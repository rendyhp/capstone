<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AkhirTerpakaiSeharusnya;
use App\Models\Bahan;
use App\Models\BahanAkhir;
use App\Models\BahanAwal;
use App\Models\BahanKeluar;
use App\Models\BahanMasuk;
use App\Models\BarangMasuk;
use App\Models\HistoryInput;

use App\Models\SatuanBahan;
use App\Models\TransaksiDetail;
use Carbon\Carbon;
use Hashids\Hashids;
use Illuminate\Http\Request;


use App\Models\TemporaryFile;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Redirect;

use App\Helpers\LogActivity;

class BahanController extends Controller
{
    public function index(Request $request)
    {

        $user = Auth::user();
        $role = $user->role;

        $date = $request->input('date', Carbon::today()->toDateString());

        $query = Bahan::with('satuan')->orderBy('name')->whereNull('deleted_at');

        if ($search = $request->input('search')) {
            $query->where('name', 'like', '%' . $search . '%');
        }

        $bahans = $query->paginate(20)->appends($request->query());

        foreach ($bahans as $bahan) {
            $bahan->jumlah_awal = BahanAwal::where('bahan_id', $bahan->id)
                ->whereDate('date', $date)
                ->whereNull('deleted_at')
                ->sum('jumlah');
            $bahan->jumlah_masuk = BahanMasuk::where('bahan_id', $bahan->id)
                ->whereDate('date', $date)
                ->whereNull('deleted_at')
                ->sum('jumlah');
            $bahan->jumlah_keluar = BahanKeluar::where('bahan_id', $bahan->id)
                ->whereDate('date', $date)
                ->whereNull('deleted_at')
                ->sum('jumlah');
            $bahan->jumlah_terpakai = DB::table('transaksi_details')
                ->join('transaksis', 'transaksi_details.transaksi_id', '=', 'transaksis.id')
                ->where('transaksi_details.bahan_id', $bahan->id)
                ->whereDate('transaksis.date', $date)
                ->whereNull('transaksis.deleted_at')
                ->sum('transaksi_details.jumlah');
            $bahan->jumlah_akhir = ($bahan->jumlah_awal + $bahan->jumlah_masuk - $bahan->jumlah_keluar) - $bahan->jumlah_terpakai;
            $bahan->bahan_akhir = BahanAkhir::where('bahan_id', $bahan->id)
                ->whereDate('date', $date)
                ->whereNull('deleted_at')
                ->sum('jumlah');
            $bahan->bahan_terbuang = ($bahan->jumlah_akhir - $bahan->bahan_akhir);
        }
        if ($role === 'OWNER' || $role === 'MANAJER' || $role === 'STAF') {
            return view('bahan.index', [

                'bahans' => $bahans,
                'satuan_bahans' => SatuanBahan::whereNull('deleted_at')->orderBy('name')->get(),
                'date' => $date,
            ]);
        } else {
            return abort(403, 'Anda tidak memiliki izin untuk mengakses halaman ini.');
        }
    }

    public function indexMasukKeluar(Request $request)
    {
        $user = Auth::user();
        $role = $user->role;

        // Data barang masuk
        $bahanMasuks = BahanMasuk::with(['bahan', 'user'])
            ->whereNull('deleted_at')
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'date' => $item->date,
                    'bahan_id' => $item->bahan_id,
                    'user' => $item->user->name ?? 'Unknown',
                    'name' => $item->bahan->name ?? '-',
                    'tipe' => 'MASUK',
                    'jumlah' => $item->jumlah,
                    'satuan' => $item->bahan->satuan->name ?? '-',
                    'created_at' => $item->created_at,
                ];
            });

        // Data barang keluar
        $bahanKeluars = BahanKeluar::with(['bahan', 'user'])
            ->whereNull('deleted_at')
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'date' => $item->date,
                    'bahan_id' => $item->bahan_id,
                    'user' => $item->user->name ?? 'Unknown',
                    'name' => $item->bahan->name ?? '-',
                    'tipe' => 'KELUAR',
                    'jumlah' => $item->jumlah,
                    'satuan' => $item->bahan->satuan->name ?? '-',
                    'created_at' => $item->created_at,
                ];
            });


        $merged = $bahanMasuks->merge($bahanKeluars)->sortByDesc('created_at')->values();

        if ($search = $request->input('search')) {
            $merged = $merged->filter(function ($item) use ($search) {
                return stripos($item['name'], $search) !== false;
            })->values();
        }

        $page = $request->input('page', 1);
        $perPage = 20;
        $offset = ($page - 1) * $perPage;

        $transaksis = new LengthAwarePaginator(
            $merged->slice($offset, $perPage),
            $merged->count(),
            $perPage,
            $page,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        if (in_array($role, ['OWNER', 'MANAJER', 'STAF'])) {
            return view('bahan.indexBahanMasukKeluar', compact('transaksis'));
        } else {
            return abort(403, 'Anda tidak memiliki izin untuk mengakses halaman ini.');
        }
    }

    public function indexBahanMKbyID(Request $request, $encryptedId)
    {
        $hashids = new Hashids(env('HASHIDS_SALT', 'cafebdim_Salty'), 32);
        $id = $hashids->decode($encryptedId);
        if (empty($id)) {
            abort(404, 'ID tidak valid');
        }

        $user = Auth::user();
        $role = $user->role;

        $bahans = Bahan::whereNull('deleted_at')->find($id[0]);

        $bahanMasuks = BahanMasuk::with(['bahan', 'user'])
            ->whereNull('deleted_at')->whereNull('deleted_at')->where('bahan_id', $id[0])
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'date' => $item->date,
                    'user' => $item->user->name ?? 'Unknown',
                    'name' => $item->bahan->name ?? '-',
                    'keterangan' => $item->keterangan ?? '-',
                    'tipe' => 'MASUK',
                    'jumlah' => $item->jumlah,
                    'satuan' => $item->bahan->satuan->name ?? '-',
                    'created_at' => $item->created_at,
                ];
            });

        $bahanKeluars = BahanKeluar::with(['bahan', 'user'])
            ->whereNull('deleted_at')->whereNull('deleted_at')->where('bahan_id', $id[0])
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'date' => $item->date,
                    'user' => $item->user->name ?? 'Unknown',
                    'name' => $item->bahan->name ?? '-',
                    'keterangan' => $item->keterangan ?? '-',
                    'tipe' => 'KELUAR',
                    'jumlah' => $item->jumlah,
                    'satuan' => $item->bahan->satuan->name ?? '-',
                    'created_at' => $item->created_at,
                ];
            });

        // Gabungkan dan urutkan semua transaksi
        $merged = $bahanMasuks->merge($bahanKeluars)->sortByDesc('created_at')->values();

        // Paginate secara manual
        $page = $request->input('page', 1);
        $perPage = 20;
        $offset = ($page - 1) * $perPage;

        $transaksis = new LengthAwarePaginator(
            $merged->slice($offset, $perPage),
            $merged->count(),
            $perPage,
            $page,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        if (in_array($role, ['OWNER', 'MANAJER', 'STAF'])) {
            return view('bahan.indexBahanMKbyID', compact('transaksis', 'bahans'));
        } else {
            return abort(403, 'Anda tidak memiliki izin untuk mengakses halaman ini.');
        }
    }

    public function indexBahanAwal(Request $request)
    {
        $user = Auth::user();
        $role = $user->role;

        if ($role !== 'OWNER') {
            return abort(403, 'Anda tidak memiliki izin untuk mengakses halaman ini.');
        }

        $date = $request->input('date', Carbon::today()->toDateString());
        $search = $request->input('search');

        // Query join BahanAwal -> Bahan -> Satuan
        $query = BahanAwal::selectRaw('
            bahan_awals.bahan_id,
            SUM(bahan_awals.jumlah) as stok,
            MAX(bahan_awals.date) as date,
            bahans.name as bahan_name,
            satuan_bahans.name as satuan_name
        ')
            ->join('bahans', 'bahan_awals.bahan_id', '=', 'bahans.id')
            ->join('satuan_bahans', 'bahans.satuan_id', '=', 'satuan_bahans.id')
            ->whereNull('bahan_awals.deleted_at')
            ->whereNull('bahans.deleted_at')
            ->whereDate('bahan_awals.date', $date)
            ->when($search, function ($q) use ($search) {
                $q->where('bahans.name', 'like', '%' . $search . '%');
            })
            ->groupBy('bahan_awals.bahan_id', 'bahans.name', 'satuan_bahans.name')
            ->orderBy('bahans.name', 'asc');

        $allData = $query->get();

        // Ambil data terbaru untuk tiap bahan_id
        $grouped = $allData->groupBy('bahan_id')->map(function ($items) {
            return $items->first();
        })->values();

        // Pagination manual
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $perPage = 20;
        $currentItems = $grouped->slice(($currentPage - 1) * $perPage, $perPage)->values();
        $bahanAwalAwals = new LengthAwarePaginator($currentItems, $grouped->count(), $perPage);
        $bahanAwalAwals->appends($request->query());


        $satuans = SatuanBahan::whereNull('deleted_at')->orderBy('name', 'asc')->get();
        $bahans = Bahan::whereNull('deleted_at')->with('satuan')->orderBy('name', 'asc')->get();

        return view('bahan.indexBahanAwal', [
            'bahanAwalAwals' => $bahanAwalAwals,
            'satuans' => $satuans,
            'bahans' => $bahans,
            'date' => $date,
        ]);
    }
    public function indexDataBahan(Request $request)
    {
        $user = Auth::user();
        $role = $user->role;

        $orderBy = $request->input('orderBy', 'name');
        $direction = $request->input('direction', 'asc');

        $query = Bahan::with('satuan')
            ->whereNull('deleted_at');
        $query->orderBy($orderBy, $direction);

        $satuans = SatuanBahan::orderBy('name', 'asc')->whereNull('deleted_at')->get();

        if ($search = $request->input('search')) {
            $query->where('name', 'like', '%' . $search . '%');
        }

        if ($role === 'OWNER' || $role === 'MANAJER' || $role === 'STAF') {
            $bahans = $query->paginate(20);

            return view('bahan.indexDataBahan', [
                'bahans' => $bahans,
                'satuans' => $satuans
            ]);
        } else {
            return abort(403, 'Anda tidak memiliki izin untuk mengakses halaman ini.');
        }
    }


    public function indexSatuan(Request $request)
    {
        $user = Auth::user();
        $role = $user->role;

        $allowedSortColumns = ['id', 'name', 'jumlah', 'created_at'];
        $allowedSortDirections = ['asc', 'desc'];

        $orderBy = in_array($request->input('orderBy'), $allowedSortColumns) ? $request->input('orderBy') : 'name';
        $sort = in_array($request->input('sort'), $allowedSortDirections) ? $request->input('sort') : 'asc';

        $query = SatuanBahan::whereNull('deleted_at')
            ->orderBy($orderBy, $sort);

        if ($search = $request->input('search')) {
            $query->where('satuan_bahans.name', 'like', '%' . $search . '%');
        }

        $satuans = $query->paginate(20)->appends($request->query());

        if ($role === 'OWNER') {
            return view('bahan.indexSatuan', compact('satuans'));
        } elseif ($role === 'MANAJER') {
            return view('bahan.indexSatuan', compact('satuans'));
        } elseif ($role === 'STAF') {
            return view('bahan.indexSatuan', compact('satuans'));
        } else {
            return abort(403, 'Anda tidak memiliki izin untuk mengakses halaman ini.');
        }
    }




    public function inputStore(Request $request)
    {
        $validated = $request->validate([
            'bahan_id' => 'required|string',
            'date' => 'required|date',
            'jumlah' => 'required|numeric|min:0',
        ]);

        try {

            $hashids = new Hashids(env('HASHIDS_SALT', 'cafebdim_Salty'), 32);
            $decryptedBahanId = $hashids->decode($validated['bahan_id']);

            if (empty($decryptedBahanId)) {
                return redirect()->back()->with('error', 'ID bahan tidak valid.');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan dalam dekripsi ID.');
        }

        $bahan = Bahan::find($decryptedBahanId[0]);

        if (!$bahan) {
            return redirect()->back()->with('error', 'Bahan tidak ditemukan.');
        }

        BahanMasuk::create([
            'user_id' => Auth::id(),
            'bahan_id' => $decryptedBahanId[0],
            'date' => $validated['date'],
            'jumlah' => $validated['jumlah'],
        ]);

        return redirect()->back()->with('success', 'Input stok ' . $bahan->name . ' pada "' . $validated['date'] . '" berhasil ditambahkan.');
    }

    public function storeM(Request $request)
    {
        $validated = $request->validate([
            'id' => 'required',
            'date' => 'required|date',
            'keterangan' => 'nullable',
            'jumlah' => 'required|numeric|min:0',

        ]);

        BahanMasuk::create([
            'bahan_id' => $validated['id'],
            'keterangan' => $validated['keterangan'],
            'jumlah' => $validated['jumlah'],
            'user_id' => Auth::id(),
            'date' => $validated['date'],
        ]);

        return redirect()->back()->with('success', 'Stok berhasil ditambahkan.');
    }

    public function storeK(Request $request)
    {
        $validated = $request->validate([
            'id' => 'required',
            'keterangan' => 'nullable',
            'jumlah' => 'required|numeric|min:0',
            'date' => 'required|date',
        ]);

        BahanKeluar::create([
            'bahan_id' => $validated['id'],
            'keterangan' => $validated['keterangan'],
            'jumlah' => $validated['jumlah'],
            'user_id' => Auth::id(),
            'date' => $validated['date'],
        ]);

        return redirect()->back()->with('success', 'Stok berhasil dikurangi.');
    }

    public function storeBahanAwal(Request $request)
    {
        $user = Auth::user();

        // Validate input fields
        $request->validate([
            'date' => 'required|date',

        ]);
        // Process each item in bahan_awal
        foreach ($request->bahan_awal as $item) {
            BahanAwal::create([
                'user_id' => $user->id,
                'date' => $request->date,
                'bahan_id' => $item['bahan_id'],
                'jumlah' => $item['jumlah'],
            ]);
        }

        return redirect()->route('bahan.indexBahanAwal', ['date' => $request->date])
            ->with('success', 'Bahan awal berhasil disimpan.');
    }

    public function storeSatuan(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:30',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user = Auth::user()->id;

        $existing = SatuanBahan::whereRaw('LOWER(name) = ?', [strtolower($request->input('name'))])->first();

        $dataPerPage = 20;
        $data = DB::table('satuan_bahans')->paginate($dataPerPage);
        $lastPage = $data->lastPage();

        if ($existing) {
            return redirect('/bahan/satuan?page=' . $lastPage . '&order=id&sort=asc')
                ->with('error', 'Satuan "' . $request->input('name') . '" sudah ada');
        }

        $Satuan = new SatuanBahan();
        $Satuan->user_id = $user;
        $Satuan->name = $request->input('name');
        $Satuan->save();

        // LogActivity::addToLog('Create Satuan "' . $Satuan->name . '"');

        return redirect('/bahan/satuan?page=' . $lastPage . '&order=id&sort=asc')
            ->with('success', 'Satuan "' . $Satuan->name . '" Berhasil Ditambahkan');
    }


    public function inputUpdate(Request $request)
    {
        $validated = $request->validate([
            'id' => 'required|exists:history_inputs,id',
            'date' => 'required|date',
            'jumlah' => 'required|numeric|min:0',
        ]);

        try {

            $hashids = new Hashids(env('HASHIDS_SALT', 'cafebdim_Salty'), 32);
            $decryptedBahanId = $hashids->decode($validated['bahan_id']);

            if (empty($decryptedBahanId)) {
                return redirect()->back()->with('error', 'ID bahan tidak valid.');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan dalam dekripsi ID.');
        }

        $bahan = Bahan::find($decryptedBahanId[0]);

        if (!$bahan) {
            return redirect()->back()->with('error', 'Bahan tidak ditemukan.');
        }

        try {
            $historyInput = HistoryInput::findOrFail($validated['id']);
            $historyInput->update([
                'date' => $validated['date'],
                'jumlah' => $validated['jumlah'],
            ]);

            return redirect()->back()->with('success', 'Input stok ' . $bahan->name . ' pada "' . $validated['date'] . '" berhasil diupdate.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal mengupdate data stok: ' . $e->getMessage());
        }
    }

    public function updateBahanAwal($bahan_id, Request $request)
    {
        $request->validate([
            'jumlah.*' => 'required|numeric|min:0.001',
            'date' => 'required|date',
        ]);

        $jumlahs = $request->input('jumlah');
        $date = $request->input('date');

        DB::transaction(function () use ($jumlahs, $bahan_id, $date) {
            // Jika semua jumlah bahan dihapus (jumlahnya kosong)
            if (empty($jumlahs) || $this->allItemsAreEmpty($jumlahs)) {
                // Hapus semua entri untuk bahan_id dan tanggal yang diberikan
                BahanAwal::where('bahan_id', $bahan_id)
                    ->whereDate('date', $date)
                    ->delete();
            } else {
                // Jika ada jumlah yang diinputkan, lakukan update/insert
                // Hapus semua entri yang ada untuk bahan_id dan tanggal yang diberikan
                BahanAwal::where('bahan_id', $bahan_id)
                    ->whereDate('date', $date)
                    ->delete();

                // Insert entri baru untuk jumlah yang diberikan
                foreach ($jumlahs as $jumlah) {
                    BahanAwal::create([
                        'bahan_id' => $bahan_id,
                        'jumlah' => $jumlah,
                        'date' => $date,
                    ]);
                }
            }
        });

        return redirect()->back()->with('success', 'Data bahan awal berhasil diperbarui.');
    }

    public function updateSatuan(Request $request, SatuanBahan $satuans)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $user = Auth::user()->id;

        $Satuan = SatuanBahan::findOrFail($request->input('id'));
        $Satuan->user_id = $user;
        $Satuan->name = $request->input('name');
        $Satuan->save();

        return redirect('/bahan/satuan')->with('success', 'Data "' . $Satuan->name . '" Berhasil Diubah');
    }

    public function inputDelete($encryptedId)
    {
        $hashids = new Hashids(env('HASHIDS_SALT', 'cafebdim_Salty'), 32);

        $decoded = $hashids->decode($encryptedId);
        if (empty($decoded)) {
            return redirect()->back()->with('error', 'ID tidak valid.');
        }

        $id = $decoded[0];

        $historyInput = HistoryInput::with('bahan')->findOrFail($id);
        $tanggalDelete = $historyInput->date;
        $historyInput->deleted_at = now();
        $historyInput->save();

        $encryptedBahanId = $hashids->encode($historyInput->bahan_id);
        $jumlahFormatted = rtrim(rtrim(number_format($historyInput->jumlah, 3, ',', '.'), '0'), ',');

        return redirect()->route('stok-bahan.historyBahan', ['encryptedId' => $encryptedBahanId])
            ->with('success', 'Data input ' . $historyInput->bahan->name . ' pada "' . $tanggalDelete . '" sebesar ' . $jumlahFormatted . ' berhasil dihapus.');
    }

    public function create()
    {

        return view('bahan');
    }

    public function storeDataBahan(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'minimum' => 'required|integer',
            'satuan_id' => 'required',
            'image' => 'nullable|mimes:jpeg,jpg,png,webp|max:3072',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Cek apakah nama bahan (case insensitive) sudah ada
        $existing = Bahan::whereRaw('LOWER(name) = ?', [strtolower($request->input('name'))])->first();
        if ($existing) {
            $dataPerPage = 20;
            $data = DB::table('bahans')->paginate($dataPerPage);
            $lastPage = $data->lastPage();

            return redirect('/bahan/data-bahan?page=' . $lastPage . '&orderBy=id&sort=asc')
                ->with('error', 'Bahan "' . $request->input('name') . '" sudah ada.');
        }

        $user = Auth::user()->id;
        $Bahan = new Bahan;
        $Bahan->user_id = $user;
        $Bahan->name = $request->input('name');
        $Bahan->description = $request->input('description', '-');
        $Bahan->minimum = $request->input('minimum', 0);
        $Bahan->satuan_id = $request->input('satuan_id', null);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            $path = 'upload/bahan/';
            $file->move($path, $filename);
            $Bahan->image = $path . $filename;
        }

        $Bahan->save();

        $dataPerPage = 20;
        $data = DB::table('bahans')->paginate($dataPerPage);
        $lastPage = $data->lastPage();

        return redirect('/bahan/data-bahan?page=' . $lastPage . '&orderBy=id&sort=asc')
            ->with('success', 'Data "' . $Bahan->name . '" Berhasil Ditambahkan');
    }




    public function show($slug)
    {

    }

    public function edit(Bahan $bahan)
    {
        $Bahan = Bahan::findOrFail($bahan->id);
        return view('bahan.index', compact('Bahan'));
    }

    public function updateDataBahan(Request $request, Bahan $bahans)
    {
        Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'minimum' => 'required|integer|max:20',
            'satuan_id' => 'required',
        ]);

        try {
            $user = Auth::user()->id;

            $Bahan = Bahan::findOrFail($request->input('id'));

            $Bahan->user_id = $user;
            $Bahan->name = $request->input('name');
            $Bahan->description = $request->input('description' ?: '-');
            $Bahan->minimum = $request->input('minimum' ?: 0);
            $Bahan->satuan_id = $request->input('satuan_id' ?: '-');
            $Bahan->save();

            return redirect('/bahan/data-bahan')->with('success', 'Data Berhasil Diubah');
        } catch (\Illuminate\Database\QueryException $e) {
            // Check for unique constraint violation
            if ($e->errorInfo[1] == 1062) {
                echo '<script>alert("Bahan sudah ada dalam database.");</script>';
                return redirect('data-bahan')->with('error', 'Bahan Gagal Ditambahkan : Nama Bahan yang diinputkan sudah ada');
            } else {
                throw $e; // Rethrow the exception if it's not due to unique constraint
            }
        }
    }

    public function delete(Request $request)
    {
        $id = $request->id;
        $barang = Bahan::findOrFail($id);

        $barang->deleted_at = now();
        $barang->save();

        return redirect('/data-bahan')->with('success', 'Data Berhasil Dihapus');
    }

    public function deleteBahanAwal(Request $request)
    {
        $bahan_id = $request->input('bahan_id');
        $date = $request->input('date', Carbon::today()->toDateString());

        BahanAwal::where('bahan_id', $bahan_id)
            ->whereDate('date', $date)
            ->update(['deleted_at' => now()]);

        return redirect()->route('bahan.indexBahanAwal', ['date' => $date])
            ->with('success', 'Data bahan berhasil dihapus.');
    }

    public function deletePermanent(Request $request)
    {
        $slug = $request->slug;

        $bahans = Bahans::where('slug', $slug)->firstOrFail();
        $name = $bahans->title;
        // Lakukan penghapusan permanen menggunakan Eloquent
        Bahan::where('slug', $slug)->forceDelete();
        // Panggil fungsi logAdd()
        LogActivity::addToLog('Delete Permanen Bahan "' . $name . '"');

        // Redirect kembali ke halaman sebelumnya
        return Redirect::back()->with('delete', 'Dataset "' . $name . '" berhasil dihapus permanen');
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bahan;
use App\Models\BahanAkhir;
use App\Models\BahanAwal;
use App\Models\BahanMasuk;
use App\Models\Barang;
use App\Models\HistoryInput;
use App\Models\SatuanBahan;
use App\Models\User;
use App\Services\StockAlertService;
use App\Services\StockDataService;
use Carbon\Carbon;
use Hashids\Hashids;
use Http;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;

use App\Helpers\LogActivity;

class BahanController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $role = $user->role;
        $date = $request->input('date', Carbon::today()->toDateString());
        session(['previous_bahanmk_url' => url()->full()]);

        // Ambil settings dari user
        $settings = json_decode($user->setting->settings ?? '[]', true);

        $paginationBar = $settings['pagination_bahanBar'] ?? 20;
        $paginationKitchen = $settings['pagination_bahanKitchen'] ?? 20;

        // Validasi pagination supaya aman
        $allowedPagination = [5, 20, 50, 100];
        if (!in_array($paginationBar, $allowedPagination)) {
            $paginationBar = 20;
        }
        // Data Bar
        $query1 = Bahan::with('satuan')->orderBy('name')->whereNull('deleted_at')->where('section', 'BAR');

        if ($search1 = $request->input('search1')) {
            $query1->where('name', 'like', '%' . $search1 . '%');
        }

        $bahan_bars = $query1->paginate($paginationBar)->appends($request->query());

        foreach ($bahan_bars as $bahan) {
            $bahan_awal = BahanAwal::where('bahan_id', $bahan->id)
                ->whereDate('date', $date)
                ->whereNull('deleted_at')
                ->first();

            if ($bahan_awal) {
                $bahan->jumlah_awal = $bahan_awal->jumlah;
                $bahan->awal_manual = true;
            } else {
                $bahan->jumlah_awal = BahanAkhir::where('bahan_id', $bahan->id)
                    ->where('date', '<', $date)
                    ->whereNull('deleted_at')
                    ->orderByDesc('date')
                    ->value('jumlah') ?? 0;

                $bahan->awal_manual = false;
            }

            $bahan->jumlah_masuk = BahanMasuk::where('bahan_id', $bahan->id)
                ->whereDate('date', $date)
                ->whereNull('deleted_at')
                ->sum('jumlah');

            $bahan->jumlah_terpakai = DB::table('transaksi_details')
                ->join('transaksis', 'transaksi_details.transaksi_id', '=', 'transaksis.id')
                ->where('transaksi_details.bahan_id', $bahan->id)
                ->whereDate('transaksis.date', $date)
                ->whereNull('transaksis.deleted_at')
                ->sum('transaksi_details.jumlah');

            $bahan->jumlah_akhir = ($bahan->jumlah_awal + $bahan->jumlah_masuk) - $bahan->jumlah_terpakai;

            $bahan_akhir = BahanAkhir::where('bahan_id', $bahan->id)
                ->whereDate('date', $date)
                ->whereNull('deleted_at')
                ->first();

            if ($bahan_akhir) {
                $bahan->bahan_akhir = $bahan_akhir->jumlah;
                $bahan->akhir_manual = true;
            } else {
                $bahan->bahan_akhir = null;
                $bahan->akhir_manual = false;
            }

            $bahan->bahan_terbuang = $bahan->bahan_akhir !== null
                ? ($bahan->jumlah_akhir - $bahan->bahan_akhir)
                : null;
        }

        if ($request->ajax()) {
            return response()->json($bahan_bars);
        }


        // Data Kitchen
        // Validasi pagination supaya aman
        $allowedPagination = [5, 20, 50, 100];
        if (!in_array($paginationKitchen, $allowedPagination)) {
            $paginationKitchen = 20;
        }

        $query2 = Bahan::with('satuan')->orderBy('name')->whereNull('deleted_at')->where('section', 'KITCHEN');

        if ($search2 = $request->input('search2')) {
            $query2->where('name', 'like', '%' . $search2 . '%');
        }

        $bahan_kitchens = $query2->paginate($paginationKitchen)->appends($request->query());

        foreach ($bahan_kitchens as $bahan) {
            $bahan_awal = BahanAwal::where('bahan_id', $bahan->id)
                ->whereDate('date', $date)
                ->whereNull('deleted_at')
                ->first();

            if ($bahan_awal) {
                $bahan->jumlah_awal = $bahan_awal->jumlah;
                $bahan->awal_manual = true;
            } else {
                $bahan->jumlah_awal = BahanAkhir::where('bahan_id', $bahan->id)
                    ->where('date', '<', $date)
                    ->whereNull('deleted_at')
                    ->orderByDesc('date')
                    ->value('jumlah') ?? 0;

                $bahan->awal_manual = false;
            }

            $bahan->jumlah_masuk = BahanMasuk::where('bahan_id', $bahan->id)
                ->whereDate('date', $date)
                ->whereNull('deleted_at')
                ->sum('jumlah');

            $bahan->jumlah_terpakai = DB::table('transaksi_details')
                ->join('transaksis', 'transaksi_details.transaksi_id', '=', 'transaksis.id')
                ->where('transaksi_details.bahan_id', $bahan->id)
                ->whereDate('transaksis.date', $date)
                ->whereNull('transaksis.deleted_at')
                ->sum('transaksi_details.jumlah');

            $bahan->jumlah_akhir = ($bahan->jumlah_awal + $bahan->jumlah_masuk) - $bahan->jumlah_terpakai;

            $bahan_akhir = BahanAkhir::where('bahan_id', $bahan->id)
                ->whereDate('date', $date)
                ->whereNull('deleted_at')
                ->first();

            if ($bahan_akhir) {
                $bahan->bahan_akhir = $bahan_akhir->jumlah;
                $bahan->akhir_manual = true;
            } else {
                $bahan->bahan_akhir = null;
                $bahan->akhir_manual = false;
            }

            $bahan->bahan_terbuang = $bahan->bahan_akhir !== null
                ? ($bahan->jumlah_akhir - $bahan->bahan_akhir)
                : null;
        }

        if ($request->ajax()) {
            return response()->json($bahan_kitchens);
        }

        if (in_array($role, ['OWNER', 'MANAJER', 'STAF'])) {
            return view('bahan.index', [
                'bahan_bars' => $bahan_bars,
                'bahan_kitchens' => $bahan_kitchens,
                'satuan_bahans' => SatuanBahan::whereNull('deleted_at')->orderBy('name')->get(),
                'date' => $date,
                'settings' => $settings,
            ]);
        } else {
            return abort(403, 'Anda tidak memiliki izin untuk mengakses halaman ini.');
        }
    }

    public function indexById(Request $request, $encryptedId)
    {
        $hashids = new Hashids(env('HASHIDS_SALT', 'cafebdim_Salty'), 32);
        $decoded = $hashids->decode($encryptedId);

        if (empty($decoded)) {
            abort(404, 'ID tidak valid');
        }

        $bahanId = $decoded[0];
        $bahan = Bahan::with('satuan')->where('id', $bahanId)->whereNull('deleted_at')->firstOrFail();
        $previousUrl = session('previous_bahanmk_url', route('bahan.index'));

        $user = Auth::user();
        $role = $user->role;

        $dateParam = $request->input('date');

        if ($dateParam) {
            // Jika ada, parsing tanggalnya
            $date = Carbon::parse($dateParam);
            $month = $date->month;
            $year = $date->year;
        } else {
            // Default sekarang
            $month = $request->input('month') ?? now()->month;
            $year = $request->input('year') ?? now()->year;
        }

        $daysInMonth = Carbon::create($year, $month, 1)->daysInMonth;

        $stokAwalData = BahanAwal::where('bahan_id', $bahanId)
            ->whereMonth('date', $month)
            ->whereYear('date', $year)
            ->whereNull('deleted_at')
            ->pluck('jumlah', 'date');

        $masukData = BahanMasuk::where('bahan_id', $bahanId)
            ->whereMonth('date', $month)
            ->whereYear('date', $year)
            ->whereNull('deleted_at')
            ->pluck('jumlah', 'date');

        $akhirData = BahanAkhir::where('bahan_id', $bahanId)
            ->whereMonth('date', $month)
            ->whereYear('date', $year)
            ->whereNull('deleted_at')
            ->pluck('jumlah', 'date');

        $history = [];
        $prevAkhir = null;

        for ($day = 1; $day <= $daysInMonth; $day++) {
            $dateString = Carbon::createFromDate($year, $month, $day)->toDateString();

            $awal = $stokAwalData[$dateString] ?? $prevAkhir;
            $masuk = $masukData[$dateString] ?? 0;
            $akhir = $akhirData[$dateString] ?? null;

            // Hitung terpakai dari transaksi_details join transaksis di tanggal ini
            $terpakai = DB::table('transaksi_details')
                ->join('transaksis', 'transaksi_details.transaksi_id', '=', 'transaksis.id')
                ->where('transaksi_details.bahan_id', $bahanId)
                ->whereDate('transaksis.date', $dateString)
                ->whereNull('transaksis.deleted_at')
                ->sum('transaksi_details.jumlah');

            // Terbuang = (awal + masuk - terpakai) - akhir
            // Sama dengan: jumlah_akhir - bahan_akhir
            $jumlah_akhir = (!is_null($awal) && !is_null($masuk) && !is_null($terpakai)) ? ($awal + $masuk - $terpakai) : null;

            $terbuang = (!is_null($jumlah_akhir) && !is_null($akhir)) ? ($jumlah_akhir - $akhir) : null;

            $history[] = [
                'tanggal' => $day,
                'awal' => $awal,
                'masuk' => $masuk,
                'sisa' => (!is_null($awal) && !is_null($masuk) && !is_null($terpakai)) ? ($awal + $masuk - $terpakai) : null,
                'akhir' => $akhir,
                'terpakai' => $terpakai,
                'terbuang' => $terbuang,
            ];

            $prevAkhir = $akhir ?? $prevAkhir;
        }


        return view('bahan.indexById', compact('bahan', 'history', 'month', 'year', 'dateParam', 'bahanId', 'previousUrl'));
    }





    public function saveBahanAwal(Request $request)
    {
        $date = $request->input('date');
        if (date('j', strtotime($date)) != 1) {
            return response()->json(['error2' => true]);
        }

        $request->validate([
            'bahan_id' => 'required|integer|exists:bahans,id',
            'date' => 'required|date',
            'jumlah' => 'required|numeric|min:0',
        ]);

        BahanAwal::where('bahan_id', $request->bahan_id)
            ->whereDate('date', $request->date)
            ->delete();

        BahanAwal::create([
            'user_id' => Auth::id(),
            'bahan_id' => $request->bahan_id,
            'date' => $request->date,
            'jumlah' => $request->jumlah,
        ]);

        $stockService = new StockDataService();
        $bahan = $stockService->getSingleBahan($request->bahan_id, $request->date);

        $alertService = new StockAlertService();
        $alertService->checkAndNotify(null, $bahan);

        return response()->json(['success' => true]);
    }

    public function saveBahanAkhir(Request $request)
    {
        $request->validate([
            'bahan_id' => 'required|integer|exists:bahans,id',
            'date' => 'required|date',
            'jumlah' => 'required|numeric|min:0',
        ]);

        BahanAkhir::where('bahan_id', $request->bahan_id)
            ->whereDate('date', $request->date)
            ->delete();

        BahanAkhir::create([
            'user_id' => Auth::id(),
            'bahan_id' => $request->bahan_id,
            'date' => $request->date,
            'jumlah' => $request->jumlah,
        ]);

        $stockService = new StockDataService();
        $bahan = $stockService->getSingleBahan($request->bahan_id, $request->date);

        $alertService = new StockAlertService();
        $alertService->checkAndNotify(null, $bahan);

        return response()->json(['success' => true]);
    }

    public function deleteBahanAwal(Request $request)
    {
        $request->validate([
            'bahan_id' => 'required|integer',
            'date' => 'required|date',
        ]);

        $deleted = BahanAwal::where('bahan_id', $request->bahan_id)
            ->whereDate('date', $request->date)
            ->delete();

        return response()->json([
            'success' => $deleted > 0
        ]);
    }

    public function deleteBahanAkhir(Request $request)
    {
        $request->validate([
            'bahan_id' => 'required|integer',
            'date' => 'required|date',
        ]);

        $deleted = BahanAkhir::where('bahan_id', $request->bahan_id)
            ->whereDate('date', $request->date)
            ->delete();

        return response()->json([
            'success' => $deleted > 0
        ]);
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
        $previousUrl = session('previous_bahanmk_url', route('bahan.index'));

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

        // Gabungkan dan urutkan semua transaksi
        $merged = $bahanMasuks->sortByDesc('created_at')->values();

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
            return view('bahan.indexBahanMKbyID', compact('transaksis', 'bahans', 'previousUrl'));
        } else {
            return abort(403, 'Anda tidak memiliki izin untuk mengakses halaman ini.');
        }
    }

    public function indexDataBahan(Request $request)
    {
        $user = Auth::user();
        $role = $user->role;

        $orderBy = $request->input('orderBy', 'name');
        $direction = $request->input('direction', 'asc');

        // Ambil settings dari user
        // Ambil settings dari user
        $settings = json_decode($user->setting->settings ?? '[]', true);

        $showImage = $settings['show_image_bahan2'] ?? false;
        $paginationBar2 = $settings['pagination_bahanBar2'] ?? 20;
        $paginationKitchen2 = $settings['pagination_bahanKitchen2'] ?? 20;

        $query1 = Bahan::with('satuan')
            ->whereNull('deleted_at')->where('section', 'BAR');
        $query1->orderBy($orderBy, $direction);

        $satuans = SatuanBahan::orderBy('name', 'asc')->whereNull('deleted_at')->get();

        if ($search1 = $request->input('search1')) {
            $query1->where('name', 'like', '%' . $search1 . '%');
        }

        $query2 = Bahan::with('satuan')
            ->whereNull('deleted_at')->where('section', 'KITCHEN');
        $query2->orderBy($orderBy, $direction);

        $satuans = SatuanBahan::orderBy('name', 'asc')->whereNull('deleted_at')->get();

        if ($search2 = $request->input('search2')) {
            $query2->where('name', 'like', '%' . $search2 . '%');
        }

        if ($role === 'OWNER' || $role === 'MANAJER' || $role === 'STAF') {
            $bahan_bars = $query1->paginate($paginationBar2);
            $bahan_kitchens = $query2->paginate($paginationKitchen2);

            return view('bahan.indexDataBahan', [
                'bahan_bars' => $bahan_bars,
                'bahan_kitchens' => $bahan_kitchens,
                'satuans' => $satuans,
                'settings' => $settings
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

        return redirect()->back()->with('success', 'Data "' . $Satuan->name . '" Berhasil Diubah');
    }


    public function storeDataBahan(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'minimum' => 'required|integer',
            'satuan_id' => 'required',
            'section' => 'required',
            'image' => 'nullable|mimes:jpeg,jpg,png,webp|max:3072',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $settings = json_decode($user->setting->settings ?? '[]', true);

        $showImage = $settings['show_image_bahan2'] ?? false;
        $paginationBar2 = $settings['pagination_bahanBar2'] ?? 20;
        $paginationKitchen2 = $settings['pagination_bahanKitchen2'] ?? 20;

        // Cek apakah nama bahan (case insensitive) sudah ada
        $existing = Bahan::whereNull('deleted_at')->whereRaw('LOWER(name) = ?', [strtolower($request->input('name'))])->first();
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
        $Bahan->section = $request->input('section');

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

    public function updateDataBahan(Request $request, Bahan $bahans)
    {
        Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'minimum' => 'required|integer|max:20',
            'satuan_id' => 'required',
            'image' => 'nullable|mimes:jpeg,jpg,png,webp|max:3072',
            'section' => 'required',
        ]);

        $user = Auth::user()->id;

        $Bahan = Bahan::findOrFail($request->input('id'));

        $Bahan->user_id = $user;
        $Bahan->name = $request->input('name');
        $Bahan->description = $request->input('description' ?: '-');
        $Bahan->minimum = $request->input('minimum' ?: 0);
        $Bahan->satuan_id = $request->input('satuan_id' ?: '-');
        $Bahan->section = $request->input('section' ?: '-');

        // Gambar hanya diubah jika ada upload baru
        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($Bahan->image && file_exists(public_path($Bahan->image))) {
                unlink(public_path($Bahan->image));
            }

            $file = $request->file('image');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $path = 'upload/bahan/';
            $file->move(public_path($path), $filename);

            $Bahan->image = $path . $filename;
        }


        $Bahan->save();

        return redirect('/bahan/data-bahan')->with('success', 'Data Berhasil Diubah');

    }

    public function deleteImageBahan($id)
    {
        $barang = Bahan::findOrFail($id);

        if ($barang->image && file_exists(public_path($barang->image))) {
            unlink(public_path($barang->image)); // Hapus dari folder
        }

        $barang->image = null; // Kosongkan di database
        $barang->save();

        return redirect()->back()->with('success', 'Gambar berhasil dihapus.');
    }

    public function deleteBahanMKbyID(Request $request)
    {
        $id = $request->id;
        $barang = BahanMasuk::findOrFail($id);

        $barang->deleted_at = now();
        $barang->save();

        return redirect()->back()->with('success', 'Data "' . $barang->bahan->name . '" Berhasil Dihapus');
    }

    public function deleteDataBahan(Request $request)
    {
        $id = $request->id;
        $barang = Bahan::findOrFail($id);

        $barang->deleted_at = now();
        $barang->save();

        return redirect()->back()->with('success', 'Data "' . $barang->name . '" Berhasil Dihapus');
    }

    public function deleteSatuan(Request $request)
    {
        $id = $request->id;
        $barang = SatuanBahan::findOrFail($id);

        $barang->deleted_at = now();
        $barang->save();

        return redirect()->back()->with('success', 'Data "' . $barang->name . '" Berhasil Dihapus');
    }


}

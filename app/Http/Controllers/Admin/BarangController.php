<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BahanCatatan;
use App\Models\Barang;
use App\Models\BarangAwal;
use App\Models\BarangKeluar;
use App\Models\BarangMasuk;
use App\Models\SatuanBarang;
use App\Services\StockAlertService;
use App\Services\StockDataService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Hashids\Hashids;

class BarangController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $role = $user->role;
        session(['previous_barangmk_url' => url()->full()]);

        $allowedSortColumns = ['id', 'name', 'stok_awal', 'created_at'];
        $allowedSortDirections = ['asc', 'desc'];

        // Ambil settings dari user
        $settings = json_decode($user->setting->settings ?? '[]', true);

        // Default jika setting kosong
        $showImage = $settings['show_image_barang'] ?? false;
        $pagination = $settings['pagination_barang'] ?? 20;

        // Validasi pagination
        $allowedPagination = [20, 50, 100];
        if (!in_array($pagination, $allowedPagination)) {
            $pagination = 20;
        }

        $orderBy = in_array($request->input('orderBy'), $allowedSortColumns) ? $request->input('orderBy') : 'name';
        $sort = in_array($request->input('sort'), $allowedSortDirections) ? $request->input('sort') : 'asc';

        $query = Barang::with('satuanBarang')
            ->whereNull('deleted_at')
            ->orderBy($orderBy, $sort);

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                    ->orWhere('description', 'like', '%' . $search . '%');
            });
        }

        $barangs = $query->paginate($pagination)->appends($request->query());

        // Ambil semua id barang yang ditampilkan
        $barangIds = $barangs->pluck('id')->toArray();

        // Hitung Awal, Masuk, Keluar
        $barangAwals = BarangAwal::whereIn('barang_id', $barangIds)
            ->whereNull('deleted_at')
            ->select('barang_id', DB::raw('SUM(jumlah) as total_awal'))
            ->groupBy('barang_id')
            ->pluck('total_awal', 'barang_id');

        $barangMasuks = BarangMasuk::whereIn('barang_id', $barangIds)
            ->whereNull('deleted_at')
            ->select('barang_id', DB::raw('SUM(jumlah) as total_masuk'))
            ->groupBy('barang_id')
            ->pluck('total_masuk', 'barang_id');

        $barangKeluars = BarangKeluar::whereIn('barang_id', $barangIds)
            ->whereNull('deleted_at')
            ->select('barang_id', DB::raw('SUM(jumlah) as total_keluar'))
            ->groupBy('barang_id')
            ->pluck('total_keluar', 'barang_id');

        // Gabungkan data ke setiap barang
        $barangs->getCollection()->transform(function ($barang) use ($barangAwals, $barangMasuks, $barangKeluars) {
            $awal = $barangAwals[$barang->id] ?? 0;
            $masuk = $barangMasuks[$barang->id] ?? 0;
            $keluar = $barangKeluars[$barang->id] ?? 0;

            $barang->awal = $awal;
            $barang->masuk = $masuk;
            $barang->keluar = $keluar;
            $barang->total_beli = $awal + $masuk;
            $barang->sisa = $barang->total_beli - $keluar;

            return $barang;
        });

        $satuanBarangs = SatuanBarang::orderBy('name', 'asc')->whereNull('deleted_at')->get();

        if (in_array($role, ['OWNER', 'MANAJER', 'STAF'])) {
            return view('barang.index', compact('barangs', 'satuanBarangs', 'settings'));
        } else {
            return abort(403, 'Anda tidak memiliki izin untuk mengakses halaman ini.');
        }
    }

    public function indexMasukKeluar(Request $request)
    {
        $user = Auth::user();
        $role = $user->role;
        session(['previous_barangmk_url' => url()->full()]);

        // Data barang awal
        $barangAwals = BarangAwal::with(['barang', 'user'])
            ->whereNull('deleted_at')
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'date' => $item->date,
                    'barang_id' => $item->barang_id,
                    'user' => $item->user->name ?? 'Unknown',
                    'keterangan' => $item->keterangan ?? '-',
                    'name' => $item->barang->name ?? '-',
                    'tipe' => 'AWAL',
                    'jumlah' => $item->jumlah,
                    'satuan' => $item->barang->satuanBarang->name ?? '-',
                    'created_at' => $item->created_at,
                ];
            })->filter(function ($item) {
                return $item['name'] !== '-'; // hilangkan barang yang tidak valid
            })
            ->values();

        // Data barang masuk
        $barangMasuks = BarangMasuk::with(['barang', 'user'])
            ->whereNull('deleted_at')
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'date' => $item->date,
                    'barang_id' => $item->barang_id,
                    'user' => $item->user->name ?? 'Unknown',
                    'name' => $item->barang->name ?? '-',
                    'keterangan' => $item->keterangan ?? '-',
                    'tipe' => 'MASUK',
                    'jumlah' => $item->jumlah,
                    'satuan' => $item->barang->satuanBarang->name ?? '-',
                    'created_at' => $item->created_at,
                ];
            })
            ->filter(function ($item) {
                return $item['name'] !== '-';
            })
            ->values();

        // Data barang keluar
        $barangKeluars = BarangKeluar::with(['barang', 'user'])
            ->whereNull('deleted_at')
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'date' => $item->date,
                    'barang_id' => $item->barang_id,
                    'user' => $item->user->name ?? 'Unknown',
                    'name' => $item->barang->name ?? '-',
                    'keterangan' => $item->keterangan ?? '-',
                    'tipe' => 'KELUAR',
                    'jumlah' => $item->jumlah,
                    'satuan' => $item->barang->satuanBarang->name ?? '-',
                    'created_at' => $item->created_at,
                ];
            })
            ->filter(function ($item) {
                return $item['name'] !== '-';
            })
            ->values();

        $merged = collect()
            ->concat($barangMasuks)
            ->concat($barangKeluars)
            ->concat($barangAwals)
            ->sortByDesc('created_at')
            ->values();

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
            return view('barang.indexBarangMasukKeluar', compact('transaksis'));
        } else {
            return abort(403, 'Anda tidak memiliki izin untuk mengakses halaman ini.');
        }
    }

    public function indexBarangMKbyID(Request $request, $encryptedId)
    {
        $hashids = new Hashids(env('HASHIDS_SALT', 'cafebdim_Salty'), 32);
        $id = $hashids->decode($encryptedId);
        if (empty($id)) {
            abort(404, 'ID tidak valid');
        }

        $user = Auth::user();
        $role = $user->role;
        $previousUrl = session('previous_barangmk_url', route('barang.indexMasukKeluar'));

        $barangs = Barang::whereNull('deleted_at')->find($id[0]);


        // Data barang awal
        $barangAwals = BarangAwal::with(['barang', 'user'])
            ->whereNull('deleted_at')->where('barang_id', $id[0])
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'date' => $item->date,
                    'user' => $item->user->name ?? 'Unknown',
                    'keterangan' => $item->keterangan ?? '-',
                    'name' => $item->barang->name ?? '-',
                    'tipe' => 'AWAL',
                    'jumlah' => $item->jumlah,
                    'satuan' => $item->barang->satuanBarang->name ?? '-',
                    'created_at' => $item->created_at,
                ];
            });

        // Data barang masuk
        $barangMasuks = BarangMasuk::with(['barang', 'user'])
            ->whereNull('deleted_at')->whereNull('deleted_at')->where('barang_id', $id[0])
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'date' => $item->date,
                    'user' => $item->user->name ?? 'Unknown',
                    'name' => $item->barang->name ?? '-',
                    'keterangan' => $item->keterangan ?? '-',
                    'tipe' => 'MASUK',
                    'jumlah' => $item->jumlah,
                    'satuan' => $item->barang->satuanBarang->name ?? '-',
                    'created_at' => $item->created_at,
                ];
            });

        // Data barang keluar
        $barangKeluars = BarangKeluar::with(['barang', 'user'])
            ->whereNull('deleted_at')->whereNull('deleted_at')->where('barang_id', $id[0])
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'date' => $item->date,
                    'user' => $item->user->name ?? 'Unknown',
                    'name' => $item->barang->name ?? '-',
                    'keterangan' => $item->keterangan ?? '-',
                    'tipe' => 'KELUAR',
                    'jumlah' => $item->jumlah,
                    'satuan' => $item->barang->satuanBarang->name ?? '-',
                    'created_at' => $item->created_at,
                ];
            });

        // Gabungkan dan urutkan semua transaksi
        $merged = collect()
            ->concat($barangMasuks)
            ->concat($barangKeluars)
            ->concat($barangAwals)
            ->sortByDesc('created_at')
            ->values();


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
            return view('barang.indexBarangMKbyID', compact('transaksis', 'barangs', 'previousUrl'));
        } else {
            return abort(403, 'Anda tidak memiliki izin untuk mengakses halaman ini.');
        }
    }

    public function indexDataBarang(Request $request)
    {
        $user = Auth::user();
        $role = $user->role;

        $query = Barang::select('barangs.*')
            ->join('satuan_barangs', 'barangs.satuan_id', '=', 'satuan_barangs.id')
            ->whereNull('barangs.deleted_at')
            ->orderBy('name', 'asc');

        if ($search = $request->input('search')) {
            $query->where('barangs.name', 'like', '%' . $search . '%');
        }

        $query->orderBy('barangs.name', 'asc');
        $satuanBarangs = SatuanBarang::orderBy('name', 'asc')->whereNull('deleted_at')->get();

        $barangs = $query->paginate(20)->appends($request->query());

        if (in_array($role, ['OWNER', 'MANAJER', 'STAF'])) {
            return view('barang.indexDataBarang', compact('barangs', 'satuanBarangs'));
        } else {
            return abort(403, 'Anda tidak memiliki izin untuk mengakses halaman ini.');
        }
    }

    public function indexSatuan(Request $request)
    {
        $user = Auth::user();
        $role = $user->role;

        $query = SatuanBarang::whereNull('deleted_at')
            ->orderBy('name', 'asc');

        if ($search = $request->input('search')) {
            $query->where('satuan_barangs.name', 'like', '%' . $search . '%');
        }

        $satuans = $query->paginate(20)->appends($request->query());

        if (in_array($role, ['OWNER', 'MANAJER', 'STAF'])) {
            return view('barang.indexSatuan', compact('satuans'));
        } else {
            return abort(403, 'Anda tidak memiliki izin untuk mengakses halaman ini.');
        }
    }

    public function storeM(Request $request)
    {
        $validated = $request->validate([
            'id' => 'required|exists:barangs,id',
            'date' => 'required|date',
            'keterangan' => 'nullable|string',
            'jumlah' => 'required|numeric|min:1',
        ]);

        // Cek duplikat stok masuk Barang
        $exists = BarangMasuk::where('barang_id', $validated['id'])
            ->where('date', $validated['date'])
            ->where('jumlah', $validated['jumlah'])
            ->where('keterangan', $validated['keterangan'])
            ->exists();

        if ($exists) {
            return redirect()->back()->with('error', 'Data stok masuk sudah pernah di submit sebelumnya.');
        }

        $barangMasuk = BarangMasuk::create([
            'barang_id' => $validated['id'],
            'keterangan' => $validated['keterangan'],
            'jumlah' => $validated['jumlah'],
            'user_id' => Auth::id(),
            'date' => $validated['date'],
        ]);

        $barangMasuk->load('barang');

        return redirect()->back()->with('success', 'Stok "' . $barangMasuk->barang->name . '" berhasil ditambahkan sebanyak ' . number_format($barangMasuk->jumlah, 0, ',', '.') . ' ' . $barangMasuk->barang->satuanBarang->name . '.');
    }

    public function storeK(Request $request)
    {
        $validated = $request->validate([
            'id' => 'required|exists:barangs,id',
            'keterangan' => 'nullable|string',
            'jumlah' => 'required|numeric|min:1',
            'date' => 'required|date',
        ]);

        // Cek duplikat stok keluar Barang
        $exists = BarangKeluar::where('barang_id', $validated['id'])
            ->where('date', $validated['date'])
            ->where('jumlah', $validated['jumlah'])
            ->where('keterangan', $validated['keterangan'])
            ->exists();

        if ($exists) {
            return redirect()->back()->with('error', 'Data stok keluar sudah pernah di submit sebelumnya.');
        }

        $barangKeluar = BarangKeluar::create([
            'barang_id' => $validated['id'],
            'keterangan' => $validated['keterangan'],
            'jumlah' => $validated['jumlah'],
            'user_id' => Auth::id(),
            'date' => $validated['date'],
        ]);

        $barangKeluar->load('barang');

        // Update dan cek alert stok
        $stockService = new StockDataService();
        $barang = $stockService->getSingleBarang($validated['id']);
        if ($barang instanceof \Illuminate\Support\Collection) {
            $barang = $barang->first();
        }
        $barangData = collect();
        if ($barang) {
            $barangData->push($barang);
        }
        $alertService = new StockAlertService();
        $alertService->checkAndNotify($barangData);

        return redirect()->back()->with('success', 'Stok "' . $barangKeluar->barang->name . '" berhasil dikurangi sebanyak ' . number_format($barangKeluar->jumlah, 0, ',', '.') . ' ' . $barangKeluar->barang->satuanBarang->name . '.');
    }

    public function storeDataBarang(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:30',
            'date' => 'required|date',
            'description' => 'nullable|string',
            'stok_awal' => 'required|integer|max:20',
            'minimum' => 'required|Integer|max:20',
            'satuan_id' => 'required',
            'image' => 'nullable|mimes:jpeg,jpg,png,webp|max:3072',
        ]);

        $existing = Barang::whereNull('deleted_at')->whereRaw('LOWER(name) = ?', [strtolower($request->input('name'))])->first();
        if ($existing) {
            return redirect()->back()->with('error', 'Barang "' . $request->input('name') . '" sudah ada.');
        }

        $Barang = new Barang;
        $Barang->user_id = Auth::id();
        $Barang->date = $request->input('date');
        $Barang->name = $request->input('name');
        $Barang->description = $request->input('description') ?? '-';
        $Barang->minimum = $request->input('minimum');
        $Barang->stok_awal = $request->input('stok_awal') ?? 0;
        $Barang->satuan_id = $request->input('satuan_id') ?? '-';

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            $path = 'upload/barang/';
            $file->move($path, $filename);
            $Barang->image = $path . $filename;
        }

        $Barang->save();

        BarangAwal::create([
            'barang_id' => $Barang->id,
            'keterangan' => 'Stok awal ' . $request->name,
            'jumlah' => $Barang->stok_awal,
            'user_id' => Auth::id(),
            'date' => $request->date,
        ]);

        $user = Auth::user();
        $settings = json_decode($user->setting->settings ?? '[]', true);
        $showImage = $settings['show_image_barang'] ?? true;
        $pagination = $settings['pagination_barang'] ?? 20;
        $allowedPagination = [20, 50, 100];
        if (!in_array($pagination, $allowedPagination)) {
            $pagination = 20;
        }
        $query = Barang::whereNull('deleted_at');
        $lastPage = $query->paginate($pagination)->lastPage();

        return redirect('/barang/manajemen-barang?page=' . $lastPage . '&orderBy=id&sort=asc')
            ->with('success', 'Barang "' . $Barang->name . '" berhasil ditambahkan.');
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

        $existing = SatuanBarang::whereNull('deleted_at')->whereRaw('LOWER(name) = ?', [strtolower($request->input('name'))])->first();

        $dataPerPage = 20;
        $data = DB::table('satuan_barangs')->paginate($dataPerPage);
        $lastPage = $data->lastPage();

        if ($existing) {
            return redirect()->back()->with('error', 'Satuan "' . $request->input('name') . '" sudah ada');
        }

        $Satuan = new SatuanBarang();
        $Satuan->user_id = $user;
        $Satuan->name = $request->input('name');
        $Satuan->save();

        return redirect('/barang/satuan?page=' . $lastPage)->with('success', 'Satuan "' . $Satuan->name . '" berhasil ditambahkan.');

    }

    public function show($id)
    {

    }

    public function updateDataBarang(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:30',
            'date' => 'required|date',
            'description' => 'nullable|string',
            'minimum' => 'required|Integer|max:20',
            'satuan_id' => 'required',
            'image' => 'nullable|mimes:jpeg,jpg,png,webp|max:3072',
        ]);

        $id = $request->input('id');
        $existing = Barang::whereNull('deleted_at')
            ->whereRaw('LOWER(name) = ?', [strtolower($request->input('name'))])
            ->where('id', '!=', $id)
            ->first();

        if ($existing) {
            return redirect()->back()->with('error', 'Barang "' . $request->input('name') . '" sudah ada.');
        }

        $Barang = Barang::findOrFail($request->input('id'));
        $Barang->user_id = Auth::id();
        $Barang->name = $request->input('name');
        $Barang->description = $request->input('description') ?? '-';
        $Barang->minimum = $request->input('minimum' ?? 0);
        $Barang->satuan_id = $request->input('satuan_id');

        if ($request->hasFile('image')) {
            if ($Barang->image && file_exists(public_path($Barang->image))) {
                unlink(public_path($Barang->image));
            }

            $file = $request->file('image');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $path = 'upload/barang/';
            $file->move(public_path($path), $filename);

            $Barang->image = $path . $filename;
        }

        $Barang->save();

        return redirect()->back()->with('success', 'Barang "' . $Barang->name . '" berhasil diperbarui.');
    }

    public function deleteImageBarang($id)
    {
        $barang = Barang::findOrFail($id);

        if ($barang->image && file_exists(public_path($barang->image))) {
            unlink(public_path($barang->image)); // Hapus dari folder
        }

        $barang->image = null; // Kosongkan di database
        $barang->save();

        return redirect()->back()->with('success', 'Gambar berhasil di hapus.');
    }

    public function updateSatuan(Request $request, SatuanBarang $satuans)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $id = $request->input('id');
        $existing = SatuanBarang::whereNull('deleted_at')
            ->whereRaw('LOWER(name) = ?', [strtolower($request->input('name'))])
            ->where('id', '!=', $id)
            ->first();

        if ($existing) {
            return redirect()->back()->with('error', 'Satuan "' . $request->input('name') . '" sudah ada.');
        }

        $user = Auth::user()->id;

        $Satuan = SatuanBarang::findOrFail($request->input('id'));
        $Satuan->user_id = $user;
        $Satuan->name = $request->input('name');
        $Satuan->save();

        return redirect()->back()->with('success', 'Satuan "' . $Satuan->name . '" berhasil diperbarui.');
    }

    public function deleteDataBarang(Request $request)
    {
        $id = $request->id;
        $barang = Barang::findOrFail($id);

        $barang->deleted_at = now();
        $barang->save();

        return redirect()->back()->with('success', 'Barang "' . $barang->name . '" berhasil di hapus.');
    }

    public function deleteBarangMasukByID(Request $request)
    {
        $id = $request->id;
        $barangs = BarangMasuk::findOrFail($id);

        $formattedDate = Carbon::parse($barangs->date)->translatedFormat('j F Y');
        $barangs->delete();

        return redirect()->back()->with('success', 'Data barang masuk tanggal "' . $formattedDate . '"  sebanyak ' . number_format($barangs->jumlah, 0, ',', '.') . ' ' . $barangs->barang->satuanBarang->name . ' berhasil di hapus.');
    }

    public function deleteBarangKeluarByID(Request $request)
    {
        $id = $request->id;
        $barangs = BarangKeluar::findOrFail($id);

        $formattedDate = Carbon::parse($barangs->date)->translatedFormat('j F Y');
        $barangs->delete();

        return redirect()->back()->with('success', 'Data barang keluar tanggal "' . $formattedDate . '"  sebanyak ' . number_format($barangs->jumlah, 0, ',', '.') . ' ' . $barangs->barang->satuanBarang->name . ' berhasil di hapus.');
    }

    public function deleteSatuan(Request $request)
    {
        $id = $request->id;
        $barang = SatuanBarang::findOrFail($id);

        $barang->deleted_at = now();
        $barang->save();

        return redirect()->back()->with('success', 'Satuan "' . $barang->name . '" berhasil di hapus.');
    }
}

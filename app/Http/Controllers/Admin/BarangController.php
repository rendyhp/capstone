<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\BarangAwal;
use App\Models\BarangKeluar;
use App\Models\BarangMasuk;
use App\Models\SatuanBarang;
use Illuminate\Http\Request;
use App\Models\TemporaryFile;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Redirect;

use App\Helpers\LogActivity;
use Hashids\Hashids;

class BarangController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $role = $user->role;

       
        $allowedSortColumns = ['id', 'name', 'jumlah', 'created_at'];
        $allowedSortDirections = ['asc', 'desc'];

        $orderBy = in_array($request->input('orderBy'), $allowedSortColumns) ? $request->input('orderBy') : 'name';
        $sort = in_array($request->input('sort'), $allowedSortDirections) ? $request->input('sort') : 'asc';

        $query = Barang::select(
            'barangs.*',
            DB::raw('
                (COALESCE(barangs.jumlah, 0) +
                COALESCE((SELECT SUM(jumlah) FROM barang_masuks WHERE barang_id = barangs.id AND deleted_at IS NULL), 0) -
                COALESCE((SELECT SUM(jumlah) FROM barang_keluars WHERE barang_id = barangs.id AND deleted_at IS NULL), 0)
                ) AS stok_akhir
            ')
        )
            ->join('satuan_barangs', 'barangs.satuan_id', '=', 'satuan_barangs.id')
            ->whereNull('barangs.deleted_at')
            ->orderBy('barangs.' . $orderBy, $sort);

        if ($search = $request->input('search')) {
            $query->where('barangs.name', 'like', '%' . $search . '%');
        }

        $satuanBarangs = SatuanBarang::orderBy('name', 'asc')->whereNull('deleted_at')->get();
        $barangs = $query->paginate(20)->appends($request->query());

        if (in_array($role, ['OWNER', 'MANAJER', 'STAF'])) {
            return view('barang.index', compact('barangs', 'satuanBarangs'));
        } else {
            return abort(403, 'Anda tidak memiliki izin untuk mengakses halaman ini.');
        }
    }

    public function indexbyId(Request $request, $encryptedId)
    {
        $hashids = new Hashids(env('HASHIDS_SALT', 'cafebdim_Salty'), 32);
        $id = $hashids->decode($encryptedId);
        if (empty($id)) {
            abort(404, 'ID tidak valid');
        }

        $user = Auth::user();
        $role = $user->role;

        $query = Barang::select(
            'barangs.*',
            DB::raw('
                (COALESCE(barangs.jumlah, 0) +
                COALESCE((SELECT SUM(jumlah) FROM barang_masuks WHERE barang_id = barangs.id AND deleted_at IS NULL), 0) -
                COALESCE((SELECT SUM(jumlah) FROM barang_keluars WHERE barang_id = barangs.id AND deleted_at IS NULL), 0)
                ) AS stok_akhir
            ')
        )
            ->join('satuan_barangs', 'barangs.satuan_id', '=', 'satuan_barangs.id')
            ->where('barangs.id', $id[0])
            ->whereNull('barangs.deleted_at')
            ->firstOrFail();

        if ($search = $request->input('search')) {
            $query->where('barangs.name', 'like', '%' . $search . '%');
        }

        $satuanBarangs = SatuanBarang::orderBy('name', 'asc')->whereNull('deleted_at')->get();
        $barang = $query;

        if (in_array($role, ['OWNER', 'MANAJER', 'STAF'])) {
            return view('barang.indexbyId', compact('barang', 'satuanBarangs'));
        } else {
            return abort(403, 'Anda tidak memiliki izin untuk mengakses halaman ini.');
        }
    }


    public function indexMasukKeluar(Request $request)
    {
        $user = Auth::user();
        $role = $user->role;

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
            });

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
            });

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
            });

        $merged = $barangMasuks->merge($barangKeluars)->merge($barangAwals)->sortByDesc('created_at')->values();

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
        $merged = $barangMasuks->merge($barangKeluars)->merge($barangAwals)->sortByDesc('created_at')->values();

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
            return view('barang.indexBarangMKbyID', compact('transaksis', 'barangs'));
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

        if ($role === 'OWNER') {
            return view('barang.indexDataBarang', compact('barangs', 'satuanBarangs'));
        } elseif ($role === 'MANAJER') {
            return view('barang.indexDataBarang', compact('barangs', 'satuanBarangs'));
        } elseif ($role === 'STAF') {
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

        if ($role === 'OWNER') {
            return view('barang.indexSatuan', compact('satuans'));
        } elseif ($role === 'MANAJER') {
            return view('barang.indexSatuan', compact('satuans'));
        } elseif ($role === 'STAF') {
            return view('barang.indexSatuan', compact('satuans'));
        } else {
            return abort(403, 'Anda tidak memiliki izin untuk mengakses halaman ini.');
        }
    }


    public function create()
    {

        return view('barang');
    }

    public function storeM(Request $request)
    {
        $validated = $request->validate([
            'id' => 'required',
            'date' => 'required|date',
            'keterangan' => 'nullable',
            'jumlah' => 'required|numeric|min:0',

        ]);

        BarangMasuk::create([
            'barang_id' => $validated['id'],
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
            'id' => 'required|exists:barangs,id',

            'keterangan' => 'nullable',
            'jumlah' => 'required|numeric|min:0',
            'date' => 'required|date',
        ]);

        BarangKeluar::create([
            'barang_id' => $validated['id'],
            'keterangan' => $validated['keterangan'],
            'jumlah' => $validated['jumlah'],
            'user_id' => Auth::id(),
            'date' => $validated['date'],
        ]);

        return redirect()->back()->with('success', 'Stok berhasil dikurangi.');
    }


    public function storeDataBarang(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:30',
            'date' => 'required|date',
            'description' => 'nullable|string',
            'jumlah' => 'required|integer|max:20',
            'satuan_id' => 'required',
            'image' => 'nullable|mimes:jpeg,jpg,png,webp|max:3072',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        } else {
            $user = Auth::user()->id;

            if ($request->has('image')) {
                $file = $request->file('image');
                $extension = $file->getClientOriginalExtension();

                $filename = time() . '.' . $extension;

                $path = 'upload/barang/';
                $file->move($path, $filename);

                $Barang = new Barang;
                $Barang->user_id = $user;
                $Barang->date = $request->input('date');
                $Barang->name = $request->input('name');
                $Barang->description = $request->input('description' ?? '-');
                $Barang->jumlah = $request->input('jumlah' ?? 0);
                $Barang->satuan_id = $request->input('satuan_id' ?? '-');
                $Barang->image = $path . $filename;
                $Barang->save();
            } else {
                $Barang = new Barang;
                $Barang->user_id = $user;
                $Barang->date = $request->input('date');
                $Barang->name = $request->input('name');
                $Barang->description = $request->input('description' ?? '-');
                $Barang->jumlah = $request->input('jumlah' ?? 0);
                $Barang->satuan_id = $request->input('satuan_id' ?? '-');

                $Barang->save();
            }

            BarangAwal::create([
                'barang_id' => $Barang->id,
                'keterangan' => 'Stok awal ' . $request->name,
                'jumlah' => $Barang->jumlah,
                'user_id' => Auth::id(),
                'date' => $request->date,
            ]);


        }

        // Panggil fungsi logAdd()
        // LogActivity::addToLog('Create Barang "' . $request->input('name') . '"');

        $dataPerPage = 20;
        $data = DB::table('barangs')->paginate($dataPerPage);
        $lastPage = $data->lastPage();

        return redirect('/barang/master?page=' . $lastPage . '&order=id&sort=asc')
            ->with('success', 'Barang "' . $Barang->name . '" Berhasil Ditambahkan');
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

        $Satuan = new SatuanBarang();
        $Satuan->user_id = $user;
        $Satuan->name = $request->input('name');
        $Satuan->save();

        // Panggil fungsi logAdd()
        // LogActivity::addToLog('Create Barang "' . $request->input('name') . '"');

        $dataPerPage = 20;
        $data = DB::table('satuan_barangs')->paginate($dataPerPage);
        $lastPage = $data->lastPage();

        return redirect('/barang/satuan?page=' . $lastPage)->with('success', 'Satuan "' . $Satuan->name . '" Berhasil Ditambahkan');

    }

    public function show($id)
    {

    }

    public function editDataBarang(Barang $barang)
    {
        $Barang = Barang::findOrFail($barang->id);
        return view('barang.indexDataBarang', compact('Barang'));
    }

    public function updateDataBarang(Request $request, Barang $barangs)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'jumlah' => 'required|integer|max:10',
            'satuan_id' => 'required',
            'image' => 'nullable|mimes:jpeg,jpg,png|max:3072',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $user = Auth::user()->id;

        $Barang = Barang::findOrFail($request->input('id'));
        $Barang->user_id = $user;
        $Barang->name = $request->input('name');
        $Barang->description = $request->input('description' ?: '-');
        $Barang->jumlah = $request->input('jumlah' ?: 0);
        $Barang->satuan_id = $request->input('satuan_id' ?: '-');
        $Barang->image = $request->input('image') ?: null;
        $Barang->save();

        return redirect('/barang/data-barang')->with('success', 'Data "' . $Barang->name . '" Berhasil Diubah');
    }

    public function updateSatuan(Request $request, SatuanBarang $satuans)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $user = Auth::user()->id;

        $Satuan = SatuanBarang::findOrFail($request->input('id'));
        $Satuan->user_id = $user;
        $Satuan->name = $request->input('name');
        $Satuan->save();

        return redirect('/barang/satuan')->with('success', 'Data "' . $Satuan->name . '" Berhasil Diubah');
    }

    public function delete(Request $request)
    {
        $id = $request->id;
        $barang = Barang::findOrFail($id);

        $barang->deleted_at = now();
        $barang->save();

        return redirect('/stok-barang')->with('success', 'Data "' . $barang->name . '" Berhasil Dihapus');
    }

    public function deletePermanent(Request $request)
    {
        $slug = $request->slug;

        $barang = Barangs::where('slug', $slug)->firstOrFail();
        $name = $barang->title;
        // Lakukan penghapusan permanen menggunakan Eloquent
        Barang::where('slug', $slug)->forceDelete();
        // Panggil fungsi logAdd()
        LogActivity::addToLog('Delete Permanen Barang "' . $name . '"');

        // Redirect kembali ke halaman sebelumnya
        return Redirect::back()->with('delete', 'Dataset "' . $name . '" berhasil dihapus permanen');
    }
}

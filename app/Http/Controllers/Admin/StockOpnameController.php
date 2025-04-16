<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AkhirTerpakaiSeharusnya;
use App\Models\Bahan;
use App\Models\BahanAkhir;
use App\Models\BahanAwal;

use App\Models\Barang;
use App\Models\HistoryInput;
use Carbon\Carbon;
use Illuminate\Http\Request;


use App\Models\TemporaryFile;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Redirect;

use App\Helpers\LogActivity;

class StockOpnameController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $role = $user->role;

        // Ambil inputan tanggal, default hari ini
        $date = $request->input('date', Carbon::today()->toDateString());
        $search = $request->input('search');

        // Ambil semua data bahan akhir untuk tanggal tertentu
        $query = BahanAkhir::selectRaw('
        bahan_akhirs.bahan_id,
        SUM(bahan_akhirs.jumlah) as total_jumlah,
        MAX(bahan_akhirs.date) as tanggal,
        bahans.name as bahan_name,
        satuans.name as satuan_name
    ')
            ->join('bahans', 'bahan_akhirs.bahan_id', '=', 'bahans.id')
            ->join('satuans', 'bahans.satuan_id', '=', 'satuans.id')
            ->whereNull('bahan_akhirs.deleted_at')
            ->whereDate('bahan_akhirs.date', $date)
            ->when($search, function ($q) use ($search) {
                $q->where('bahans.name', 'like', '%' . $search . '%');
            })
            ->groupBy('bahan_akhirs.bahan_id', 'bahans.name', 'satuans.name')
            ->orderBy('bahans.name', 'asc');



        if (!empty($search)) {
            $query->where('bahans.name', 'like', '%' . $search . '%');
        }

        // Ambil semua data dulu
        $allData = $query->orderByDesc('bahan_akhirs.id')->get();

        // Grouping berdasarkan bahan_id, ambil entri terakhir
        $grouped = $allData->groupBy('bahan_id')->map(function ($items) {
            return $items->first(); // ambil yang id paling besar (terbaru)
        })->values();

        // Manual paginate
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $perPage = 20;
        $currentItems = $grouped->slice(($currentPage - 1) * $perPage, $perPage)->values();
        $bahan_akhirs = new LengthAwarePaginator($currentItems, $grouped->count(), $perPage);
        $bahan_akhirs->appends($request->query());

        // Hitung total jumlah dari seluruh data (bukan hanya yang ditampilkan)
        $total_jumlah = $grouped->sum('jumlah');

        // Return ke view sesuai role
        if ($role === 'OWNER') {
            return view('stock-opname.index', compact('bahan_akhirs', 'date', 'total_jumlah'));
        } elseif ($role === 'user') {
            return view('user.barang', compact('bahan_akhirs', 'date', 'total_jumlah'));
        } else {
            return abort(403, 'Anda tidak memiliki izin untuk mengakses halaman ini.');
        }
    }


    public function simpan(Request $request)
    {
        $user = Auth::user();
        $role = $user->role;

        // Ambil semua bahan beserta satuan dan jumlah stok akhir (jika ada)
        $stockOpnames = Bahan::with([
            'satuan',
            'bahanAkhir' => function ($query) {
                $query->latest('date'); // Ambil stok akhir terbaru
            }
        ])->orderBy('name', 'asc')
            ->whereNull('deleted_at')
            ->get();

        return view('stock-opname.stock-opname', compact('stockOpnames'));
    }

    public function simpanDataBaru(Request $request)
    {
        $user = Auth::user()->id;

        $validatedData = $request->validate([
            'tanggaltransmasuk' => 'required|date',
            'bahan_id' => 'required|array',
            'jumlah' => 'required|array',
            'save_for_tomorrow' => 'nullable' // boleh tidak dikirim
        ]);

        $tanggalHariIni = $validatedData['tanggaltransmasuk'];
        $tanggalBesok = date('Y-m-d', strtotime($tanggalHariIni . ' +1 day'));
        $saveBesok = $request->has('save_for_tomorrow');

        foreach ($validatedData['bahan_id'] as $index => $bahan_id) {
            $jumlah = $validatedData['jumlah'][$index];

            // Simpan ke BahanAkhir (stok hari ini)
            BahanAkhir::create([
                'user_id' => $user,
                'date' => $tanggalHariIni,
                'bahan_id' => $bahan_id,
                'jumlah' => $jumlah,
            ]);

            // Jika checkbox dicentang, simpan juga untuk besok
            if ($saveBesok) {
                BahanAwal::create([
                    'date' => $tanggalBesok,
                    'bahan_id' => $bahan_id,
                    'jumlah' => $jumlah,
                ]);
            }
        }

        return redirect()->route('stock-opname.index', ['date' => $tanggalHariIni])
            ->with('success', 'Data Stock Opname berhasil disimpan!');
    }

    public function create()
    {

        return view('pages.admin.dataset.create', compact('tags'));
    }

    public function store(Request $request)
    {

        Validator::make($request->all(), [
            'name' => 'required',
            'description' => 'required',
            'minimum' => 'required',
            'satuan_id' => 'required',
        ]);

        $user = Auth::user()->id;

        // Simpan data dataset ke database
        Dataset::create([
            'user_id' => $user,
            'name' => $request->name,
            'description' => $request->description,
            'minimum' => $request->minimum,
            'satuan_id' => $request->satuan_id,
        ]);

        // Panggil fungsi logAdd()
        LogActivity::addToLog('Create Bahan "' . $request->name . '"');

        return redirect()->route('admin.dataset')->with('success', 'Bahan "' . $request->name . '" berhasil ditambahkan');
    }

    public function show($slug)
    {
        $bahans = Bahan::where('slug', $slug)
            ->first();

        $bahanAwal = BahanAwal::all();
        $historyInput = HistoryInput::all();
        $akhirTerpakaiSeharusnya = AkhirTerpakaiSeharusnya::all();

        return view('pages.admin.dataset.show', [
            'bahans' => $bahans,
        ], compact('bahan', 'bahanAwal', 'historyInput', 'akhirTerpakaiSeharusnya'));
    }

    public function edit($slug)
    {
        $barangs = DB::table('bahans')->where('slug', $slug)
            ->first();

        return view('pages.admin.dataset.edit', ['bahans' => $barangs]);
    }

    public function update(Request $request, Bahans $bahans)
    {
        Validator::make($request->all(), [
            'name' => 'required',
            'description' => 'required',
            'minimum' => 'required',
            'satuan_id' => 'required',
        ]);

        $user = Auth::user()->id;

        // Cari dataset berdasarkan slug
        $bahans = Bahan::where('slug', $request->slug)->first();


        // Simpan barang ke database
        $bahans->update([
            'user_id' => $user,
            'name' => $request->name,
            'description' => $request->description,
            'minimum' => $request->minimum,
            'satuan_id' => $request->satuan_id,
        ]);

        // Panggil fungsi logAdd()
        LogActivity::addToLog('Update Bahan "' . $request->title . '"');

        return redirect()->route('admin.dataset')
            ->with('update', 'Barang berhasil diperbarui');
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

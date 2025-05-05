<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Imports\TransaksiImport;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\Menu;
use Illuminate\Pagination\LengthAwarePaginator;
use PhpOffice\PhpSpreadsheet\IOFactory;
use App\Models\KomposisiMenu;
use App\Models\Bahan;
use App\Models\TransaksiDetail;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;

use Illuminate\Support\Collection;



class TransaksiController extends Controller
{


    public function index(Request $request)
    {
        $user = Auth::user();
        $role = $user->role;

        $date = $request->input('date', Carbon::today()->toDateString());
        $search = $request->input('search');

        // Ambil semua data transaksi dan komposisi
        $allData = DB::table('transaksis')
            ->selectRaw('
            transaksis.menu_id,
            menus.name as menu_name,
            SUM(transaksis.jumlah) as total_jumlah,
            bahans.name as bahan_name,
            satuan_bahans.name as satuan_name,
            SUM(komposisi_menus.jumlah * transaksis.jumlah) as total_bahan
        ')
            ->join('menus', 'transaksis.menu_id', '=', 'menus.id')
            ->join('komposisi_menus', 'menus.id', '=', 'komposisi_menus.menu_id')
            ->join('bahans', 'komposisi_menus.bahan_id', '=', 'bahans.id')
            ->join('satuan_bahans', 'bahans.satuan_id', '=', 'satuan_bahans.id')
            ->whereDate('transaksis.date', $date)
            ->when($search, function ($q) use ($search) {
                $q->where('menus.name', 'like', '%' . $search . '%');
            })
            ->groupBy('transaksis.menu_id', 'menus.name', 'bahans.name', 'satuan_bahans.name')
            ->orderBy('menus.name', 'asc')
            ->get();

        // Grouping berdasarkan menu
        $transaksis = $allData->groupBy('menu_id')->map(function ($items) {
            return [
                'menu_id' => $items->first()->menu_id,
                'menu_name' => $items->first()->menu_name,
                'total_jumlah' => $items->first()->total_jumlah,
                'bahans' => $items->map(function ($item) {
                    return [
                        'bahan_name' => $item->bahan_name,
                        'total_bahan' => $item->total_bahan,
                        'satuan_name' => $item->satuan_name,
                    ];
                })
            ];
        })->values();

        // Pagination manual
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $perPage = 20;
        $currentItems = $transaksis->slice(($currentPage - 1) * $perPage, $perPage)->values();
        $paginated = new LengthAwarePaginator($currentItems, $transaksis->count(), $perPage);
        $paginated->appends($request->query());

        // Ambil semua menu untuk modal/edit
        $menus = Menu::with('komposisi.bahan.satuan')->whereNull('deleted_at')->orderBy('name','asc')->get();

        if ($role === 'OWNER') {
            return view('transaksi.index', compact('paginated', 'date', 'menus'));
        } elseif ($role === 'user') {
            return view('user.transaksi', compact('paginated', 'date', 'menus'));
        } else {
            return abort(403, 'Anda tidak memiliki izin untuk mengakses halaman ini.');
        }
    }

    public function importTransaksi(Request $request)
{
    $request->validate([
        'file' => 'required|file|mimes:xlsx,xls',
        'date' => 'required|date',
    ]);

    $file = $request->file('file');
    $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($file->getRealPath());
    $sheet = $spreadsheet->getActiveSheet();
    $rows = $sheet->toArray();

    for ($i = 1; $i < count($rows); $i++) {
        $judulProduk = trim($rows[$i][0]); 
        $jumlah = (int) $rows[$i][2]; 

        if (!$judulProduk || $jumlah <= 0) {
            continue;
        }

        $menu = Menu::where('name', $judulProduk)->first();
        if (!$menu) {
            continue;
        }

        $transaksi = Transaksi::create([
            'user_id' => Auth::id(),
            'menu_id' => $menu->id,
            'jumlah' => $jumlah,
            'date' => $request->date,
        ]);

        $this->hitungBahanTerpakai($transaksi);
    }

    return redirect()->route('transaksi.index')->with('success', 'Import transaksi berhasil.');
}

    public function preview()
    {
        $path = session('temp_excel');

        if (!$path || !Storage::exists($path)) {
            return redirect()->back()->with('error', 'File tidak ditemukan.');
        }

        $data = Excel::toCollection(null, storage_path('app/' . $path))->first();
        $previewData = [];

        foreach ($data as $row) {
            if (!empty($row[0]) && !empty($row[2])) {
                $previewData[] = [
                    'menu' => $row[0],
                    'jumlah' => intval($row[2]),
                ];
            }
        }

        return view('transaksi.preview', compact('previewData'));
    }

    public function deleteTemp()
    {
        $path = session('temp_excel');

        if ($path && Storage::exists($path)) {
            Storage::delete($path);
        }

        session()->forget('temp_excel');

        return redirect()->back()->with('success', 'File sementara dihapus.');
    }




    public function store(Request $request)
    {
        $request->validate([
            'menu_id' => 'required|exists:menus,id',
            'jumlah' => 'required|numeric|min:1',
            'date' => 'required|date',
        ]);

        $transaksi = Transaksi::create([
            'user_id' => Auth::id(),
            'menu_id' => $request->menu_id,
            'jumlah' => $request->jumlah,
            'date' => $request->date,
        ]);

        $this->hitungBahanTerpakai($transaksi);

        return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil ditambahkan.');
    }

    private function hitungBahanTerpakai(Transaksi $transaksi)
    {
        $menu = $transaksi->menu;
        if (!$menu)
            return;

        foreach ($menu->komposisi as $komposisi) {
            // Simpan detail pemakaian bahan dalam transaksi_detail
            TransaksiDetail::create([
                'date' => $transaksi->date,
                'transaksi_id' => $transaksi->id,
                'menu_id' => $transaksi->menu_id,
                'bahan_id' => $komposisi->bahan_id,
                'jumlah' => $komposisi->jumlah * $transaksi->jumlah,
                
               
            ]);


        }
    }



    public function edit($id)
    {
        $transaksi = Transaksi::findOrFail($id);
        $menus = Menu::all(); // untuk pilihan menu
        return view('transaksi.edit', compact('transaksi', 'menus'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'menu_id' => 'required|exists:menus,id',
            'jumlah' => 'required|numeric|min:1',
            'date' => 'required|date',
            'catatan' => 'nullable|string'
        ]);

        $transaksi = Transaksi::findOrFail($id);

        $transaksi->update([
            'menu_id' => $request->menu_id,
            'jumlah' => $request->jumlah,
            'date' => $request->date,
            'catatan' => $request->catatan,
        ]);

        // Hapus dan hitung ulang transaksi_detail
        // $transaksi->transaksiDetail()->delete();
        $this->hitungBahanTerpakai($transaksi);

        return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil diperbarui.');
    }


    public function destroy($id)
    {
        Transaksi::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Transaksi berhasil dihapus');
    }
}

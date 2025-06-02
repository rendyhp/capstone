<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\StockAlertService;
use App\Services\StockDataService;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\Menu;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Models\TransaksiDetail;
use Illuminate\Support\Facades\Auth;

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
            transaksis.menu_id as menu_id,
            transaksis.date as date,
            menus.name as menu_name,
            menus.image as menu_image,
            SUM(transaksis.jumlah) as total_jumlah,
            MIN(transaksis.id) as transaksi_id,
            bahans.name as bahan_name,
            satuan_bahans.name as satuan_name,
            SUM(komposisi_menus.jumlah * transaksis.jumlah) as total_bahan,
            komposisi_menus.bahan_id,  -- Include komposisi_menus.bahan_id
            komposisi_menus.jumlah as komposisi_jumlah  -- Include komposisi_menus.jumlah
        ')
            ->join('menus', 'transaksis.menu_id', '=', 'menus.id')
            ->join('komposisi_menus', 'menus.id', '=', 'komposisi_menus.menu_id')
            ->join('bahans', 'komposisi_menus.bahan_id', '=', 'bahans.id')
            ->join('satuan_bahans', 'bahans.satuan_id', '=', 'satuan_bahans.id')
            ->whereDate('transaksis.date', $date)
            ->when($search, function ($q) use ($search) {
                $q->where('menus.name', 'like', '%' . $search . '%');
            })
            ->groupBy(
                'transaksis.menu_id',
                'transaksis.date',
                'menus.name',
                'menus.image',
                'bahans.name',
                'satuan_bahans.name',
                'komposisi_menus.bahan_id',
                'komposisi_menus.jumlah'
            )
            ->orderBy('menus.name', 'asc')
            ->get();

        // Grouping berdasarkan menu
        $transaksis = $allData->groupBy('menu_id')->map(function ($items) {
            return [
                'menu_id' => $items->first()->menu_id,
                'transaksi_id' => $items->first()->transaksi_id,
                'date' => $items->first()->date,
                'menu_image' => $items->first()->menu_image,
                'menu_name' => $items->first()->menu_name,
                'total_jumlah' => $items->first()->total_jumlah,
                'bahans' => $items->map(function ($item) {
                    return [
                        'bahan_name' => $item->bahan_name,
                        'total_bahan' => $item->total_bahan,
                        'satuan_name' => $item->satuan_name,
                    ];
                }),
                'komposisi' => $items->map(function ($item) {
                    return [
                        'bahan_id' => $item->bahan_id,
                        'komposisi_jumlah' => $item->komposisi_jumlah,
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
        $menus = Menu::with('komposisi.bahan.satuan')->whereNull('deleted_at')->orderBy('name', 'asc')->get();

        return view('transaksi.index', compact('paginated', 'date', 'menus'));

    }

    public function importTransaksi(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls,csv',
            'date' => 'required|date',
            'mode' => 'required|in:tambah,update,range',
        ]);

        if ($request->mode === 'range') {
            $request->validate([
                'range_start' => 'required|date',
                'range_end' => 'required|date|after_or_equal:range_start',
            ]);
            $rangeStart = $request->range_start;
            $rangeEnd = $request->range_end;
        }

        $file = $request->file('file');
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($file->getRealPath());
        $sheet = $spreadsheet->getActiveSheet();
        $rows = $sheet->toArray();

        $tanggal = $request->date;
        $mode = $request->mode;

        $processedMenus = [];

        for ($i = 1; $i < count($rows); $i++) {
            $judulProduk = trim($rows[$i][0]);
            $jumlahBaru = (int) $rows[$i][2];

            if (!$judulProduk || $jumlahBaru <= 0) {
                continue;
            }

            $menu = Menu::whereRaw('LOWER(TRIM(name)) = ?', [strtolower($judulProduk)])
                ->whereNull('deleted_at')
                ->first();
            if (!$menu)
                continue;

            $processedMenus[] = $menu->id;

            if ($mode === 'update') {
                Transaksi::where('menu_id', $menu->id)
                    ->whereDate('date', $tanggal)
                    ->delete();
                $jumlahFinal = $jumlahBaru;
            } elseif ($mode === 'range') {
                // Hitung total dari range
                $totalSebelumnya = Transaksi::where('menu_id', $menu->id)
                    ->whereBetween('date', [$rangeStart, $rangeEnd])
                    ->sum('jumlah');

                // Selisih yang akan ditambahkan
                $jumlahFinal = $jumlahBaru - $totalSebelumnya;
                if ($jumlahFinal <= 0) {
                    continue;
                }
            } else {
                // Mode tambah
                $jumlahFinal = $jumlahBaru;
            }

            $transaksi = Transaksi::create([
                'user_id' => Auth::id(),
                'menu_id' => $menu->id,
                'jumlah' => $jumlahFinal,
                'date' => $tanggal,
            ]);

            $this->hitungBahanTerpakai($transaksi);
        }

        $bahanIds = \App\Models\KomposisiMenu::whereIn('menu_id', $processedMenus)
            ->pluck('bahan_id')
            ->unique()
            ->toArray();

        $stockService = new StockDataService();

        $bahanData = collect();

        foreach ($bahanIds as $bahanId) {
            $bahan = $stockService->getSingleBahan($bahanId, $tanggal);
            if ($bahan) {
                $bahanData = $bahanData->merge($bahan);
            }
        }

        $alertService = new StockAlertService();
        $alertService->checkAndNotify(null, $bahanData);

        return redirect()->route('transaksi.index', ['date' => $tanggal])
            ->with('success', 'Import transaksi berhasil.');
    }


    public function jumlahSebelumnya(Request $request)
    {
        $menuName = $request->input('menu');
        $date = $request->input('date');

        $menu = Menu::whereRaw('LOWER(TRIM(name)) = ?', [strtolower($menuName)])
            ->whereNull('deleted_at')
            ->first();

        if (!$menu) {
            return response()->json(['jumlah' => 0, 'menu_name' => null]);
        }

        $jumlah = Transaksi::where('menu_id', $menu->id)
            ->whereDate('date', $date)
            ->sum('jumlah');

        return response()->json([
            'jumlah' => $jumlah,
            'menu_name' => $menu->name,
        ]);
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

        return redirect()->back()->with('success', 'Transaksi berhasil ditambahkan.');
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

    public function updateTransaksi(Request $request, $id)
    {

        $request->validate([
            'menu_id' => 'required|exists:menus,id',
            'jumlah' => 'required|numeric|min:1',
            'date' => 'required|date',
        ]);

        $transaksi = Transaksi::find($id);

        if (!$transaksi) {
            return redirect()->route('transaksi.index')->with('error', 'Transaksi tidak ditemukan.');
        }

        $transaksi->menu_id = $request->menu_id;
        $transaksi->jumlah = $request->jumlah;
        $transaksi->date = $request->date;
        $transaksi->save();

        DB::table('transaksis')
            ->where('menu_id', $request->menu_id)
            ->where('date', $request->date)
            ->where('id', '!=', $transaksi->id)
            ->delete();

        $this->hitungBahanTerpakai($transaksi);

        return redirect()->back()->with('success', 'Transaksi berhasil diubah');
    }

    public function destroy(Request $request)
    {
        $transaksiId = $request->input('transaksi_id');
        $transaksi = Transaksi::find($transaksiId);

        if (!$transaksi) {
            return redirect()->back()->with('error', 'Transaksi tidak ditemukan.');
        }

        // Cari semua transaksi yang punya menu_id dan date sama
        $menuId = $transaksi->menu_id;
        $tanggal = $transaksi->date;
        $menuName = $transaksi->menu->name;

        Transaksi::where('menu_id', $menuId)
            ->whereDate('date', $tanggal)
            ->delete();

        return redirect()->back()->with('success', 'Transaksi "' . $menuName . '" berhasil dihapus.');
    }
}

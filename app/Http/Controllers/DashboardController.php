<?php

namespace App\Http\Controllers;

use App\Models\Bahan;
use App\Models\BahanAkhir;
use App\Models\BahanAwal;
use App\Models\BahanMasuk;
use App\Models\BarangAwal;
use App\Models\BarangKeluar;
use App\Models\BarangMasuk;
use App\Models\UP;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\DetailTransaksi;
use App\Models\Barang;
use App\Models\Transaksi;
use PDF;
use Illuminate\Support\Facades\DB;
use App\Services\StockAlertService;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct()
    {

        $this->middleware('auth');
    }
    public function index(Request $request)
    {
        $user = Auth::user();
        $role = $user->role;
        $date = Carbon::today()->toDateString();
        $dateParam = $request->input('month', Carbon::now()->format('Y-m')); // Untuk laporan loss per bulan

        // ---------- BARANG ----------
        $barangs = Barang::with('satuanBarang')->whereNull('deleted_at')->get();

        $barang_data = $barangs->map(function ($barang) {
            $awal = BarangAwal::where('barang_id', $barang->id)->whereNull('deleted_at')->sum('jumlah');
            $masuk = BarangMasuk::where('barang_id', $barang->id)->whereNull('deleted_at')->sum('jumlah');
            $keluar = BarangKeluar::where('barang_id', $barang->id)->whereNull('deleted_at')->sum('jumlah');

            $total_beli = $awal + $masuk;
            $sisa = $total_beli - $keluar;

            $barang->sisa = $sisa;
            return $barang;
        })->sortBy('name');

        $barangs_below_minimum = $barang_data->filter(function ($barang) {
            return $barang->sisa < $barang->minimum;
        });

        // ---------- BAHAN ----------
        $bahans = Bahan::with('satuan')->whereNull('deleted_at')->get();

        $bahan_data = $bahans->map(function ($bahan) use ($date) {
            $awal = BahanAwal::where('bahan_id', $bahan->id)->whereDate('date', $date)->whereNull('deleted_at')->value('jumlah');
            if ($awal === null) {
                $awal = BahanAkhir::where('bahan_id', $bahan->id)->where('date', '<', $date)->whereNull('deleted_at')->orderByDesc('date')->value('jumlah') ?? 0;
            }

            $masuk = BahanMasuk::where('bahan_id', $bahan->id)->whereDate('date', $date)->whereNull('deleted_at')->sum('jumlah');

            $terpakai = DB::table('transaksi_details')
                ->join('transaksis', 'transaksi_details.transaksi_id', '=', 'transaksis.id')
                ->where('transaksi_details.bahan_id', $bahan->id)
                ->whereDate('transaksis.date', $date)
                ->whereNull('transaksis.deleted_at')
                ->sum('transaksi_details.jumlah');

            $jumlah_akhir = ($awal + $masuk) - $terpakai;
            $bahan->jumlah_akhir = $jumlah_akhir;

            return $bahan;
        })->sortBy([
                    ['section', 'asc'],
                    ['name', 'asc'],
                ]);

        $bahans_below_minimum = $bahan_data->filter(function ($bahan) {
            return $bahan->jumlah_akhir < $bahan->minimum;
        });

        // ---------- PERHITUNGAN LOSS BULANAN ----------
        $bulanNama = null;
        $tahunNama = null;
        $totalTerbuangBar = [];
        $totalTerbuangKitchen = [];

        if ($dateParam) {
            try {
                $dateCarbon = Carbon::createFromFormat('Y-m', $dateParam);
                $bulanNama = $dateCarbon->translatedFormat('F');
                $tahunNama = $dateCarbon->translatedFormat('Y');
                $month = $dateCarbon->month;
                $year = $dateCarbon->year;

                // BAR
                $totalTerbuangBar = $this->generateTotalTerbuangBySection($month, $year, 'BAR');
                // KITCHEN
                $totalTerbuangKitchen = $this->generateTotalTerbuangBySection($month, $year, 'KITCHEN');

            } catch (\Exception $e) {
                // log error jika diperlukan
            }
        }

        return view('dashboard.index', [
            'user' => $user,
            'barangs_below_minimum' => $barangs_below_minimum,
            'bahans_below_minimum' => $bahans_below_minimum,
            'totalTerbuangBar' => $totalTerbuangBar,
            'totalTerbuangKitchen' => $totalTerbuangKitchen,
            'bulanNama' => $bulanNama,
            'tahunNama' => $tahunNama,
            'dateParam' => $dateParam,
        ]);
    }

    private function generateTotalTerbuangBySection($month, $year, $section)
    {
        $results = [];

        $allHistories = $this->generateAllHistories($month, $year, $section);
        foreach ($allHistories as $item) {
            $total = collect($item['history'])->pluck('terbuang')->filter()->sum();
            $results[] = [
                'name' => $item['bahan']->name,
                'total_terbuang' => $total,
            ];
        }

        return $results;
    }

    private function generateAllHistories($month, $year, $section)
    {
        $daysInMonth = Carbon::create($year, $month, 1)->daysInMonth;
        $bahans = Bahan::with('satuan')
            ->whereNull('deleted_at')
            ->where('section', $section)
            ->orderBy('name', 'asc')
            ->get();

        $allHistories = [];

        foreach ($bahans as $bahan) {
            $bahanId = $bahan->id;

            $stokAwalData = BahanAwal::select(DB::raw('DATE(date) as tanggal'), DB::raw('SUM(jumlah) as total'))
                ->where('bahan_id', $bahanId)
                ->whereMonth('date', $month)
                ->whereYear('date', $year)
                ->whereNull('deleted_at')
                ->groupBy(DB::raw('DATE(date)'))
                ->pluck('total', 'tanggal');

            $masukData = BahanMasuk::select(DB::raw('DATE(date) as tanggal'), DB::raw('SUM(jumlah) as total'))
                ->where('bahan_id', $bahanId)
                ->whereMonth('date', $month)
                ->whereYear('date', $year)
                ->whereNull('deleted_at')
                ->groupBy(DB::raw('DATE(date)'))
                ->pluck('total', 'tanggal');

            $akhirData = BahanAkhir::select(DB::raw('DATE(date) as tanggal'), DB::raw('SUM(jumlah) as total'))
                ->where('bahan_id', $bahanId)
                ->whereMonth('date', $month)
                ->whereYear('date', $year)
                ->whereNull('deleted_at')
                ->groupBy(DB::raw('DATE(date)'))
                ->pluck('total', 'tanggal');

            $history = [];
            $prevAkhir = null;

            for ($day = 1; $day <= $daysInMonth; $day++) {
                $dateString = Carbon::createFromDate($year, $month, $day)->toDateString();

                $awal = $stokAwalData[$dateString] ?? $prevAkhir;
                $masuk = $masukData[$dateString] ?? 0;

                $terpakai = DB::table('transaksi_details')
                    ->join('transaksis', 'transaksi_details.transaksi_id', '=', 'transaksis.id')
                    ->where('transaksi_details.bahan_id', $bahanId)
                    ->whereDate('transaksis.date', $dateString)
                    ->whereNull('transaksis.deleted_at')
                    ->sum('transaksi_details.jumlah');

                $akhir = $akhirData[$dateString] ?? null;
                $jumlah_akhir = (!is_null($awal) && !is_null($masuk)) ? ($awal + $masuk - $terpakai) : null;
                $terbuang = (!is_null($jumlah_akhir) && !is_null($akhir)) ? ($jumlah_akhir - $akhir) : null;

                $history[] = [
                    'tanggal' => $day,
                    'awal' => $awal,
                    'masuk' => $masuk,
                    'terpakai' => $terpakai,
                    'sisa' => $jumlah_akhir,
                    'akhir' => $akhir,
                    'terbuang' => $terbuang,
                ];

                $prevAkhir = $akhir ?? $prevAkhir;
            }

            $allHistories[] = [
                'bahan' => $bahan,
                'history' => $history,
            ];
        }

        return $allHistories;
    }

    public function laporan()
    {

        $user = Auth::user();
        $role = $user->role;
        $unit = $user->unit;
        $query = Transaksi::query();

        if ($role === 'OWNER') {

            $Users = User::all();
            $Barangs = Barang::all();

            return view('laporan.index', compact('users'));
        } else {
            return abort(403, 'Anda tidak memiliki izin untuk mengakses halaman ini.');
        }
    }

    public function filter(Request $request)
    {
        // Lakukan pemrosesan filter laporan di sini
        $tanggalAwal = $request->input('tglawal');
        $tanggalAkhir = $request->input('tglakhir');

        // Lakukan query database untuk mengambil data laporan berdasarkan tanggal
        $dashboards = DetailTransaksi::select('tanggal_trans', 'barang_nama', 'barang_merk')
            ->selectRaw('SUM(CASE WHEN trans_jenis = "Masuk" THEN barang_quantity ELSE 0 END) AS barang_masuk')
            ->selectRaw('SUM(CASE WHEN trans_jenis = "Keluar" THEN barang_quantity ELSE 0 END) AS barang_keluar')
            ->join('transaksi', 'detail_transaksi.trans_id', '=', 'transaksi.id')
            ->join('barang', 'detail_transaksi.barang_id', '=', 'barang.id')
            ->whereBetween('tanggal_trans', [$tanggalAwal, $tanggalAkhir]) // Filter by date range
            ->groupBy('tanggal_trans', 'barang_nama', 'barang_merk')
            ->get();

        // Ambil data barang
        $Barangs = Barang::all();

        $stokTersedia = [];

        foreach ($Barangs as $barang) {
            // Mengambil jumlah stok masuk per barang
            $jumlahStokMasuk = DetailTransaksi::where('barang_id', $barang->id)
                ->whereHas('transaksi', function ($query) {
                    $query->where('trans_jenis', 'Masuk');
                })
                ->sum('barang_quantity');

            // Mengambil jumlah stok keluar per barang
            $jumlahStokKeluar = DetailTransaksi::where('barang_id', $barang->id)
                ->whereHas('transaksi', function ($query) {
                    $query->where('trans_jenis', 'Keluar');
                })
                ->sum('barang_quantity');

            // Menghitung stok tersedia untuk setiap barang
            $stokTersedia[$barang->barang_nama] = $jumlahStokMasuk - $jumlahStokKeluar;
        }

        $totalBarang = count($Barangs);

        return view('laporan.index', compact('dashboards', 'Barangs', 'totalBarang'));
    }
}

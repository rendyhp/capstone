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
use Carbon\CarbonPeriod;
use Hashids\Hashids;
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
        $type = $request->input('type', 'month');
        $dateInput = $request->input('date', now()->toDateString());

        $date = Carbon::parse($dateInput);
        $dateMin = Carbon::today()->toDateString();
        session(['previous_dashboard_url' => url()->full()]);

        switch ($type) {
            case 'week':
                $startDate = $date->copy()->startOfWeek(Carbon::SUNDAY);
                $endDate = $date->copy()->endOfWeek(Carbon::SATURDAY);
                break;
            case 'month':
                $startDate = $date->copy()->startOfMonth();
                $endDate = $date->copy()->endOfMonth();
                break;
            case 'year':
                $startDate = $date->copy()->startOfYear();
                $endDate = $date->copy()->endOfYear();
                break;
            default:
                $startDate = $date;
                $endDate = $date;
        }

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

        $bahan_data = $bahans->map(function ($bahan) use ($dateMin) {
            $awal = BahanAwal::where('bahan_id', $bahan->id)->whereDate('date', $dateMin)->whereNull('deleted_at')->value('jumlah');
            if ($awal === null) {
                $awal = BahanAkhir::where('bahan_id', $bahan->id)->where('date', '<', $dateMin)->whereNull('deleted_at')->orderByDesc('date')->value('jumlah') ?? 0;
            }

            $masuk = BahanMasuk::where('bahan_id', $bahan->id)->whereDate('date', $dateMin)->whereNull('deleted_at')->sum('jumlah');

            $terpakai = DB::table('transaksi_details')
                ->join('transaksis', 'transaksi_details.transaksi_id', '=', 'transaksis.id')
                ->where('transaksi_details.bahan_id', $bahan->id)
                ->whereDate('transaksis.date', $dateMin)
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

        // ---------- PERHITUNGAN LOSS DARI PERIODE ----------
        $periodeLabel = match ($type) {
            'week' => 'Minggu ke ' . $startDate->format('W') . ' (' . $startDate->translatedFormat('j M') . ' - ' . $endDate->translatedFormat('j M Y') . ')',
            'month' => $date->translatedFormat('F Y'),
            'year' => $date->translatedFormat('Y'),
            default => $date->translatedFormat('d F Y'),
        };

        $totalTerbuangBar = [];
        $totalTerbuangKitchen = [];

        if ($type === 'year') {
            $totalTerbuangBar = $this->generateTotalTerbuangBySectionYear($startDate, $endDate, 'BAR');
            $totalTerbuangKitchen = $this->generateTotalTerbuangBySectionYear($startDate, $endDate, 'KITCHEN');
        } else {
            $totalTerbuangBar = $this->generateTotalTerbuangBySectionRange($startDate, $endDate, 'BAR');
            $totalTerbuangKitchen = $this->generateTotalTerbuangBySectionRange($startDate, $endDate, 'KITCHEN');
        }

        return view('dashboard.index', [
            'user' => $user,
            'barangs_below_minimum' => $barangs_below_minimum,
            'bahans_below_minimum' => $bahans_below_minimum,
            'totalTerbuangBar' => $totalTerbuangBar,
            'totalTerbuangKitchen' => $totalTerbuangKitchen,
            'periodeLabel' => $periodeLabel,     // << baru
            'type' => $type,                     // << baru
            'dateInput' => $dateInput,          // << baru
        ]);

    }

    private function generateTotalTerbuangBySectionRange(Carbon $startDate, Carbon $endDate, $section)
    {
        $results = [];
        $allHistories = $this->generateAllHistoriesByRange($startDate, $endDate, $section);

        foreach ($allHistories as $item) {
            $total = collect($item['history'])->pluck('terbuang')->filter()->sum();
            $results[] = [
                'id' => $item['bahan']->id,
                'name' => $item['bahan']->name,
                'satuan' => $item['bahan']->satuan->name,
                'total_terbuang' => round($total, 3),
            ];
        }

        return $results;
    }

    private function generateTotalTerbuangBySectionYear(Carbon $startDate, Carbon $endDate, $section)
    {
        $results = [];
        $allHistories = $this->generateAllHistoriesByMonthInYear($startDate, $endDate, $section);

        foreach ($allHistories as $item) {
            $total = collect($item['history'])->flatten(1)->pluck('terbuang')->filter()->sum();
            $results[] = [
                'id' => $item['bahan']->id,
                'name' => $item['bahan']->name,
                'satuan' => $item['bahan']->satuan->name,
                'total_terbuang' => round($total, 3),
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
                $jumlah_akhir = (!is_null($awal)) ? (($awal ?? 0) + ($masuk ?? 0) - $terpakai) : null;
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

    public function detailLossBahan(Request $request, $encryptedId)
    {
        $hashids = new Hashids(env('HASHIDS_SALT', 'cafebdim_Salty'), 32);
        $decoded = $hashids->decode($encryptedId);
        if (empty($decoded)) {
            abort(404, 'ID tidak valid');
        }

        $user = Auth::user();
        $type = $request->input('type', 'month'); // week | month | year
        $dateInput = $request->input('date', Carbon::now()->toDateString());
        $date = Carbon::parse($dateInput);
        $previousUrl = session('previous_dashboard_url', route('bahan.index'));

        $bahanId = $decoded[0];
        $bahan = Bahan::with('satuan')->findOrFail($bahanId);

        // Tentukan range waktu berdasarkan type
        switch ($type) {
            case 'week':
                $startDate = $date->copy()->startOfWeek(Carbon::SUNDAY);
                $endDate = $date->copy()->endOfWeek(Carbon::SATURDAY);
                break;
            case 'month':
                $startDate = $date->copy()->startOfMonth();
                $endDate = $date->copy()->endOfMonth();
                break;
            case 'year':
                $startDate = $date->copy()->startOfYear();
                $endDate = $date->copy()->endOfYear();
                break;
            default:
                $startDate = $date;
                $endDate = $date;
        }

        $periodeLabel = match ($type) {
            'week' => 'Minggu ke ' . $startDate->format('W') . ' (' . $startDate->translatedFormat('j M') . ' - ' . $endDate->translatedFormat('j M Y') . ')',
            'month' => $date->translatedFormat('F Y'),
            'year' => $date->translatedFormat('Y'),
            default => $date->translatedFormat('d F Y'),
        };

        // === type YEAR: Tampilkan per bulan ===
        if ($type === 'year') {
            $monthlyHistories = $this->generateHistoryPerMonthForSingleBahan($bahanId, $startDate, $endDate);
            $totalTerbuang = collect($monthlyHistories)->flatMap(fn($items) => $items)->sum('terbuang');

            return view('dashboard.bahan_loss_detail', [
                'bahan' => $bahan,
                'bahanId' => $bahanId,
                'history' => $monthlyHistories, // isinya: ['Januari' => [...], ...]
                'totalTerbuang' => $totalTerbuang,
                'previousUrl' => $previousUrl,
                'periodeLabel' => $periodeLabel,
                'type' => $type,
                'dateInput' => $dateInput,
            ]);
        }

        // === type WEEK/MONTH ===
        $history = [];
        $prevAkhir = null;
        $currentDate = $startDate->copy();

        while ($currentDate->lte($endDate)) {
            $tanggal = $currentDate->toDateString();

            $awalManual = BahanAwal::where('bahan_id', $bahanId)->whereDate('date', $tanggal)->whereNull('deleted_at')->sum('jumlah');
            $awal = $awalManual > 0 ? $awalManual : $prevAkhir;

            $masuk = BahanMasuk::where('bahan_id', $bahanId)->whereDate('date', $tanggal)->whereNull('deleted_at')->sum('jumlah');

            $terpakai = DB::table('transaksi_details')
                ->join('transaksis', 'transaksi_details.transaksi_id', '=', 'transaksis.id')
                ->where('transaksi_details.bahan_id', $bahanId)
                ->whereDate('transaksis.date', $tanggal)
                ->whereNull('transaksis.deleted_at')
                ->sum('transaksi_details.jumlah');

            $akhir = BahanAkhir::where('bahan_id', $bahanId)->whereDate('date', $tanggal)->whereNull('deleted_at')->value('jumlah');

            $jumlah_akhir = (!is_null($awal)) ? ($awal + $masuk - $terpakai) : null;
            $terbuang = (!is_null($jumlah_akhir) && !is_null($akhir)) ? ($jumlah_akhir - $akhir) : null;

            $history[] = [
                'tanggal' => $tanggal,
                'awal' => round($awal ?? 0, 3),
                'masuk' => round($masuk ?? 0, 3),
                'terpakai' => round($terpakai ?? 0, 3),
                'sisa' => round($jumlah_akhir ?? 0, 3),
                'akhir' => round($akhir ?? 0, 3),
                'terbuang' => round($terbuang ?? 0, 3),
            ];

            $prevAkhir = $akhir ?? $prevAkhir;
            $currentDate->addDay();
        }

        $totalTerbuang = collect($history)->sum('terbuang');

        return view('dashboard.bahan_loss_detail', [
            'bahan' => $bahan,
            'bahanId' => $bahanId,
            'history' => $history,
            'totalTerbuang' => $totalTerbuang,
            'previousUrl' => $previousUrl,
            'periodeLabel' => $periodeLabel,
            'type' => $type,
            'dateInput' => $dateInput,
        ]);
    }

    private function generateHistoryPerMonthForSingleBahan($bahanId, Carbon $startDate, Carbon $endDate)
    {
        $range = CarbonPeriod::create($startDate, $endDate);
        $bahan = Bahan::with('satuan')->findOrFail($bahanId);

        $stokAwalData = BahanAwal::where('bahan_id', $bahanId)
            ->whereBetween('date', [$startDate, $endDate])
            ->whereNull('deleted_at')
            ->selectRaw('DATE(date) as tanggal, SUM(jumlah) as total')
            ->groupBy('tanggal')
            ->pluck('total', 'tanggal');

        $masukData = BahanMasuk::where('bahan_id', $bahanId)
            ->whereBetween('date', [$startDate, $endDate])
            ->whereNull('deleted_at')
            ->selectRaw('DATE(date) as tanggal, SUM(jumlah) as total')
            ->groupBy('tanggal')
            ->pluck('total', 'tanggal');

        $akhirData = BahanAkhir::where('bahan_id', $bahanId)
            ->whereBetween('date', [$startDate, $endDate])
            ->whereNull('deleted_at')
            ->selectRaw('DATE(date) as tanggal, SUM(jumlah) as total')
            ->groupBy('tanggal')
            ->pluck('total', 'tanggal');

        $monthly = [];
        $prevAkhir = null;

        foreach ($range as $date) {
            $tanggal = $date->toDateString();
            $monthName = $date->translatedFormat('F');

            $isTanggalSatu = $date->day === 1;
            if ($isTanggalSatu) {
                $awal = $stokAwalData[$tanggal] ?? null;
            } else {
                $yesterday = $date->copy()->subDay()->toDateString();
                $awal = $akhirData[$yesterday] ?? null;
            }

            $masuk = $masukData[$tanggal] ?? 0;

            $terpakai = DB::table('transaksi_details')
                ->join('transaksis', 'transaksi_details.transaksi_id', '=', 'transaksis.id')
                ->where('transaksi_details.bahan_id', $bahanId)
                ->whereDate('transaksis.date', $tanggal)
                ->whereNull('transaksis.deleted_at')
                ->sum('transaksi_details.jumlah');

            $akhir = $akhirData[$tanggal] ?? null;

            $jumlah_akhir = (!is_null($awal)) ? ($awal + $masuk - $terpakai) : null;
            $terbuang = (!is_null($jumlah_akhir) && !is_null($akhir)) ? ($jumlah_akhir - $akhir) : null;

            $monthly[$monthName][] = [
                'tanggal' => $date->format('Y-m-d'),
                'awal' => round($awal ?? 0, 3),
                'masuk' => round($masuk ?? 0, 3),
                'terpakai' => round($terpakai ?? 0, 3),
                'sisa' => round($jumlah_akhir ?? 0, 3),
                'akhir' => round($akhir ?? 0, 3),
                'terbuang' => round($terbuang ?? 0, 3),
            ];

            $prevAkhir = $akhir ?? $prevAkhir;
        }

        return $monthly;
    }



    private function generateAllHistoriesByRange(Carbon $startDate, Carbon $endDate, $section)
    {
        $range = CarbonPeriod::create($startDate, $endDate);

        $bahans = Bahan::with('satuan')
            ->where('section', $section)
            ->whereNull('deleted_at')
            ->orderBy('name', 'asc')
            ->get();

        $allHistories = [];

        foreach ($bahans as $bahan) {
            $bahanId = $bahan->id;

            // Ambil data awal, masuk, akhir dari DB dalam range
            $stokAwalData = BahanAwal::where('bahan_id', $bahanId)
                ->whereBetween('date', [$startDate, $endDate])
                ->whereNull('deleted_at')
                ->selectRaw('DATE(date) as tanggal, SUM(jumlah) as total')
                ->groupBy('tanggal')
                ->pluck('total', 'tanggal');

            $masukData = BahanMasuk::where('bahan_id', $bahanId)
                ->whereBetween('date', [$startDate, $endDate])
                ->whereNull('deleted_at')
                ->selectRaw('DATE(date) as tanggal, SUM(jumlah) as total')
                ->groupBy('tanggal')
                ->pluck('total', 'tanggal');

            $akhirData = BahanAkhir::where('bahan_id', $bahanId)
                ->whereBetween('date', [$startDate, $endDate])
                ->whereNull('deleted_at')
                ->selectRaw('DATE(date) as tanggal, SUM(jumlah) as total')
                ->groupBy('tanggal')
                ->pluck('total', 'tanggal');

            $history = [];
            $prevAkhir = null;

            foreach ($range as $date) {
                $dateString = $date->toDateString();

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
                    'tanggal' => $date->format('j M'), // atau 'd-m-Y' jika ingin full
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

    private function generateAllHistoriesByMonthInYear(Carbon $startDate, Carbon $endDate, $section)
    {
        $range = CarbonPeriod::create($startDate, $endDate);

        $bahans = Bahan::with('satuan')
            ->where('section', $section)
            ->whereNull('deleted_at')
            ->orderBy('name', 'asc')
            ->get();

        $allHistories = [];

        foreach ($bahans as $bahan) {
            $bahanId = $bahan->id;

            // Preload semua data dalam 1x query (efisien)
            $stokAwalData = BahanAwal::where('bahan_id', $bahanId)
                ->whereBetween('date', [$startDate, $endDate])
                ->whereNull('deleted_at')
                ->selectRaw('DATE(date) as tanggal, SUM(jumlah) as total')
                ->groupBy('tanggal')
                ->pluck('total', 'tanggal');

            $masukData = BahanMasuk::where('bahan_id', $bahanId)
                ->whereBetween('date', [$startDate, $endDate])
                ->whereNull('deleted_at')
                ->selectRaw('DATE(date) as tanggal, SUM(jumlah) as total')
                ->groupBy('tanggal')
                ->pluck('total', 'tanggal');

            $akhirData = BahanAkhir::where('bahan_id', $bahanId)
                ->whereBetween('date', [$startDate, $endDate])
                ->whereNull('deleted_at')
                ->selectRaw('DATE(date) as tanggal, SUM(jumlah) as total')
                ->groupBy('tanggal')
                ->pluck('total', 'tanggal');

            $historyPerMonth = [];
            $prevAkhir = null;

            foreach ($range as $date) {
                $dateString = $date->toDateString();

                $isTanggalSatu = $date->day === 1;

                // Logika awal:
                // tgl 1 = stok awal manual (bisa null)
                // tgl >1 = dari bahan akhir tgl sebelumnya
                $awal = null;
                if ($isTanggalSatu) {
                    $awal = $stokAwalData[$dateString] ?? null;
                } else {
                    $yesterday = $date->copy()->subDay()->toDateString();
                    $awal = $akhirData[$yesterday] ?? null;
                }

                $masuk = $masukData[$dateString] ?? 0;

                $terpakai = DB::table('transaksi_details')
                    ->join('transaksis', 'transaksi_details.transaksi_id', '=', 'transaksis.id')
                    ->where('transaksi_details.bahan_id', $bahanId)
                    ->whereDate('transaksis.date', $dateString)
                    ->whereNull('transaksis.deleted_at')
                    ->sum('transaksi_details.jumlah');

                $akhir = $akhirData[$dateString] ?? null;

                $jumlah_akhir = (!is_null($awal)) ? ($awal + $masuk - $terpakai) : null;
                $terbuang = (!is_null($jumlah_akhir) && !is_null($akhir)) ? ($jumlah_akhir - $akhir) : null;

                $monthName = $date->translatedFormat('F');

                $historyPerMonth[$monthName][] = [
                    'tanggal' => $date->format('j M'),
                    'awal' => $awal,
                    'masuk' => $masuk,
                    'terpakai' => $terpakai,
                    'sisa' => $jumlah_akhir,
                    'akhir' => $akhir,
                    'terbuang' => $terbuang,
                ];
            }

            $allHistories[] = [
                'bahan' => $bahan,
                'history' => $historyPerMonth,
            ];
        }

        return $allHistories;
    }
}

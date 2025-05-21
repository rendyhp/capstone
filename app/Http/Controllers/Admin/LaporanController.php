<?php

namespace App\Http\Controllers\Admin;

use App\Exports\LaporanExport;
use App\Http\Controllers\Controller;
use App\Models\Bahan;
use App\Models\BahanAkhir;
use App\Models\BahanAwal;
use App\Models\BahanMasuk;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $role = $user->role;

        if (!in_array($role, ['OWNER', 'MANAJER'])) {
            abort(403, 'Anda tidak memiliki izin untuk mengakses halaman ini.');
        }

        $dateParam = $request->input('date'); // '2025-05' format

        $allHistories = [];
        $allHistories2 = [];
        $bulanNama = null;
        $tahunNama = null;
        $selectedMonth = null;
        $selectedYear = null;

        if ($dateParam) {
            try {
                $date = Carbon::createFromFormat('Y-m', $dateParam);
                $selectedMonth = $date->month;
                $selectedYear = $date->year;
                $bulanNama = $date->translatedFormat('F');
                $tahunNama = $date->translatedFormat('Y');

                $daysInMonth = $date->daysInMonth;

                $bahans = Bahan::with('satuan')
                    ->whereNull('deleted_at')
                    ->where('section', 'BAR')
                    ->orderBy('name', 'asc')
                    ->get();

                foreach ($bahans as $bahan) {
                    $bahanId = $bahan->id;

                    $stokAwalData = BahanAwal::where('bahan_id', $bahanId)
                        ->whereMonth('date', $selectedMonth)
                        ->whereYear('date', $selectedYear)
                        ->whereNull('deleted_at')
                        ->pluck('jumlah', 'date');

                    $masukData = BahanMasuk::where('bahan_id', $bahanId)
                        ->whereMonth('date', $selectedMonth)
                        ->whereYear('date', $selectedYear)
                        ->whereNull('deleted_at')
                        ->pluck('jumlah', 'date');

                    $akhirData = BahanAkhir::where('bahan_id', $bahanId)
                        ->whereMonth('date', $selectedMonth)
                        ->whereYear('date', $selectedYear)
                        ->whereNull('deleted_at')
                        ->pluck('jumlah', 'date');

                    $history = [];
                    $prevAkhir = null;

                    for ($day = 1; $day <= $daysInMonth; $day++) {
                        $dateString = Carbon::createFromDate($selectedYear, $selectedMonth, $day)->toDateString();

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

                $bahans2 = Bahan::with('satuan')
                    ->whereNull('deleted_at')
                    ->where('section', 'KITCHEN')
                    ->orderBy('name', 'asc')
                    ->get();

                foreach ($bahans2 as $bahan) {
                    $bahanId = $bahan->id;

                    $stokAwalData = BahanAwal::where('bahan_id', $bahanId)
                        ->whereMonth('date', $selectedMonth)
                        ->whereYear('date', $selectedYear)
                        ->whereNull('deleted_at')
                        ->pluck('jumlah', 'date');

                    $masukData = BahanMasuk::where('bahan_id', $bahanId)
                        ->whereMonth('date', $selectedMonth)
                        ->whereYear('date', $selectedYear)
                        ->whereNull('deleted_at')
                        ->pluck('jumlah', 'date');

                    $akhirData = BahanAkhir::where('bahan_id', $bahanId)
                        ->whereMonth('date', $selectedMonth)
                        ->whereYear('date', $selectedYear)
                        ->whereNull('deleted_at')
                        ->pluck('jumlah', 'date');

                    $history = [];
                    $prevAkhir = null;

                    for ($day = 1; $day <= $daysInMonth; $day++) {
                        $dateString = Carbon::createFromDate($selectedYear, $selectedMonth, $day)->toDateString();

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

                    $allHistories2[] = [
                        'bahan' => $bahan,
                        'history' => $history,
                    ];
                }

            } catch (\Exception $e) {
                // Jika format tidak valid, abaikan saja dan jangan tampilkan data
            }
        }

        return view('laporan.index', compact('allHistories', 'allHistories2', 'dateParam', 'bulanNama', 'tahunNama'));
    }

    public function indexLaporanBarang(Request $request){
        
    }

    public function exportExcel(Request $request)
    {
        $month = $request->input('month') ?? now()->month;
        $year = $request->input('year') ?? now()->year;
        $bulanNama = Carbon::create()->month($month)->locale('id')->isoFormat('MMMM');

        $barHistories = $this->generateAllHistories($month, $year, 'BAR');
        $kitchenHistories = $this->generateAllHistories($month, $year, 'KITCHEN');

        return Excel::download(
            new LaporanExport($barHistories, $kitchenHistories, $month, $year),
            "Laporan_Bahan_{$bulanNama}_{$year}.xlsx"
        );
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



}
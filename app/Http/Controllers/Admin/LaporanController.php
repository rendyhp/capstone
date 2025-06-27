<?php

namespace App\Http\Controllers\Admin;

use App\Exports\LaporanExport;
use App\Http\Controllers\Controller;
use App\Models\Bahan;
use App\Models\BahanAkhir;
use App\Models\BahanAwal;
use App\Models\BahanMasuk;
use App\Models\Barang;
use App\Models\BarangAwal;
use App\Models\BarangKeluar;
use App\Models\BarangMasuk;
use App\Models\SatuanBarang;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\SimpleType\Jc;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        if (!in_array($user->role, ['OWNER', 'MANAJER'])) {
            abort(403);
        }

        $type = $request->input('type', 'month'); // default ke bulan
        $dateInput = $request->input('date', now()->toDateString());
        $date = Carbon::parse($dateInput);

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

        if ($type === 'year') {
            $allHistories = $this->generateAllHistoriesByMonthInYear($startDate, $endDate, 'BAR');
            $allHistories2 = $this->generateAllHistoriesByMonthInYear($startDate, $endDate, 'KITCHEN');
        } else {
            $allHistories = $this->generateAllHistoriesByRange($startDate, $endDate, 'BAR');
            $allHistories2 = $this->generateAllHistoriesByRange($startDate, $endDate, 'KITCHEN');
        }

        $periodeLabel = match ($type) {
            'week' => 'Minggu ke ' . $startDate->format('W') . ' (' . $startDate->translatedFormat('j M') . ' - ' . $endDate->translatedFormat('j M Y') . ')',
            'month' => $date->translatedFormat('F Y'),
            'year' => $date->translatedFormat('Y'),
            default => $date->translatedFormat('d F Y'),
        };

        return view('laporan.index', [
            'dateInput' => $dateInput,
            'allHistories' => $allHistories,
            'allHistories2' => $allHistories2,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'type' => $type,
            'periodeLabel' => $periodeLabel,
        ]);
    }

    public function indexLaporanBarang(Request $request)
    {
        $user = Auth::user();
        $role = $user->role;

        if (!in_array($role, ['OWNER', 'MANAJER'])) {
            return abort(403, 'Anda tidak memiliki izin untuk mengakses halaman ini.');
        }

        $query = $this->buildLaporanBarangQuery($request);

        $paginated = $query->paginate(20)->appends($request->query());
        $transformed = $this->transformLaporanBarang($paginated->getCollection());
        $paginated->setCollection($transformed);

        $satuanBarangs = SatuanBarang::orderBy('name', 'asc')->whereNull('deleted_at')->get();

        return view('laporan.indexLaporanBarang', [
            'barangs' => $paginated,
            'satuanBarangs' => $satuanBarangs,
        ]);
    }


    public function exportPdf(Request $request)
    {
        $barangs = $this->buildLaporanBarangQuery($request)->get();
        $barangs = $this->transformLaporanBarang($barangs);

        $pdf = PDF::loadView('laporan.export-pdf', compact('barangs'))
            ->setPaper('a4', 'portrait');
        return $pdf->download('laporan-stok-barang.pdf');
    }


    public function exportWord(Request $request)
    {
        $barangs = $this->buildLaporanBarangQuery($request)->get();
        $barangs = $this->transformLaporanBarang($barangs);

        $phpWord = new PhpWord();
        $section = $phpWord->addSection();

        $section->addText('Laporan Stok Barang', ['bold' => true, 'size' => 14], ['alignment' => 'center']);

        // Tambahkan tabel
        $table = $section->addTable([
            'borderSize' => 6,
            'borderColor' => '999999',
            'cellMargin' => 50,
        ]);

        // Header tabel
        $cellStyle = ['valign' => 'center'];

        $headerCellStyle = ['valign' => 'center'];
        $headerTextStyle = ['bold' => true, 'alignment' => Jc::CENTER];

        $textCentered = ['alignment' => Jc::CENTER];
        $textLeft = ['alignment' => Jc::START];

        // Header
        $table->addRow();
        $table->addCell(500, $headerCellStyle)->addText('No.', $headerTextStyle, $textCentered);
        $table->addCell(2500, $headerCellStyle)->addText('Nama', $headerTextStyle, $textCentered);
        $table->addCell(1000, $headerCellStyle)->addText('Awal', $headerTextStyle, $textCentered);
        $table->addCell(1000, $headerCellStyle)->addText('Masuk', $headerTextStyle, $textCentered);
        $table->addCell(1000, $headerCellStyle)->addText('Total Beli', $headerTextStyle, $textCentered);
        $table->addCell(1000, $headerCellStyle)->addText('Keluar', $headerTextStyle, $textCentered);
        $table->addCell(1000, $headerCellStyle)->addText('Sisa', $headerTextStyle, $textCentered);
        $table->addCell(1000, $headerCellStyle)->addText('Satuan', $headerTextStyle, $textCentered);
        $table->addCell(1500, $headerCellStyle)->addText('Keterangan', $headerTextStyle, $textCentered);

        // Data
        foreach ($barangs as $index => $barang) {
            $table->addRow();
            $table->addCell(500, $cellStyle)->addText($index + 1, null, $textCentered);
            $table->addCell(2500, $cellStyle)->addText($barang->name, null, $textLeft);
            $table->addCell(1000, $cellStyle)->addText($barang->awal, null, $textCentered);
            $table->addCell(1000, $cellStyle)->addText($barang->masuk, null, $textCentered);
            $table->addCell(1000, $cellStyle)->addText($barang->total_beli, null, $textCentered);
            $table->addCell(1000, $cellStyle)->addText($barang->keluar, null, $textCentered);
            $table->addCell(1000, $cellStyle)->addText($barang->sisa, null, $textCentered);
            $table->addCell(1000, $cellStyle)->addText($barang->satuanBarang->name ?? '-', null, $textCentered);
            $table->addCell(1500, $cellStyle)->addText('', null, $textCentered);
        }

        // Simpan ke file sementara
        $filePath = storage_path('app/public/laporan-stok-barang.docx');
        $objWriter = IOFactory::createWriter($phpWord, 'Word2007');
        $objWriter->save($filePath);

        return response()->download($filePath)->deleteFileAfterSend(true);
    }

    public function exportExcel(Request $request)
    {
        $type = $request->input('type', 'month');
        $dateInput = $request->input('date', now()->toDateString());
        $date = Carbon::parse($dateInput);

        // Tentukan rentang tanggal berdasarkan tipe
        switch ($type) {
            case 'week':
                $startDate = $date->copy()->startOfWeek(Carbon::SUNDAY);
                $endDate = $date->copy()->endOfWeek(Carbon::MONDAY);
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

        // Ambil data sesuai jenis laporan
        if ($type === 'year') {
            $barHistories = $this->generateAllHistoriesByMonthInYear($startDate, $endDate, 'BAR');
            $kitchenHistories = $this->generateAllHistoriesByMonthInYear($startDate, $endDate, 'KITCHEN');
        } else {
            $barHistories = $this->generateAllHistoriesByRange($startDate, $endDate, 'BAR');
            $kitchenHistories = $this->generateAllHistoriesByRange($startDate, $endDate, 'KITCHEN');
        }

        // Buat label periode untuk nama file
        $periodeLabel = match ($type) {
            'week' => 'Week_' . $startDate->format('W'),
            'month' => $date->translatedFormat('F_Y'),
            'year' => $date->translatedFormat('Y'),
            default => $date->translatedFormat('d_F_Y'),
        };

        $timestamp = now()->format('Ymd_His');

        return Excel::download(
            new LaporanExport($barHistories, $kitchenHistories, $startDate, $endDate, $periodeLabel),
            "Laporan_Bahan_{$periodeLabel}_{$timestamp}.xlsx"
        );
    }


    private function getLaporanBarangData(Request $request)
    {
        $allowedSortColumns = ['id', 'name', 'stok_awal', 'created_at'];
        $allowedSortDirections = ['asc', 'desc'];

        $orderBy = in_array($request->input('orderBy'), $allowedSortColumns) ? $request->input('orderBy') : 'name';
        $sort = in_array($request->input('sort'), $allowedSortDirections) ? $request->input('sort') : 'asc';

        $query = Barang::with('satuanBarang')
            ->whereNull('deleted_at')
            ->orderBy($orderBy, $sort);

        if ($search = $request->input('search')) {
            $query->where('name', 'like', '%' . $search . '%');
        }

        return $query;
    }

    private function buildLaporanBarangQuery(Request $request)
    {
        $allowedSortColumns = ['id', 'name', 'stok_awal', 'created_at'];
        $allowedSortDirections = ['asc', 'desc'];

        $orderBy = in_array($request->input('orderBy'), $allowedSortColumns) ? $request->input('orderBy') : 'name';
        $sort = in_array($request->input('sort'), $allowedSortDirections) ? $request->input('sort') : 'asc';

        $query = Barang::with('satuanBarang')
            ->whereNull('deleted_at')
            ->orderBy($orderBy, $sort);

        if ($search = $request->input('search')) {
            $query->where('name', 'like', '%' . $search . '%');
        }

        return $query;
    }

    private function transformLaporanBarang($barangs)
    {
        $barangIds = $barangs->pluck('id')->toArray();

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


        $barangs->transform(function ($barang) use ($barangAwals, $barangMasuks, $barangKeluars) {
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

        return $barangs;
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
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
        $role = $user->role;

        if (!in_array($role, ['OWNER', 'MANAJER'])) {
            abort(403, 'Anda tidak memiliki izin untuk mengakses halaman ini.');
        }

        $dateParam = $request->input('date'); // format '2025-05'

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

                    $stokAwalData = BahanAwal::select(DB::raw('DATE(date) as tanggal'), DB::raw('SUM(jumlah) as total'))
                        ->where('bahan_id', $bahanId)
                        ->whereMonth('date', $selectedMonth)
                        ->whereYear('date', $selectedYear)
                        ->whereNull('deleted_at')
                        ->groupBy(DB::raw('DATE(date)'))
                        ->pluck('total', 'tanggal');

                    $masukData = BahanMasuk::select(DB::raw('DATE(date) as tanggal'), DB::raw('SUM(jumlah) as total'))
                        ->where('bahan_id', $bahanId)
                        ->whereMonth('date', $selectedMonth)
                        ->whereYear('date', $selectedYear)
                        ->whereNull('deleted_at')
                        ->groupBy(DB::raw('DATE(date)'))
                        ->pluck('total', 'tanggal');

                    $akhirData = BahanAkhir::select(DB::raw('DATE(date) as tanggal'), DB::raw('SUM(jumlah) as total'))
                        ->where('bahan_id', $bahanId)
                        ->whereMonth('date', $selectedMonth)
                        ->whereYear('date', $selectedYear)
                        ->whereNull('deleted_at')
                        ->groupBy(DB::raw('DATE(date)'))
                        ->pluck('total', 'tanggal');


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
            }
        }

        return view('laporan.index', compact('allHistories', 'allHistories2', 'dateParam', 'bulanNama', 'tahunNama'));
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
}
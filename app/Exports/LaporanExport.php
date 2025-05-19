<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithStyles;

class LaporanExport implements FromView, WithColumnWidths, WithEvents, WithStyles
{
    protected $allHistories;
    protected $month;
    protected $year;

    public function __construct($allHistories, $month, $year)
    {
        $this->allHistories = $allHistories;
        $this->month = $month;
        $this->year = $year;
    }

    public function view(): View
    {
        return view('laporan.excel', [
            'allHistories' => $this->allHistories,
            'month' => $this->month,
            'year' => $this->year,
        ]);
    }

    public function columnWidths(): array
    {
        $daysInMonth = \Carbon\Carbon::create($this->year, $this->month, 1)->daysInMonth;

        $widths = [];
        $widths['A'] = 30; // kolom nama bahan

        // Kolom harian (B, C, D, ..., sesuai jumlah hari)
        for ($i = 1; $i <= $daysInMonth; $i++) {
            $col = Coordinate::stringFromColumnIndex($i + 1);
            $widths[$col] = 14;
        }

        // Kolom total (setelah kolom harian)
        $totalCol = Coordinate::stringFromColumnIndex($daysInMonth + 3);
        $widths[$totalCol] = 30;

        return $widths;
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                $highestRow = $sheet->getHighestRow();
                $highestColumnIndex = Coordinate::columnIndexFromString($sheet->getHighestColumn());

                for ($row = 1; $row <= $highestRow; $row++) {
                    $firstCellValue = $sheet->getCellByColumnAndRow(1, $row)->getValue();

                    for ($col = 1; $col <= $highestColumnIndex; $col++) {
                        $cell = $sheet->getCellByColumnAndRow($col, $row);
                        $value = $cell->getValue();

                        if ($value !== null && $value !== '') {
                            $coordinate = $cell->getCoordinate();

                            // Apply border
                            $sheet->getStyle($coordinate)->applyFromArray([
                                'borders' => [
                                    'allBorders' => [
                                        'borderStyle' => Border::BORDER_THIN,
                                        'color' => ['argb' => 'FF000000'],
                                    ],
                                ],
                            ]);

                            // Fill for "Awal" to "Sisa" section
                            if (in_array($firstCellValue, ['Awal', 'Masuk', 'Terpakai', 'Sisa'])) {
                                $sheet->getStyle($coordinate)->getFill()->setFillType(Fill::FILL_SOLID)
                                    ->getStartColor()->setARGB('FFF9F2CC'); // light yellow
                            }

                            // Fill for "Akhir" to "Terbuang" section
                            if (in_array($firstCellValue, ['Akhir', 'Terbuang'])) {
                                $sheet->getStyle($coordinate)->getFill()->setFillType(Fill::FILL_SOLID)
                                    ->getStartColor()->setARGB('FFE2EFDA'); // light green
                            }

                            // Fill for nomor + nama bahan (baris yang diawali dengan angka dan titik, misal "1. ")
                            if (preg_match('/^\d+\./', $firstCellValue)) {
                                $sheet->getStyle($coordinate)->getFill()->setFillType(Fill::FILL_SOLID)
                                    ->getStartColor()->setARGB('FFD9E1F2'); // light blue
                            }
                        }
                    }
                }
            },
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $daysInMonth = \Carbon\Carbon::create($this->year, $this->month, 1)->daysInMonth;
        $startColIndex = 2;
        $endColIndex = $daysInMonth + 2; // kolom total

        for ($colIndex = $startColIndex; $colIndex <= $endColIndex; $colIndex++) {
            $colLetter = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIndex);

            for ($row = 3; $row <= 100; $row++) {
                $cell = $colLetter . $row;
                $sheet->getStyle($cell)->getNumberFormat()->setFormatCode('#,##0'); // pakai format internasional
            }
        }


        $highestRow = $sheet->getHighestRow();
        $totalColIndex = $daysInMonth + 3; // kalau memang memang mau pakai +3
        $totalCol = Coordinate::stringFromColumnIndex($totalColIndex);

        $range = $totalCol . '3:' . $totalCol . $highestRow; // contoh: AG3:AG100

        $sheet->getStyle($range)->getNumberFormat()->setFormatCode('#,##0');



        // Kalau tidak perlu style global lain, return kosong
        return [];
    }
}

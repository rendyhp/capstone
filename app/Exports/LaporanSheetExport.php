<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithEvents;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Events\AfterSheet;

class LaporanSheetExport implements FromView, WithTitle, WithColumnWidths, WithEvents, WithStyles
{
    protected $allHistories;
    protected $month;
    protected $year;
    protected $sectionName;

    public function __construct($allHistories, $month, $year, $sectionName)
    {
        $this->allHistories = $allHistories;
        $this->month = $month;
        $this->year = $year;
        $this->sectionName = $sectionName;
    }

    public function view(): View
    {
        return view('laporan.excel', [
            'allHistories' => $this->allHistories,
            'month' => $this->month,
            'year' => $this->year,
        ]);
    }

    public function title(): string
    {
        return $this->sectionName;
    }

    public function columnWidths(): array
    {
        $daysInMonth = \Carbon\Carbon::create($this->year, $this->month, 1)->daysInMonth;

        $widths = ['A' => 30];
        for ($i = 1; $i <= $daysInMonth; $i++) {
            $col = Coordinate::stringFromColumnIndex($i + 1);
            $widths[$col] = 14;
        }

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

                $daysInMonth = \Carbon\Carbon::create($this->year, $this->month, 1)->daysInMonth; // ✅ Tambahkan ini
    
                for ($row = 1; $row <= $highestRow; $row++) {
                    $firstCellValue = $sheet->getCellByColumnAndRow(1, $row)->getValue();
                    for ($col = 1; $col <= $highestColumnIndex; $col++) {
                        $cell = $sheet->getCellByColumnAndRow($col, $row);
                        $value = $cell->getValue();

                        if ($value !== null && $value !== '') {
                            $coordinate = $cell->getCoordinate();

                            $sheet->getStyle($coordinate)->applyFromArray([
                                'borders' => [
                                    'allBorders' => [
                                        'borderStyle' => Border::BORDER_THIN,
                                        'color' => ['argb' => 'FF000000'],
                                    ],
                                ],
                            ]);

                            if (in_array($firstCellValue, ['Awal', 'Masuk', 'Terpakai', 'Sisa'])) {
                                $sheet->getStyle($coordinate)->getFill()->setFillType(Fill::FILL_SOLID)
                                    ->getStartColor()->setARGB('FFF9F2CC');
                            }

                            if (in_array($firstCellValue, ['Akhir', 'Terbuang'])) {
                                $sheet->getStyle($coordinate)->getFill()->setFillType(Fill::FILL_SOLID)
                                    ->getStartColor()->setARGB('FFE2EFDA');
                            }

                            if (preg_match('/^\d+\./', $firstCellValue)) {
                                $sheet->getStyle($coordinate)->getFill()->setFillType(Fill::FILL_SOLID)
                                    ->getStartColor()->setARGB('FFD9E1F2');
                            }
                        }
                    }
                }
                for ($row = 1; $row <= $highestRow; $row++) {
                    $firstCellValue = $sheet->getCellByColumnAndRow(1, $row)->getValue();

                    // Tambahkan formula hanya untuk baris Masuk, Terpakai, dan Terbuang
                    if (in_array($firstCellValue, ['Masuk', 'Terpakai', 'Terbuang'])) {
                        $startCol = Coordinate::stringFromColumnIndex(2);
                        $endCol = Coordinate::stringFromColumnIndex($daysInMonth + 1);
                        $totalCol = Coordinate::stringFromColumnIndex($daysInMonth + 3);
                        $sumFormula = "=SUM({$startCol}{$row}:{$endCol}{$row})";
                        $sheet->setCellValue("{$totalCol}{$row}", $sumFormula);
                    }
                }

            },
        ];
    }


    public function styles(Worksheet $sheet)
    {
        $daysInMonth = \Carbon\Carbon::create($this->year, $this->month, 1)->daysInMonth;
        $startColIndex = 2;
        $endColIndex = $daysInMonth + 2;

        for ($colIndex = $startColIndex; $colIndex <= $endColIndex; $colIndex++) {
            $colLetter = Coordinate::stringFromColumnIndex($colIndex);
            for ($row = 3; $row <= 100; $row++) {
                $cell = $colLetter . $row;
                $sheet->getStyle($cell)->getNumberFormat()->setFormatCode('#,##0');
            }
        }

        $highestRow = $sheet->getHighestRow();
        $totalColIndex = $daysInMonth + 3;
        $totalCol = Coordinate::stringFromColumnIndex($totalColIndex);
        $range = $totalCol . '3:' . $totalCol . $highestRow;
        $sheet->getStyle($range)->getNumberFormat()->setFormatCode('#,##0');

        return [];
    }
}

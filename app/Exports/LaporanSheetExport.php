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
use Carbon\CarbonPeriod;

class LaporanSheetExport implements FromView, WithTitle, WithColumnWidths, WithEvents, WithStyles
{
    protected $allHistories;
    protected $startDate;
    protected $endDate;
    protected $periodeLabel;
    protected $sectionName;

    public function __construct($allHistories, $startDate, $endDate, $periodeLabel, $sectionName)
    {
        $this->allHistories = $allHistories;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->periodeLabel = $periodeLabel;
        $this->sectionName = $sectionName;
    }

    public function view(): View
    {
        return view('laporan.excel', [
            'allHistories' => $this->allHistories,
            'startDate' => $this->startDate,
            'endDate' => $this->endDate,
            'periodeLabel' => $this->periodeLabel,
            'section' => $this->sectionName
        ]);
    }

    public function title(): string
    {
        return $this->sectionName;
    }

    public function columnWidths(): array
    {
        $isYear = $this->startDate->format('Y-m-d') === \Carbon\Carbon::create($this->startDate->year, 1, 1)->format('Y-m-d') &&
            $this->endDate->format('Y-m-d') === \Carbon\Carbon::create($this->endDate->year, 12, 31)->format('Y-m-d');


        $widths = ['A' => 30];

        if ($isYear) {
            // 12 kolom untuk bulan
            for ($i = 1; $i <= 12; $i++) {
                $col = Coordinate::stringFromColumnIndex($i + 1);
                $widths[$col] = 14;
            }
            $totalCol = Coordinate::stringFromColumnIndex(15); // 12 bulan + 2 (judul + kosong) + 1 (total)
        } else {
            // Rentang harian biasa
            $range = CarbonPeriod::create($this->startDate, $this->endDate);
            $daysCount = iterator_count($range);

            for ($i = 1; $i <= $daysCount; $i++) {
                $col = Coordinate::stringFromColumnIndex($i + 1);
                $widths[$col] = 14;
            }
            $totalCol = Coordinate::stringFromColumnIndex($daysCount + 3);
        }

        $widths[$totalCol] = 30;

        return $widths;
    }


    public function registerEvents(): array
    {
        return [
            \Maatwebsite\Excel\Events\AfterSheet::class => function (\Maatwebsite\Excel\Events\AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                $highestRow = $sheet->getHighestRow();
                $highestColumnIndex = Coordinate::columnIndexFromString($sheet->getHighestColumn());

                $range = CarbonPeriod::create($this->startDate, $this->endDate);
                $daysCount = iterator_count($range);

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

                    // Formula untuk baris tertentu
                    if (in_array($firstCellValue, ['Masuk', 'Terpakai', 'Terbuang'])) {
                        $startCol = Coordinate::stringFromColumnIndex(2);
                        $endCol = Coordinate::stringFromColumnIndex($daysCount + 1);
                        $totalCol = Coordinate::stringFromColumnIndex($daysCount + 3);
                        $sumFormula = "=SUM({$startCol}{$row}:{$endCol}{$row})";
                        $sheet->setCellValue("{$totalCol}{$row}", $sumFormula);
                    }
                }
            },
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $range = CarbonPeriod::create($this->startDate, $this->endDate);
        $daysCount = iterator_count($range);

        $startColIndex = 2;
        $endColIndex = $daysCount + 2;

        for ($colIndex = $startColIndex; $colIndex <= $endColIndex; $colIndex++) {
            $colLetter = Coordinate::stringFromColumnIndex($colIndex);
            for ($row = 3; $row <= 100; $row++) {
                $cell = $colLetter . $row;
                $sheet->getStyle($cell)->getNumberFormat()->setFormatCode('#,##0');
            }
        }

        $highestRow = $sheet->getHighestRow();
        $totalColIndex = $daysCount + 3;
        $totalCol = Coordinate::stringFromColumnIndex($totalColIndex);
        $rangeTotal = $totalCol . '3:' . $totalCol . $highestRow;
        $sheet->getStyle($rangeTotal)->getNumberFormat()->setFormatCode('#,##0');

        return [];
    }
}

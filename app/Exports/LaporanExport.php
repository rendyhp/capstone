<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithColumnWidths;

class LaporanExport implements FromView, WithColumnWidths
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

        // Kolom A (nomor + nama bahan)
        $widths['A'] = 30; // Lebar bisa kamu sesuaikan

        // Kolom B sampai (B + daysInMonth -1)
        for ($i = 1; $i <= $daysInMonth; $i++) {
            // misal kolom B = 'B', kolom C = 'C', dst
            $col = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($i + 1);
            $widths[$col] = 14; // sesuaikan lebar 14 (atau angka lain)
        }

        return $widths;
    }
}

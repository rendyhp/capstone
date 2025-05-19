<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class LaporanExport implements WithMultipleSheets
{
    protected $barHistories;
    protected $kitchenHistories;
    protected $month;
    protected $year;

    public function __construct($barHistories, $kitchenHistories, $month, $year)
    {
        $this->barHistories = $barHistories;
        $this->kitchenHistories = $kitchenHistories;
        $this->month = $month;
        $this->year = $year;
    }

    public function sheets(): array
    {
        return [
            new LaporanSheetExport($this->barHistories, $this->month, $this->year, 'BAR'),
            new LaporanSheetExport($this->kitchenHistories, $this->month, $this->year, 'KITCHEN'),
        ];
    }
}

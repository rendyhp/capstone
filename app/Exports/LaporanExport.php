<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class LaporanExport implements WithMultipleSheets
{
    protected $barHistories;
    protected $kitchenHistories;
    protected $startDate;
    protected $endDate;
    protected $periodeLabel;

    public function __construct($barHistories, $kitchenHistories, $startDate, $endDate, $periodeLabel)
    {
        $this->barHistories = $barHistories;
        $this->kitchenHistories = $kitchenHistories;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->periodeLabel = $periodeLabel;
    }

    public function sheets(): array
    {
        return [
            new LaporanSheetExport($this->barHistories, $this->startDate, $this->endDate, $this->periodeLabel, 'BAR'),
            new LaporanSheetExport($this->kitchenHistories, $this->startDate, $this->endDate, $this->periodeLabel, 'KITCHEN'),
        ];
    }
}


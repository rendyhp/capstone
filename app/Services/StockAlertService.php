<?php

namespace App\Services;

use App\Models\StockAlertLog;
use App\Http\Controllers\MessageController;
use Illuminate\Support\Collection;
use Carbon\Carbon;

class StockAlertService
{
    protected $messageService;

    public function __construct()
    {
        $this->messageService = new MessageController();
    }

    public function checkAndNotify(Collection $barangs, Collection $bahans)
    {
        $barangs_below_min = $barangs->filter(fn($item) => $item->sisa < $item->minimum);
        $bahans_below_min = $bahans->filter(fn($item) => $item->jumlah_akhir < $item->minimum);

        if ($barangs_below_min->isEmpty() && $bahans_below_min->isEmpty()) {
            return;
        }

        // Format pesan satu kali untuk semua
        $message = $this->messageService->formatStockMinimumMessage($barangs_below_min, $bahans_below_min);

        $notified = false;

        foreach ($barangs_below_min as $item) {
            $alreadyNotified = StockAlertLog::where('stockable_id', $item->id)
                ->where('stockable_type', get_class($item))
                ->whereDate('alert_date', Carbon::today())
                ->exists();

            if (!$alreadyNotified) {
                $this->logAlert($item);
                $notified = true;
            }
        }

        foreach ($bahans_below_min as $item) {
            $alreadyNotified = StockAlertLog::where('stockable_id', $item->id)
                ->where('stockable_type', get_class($item))
                ->whereDate('alert_date', Carbon::today())
                ->exists();

            if (!$alreadyNotified) {
                $this->logAlert($item);
                $notified = true;
            }
        }

        if ($notified) {
            $this->messageService->sendWhatsAppToOwnerManager($message);
        }
    }

    protected function logAlert($item)
    {
        StockAlertLog::create([
            'stockable_id' => $item->id,
            'stockable_type' => get_class($item),
            'alert_date' => Carbon::today(),
        ]);
    }
}

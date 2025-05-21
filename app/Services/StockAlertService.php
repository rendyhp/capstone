<?php

namespace App\Services;

use App\Models\StockAlertLog;
use App\Models\User;
use Illuminate\Support\Facades\Http;

class StockAlertService
{
    public function checkAndNotify($barangData = null, $bahanData = null)
    {
        $today = now()->toDateString();

        $barangData = $barangData ?: collect();
        $bahanData = $bahanData ?: collect();

        $barangMinimum = $barangData->filter(function ($b) use ($today) {
            return $b->sisa < $b->minimum &&
                !StockAlertLog::where('stockable_id', $b->id)
                    ->where('stockable_type', 'App\Models\Barang')
                    ->where('alert_date', $today)
                    ->exists();
        });

        $bahanMinimum = $bahanData->filter(function ($b) use ($today) {
            return $b->jumlah_akhir < $b->minimum &&
                !StockAlertLog::where('stockable_id', $b->id)
                    ->where('stockable_type', 'App\Models\Bahan')
                    ->where('alert_date', $today)
                    ->exists();
        });

        if ($barangMinimum->isEmpty() && $bahanMinimum->isEmpty()) {
            return;
        }

        $message = "*⚠️ Notifikasi Stok Menipis*\n\n";

        if ($barangMinimum->isNotEmpty()) {
            $message .= "*Barang:*\n";
            foreach ($barangMinimum as $b) {
                $message .= "- {$b->name}: {$b->sisa} {$b->satuanBarang->name}, min: {$b->minimum}\n";
                StockAlertLog::create([
                    'stockable_id' => $b->id,
                    'stockable_type' => 'App\Models\Barang',
                    'alert_date' => $today,
                ]);
            }
        }

        if ($bahanMinimum->isNotEmpty()) {
            $message .= "\n*Bahan:*\n";
            foreach ($bahanMinimum as $b) {
                $message .= "- {$b->name}: {$b->jumlah_akhir} {$b->satuan->name}, min: {$b->minimum}\n";
                StockAlertLog::create([
                    'stockable_id' => $b->id,
                    'stockable_type' => 'App\Models\Bahan',
                    'alert_date' => $today,
                ]);
            }
        }

        $users = User::whereIn('role', ['OWNER', 'MANAJER'])
            ->whereNotNull('wa_api_token')
            ->with('profile')
            ->get();

        foreach ($users as $user) {
            $phone = $user->profile->phone ?? $user->phone;
            if ($phone) {
                $this->sendWhatsApp($phone, $message);
            }
        }
    }


    public function sendDailyReport($ringkasan)
    {
        $message = "*📊 Laporan Stok Harian – " . now()->format('d M Y') . "*\n\n";

        foreach ($ringkasan as $kategori => $data) {
            $message .= strtoupper($kategori) . ":\n";
            foreach ($data as $nama => $jumlah) {
                $message .= "- $nama: $jumlah\n";
            }
            $message .= "\n";
        }

        $users = User::whereIn('role', ['OWNER', 'MANAJER'])
            ->whereNotNull('wa_api_token')
            ->with('profile')
            ->get();
        foreach ($users as $user) {
            $this->sendWhatsApp($user->phone, $message);
        }
    }

    protected function sendWhatsApp($phone, $message)
    {
        $users = User::whereIn('role', ['OWNER', 'MANAJER'])
            ->whereNotNull('wa_api_token')
            ->with('profile')
            ->get();

        foreach ($users as $user) {
            $token = $user->wa_api_token;
            $phone = $user->profile->phone ?? null;

            if (!$phone)
                continue;

            $response = Http::withHeaders([
                'Authorization' => $token,
            ])->post('https://api.fonnte.com/send', [
                        'target' => $phone,
                        'message' => $message,
                    ]);

            if (!$response->successful()) {
                \Log::error('Gagal kirim WA ke ' . $phone . ': ' . $response->body());
            }
        }

    }
}
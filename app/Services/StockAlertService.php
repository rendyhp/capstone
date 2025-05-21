<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Http;

class StockAlertService
{
    public function checkAndNotify($barangData, $bahanData)
    {
        $barangMinimum = $barangData->filter(fn($b) => $b->sisa < $b->minimum);
        $bahanMinimum = $bahanData->filter(fn($b) => $b->jumlah_akhir < $b->minimum);

        if ($barangMinimum->isEmpty() && $bahanMinimum->isEmpty())
            return;

        $message = "*⚠️ Notifikasi Stok Menipis*\n\n";

        if ($barangMinimum->isNotEmpty()) {
            $message .= "*Barang:*\n";
            foreach ($barangMinimum as $b) {
                $message .= "- {$b->name}: {$b->sisa} {$b->satuanBarang->name}, min: {$b->minimum}\n";
            }
        }

        if ($bahanMinimum->isNotEmpty()) {
            $message .= "\n*Bahan:*\n";
            foreach ($bahanMinimum as $b) {
                $message .= "- {$b->name}: {$b->jumlah_akhir} {$b->satuan->name}, min: {$b->minimum}\n";
            }
        }

        // Kirim ke semua STAF
        $staffs = User::where('role', 'STAF')->get();
        foreach ($staffs as $staff) {
            $this->sendWhatsApp($staff->wa_api_token, $message);
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

        // Kirim ke OWNER dan MANAJER
        $penerimas = User::whereIn('role', ['OWNER', 'MANAJER'])->get();
        foreach ($penerimas as $user) {
            $this->sendWhatsApp($user->wa_api_token, $message);
        }
    }

    protected function sendWhatsApp($wa_token, $message)
    {
        // Contoh API ke Fonte
        if (!$wa_token)
            return;

        Http::withToken($wa_token)->post('https://fonte.example/send-message', [
            'message' => $message,
        ]);
    }
}

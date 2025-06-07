<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Http;

class StockAlertService
{
    public function checkAndNotify($barangData = null)
    {
        $today = now()->toDateString();

        $barangData = $barangData ?: collect();

        $barangMinimum = $barangData->filter(function ($b) use ($today) {
            return $b->sisa < $b->minimum &&
                $b->total_sebelumnya >= $b->minimum;
        });

        if ($barangMinimum->isEmpty()) {
            return;
        }

        $message = "*🔴❗ Notifikasi Barang Menipis*\n\n";

        if ($barangMinimum->isNotEmpty()) {
            $message .= "*Barang:*\n";
            foreach ($barangMinimum as $b) {
                $message .= "- {$b->name}: {$b->sisa} {$b->satuanBarang->name}, minimal: {$b->minimum} {$b->satuanBarang->name}, _sebelumnya: {$b->total_sebelumnya} {$b->satuanBarang->name}_\n";
            }
        }

        // Ambil semua user yang perlu dikirimi WA
        $users = User::whereIn('role', ['OWNER', 'MANAJER'])
            ->whereNotNull('wa_api_token')
            ->with('profile')
            ->get();

        foreach ($users as $user) {
            $phone = $user->profile->phone ?? $user->phone;
            $token = $user->wa_api_token;

            if ($phone && $token) {
                \Log::info("Mengirim WA ke $phone");
                $this->sendWhatsApp($phone, $token, $message);
            }
        }
    }

    public function checkAndNotify2($bahanData = null)
    {
        $today = now()->toDateString();
        $bahanData = $bahanData ?: collect();

        $bahanMinimum = $bahanData->filter(function ($b) use ($today) {
            return $b->jumlah_akhir < $b->minimum &&
                $b->sisa_sebelumnya >= $b->minimum;
        });

        if ($bahanMinimum->isEmpty()) {
            return;
        }

        $message = "*⚠️ Notifikasi Bahan Menipis*\n\n";

        if ($bahanMinimum->isNotEmpty()) {
            $message .= "*Bahan:*\n";
            foreach ($bahanMinimum as $b) {
                $message .= "- {$b->name}: " . $this->formatNumber($b->jumlah_akhir) . " {$b->satuan->name}, minimal: " . $this->formatNumber($b->minimum) . " {$b->satuan->name}, _sebelumnya: ". $this->formatNumber($b->sisa_sebelumnya) . " {$b->satuan->name}_\n";
            }
        }

        // Ambil semua user yang perlu dikirimi WA
        $users = User::whereIn('role', ['OWNER', 'MANAJER'])
            ->whereNotNull('wa_api_token')
            ->with('profile')
            ->get();

        foreach ($users as $user) {
            $phone = $user->profile->phone ?? $user->phone;
            $token = $user->wa_api_token;

            if ($phone && $token) {
                \Log::info("Mengirim WA ke $phone");
                $this->sendWhatsApp($phone, $token, $message);
            }
        }
    }

    public function checkAndNotify3($bahanData = null)
    {
        $today = now()->toDateString();
        $bahanData = $bahanData ?: collect();

        $bahanMinimum = $bahanData->filter(function ($b) use ($today) {
            return $b->akhir_sebenarnya &&
                $b->jumlah_akhir >= $b->minimum &&
                $b->akhir_sebenarnya->jumlah < $b->minimum;
        });

        if ($bahanMinimum->isEmpty()) {
            return;
        }

        $message = "*⚠️ Notifikasi Bahan Menipis*\n\n";
        $message .= "*Bahan:*\n";

        foreach ($bahanMinimum as $b) {
            $message .= "- {$b->name}: " . $this->formatNumber($b->akhir_sebenarnya->jumlah) . " {$b->satuan->name}, minimal: " . $this->formatNumber($b->minimum) . " {$b->satuan->name}, _sebelumnya: ". $this->formatNumber($b->jumlah_akhir) . " {$b->satuan->name}_\n";
        }

        $users = User::whereIn('role', ['OWNER', 'MANAJER'])
            ->whereNotNull('wa_api_token')
            ->with('profile')
            ->get();

        foreach ($users as $user) {
            $phone = $user->profile->phone ?? $user->phone;
            $token = $user->wa_api_token;

            if ($phone && $token) {
                \Log::info("Mengirim WA ke $phone");
                $this->sendWhatsApp($phone, $token, $message);
            }
        }
    }


    private function formatNumber($number)
    {
        return number_format($number, 0, ',', '.');
    }

    protected function sendWhatsApp($phone, $token, $message)
    {
        $response = Http::withHeaders([
            'Authorization' => $token,
        ])->post('https://api.fonnte.com/send', [
                    'target' => $phone,
                    'message' => $message,
                ]);

        if (!$response->successful()) {
            \Log::error("Gagal kirim WA ke $phone: " . $response->body());
        } else {
            \Log::info("Berhasil kirim WA ke $phone");
        }
    }
}
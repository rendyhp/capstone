<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;


use Http;
use App\Models\User;

class MessageController extends Controller
{
    public function sendWhatsAppToOwnerManager($text)
    {
        $recipients = User::whereIn('role', ['OWNER', 'MANAJER'])
            ->join('user_settings', 'users.id', '=', 'user_settings.user_id')
            ->whereNotNull('user_settings.fontee_token')
            ->whereNotNull('user_settings.fontee_instance_id')
            ->get();

        foreach ($recipients as $user) {
            Http::withToken($user->fontee_token)->post('https://app.fontee.id/api/send-message', [
                'instance_id' => $user->fontee_instance_id,
                'receiver' => $user->whatsapp_number,
                'message' => $text,
            ]);
        }
    }

    public function formatStockMinimumMessage($barangs, $bahans)
    {
        $message = "[PERINGATAN STOK MINIMUM]\n\n";

        if ($barangs->count()) {
            $message .= "📦 BARANG:\n";
            foreach ($barangs as $barang) {
                $satuan = $barang->satuanBarang->nama ?? '-';
                $message .= "- {$barang->name} | Sisa: {$barang->sisa} {$satuan} (Min: {$barang->minimum})\n";
            }
            $message .= "\n";
        }

        if ($bahans->count()) {
            $message .= "🍴 BAHAN:\n";
            foreach ($bahans as $bahan) {
                $satuan = $bahan->satuan->nama ?? '-';
                $section = strtoupper($bahan->section ?? '-');
                $message .= "- {$bahan->name} ({$section}) | Sisa: {$bahan->jumlah_akhir} {$satuan} (Min: {$bahan->minimum})\n";
            }
        }

        return $message;
    }

}

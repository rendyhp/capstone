<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\User;

class ReportController extends Controller
{
    public function send(Request $request)
    {
        $request->validate([
            'kategori' => 'required|string',
            'alasan' => 'required|string',
            'keterangan' => 'required|string|max:1000',
        ]);

        $kategori = $request->kategori === 'Lainnya' ? $request->kategori_lainnya : $request->kategori;
        $alasan = $request->alasan === 'Lainnya' ? $request->alasan_lainnya : $request->alasan;
        $keterangan = $request->keterangan;
        $sender = auth()->user()->name;

        $template = <<<EOT
                    *Lapor*  : {$kategori}
                    *Alasan* : {$alasan}
                    *Pesan*  : {$keterangan}

                    _- Dikirim oleh:_ {$sender}
                    EOT;

        // Kirim ke OWNER dan MANAJER yang punya WA API Token
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
                        'message' => $template,
                    ]);

            if (!$response->successful()) {
                \Log::error('Gagal kirim WA ke ' . $phone . ': ' . $response->body());
            }
        }

        return back()->with('success', 'Laporan berhasil dikirim ke admin.');
    }
}

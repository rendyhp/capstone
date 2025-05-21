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
        $users = User::whereNotNull('wa_api_token')->with('profile')->get();

        foreach ($users as $user) {
            $token = $user->wa_api_token;
            $phone = $user->profile->phone ?? null;

            if (!$phone)
                continue; // skip jika tidak ada nomor

            $message = 'Pesan berhasil dikirim.';

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

        return back()->with('success', 'Pesan berhasil dikirim ke semua user.');
    }


}

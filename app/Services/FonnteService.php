<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class FonnteService
{
    protected $accountToken;

    public function __construct()
    {
        $this->accountToken = config('services.fonnte.account_token');
    }

    public function getDevices()
    {
        $response = Http::withHeaders([
            'Authorization' => $this->accountToken,
        ])->post('https://api.fonnte.com/device');

        dd($response->status(), $response->body());
        return $response->json();
    }

    public function requestQRActivation($deviceNumber, $token)
    {
        $response = Http::withHeaders([
            'Authorization' => $token,
        ])->get("https://api.fonnte.com/device");

        return $response->json();
    }

    public function getDeviceProfile($token)
    {
        $response = Http::withHeaders([
            'Authorization' => $token,
        ])->get('https://api.fonnte.com/profile');

        return $response->json();
    }

    public function disconnectDevice($token)
    {
        return Http::withHeaders([
            'Authorization' => $token,
        ])->post('https://api.fonnte.com/disconnect')->json();
    }

    public function sendWhatsAppMessage($target, $message, $token)
    {
        $response = Http::withHeaders([
            'Authorization' => $token,
        ])->asForm()->post('https://api.fonnte.com/send', [
                    'target' => $target,
                    'message' => $message,
                ]);

        return $response->json();
    }

    public function requestOTPForDeleteDevice($token)
    {
        return Http::withHeaders([
            'Authorization' => $token,
        ])->post('https://api.fonnte.com/device-otp')->json();
    }

    public function submitOTPForDeleteDevice($otp, $token)
    {
        return Http::withHeaders([
            'Authorization' => $token,
        ])->asForm()->post('https://api.fonnte.com/delete-device', [
                    'otp' => $otp,
                ])->json();
    }
}

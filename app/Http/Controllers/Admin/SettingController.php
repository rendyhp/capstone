<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SetApiToken;
use App\Services\FonnteService;
use Auth;
use Hash;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    protected $fonnteService;

    public function __construct(FonnteService $fonnteService)
    {
        $this->fonnteService = $fonnteService;
    }

    public function index()
    {
        $user = auth()->user();
        $profile = $user->profile; // relasi: user hasOne UserProfile
        $settings = $user->settings; // relasi: user hasOne UserSetting

        return view('setting.index', compact('user', 'profile', 'settings'));
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        $user->update([
            'name' => $request->name,
            'wa_api_token' => $request->wa_api_token,
        ]);

        $user->profile()->updateOrCreate(
            ['user_id' => $user->id],
            [
                'phone' => '62' . ltrim($request->phone, '0'), // hilangkan 0 jika user input 0812...
                'address' => $request->address,
                'birth_date' => $request->birth_date,
                'gender' => $request->gender
            ]
        );

        return back()->with('success', 'Profil berhasil diperbarui.');
    }

    public function indexPassword()
    {
        return view('setting.password');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|string|min:8|max:20|confirmed',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->with('error', 'Password lama tidak sesuai.');
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return back()->with('success', 'Password berhasil diperbarui.');
    }

    public function indexNotifikasiApi()
    {
        $user = auth()->user()->load('profile');
        return view('setting.notifapi', [
            'user' => $user,
        ]);
    }

    public function disconnectNotifikasiApi(Request $request)
    {
        $user = Auth::user();

        if (!in_array($user->role, ['OWNER', 'MANAJER'])) {
            abort(403, 'Anda tidak memiliki akses ke fitur ini.');
        }

        $user->wa_api_token = null;
        $user->save();
        $request->session()->forget('wa_qr_code');

        return redirect()->route('setting.notifikasi-api.index')
            ->with('success', 'Hubungan notifikasi WhatsApp berhasil diputuskan.');
    }

    public function connectNotifikasiApi(Request $request)
    {
        $user = Auth::user();

        if (!in_array($user->role, ['OWNER', 'MANAJER'])) {
            abort(403, 'Anda tidak memiliki akses ke fitur ini.');
        }

        $phone = $user->profile->phone ?? null;

        if (is_null($phone) || $phone === '62') {
            return redirect()->back()->with('error', 'No. HP (WhatsApp) Anda belum terisi. Silakan menuju <a href="/my/profile">menu profil</a> terlebih dahulu.');
        }

        // Ambil token_name dari tabel set_api_tokens
        $apiToken = SetApiToken::first();

        if (!$apiToken || !$apiToken->token_name) {
            return redirect()->back()->with('error', 'Token API belum tersedia. Silakan atur terlebih dahulu.');
        }

        $user->wa_api_token = $apiToken->token_name;
        $user->save();

        return redirect()->back()->with('success', 'Notifikasi WhatsApp berhasil dihubungkan menggunakan token API.');
    }

    public function indexSetAPItoken()
    {
        $setApiToken = SetApiToken::first();
        $user = auth()->user()->load('profile');
        return view('setting.setAPItoken', [
            'user' => $user,
            'setApiToken' => $setApiToken,
        ]);
    }

    public function updateSetAPItoken(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:13',
            'token_name' => 'required|string|max:255',
        ]);

        $formattedPhone = '62' . ltrim($request->phone, '0');

        SetApiToken::updateOrCreate(
            ['id' => 1],
            [
                'name' => $request->name,
                'phone' => $formattedPhone,
                'token_name' => $request->token_name,
            ]
        );

        \App\Models\User::whereNotNull('wa_api_token')->update([
            'wa_api_token' => $request->token_name
        ]);

        return back()->with('success', 'Token berhasil diperbarui dan disinkronkan ke semua pengguna.');
    }



    public function updateFilterSetting(Request $request)
    {
        $user = Auth::user();
        $settings = json_decode($user->setting->settings ?? '{}', true);

        foreach ($request->except('_token', '_method') as $key => $value) {
            if (in_array($key, ['show_image_barang', 'show_image_bahan', 'show_image_bahan2'])) {
                $settings[$key] = ($value === '1' || $value === true);
            } elseif (in_array($key, ['pagination_barang', 'pagination_bahan', 'pagination_bahan2'])) {
                $settings[$key] = (int) $value;
            } else {
                $settings[$key] = $value;
            }
        }

        $user->setting->update([
            'settings' => json_encode($settings)
        ]);

        return redirect()->back()->with('status', 'Pengaturan diperbarui.');
    }



}

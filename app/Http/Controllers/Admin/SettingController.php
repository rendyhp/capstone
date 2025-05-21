<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
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
                'phone' => $request->phone,
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
    // Tampilkan halaman notifikasi API
    public function indexNotifikasiApi()
    {
        $user = auth()->user()->load('profile'); // pastikan relasi 'profile' sudah didefinisikan
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

        $user->wa_api_token = '49zbRGa16VLm8S44vT5E';
        $user->save();

        return redirect()->back()->with('success', 'Notifikasi WhatsApp berhasil dihubungkan kembali.');
    }


}

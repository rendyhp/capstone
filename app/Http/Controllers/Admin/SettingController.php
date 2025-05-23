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

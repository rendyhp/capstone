<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bahan;
use App\Models\BahanAkhir;
use App\Models\BahanAwal;
use App\Models\BahanMasuk;
use App\Models\BarangAwal;
use App\Models\BarangKeluar;
use App\Models\BarangMasuk;
use App\Models\UP;
use Auth;
use Carbon\Carbon;
use Hash;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\DetailTransaksi;
use App\Models\Barang;
use App\Models\Transaksi;
use PDF;
use Illuminate\Support\Facades\DB;
use App\Services\StockAlertService;

class SettingController extends Controller
{
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
        $user->update(['name' => $request->name]);

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
        $user = Auth::user();

        // Cek apakah user sudah connect
        // Misal kita simpan token di kolom user->wa_api_token
        $isConnected = !empty($user->wa_api_token);

        // Kalau sudah connect dan simpan QR code base64 di DB atau session, 
        // tampilkan QR code, kalau belum null
        $qrCode = session('wa_qr_code', null);

        return view('setting.notifapi', compact('isConnected', 'qrCode'));
    }

    // Generate QR Code baru untuk koneksi WhatsApp
    public function generateQrCode(Request $request)
    {
        $user = Auth::user();

        // Contoh: panggil API pihak ketiga untuk generate QR code
        // Di sini kita pakai dummy base64 PNG image (replace dengan API nyata)
        $dummyQrCode = base64_encode(file_get_contents(public_path('img/dummy-qr.png')));

        // Simpan QR code di session supaya bisa ditampilkan
        $request->session()->put('wa_qr_code', $dummyQrCode);

        // Simulasi token kosong dulu (belum connect)
        $user->wa_api_token = null;
        $user->save();

        return redirect()->route('setting.notifikasi-api.index')
            ->with('success', 'QR Code berhasil dibuat, silakan scan dengan WhatsApp Anda.');
    }

    // Disconnect / putuskan hubungan notifikasi WhatsApp
    public function disconnectNotifikasiApi(Request $request)
    {
        $user = Auth::user();

        // Hapus token api / connection info
        $user->wa_api_token = null;
        $user->save();

        // Hapus QR code di session
        $request->session()->forget('wa_qr_code');

        return redirect()->route('setting.notifikasi-api.index')
            ->with('success', 'Hubungan notifikasi WhatsApp berhasil diputuskan.');
    }
}

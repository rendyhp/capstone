<?php

use App\Http\Controllers\Admin\BahanController;
use App\Http\Controllers\Admin\LaporanController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\NotifikasiController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\BarangController;
use App\Http\Controllers\Admin\TransaksiController;
use App\Http\Controllers\DashboardController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Public routes
Route::get('/', function () {
    return view('home');
});

// Auth routes
Auth::routes();
Route::redirect('/my', '/my/profile');
Route::redirect('/laporan', '/laporan/bahan');
// Reset password
// Tampilkan form input email untuk reset password
Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');

// Kirim email reset password
Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');

// Tampilkan form reset password dengan token
Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');

// Proses simpan password baru
Route::post('password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');

// Authenticated routes
Route::middleware(['auth'])->group(function () {
    Route::get('/layout', function () {
        return view('layout');
    });

    // Dasbor
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

    // Laporan
    Route::get('/laporan/bahan', [LaporanController::class, 'index'])->name('laporan.index');
    Route::get('/laporan/bahan/export', [LaporanController::class, 'exportExcel'])->name('laporan.export');
    Route::get('/laporan/barang', [LaporanController::class, 'indexLaporanBarang'])->name('laporan.indexLaporanBarang');
    Route::get('/laporan/barang/export-pdf', [LaporanController::class, 'exportPdf'])->name('laporan.exportBarangPdf');
    Route::get('/laporan/barang/export-word', [LaporanController::class, 'exportWord'])->name('laporan.exportBarangWord');

    // Stok
    // Barang
    Route::get('/barang/manajemen-barang', [BarangController::class, 'index'])->name('barang.index');
    Route::get('/barang/manajemen-barang/{encryptedId}', [BarangController::class, 'indexbyID'])->name('barang.indexbyId');
    Route::post('/barang/delete', [BarangController::class, 'delete'])->name('barang.delete');
    Route::post('/barang/manajemen-barang/storeM', [BarangController::class, 'storeM'])->name('barang.storeM');
    Route::post('/barang/manajemen-barang/storeK', [BarangController::class, 'storeK'])->name('barang.storeK');
    Route::get('/barang/masuk-keluar', [BarangController::class, 'indexMasukKeluar'])->name('barang.indexMasukKeluar');
    Route::get('/barang/masuk-keluar/{encryptedId}', [BarangController::class, 'indexBarangMKbyID'])->name('barang.indexBarangMKbyID');
    Route::put('/barang/masuk-keluar/deleteM', [BarangController::class, 'deleteBarangMasukbyID'])->name('barang.deleteBarangMKbyIDmasuk');
     Route::put('/barang/masuk-keluar/deleteK', [BarangController::class, 'deleteBarangKeluarbyID'])->name('barang.deleteBarangMKbyIDkeluar');
    Route::post('/barang/masuk-keluar/store', [BarangController::class, 'storeMasukKeluar'])->name('barang.storeMasukKeluar');
    Route::put('/barang/masuk-keluar/edit', [BarangController::class, 'updateMasukKeluar'])->name('barang.updateMasukKeluar');
    Route::post('/barang/data-barang/store', [BarangController::class, 'storeDataBarang'])->name('barang.storeDataBarang');
    Route::put('/barang/data-barang/edit', [BarangController::class, 'updateDataBarang'])->name('barang.updateDataBarang');
    Route::get('/barang/data-barang/delete-image/{id}', [BarangController::class, 'deleteImageBarang'])->name('barang.deleteImage');

    Route::get('/barang/satuan', [BarangController::class, 'indexSatuan'])->name('barang.indexSatuan');
    Route::post('/barang/satuan/store', [BarangController::class, 'storeSatuan'])->name('barang.storeSatuan');
    Route::put('/barang/satuan/edit', [BarangController::class, 'updateSatuan'])->name('barang.updateSatuan');
    Route::put('/barang/satuan/delete', [BarangController::class, 'deleteSatuan'])->name('barang.deleteSatuan');
    //Bahan
    Route::get('/bahan/manajemen-bahan', [BahanController::class, 'index'])->name('bahan.index');
    Route::get('/bahan/manajemen-bahan/{encryptedId}', [BahanController::class, 'indexbyID'])->name('bahan.indexbyId');

    Route::post('/bahanAwal/save', [BahanController::class, 'saveBahanAwal'])->name('bahanAwal.save');
    Route::post('/bahanAkhir/save', [BahanController::class, 'saveBahanAkhir'])->name('bahanAkhir.save');
    Route::delete('/bahanAwal/delete', [BahanController::class, 'deleteBahanAwal'])->name('bahanAwal.delete');
    Route::delete('/bahanAkhir/delete', [BahanController::class, 'deleteBahanAkhir'])->name('bahanAkhir.delete');

    Route::get('/bahan/data-bahan', [BahanController::class, 'indexDataBahan'])->name('bahan.indexDataBahan');
    Route::post('/bahan/data-bahan/store', [BahanController::class, 'storeDataBahan'])->name('bahan.storeDataBahan');
    Route::put('/bahan/data-bahan/edit', [BahanController::class, 'updateDataBahan'])->name('bahan.updateDataBahan');
    Route::put('/bahan/data-bahan/delete', [BahanController::class, 'deleteDataBahan'])->name('bahan.deleteDataBahan');
    Route::get('/bahan/data-bahan/delete-image/{id}', [BahanController::class, 'deleteImageBahan'])->name('bahan.deleteImage');

    Route::get('/bahan/satuan', [BahanController::class, 'indexSatuan'])->name('bahan.indexSatuan');
    Route::post('/bahan/satuan/store', [BahanController::class, 'storeSatuan'])->name('bahan.storeSatuan');
    Route::put('/bahan/satuan/edit', [BahanController::class, 'updateSatuan'])->name('bahan.updateSatuan');
    Route::put('/bahan/satuan/delete', [BahanController::class, 'deleteSatuan'])->name('bahan.deleteSatuan');

    Route::get('/bahan/masuk-keluar/{encryptedId}', [BahanController::class, 'indexBahanMKbyID'])->name('bahan.indexBahanMKbyID');
    Route::put('/bahan/masuk-keluar/delete', [BahanController::class, 'deleteBahanMKbyID'])->name('bahan.deleteBahanMKbyID');
    Route::post('/bahan/manajemen-bahan/storeM', [BahanController::class, 'storeM'])->name('bahan.storeM');

    // Menu & transaksi
    Route::get('/daftar-menu', [MenuController::class, 'index'])->name('datftar-menu');
    Route::put('/daftar-menu/delete', [MenuController::class, 'delete'])->name('daftar-menu.delete');
    Route::get('/daftar-menu/delete-image/{id}', [MenuController::class, 'deleteImageMenu'])->name('daftar-menu.deleteImage');

    Route::get('/transaksi', [TransaksiController::class, 'index'])->name('transaksi');
    Route::post('/transaksi/import', [TransaksiController::class, 'importTransaksi'])->name('transaksi.import');
    Route::get('/transaksi/jumlah-sebelumnya', [TransaksiController::class, 'jumlahSebelumnya']);
    Route::delete('/transaksi/delete', [TransaksiController::class, 'destroy'])->name('transaksi.delete');
    Route::put('/transaksi/updateTransaksi/{id}', [TransaksiController::class, 'updateTransaksi'])->name('transaksi.updateTransaksi');

    // Lainnya
    Route::get('/protected/user-data', [UserController::class, 'index'])->name('user.index');
    Route::get('/protected/user-data/register', [UserController::class, 'register'])->name('user-data.register');
    Route::post('/protected/user-data/registerStore', [UserController::class, 'registerStore'])->name('user-data.registerStore');
    Route::get('/protected/user/{id}', [UserController::class, 'getEmail'])->name('user.getEmail');
    Route::put('/protected/user/{id}/delete', [UserController::class, 'delete'])->name('user.delete');

    // Setting pages
    Route::get('/my/profile', [SettingController::class, 'index'])->name('setting.index');
    Route::put('/my/profile', [SettingController::class, 'update'])->name('setting.update');
    Route::post('/verify-phone', [SettingController::class, 'verifyPhone'])->name('verify.phone');
    Route::post('/update-email', [SettingController::class, 'updateEmail'])->name('email.update');
    Route::post('/verify-email', [SettingController::class, 'verifyEmail'])->name('verify.email');

    Route::get('/my/notifikasi-api', [SettingController::class, 'indexNotifikasiApi'])->name('setting.notifikasi-api.index');
    Route::post('/my/notifikasi-api/connect', [SettingController::class, 'connectNotifikasiApi'])->name('setting.notifikasi-api.connect');
    Route::post('/my/notifikasi-api/disconnect', [SettingController::class, 'disconnectNotifikasiApi'])->name('setting.notifikasi-api.disconnect');
    Route::get('/my/password', [SettingController::class, 'indexPassword'])->name('setting.password.index');
    Route::post('/my/password', [SettingController::class, 'updatePassword'])->name('setting.password.update');

    Route::post('/send-report', [ReportController::class, 'send'])->name('send.report');

    Route::post('/user/setting/update/', [SettingController::class, 'updateFilterSetting'])->name('user.setting.update');




    // Route::get('/send-wa', function () {
    //     $response = Http::withHeaders([
    //         'Authorization' => '49zbRGa16VLm8S44vT5E',
    //     ])->post('https://api.fonnte.com/send', [
    //                 'target' => '081226077106',
    //                 'message' => 'ini Pesan Laravel test',
    //             ]);

    //     dd(json_decode($response, true));
    // });





    // Resource routes
    Route::resource('/daftar-menu', \App\Http\Controllers\Admin\MenuController::class);
    Route::resource('/transaksi', \App\Http\Controllers\Admin\TransaksiController::class);
});
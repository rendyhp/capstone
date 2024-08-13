<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\UPController;
use App\Http\Controllers\ULPController;
use App\Http\Controllers\DetailTransaksiController;
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

// Authenticated routes
Route::middleware(['auth'])->group(function () {
    Route::get('/layout', function () {
        return view('layout');
    });

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Transaksi routes
    Route::get('trans/input', [TransaksiController::class, 'input'])->name('transaksi.input');
    Route::post('trans/input', [TransaksiController::class, 'caribarangmasuk'])->name('transaksi.inputPost');
    Route::get('trans/detail/{trans_id}', [TransaksiController::class, 'detail'])->name('transaksi.detail');
    Route::resource('transaksi', TransaksiController::class);
    Route::post('/simpandatamasuk', [TransaksiController::class, 'simpanDataMasuk'])->name('transaksi.simpanmasuk');
    Route::get('trans/keluar', [TransaksiController::class, 'keluar'])->name('transaksi.keluar');
    Route::post('trans/keluar', [TransaksiController::class, 'caribarangkeluar'])->name('transaksi.keluarPost');
    Route::post('/simpandatakeluar', [TransaksiController::class, 'simpanDataKeluar'])->name('transaksi.simpankeluar');
    Route::post('/autocomplete', [TransaksiController::class, 'autocomplete'])->name('transaksi.autocomplete');
    Route::get('/trans/keluar/cetak-barang-keluar/{trans_id}', [TransaksiController::class, 'cetakBarangKeluar'])->name('cetak-barang-keluar');
    Route::get('trans/barangkeluar', [TransaksiController::class, 'barangkeluar']);
    Route::get('trans/barangmasuk', [TransaksiController::class, 'barangmasuk']);
    
    // Dashboard routes
    Route::get('/report', [DashboardController::class, 'laporan'])->name('dashboard.report');
    Route::get('/report/print', [DashboardController::class, 'print'])->name('dashboard.print');
    Route::post('/report', [DashboardController::class, 'filter'])->name('dashboard.filter');
    
    // Resource routes
    Route::resource('/barang', \App\Http\Controllers\BarangController::class);
    Route::resource('/up', \App\Http\Controllers\UPController::class);
    Route::resource('/ulp', \App\Http\Controllers\ULPController::class);
    Route::resource('/user', \App\Http\Controllers\UserController::class);
});

// Route user
Route::get('/beranda', [TransaksiController::class, 'trans'])->name('beranda');

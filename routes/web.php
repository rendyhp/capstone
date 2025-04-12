<?php

use App\Http\Controllers\Admin\BahanController;
use App\Http\Controllers\Admin\LaporanController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\NotifikasiController;
use App\Http\Controllers\Admin\SearchController;
use App\Http\Controllers\Admin\StockOpnameController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\BarangController;
use App\Http\Controllers\Admin\TransaksiController;
use App\Http\Controllers\DashboardController;

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

    //coba
    // routes/web.php
    Route::get('/search/satuan', [SearchController::class, 'searchSatuan'])->name('search.satuan');


    //endcoba

    // Buatanku
    // Awal
    Route::get('/notification', [NotifikasiController::class, 'index'])->name('notification');
    Route::get('/report', [NotifikasiController::class, 'indexReport'])->name('report');

    // Data
    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan');

    // Stok
    Route::get('/data-barang', [BarangController::class, 'index'])->name('data-barang');
    Route::put('/data-barang/delete/{id}', [BarangController::class, 'delete'])->name('data-barang.delete');

    Route::get('/data-bahan', [BahanController::class, 'index'])->name('data-bahan');
    Route::put('/data-bahan/delete/{id}', [BahanController::class, 'delete'])->name('data-bahan.delete');
    Route::get('/data-bahan/historyInput/{id}', [BahanController::class, 'indexHistory'])->name('data-bahan.historyBahan');

    Route::get('/stock-opname', [StockOpnameController::class, 'index'])->name('stock-opname');
    Route::get('/stock-opname/simpan', [StockOpnameController::class, 'simpan'])->name('stock-opname.simpan');
    Route::post('/stock-opname/simpan/store', [StockOpnameController::class, 'simpanDataBaru'])->name('stock-opname.simpan.store');

    // Menu & transaksi
    Route::get('/daftar-menu', [MenuController::class, 'index'])->name('datftar-menu');
    Route::put('/daftar-menu/delete/{id}', [MenuController::class, 'delete'])->name('daftar-menu.delete');

    Route::get('/transaksi', [TransaksiController::class, 'index'])->name('transaksi');
    Route::post('/transaksi/import', [TransaksiController::class, 'import'])->name('transaksi.import');
    Route::get('/transaksi/preview', [TransaksiController::class, 'preview'])->name('transaksi.preview');
    Route::delete('/transaksi/temp-delete', [TransaksiController::class, 'deleteTemp'])->name('transaksi.tempDelete');




    Route::get('/transaksi/{id}/edit', [TransaksiController::class, 'edit']);
    Route::put('/transaksi/{id}', [TransaksiController::class, 'update']);
    Route::delete('/transaksi/{id}', [TransaksiController::class, 'destroy'])->name('transaksi.destroy');


    // Lainnya
    Route::get('/log-activities', [LogActivityController::class, 'index'])->name('log-activities');
    Route::get('/user-data', [UserController::class, 'index'])->name('user-data');


    // Transaksi routes
    Route::get('trans/input', [TransaksiController::class, 'input'])->name('transaksi.input');
    Route::post('trans/input', [TransaksiController::class, 'caribarangmasuk'])->name('transaksi.inputPost');
    Route::get('trans/detail/{trans_id}', [TransaksiController::class, 'detail'])->name('transaksi.detail');

    Route::post('/simpandatamasuk', [TransaksiController::class, 'simpanDataMasuk'])->name('transaksi.simpanmasuk');
    Route::get('trans/keluar', [TransaksiController::class, 'keluar'])->name('transaksi.keluar');
    Route::post('trans/keluar', [TransaksiController::class, 'caribarangkeluar'])->name('transaksi.keluarPost');
    Route::post('/simpandatakeluar', [TransaksiController::class, 'simpanDataKeluar'])->name('transaksi.simpankeluar');
    Route::post('/autocomplete', [TransaksiController::class, 'autocomplete'])->name('transaksi.autocomplete');
    Route::get('/trans/keluar/cetak-barang-keluar/{trans_id}', [TransaksiController::class, 'cetakBarangKeluar'])->name('cetak-barang-keluar');
    Route::get('trans/barangkeluar', [TransaksiController::class, 'barangkeluar']);
    Route::get('trans/barangmasuk', [TransaksiController::class, 'barangmasuk']);

    // Dashboard routes
    // Route::get('/laporan', [DashboardController::class, 'laporan'])->name('dashboard.laporan');
    Route::get('/laporan/print', [DashboardController::class, 'print'])->name('dashboard.laporan.print');
    Route::post('/laporan', [DashboardController::class, 'filter'])->name('dashboard.laporan.filter');

    // Resource routes
    Route::resource('/data-barang', \App\Http\Controllers\Admin\BarangController::class);
    Route::resource('/data-bahan', \App\Http\Controllers\Admin\BahanController::class);
    Route::resource('/stock-opname', \App\Http\Controllers\Admin\StockOpnameController::class);
    Route::resource('/daftar-menu', \App\Http\Controllers\Admin\MenuController::class);
    Route::resource('/transaksi', \App\Http\Controllers\Admin\TransaksiController::class);
    Route::resource('/user', \App\Http\Controllers\UserController::class);
});

// Route user
Route::get('/beranda', [TransaksiController::class, 'trans'])->name('beranda');

Auth::routes();


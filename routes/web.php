<?php

use App\Http\Controllers\Admin\BahanAwalController;
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

    // Laporan
    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan');

    // Stok
    Route::get('/barang/master', [BarangController::class, 'index'])->name('barang.index');
    Route::get('/barang/master/{encryptedId}', [BarangController::class, 'indexbyID'])->name('barang.indexbyId');
    Route::post('/barang/master/storeM', [BarangController::class, 'storeM'])->name('barang.storeM');
    Route::post('/barang/master/storeK', [BarangController::class, 'storeK'])->name('barang.storeK');
    Route::get('/barang/masuk-keluar', [BarangController::class, 'indexMasukKeluar'])->name('barang.indexMasukKeluar');
    Route::get('/barang/masuk-keluar/{encryptedId}', [BarangController::class, 'indexBarangMKbyID'])->name('barang.indexBarangMKbyID');
    Route::post('/barang/masuk-keluar/store', [BarangController::class, 'storeMasukKeluar'])->name('barang.storeMasukKeluar');
    Route::put('/barang/masuk-keluar/edit', [BarangController::class, 'updateMasukKeluar'])->name('barang.updateMasukKeluar');
    Route::get('/barang/data-barang', [BarangController::class, 'indexDataBarang'])->name('barang.indexDataBarang');
    Route::post('/barang/data-barang/store', [BarangController::class, 'storeDataBarang'])->name('barang.storeDataBarang');
    Route::put('/barang/data-barang/edit', [BarangController::class, 'updateDataBarang'])->name('barang.updateDataBarang');
    Route::get('/barang/satuan', [BarangController::class, 'indexSatuan'])->name('barang.indexSatuan');
    Route::post('/barang/satuan/store', [BarangController::class, 'storeSatuan'])->name('barang.storeSatuan');
    Route::put('/barang/satuan/edit', [BarangController::class, 'updateSatuan'])->name('barang.updateSatuan');
    // Route::put('/stok-barang/delete/{id}', [BarangController::class, 'delete'])->name('stok-barang.delete');

    Route::get('/bahan/master', [BahanController::class, 'index'])->name('bahan.index');
    Route::get('/bahan/masuk-keluar', [BahanController::class, 'indexMasukKeluar'])->name('bahan.indexMasukKeluar');

    Route::get('/bahan/bahan-awal', [BahanController::class, 'indexBahanAwal'])->name('bahan.indexBahanAwal');
    Route::post('/bahan/bahan-awal/store', [BahanController::class, 'storeBahanAwal'])->name('bahan.storeBahanAwal');
    Route::put('/bahan/bahan-awal/edit', [BahanController::class, 'updateBahanAwal'])->name('bahan.updateBahanAwal');
    Route::put('/bahan/bahan-awal/delete', [BahanController::class, 'deleteBahanAwal'])->name('bahan.deleteBahanAwal');

    Route::get('/bahan/data-bahan', [BahanController::class, 'indexDataBahan'])->name('bahan.indexDataBahan');
    Route::post('/bahan/data-bahan/store', [BahanController::class, 'storeDataBahan'])->name('bahan.storeDataBahan');
    Route::put('/bahan/data-bahan/edit', [BahanController::class, 'updateDataBahan'])->name('bahan.updateDataBahan');
    Route::put('/bahan/data-bahan/delete/{id}', [BahanController::class, 'deleteDataBahan'])->name('bahan.deleteDataBahan');

    Route::get('/bahan/satuan', [BahanController::class, 'indexSatuan'])->name('bahan.indexSatuan');
    Route::post('/bahan/satuan/store', [BahanController::class, 'storeSatuan'])->name('bahan.storeSatuan');
    Route::put('/bahan/satuan/edit', [BahanController::class, 'updateSatuan'])->name('bahan.updateSatuan');
    Route::get('/bahan/history', [BahanController::class, 'indexHistory'])->name('bahan.indexHistory');

    Route::get('/bahan/masuk-keluar', [BahanController::class, 'indexMasukKeluar'])->name('bahan.indexMasukKeluar');
    Route::get('/bahan/masuk-keluar/{encryptedId}', [BahanController::class, 'indexBahanMKbyID'])->name('bahan.indexBahanMKbyID');
    Route::post('/bahan/master/storeM', [BahanController::class, 'storeM'])->name('bahan.storeM');
    Route::post('/bahan/master/storeK', [BahanController::class, 'storeK'])->name('bahan.storeK');
    Route::post('/bahan/masuk-keluar/store', [BahanController::class, 'inputStore'])->name('historyBahan.store');
    Route::put('/bahan/masuk-keluar/update/', [BahanController::class, 'inputUpdate'])->name('historyBahan.update');
    Route::put('/bahan/masuk-keluar/delete/{id}', [BahanController::class, 'inputDelete'])->name('historyBahan.delete');



    Route::get('/stock-opname', [StockOpnameController::class, 'index'])->name('stock-opname');
    Route::get('/stock-opname/{bahan_id}/edit', [StockOpnameController::class, 'edit']);
    Route::put('/stock-opname/{bahan_id}/update', [StockOpnameController::class, 'update'])->name('stock-opname.update');
    Route::put('/stock-opname/{bahan_akhir_id}/delete', [StockOpnameController::class, 'delete'])->name('stock-opname.delete');
    Route::get('/stock-opname/simpan', [StockOpnameController::class, 'simpan'])->name('stock-opname.simpan');
    Route::post('/stock-opname/simpan/store', [StockOpnameController::class, 'simpanDataBaru'])->name('stock-opname.simpan.store');



    // Menu & transaksi
    Route::get('/daftar-menu', [MenuController::class, 'index'])->name('datftar-menu');
    Route::put('/daftar-menu/delete/{id}', [MenuController::class, 'delete'])->name('daftar-menu.delete');

    Route::get('/transaksi', [TransaksiController::class, 'index'])->name('transaksi');
    Route::post('/transaksi/import', [TransaksiController::class, 'importTransaksi'])->name('transaksi.import');


    Route::get('/transaksi/preview', [TransaksiController::class, 'preview'])->name('transaksi.preview');
    Route::delete('/transaksi/temp-delete', [TransaksiController::class, 'deleteTemp'])->name('transaksi.tempDelete');

    // Lainnya
    Route::get('/log-activities', [LogActivityController::class, 'index'])->name('log-activities');
    Route::get('/user-data', [UserController::class, 'index'])->name('user-data');

    // Dashboard routes
    // Route::get('/laporan', [DashboardController::class, 'laporan'])->name('dashboard.laporan');
    Route::get('/laporan/print', [DashboardController::class, 'print'])->name('dashboard.laporan.print');
    Route::post('/laporan', [DashboardController::class, 'filter'])->name('dashboard.laporan.filter');

    // Resource routes
    Route::resource('/stock-opname', \App\Http\Controllers\Admin\StockOpnameController::class);
    Route::resource('/daftar-menu', \App\Http\Controllers\Admin\MenuController::class);
    Route::resource('/transaksi', \App\Http\Controllers\Admin\TransaksiController::class);
    Route::resource('/user', \App\Http\Controllers\UserController::class);

});

Auth::routes();


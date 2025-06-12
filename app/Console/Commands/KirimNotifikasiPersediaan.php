<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\StockDataService;
use App\Services\StockAlertService;

class KirimNotifikasiPersediaan extends Command
{
    protected $signature = 'notifikasi:persediaan';
    protected $description = 'Mengirim notifikasi bahan dan barang setiap hari jam 23:30';

    public function handle()
    {
        $dataService = new StockDataService();
        $alertService = new StockAlertService();

        $tanggalHariIni = now()->toDateString();

        // 🔹 Ambil data bahan dan barang
        $bahanData = $dataService->getBahanData($tanggalHariIni);
        $barangData = $dataService->getBarangData();

        // 🔔 Kirim notifikasi
        $alertService->checkAndNotify2($bahanData); // bahan menipis (berdasarkan jumlah_akhir)
        $alertService->checkAndNotify3($bahanData); // bahan hari ini normal tapi tercatat akhir kemarin < minimum
        $alertService->checkAndNotify($barangData); // barang menipis

        $this->info('Notifikasi bahan dan barang berhasil dikirim.');
    }
}


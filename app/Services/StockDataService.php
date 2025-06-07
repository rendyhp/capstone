<?php

namespace App\Services;

use App\Models\Barang;
use App\Models\Bahan;
use App\Models\BarangAwal;
use App\Models\BarangMasuk;
use App\Models\BarangKeluar;
use App\Models\BahanAwal;
use App\Models\BahanAkhir;
use App\Models\BahanMasuk;
use Illuminate\Support\Facades\DB;

class StockDataService
{
    public function getBarangData()
    {
        $barangs = Barang::with('satuanBarang')->whereNull('deleted_at')->get();

        return $barangs->map(function ($barang) {
            $awal = BarangAwal::where('barang_id', $barang->id)->whereNull('deleted_at')->sum('jumlah');
            $masuk = BarangMasuk::where('barang_id', $barang->id)->whereNull('deleted_at')->sum('jumlah');
            $keluar = BarangKeluar::where('barang_id', $barang->id)->whereNull('deleted_at')->sum('jumlah');

            $barang->sisa = ($awal + $masuk) - $keluar;
            return $barang;
        })->sortBy('name');
    }

    public function getBahanData($date)
    {
        $bahans = Bahan::with('satuan')->whereNull('deleted_at')->get();

        return $bahans->map(function ($bahan) use ($date) {
            $awal = BahanAwal::where('bahan_id', $bahan->id)->whereDate('date', $date)->whereNull('deleted_at')->value('jumlah');
            if ($awal === null) {
                $awal = BahanAkhir::where('bahan_id', $bahan->id)
                    ->where('date', '<', $date)
                    ->whereNull('deleted_at')
                    ->orderByDesc('date')
                    ->value('jumlah') ?? 0;
            }

            $masuk = BahanMasuk::where('bahan_id', $bahan->id)->whereDate('date', $date)->whereNull('deleted_at')->sum('jumlah');

            $terpakai = DB::table('transaksi_details')
                ->join('transaksis', 'transaksi_details.transaksi_id', '=', 'transaksis.id')
                ->where('transaksi_details.bahan_id', $bahan->id)
                ->whereDate('transaksis.date', $date)
                ->whereNull('transaksis.deleted_at')
                ->sum('transaksi_details.jumlah');

            $bahan->jumlah_akhir = ($awal + $masuk) - $terpakai;
            return $bahan;
        })->sortBy([['section', 'asc'], ['name', 'asc']]);
    }

    public function getSingleBahan($bahanId, $date)
    {
        $bahan = Bahan::with('satuan')->find($bahanId);

        $awal = BahanAwal::where('bahan_id', $bahan->id)
            ->whereDate('date', $date)
            ->whereNull('deleted_at')
            ->value('jumlah');

        if ($awal === null) {
            $awal = BahanAkhir::where('bahan_id', $bahan->id)
                ->where('date', '<', $date)
                ->whereNull('deleted_at')
                ->orderByDesc('date')
                ->value('jumlah') ?? 0;
        }

        $masuk = BahanMasuk::where('bahan_id', $bahan->id)
            ->whereDate('date', $date)
            ->whereNull('deleted_at')
            ->sum('jumlah');

        $terpakai = DB::table('transaksi_details')
            ->join('transaksis', 'transaksi_details.transaksi_id', '=', 'transaksis.id')
            ->where('transaksi_details.bahan_id', $bahan->id)
            ->whereDate('transaksis.date', $date)
            ->whereNull('transaksis.deleted_at')
            ->sum('transaksi_details.jumlah');

        $bahan->jumlah_akhir = ($awal + $masuk) - $terpakai;
        $bahan->sisa_sebelumnya = ($awal + $masuk);

        $bahan->akhir_sebenarnya = BahanAkhir::where('bahan_id', $bahan->id)
            ->whereDate('date', $date)
            ->whereNull('deleted_at')
            ->first();

        return collect([$bahan]);
    }
    public function getSingleBarang($barangId)
    {
        $barang = Barang::with('satuanBarang')->find($barangId);

        if (!$barang) {
            return collect();
        }

        $awal = BarangAwal::where('barang_id', $barang->id)
            ->whereNull('deleted_at')
            ->sum('jumlah');

        $masuk = BarangMasuk::where('barang_id', $barang->id)
            ->whereNull('deleted_at')
            ->sum('jumlah');

        $keluarSemua = BarangKeluar::where('barang_id', $barang->id)
            ->whereNull('deleted_at')
            ->orderBy('id')
            ->get();

        $keluar = $keluarSemua->sum('jumlah');

        $keluar_sebelumnya = $keluarSemua->count() > 1
            ? $keluarSemua->slice(0, -1)->sum('jumlah')
            : 0;

        $barang->total_sebelumnya = ($awal + $masuk) - $keluar_sebelumnya;
        $barang->sisa = ($awal + $masuk) - $keluar;

        return collect([$barang]);
    }
}

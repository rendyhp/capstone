<?php

namespace App\Imports;

use App\Models\Menu;
use App\Models\Transaksi;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class TransaksiImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        // Ambil tanggal dari request
        $date = request()->input('date');

        foreach ($rows as $row) {
            // Ambil nama menu dan jumlahnya
            $menuName = $row['judul_produk'];
            $jumlah = $row['unit_terjual'];

            // Cari menu berdasarkan nama
            $menu = Menu::where('name', $menuName)->first();

            // Jika menu ditemukan, simpan transaksi
            if ($menu) {
                Transaksi::create([
                    'date' => $date,
                    'menu_id' => $menu->id,
                    'jumlah' => $jumlah,
                ]);
            }
        }
    }
}

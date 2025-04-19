<?php

namespace App\Http\Controllers;

use App\Models\UP;
use Auth;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\DetailTransaksi;
use App\Models\Barang;
use App\Models\Transaksi;
use PDF;
use Illuminate\Support\Facades\DB;
class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct()
    {

        $this->middleware('auth');
    }
    public function index()
    {

        $user = Auth::user();
        $role = $user->role;

        if ($role === 'OWNER') {
            return view('dashboard.index');
        } elseif ($role === 'MANAJER') {
            return view('dashboard.index');
        } elseif ($role === 'STAF') {
            return view('dashboard.index');
        } else {
            return abort(403, 'Anda tidak memiliki izin untuk mengakses halaman ini.');
        }
    }

    public function laporan()
    {

        $user = Auth::user();
        $role = $user->role;
        $unit = $user->unit;
        $query = Transaksi::query();

        if ($role === 'OWNER') {

            $Users = User::all();
            $Barangs = Barang::all();

            return view('laporan.index', compact('users'));
        } else {
            return abort(403, 'Anda tidak memiliki izin untuk mengakses halaman ini.');
        }
    }

    public function filter(Request $request)
    {
        // Lakukan pemrosesan filter laporan di sini
        $tanggalAwal = $request->input('tglawal');
        $tanggalAkhir = $request->input('tglakhir');

        // Lakukan query database untuk mengambil data laporan berdasarkan tanggal
        $dashboards = DetailTransaksi::select('tanggal_trans', 'barang_nama', 'barang_merk')
            ->selectRaw('SUM(CASE WHEN trans_jenis = "Masuk" THEN barang_quantity ELSE 0 END) AS barang_masuk')
            ->selectRaw('SUM(CASE WHEN trans_jenis = "Keluar" THEN barang_quantity ELSE 0 END) AS barang_keluar')
            ->join('transaksi', 'detail_transaksi.trans_id', '=', 'transaksi.id')
            ->join('barang', 'detail_transaksi.barang_id', '=', 'barang.id')
            ->whereBetween('tanggal_trans', [$tanggalAwal, $tanggalAkhir]) // Filter by date range
            ->groupBy('tanggal_trans', 'barang_nama', 'barang_merk')
            ->get();

        // Ambil data barang
        $Barangs = Barang::all();

        $stokTersedia = [];

        foreach ($Barangs as $barang) {
            // Mengambil jumlah stok masuk per barang
            $jumlahStokMasuk = DetailTransaksi::where('barang_id', $barang->id)
                ->whereHas('transaksi', function ($query) {
                    $query->where('trans_jenis', 'Masuk');
                })
                ->sum('barang_quantity');

            // Mengambil jumlah stok keluar per barang
            $jumlahStokKeluar = DetailTransaksi::where('barang_id', $barang->id)
                ->whereHas('transaksi', function ($query) {
                    $query->where('trans_jenis', 'Keluar');
                })
                ->sum('barang_quantity');

            // Menghitung stok tersedia untuk setiap barang
            $stokTersedia[$barang->barang_nama] = $jumlahStokMasuk - $jumlahStokKeluar;
        }

        $totalBarang = count($Barangs);

        return view('laporan.index', compact('dashboards', 'Barangs', 'totalBarang'));
    }
}

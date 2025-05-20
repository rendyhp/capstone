<?php

namespace App\Http\Controllers;

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
    public function index(Request $request)
    {
        $user = Auth::user();
        $role = $user->role;
        $date = $request->input('date', Carbon::today()->toDateString());

        // ---------- BARANG ----------
        $barangs = Barang::with('satuanBarang')->whereNull('deleted_at')->get();

        $barang_data = $barangs->map(function ($barang) {
            $awal = BarangAwal::where('barang_id', $barang->id)->whereNull('deleted_at')->sum('jumlah');
            $masuk = BarangMasuk::where('barang_id', $barang->id)->whereNull('deleted_at')->sum('jumlah');
            $keluar = BarangKeluar::where('barang_id', $barang->id)->whereNull('deleted_at')->sum('jumlah');

            $total_beli = $awal + $masuk;
            $sisa = $total_beli - $keluar;

            $barang->sisa = $sisa;
            return $barang;
        });

        $barangs_below_minimum = $barang_data->filter(function ($barang) {
            return $barang->sisa < $barang->minimum;
        });

        // ---------- BAHAN ----------
        $bahans = Bahan::with('satuan')->whereNull('deleted_at')->get();

        $bahan_data = $bahans->map(function ($bahan) use ($date) {
            $awal = BahanAwal::where('bahan_id', $bahan->id)->whereDate('date', $date)->whereNull('deleted_at')->value('jumlah');
            if ($awal === null) {
                $awal = BahanAkhir::where('bahan_id', $bahan->id)->where('date', '<', $date)->whereNull('deleted_at')->orderByDesc('date')->value('jumlah') ?? 0;
            }

            $masuk = BahanMasuk::where('bahan_id', $bahan->id)->whereDate('date', $date)->whereNull('deleted_at')->sum('jumlah');

            $terpakai = DB::table('transaksi_details')
                ->join('transaksis', 'transaksi_details.transaksi_id', '=', 'transaksis.id')
                ->where('transaksi_details.bahan_id', $bahan->id)
                ->whereDate('transaksis.date', $date)
                ->whereNull('transaksis.deleted_at')
                ->sum('transaksi_details.jumlah');

            $jumlah_akhir = ($awal + $masuk) - $terpakai;
            $bahan->jumlah_akhir = $jumlah_akhir;

            return $bahan;
        });

        $bahans_below_minimum = $bahan_data->filter(function ($bahan) {
            return $bahan->jumlah_akhir < $bahan->minimum;
        });

        return view('dashboard.index', [
            'barangs_below_minimum' => $barangs_below_minimum,
            'bahans_below_minimum' => $bahans_below_minimum,
            'user' => $user,
        ]);
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

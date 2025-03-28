<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\Menu;
use PhpOffice\PhpSpreadsheet\IOFactory;
use App\Models\KomposisiMenu;
use App\Models\Bahan;
use App\Models\TransaksiDetail;
use Illuminate\Support\Facades\Auth;

class TransaksiController extends Controller
{
    public function import(Request $request)
    {
        // Validasi apakah ada file yang diunggah
        if (!$request->hasFile('file')) {
            return response()->json(['error' => 'Tidak ada file yang diunggah.'], 400);
        }

        $file = $request->file('file');
        $extension = $file->getClientOriginalExtension();

        // Validasi format file (CSV atau XLSX)
        if (!in_array($extension, ['csv', 'xlsx', 'xls'])) {
            return response()->json(['error' => 'Format file harus CSV atau Excel (XLSX, XLS).'], 400);
        }

        try {
            // Baca file dengan PhpSpreadsheet
            $spreadsheet = IOFactory::load($file->getPathname());
            $sheet = $spreadsheet->getActiveSheet();
            $data = $sheet->toArray();

            // Iterasi data (skip header row)
            foreach ($data as $index => $row) {
                if ($index == 0)
                    continue; // Lewati header

                $menuName = trim($row[0]); // Nama Menu ada di kolom pertama
                $jumlah = intval($row[2]); // Jumlah ada di kolom ke-3

                // Cek apakah menu ada di database
                $menu = Menu::where('name', $menuName)->first();

                // Simpan transaksi
                $transaksi = Transaksi::create([
                    'user_id' => Auth::id(),
                    'menu_id' => $menu ? $menu->id : null,
                    'date' => now(),
                    'jumlah' => $jumlah,
                ]);

                // Jika menu ditemukan, hitung bahan terpakai
                if ($menu) {
                    $this->hitungBahanTerpakai($transaksi);
                }
            }

            return response()->json(['success' => 'Data berhasil diimpor!']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Terjadi kesalahan saat memproses file: ' . $e->getMessage()], 500);
        }
    }




    public function store(Request $request)
    {
        $request->validate([
            'menu_id' => 'required|exists:menus,id',
            'jumlah' => 'required|numeric|min:1',
            'date' => 'required|date',
        ]);

        $transaksi = Transaksi::create([
            'user_id' => Auth::id(),
            'menu_id' => $request->menu_id,
            'jumlah' => $request->jumlah,
            'date' => $request->date,
        ]);

        $this->hitungBahanTerpakai($transaksi);

        return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil ditambahkan.');
    }

    private function hitungBahanTerpakai(Transaksi $transaksi)
    {
        $menu = $transaksi->menu;
        if (!$menu)
            return;

        foreach ($menu->komposisi as $komposisi) {
            // Simpan detail pemakaian bahan dalam transaksi_detail
            TransaksiDetail::create([
                'transaksi_id' => $transaksi->id,
                'bahan_id' => $komposisi->bahan_id,
                'jumlah' => $komposisi->jumlah * $transaksi->jumlah,
                'satuan_id' => $komposisi->bahan->satuan_id,
            ]);


        }
    }

    public function index(Request $request)
    {
        $user = Auth::user();
        $role = $user->role;

        // Ambil tanggal dari request, default ke hari ini
        $date = $request->input('date', Carbon::today()->toDateString());

        // Query transaksi dengan relasi menu dan bahan
        $query = Transaksi::with(['menu', 'menu.komposisi.bahan.satuan'])
            ->whereDate('date', $date)
            ->orderBy('date', 'desc');

        // Filter berdasarkan pencarian (misalnya nama menu)
        if ($search = $request->input('search')) {
            $query->whereHas('menu', function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%');
            });
        }

        // Paginasi hasil query
        $transaksis = $query->paginate(20)->appends($request->query());

        // Akses berdasarkan role
        if ($role === 'OWNER') {
            return view('transaksi.index', compact('transaksis', 'date'));
        } elseif ($role === 'user') {
            return view('user.transaksi', compact('transaksis', 'date'));
        } else {
            return abort(403, 'Anda tidak memiliki izin untuk mengakses halaman ini.');
        }
    }


    public function destroy($id)
    {
        Transaksi::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Transaksi berhasil dihapus');
    }
}

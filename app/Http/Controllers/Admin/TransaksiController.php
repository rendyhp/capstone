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
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;



class TransaksiController extends Controller
{
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

        // Ambil data menu lengkap untuk digunakan di view
        $menus = Menu::with('komposisi.bahan.satuan')->get();

        // Filter berdasarkan pencarian nama menu
        if ($search = $request->input('search')) {
            $query->whereHas('menu', function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%');
            });
        }

        // Paginasi hasil query
        $transaksis = $query->paginate(20)->appends($request->query());

        // Routing ke view sesuai role
        if ($role === 'OWNER') {
            return view('transaksi.index', compact('transaksis', 'date', 'menus'));
        } elseif ($role === 'user') {
            return view('user.transaksi', compact('transaksis', 'date', 'menus'));
        } else {
            return abort(403, 'Anda tidak memiliki izin untuk mengakses halaman ini.');
        }
    }


    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,csv'
        ]);

        $file = $request->file('file');
        $filename = 'temp_import_' . time() . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs('temp', $filename);

        session(['temp_excel' => $path]);

        return redirect()->route('transaksi.preview')->with('success', 'File berhasil diupload.');
    }

    public function preview()
    {
        $path = session('temp_excel');

        if (!$path || !Storage::exists($path)) {
            return redirect()->back()->with('error', 'File tidak ditemukan.');
        }

        $data = Excel::toCollection(null, storage_path('app/' . $path))->first();
        $previewData = [];

        foreach ($data as $row) {
            if (!empty($row[0]) && !empty($row[2])) {
                $previewData[] = [
                    'menu' => $row[0],
                    'jumlah' => intval($row[2]),
                ];
            }
        }

        return view('transaksi.preview', compact('previewData'));
    }

    public function deleteTemp()
    {
        $path = session('temp_excel');

        if ($path && Storage::exists($path)) {
            Storage::delete($path);
        }

        session()->forget('temp_excel');

        return redirect()->back()->with('success', 'File sementara dihapus.');
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



    public function edit($id)
    {
        $transaksi = Transaksi::findOrFail($id);
        $menus = Menu::all(); // untuk pilihan menu
        return view('transaksi.edit', compact('transaksi', 'menus'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'menu_id' => 'required|exists:menus,id',
            'jumlah' => 'required|numeric|min:1',
            'date' => 'required|date',
            'catatan' => 'nullable|string'
        ]);

        $transaksi = Transaksi::findOrFail($id);

        $transaksi->update([
            'menu_id' => $request->menu_id,
            'jumlah' => $request->jumlah,
            'date' => $request->date,
            'catatan' => $request->catatan,
        ]);

        // Hapus dan hitung ulang transaksi_detail
        $transaksi->transaksiDetail()->delete();
        $this->hitungBahanTerpakai($transaksi);

        return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil diperbarui.');
    }


    public function destroy($id)
    {
        Transaksi::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Transaksi berhasil dihapus');
    }
}

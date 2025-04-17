<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AkhirTerpakaiSeharusnya;
use App\Models\Bahan;
use App\Models\BahanAkhir;
use App\Models\BahanAwal;

use App\Models\Barang;
use App\Models\HistoryInput;
use App\Models\Satuan;
use Carbon\Carbon;
use Illuminate\Http\Request;


use App\Models\TemporaryFile;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Redirect;

use App\Helpers\LogActivity;

class StockOpnameController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $role = $user->role;

        // Ambil inputan tanggal, default hari ini
        $date = $request->input('date', Carbon::today()->toDateString());
        $search = $request->input('search');

        // Ambil semua data bahan akhir untuk tanggal tertentu
        $query = BahanAkhir::selectRaw('
        bahan_akhirs.bahan_id,
        SUM(bahan_akhirs.jumlah) as total_jumlah,
        MAX(bahan_akhirs.date) as tanggal,
        bahans.name as bahan_name,
        satuans.name as satuan_name
    ')
            ->join('bahans', 'bahan_akhirs.bahan_id', '=', 'bahans.id')
            ->join('satuans', 'bahans.satuan_id', '=', 'satuans.id')
            ->whereNull('bahan_akhirs.deleted_at')
            ->whereDate('bahan_akhirs.date', $date)
            ->when($search, function ($q) use ($search) {
                $q->where('bahans.name', 'like', '%' . $search . '%');
            })
            ->groupBy('bahan_akhirs.bahan_id', 'bahans.name', 'satuans.name')
            ->orderBy('bahans.name', 'asc');



        if (!empty($search)) {
            $query->where('bahans.name', 'like', '%' . $search . '%');
        }

        // Ambil semua data dulu
        $allData = $query->orderByDesc('bahan_akhirs.id')->get();

        // Grouping berdasarkan bahan_id, ambil entri terakhir
        $grouped = $allData->groupBy('bahan_id')->map(function ($items) {
            return $items->first(); // ambil yang id paling besar (terbaru)
        })->values();

        // Manual paginate
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $perPage = 20;
        $currentItems = $grouped->slice(($currentPage - 1) * $perPage, $perPage)->values();
        $bahan_akhirs = new LengthAwarePaginator($currentItems, $grouped->count(), $perPage);
        $bahan_akhirs->appends($request->query());

        // Hitung total jumlah dari seluruh data (bukan hanya yang ditampilkan)
        $total_jumlah = $grouped->sum('jumlah');
        // Data satuan untuk dropdown/modal
        $satuans = Satuan::whereNull('deleted_at')->orderBy('name', 'asc')->get();
        $bahans = Bahan::whereNull('deleted_at')->with('satuan')->orderBy('name', 'asc')->get();

        // Return ke view sesuai role
        if ($role === 'OWNER') {
            return view('stock-opname.index', compact('bahan_akhirs', 'date', 'total_jumlah', 'satuans', 'bahans'));
        } elseif ($role === 'user') {
            return view('user.barang', compact('bahan_akhirs', 'date', 'total_jumlah'));
        } else {
            return abort(403, 'Anda tidak memiliki izin untuk mengakses halaman ini.');
        }
    }




    public function simpan(Request $request)
    {
        $user = Auth::user();
        $role = $user->role;

        // Ambil semua bahan beserta satuan dan jumlah stok akhir (jika ada)
        $stockOpnames = Bahan::with([
            'satuan',
            'bahanAkhir' => function ($query) {
                $query->latest('date'); // Ambil stok akhir terbaru
            }
        ])->orderBy('name', 'asc')
            ->whereNull('deleted_at')
            ->get();

        return view('stock-opname.stock-opname', compact('stockOpnames'));
    }

    public function simpanDataBaru(Request $request)
    {
        $user = Auth::user()->id;

        $validatedData = $request->validate([
            'tanggaltransmasuk' => 'required|date',
            'bahan_id' => 'required|array',
            'jumlah' => 'required|array',
            'save_for_tomorrow' => 'nullable' // boleh tidak dikirim
        ]);

        $tanggalHariIni = $validatedData['tanggaltransmasuk'];
        $tanggalBesok = date('Y-m-d', strtotime($tanggalHariIni . ' +1 day'));
        $saveBesok = $request->has('save_for_tomorrow');

        foreach ($validatedData['bahan_id'] as $index => $bahan_id) {
            $jumlah = $validatedData['jumlah'][$index];

            // Simpan ke BahanAkhir (stok hari ini)
            BahanAkhir::create([
                'user_id' => $user,
                'date' => $tanggalHariIni,
                'bahan_id' => $bahan_id,
                'jumlah' => $jumlah,
            ]);

            // Jika checkbox dicentang, simpan juga untuk besok
            if ($saveBesok) {
                BahanAwal::create([
                    'date' => $tanggalBesok,
                    'bahan_id' => $bahan_id,
                    'jumlah' => $jumlah,
                ]);
            }
        }

        return redirect()->route('stock-opname.index', ['date' => $tanggalHariIni])
            ->with('success', 'Data Stock Opname berhasil disimpan!');
    }

    public function create()
    {

        return view('pages.admin.dataset.create', compact('tags'));
    }

    // edit method
    public function edit($bahan_id, Request $request)
    {
        $entries = BahanAkhir::where('bahan_id', $bahan_id)
            ->whereDate('date', $request->date)  // Ensure the date from request is being used
            ->get();

        $bahan = Bahan::find($bahan_id);

        // Return the data in JSON format
        return response()->json([
            'id' => $bahan_id,
            'date' => $request->date,
            'entries' => $entries,
            'bahan' => $bahan,
        ]);
    }




    public function update($bahan_id, Request $request)
    {
        // Validate the input data
        $request->validate([
            'jumlah.*' => 'required|numeric|min:0.001',  // Ensures positive quantities
            'date' => 'required|date',
        ]);

        $jumlahs = $request->input('jumlah');
        $date = $request->input('date');

        DB::transaction(function () use ($jumlahs, $bahan_id, $date) {
            // Check if there are no quantities or they are all empty
            if (empty($jumlahs) || $this->allItemsAreEmpty($jumlahs)) {
                // If quantities are empty, delete all related entries
                BahanAkhir::where('bahan_id', $bahan_id)
                    ->whereDate('date', $date)
                    ->delete();
            } else {
                // Delete previous entries
                BahanAkhir::where('bahan_id', $bahan_id)
                    ->whereDate('date', $date)
                    ->delete();

                // Insert new entries based on the quantities provided
                foreach ($jumlahs as $jumlah) {
                    BahanAkhir::create([
                        'bahan_id' => $bahan_id,
                        'jumlah' => $jumlah,
                        'date' => $date,
                    ]);
                }
            }
        });

        return redirect()->back()->with('success', 'Data bahan akhir berhasil diperbarui.');
    }

    protected function allItemsAreEmpty($jumlahs)
    {
        return empty(array_filter($jumlahs, function ($value) {
            return !empty($value);
        }));
    }


    public function delete($bahan_akhir_id)
    {
        $bahan_akhir = BahanAkhir::find($bahan_akhir_id);

        if ($bahan_akhir) {
            $bahan_akhir->delete();
            return redirect()->route('stock-opname.index')
                ->with('success', 'Bahan Akhir berhasil dihapus.');
        }

        return redirect()->route('stock-opname.index')
            ->with('error', 'Bahan Akhir tidak ditemukan.');
    }


}

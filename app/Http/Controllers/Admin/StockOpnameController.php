<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bahan;
use App\Models\BahanAkhir;
use App\Models\BahanAwal;
use App\Models\SatuanBahan;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Models\TemporaryFile;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

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
        satuan_bahans.name as satuan_name
    ')
            ->join('bahans', 'bahan_akhirs.bahan_id', '=', 'bahans.id')
            ->join('satuan_bahans', 'bahans.satuan_id', '=', 'satuan_bahans.id')
            ->whereNull('bahan_akhirs.deleted_at')
            ->whereDate('bahan_akhirs.date', $date)
            ->when($search, function ($q) use ($search) {
                $q->where('bahans.name', 'like', '%' . $search . '%');
            })
            ->groupBy('bahan_akhirs.bahan_id', 'bahans.name', 'satuan_bahans.name')
            ->orderBy('bahans.name', 'asc');



        if (!empty($search)) {
            $query->where('bahans.name', 'like', '%' . $search . '%');
        }

        $allData = $query->orderByDesc('bahan_akhirs.id')->get();

        $grouped = $allData->groupBy('bahan_id')->map(function ($items) {
            return $items->first();
        })->values();

        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $perPage = 20;
        $currentItems = $grouped->slice(($currentPage - 1) * $perPage, $perPage)->values();
        $bahan_akhirs = new LengthAwarePaginator($currentItems, $grouped->count(), $perPage);
        $bahan_akhirs->setPath(url()->current());
        $bahan_akhirs->appends($request->query());

        $total_jumlah = $grouped->sum('jumlah');

        $satuans = SatuanBahan::whereNull('deleted_at')->orderBy('name', 'asc')->get();
        $bahans = Bahan::whereNull('deleted_at')->with('satuan')->orderBy('name', 'asc')->get();

        if (in_array($role, ['OWNER', 'MANAJER', 'STAF'])) {
            return view('stock-opname.index', compact('bahan_akhirs', 'date', 'total_jumlah', 'satuans', 'bahans'));
        } else {
            return abort(403, 'Anda tidak memiliki izin untuk mengakses halaman ini.');
        }
    }
    public function simpan(Request $request)
    {
        $user = Auth::user();
        $role = $user->role;

        if (!in_array($role, ['OWNER', 'MANAJER', 'STAF'])) {
            abort(403, 'Anda tidak memiliki izin untuk mengakses halaman ini.');
        }

        $date = $request->input('date');
        $currentPage = $request->input('page', 1);
        $perPage = 20;

        // Gunakan tanggal yang dipilih user, tanpa -1 hari
        $stockOpnames = Bahan::with('satuan')
            ->select('bahans.*')
            ->selectSub(function ($query) use ($date) {
                $query->from('bahan_akhirs')
                    ->select(DB::raw('SUM(jumlah)'))
                    ->whereColumn('bahan_akhirs.bahan_id', 'bahans.id')
                    ->whereDate('bahan_akhirs.date', $date); // pakai $date langsung
            }, 'jumlah_sebelumnya')
            ->whereNull('bahans.deleted_at')
            ->orderBy('bahans.name', 'asc')
            ->skip(($currentPage - 1) * $perPage)
            ->take($perPage + 1)
            ->get();

        $hasNextPage = $stockOpnames->count() > $perPage;
        if ($hasNextPage) {
            $stockOpnames = $stockOpnames->slice(0, $perPage);
        }

        return view('stock-opname.stock-opname', compact('stockOpnames', 'date', 'currentPage', 'hasNextPage'));
    }



    public function simpanDataBaru(Request $request)
    {
        $user = Auth::user()->id;

        $validatedData = $request->validate([
            'tanggaltransmasuk' => 'required|date',
            'bahan_id' => 'required|array',
            'jumlah' => 'required|array',
            'save_for_tomorrow' => 'nullable|boolean',
            'custom_date' => 'nullable|date'
        ]);

        $tanggalHariIni = $validatedData['tanggaltransmasuk'];
        $tanggalBesok = $request->has('custom_date') ? $request->custom_date : date('Y-m-d', strtotime($tanggalHariIni . ' +1 day'));
        $saveBesok = $request->has('save_for_tomorrow');

        foreach ($validatedData['bahan_id'] as $index => $bahan_id) {
            $jumlah = $validatedData['jumlah'][$index];

            BahanAkhir::create([
                'user_id' => $user,
                'date' => $tanggalHariIni,
                'bahan_id' => $bahan_id,
                'jumlah' => $jumlah,
            ]);

            if ($saveBesok) {
                BahanAwal::create([
                    'user_id' => $user,
                    'date' => $tanggalBesok,
                    'bahan_id' => $bahan_id,
                    'jumlah' => $jumlah,
                ]);
            }

        }

        // Cek next page
        $nextPage = $request->input('page', 1) + 1;
        $totalData = Bahan::whereNull('deleted_at')->count();
        if ($nextPage > ceil($totalData / 20)) {
            return redirect()->route('stock-opname.index', ['date' => $tanggalHariIni])
                ->with('success', 'Semua data Stock Opname berhasil disimpan!');
        }

        return redirect()->route('stock-opname.simpan', ['date' => $tanggalHariIni, 'page' => $nextPage])
            ->with('success', 'Data halaman sebelumnya berhasil disimpan!');
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

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AkhirTerpakaiSeharusnya;
use App\Models\Bahan;
use App\Models\BahanAkhir;
use App\Models\BahanAwal;
use App\Models\HistoryInput;
use App\Models\Satuan;
use Carbon\Carbon;
use Illuminate\Http\Request;


use App\Models\TemporaryFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Redirect;

use App\Helpers\LogActivity;

class BahanController extends Controller
{
    public function index(Request $request)
    {

        $user = Auth::user();
        $role = $user->role;

        $query = Bahan::with('satuan')
            ->orderBy('name', 'asc')
            ->whereNull('deleted_at');
        // $tanggalDipilih = request(now()->format('Y-m-d')); // Pastikan ini format 'Y-m-d' misalnya '2025-03-21'

        // $query = Bahan::orderBy('name', 'asc')
        //     ->whereNull('deleted_at')
        //     // ->whereDate('date', $tanggalDipilih)
        //     ->get();
        $bahanAwals = BahanAwal::all();
        $historyInputs = HistoryInput::all();
        $akhirTerpakaiSeharusnyas = AkhirTerpakaiSeharusnya::all();

        $satuans = Satuan::orderBy('name', 'asc')->whereNull('deleted_at')->get();

        // Filter pencarian jika ada input search
        if ($search = $request->input('search')) {
            $query->where('name', 'like', '%' . $search . '%');
        }

        if ($role === 'OWNER') {
            $bahans = $query->paginate(20);

            return view('bahan.index', [
                'bahans' => $bahans,
                'bahanAwals' => $bahanAwals,
                'historyInputs' => $historyInputs,
                'satuans' => $satuans
            ]);
        }
    }

    public function indexStok(Request $request)
    {

        
        $user = Auth::user();
        $role = $user->role;

        $date = $request->input('date', Carbon::today()->toDateString());

        $query = Bahan::with('satuan')->orderBy('name')->whereNull('deleted_at');

        if ($search = $request->input('search')) {
            $query->where('name', 'like', '%' . $search . '%');
        }

        $bahans = $query->paginate(20)->appends($request->query());

        foreach ($bahans as $bahan) {
            $bahan->jumlah_awal = BahanAwal::where('bahan_id', $bahan->id)->value('jumlah') ?? 0;
            $bahan->jumlah_masuk = HistoryInput::where('bahan_id', $bahan->id)
                ->whereDate('date', '<=', $date)
                ->sum('jumlah');
            $bahan->jumlah_terpakai = AkhirTerpakaiSeharusnya::where('bahan_id', $bahan->id)
                ->whereDate('date', '<=', $date)
                ->sum('jumlah');
            $bahan->jumlah_akhir = ($bahan->jumlah_awal + $bahan->jumlah_masuk) - $bahan->jumlah_terpakai;
            $bahan->bahan_akhir = BahanAkhir::where('bahan_id', $bahan->id)
                ->whereDate('date', '<=', $date)
                ->sum('jumlah');
            $bahan->bahan_terbuang = ($bahan->jumlah_akhir - $bahan->bahan_akhir);

        }
        



        return view('bahan.stokIndex', [

            'bahans' => $bahans,
            'satuans' => Satuan::whereNull('deleted_at')->orderBy('name')->get(),
            'date' => $date,
        ]);
    }


    public function indexHistory(Request $request, $id)
    {
        $user = Auth::user();
        $role = $user->role;

        // Ambil satuan bahan & bahan berdasarkan ID
        $bahan = Bahan::with('satuan')->findOrFail($id);

        // Query history input berdasarkan bahan_id
        $query = HistoryInput::with(['bahan.satuan'])
            ->where('bahan_id', $id)
            ->whereNull('deleted_at')
            ->orderBy('date', 'desc');

        // Optional: pencarian nama bahan
        if ($search = $request->input('search')) {
            $query->whereHas('bahan', function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%');
            });
        }

        $historyInputs = $query->paginate(20)->appends($request->query());

        $satuans = Satuan::orderBy('name', 'asc')->whereNull('deleted_at')->get();

        if ($role === 'OWNER') {
            return view('bahan.historyInput', [
                'historyInputs' => $historyInputs,
                'satuans' => $satuans,
                'bahan' => $bahan,
                
            ]);
        }

        return abort(403, 'Anda tidak memiliki izin untuk mengakses halaman ini.');
    }

    public function inputStore(Request $request)
    {
        $validated = $request->validate([
            'bahan_id' => 'required|exists:bahans,id',
            'date' => 'required|date',
            'jumlah' => 'required|numeric|min:0',
        ]);

        HistoryInput::create([
            'user_id' => Auth::id(),
            'bahan_id' => $validated['bahan_id'],
            'date' => $validated['date'],
            'jumlah' => $validated['jumlah'],
        ]);

        return redirect()->back()->with('success', 'Stok berhasil ditambahkan.');
    }






    public function create()
    {

        return view('bahan');
    }

    public function store(Request $request)
    {

        Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'minimum' => 'required|integer|max:20',
            'satuan_id' => 'required',
        ]);

        try {
            $user = Auth::user()->id;

            $Bahan = new Bahan;
            $Bahan->user_id = $user;
            $Bahan->name = $request->input('name');
            $Bahan->description = $request->input('description' ?: '-');
            $Bahan->minimum = $request->input('minimum' ?: 0);
            $Bahan->satuan_id = $request->input('satuan_id' ?: '-');
            $Bahan->save();

            // Panggil fungsi logAdd()
            // LogActivity::addToLog('Create Barang "' . $request->input('name') . '"');

            $dataPerPage = 20;
            $data = DB::table('bahans')->paginate($dataPerPage);
            $lastPage = $data->lastPage();
            return redirect('/data-bahan?page=' . $lastPage)->with('success', 'Data Berhasil Ditambahkan');
        } catch (\Illuminate\Database\QueryException $e) {
            // Check for unique constraint violation
            if ($e->errorInfo[1] == 1062) {
                echo '<script>alert("Bahan sudah ada dalam database.");</script>';
                return redirect('data-bahan')->with('error', 'Bahan Gagal Ditambahkan : Nama Bahan yang diinputkan sudah ada');
            } else {
                throw $e; // Rethrow the exception if it's not due to unique constraint
            }
        }
    }

    public function show($slug)
    {

    }

    public function edit(Bahan $bahan)
    {
        $Bahan = Bahan::findOrFail($bahan->id);
        return view('bahan.index', compact('Bahan'));
    }

    public function update(Request $request, Bahan $bahans)
    {
        Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'minimum' => 'required|integer|max:20',
            'satuan_id' => 'required',
        ]);

        try {
            $user = Auth::user()->id;

            $Bahan = Bahan::findOrFail($request->input('id'));
            $Bahan->user_id = $user;
            $Bahan->name = $request->input('name');
            $Bahan->description = $request->input('description' ?: '-');
            $Bahan->minimum = $request->input('minimum' ?: 0);
            $Bahan->satuan_id = $request->input('satuan_id' ?: '-');
            $Bahan->save();

            return redirect('/data-bahan/')->with('success', 'Data Berhasil Diubah');
        } catch (\Illuminate\Database\QueryException $e) {
            // Check for unique constraint violation
            if ($e->errorInfo[1] == 1062) {
                echo '<script>alert("Bahan sudah ada dalam database.");</script>';
                return redirect('data-bahan')->with('error', 'Bahan Gagal Ditambahkan : Nama Bahan yang diinputkan sudah ada');
            } else {
                throw $e; // Rethrow the exception if it's not due to unique constraint
            }
        }
    }

    public function delete(Request $request)
    {
        $id = $request->id;
        $barang = Bahan::findOrFail($id);

        $barang->deleted_at = now();
        $barang->save();

        return redirect('/data-bahan')->with('success', 'Data Berhasil Dihapus');
    }

    public function deletePermanent(Request $request)
    {
        $slug = $request->slug;

        $bahans = Bahans::where('slug', $slug)->firstOrFail();
        $name = $bahans->title;
        // Lakukan penghapusan permanen menggunakan Eloquent
        Bahan::where('slug', $slug)->forceDelete();
        // Panggil fungsi logAdd()
        LogActivity::addToLog('Delete Permanen Bahan "' . $name . '"');

        // Redirect kembali ke halaman sebelumnya
        return Redirect::back()->with('delete', 'Dataset "' . $name . '" berhasil dihapus permanen');
    }
}

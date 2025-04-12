<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AkhirTerpakaiSeharusnya;
use App\Models\Bahan;
use App\Models\BahanAwal;
use App\Models\HistoryInput;
use App\Models\Satuan;
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

    public function indexHistory(Request $request {{id}})
    {

        $user = Auth::user();
        $role = $user->role;


        $tanggalDipilih = request(now()->format('Y-m-d')); // Pastikan ini format 'Y-m-d' misalnya '2025-03-21'
        $query = HistoryInput::with('satuan')
            ->orderBy('name', 'asc')
            ->whereNull('deleted_at')
            ->whereDate('date', $tanggalDipilih);
        

        // $query = Bahan::orderBy('name', 'asc')
        //     ->whereNull('deleted_at')
        //     // ->whereDate('date', $tanggalDipilih)
        //     ->get();
        

        $satuans = Satuan::orderBy('name', 'asc')->whereNull('deleted_at')->get();

        // Filter pencarian jika ada input search
        if ($search = $request->input('search')) {
            $query->where('name', 'like', '%' . $search . '%');
        }

        if ($role === 'OWNER') {
            $historyInputs = $query->paginate(20);

            return view('bahan.historyInput', [
                
                'historyInputs' => $historyInputs,
                'satuans' => $satuans
            ]);
        }
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

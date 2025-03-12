<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AkhirTerpakaiSeharusnya;
use App\Models\Bahan;
use App\Models\BahanAwal;
use App\Models\Barang;
use App\Models\HistoryInput;
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
        $tanggalDipilih = request('tanggal'); // Pastikan ini format 'Y-m-d'

        $bahan = Bahan::orderBy('name', 'asc')
            ->whereNull('deleted_at')
            ->whereDate('tanggal', $tanggalDipilih)
            ->get();
        $bahanAwal = BahanAwal::all();
        $historyInput = HistoryInput::all();
        $akhirTerpakaiSeharusnya = AkhirTerpakaiSeharusnya::all();

        

        if ($request->ajax()) {
            return datatables()->of($bahan)->toJson();
        }

        return view('pages.admin.dataset.index', compact('bahan', 'bahanAwal', 'historyInput', 'akhirTerpakaiSeharusnya'));
    }
    

    public function create()
    {

        return view('pages.admin.dataset.create', compact('tags'));
    }

    public function store(Request $request)
    {

        Validator::make($request->all(), [
            'name' => 'required',
            'description' => 'required',
            'minimum' => 'required',
            'satuan_id' => 'required',
        ]);

        $user = Auth::user()->id;

        // Simpan data dataset ke database
        Dataset::create([
            'user_id' => $user,
            'name' => $request->name,
            'description' => $request->description,
            'minimum' => $request->minimum,
            'satuan_id' => $request->satuan_id,
        ]);

        // Panggil fungsi logAdd()
        LogActivity::addToLog('Create Bahan "' . $request->name . '"');

        return redirect()->route('admin.dataset')->with('success', 'Bahan "' . $request->name . '" berhasil ditambahkan');
    }

    public function show($slug)
    {
        $bahans = Bahan::where('slug', $slug)
            ->first();

        $bahanAwal = BahanAwal::all();
        $historyInput = HistoryInput::all();
        $akhirTerpakaiSeharusnya = AkhirTerpakaiSeharusnya::all();

        return view('pages.admin.dataset.show', [
            'bahans' => $bahans,
        ], compact('bahan', 'bahanAwal', 'historyInput', 'akhirTerpakaiSeharusnya'));
    }

    public function edit($slug)
    {
        $barangs = DB::table('bahans')->where('slug', $slug)
            ->first();

        return view('pages.admin.dataset.edit', ['bahans' => $barangs]);
    }

    public function update(Request $request, Bahans $bahans)
    {
        Validator::make($request->all(), [
            'name' => 'required',
            'description' => 'required',
            'minimum' => 'required',
            'satuan_id' => 'required',
        ]);

        $user = Auth::user()->id;

        // Cari dataset berdasarkan slug
        $bahans = Bahan::where('slug', $request->slug)->first();


        // Simpan barang ke database
        $bahans->update([
            'user_id' => $user,
            'name' => $request->name,
            'description' => $request->description,
            'minimum' => $request->minimum,
            'satuan_id' => $request->satuan_id,
        ]);

        // Panggil fungsi logAdd()
        LogActivity::addToLog('Update Bahan "' . $request->title . '"');

        return redirect()->route('admin.dataset')
            ->with('update', 'Barang berhasil diperbarui');
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
        return Redirect::back()->with('delete', 'Dataset "'  . $name . '" berhasil dihapus permanen');
    }
}

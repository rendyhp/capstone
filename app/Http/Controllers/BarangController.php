<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use App\Models\Barang;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;

class BarangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $user = Auth::user();
        $role = $user->role;
    
        $query = DB::table('barang');
    
        if ($search = $request->input('search')) {
            $query->where('barang_nama', 'like', '%' . $search . '%');
        }
    
        $query->orderBy('barang_code', 'asc'); // Mengurutkan berdasarkan ID secara ascending
    
        if ($role === 'admin') {
            $barangs = $query->paginate(10);
    
            return view('barang', ['barangs' => $barangs]);
        } elseif ($role === 'user') {
            $barangs = $query->paginate(10);
    
            return view('user.barang', ['barangs' => $barangs]);
        } else {
            return abort(403, 'Anda tidak memiliki izin untuk mengakses halaman ini.');
        }
    }
    
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('barang');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'namabarang' => 'required|string|max:255',
            'merkbarang' => 'nullable|string|max:255',
            'jenisbarang' => 'nullable|string|min:1',
            'tipebarang' => 'nullable|string|max:255',
            'satuan' => 'required|string|max:255'
        ]);
        
        try{
            $Barang = new Barang;
            $kodebarang = Barang::generateBarang();
            $Barang -> barang_code = $kodebarang;
            $Barang -> barang_nama = $request->input('namabarang');
            $Barang -> barang_merk = $request->input('merkbarang') ?: '-';
            $Barang -> barang_jenis = $request->input('jenisbarang')?: '-';
            $Barang -> barang_tipe = $request->input('tipebarang') ?: '-';
            $Barang -> barang_satuan = $request->input('satuan') ?: '-';
            $Barang -> save();
            
            $dataPerPage = 10;
            $data = DB::table('barang')->paginate($dataPerPage);
            $lastPage = $data->lastPage();
            return redirect('/barang?page=' . $lastPage)->with('success', 'Data Berhasil Ditambahkan');

            } catch (\Illuminate\Database\QueryException $e) {
                // Check for unique constraint violation
                if ($e->errorInfo[1] == 1062) {
                    echo '<script>alert("Barang sudah ada dalam database.");</script>';
                    return redirect('barang')->with('error','Barang Gagal Ditambahkan : Kode Barang yang diinputkan sudah ada');
                } else {
                    throw $e; // Rethrow the exception if it's not due to unique constraint
                }
            }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Barang $barang)
    {
        $Barang = Barang::findOrFail($barang->id);
        return view('barang', compact('Barang'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'jenisbarang' => 'nullable|string|max:255',
            'tipebarang' => 'nullable|string|max:255'
        ]);
        try{

        $Barang = Barang::findOrFail($request->input('id'));
        $Barang -> barang_code = $request->input('kodebarang');
        $Barang -> barang_nama = $request->input('namabarang');
        $Barang -> barang_merk = $request->input('merkbarang') ?: '-';
        $Barang -> barang_jenis = $request->input('jenisbarang') ?: '-';
        $Barang -> barang_tipe = $request->input('tipebarang') ?: '-';
        $Barang -> barang_satuan = $request->input('satuan') ?: '-';
        $Barang -> save();
        
        return redirect('/barang/')->with('success', 'Data Berhasil Diubah');
        } catch (\Illuminate\Database\QueryException $e) {
            
            if ($e->errorInfo[1] == 1062) {
                echo '<script>alert("Barang sudah ada dalam database.");</script>';
                return redirect('barang')->with('error','Barang Gagal Diubah');
            } else {
                throw $e; 
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Barang $barang)
    {
        Barang::destroy($barang->id);
        return redirect('/barang')->with('success','Data Berhasil Dihapus');

    }

}

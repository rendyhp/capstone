<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use App\Models\UP;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class UPController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request) : View
    {
        $user = Auth::user();
        $role = $user->role;

        if ($role === 'admin'){
            $search = $request->input('search');
            $query = DB::table('up');
            if($search){
                $query->where('up_nama' , 'like' , '%' .$search. '%');
            }
            $UPs = $query->paginate(10);
            return view('up', compact('UPs'));
        }
        else if($role === 'user'){
            $search = $request->input('search');
            $query = DB::table('up');
            if($search){
                $query->where('up_nama' , 'like' , '%' .$search. '%');
            }
            $UPs = $query->paginate(10);
            return view('user.UP', compact('UPs'));
        }else{
            return abort(403,'Anda tidak memiliki izin untuk mengakses halaman ini.'); 
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('up');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try{
            $Up = new UP;
            $Up -> id = $request->input('up_id');
            $Up -> up_nama = $request->input('namaUP');
            $Up -> up_alamat = $request->input('alamatUP');
            $Up -> latitude = $request->input('latitudeUP');
            $Up -> longitude = $request->input('longitudeUP');
            $Up -> save();

            return redirect('/up')->with('success','Data Berhasil Ditambahkan');
            } catch (\Illuminate\Database\QueryException $e) {
                // Check for unique constraint violation
                if ($e->errorInfo[1] == 1062) {
                    echo '<script>alert("Data sudah ada dalam database.");</script>';
                    return redirect('up')->with('error','Data Gagal Ditambahkan');
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
    public function edit(UP $up)
    {
        $Up = UP::findOrFail($up->id);
        return view('up', compact('Up'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        try {
            $Up = UP::findOrFail($request->input('up_id'));
            $Up->up_nama = $request->input('namaUP');
            $Up->up_alamat = $request->input('alamatUP');
            $Up->latitude = $request->input('latitudeUP');
            $Up->longitude = $request->input('longitudeUP');
            $Up->save();
        
            return redirect('/up')->with('success', 'Data Berhasil Diubah');
        } catch (\Illuminate\Database\QueryException $e) {
            // Check for unique constraint violation
            if ($e->errorInfo[1] == 1062) {
                return redirect('up')->with('error', 'Data sudah ada dalam database.');
            } else {
                return redirect('up')->with('error', 'Terjadi kesalahan saat mengubah data.');
            }
        }
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UP $up)
    {
        UP::destroy($up->id);
        return redirect('/up')->with('success','Data Berhasil Dihapus');
    }
}

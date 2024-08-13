<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\DetailTransaksi;
use App\Models\UP;
use App\Models\User;
use Auth;
use DB;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request){
        
        $query = User::query();
        $unit = Auth::user()->unit;

        $search = $request->input('search'); 
        $query->when($unit != '13000', function ($query) use ($unit) {
            $allowedUnits = ['UP3 Padang', 'UP3 Solok', 'UP3 Bukittinggi', 'UP3 Payakumbuh'];
            return $query->whereHas('up', function ($subquery) use ($unit, $allowedUnits) {
                $subquery->where('unit', $unit)->orWhereIn('unit', $allowedUnits);
            });
        });

            if ($search) {
                $query->where('name', 'like', '%' . $search . '%');
            }

            $users = $query->paginate(8);
            $UPs = UP::all();

        return view('user', ['users' => $users,'UPs' => $UPs]);
    }

    /**
     * Display the specified resource.
     */
    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'no' => 'required|max:255',
            'name' => 'nullable|string|max:255|min:1',
            'email' => 'nullable|string|min:1',
            'role' => 'nullable|enum:admin,user|max:255',
            'unit' => 'nullable|string|min:1'
        ]);
        
        try{
            $User = new User;
            $User -> id = $request->input('no');
            $User -> name = $request->input('username');
            $User -> email = $request->input('email');
            $User -> password = $request->input('password');
            $User -> role = $request->input('role');
            $User -> unit = $request->input('unit');
            $User -> save();
            
            $dataPerPage = 8;
            $data = DB::table('users')->paginate($dataPerPage);
            $lastPage = $data->lastPage();
            return redirect('/user?page=' . $lastPage)->with('success', 'Data Berhasil Ditambahkan');

            } catch (\Illuminate\Database\QueryException $e) {
                // Check for unique constraint violation
                if ($e->errorInfo[1] == 1062) {
                    echo '<script>alert("Barang sudah ada dalam database.");</script>';
                    return redirect('user')->with('error','Barang Gagal Ditambahkan : Kode Barang yang diinputkan sudah ada');
                } else {
                    throw $e; // Rethrow the exception if it's not due to unique constraint
                }
            }
    }
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $User = Barang::findOrFail($user->id);
        return view('user', compact('User'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'no' => 'required|max:255',
            'name' => 'nullable|string|max:255',
            'email' => 'nullable|string|min:1',
            'role' => 'nullable|enum:admin,user|max:255',
            'unit' => 'nullable|string|max:255|min:1'
        ]);
        try{

        $User = User::findOrFail($request->input('no'));
        $User -> name = $request->input('name');
        $User -> email = $request->input('email');
        $User -> password = $request->input('password');
        $User -> role = $request->input('role');
        $User -> unit = $request->input('unit');
        $User -> save();
    
        return redirect('/user')->with('success', 'Data Berhasil Diubah');

        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->errorInfo[1] == 1062) {
                echo '<script>alert("Barang sudah ada dalam database.");</script>';
                return redirect('user')->with('error','Barang Gagal Ditambahkan : Kode Barang yang diinputkan sudah ada');
            } else {
                throw $e; // Rethrow the exception if it's not due to unique constraint
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        User::destroy($user->id);
        return redirect('/user')->with('success','Data Berhasil Dihapus');

    }
}

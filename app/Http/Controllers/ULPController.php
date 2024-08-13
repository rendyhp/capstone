<?php

namespace App\Http\Controllers;
use Auth;
use Illuminate\Http\Request;
use App\Models\UP;
use App\Models\ULP;
use App\Models\User;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;
class ULPController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request) : View
    {
        $user = Auth::user();
        $role = $user->role;
        $unit = $user->unit;
        $query = ULP::query();

        if ($role === 'admin') {

            $search = $request->input('search');
        
            $query->when($unit != '13000', function ($query) use ($unit) {
                $allowedUnits = ['UP3 Padang', 'UP3 Solok', 'UP3 Bukittinggi', 'UP3 Payakumbuh'];
                return $query->whereHas('up', function ($subquery) use ($unit, $allowedUnits) {
                    $subquery->where('up_id', $unit)->orWhereIn('up_id', $allowedUnits);
                });
            });

            if ($search) {
                $query->where('ulp_nama', 'like', '%' . $search . '%');
            }

            $ULPs = $query->paginate(8);
            $users = User::find($unit);
            $UPs = UP::all();

            return view('ULP', compact('UPs', 'ULPs'));

        } 

        elseif ($role === 'user') {

            $search = $request->input('search');
        
            $query->when($unit != '13000', function ($query) use ($unit) {
                $allowedUnits = ['UP3 Padang', 'UP3 Solok', 'UP3 Bukittinggi', 'UP3 Payakumbuh'];
                return $query->whereHas('up', function ($subquery) use ($unit, $allowedUnits) {
                    $subquery->where('up_id', $unit)->orWhereIn('up_id', $allowedUnits);
                });
            });

            if ($search) {
                $query->where('ulp_nama', 'like', '%' . $search . '%');
            }

            $ULPs = $query->paginate(8);
            $users = User::find($unit);
            $UPs = UP::all();

            return view('user.ULP', compact('UPs', 'ULPs'));

        } else {
            return abort(403, 'Anda tidak memiliki izin untuk mengakses halaman ini.');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('ulp');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try{

            $Ulp = new ULP;
            $Ulp -> id = $request->input('ulp_id');
            $Ulp -> ulp_nama = $request->input('namaULP');
            $Ulp -> ulp_alamat = $request->input('alamatULP');
            $Ulp -> ulp_latitude = $request->input('latitudeULP');
            $Ulp -> ulp_longitude = $request->input('longitudeULP');
            $Ulp -> up_id = $request->input('slcup');
            $Ulp -> save();

            return redirect('/ulp')->with('success','Data Berhasil Ditambahkan');
            } catch (\Illuminate\Database\QueryException $e) {
                // Check for unique constraint violation
                if ($e->errorInfo[1] == 1062) {
                    echo '<script>alert("Data sudah ada dalam database.");</script>';
                    return redirect('ulp')->with('error','Data Gagal Ditambahkan');
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
    public function edit(ULP $ulp)
    {
        $Ulp = ULP::findOrFail($ulp->id);
        return view('ulp', compact('Ulp'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        try {
            $ulp = Ulp::findOrFail($request->input('ulp_id'));
            $ulp->ulp_nama = $request->input('namaULP');
            $ulp->ulp_alamat = $request->input('alamatULP');
            $ulp->ulp_latitude = $request->input('latitudeULP');
            $ulp->ulp_longitude = $request->input('longitudeULP');
            $ulp->up_id = $request->input('slcup');
            $ulp->save();
    
            return redirect('/ulp')->with('success', 'Data Berhasil Diubah');
        } catch (\Illuminate\Database\QueryException $e) {
            // Check for unique constraint violation
            if ($e->errorInfo[1] == 1062) {
                echo '<script>alert("Data sudah ada dalam database.");</script>';
                return redirect('ulp')->with('error', 'Data Gagal Diubah');
            } else {
                throw $e; // Rethrow the exception if it's not due to a unique constraint violation
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ULP $ulp)
    {
        ULP::destroy($ulp->id);
        return redirect('/ulp')->with('success','Data Berhasil Dihapus');
    }
}

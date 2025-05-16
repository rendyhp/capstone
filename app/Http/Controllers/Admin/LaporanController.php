<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $role = $user->role;

        $query = DB::table('bahans');


        if ($search = $request->input('search')) {
            $query->where('bahans', 'like', '%' . $search . '%');
        }

        $query->orderBy('created_at', 'asc'); // Mengurutkan berdasarkan ID secara descending

        if ($role === 'OWNER') {
            $bahans = $query->paginate(10);

            return view('laporan.index', ['bahans' => $bahans]);
        } elseif ($role === 'user') {
            $barangs = $query->paginate(10);

            return view('user.barang', ['barangs' => $barangs]);
        } else {
            return abort(403, 'Anda tidak memiliki izin untuk mengakses halaman ini.');
        }
    }

    
}
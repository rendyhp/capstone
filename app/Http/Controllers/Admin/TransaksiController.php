<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notifikasi;
use Illuminate\Http\Request;


use App\Models\TemporaryFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Redirect;

use App\Helpers\LogActivity;

class TransaksiController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $role = $user->role;

        $query = DB::table('transaksis');


        if ($search = $request->input('search')) {
            $query->where('name', 'like', '%' . $search . '%');
        }

        $query->orderBy('created_at', 'desc'); // Mengurutkan berdasarkan ID secara descending

        if ($role === 'OWNER') {
            $transaksis = $query->paginate(10);

            return view('transaksi.index', ['transaksis' => $transaksis]);
        } elseif ($role === 'user') {
            $barangs = $query->paginate(10);

            return view('user.barang', ['barangs' => $barangs]);
        } else {
            return abort(403, 'Anda tidak memiliki izin untuk mengakses halaman ini.');
        }
    }

    
}
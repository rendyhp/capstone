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

class NotifikasiController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $role = $user->role;

        $query = DB::table('notifikasis');


        if ($search = $request->input('search')) {
            $query->where('description', 'like', '%' . $search . '%');
        }

        $query->orderBy('created_at', 'desc'); // Mengurutkan berdasarkan ID secara descending

        if ($role === 'OWNER') {
            $notifikasis = $query->paginate(10);

            return view('notifikasi.index', ['notifikasis' => $notifikasis]);
        } elseif ($role === 'user') {
            $barangs = $query->paginate(10);

            return view('user.barang', ['barangs' => $barangs]);
        } else {
            return abort(403, 'Anda tidak memiliki izin untuk mengakses halaman ini.');
        }
    }

    public function indexReport(Request $request)
    {
        $user = Auth::user();
        $role = $user->role;

        $query = DB::table('notifikasis');


        if ($search = $request->input('search')) {
            $query->where('description', 'like', '%' . $search . '%');
        }

        $query->orderBy('created_at', 'desc'); // Mengurutkan berdasarkan ID secara descending

        if ($role === 'OWNER') {
            $notifikasis = $query->paginate(10);

            return view('report.index', ['notifikasis' => $notifikasis]);
        } elseif ($role === 'user') {
            $barangs = $query->paginate(10);

            return view('user.barang', ['barangs' => $barangs]);
        } else {
            return abort(403, 'Anda tidak memiliki izin untuk mengakses halaman ini.');
        }
    }
}
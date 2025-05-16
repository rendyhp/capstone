<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

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
        } elseif ($role === 'MANAJER') {
            $notifikasis = $query->paginate(10);

            return view('notifikasi.index', ['notifikasis' => $notifikasis]);
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

        if ($role === 'STAF') {
            $notifikasis = $query->paginate(10);

            return view('report.index', ['notifikasis' => $notifikasis]);
        } else {
            return abort(403, 'Anda tidak memiliki izin untuk mengakses halaman ini.');
        }
    }
}
<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\LogActivity;
use App\Http\Controllers\Controller;
use Auth;
use Hash;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Models\LogActivity as LogActivityModel;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\File;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $role = $user->role;

        $query = User::whereNull('deleted_at')
            ->orderByRaw("FIELD(role, 'OWNER', 'MANAJER', 'STAF')")
            ->orderBy('name');

        if ($search = $request->input('search')) {
            $query->where('name', 'like', '%' . $search . '%');
        }

        $userDatas = $query->paginate(20)->appends($request->query());

        if (in_array($role, ['OWNER', 'MANAJER'])) {
            return view('user.index', [
                'userDatas' => $userDatas,
                'maskEmail' => fn($email) => $this->maskEmail($email),
                'role' => $role
            ]);
        } else {
            return abort(403, 'Anda tidak memiliki izin untuk mengakses halaman ini.');
        }
    }


    private function maskEmail($email)
    {
        [$username, $domain] = explode('@', $email);

        if (strlen($username) <= 2) {
            return substr($username, 0, 1) . '*' . '@' . $domain;
        } else {
            return substr($username, 0, 2) . '***' . substr($username, -1) . '@' . $domain;
        }
    }

    public function getEmail($id)
    {
        $user = Auth::user();

        if (!in_array($user->role, ['OWNER', 'MANAJER'])) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $targetUser = User::findOrFail($id);
        return response()->json(['email' => $targetUser->email]);
    }

    public function register(Request $request)
    {
        $user = Auth::user();
        $role = $user->role;

        if (in_array($role, ['OWNER', 'MANAJER'])) {
            return view('user.register', [
            ]);
        } else {
            return abort(403, 'Anda tidak memiliki izin untuk mengakses halaman ini.');
        }
    }

    public function registerStore(Request $request)
    {
        // Cek autentikasi dan role pengguna yang login
        $user = Auth::user();
        $role = $user->role;

        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'role' => 'required|in:OWNER,MANAJER,STAF',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Logika role
        if ($role == 'OWNER') {
            // OWNER bisa membuat role OWNER, MANAGER, atau STAFF
            if (!in_array($request->role, ['OWNER', 'MANAJER', 'STAF'])) {
                abort(403, 'Anda tidak memiliki akses!');
            }
        } elseif ($role == 'MANAJER') {
            // MANAJER hanya bisa membuat STAF
            if ($request->role != 'STAF') {
                abort(403, 'Anda tidak memiliki akses!');
            }
        } else {
            // Selain OWNER dan MANAJER tidak boleh mengakses
            abort(403, 'Anda tidak memiliki akses!');
        }

        // Simpan user
        $user = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'role' => $request->role,
            'password' => Hash::make($request->password),
        ]);

        // Redirect ke protected/user-data dengan pesan sukses
        return redirect('/protected/user-data')->with('message', 'Registrasi Akun ' . $user->name . ' Berhasil!');
    }



    public function delete(Request $request)
    {
        $currentUser = Auth::user();
        $currentRole = $currentUser->role;

        $id = $request->id;
        $targetUser = User::findOrFail($id);
        $targetRole = $targetUser->role;

        if ($currentRole === 'STAF') {
            abort(403, 'Anda tidak memiliki akses!');
        }

        if ($currentRole === 'OWNER' && !in_array($targetRole, ['MANAJER', 'STAF'])) {
            abort(403, 'Anda tidak memiliki akses!');
        }

        if ($currentRole === 'MANAJER' && $targetRole !== 'STAF') {
            abort(403, 'Anda tidak memiliki akses!');
        }

        $targetUser->deleted_at = now();
        $targetUser->save();

        return redirect()->back()->with('success', 'Data ' . $targetUser->name . ' berhasil dihapus');
    }



    public function configIndex()
    {
        $users = User::latest()->get();

        return view('user.index', compact('users'));
    }

    public function configCreate()
    {
        return view('pages.admin.user.register');
    }

    public function configStore(Request $request)
    {
        // Define validation rules
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'string', 'email', 'max:255', 'unique:users'],
            'username' => ['required', 'string', 'min:8', 'max:16', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'confirm' => ['same:password'],
            'role' => ['required', Rule::in(['ADMIN', 'PETUGAS'])], // Use Rule::in for enum validation
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Create user
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'username' => $request->username,
            'password' => bcrypt($request->password), // Securely hash the password
            'role' => $request->role
        ]);

        // Return response
        return redirect()->route('admin.user-config')->with('create', 'User behasil ditambahkan');
    }

    public function clearTmp()
    {
        $directory = public_path('upload/tmp/');
        File::cleanDirectory($directory);

        return redirect()->back();
    }


    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }


    public function logIndex(Request $request)
    {
        $logs = LogActivity::logActivityLists();

        if ($request->ajax()) {
            return datatables()->of($logs)->toJson();
        }

        return view('pages.admin.user.logIndex', compact('logs'));
    }

    public function logDelete(Request $request)
    {
        $id = $request->id;

        $logs = LogActivityModel::where('id', $id)->firstOrFail();
        $subject = $logs->subject;
        // Lakukan penghapusan permanen menggunakan Eloquent
        LogActivityModel::where('id', $id)->forceDelete();
        // Redirect kembali ke halaman sebelumnya
        return Redirect::back()->with('delete', 'Log "' . $subject . '" berhasil dihapus permanen');
    }









}

<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\LogActivity;
use App\Http\Controllers\Controller;
use App\Models\UserProfile;
use App\Models\UserSetting;
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
        $user = Auth::user();
        $role = $user->role;

        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'role' => 'required|in:OWNER,MANAJER,STAF',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($role == 'OWNER') {
            if (!in_array($request->role, ['OWNER', 'MANAJER', 'STAF'])) {
                abort(403, 'Anda tidak memiliki akses!');
            }
        } elseif ($role == 'MANAJER') {
            if ($request->role != 'STAF') {
                abort(403, 'Anda tidak memiliki akses!');
            }
        } else {
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

        // Simpan ke user_profiles dengan default null/null
        UserProfile::create([
            'user_id' => $user->id,
            'phone' => null,
            'address' => null,
            'birth_date' => null,
            'gender' => null,
        ]);
        UserSetting::create([
            'user_id' => $user->id,
            'settings' => json_encode([]), // atau array default
        ]);

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

    public function clearTmp()
    {
        $directory = public_path('upload/tmp/');
        File::cleanDirectory($directory);

        return redirect()->back();
    }
}

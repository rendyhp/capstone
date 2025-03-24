<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\LogActivity;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Models\LogActivity as LogActivityModel;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\File;

class UserController extends Controller
{

    public function configIndex()
    {
        $users = User::latest()->get();

        return view('pages.admin.user.configIndex', compact('users'));
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
            'name'     => $request->name,
            'email'   => $request->email,
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
        return Redirect::back()->with('delete', 'Log "'  . $subject . '" berhasil dihapus permanen');
    }








    public function index()
    {
        $users = User::all();
        return view('admin.user.index', ['user' => $users]);
    }

    public function create()
    {
        return view('admin.user.create');
    }

    public function store(Request $request)
    {
        // Validasi data dari formulir
        $request->validate([
            'name' => 'required',
            'username' => 'required|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'role' => 'required|in:ADMIN,PETUGAS',
        ]);

        // Simpan data ke database
        User::create([
            'name' => $request->input('name'),
            'username' => $request->input('username'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
            'role' => $request->input('role'),
        ]);

        return redirect()->route('admin.user.index')->with('success', 'User berhasil ditambahkan');
    }

    public function show($id)
    {
        $user = User::find($id);
        return view('admin.user.show', ['user' => $user]);
    }

    public function edit($id)
    {
        $user = User::find($id);
        return view('admin.users.edit', ['user' => $user]);
    }

    public function update(Request $request, $id)
    {
        // Validasi data dari formulir
        $request->validate([
            'name' => 'required',
            'username' => 'required|unique:users,username,' . $id,
            'email' => 'required|email|unique:users,email,' . $id,
            'role' => 'required|in:ADMIN,PETUGAS',
        ]);

        // Update data di database
        $user = User::find($id);
        $user->update([
            'name' => $request->input('name'),
            'username' => $request->input('username'),
            'email' => $request->input('email'),
            'role' => $request->input('role'),
        ]);

        return redirect()->route('admin.user.index')->with('success', 'User berhasil diperbarui');
    }

    public function destroy($id)
    {
        // Hapus data dari database
        $users = User::find($id);
        $users->delete();

        return redirect()->route('admin.user.index')->with('success', 'User berhasil dihapus');
    }
}

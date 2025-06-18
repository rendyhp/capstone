<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;




class AuthController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function registration()
    {
        return view('auth.register');
    }

    use AuthenticatesUsers;

    protected $redirectTo;

    public function __construct()
    {
        if (Auth::check() && Auth::user()->role == 'OWNER') {
            $this->redirectTo = route('main.index');
        } elseif (Auth::check() && Auth::user()->role == "MANAJER") {
            $this->redirectTo = route('main.index');
        } elseif (Auth::check() && Auth::user()->role == "STAF") {
            $this->redirectTo = route('main.index');
        }
        $this->middleware('guest')->except('logout');
    }

    public function username()
    {
        return 'username';
    }

    protected function validateLogin(Request $request)
    {
        $this->validate($request, [
            $this->username() => 'required',
            'password' => 'required',
        ]);
    }

    public function postLogin(Request $request)
    {
        $this->validateLogin($request);

        $credentials = $request->only('username', 'password');

        if (Auth::attempt($credentials)) {
            if (Auth::user()->role == 'OWNER' || Auth::user()->role == 'MANAJER' || Auth::user()->role == 'STAF') {
                return redirect()->route('main.index');
            }
        } else {
            return redirect()->back()->with('error', 'Invalid username or password');
        }

        return redirect()->route('login');
    }

    public function postRegistration(Request $request)
    {
        // Define validation rules
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:50'],
            'email' => ['nullable', 'string', 'email', 'max:60', 'unique:users'],
            'username' => ['required', 'string', 'min:8', 'max:20', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'max:30', 'confirmed'],
            'confirm' => ['same:password'],
            'role' => ['required', Rule::in(['OWNER', 'MANAJER', 'STAF'])], // Use Rule::in for enum validation
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Create user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'username' => $request->username,
            'password' => bcrypt($request->password),
            'role' => $request->role
        ]);

        // Return response
        return response()->json([
            'success' => true,
            'message' => 'Data Berhasil Disimpan!',
            'data' => $user
        ]);
    }

    // public function dashboard()
    // {
    //     if (Auth::check()) {
    //         return view('dashboard');
    //     }
    //     return redirect("login")->withSuccess('Opps! You do not have access');
    // }

    public function logout(Request $request)
    {
        // Lakukan logout
        Auth::logout();
        // Lakukan flush session jika diperlukan
        $request->session()->invalidate();

        return redirect()->route('main.index');
    }
}

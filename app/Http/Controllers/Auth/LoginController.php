<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::DASHBOARD;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    protected function authenticated(Request $request, $user)
    {
        session()->flash('success', $user->name .' berhasil login');
        return redirect($this->redirectTo);
    }
    protected function attemptLogin(Request $request)
{
    $credentials = $this->credentials($request);

    if (Auth::attempt($credentials)) {
        return true;
    }

    // Pengecekan apakah email benar
    $user = Auth::getProvider()->retrieveByCredentials($credentials);

    if ($user) {
        // Pengecekan apakah password yang dimasukkan benar atau salah
        if (!Auth::getProvider()->validateCredentials($user, $credentials)) {
            session()->flash('error', 'Password salah.');
        } else {
            session()->flash('error', 'Email atau Password salah.');
        }
    } else {
        session()->flash('error', 'Email dan Password invalid');
    }

    return false;
}

    
}

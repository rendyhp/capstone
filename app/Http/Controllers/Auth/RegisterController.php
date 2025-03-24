<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class RegisterController extends Controller
{
    use RegistersUsers;

    public function __construct()
    {
        $this->middleware('admin');
        // return redirect()->to('/')->send();
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:50'],
        'email' => ['nullable', 'string', 'email', 'max:60', 'unique:users'],
        'username' => ['required', 'string', 'min:8', 'max:20', 'unique:users'],
        'password' => ['required', 'string', 'min:8', 'max:30', 'confirmed'],
        'confirm' => ['same:password'],
        'role' => ['required', Rule::in(['OWNER', 'MANAJER', 'STAF'])], // Use Rule::in for enum validation
        ]);
    }

    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'username' => $data['username'],
            'password' => Hash::make($data['password']),
            'role' => $data['role'],
        ]);
    }
}

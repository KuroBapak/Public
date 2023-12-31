<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest')->except([
            'logout', 'index',
        ]);
    }

    //form register
    public function register(Request $request)
    {
        return view('auth.register');
    }

    //store register
    public function store(Request $request, User $user, Auth $auth)
    {
        $request->validate([
            'name' => 'required|string|max:250',
            'email' => 'required|email|max:250|unique:users,email',
            'password' => 'required|max:8'
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        $credential = $request->only('email','password');
        $auth::attempt($credential);
        $request->session()->regenerate();

        return redirect()->route('index')
        ->withSuccess('PULU PULU');
    }

    //form login
    public function login()
    {
        return view('auth.login');
    }

    //authentication
    public function authentication(Request $request, Auth $auth)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
        $credential = $request->only('email','password');
        if ($auth::attempt($credential))
        {
        $request->session()->regenerate();
        return redirect()->route('index');
        }
        return back()->withErrors([
            'email' => 'Email Atau Password Salah'
        ])->onlyInput('email');
    }


    //logout
    public function logout(Request $request, Auth $auth)
    {
        $auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('auth.login');
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest')->except([
            'logout', 'dashboard',
        ]);
    }

    //form register
    public function register(Request $request)
    {
        return view('auth.register');
    }

    //store register
    public function store(Request $request, User $user, Auth $auth, Profile $profile)
    {
        $request->validate([
            'name' => 'required|string|max:250',
            'email' => 'required|email|max:250|unique:users,email',
            'password' => 'required|max:8',
            'umur' => 'required',
            'bio' => 'required|min:10',
            'alamat' => 'required|min:10',
        ]);

        // User::create([
        //     'name' => $request->name,
        //     'email' => $request->email,
        //     'password' => Hash::make($request->password)
        // ]);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();

        $profile->bio  = $request->bio;
        $profile->alamat  = $request->alamat;
        $profile->umur  = $request->umur;
        $profile->user_id  = $user->id;
        $profile->save();

        $credential = $request->only('email','password');
        $auth::attempt($credential);
        $request->session()->regenerate();

        return redirect()->route('auth.dashboard')
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
        return redirect()->route('auth.dashboard');
        }
        return back()->withErrors([
            'email' => 'Email Atau Password Salah'
        ])->onlyInput('email');
    }

    //dashboard
    public function dashboard()
    {
        if(Auth::check()){
            return view('auth.dashboard');
        }
        return redirect()->route('auth.login');
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
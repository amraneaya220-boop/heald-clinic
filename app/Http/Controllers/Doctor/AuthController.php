<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showRegisterForm()
{
    return view('doctor.auth.register');
}
    public function showLoginForm()
    {
        return view('doctor.auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::guard('doctor')->attempt($credentials)) {
            return redirect()->intended(route('doctor.dashboard'));
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    public function showRegisterForm()
    {
        return view('doctor.auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:doctors',
            'password' => 'required|min:8|confirmed',
            'specialty' => 'required|string',
            'phone' => 'required|string',
        ]);

        $doctor = Doctor::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'specialty' => $request->specialty,
            'phone' => $request->phone,
        ]);

        Auth::guard('doctor')->login($doctor);

        return redirect()->route('doctor.dashboard');
    }

    public function logout()
    {
        Auth::guard('doctor')->logout();
        return redirect()->route('doctor.login.form');
    }
}
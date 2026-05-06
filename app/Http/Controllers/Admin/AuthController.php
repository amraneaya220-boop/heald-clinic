<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    // بيانات الدخول للـ Super Admin
    private $superAdminEmail = 'superadmin@mediease.com';
    private $superAdminPassword = 'admin123456';

    public function showLoginForm()
    {
        return view('super_admin.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // التحقق من البيانات
        if ($request->email === $this->superAdminEmail && $request->password === $this->superAdminPassword) {
            // تخزين جلسة الـ Super Admin
            session(['super_admin_logged_in' => true]);
            session(['super_admin_email' => $request->email]);
            
            return redirect()->route('admin.dashboard');
        }

        return back()->with('error', 'Invalid email or password!');
    }

    public function logout(Request $request)
    {
        session()->forget('super_admin_logged_in');
        session()->forget('super_admin_email');
        
        return redirect()->route('admin.login.form');
    }
}
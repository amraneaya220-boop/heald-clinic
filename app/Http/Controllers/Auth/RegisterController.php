<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Patient;
use App\Models\Clinic;
use App\Models\Doctor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    public function showRegistrationForm($type = 'patient')
    {
        return view('front.register', compact('type'));
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
            'role' => 'required|in:patient,clinic,doctor',
            // حقل إضافي حسب الدور
            'phone' => 'nullable|string',
            'address' => 'nullable|string',
            'specialty' => 'nullable|string',
            'clinic_id' => 'nullable|exists:clinics,id'
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => $data['role']
        ]);

        // إنشاء السجل في الجدول المناسب
        if ($data['role'] === 'patient') {
            Patient::create([
                'user_id' => $user->id,
                'name' => $data['name'],
                'email' => $data['email'],
                'phone' => $request->phone,
                'address' => $request->address
            ]);
        } elseif ($data['role'] === 'clinic') {
            Clinic::create([
                'user_id' => $user->id,
                'name' => $data['name'],
                'email' => $data['email'],
                'phone' => $request->phone,
                'address' => $request->address,
                'status' => 'pending'
            ]);
        } elseif ($data['role'] === 'doctor') {
            Doctor::create([
                'user_id' => $user->id,
                'name' => $data['name'],
                'email' => $data['email'],
                'phone' => $request->phone,
                'specialty' => $request->specialty,
                'clinic_id' => $request->clinic_id
            ]);
        }

        Auth::login($user);
        return redirect('/');
    }
}
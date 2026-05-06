<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Patient;
use App\Models\Clinic;
use App\Models\Doctor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function showLogin($type = 'patient')
    {
        $validTypes = ['patient', 'clinic', 'doctor', 'admin'];
        if (!in_array($type, $validTypes)) {
            $type = 'patient';
        }
        return view('front.login', compact('type'));
    }

    public function showRegister($type = 'patient')
    {
        $validTypes = ['patient', 'clinic', 'doctor'];
        if (!in_array($type, $validTypes)) {
            $type = 'patient';
        }
        return view('front.register', compact('type'));
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
            'role' => 'required|in:patient,clinic,doctor,admin'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $credentials = $request->only('email', 'password');
        $role = $request->role;

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            if ($user->role !== $role) {
                Auth::logout();
                return back()->withErrors(['email' => 'Account type mismatch. Your account type is: ' . $user->role])->withInput();
            }

            $request->session()->regenerate();

            return match ($user->role) {
                'patient' => redirect()->route('patient.home')->with('success', 'Welcome back!'),
                'doctor'  => redirect()->to('/doctor/dashboard')->with('success', 'Welcome back!'),  
                'clinic'  => redirect()->route('clinic.dashboard')->with('success', 'Welcome back!'),
                'admin'   => redirect()->route('admin.dashboard')->with('success', 'Welcome back!'),
                default   => redirect()->route('home'),
            };
        }

        return back()->withErrors(['email' => 'Invalid credentials'])->withInput();
    }

    public function register(Request $request)
    {
        // 1. التحقق من صحة البيانات
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
            'role' => ['required', Rule::in(['patient', 'clinic', 'doctor'])],
            'phone' => 'required|string|max:20',
        ];

        if ($request->role === 'clinic') {
            $rules['address'] = 'required|string';
        } elseif ($request->role === 'doctor') {
            $rules['specialty'] = 'required|string';
            $rules['clinic_name'] = 'required|string';
        } elseif ($request->role === 'patient') {
            $rules['dob'] = 'nullable|date';
            $rules['gender'] = 'nullable|in:Male,Female';
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // 2. إنشاء المستخدم
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'role' => $request->role,
        ]);

        if (!$user) {
            return back()->withErrors(['error' => 'Failed to create user account'])->withInput();
        }

        // 3. إنشاء السجل المرتبط حسب الدور
        try {
            if ($request->role === 'patient') {
                Patient::create([
                    'user_id' => $user->id,
                    'name' => $request->name,
                     'email' => $request->email,
                     'phone' => $request->phone,
                     'dob' => $request->dob,
                    'gender' => $request->gender,
                    'address' => $request->address,
                    'status' => 'active',
                ]);
            } elseif ($request->role === 'clinic') {
                $clinicData = [
                    'user_id' => $user->id,
                    'name' => $request->name,
                    'email' => $request->email,
                    'phone' => $request->phone,
                    'address' => $request->address,
                ];

                // إضافة الأعمدة الاختيارية فقط إذا كانت موجودة في الجدول
                if (Schema::hasColumn('clinics', 'location')) {
                    $clinicData['location'] = $request->city ?? null;
                }
                if (Schema::hasColumn('clinics', 'description')) {
                    $clinicData['description'] = $request->description ?? null;
                }
                if (Schema::hasColumn('clinics', 'status')) {
                    $clinicData['status'] = 'active';
                }

                Clinic::create($clinicData);
                Log::info('Clinic created for user: ' . $user->id);
            } elseif ($request->role === 'doctor') {
                // البحث عن العيادة أو إنشاؤها
                $clinic = Clinic::firstOrCreate(
                    ['name' => $request->clinic_name],
                    [
                        'address' => $request->clinic_address ?? '',
                        'phone' => $request->clinic_phone ?? '',
                        'status' => 'active'
                    ]
                );

                Doctor::create([
                    'user_id' => $user->id,
                    'name' => $request->name,
                    'specialty' => $request->specialty,
                    'email' => $request->email,
                    'phone' => $request->phone,
                    'clinic_id' => $clinic->id,
                    'experience' => $request->experience ?? null,
                    'consultation_fee' => $request->consultation_fee ?? null,
                    'about' => $request->about ?? null,
                    'status' => 'active',
                ]);
            }
        } catch (\Exception $e) {
            $user->delete();
            Log::error('Registration error: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Registration failed: ' . $e->getMessage()])->withInput();
        }

        // 4. تسجيل الدخول
        Auth::login($user);

        if (!Auth::check()) {
            return back()->withErrors(['error' => 'Login failed after registration'])->withInput();
        }

        // 5. التوجيه حسب الدور مع التحقق من وجود المسار
        if ($user->role === 'clinic') {
            if (Route::has('clinic.dashboard')) {
                return redirect()->route('clinic.dashboard')->with('success', 'Account created successfully!');
            } else {
                return redirect()->to('/clinic/dashboard')->with('success', 'Account created successfully!');
            }
        } elseif ($user->role === 'doctor') {
            if (Route::has('doctor.dashboard')) {
                return redirect()->route('doctor.dashboard')->with('success', 'Account created successfully!');
            } else {
                return redirect()->to('/doctor/dashboard')->with('success', 'Account created successfully!');
            }
        } elseif ($user->role === 'patient') {
            return redirect()->route('patient.index')->with('success', 'Account created successfully!');
        }

        return redirect()->route('home')->with('success', 'Account created successfully!');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('home')->with('success', 'You have been logged out successfully.');
    }
}
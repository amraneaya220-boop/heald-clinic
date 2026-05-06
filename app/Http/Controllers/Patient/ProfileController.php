<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
    
    // محاولة جلب المريض عبر user_id أولاً
    $patient = Patient::where('user_id', $user->id)->first();
    
    // إذا لم يوجد، حاول جلب المريض باستخدام نفس البريد الإلكتروني (لتجنب التكرار)
    if (!$patient) {
        $patient = Patient::where('email', $user->email)->first();
    }
    
    // إذا لا يزال غير موجود، قم بإنشائه
    if (!$patient) {
        $patient = Patient::create([
            'user_id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'phone' => '',
            'address' => '',
            'status' => 'active',
        ]);
    } else {
        // إذا وجدنا مريضاً بنفس البريد ولكن user_id مختلف، قم بتحديث user_id ليربطه بالمستخدم الحالي
        if ($patient->user_id != $user->id) {
            $patient->user_id = $user->id;
            $patient->save();
        }
    }
    
    return view('patient.profile', compact('patient'));
}
    
    public function update(Request $request)
    {
        $patient = Patient::where('user_id', Auth::id())->first();
        $user = Auth::user();
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'address' => 'nullable|string',
            'dob' => 'nullable|date',
            'gender' => 'nullable|in:Male,Female',
            'current_password' => 'nullable|required_with:new_password',
            'new_password' => 'nullable|min:6|confirmed'
        ]);
        
        // تحديث معلومات المستخدم
        $user->name = $validated['name'];
        $user->email = $validated['email'];
        
        if (!empty($validated['new_password'])) {
            if (!Hash::check($validated['current_password'], $user->password)) {
                return back()->withErrors(['current_password' => 'Current password is incorrect']);
            }
            $user->password = Hash::make($validated['new_password']);
        }
        $user->save();
        
        // تحديث معلومات المريض
        $patient->name = $validated['name'];
        $patient->email = $validated['email'];
        $patient->phone = $validated['phone'];
        $patient->address = $validated['address'] ?? $patient->address;
        $patient->dob = $validated['dob'] ?? $patient->dob;
        $patient->gender = $validated['gender'] ?? $patient->gender;
        $patient->save();
        
        return redirect()->route('patient.profile')->with('success', 'Profile updated successfully');
    }
    public function apiGet()
{
    $patient = Patient::where('user_id', Auth::id())->first();
    $user = Auth::user();
    
    return response()->json([
        'success' => true,
        'data' => [
            'user' => $user,
            'patient' => $patient
        ]
    ]);
}

public function apiUpdate(Request $request)
{
    $patient = Patient::where('user_id', Auth::id())->first();
    $user = Auth::user();
    
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'phone' => 'required|string|max:20',
        'email' => 'required|email|unique:users,email,' . $user->id,
        'address' => 'nullable|string',
        'dob' => 'nullable|date',
        'gender' => 'nullable|in:Male,Female'
    ]);
    
    $user->name = $validated['name'];
    $user->email = $validated['email'];
    $user->save();
    
    $patient->name = $validated['name'];
    $patient->email = $validated['email'];
    $patient->phone = $validated['phone'];
    $patient->address = $validated['address'] ?? $patient->address;
    $patient->dob = $validated['dob'] ?? $patient->dob;
    $patient->gender = $validated['gender'] ?? $patient->gender;
    $patient->save();
    
    return response()->json(['success' => true, 'message' => 'Profile updated successfully']);
}
}
<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class DoctorSettingController extends Controller
{
    public function index()
    {
        $doctor = Auth::user()->doctor;
        $user = Auth::user();
        $workingDays = json_decode($doctor->working_days ?? '["Sat","Sun","Mon","Tue","Wed","Thu"]', true);

        return view('doctor.settings', compact('doctor', 'user', 'workingDays'));
    }

    public function update(Request $request)
    {
        $doctor = Auth::user()->doctor;
        $user = Auth::user();

        $request->validate([
            'name'        => 'nullable|string|max:255',
            'specialty'   => 'nullable|string|max:255',
            'phone'       => 'nullable|string|max:20',
            'email'       => 'nullable|email|unique:users,email,' . $user->id,
            'clinic_name' => 'nullable|string|max:255',
            'break_time'  => 'nullable|string',
            'working_days'=> 'nullable|array',
            'password'    => 'nullable|string|min:6|confirmed',
        ]);

        // تحديث بيانات المستخدم
        if ($request->filled('name')) $user->name = $request->name;
        if ($request->filled('email')) $user->email = $request->email;
        if ($request->filled('password')) $user->password = Hash::make($request->password);
        $user->save();

        // تحديث بيانات الطبيب
        if ($request->filled('specialty')) $doctor->specialty = $request->specialty;
        if ($request->filled('phone')) $doctor->phone = $request->phone;
        if ($request->filled('clinic_name')) {
            // تحديث أو إنشاء العيادة إذا لزم الأمر
            $clinic = \App\Models\Clinic::firstOrCreate(['name' => $request->clinic_name]);
            $doctor->clinic_id = $clinic->id;
        }
        if ($request->filled('break_time')) $doctor->break_time = $request->break_time;
        if ($request->has('working_days')) $doctor->working_days = json_encode($request->working_days);
        $doctor->save();

        return response()->json(['success' => true]);
    }
    // تحديث الملف الشخصي
public function updateProfile(Request $request)
{
    $doctor = Auth::user()->doctor;
    $user = Auth::user();
    
    $request->validate([
        'name' => 'nullable|string|max:255',
        'phone' => 'nullable|string|max:20',
    ]);
    
    if ($request->filled('name')) $user->name = $request->name;
    if ($request->filled('phone')) $doctor->phone = $request->phone;
    
    $user->save();
    $doctor->save();
    
    return response()->json(['success' => true]);
}

// تحديث كلمة المرور
public function updatePassword(Request $request)
{
    $request->validate([
        'password' => 'required|string|min:6|confirmed'
    ]);
    
    $user = Auth::user();
    $user->password = Hash::make($request->password);
    $user->save();
    
    return response()->json(['success' => true]);
}

// تحديث إعدادات الإشعارات
public function updateNotifications(Request $request)
{
    $doctor = Auth::user()->doctor;
    $doctor->notification_settings = json_encode($request->all());
    $doctor->save();
    
    return response()->json(['success' => true]);
}
}
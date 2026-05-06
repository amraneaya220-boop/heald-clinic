<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{
    // عرض قائمة مواعيد المريض (API)
    public function apiIndex()
    {
        $user = Auth::user();
        $patient = $user->patient;
        
        if (!$patient) {
            return response()->json(['success' => false, 'message' => 'Patient not found'], 404);
        }
        
        $appointments = Appointment::where('patient_id', $patient->id)
            ->with(['doctor', 'clinic'])
            ->orderBy('appointment_date', 'desc')
            ->orderBy('appointment_time', 'desc')
            ->get();
        
        $upcoming = $appointments->filter(function($app) {
            return $app->appointment_date >= now()->toDateString() && $app->status === 'Pending';
        })->values();
        
        $past = $appointments->filter(function($app) {
            return $app->appointment_date < now()->toDateString() || $app->status !== 'Pending';
        })->values();
        
        return response()->json([
            'success' => true,
            'upcoming' => $upcoming,
            'past' => $past
        ]);
    }
    
    // عرض تفاصيل موعد معين
    public function apiShow($id)
    {
        $user = Auth::user();
        $patient = $user->patient;
        
        $appointment = Appointment::where('patient_id', $patient->id)
            ->with(['doctor', 'clinic', 'medicalRecord'])
            ->findOrFail($id);
        
        return response()->json(['success' => true, 'appointment' => $appointment]);
    }
    
    // إلغاء موعد
    public function apiCancel($id)
    {
        $user = Auth::user();
        $patient = $user->patient;
        
        $appointment = Appointment::where('patient_id', $patient->id)->findOrFail($id);
        
        if ($appointment->status !== 'Pending') {
            return response()->json(['success' => false, 'message' => 'Cannot cancel this appointment'], 422);
        }
        
        $appointment->status = 'Cancelled';
        $appointment->save();
        
        return response()->json(['success' => true]);
    }
    
    // تعيين تذكير للموعد (اختياري)
    public function apiSetReminder($id)
    {
        // يمكنك تنفيذ منطق التذكير هنا
        return response()->json(['success' => true, 'message' => 'Reminder set']);
    }
    
    // المواعيد القادمة (للواجهة)
    public function apiUpcoming()
    {
        $user = Auth::user();
        $patient = $user->patient;
        
        $upcoming = Appointment::where('patient_id', $patient->id)
            ->where('appointment_date', '>=', now()->toDateString())
            ->where('status', 'Pending')
            ->with(['doctor', 'clinic'])
            ->orderBy('appointment_date', 'asc')
            ->orderBy('appointment_time', 'asc')
            ->get();
        
        return response()->json(['success' => true, 'upcoming' => $upcoming]);
    }
    
    // المواعيد السابقة
    public function apiPast()
    {
        $user = Auth::user();
        $patient = $user->patient;
        
        $past = Appointment::where('patient_id', $patient->id)
            ->where(function($q) {
                $q->where('appointment_date', '<', now()->toDateString())
                  ->orWhere('status', '!=', 'Pending');
            })
            ->with(['doctor', 'clinic'])
            ->orderBy('appointment_date', 'desc')
            ->orderBy('appointment_time', 'desc')
            ->get();
        
        return response()->json(['success' => true, 'past' => $past]);
    }
}
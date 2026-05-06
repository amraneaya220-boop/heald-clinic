<?php
// app/Http/Controllers/Doctor/DoctorController.php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Notification;
use App\Models\Patient;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DoctorController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:doctor');
    }
    
    public function dashboard()
    {
        $doctorId = Auth::id();
        
        // جلب الطبيب من جدول doctors
        $doctor = \App\Models\Doctor::where('user_id', $doctorId)->first();
        
        if (!$doctor) {
            abort(404, 'Doctor not found');
        }
        
        $today = Carbon::today()->format('Y-m-d');
        
        // Get today's appointments
        $todayAppointments = Appointment::with('patient')
            ->where('doctor_id', $doctor->id)
            ->where('appointment_date', $today)
            ->orderBy('appointment_time')
            ->get();
        
        // Count statistics
        $todayAppointmentsCount = Appointment::where('doctor_id', $doctor->id)
            ->where('appointment_date', $today)
            ->count();
        
        // New patients (patients who had first appointment in last 30 days)
        $newPatientsCount = Patient::where('doctor_id', $doctor->id)
            ->where('created_at', '>=', Carbon::now()->subDays(30))
            ->count();
        
        $completedAppointmentsCount = Appointment::where('doctor_id', $doctor->id)
            ->where('status', 'completed')
            ->count();
        
        $pendingAppointmentsCount = Appointment::where('doctor_id', $doctor->id)
            ->whereIn('status', ['waiting', 'ready'])
            ->count();
        
        // Upcoming appointments (next 7 days excluding today)
        $upcomingAppointments = Appointment::with('patient')
            ->where('doctor_id', $doctor->id)
            ->where('appointment_date', '>', $today)
            ->where('appointment_date', '<=', Carbon::today()->addDays(7))
            ->orderBy('appointment_date')
            ->orderBy('appointment_time')
            ->get();
        
        // Get notifications for the doctor
        $notifications = Notification::where('user_id', $doctorId)
            ->where('user_type', 'doctor')
            ->orderBy('created_at', 'desc')
            ->limit(20)
            ->get();
        
        return view('doctor.dashboard', compact(
            'todayAppointments',
            'todayAppointmentsCount',
            'newPatientsCount',
            'completedAppointmentsCount',
            'pendingAppointmentsCount',
            'upcomingAppointments',
            'notifications'
        ));
    }
    // أضف هذه الدوال في DoctorController

public function appointmentDetail($id)
{
    $doctorId = Auth::id();
    $doctor = \App\Models\Doctor::where('user_id', $doctorId)->first();
    
    $appointment = Appointment::with('patient')
        ->where('id', $id)
        ->where('doctor_id', $doctor->id)
        ->firstOrFail();
    
    // Get medical record for this patient if exists
    $medicalRecord = \App\Models\MedicalRecord::where('patient_id', $appointment->patient_id)
        ->where('appointment_id', $id)
        ->first();
    
    // Get notifications
    $notifications = Notification::where('user_id', $doctorId)
        ->where('user_type', 'doctor')
        ->orderBy('created_at', 'desc')
        ->limit(20)
        ->get();
    
    return view('doctor.appointment-detail', compact('appointment', 'medicalRecord', 'notifications'));
}

public function saveDiagnosis(Request $request)
{
    $request->validate([
        'appointment_id' => 'required|exists:appointments,id',
        'complaint' => 'nullable|string',
        'diagnosis' => 'nullable|string',
        'prescription' => 'nullable|string',
        'notes' => 'nullable|string',
    ]);
    
    $appointment = Appointment::findOrFail($request->appointment_id);
    
    // Create or update medical record
    $medicalRecord = \App\Models\MedicalRecord::updateOrCreate(
        [
            'patient_id' => $appointment->patient_id,
            'appointment_id' => $appointment->id,
        ],
        [
            'complaint' => $request->complaint,
            'diagnosis' => $request->diagnosis,
            'prescription' => $request->prescription,
            'notes' => $request->notes,
            'date' => now(),
        ]
    );
    
    // Create notification
    Notification::create([
        'user_id' => Auth::id(),
        'user_type' => 'doctor',
        'title' => 'Diagnosis added',
        'message' => "Diagnosis and prescription added for patient " . ($appointment->patient->name ?? ''),
        'type' => 'diagnosis',
        'patient_name' => $appointment->patient->name ?? '',
    ]);
    
    return response()->json(['success' => true, 'medical_record' => $medicalRecord]);
}

public function cancelAppointment($id)
{
    $doctorId = Auth::id();
    $doctor = \App\Models\Doctor::where('user_id', $doctorId)->first();
    
    $appointment = Appointment::where('id', $id)
        ->where('doctor_id', $doctor->id)
        ->firstOrFail();
    
    if ($appointment->status == 'completed') {
        return response()->json(['success' => false, 'message' => 'Cannot cancel a completed appointment'], 400);
    }
    
    $appointment->update(['status' => 'cancelled']);
    
    // Create notification
    Notification::create([
        'user_id' => Auth::id(),
        'user_type' => 'doctor',
        'title' => 'Appointment cancelled',
        'message' => "Appointment with " . ($appointment->patient->name ?? '') . " has been cancelled",
        'type' => 'cancelled',
    ]);
    
    return response()->json(['success' => true]);
}

public function completeAppointment($id)
{
    $doctorId = Auth::id();
    $doctor = \App\Models\Doctor::where('user_id', $doctorId)->first();
    
    $appointment = Appointment::where('id', $id)
        ->where('doctor_id', $doctor->id)
        ->firstOrFail();
    
    if ($appointment->status == 'cancelled') {
        return response()->json(['success' => false, 'message' => 'Cannot complete a cancelled appointment'], 400);
    }
    
    $appointment->update(['status' => 'completed']);
    
    // Create notification
    Notification::create([
        'user_id' => Auth::id(),
        'user_type' => 'doctor',
        'title' => 'Appointment completed',
        'message' => "Appointment with " . ($appointment->patient->name ?? '') . " has been completed successfully",
        'type' => 'completed',
        'patient_name' => $appointment->patient->name ?? '',
    ]);
    
    return response()->json(['success' => true]);
}
}
<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use App\Models\Appointment;
use App\Models\MedicalRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PatientRecordController extends Controller
{
    // عرض ملف المريض مع تاريخه الطبي
    public function show($patientId)
    {
        $doctor = Auth::user()->doctor;
        $patient = Patient::findOrFail($patientId);

        // التأكد من أن هذا المريض يخص هذا الطبيب (على الأقل لديه موعد معه)
        $hasAppointment = Appointment::where('doctor_id', $doctor->id)
            ->where('patient_id', $patient->id)
            ->exists();

        if (!$hasAppointment) {
            abort(403, 'You do not have access to this patient record.');
        }

        $medicalRecords = MedicalRecord::where('patient_id', $patient->id)
            ->where('doctor_id', $doctor->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('doctor.patient-record', compact('patient', 'medicalRecords'));
    }

    // إضافة موعد جديد للمريض من قبل الطبيب
    public function addAppointment(Request $request, $patientId)
    {
        $doctor = Auth::user()->doctor;
        $patient = Patient::findOrFail($patientId);

        $request->validate([
            'date' => 'required|date|after_or_equal:today',
            'time' => 'required|date_format:H:i',
        ]);

        $appointment = Appointment::create([
            'doctor_id'        => $doctor->id,
            'patient_id'       => $patient->id,
            'clinic_id'        => $doctor->clinic_id,
            'appointment_date' => $request->date,
            'appointment_time' => $request->time,
            'status'           => 'pending',
            'notes'            => $request->notes ?? null,
        ]);

        return response()->json(['success' => true, 'appointment' => $appointment]);
    }
    // عرض قائمة المرضى
public function index()
{
    $doctor = Auth::user()->doctor;
    $patients = Patient::whereHas('appointments', function($query) use ($doctor) {
        $query->where('doctor_id', $doctor->id);
    })->distinct()->get();
    
    return view('doctor.patients', compact('patients'));
}

// جلب سجلات المريض (API)
public function getRecords($patientId)
{
    $doctor = Auth::user()->doctor;
    $records = MedicalRecord::where('patient_id', $patientId)
        ->where('doctor_id', $doctor->id)
        ->orderBy('created_at', 'desc')
        ->get();
    
    return response()->json(['success' => true, 'data' => $records]);
}

// إضافة وصفة طبية
public function addPrescription(Request $request, $patientId)
{
    $doctor = Auth::user()->doctor;
    
    $request->validate([
        'prescription' => 'required|string',
        'diagnosis' => 'nullable|string'
    ]);
    
    $record = MedicalRecord::create([
        'patient_id' => $patientId,
        'doctor_id' => $doctor->id,
        'prescription' => $request->prescription,
        'diagnosis' => $request->diagnosis,
        'date' => now()->toDateString()
    ]);
    
    return response()->json(['success' => true, 'data' => $record]);
}

// إضافة تشخيص
public function addDiagnosis(Request $request, $patientId)
{
    $doctor = Auth::user()->doctor;
    
    $request->validate([
        'diagnosis' => 'required|string'
    ]);
    
    $record = MedicalRecord::create([
        'patient_id' => $patientId,
        'doctor_id' => $doctor->id,
        'diagnosis' => $request->diagnosis,
        'date' => now()->toDateString()
    ]);
    
    return response()->json(['success' => true, 'data' => $record]);
}
}
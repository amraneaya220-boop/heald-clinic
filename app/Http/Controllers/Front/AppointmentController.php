<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Clinic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon; // added for time conversion

class AppointmentController extends Controller
{
    public function create($doctorId)
    {
        $doctor = Doctor::findOrFail($doctorId);
        return view('front.appointment', compact('doctor'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'doctor_id' => 'required|exists:doctors,id',
            'appointment_date' => 'required|date|after:today',
            'appointment_time' => 'required',
            'patient_name' => 'required|string',
            'patient_phone' => 'required|string',
            'notes' => 'nullable|string'
        ]);

        // Convert time from '02:00 PM' to '14:00:00'
        $data['appointment_time'] = $this->convertTimeTo24Hour($data['appointment_time']);

        $data['status'] = 'Pending';
        if (Auth::check() && Auth::user()->role === 'patient' && Auth::user()->patient) {
            $data['patient_id'] = Auth::user()->patient->id;
        }
        
        Appointment::create($data);
        return redirect()->route('home')->with('success', 'Appointment booked!');
    }

    public function createClinic($clinicId)
    {
        $clinic = Clinic::findOrFail($clinicId);
        return view('front.appointment-clinic', compact('clinic'));
    }

    public function storeClinic(Request $request)
    {
        $data = $request->validate([
            'clinic_name' => 'required|string',
            'appointment_date' => 'required|date|after:today',
            'appointment_time' => 'required',
            'patient_name' => 'required|string',
            'patient_phone' => 'required|string',
            'payment_method' => 'nullable|string'
        ]);

        // Convert time
        $convertedTime = $this->convertTimeTo24Hour($data['appointment_time']);

        Appointment::create([
            'doctor_id' => null,
            'patient_name' => $data['patient_name'],
            'patient_phone' => $data['patient_phone'],
            'appointment_date' => $data['appointment_date'],
            'appointment_time' => $convertedTime,
            'status' => 'Pending',
            'payment_method' => $data['payment_method'] ?? null,
        ]);
        return redirect()->route('home')->with('success', 'Clinic appointment booked!');
    }

    // API methods
    public function apiStore(Request $request)
    {
        $data = $request->validate([
            'doctor_id' => 'required|exists:doctors,id',
            'appointment_date' => 'required|date',
            'appointment_time' => 'required',
            'patient_name' => 'required|string',
            'patient_phone' => 'required|string'
        ]);

        // Convert time
        $data['appointment_time'] = $this->convertTimeTo24Hour($data['appointment_time']);
        $data['status'] = 'Pending';
        $appointment = Appointment::create($data);
        return response()->json(['success' => true, 'data' => $appointment]);
    }

    public function apiStoreClinic(Request $request)
    {
        $data = $request->validate([
            'clinic_name' => 'required|string',
            'appointment_date' => 'required|date',
            'appointment_time' => 'required',
            'patient_name' => 'required|string',
            'patient_phone' => 'required|string'
        ]);

        // Convert time
        $convertedTime = $this->convertTimeTo24Hour($data['appointment_time']);

        $appointment = Appointment::create([
            'patient_name' => $data['patient_name'],
            'patient_phone' => $data['patient_phone'],
            'appointment_date' => $data['appointment_date'],
            'appointment_time' => $convertedTime,
            'status' => 'Pending'
        ]);
        return response()->json(['success' => true, 'data' => $appointment]);
    }

    public function apiPatientAppointments(Request $request)
    {
        $user = Auth::user();
        if (!$user || $user->role !== 'patient') {
            return response()->json(['success' => false, 'message' => 'Unauthenticated'], 401);
        }
        $patient = $user->patient;
        $appointments = Appointment::where('patient_id', $patient->id)
            ->with(['doctor', 'clinic'])
            ->orderBy('appointment_date', 'desc')
            ->get();
        return response()->json(['success' => true, 'data' => $appointments]);
    }

    /**
     * Convert time from 12-hour format (e.g., "02:00 PM") to 24-hour format (14:00:00)
     * If time is already in 24-hour format (H:i or H:i:s), it will be returned as is.
     *
     * @param string $time
     * @return string
     */
    private function convertTimeTo24Hour($time)
    {
        // Try to parse as 12-hour format with AM/PM
        if (preg_match('/\d{1,2}:\d{2}\s?(AM|PM)/i', $time)) {
            return Carbon::createFromFormat('h:i A', $time)->format('H:i:s');
        }
        
        // If already in 24-hour format without seconds, add seconds
        if (preg_match('/^([01]\d|2[0-3]):([0-5]\d)$/', $time)) {
            return $time . ':00';
        }
        
        // If already in full 24-hour format H:i:s, return as is
        if (preg_match('/^([01]\d|2[0-3]):([0-5]\d):([0-5]\d)$/', $time)) {
            return $time;
        }
        
        // Fallback: try to parse with Carbon (handles many formats)
        try {
            return Carbon::parse($time)->format('H:i:s');
        } catch (\Exception $e) {
            // If all fails, return original (will cause DB error, but at least we tried)
            return $time;
        }
    }
}
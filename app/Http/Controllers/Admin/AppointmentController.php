<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Patient;
use App\Models\Doctor;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    public function index()
    {
        $appointments = Appointment::with(['patient', 'doctor'])->latest()->get();
        return view('clinic.appointments.index', compact('appointments'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'doctor_id' => 'required|exists:doctors,id',
            'date' => 'required|date',
            'time' => 'required',
            'notes' => 'nullable|string',
        ]);

        $appointment = Appointment::create([
            ...$validated,
            'status' => 'Pending'
        ]);

        // إرسال إشعار
        \App\Models\Notification::create([
            'type' => 'appointment',
            'message' => "New appointment for {$appointment->patient->name} with {$appointment->doctor->name}",
            'is_read' => false
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Appointment created successfully',
            'appointment' => $appointment->load(['patient', 'doctor'])
        ]);
    }

    public function accept(Appointment $appointment)
    {
        $appointment->update(['status' => 'Accepted']);

        \App\Models\Notification::create([
            'type' => 'appointment',
            'message' => "Appointment ACCEPTED: {$appointment->patient->name} with {$appointment->doctor->name}",
            'is_read' => false
        ]);

        return response()->json(['success' => true, 'status' => 'Accepted']);
    }

    public function reject(Appointment $appointment)
    {
        $appointment->update(['status' => 'Rejected']);

        \App\Models\Notification::create([
            'type' => 'appointment',
            'message' => "Appointment REJECTED: {$appointment->patient->name} with {$appointment->doctor->name}",
            'is_read' => false
        ]);

        return response()->json(['success' => true, 'status' => 'Rejected']);
    }

    public function destroy(Appointment $appointment)
    {
        $appointment->delete();
        return response()->json(['success' => true]);
    }
}
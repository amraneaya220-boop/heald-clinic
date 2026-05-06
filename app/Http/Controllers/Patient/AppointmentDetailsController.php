<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Invoice;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
class AppointmentDetailsController extends Controller
{
    public function show($id)
    {
        $patient = Auth::user()->patient;
        $appointment = Appointment::with(['doctor', 'clinic'])
            ->where('id', $id)
            ->where('patient_id', $patient->id)
            ->firstOrFail();

        $invoice = Invoice::where('appointment_id', $appointment->id)->first();

        return view('patient.appointment-details', compact('appointment', 'invoice'));
    }
}
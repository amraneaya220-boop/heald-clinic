<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Appointment;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        $doctors = Doctor::all();
        $patients = Patient::all();
        $appointments = Appointment::with(['patient', 'doctor'])->latest()->take(10)->get();

        return view('clinic.reports.index', compact('doctors', 'patients', 'appointments'));
    }

    public function generate(Request $request)
    {
        // يمكن توسيعها لاحقًا لإنشاء PDF
        return response()->json([
            'success' => true,
            'message' => 'Report generated successfully'
        ]);
    }
}
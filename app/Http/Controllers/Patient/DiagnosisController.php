<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Models\MedicalRecord;
use App\Models\Patient;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
class DiagnosisController extends Controller
{
    public function index()
    {
        $patient = Patient::where('user_id', Auth::id())->first();
        
        if (!$patient) {
            return redirect()->route('login')->with('error', 'Patient profile not found');
        }
        
        $medicalRecords = MedicalRecord::with(['doctor', 'clinic'])
            ->where('patient_id', $patient->id)
            ->orderBy('date', 'desc')
            ->get();
        
        return view('patient.diagnoses', compact('patient', 'medicalRecords'));
    }
}
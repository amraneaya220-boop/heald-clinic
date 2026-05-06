<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Models\MedicalRecord;
use App\Models\Patient;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
class MedicalRecordController extends Controller
{
    private function getPatient()
    {
        return Patient::where('user_id', Auth::id())->firstOrFail();
    }
    
    public function apiIndex()
    {
        $patient = $this->getPatient();
        $records = MedicalRecord::with(['doctor', 'clinic'])
            ->where('patient_id', $patient->id)
            ->orderBy('date', 'desc')
            ->get();
        
        return response()->json(['success' => true, 'data' => $records]);
    }
    
    public function apiShow($id)
    {
        $patient = $this->getPatient();
        $record = MedicalRecord::with(['doctor', 'clinic', 'appointment'])
            ->where('id', $id)
            ->where('patient_id', $patient->id)
            ->firstOrFail();
        
        return response()->json(['success' => true, 'data' => $record]);
    }
}
<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    public function index()
    {
        $patients = Patient::all();
        return view('clinic.patients.index', compact('patients'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:patients',
            'phone' => 'required|string',
            'dob' => 'nullable|date',
            'gender' => 'in:Male,Female',
            'address' => 'nullable|string',
            'status' => 'in:active,inactive',
        ]);

        $patient = Patient::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Patient added successfully',
            'patient' => $patient
        ]);
    }

    public function update(Request $request, Patient $patient)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:patients,email,' . $patient->id,
            'phone' => 'required|string',
            'dob' => 'nullable|date',
            'gender' => 'in:Male,Female',
            'address' => 'nullable|string',
            'status' => 'in:active,inactive',
        ]);

        $patient->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Patient updated successfully',
            'patient' => $patient
        ]);
    }

    public function destroy(Patient $patient)
    {
        $patient->delete();
        return response()->json(['success' => true, 'message' => 'Patient deleted']);
    }

    public function toggleStatus(Patient $patient)
    {
        $patient->status = $patient->status === 'active' ? 'inactive' : 'active';
        $patient->save();

        return response()->json([
            'success' => true,
            'status' => $patient->status
        ]);
    }
}
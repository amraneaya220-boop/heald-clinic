<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use App\Models\Clinic;
use Illuminate\Http\Request;

class DoctorController extends Controller
{
    public function index($clinicId)
    {
        $clinic = Clinic::findOrFail($clinicId);
        $doctors = $clinic->doctors;
        return view('front.doctors', compact('clinic', 'doctors'));
    }

    public function show($id)
    {
        $doctor = Doctor::with('clinic.reviews.user')->findOrFail($id);
        return view('front.doctor-profile', compact('doctor'));
    }

    // API
    public function apiIndex()
    {
        return response()->json(['success' => true, 'data' => Doctor::with('clinic')->get()]);
    }

    public function apiShow($id)
    {
        return response()->json(['success' => true, 'data' => Doctor::with('clinic')->findOrFail($id)]);
    }

    public function apiGetByClinic($clinicId)
    {
        return response()->json(['success' => true, 'data' => Doctor::where('clinic_id', $clinicId)->get()]);
    }
}
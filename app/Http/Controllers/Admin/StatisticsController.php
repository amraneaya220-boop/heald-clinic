<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Appointment;

class StatisticsController extends Controller
{
    public function index()
    {
        $totalDoctors = Doctor::count();
        $activeDoctors = Doctor::where('status', 'active')->count();
        $totalPatients = Patient::count();
        $activePatients = Patient::where('status', 'active')->count();
        $totalAppointments = Appointment::count();
        $pendingAppointments = Appointment::where('status', 'Pending')->count();
        $acceptedAppointments = Appointment::where('status', 'Accepted')->count();
        $rejectedAppointments = Appointment::where('status', 'Rejected')->count();

        $revenue = $acceptedAppointments * 2500; // افتراضي 2500 دج للاستشارة

        return view('clinic.statistics.index', compact(
            'totalDoctors', 'activeDoctors', 'totalPatients', 'activePatients',
            'totalAppointments', 'pendingAppointments', 'acceptedAppointments',
            'rejectedAppointments', 'revenue'
        ));
    }
}
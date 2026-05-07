<?php
// app/Http/Controllers/Clinic/StatisticsController.php

namespace App\Http\Controllers\Clinic;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Appointment;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class StatisticsController extends Controller
{
    public function index()
    {
        return view('clinic.statistics.index');
    }
    
    public function getStats()
    {
        $user = Auth::user();
        $clinicId = $user->id;
        
        // Get data for current clinic
        $doctors = Doctor::where('clinic_id', $clinicId)->get();
        $patients = Patient::where('clinic_id', $clinicId)->get();
        $appointments = Appointment::where('clinic_id', $clinicId)->get();
        
        // Basic statistics
        $totalDoctors = $doctors->count();
        $totalPatients = $patients->count();
        $totalAppointments = $appointments->count();
        $pendingAppointments = $appointments->where('status', 'Pending')->count();
        $acceptedAppointments = $appointments->where('status', 'Accepted')->count();
        $rejectedAppointments = $appointments->where('status', 'Rejected')->count();
        
        // Calculate revenue (€50 per accepted appointment)
        $revenue = '€' . number_format($acceptedAppointments * 50, 2);
        
        // Weekly appointments trend
        $weeklyLabels = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
        $weeklyCounts = [0, 0, 0, 0, 0, 0];
        
        foreach ($appointments as $appointment) {
            if ($appointment->appointment_date) {
                $date = Carbon::parse($appointment->appointment_date);
                $dayOfWeek = $date->dayOfWeek;
                if ($dayOfWeek >= 1 && $dayOfWeek <= 6) {
                    $weeklyCounts[$dayOfWeek - 1]++;
                }
            }
        }
        
        // Doctors by specialty
        $specialtyCounts = [];
        foreach ($doctors as $doctor) {
            $specialty = $doctor->specialty ?? 'General';
            if (!isset($specialtyCounts[$specialty])) {
                $specialtyCounts[$specialty] = 0;
            }
            $specialtyCounts[$specialty]++;
        }
        
        $specialtyLabels = array_keys($specialtyCounts);
        $specialtyCountsArray = array_values($specialtyCounts);
        
        // Patients by gender
        $malePatients = $patients->where('gender', 'Male')->count();
        $femalePatients = $patients->where('gender', 'Female')->count();
        
        // Top performing doctors
        $doctorAppointments = [];
        foreach ($appointments->where('status', 'Accepted') as $appointment) {
            $doctorName = $appointment->doctor_name;
            if (!isset($doctorAppointments[$doctorName])) {
                $doctorAppointments[$doctorName] = [
                    'total' => 0,
                    'accepted' => 0
                ];
            }
            $doctorAppointments[$doctorName]['accepted']++;
        }
        
        foreach ($appointments as $appointment) {
            $doctorName = $appointment->doctor_name;
            if (isset($doctorAppointments[$doctorName])) {
                $doctorAppointments[$doctorName]['total']++;
            } else {
                $doctorAppointments[$doctorName] = [
                    'total' => 1,
                    'accepted' => 0
                ];
            }
        }
        
        $topDoctors = [];
        foreach ($doctorAppointments as $name => $data) {
            $doctor = $doctors->firstWhere('name', $name);
            $specialty = $doctor ? $doctor->specialty : 'General';
            $acceptanceRate = $data['total'] > 0 ? round(($data['accepted'] / $data['total']) * 100) : 0;
            
            $topDoctors[] = [
                'name' => $name,
                'specialty' => $specialty,
                'appointments' => $data['total'],
                'acceptance_rate' => $acceptanceRate
            ];
        }
        
        // Sort by appointments count
        usort($topDoctors, function($a, $b) {
            return $b['appointments'] - $a['appointments'];
        });
        
        $data = [
            'total_doctors' => $totalDoctors,
            'total_patients' => $totalPatients,
            'total_appointments' => $totalAppointments,
            'pending_appointments' => $pendingAppointments,
            'accepted_appointments' => $acceptedAppointments,
            'rejected_appointments' => $rejectedAppointments,
            'revenue' => $revenue,
            'weekly_labels' => $weeklyLabels,
            'weekly_counts' => $weeklyCounts,
            'specialty_labels' => $specialtyLabels,
            'specialty_counts' => $specialtyCountsArray,
            'male_patients' => $malePatients,
            'female_patients' => $femalePatients,
        ];
        
        return response()->json([
            'success' => true,
            'data' => $data,
            'top_doctors' => $topDoctors
        ]);
    }
    
}
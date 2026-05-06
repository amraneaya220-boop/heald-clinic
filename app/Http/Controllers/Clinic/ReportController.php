<?php

namespace App\Http\Controllers\Clinic;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Appointment;
use App\Models\Service;

class ReportController extends Controller
{
    public function index()
    {
        // Get data from database
        $doctors = Doctor::all();
        $patients = Patient::all();
        $appointments = Appointment::all();
        
        // Prepare statistics
        $totalDoctors = $doctors->count();
        $activeDoctors = $doctors->where('status', 'active')->count();
        $totalPatients = $patients->count();
        $activePatients = $patients->where('status', 'active')->count();
        $totalAppointments = $appointments->count();
        $pendingAppointments = $appointments->where('status', 'Pending')->count();
        $acceptedAppointments = $appointments->where('status', 'Accepted')->count();
        $totalRevenue = '€' . ($acceptedAppointments * 50);
        
        // Prepare services
        $services = Service::all()->map(function($service) {
            return [
                'name' => $service->name,
                'type' => $service->type ?? 'Service',
                'price' => $service->price,
                'desc' => $service->description
            ];
        });
        
        // If no services in database, use default data
        if ($services->isEmpty()) {
            $services = collect([
                ['name' => 'Consultation', 'type' => 'Service', 'price' => '€50', 'desc' => 'General medical consultation'],
                ['name' => 'Radiology', 'type' => 'Service', 'price' => '€80', 'desc' => 'X-ray imaging'],
                ['name' => 'MRI Scan', 'type' => 'Service', 'price' => '€200', 'desc' => 'Magnetic resonance imaging'],
                ['name' => 'CT Scan', 'type' => 'Service', 'price' => '€150', 'desc' => 'Computer tomography']
            ]);
        }
        
        // Prepare recent appointments
        $recentAppointments = $appointments->take(5)->map(function($appointment) {
            return [
                'patient_name' => $appointment->patient_name,
                'doctor_name' => $appointment->doctor_name,
                'appointment_date' => $appointment->appointment_date,
                'appointment_time' => $appointment->appointment_time,
                'status' => $appointment->status
            ];
        });
        
        return view('clinic.reports.index', compact(
            'totalDoctors', 'activeDoctors', 'totalPatients', 'activePatients',
            'totalAppointments', 'pendingAppointments', 'acceptedAppointments',
            'totalRevenue', 'services', 'recentAppointments'
        ));
    }
    
    public function generate(Request $request)
    {
        // Get data from database
        $doctors = Doctor::all();
        $patients = Patient::all();
        $appointments = Appointment::all();
        
        // Prepare statistics
        $stats = [
            'total_doctors' => $doctors->count(),
            'active_doctors' => $doctors->where('status', 'active')->count(),
            'total_patients' => $patients->count(),
            'active_patients' => $patients->where('status', 'active')->count(),
            'total_appointments' => $appointments->count(),
            'pending_appointments' => $appointments->where('status', 'Pending')->count(),
            'accepted_appointments' => $appointments->where('status', 'Accepted')->count(),
            'total_revenue' => '€' . ($appointments->where('status', 'Accepted')->count() * 50)
        ];
        
        // Prepare services
        $services = Service::all()->map(function($service) {
            return [
                'name' => $service->name,
                'type' => $service->type ?? 'Service',
                'price' => $service->price,
                'desc' => $service->description
            ];
        });
        
        if ($services->isEmpty()) {
            $services = collect([
                ['name' => 'Consultation', 'type' => 'Service', 'price' => '€50', 'desc' => 'General medical consultation'],
                ['name' => 'Radiology', 'type' => 'Service', 'price' => '€80', 'desc' => 'X-ray imaging'],
                ['name' => 'MRI Scan', 'type' => 'Service', 'price' => '€200', 'desc' => 'Magnetic resonance imaging'],
                ['name' => 'CT Scan', 'type' => 'Service', 'price' => '€150', 'desc' => 'Computer tomography']
            ]);
        }
        
        // Prepare recent appointments
        $recentAppointments = $appointments->take(5)->map(function($appointment) {
            return [
                'patient_name' => $appointment->patient_name,
                'doctor_name' => $appointment->doctor_name,
                'date' => $appointment->appointment_date,
                'time' => $appointment->appointment_time,
                'status' => $appointment->status
            ];
        });
        
        $data = [
            'clinic_name' => $request->input('clinic_name'),
            'clinic_location' => $request->input('clinic_location'),
            'report_id' => $request->input('report_id') ?: 'RPT-' . time(),
            'report_date' => $request->input('report_date') ?: date('Y-m-d'),
            'report_time' => $request->input('report_time') ?: date('H:i'),
            'stats' => $stats,
            'services' => $services,
            'recent_appointments' => $recentAppointments,
            'notes' => '- Clinic activity is stable.<br>- Increase in consultation demand this month.<br>- All departments operating normally.'
        ];
        
        return response()->json(['success' => true, 'data' => $data]);
    }
}
<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Invoice;
use App\Models\MedicalRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $patient = $user->patient;

        if (!$patient) {
            // إذا لم يكن للمستخدم سجل مريض، قم بتوجيهه أو عرض رسالة
            return redirect()->route('patient.profile')->withErrors(['error' => 'Patient profile not found. Please complete your profile.']);
        }

        // المواعيد القادمة (Pending وتاريخها اليوم أو مستقبل)
        $upcomingAppointments = Appointment::where('patient_id', $patient->id)
            ->where('appointment_date', '>=', now()->toDateString())
            ->where('status', 'Pending')
            ->orderBy('appointment_date', 'asc')
            ->orderBy('appointment_time', 'asc')
            ->get();

        // إجمالي المبالغ المدفوعة من الفواتير (حسب حالة الفاتورة)
        $totalPaid = Invoice::where('patient_id', $patient->id)
            ->where('status', 'paid')
            ->sum('amount');

        // عدد السجلات الطبية
        $medicalRecordsCount = MedicalRecord::where('patient_id', $patient->id)->count();

        // آخر 5 تشخيصات (مع العلاقة مع الطبيب)
        $recentDiagnoses = MedicalRecord::where('patient_id', $patient->id)
            ->with('doctor')
            ->orderBy('date', 'desc')
            ->limit(5)
            ->get();

        return view('patient.home', compact(
            'upcomingAppointments',
            'totalPaid',
            'medicalRecordsCount',
            'recentDiagnoses'
        ));
    }
}
<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\MedicalRecord;
use App\Models\Notification;
use App\Models\Patient;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DoctorDashboardController extends Controller
{
    public function index()
    {
        // جلب الطبيب المرتبط بالمستخدم الحالي
        $doctor = Doctor::where('user_id', Auth::id())->first();

        if (!$doctor) {
            abort(403, 'Doctor profile not found. Please contact admin.');
        }

        $today = Carbon::today()->toDateString();

        // Today's appointments
        $todayAppointments = Appointment::with('patient')
            ->where('doctor_id', $doctor->id)
            ->where('appointment_date', $today)
            ->orderBy('appointment_time')
            ->get();

        $todayAppointmentsCount = $todayAppointments->count();

        // Statistics - Modified to avoid patients.doctor_id column
        // Get new patients from appointments (patients who had first appointment in last 30 days)
        $newPatientsCount = DB::table('appointments')
            ->where('doctor_id', $doctor->id)
            ->select('patient_id')
            ->distinct()
            ->where('created_at', '>=', Carbon::now()->subDays(30))
            ->count();

        $completedAppointmentsCount = Appointment::where('doctor_id', $doctor->id)
            ->where('status', 'completed')
            ->count();

        $pendingAppointmentsCount = Appointment::where('doctor_id', $doctor->id)
            ->whereIn('status', ['waiting', 'ready', 'pending'])
            ->count();

        // Upcoming appointments (next 7 days excluding today)
        $upcomingAppointments = Appointment::with('patient')
            ->where('doctor_id', $doctor->id)
            ->where('appointment_date', '>', $today)
            ->where('appointment_date', '<=', Carbon::today()->addDays(7))
            ->orderBy('appointment_date')
            ->orderBy('appointment_time')
            ->get();

        // Get notifications for the doctor
        $notifications = Notification::where('user_id', Auth::id())
            ->where('user_type', 'doctor')
            ->orderBy('created_at', 'desc')
            ->limit(20)
            ->get();

        return view('doctor.dashboard', compact(
            'todayAppointments',
            'todayAppointmentsCount',
            'newPatientsCount',
            'completedAppointmentsCount',
            'pendingAppointmentsCount',
            'upcomingAppointments',
            'notifications'
        ));
    }

    /**
     * عرض تفاصيل موعد محدد
     */
    public function appointmentDetail($id)
    {
        $doctor = Doctor::where('user_id', Auth::id())->first();

        if (!$doctor) {
            abort(403, 'Doctor profile not found.');
        }

        $appointment = Appointment::with('patient')
            ->where('id', $id)
            ->where('doctor_id', $doctor->id)
            ->firstOrFail();

        // Get medical record for this appointment
        $medicalRecord = MedicalRecord::where('appointment_id', $id)
            ->orWhere('patient_id', $appointment->patient_id)
            ->first();

        // Get notifications
        $notifications = Notification::where('user_id', Auth::id())
            ->where('user_type', 'doctor')
            ->orderBy('created_at', 'desc')
            ->limit(20)
            ->get();

        return view('doctor.appointment-detail', compact('appointment', 'medicalRecord', 'notifications'));
    }

    /**
     * حفظ التشخيص والوصفة الطبية
     */
    public function saveDiagnosis(Request $request)
    {
        $request->validate([
            'appointment_id' => 'required|exists:appointments,id',
            'complaint' => 'nullable|string',
            'diagnosis' => 'nullable|string',
            'prescription' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        $appointment = Appointment::with('patient')->findOrFail($request->appointment_id);
        
        $doctor = Doctor::where('user_id', Auth::id())->first();
        
        // Verify doctor owns this appointment
        if ($appointment->doctor_id != $doctor->id) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        // Create or update medical record
        $medicalRecord = MedicalRecord::updateOrCreate(
            [
                'appointment_id' => $appointment->id,
                'patient_id' => $appointment->patient_id,
            ],
            [
                'complaint' => $request->complaint,
                'diagnosis' => $request->diagnosis,
                'prescription' => $request->prescription,
                'notes' => $request->notes,
                'date' => now(),
            ]
        );

        // Create notification
        Notification::create([
            'user_id' => Auth::id(),
            'user_type' => 'doctor',
            'title' => 'Diagnosis saved',
            'message' => 'Diagnosis and prescription saved for patient: ' . ($appointment->patient->name ?? 'N/A'),
            'type' => 'diagnosis',
            'read' => false,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Diagnosis saved successfully',
            'medical_record' => $medicalRecord
        ]);
    }

    /**
     * إلغاء الموعد
     */
    public function cancelAppointment($id)
    {
        $doctor = Doctor::where('user_id', Auth::id())->first();

        if (!$doctor) {
            return response()->json(['success' => false, 'message' => 'Doctor not found'], 404);
        }

        $appointment = Appointment::with('patient')
            ->where('id', $id)
            ->where('doctor_id', $doctor->id)
            ->firstOrFail();

        if ($appointment->status === 'completed') {
            return response()->json(['success' => false, 'message' => 'Cannot cancel a completed appointment'], 400);
        }

        $appointment->update(['status' => 'cancelled']);

        // Create notification
        Notification::create([
            'user_id' => Auth::id(),
            'user_type' => 'doctor',
            'title' => 'Appointment cancelled',
            'message' => 'Appointment with ' . ($appointment->patient->name ?? 'N/A') . ' has been cancelled',
            'type' => 'cancelled',
            'read' => false,
        ]);

        return response()->json(['success' => true, 'message' => 'Appointment cancelled successfully']);
    }

    /**
     * إنهاء الفحص (تحديث حالة الموعد إلى مكتمل)
     */
    public function completeAppointment($id)
    {
        $doctor = Doctor::where('user_id', Auth::id())->first();

        if (!$doctor) {
            return response()->json(['success' => false, 'message' => 'Doctor not found'], 404);
        }

        $appointment = Appointment::with('patient')
            ->where('id', $id)
            ->where('doctor_id', $doctor->id)
            ->firstOrFail();

        if ($appointment->status === 'cancelled') {
            return response()->json(['success' => false, 'message' => 'Cannot complete a cancelled appointment'], 400);
        }

        if ($appointment->status === 'completed') {
            return response()->json(['success' => false, 'message' => 'Appointment already completed'], 400);
        }

        $appointment->update(['status' => 'completed']);

        // Create notification
        Notification::create([
            'user_id' => Auth::id(),
            'user_type' => 'doctor',
            'title' => 'Appointment completed',
            'message' => 'Appointment with ' . ($appointment->patient->name ?? 'N/A') . ' has been completed successfully',
            'type' => 'completed',
            'read' => false,
        ]);

        return response()->json(['success' => true, 'message' => 'Appointment completed successfully']);
    }

    /**
     * تعيين إشعار كمقروء
     */
    public function markNotificationAsRead($id)
    {
        $notification = Notification::where('id', $id)
            ->where('user_id', Auth::id())
            ->where('user_type', 'doctor')
            ->first();

        if (!$notification) {
            return response()->json(['success' => false, 'message' => 'Notification not found'], 404);
        }

        $notification->update(['read' => true]);

        return response()->json(['success' => true]);
    }

    /**
     * عرض صفحة إعدادات الطبيب
     */
    public function settings()
    {
        $doctor = Doctor::where('user_id', Auth::id())->first();
        $user = Auth::user();
        
        return view('doctor.settings', compact('doctor', 'user'));
    }
}
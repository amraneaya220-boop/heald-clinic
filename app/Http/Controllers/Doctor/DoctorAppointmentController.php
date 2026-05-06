<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\MedicalRecord;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DoctorAppointmentController extends Controller
{
    // عرض قائمة المواعيد (كلها أو مفلترة)
    public function index()
    {
        $doctor = Auth::user()->doctor;
        $appointments = Appointment::where('doctor_id', $doctor->id)
            ->with('patient')
            ->orderBy('appointment_date', 'asc')
            ->orderBy('appointment_time', 'asc')
            ->get();

        return view('doctor.appointments', compact('appointments'));
    }

    // عرض مواعيد اليوم
    public function today()
    {
        $doctor = Auth::user()->doctor;
        $appointments = Appointment::where('doctor_id', $doctor->id)
            ->where('appointment_date', now()->toDateString())
            ->with('patient')
            ->orderBy('appointment_time', 'asc')
            ->get();

        return view('doctor.appointments', compact('appointments'));
    }

    // عرض المواعيد القادمة
    public function upcoming()
    {
        $doctor = Auth::user()->doctor;
        $appointments = Appointment::where('doctor_id', $doctor->id)
            ->where('appointment_date', '>', now()->toDateString())
            ->with('patient')
            ->orderBy('appointment_date', 'asc')
            ->orderBy('appointment_time', 'asc')
            ->get();

        return view('doctor.appointments', compact('appointments'));
    }

    // عرض المواعيد المكتملة
    public function completed()
    {
        $doctor = Auth::user()->doctor;
        $appointments = Appointment::where('doctor_id', $doctor->id)
            ->where('status', 'completed')
            ->with('patient')
            ->orderBy('appointment_date', 'desc')
            ->get();

        return view('doctor.appointments', compact('appointments'));
    }

    // عرض المواعيد الملغاة
    public function cancelled()
    {
        $doctor = Auth::user()->doctor;
        $appointments = Appointment::where('doctor_id', $doctor->id)
            ->where('status', 'cancelled')
            ->with('patient')
            ->orderBy('appointment_date', 'desc')
            ->get();

        return view('doctor.appointments', compact('appointments'));
    }

    // عرض تفاصيل موعد معين
    public function show($id)
    {
        $doctor = Auth::user()->doctor;
        $appointment = Appointment::where('doctor_id', $doctor->id)
            ->with(['patient', 'medicalRecord'])
            ->findOrFail($id);

        return view('doctor.appointment-detail', compact('appointment'));
    }

    // عرض تفاصيل (alias للـ show)
    public function details($id)
    {
        return $this->show($id);
    }

    // تحديث حالة الموعد
    public function updateStatus(Request $request, $id)
    {
        $doctor = Auth::user()->doctor;
        $appointment = Appointment::where('doctor_id', $doctor->id)->findOrFail($id);

        $request->validate([
            'status' => 'required|in:pending,accepted,rejected,completed,cancelled'
        ]);

        $appointment->status = $request->status;
        $appointment->save();

        return response()->json(['success' => true]);
    }

    // حفظ التشخيص والوصفة الطبية
    public function saveMedicalRecord(Request $request, $id)
    {
        $doctor = Auth::user()->doctor;
        $appointment = Appointment::where('doctor_id', $doctor->id)->findOrFail($id);

        $request->validate([
            'complaint'   => 'nullable|string',
            'diagnosis'   => 'nullable|string',
            'prescription'=> 'nullable|string',
            'notes'       => 'nullable|string',
        ]);

        $medicalRecord = MedicalRecord::updateOrCreate(
            ['appointment_id' => $appointment->id],
            [
                'patient_id'    => $appointment->patient_id,
                'doctor_id'     => $doctor->id,
                'complaint'     => $request->complaint,
                'diagnosis'     => $request->diagnosis,
                'prescription'  => $request->prescription,
                'notes'         => $request->notes,
                'date'          => now()->toDateString(),
            ]
        );

        return response()->json(['success' => true, 'medical_record' => $medicalRecord]);
    }

    // إلغاء الموعد
    public function cancel($id)
    {
        $doctor = Auth::user()->doctor;
        $appointment = Appointment::where('doctor_id', $doctor->id)->findOrFail($id);

        if ($appointment->status === 'completed') {
            return response()->json(['success' => false, 'message' => 'Cannot cancel completed appointment'], 422);
        }

        $appointment->status = 'cancelled';
        $appointment->save();

        return response()->json(['success' => true]);
    }

    // ==================== الدوال الجديدة المضافة ====================

    // حذف الموعد
    public function destroy($id)
    {
        $doctor = Auth::user()->doctor;
        $appointment = Appointment::where('doctor_id', $doctor->id)->findOrFail($id);
        
        // لا يمكن حذف موعد مكتمل
        if ($appointment->status === 'completed') {
            return response()->json(['success' => false, 'message' => 'Cannot delete completed appointment'], 422);
        }
        
        $appointment->delete();
        
        return response()->json(['success' => true]);
    }

    // عرض صفحة تعديل الموعد
    public function edit($id)
    {
        $doctor = Auth::user()->doctor;
        $appointment = Appointment::where('doctor_id', $doctor->id)
            ->with('patient')
            ->findOrFail($id);
        
        return view('doctor.appointment-edit', compact('appointment'));
    }

    // تحديث بيانات الموعد
    public function update(Request $request, $id)
    {
        $doctor = Auth::user()->doctor;
        $appointment = Appointment::where('doctor_id', $doctor->id)->findOrFail($id);
        
        $request->validate([
            'appointment_date' => 'required|date',
            'appointment_time' => 'required',
            'status' => 'required|in:pending,accepted,completed,cancelled',
            'notes' => 'nullable|string'
        ]);
        
        $appointment->update([
            'appointment_date' => $request->appointment_date,
            'appointment_time' => $request->appointment_time,
            'status' => $request->status,
            'notes' => $request->notes
        ]);
        
        if ($request->ajax()) {
            return response()->json(['success' => true]);
        }
        
        return redirect()->route('doctor.appointments.index')->with('success', 'Appointment updated successfully');
    }

    // عرض صفحة إنشاء موعد جديد
    public function create()
    {
        $doctor = Auth::user()->doctor;
        $patients = Patient::whereHas('appointments', function($query) use ($doctor) {
            $query->where('doctor_id', $doctor->id);
        })->get();
        
        // جلب جميع المرضى (إذا لم يكن لديهم مواعيد سابقة)
        $allPatients = Patient::all();
        
        return view('doctor.appointment-create', compact('patients', 'allPatients'));
    }

    // حفظ موعد جديد
    public function store(Request $request)
    {
        $doctor = Auth::user()->doctor;
        
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'appointment_date' => 'required|date|after_or_equal:today',
            'appointment_time' => 'required',
            'notes' => 'nullable|string'
        ]);
        
        // التحقق من عدم وجود موعد مكرر
        $existing = Appointment::where('doctor_id', $doctor->id)
            ->where('appointment_date', $request->appointment_date)
            ->where('appointment_time', $request->appointment_time)
            ->first();
            
        if ($existing) {
            if ($request->ajax()) {
                return response()->json(['success' => false, 'message' => 'Time slot already booked'], 422);
            }
            return back()->with('error', 'This time slot is already booked');
        }
        
        $appointment = Appointment::create([
            'doctor_id' => $doctor->id,
            'patient_id' => $request->patient_id,
            'clinic_id' => $doctor->clinic_id,
            'appointment_date' => $request->appointment_date,
            'appointment_time' => $request->appointment_time,
            'status' => 'pending',
            'notes' => $request->notes
        ]);
        
        if ($request->ajax()) {
            return response()->json(['success' => true, 'appointment' => $appointment]);
        }
        
        return redirect()->route('doctor.appointments.index')->with('success', 'Appointment created successfully');
    }
}
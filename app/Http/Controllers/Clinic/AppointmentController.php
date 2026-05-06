<?php

namespace App\Http\Controllers\Clinic;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class AppointmentController extends Controller
{
    // ========== دوال الاختبار ==========
    public function testConnection()
    {
        try {
            // تجربة جلب كل المواعيد
            $appointments = Appointment::all();
            
            // تجربة جلب أول موعد
            $firstAppointment = Appointment::first();
            
            // تجربة جلب إحصائيات
            $stats = [
                'total' => Appointment::count(),
                'pending' => Appointment::where('status', 'Pending')->count(),
                'accepted' => Appointment::where('status', 'Accepted')->count(),
                'rejected' => Appointment::where('status', 'Rejected')->count(),
            ];
            
            return response()->json([
                'success' => true,
                'message' => 'Connection successful!',
                'appointments_count' => $appointments->count(),
                'first_appointment' => $firstAppointment,
                'stats' => $stats
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // ========== عرض الصفحات ==========
    public function index()
    {
        return view('clinic.appointments.index');
    }

    public function create()
    {
        return view('clinic.patients.create');
    }

    public function edit(Patient $patient)
    {
        return view('clinic.patients.edit', compact('patient'));
    }

    // ========== الدوال الجديدة لـ Manage Appointments Blade ==========
    
    /**
     * جلب البيانات لصفحة Manage Appointments مع الفلاتر
     */
    public function getAppointmentsData(Request $request): JsonResponse
    {
        $clinic = Auth::user()->clinic;
        if (!$clinic) {
            return response()->json(['success' => false, 'data' => [], 'stats' => [
                'total' => 0, 'pending' => 0, 'accepted' => 0, 'rejected' => 0
            ]]);
        }

        // جلب أطباء العيادة
        $doctorIds = Doctor::where('clinic_id', $clinic->id)->pluck('id');

        $query = Appointment::whereIn('doctor_id', $doctorIds)
            ->with(['patient', 'doctor']);

        // فلترة البحث
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->whereHas('patient', function($pq) use ($search) {
                    $pq->where('name', 'like', "%{$search}%");
                })->orWhereHas('doctor', function($dq) use ($search) {
                    $dq->where('name', 'like', "%{$search}%");
                });
            });
        }

        // فلترة الحالة
        if ($request->filled('status') && $request->status != 'all') {
            $query->where('status', $request->status);
        }

        // فلترة التاريخ
        if ($request->filled('date')) {
            $query->where('appointment_date', $request->date);
        }

        $appointments = $query->orderBy('appointment_date', 'asc')
                              ->orderBy('appointment_time', 'asc')
                              ->get();

        // تنسيق البيانات للواجهة
        $formattedAppointments = $appointments->map(function($app) {
            return [
                'id' => $app->id,
                'patient_name' => $app->patient->name ?? 'Unknown',
                'doctor_name' => $app->doctor->name ?? 'Unknown',
                'specialty' => $app->specialty ?? ($app->doctor->specialty ?? 'General'),
                'date' => $app->appointment_date,
                'time' => $app->appointment_time,
                'status' => $app->status,
                'notes' => $app->notes
            ];
        });

        // إحصائيات سريعة
        $stats = [
            'total' => Appointment::whereIn('doctor_id', $doctorIds)->count(),
            'pending' => Appointment::whereIn('doctor_id', $doctorIds)->where('status', 'Pending')->count(),
            'accepted' => Appointment::whereIn('doctor_id', $doctorIds)->where('status', 'Accepted')->count(),
            'rejected' => Appointment::whereIn('doctor_id', $doctorIds)->where('status', 'Rejected')->count(),
        ];

        return response()->json([
            'success' => true,
            'data' => $formattedAppointments,
            'stats' => $stats
        ]);
    }

    /**
     * تخزين موعد جديد من واجهة Manage Appointments
     */
   public function storeAppointment(Request $request): JsonResponse
{
    try {
        $clinic = Auth::user()->clinic;
        if (!$clinic) {
            return response()->json(['success' => false, 'message' => 'عيادة غير موجودة'], 400);
        }

        $validated = $request->validate([
            'patient_name' => 'required|string|max:255',
            'doctor_id'    => 'required|exists:doctors,id',
            'specialty'    => 'nullable|string|max:255',
            'date'         => 'required|date',
            'time'         => 'required',
            'notes'        => 'nullable|string',
        ]);

        $doctor = Doctor::find($validated['doctor_id']);
        if (!$doctor || $doctor->clinic_id != $clinic->id) {
            return response()->json(['success' => false, 'message' => 'الطبيب لا يتبع عيادتك'], 403);
        }

        // البحث عن مريض موجود أو إنشاء جديد - مع تجنب مشكلة email
        $patient = Patient::firstOrCreate(
            ['name' => $validated['patient_name'], 'clinic_id' => $clinic->id],
            [
                'email' => null,
                'phone' => null,
                'address' => null,
                'date_of_birth' => null,
                'gender' => null,
                'blood_type' => null,
                'medical_history' => null
            ]
        );

        $appointment = Appointment::create([
            'patient_id'       => $patient->id,
            'doctor_id'        => $validated['doctor_id'],
            'appointment_date' => $validated['date'],
            'appointment_time' => $validated['time'],
            'specialty'        => $validated['specialty'] ?? ($doctor->specialty ?? 'General'),
            'notes'            => $validated['notes'] ?? null,
            'status'           => 'Pending'
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Appointment created successfully',
            'data' => $appointment->load(['patient', 'doctor'])
        ], 201);

    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => $e->getMessage()
        ], 500);
    }
}

    /**
     * تحديث حالة الموعد (Accept/Reject)
     */
    public function updateAppointmentStatus(Request $request, $id): JsonResponse
    {
        $clinic = Auth::user()->clinic;
        
        $appointment = Appointment::findOrFail($id);
        $doctor = Doctor::find($appointment->doctor_id);
        
        if ($doctor->clinic_id != $clinic->id) {
            return response()->json(['success' => false, 'message' => 'غير مصرح'], 403);
        }

        $request->validate([
            'status' => ['required', Rule::in(['Pending', 'Accepted', 'Rejected'])]
        ]);

        $appointment->status = $request->status;
        $appointment->save();

        return response()->json(['success' => true, 'message' => 'Status updated successfully']);
    }

    /**
     * تحديث موعد كامل
     */
    public function updateAppointment(Request $request, $id): JsonResponse
    {
        $clinic = Auth::user()->clinic;
        
        $appointment = Appointment::findOrFail($id);
        $doctor = Doctor::find($appointment->doctor_id);
        
        if ($doctor->clinic_id != $clinic->id) {
            return response()->json(['success' => false, 'message' => 'غير مصرح'], 403);
        }

        $data = $request->validate([
            'patient_name' => 'required|string|max:255',
            'doctor_name'  => 'nullable|string|max:255',
            'specialty'    => 'nullable|string|max:255',
            'date'         => 'required|date',
            'time'         => 'required',
            'notes'        => 'nullable|string',
        ]);

        // تحديث المريض إذا تغير الاسم
        $patient = Patient::updateOrCreate(
            ['id' => $appointment->patient_id],
            ['name' => $data['patient_name'], 'clinic_id' => $clinic->id]
        );

        $appointment->update([
            'patient_id'       => $patient->id,
            'appointment_date' => $data['date'],
            'appointment_time' => $data['time'],
            'specialty'        => $data['specialty'] ?? $appointment->specialty,
            'notes'            => $data['notes'] ?? null,
        ]);

        return response()->json(['success' => true, 'message' => 'Appointment updated successfully']);
    }

    /**
     * حذف موعد
     */
    public function deleteAppointment($id): JsonResponse
    {
        $clinic = Auth::user()->clinic;
        
        $appointment = Appointment::findOrFail($id);
        $doctor = Doctor::find($appointment->doctor_id);
        
        if ($doctor->clinic_id != $clinic->id) {
            return response()->json(['success' => false, 'message' => 'غير مصرح'], 403);
        }
        
        $appointment->delete();
        return response()->json(['success' => true, 'message' => 'Appointment deleted successfully']);
    }

    /**
     * جلب قائمة الأطباء للـ dropdown
     */
    public function getDoctorsList(): JsonResponse
    {
        $clinic = Auth::user()->clinic;
        if (!$clinic) {
            return response()->json([]);
        }

        $doctors = Doctor::where('clinic_id', $clinic->id)
                        ->select('id', 'name', 'specialty')
                        ->orderBy('name')
                        ->get();

        return response()->json($doctors);
    }

    // ========== الدوال القديمة المحفوظة ==========
    
    public function getAppointments(Request $request): JsonResponse
    {
        $clinic = Auth::user()->clinic;
        if (!$clinic) {
            return response()->json(['success' => false, 'data' => []]);
        }

        $doctorIds = Doctor::where('clinic_id', $clinic->id)->pluck('id');

        $query = Appointment::whereIn('doctor_id', $doctorIds)
            ->with(['patient', 'doctor']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('patient', function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status') && $request->status != 'all') {
            $query->where('status', $request->status);
        }

        $appointments = $query->orderBy('appointment_date', 'desc')
                              ->orderBy('appointment_time', 'desc')
                              ->paginate(15);

        return response()->json(['success' => true, 'data' => $appointments]);
    }

    public function store(Request $request): JsonResponse
    {
        $clinic = Auth::user()->clinic;
        if (!$clinic) {
            return response()->json(['success' => false, 'message' => 'عيادة غير موجودة'], 400);
        }

        $data = $request->validate([
            'patient_id'       => 'required|exists:patients,id',
            'doctor_id'        => 'required|exists:doctors,id',
            'appointment_date' => 'required|date',
            'appointment_time' => 'required',
            'specialty'        => 'nullable|string',
            'notes'            => 'nullable|string',
        ]);

        // تأكد أن الطبيب يتبع نفس العيادة
        $doctor = Doctor::find($data['doctor_id']);
        if ($doctor->clinic_id != $clinic->id) {
            return response()->json(['success' => false, 'message' => 'الطبيب لا يتبع عيادتك'], 403);
        }

        $data['status'] = 'Pending';
        $appointment = Appointment::create($data);

        return response()->json(['success' => true, 'data' => $appointment]);
    }

    public function update(Request $request, Appointment $appointment): JsonResponse
    {
        $clinic = Auth::user()->clinic;
        $doctor = Doctor::find($appointment->doctor_id);
        if ($doctor->clinic_id != $clinic->id) {
            return response()->json(['success' => false, 'message' => 'غير مصرح'], 403);
        }

        $data = $request->validate([
            'patient_id'       => 'required|exists:patients,id',
            'doctor_id'        => 'required|exists:doctors,id',
            'appointment_date' => 'required|date',
            'appointment_time' => 'required',
            'specialty'        => 'nullable|string',
            'notes'            => 'nullable|string',
        ]);

        $appointment->update($data);
        return response()->json(['success' => true, 'data' => $appointment]);
    }

    public function updateStatus(Request $request, Appointment $appointment): JsonResponse
    {
        $clinic = Auth::user()->clinic;
        $doctor = Doctor::find($appointment->doctor_id);
        if ($doctor->clinic_id != $clinic->id) {
            return response()->json(['success' => false, 'message' => 'غير مصرح'], 403);
        }

        $request->validate([
            'status' => ['required', Rule::in(['Pending', 'Accepted', 'Rejected', 'Cancelled'])]
        ]);

        $appointment->status = $request->status;
        $appointment->save();

        return response()->json(['success' => true, 'data' => $appointment]);
    }

    public function destroy(Appointment $appointment): JsonResponse
    {
        $clinic = Auth::user()->clinic;
        $doctor = Doctor::find($appointment->doctor_id);
        if ($doctor->clinic_id != $clinic->id) {
            return response()->json(['success' => false, 'message' => 'غير مصرح'], 403);
        }
        $appointment->delete();
        return response()->json(['success' => true]);
    }
    
}
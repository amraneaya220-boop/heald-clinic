<?php

namespace App\Http\Controllers\Clinic;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class DoctorController extends Controller
{
    /**
     * عرض صفحة الأطباء الرئيسية
     */
    public function index()
    {
        // التحقق من وجود عمود clinic_id
        if (Schema::hasColumn('doctors', 'clinic_id')) {
            $clinicId = auth()->user()->clinic->id ?? null;
            if ($clinicId) {
                $doctors = Doctor::where('clinic_id', $clinicId)->get();
            } else {
                $doctors = Doctor::all();
            }
        } else {
            // إذا لم يكن هناك clinic_id، جلب جميع الأطباء
            $doctors = Doctor::all();
        }

        return view('clinic.doctors.index', compact('doctors'));
    }

    /**
     * جلب بيانات الأطباء مع فلترة وبحث وإحصائيات (API)
     */
    public function getData(Request $request): JsonResponse
    {
        $clinic = $this->getCurrentClinic();
        if (!$clinic) {
            return $this->errorResponse('عيادة غير موجودة', 400, [
                'data'  => [],
                'stats' => $this->emptyStats()
            ]);
        }

        // التحقق من وجود عمود clinic_id قبل استخدامه
        if (Schema::hasColumn('doctors', 'clinic_id')) {
            $query = Doctor::where('clinic_id', $clinic->id);
        } else {
            $query = Doctor::query();
        }

        // بحث
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('specialty', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // فلترة الحالة
        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        $doctors = $query->get();

        return response()->json([
            'success' => true,
            'data'    => $doctors,
            'stats'   => $this->getClinicStats($clinic->id)
        ]);
    }

    /**
     * إضافة طبيب جديد
     */
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'full_name'    => 'required|string|max:255',
            'specialty'    => 'required|string|max:255',
            'email'        => 'required|email|unique:doctors,email',
            'phone'        => 'required|string|max:20',
            'working_days' => 'nullable|string|max:100',
            'status'       => ['required', Rule::in(['active', 'onleave', 'blocked'])],
        ]);

        if ($validator->fails()) {
            return $this->errorResponse('Validation failed', 422, $validator->errors());
        }

        $clinic = $this->getCurrentClinic();
        if (!$clinic) {
            return $this->errorResponse('عيادة غير موجودة', 400);
        }

        // إنشاء الطبيب بدون clinic_id لأن العمود غير موجود في قاعدة البيانات
        $doctorData = [
            'name'         => $request->full_name,
            'specialty'    => $request->specialty,
            'email'        => $request->email,
            'phone'        => $request->phone,
            'working_days' => $request->working_days,
            'status'       => $request->status,
            'password'     => bcrypt('default123'),
        ];

        // إذا كان عمود clinic_id موجود في قاعدة البيانات، أضفه
        if (Schema::hasColumn('doctors', 'clinic_id')) {
            $doctorData['clinic_id'] = $clinic->id;
        }

        $doctor = Doctor::create($doctorData);

        return response()->json([
            'success' => true,
            'message' => 'تم إضافة الطبيب بنجاح',
            'data'    => $doctor
        ]);
        
    }

    /**
     * تبديل حالة الطبيب بالتتابع (active -> onleave -> blocked)
     */
    public function toggleStatus(Doctor $doctor): JsonResponse
    {
        if (!$this->isDoctorBelongsToCurrentClinic($doctor)) {
            return $this->errorResponse('غير مصرح به', 403);
        }

        $statuses = ['active', 'onleave', 'blocked'];
        $currentIndex = array_search($doctor->status, $statuses);
        $nextStatus = $statuses[($currentIndex + 1) % 3];

        $doctor->status = $nextStatus;
        $doctor->save();

        return response()->json([
            'success' => true,
            'status'  => $doctor->status,
            'message' => 'تم تغيير الحالة بنجاح'
        ]);
    }

    /**
     * تحديث بيانات طبيب (PUT/PATCH)
     */
    public function update(Request $request, Doctor $doctor): JsonResponse
    {
        if (!$this->isDoctorBelongsToCurrentClinic($doctor)) {
            return $this->errorResponse('غير مصرح به', 403);
        }

        $validator = Validator::make($request->all(), [
            'name'         => 'required|string|max:255',
            'specialty'    => 'required|string|max:255',
            'email'        => [
                'required',
                'email',
                Rule::unique('doctors', 'email')->ignore($doctor->id)
            ],
            'phone'        => 'nullable|string|max:20',
            'working_days' => 'nullable|string|max:100',
            'status'       => ['nullable', Rule::in(['active', 'onleave', 'blocked'])],
        ]);

        if ($validator->fails()) {
            return $this->errorResponse('Validation failed', 422, $validator->errors());
        }

        $doctor->update($validator->validated());

        return response()->json([
            'success' => true,
            'message' => 'تم تحديث بيانات الطبيب',
            'data'    => $doctor
        ]);
    }

    /**
     * حذف طبيب
     */
    public function destroy(Doctor $doctor): JsonResponse
    {
        if (!$this->isDoctorBelongsToCurrentClinic($doctor)) {
            return $this->errorResponse('غير مصرح به', 403);
        }

        $doctor->delete();

        return response()->json([
            'success' => true,
            'message' => 'تم حذف الطبيب'
        ]);
    }

    /**
     * جلب قائمة الأطباء للـ pagination (إن لزم)
     */
    public function getDoctors(): JsonResponse
    {
        $clinic = $this->getCurrentClinic();
        if (!$clinic) {
            return $this->errorResponse('عيادة غير موجودة', 400, []);
        }

        // التحقق من وجود عمود clinic_id
        if (Schema::hasColumn('doctors', 'clinic_id')) {
            $doctors = Doctor::where('clinic_id', $clinic->id)
                         ->orderBy('name')
                         ->paginate(15);
        } else {
            $doctors = Doctor::orderBy('name')->paginate(15);
        }

        return response()->json([
            'success' => true,
            'data'    => $doctors
        ]);
    }

    /**
     * قائمة مبسطة (للـ dropdowns)
     */
    public function list(): JsonResponse
    {
        $clinic = $this->getCurrentClinic();
        if (!$clinic) {
            return $this->errorResponse('عيادة غير موجودة', 400, []);
        }

        // التحقق من وجود عمود clinic_id
        if (Schema::hasColumn('doctors', 'clinic_id')) {
            $doctors = Doctor::where('clinic_id', $clinic->id)
                         ->select('id', 'name', 'specialty')
                         ->get();
        } else {
            $doctors = Doctor::select('id', 'name', 'specialty')->get();
        }

        return response()->json($doctors);
    }

    // --------------------- PRIVATE HELPER METHODS ---------------------

    /**
     * الحصول على العيادة الحالية من المستخدم المسجل
     */
    private function getCurrentClinic()
    {
        return auth()->user()?->clinic;
    }

    /**
     * التحقق من أن الطبيب ينتمي للعيادة الحالية
     */
    private function isDoctorBelongsToCurrentClinic(Doctor $doctor): bool
    {
        // إذا كان عمود clinic_id غير موجود، نعتبر أن جميع الأطباء مسموحون
        if (!Schema::hasColumn('doctors', 'clinic_id')) {
            return true;
        }
        
        $clinic = $this->getCurrentClinic();
        return $clinic && $doctor->clinic_id === $clinic->id;
    }

    /**
     * إحصائيات فارغة (لحالة عدم وجود عيادة)
     */
    private function emptyStats(): array
    {
        return [
            'total'      => 0,
            'active'     => 0,
            'onleave'    => 0,
            'specialties'=> 0,
        ];
    }

    /**
     * حساب إحصائيات العيادة (عدد الأطباء الكلي، النشط، في إجازة، التخصصات)
     */
    private function getClinicStats(int $clinicId): array
    {
        // التحقق من وجود عمود clinic_id
        if (Schema::hasColumn('doctors', 'clinic_id')) {
            return [
                'total'      => Doctor::where('clinic_id', $clinicId)->count(),
                'active'     => Doctor::where('clinic_id', $clinicId)->where('status', 'active')->count(),
                'onleave'    => Doctor::where('clinic_id', $clinicId)->where('status', 'onleave')->count(),
                'specialties'=> Doctor::where('clinic_id', $clinicId)->distinct('specialty')->count('specialty'),
            ];
        } else {
            // إذا لم يكن هناك clinic_id، نحسب لكل الأطباء
            return [
                'total'      => Doctor::count(),
                'active'     => Doctor::where('status', 'active')->count(),
                'onleave'    => Doctor::where('status', 'onleave')->count(),
                'specialties'=> Doctor::distinct('specialty')->count('specialty'),
            ];
        }
    }

    /**
     * رد خطأ موحد (JSON)
     */
    private function errorResponse(string $message, int $status = 400, $errors = null): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => $message,
            'errors'  => $errors,
        ], $status);
    }
}
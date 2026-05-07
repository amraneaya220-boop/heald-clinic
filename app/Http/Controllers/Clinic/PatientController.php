<?php

namespace App\Http\Controllers\Clinic;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class PatientController extends Controller
{
    /**
     * عرض صفحة إدارة المرضى الرئيسية
     */
    public function index()
    {
        return view('clinic.patients.index');
    }

    /**
     * عرض نموذج إضافة مريض جديد
     */
    public function create()
    {
        return redirect()->route('clinic.patients.index')->with('error', 'Create view not available. Use the add patient modal.');
    }

    /**
     * عرض نموذج تعديل بيانات مريض
     */
    public function edit(Patient $patient)
    {
        if (!$this->isPatientBelongsToCurrentClinic($patient)) {
            return redirect()->route('clinic.patients.index')->with('error', 'غير مصرح به');
        }
        return redirect()->route('clinic.patients.index')->with('error', 'Edit view not available. Use the edit patient modal.');
    }

    /**
     * جلب بيانات المرضى (API) مع فلترة وبحث وإحصائيات
     */
   public function getData(Request $request): JsonResponse
{
    $clinic = $this->getCurrentClinic();
    if (!$clinic) {
        return $this->errorResponse('عيادة غير موجودة', 400);
    }

    // ❌ حذف whereHas
    // ✅ عرض كل المرضى مباشرة
    $query = Patient::query();

    // البحث
    if ($request->filled('search')) {
        $search = $request->search;
        $query->where(function ($q) use ($search) {
            $q->where('name', 'like', "%{$search}%")
              ->orWhere('email', 'like', "%{$search}%")
              ->orWhere('phone', 'like', "%{$search}%");
        });
    }

    // فلترة الحالة
    if ($request->filled('status') && $request->status !== 'all') {
        $query->where('status', $request->status);
    }

    $patients = $query->orderBy('name')->get(); // بدل paginate باش يسهل JS
    $stats = $this->getClinicStats($clinic->id);

    return response()->json([
        'success' => true,
        'data'    => $patients,
        'stats'   => $stats,
    ]);
}

    /**
     * إضافة مريض جديد (AJAX)
     */
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|unique:patients,email',
            'phone'   => 'required|string|max:20',
            'dob'     => 'nullable|date',
            'gender'  => ['required', Rule::in(['Male', 'Female'])],
            'address' => 'nullable|string|max:500',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse('Validation failed', 422, $validator->errors());
        }

        $patient = Patient::create([
            'name'       => $request->name,
            'email'      => $request->email,
            'phone'      => $request->phone,
            'dob'        => $request->dob,
            'gender'     => $request->gender,
            'address'    => $request->address,
            'last_visit' => now()->toDateString(),
            'status'     => 'active',
            'created_at' => now(),
            'clinic_id'  => auth()->user()->clinic->id, 
             
        ]);

        return response()->json([
            'success' => true,
            'message' => 'تم إضافة المريض بنجاح',
            'data'    => $patient,
        ]);
    }

    /**
     * تحديث بيانات مريض (AJAX)
     */
    public function update(Request $request, Patient $patient): JsonResponse
    {
        if (!$this->isPatientBelongsToCurrentClinic($patient)) {
            return $this->errorResponse('غير مصرح به', 403);
        }

        $validator = Validator::make($request->all(), [
            'name'    => 'required|string|max:255',
            'email'   => ['required', 'email', Rule::unique('patients', 'email')->ignore($patient->id)],
            'phone'   => 'required|string|max:20',
            'dob'     => 'nullable|date',
            'gender'  => ['required', Rule::in(['Male', 'Female'])],
            'address' => 'nullable|string|max:500',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse('Validation failed', 422, $validator->errors());
        }

        $patient->update($validator->validated());

        return response()->json([
            'success' => true,
            'message' => 'تم تحديث بيانات المريض',
            'data'    => $patient,
        ]);
    }

    /**
     * حذف مريض (AJAX)
     */
    public function destroy(Patient $patient): JsonResponse
    {
        if (!$this->isPatientBelongsToCurrentClinic($patient)) {
            return $this->errorResponse('غير مصرح به', 403);
        }

        $patient->delete();

        return response()->json([
            'success' => true,
            'message' => 'تم حذف المريض',
        ]);
    }

    /**
     * تبديل حالة المريض (AJAX)
     */
    public function toggleStatus(Patient $patient): JsonResponse
    {
        if (!$this->isPatientBelongsToCurrentClinic($patient)) {
            return $this->errorResponse('غير مصرح به', 403);
        }

        $patient->status = $patient->status === 'active' ? 'inactive' : 'active';
        $patient->save();

        return response()->json([
            'success' => true,
            'message' => 'تم تغيير حالة المريض',
            'data'    => $patient,
        ]);
    }

    // --------------------- PRIVATE HELPER METHODS ---------------------

    private function getCurrentClinic()
    {
        return Auth::user()?->clinic;
    }

    private function isPatientBelongsToCurrentClinic(Patient $patient): bool
    {
        $clinic = $this->getCurrentClinic();
        if (!$clinic) return false;

        return $patient->appointments()
            ->whereHas('doctor', function ($q) use ($clinic) {
                $q->where('clinic_id', $clinic->id);
            })
            ->exists();
    }

    private function getClinicStats(int $clinicId): array
{
    $baseQuery = Patient::query();

    return [
        'total'        => $baseQuery->count(),
        'active'       => (clone $baseQuery)->where('status', 'active')->count(),
        'new'          => (clone $baseQuery)->whereMonth('created_at', now()->month)->count(),
        'appointments' => 0,
    ];
}
    private function errorResponse(string $message, int $status = 400, $errors = null): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => $message,
            'errors'  => $errors,
        ], $status);
    }
    public function pendingApproval()
    {
        return view('clinic.pending_approval');
    }
}
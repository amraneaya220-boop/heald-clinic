<?php

namespace App\Http\Controllers\Clinic;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Appointment;
use App\Models\Review;
use App\Models\Clinic;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * عرض لوحة التحكم الرئيسية للعيادة
     */
    public function index()
    {
        // الحصول على العيادة المرتبطة بالمستخدم الحالي
        $user = Auth::user();
        
        // تأكد من أن المستخدم لديه عيادة مرتبطة
        $clinic = Clinic::where('user_id', $user->id)->first();
        
        if (!$clinic) {
            return redirect()->to('/clinic/settings')->withErrors(['error' => 'لم يتم العثور على بيانات العيادة الخاصة بك. يرجى إكمال التسجيل.']);
        }
        
        $clinicId = $clinic->id;
        
        // التحقق من وجود عمود clinic_id في جدول doctors
        $hasClinicId = Schema::hasColumn('doctors', 'clinic_id');
        
        if ($hasClinicId) {
            // الحصول على معرفات الأطباء التابعين لهذه العيادة
            $doctorIds = Doctor::where('clinic_id', $clinicId)->pluck('id')->toArray();
            
            // الأطباء التابعين لهذه العيادة
            $totalDoctors = Doctor::where('clinic_id', $clinicId)->count();
            
            $activeDoctorsQuery = Doctor::where('clinic_id', $clinicId);
            if (Schema::hasColumn('doctors', 'status')) {
                $activeDoctors = $activeDoctorsQuery->where('status', 'active')->count();
            } else {
                $activeDoctors = $activeDoctorsQuery->count();
            }
        } else {
            // إذا لم يكن هناك clinic_id، استخدم جميع الأطباء
            $doctorIds = Doctor::pluck('id')->toArray();
            $totalDoctors = Doctor::count();
            $activeDoctors = $totalDoctors;
        }
        
        // جلب أسماء الأطباء من جدول users (التحقق من وجود user_id أولاً)
        $doctorNames = [];
        if (Schema::hasColumn('doctors', 'user_id') && !empty($doctorIds)) {
            $doctorUserIds = Doctor::whereIn('id', $doctorIds)->pluck('user_id')->toArray();
            $doctorUserIds = array_filter($doctorUserIds); // إزالة القيم الفارغة
            if (!empty($doctorUserIds)) {
                $doctorNames = User::whereIn('id', $doctorUserIds)->pluck('name', 'id')->toArray();
            }
        }
        
        // المرضى المرتبطين بالعيادة عبر المواعيد
        if (!empty($doctorIds)) {
            $totalPatients = Patient::whereHas('appointments', function($q) use ($doctorIds) {
                $q->whereIn('doctor_id', $doctorIds);
            })->count();
            
            $activePatientsQuery = Patient::whereHas('appointments', function($q) use ($doctorIds) {
                $q->whereIn('doctor_id', $doctorIds);
            });
            
            if (Schema::hasColumn('patients', 'status')) {
                $activePatients = $activePatientsQuery->where('status', 'active')->count();
            } else {
                $activePatients = $activePatientsQuery->count();
            }
        } else {
            $totalPatients = 0;
            $activePatients = 0;
        }
        
        // المواعيد الخاصة بالعيادة (من خلال الأطباء)
        if (!empty($doctorIds)) {
            $totalAppointments = Appointment::whereIn('doctor_id', $doctorIds)->count();
            $pendingAppointments = Appointment::whereIn('doctor_id', $doctorIds)->where('status', 'Pending')->count();
            $acceptedAppointments = Appointment::whereIn('doctor_id', $doctorIds)->where('status', 'Accepted')->count();
            $rejectedAppointments = Appointment::whereIn('doctor_id', $doctorIds)->where('status', 'Rejected')->count();
        } else {
            $totalAppointments = 0;
            $pendingAppointments = 0;
            $acceptedAppointments = 0;
            $rejectedAppointments = 0;
        }
        
        // الإيرادات
        $revenue = $acceptedAppointments * 50;
        
        // آخر 5 مواعيد حديثة
        if (!empty($doctorIds)) {
            $recentAppointments = Appointment::whereIn('doctor_id', $doctorIds)
                ->with(['patient', 'doctor'])
                ->orderBy('appointment_date', 'desc')
                ->orderBy('appointment_time', 'desc')
                ->limit(5)
                ->get()
                ->map(function($appointment) use ($doctorNames) {
                    $doctorName = 'غير محدد';
                    if ($appointment->doctor && $appointment->doctor->user_id) {
                        $doctorName = $doctorNames[$appointment->doctor->user_id] ?? ($appointment->doctor->name ?? 'غير محدد');
                    }
                    
                    return (object)[
                        'id' => $appointment->id,
                        'patient_name' => $appointment->patient ? ($appointment->patient->name ?? 'غير محدد') : 'غير محدد',
                        'doctor_name' => $doctorName,
                        'appointment_date' => $appointment->appointment_date,
                        'appointment_time' => $appointment->appointment_time,
                        'status' => $appointment->status,
                    ];
                });
        } else {
            $recentAppointments = collect([]);
        }
        
        // التقييمات الخاصة بالأطباء
        if (!empty($doctorIds)) {
            $reviews = Review::whereIn('doctor_id', $doctorIds)->orderBy('created_at', 'desc')->get();
            $avgRating = $reviews->avg('rating') ?? 0;
            $unreadNotifications = Notification::whereIn('doctor_id', $doctorIds)->where('is_read', false)->count();
            $recentNotifications = Notification::whereIn('doctor_id', $doctorIds)->orderBy('created_at', 'desc')->limit(5)->get();
        } else {
            $reviews = collect([]);
            $avgRating = 0;
            $unreadNotifications = 0;
            $recentNotifications = collect([]);
        }
        
        return view('clinic.dashboard', compact(
            'totalDoctors', 'activeDoctors', 'totalPatients', 'activePatients',
            'totalAppointments', 'pendingAppointments', 'acceptedAppointments',
            'rejectedAppointments', 'revenue', 'recentAppointments',
            'reviews', 'avgRating', 'unreadNotifications', 'recentNotifications'
        ));
    }

    /**
     * API: إحصائيات سريعة للـ AJAX
     */
    public function getStats()
    {
        $user = Auth::user();
        $clinic = Clinic::where('user_id', $user->id)->first();
        
        if (!$clinic) {
            return response()->json(['success' => false, 'message' => 'Clinic not found'], 404);
        }
        
        $clinicId = $clinic->id;
        
        if (Schema::hasColumn('doctors', 'clinic_id')) {
            $doctorIds = Doctor::where('clinic_id', $clinicId)->pluck('id')->toArray();
            $totalDoctors = Doctor::where('clinic_id', $clinicId)->count();
            $activeDoctors = $totalDoctors;
        } else {
            $doctorIds = Doctor::pluck('id')->toArray();
            $totalDoctors = Doctor::count();
            $activeDoctors = $totalDoctors;
        }
        
        if (!empty($doctorIds)) {
            $totalPatients = Patient::whereHas('appointments', function($q) use ($doctorIds) {
                $q->whereIn('doctor_id', $doctorIds);
            })->count();
            $totalAppointments = Appointment::whereIn('doctor_id', $doctorIds)->count();
            $pendingAppointments = Appointment::whereIn('doctor_id', $doctorIds)->where('status', 'Pending')->count();
        } else {
            $totalPatients = 0;
            $totalAppointments = 0;
            $pendingAppointments = 0;
        }
        
        $acceptedAppointments = 0; // يمكن حسابها حسب الحاجة
        $revenue = 0;
        
        return response()->json([
            'success' => true,
            'data' => [
                'totalDoctors' => $totalDoctors,
                'activeDoctors' => $activeDoctors,
                'totalPatients' => $totalPatients,
                'activePatients' => $totalPatients,
                'totalAppointments' => $totalAppointments,
                'pendingAppointments' => $pendingAppointments,
                'acceptedAppointments' => $acceptedAppointments,
                'revenue' => $revenue
            ]
        ]);
    }
    
    /**
     * API: التقييمات للـ AJAX
     */
    public function getReviews()
    {
        $user = Auth::user();
        $clinic = Clinic::where('user_id', $user->id)->first();

        if (!$clinic) {
            return response()->json(['success' => false, 'message' => 'Clinic not found'], 404);
        }

        if (Schema::hasColumn('doctors', 'clinic_id')) {
            $doctorIds = Doctor::where('clinic_id', $clinic->id)->pluck('id')->toArray();
        } else {
            $doctorIds = Doctor::pluck('id')->toArray();
        }

        if (empty($doctorIds)) {
            return response()->json([
                'success' => true,
                'reviews' => [],
                'avgRating' => 0
            ]);
        }

        $reviews = Review::whereIn('doctor_id', $doctorIds)
            ->with('patient')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get()
            ->map(function($review) {
                return [
                    'id' => $review->id,
                    'patient_name' => $review->patient ? ($review->patient->name ?? 'غير محدد') : 'غير محدد',
                    'rating' => $review->rating,
                    'review' => $review->review,
                    'date' => $review->created_at ? $review->created_at->toDateString() : date('Y-m-d'),
                ];
            });

        $avgRating = Review::whereIn('doctor_id', $doctorIds)->avg('rating') ?? 0;

        return response()->json([
            'success' => true,
            'reviews' => $reviews,
            'avgRating' => round($avgRating, 1)
        ]);
    }

    /**
     * API: آخر المواعيد للـ AJAX
     */
    public function getRecentAppointments()
    {
        $user = Auth::user();
        $clinic = Clinic::where('user_id', $user->id)->first();
        
        if (!$clinic) {
            return response()->json(['success' => false, 'message' => 'Clinic not found'], 404);
        }
        
        if (Schema::hasColumn('doctors', 'clinic_id')) {
            $doctorIds = Doctor::where('clinic_id', $clinic->id)->pluck('id')->toArray();
        } else {
            $doctorIds = Doctor::pluck('id')->toArray();
        }
        
        if (empty($doctorIds)) {
            return response()->json([
                'success' => true,
                'appointments' => []
            ]);
        }
        
        // جلب أسماء الأطباء من جدول users
        $doctorNames = [];
        if (Schema::hasColumn('doctors', 'user_id')) {
            $doctorUserIds = Doctor::whereIn('id', $doctorIds)->pluck('user_id')->toArray();
            $doctorUserIds = array_filter($doctorUserIds);
            if (!empty($doctorUserIds)) {
                $doctorNames = User::whereIn('id', $doctorUserIds)->pluck('name', 'id')->toArray();
            }
        }
        
        $recentAppointments = Appointment::whereIn('doctor_id', $doctorIds)
            ->with('patient')
            ->orderBy('appointment_date', 'desc')
            ->orderBy('appointment_time', 'desc')
            ->limit(5)
            ->get()
            ->map(function($appointment) use ($doctorNames) {
                $doctorName = 'غير محدد';
                if ($appointment->doctor && $appointment->doctor->user_id) {
                    $doctorName = $doctorNames[$appointment->doctor->user_id] ?? ($appointment->doctor->name ?? 'غير محدد');
                }
                
                return [
                    'id' => $appointment->id,
                    'patient_name' => $appointment->patient ? ($appointment->patient->name ?? 'غير محدد') : 'غير محدد',
                    'doctor_name' => $doctorName,
                    'specialty' => $appointment->doctor ? ($appointment->doctor->specialty ?? '—') : '—',
                    'date' => $appointment->appointment_date,
                    'time' => $appointment->appointment_time,
                    'status' => $appointment->status,
                ];
            });
        
        return response()->json([
            'success' => true,
            'appointments' => $recentAppointments
        ]);
    }
}
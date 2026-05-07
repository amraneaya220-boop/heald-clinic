<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Clinic;
use App\Models\Doctor;
use App\Models\Booking;
use App\Models\Payment;
use App\Models\Review;
use App\Models\Ad;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DashboardController extends Controller
{
    public function index()
    {
        // إحصائيات الـ Dashboard
        $totalClinics = Clinic::count();
        $totalDoctors = Doctor::count();
        $totalBookings = Booking::count();
        $totalReviews = Review::count();
        
        // حساب الإيرادات
        $totalRevenue = 0;
        try {
            $totalRevenue = Payment::sum('amount') ?? 0;
        } catch (\Exception $e) {
            $totalRevenue = 0;
        }
        
        // حساب العمولة (إذا كان العمود موجوداً)
        $totalCommission = 0;
        try {
            if (Schema::hasColumn('payments', 'commission')) {
                $totalCommission = Payment::sum('commission') ?? 0;
            }
        } catch (\Exception $e) {
            $totalCommission = 0;
        }
        
        // عدد الإعلانات النشطة - نستخدم عمود status الموجود
        $activeAds = 0;
        try {
            if (Schema::hasTable('ads')) {
                if (Schema::hasColumn('ads', 'status')) {
                    $activeAds = Ad::where('status', 'active')->count() ?? 0;
                } else {
                    $activeAds = Ad::count() ?? 0;
                }
            }
        } catch (\Exception $e) {
            $activeAds = 0;
        }
        
        // الحجوزات المعلقة
        $pendingBookings = 0;
        try {
            if (Schema::hasColumn('bookings', 'status')) {
                $pendingBookings = Booking::where('status', 'pending')->count();
            } else {
                $pendingBookings = Booking::count();
            }
        } catch (\Exception $e) {
            $pendingBookings = 0;
        }
        
        // الحجوزات الأخيرة
        $recentBookings = collect();
        try {
            $recentBookings = Booking::with(['clinic', 'doctor'])
                ->orderBy('created_at', 'desc')
                ->take(10)
                ->get();
        } catch (\Exception $e) {
            $recentBookings = collect();
        }
        
        // حجوزات اليوم
        $todayBookings = 0;
        try {
            $todayBookings = Booking::whereDate('created_at', today())->count();
        } catch (\Exception $e) {
            $todayBookings = 0;
        }
        
        // تقييمات اليوم
        $todayReviews = 0;
        try {
            $todayReviews = Review::whereDate('created_at', today())->count();
        } catch (\Exception $e) {
            $todayReviews = 0;
        }
        $pendingClinicsCount = Clinic::where('is_approved', false)->count();
        return view('super_admin.dashboard', compact(
            'totalClinics',
            'totalDoctors',
            'totalBookings',
            'totalReviews',
            'totalRevenue',
            'totalCommission',
            'activeAds',
            'pendingBookings',
            'recentBookings',
            'todayBookings',
            'todayReviews',
            'pendingClinicsCount'
        ));
    }
}
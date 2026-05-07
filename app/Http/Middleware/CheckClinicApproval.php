<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckClinicApproval
{
    public function handle(Request $request, Closure $next)
    {
        $user = auth()->user();
        
        // التحقق من أن المستخدم مسجل دخول
        if (!$user) {
            return redirect()->route('login');
        }
        
        // التحقق من أن المستخدم هو عيادة
        if ($user->role !== 'clinic') {
            return redirect()->route('home');
        }
        
        // الحصول على العيادة المرتبطة
        $clinic = $user->clinic;
        
        if (!$clinic) {
            return redirect()->route('clinic.settings')
                ->with('error', 'Clinic profile not found. Please complete your registration.');
        }
        
        // ✅ التحقق من موافقة الأدمن
        if (!$clinic->is_approved) {
            // قائمة المسارات المسموح بها قبل الموافقة
            $allowedRoutes = [
                'clinic.pending.approval',
                'clinic.logout',
                'clinic.settings',
                'clinic.settings.index',
                'clinic.settings.data',
                'clinic.settings.clinic.update',
                'clinic.settings.prices.update',
                'clinic.settings.services.store',
                'clinic.settings.services.delete',
                'clinic.settings.schedules.store',
                'clinic.settings.schedules.delete',
                'clinic.settings.specialties.store',
                'clinic.settings.specialties.delete',
                'clinic.settings.image.upload',
                'clinic.subscription.plans',
                'clinic.subscription.subscribe',
                'clinic.subscription.use-trial',
                'clinic.subscription.status',
            ];
            
            $currentRoute = $request->route()->getName();
            
            // إذا حاول الوصول لأي صفحة غير مسموحة → التوجيه إلى صفحة الانتظار
            if (!in_array($currentRoute, $allowedRoutes)) {
                return redirect()->route('clinic.pending.approval')
                    ->with('warning', 'Your clinic is waiting for admin approval. You will be notified once approved.');
            }
        }
        
        return $next($request);
    }
}
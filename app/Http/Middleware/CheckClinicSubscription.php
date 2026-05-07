<?php
// app/Http/Middleware/CheckClinicSubscription.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Clinic;

class CheckClinicSubscription
{
    public function handle(Request $request, Closure $next)
    {
        $user = auth()->user();
        
        if (!$user || !$user->clinic) {
            return redirect()->route('clinic.settings')
                ->with('error', 'Clinic not found.');
        }
        
        $clinic = $user->clinic;
        
        // التحقق من موافقة الأدمن
        if (!$clinic->is_approved) {
            return redirect()->route('clinic.pending.approval')
                ->with('warning', 'Your clinic is waiting for admin approval.');
        }
        
        // التحقق من وجود اشتراك فعال أو تجارب متبقية
        $hasActiveSubscription = $this->hasActiveSubscription($clinic);
        
        if (!$hasActiveSubscription) {
            $remainingTrials = $clinic->max_trials - $clinic->trial_used;
            if ($remainingTrials <= 0) {
                return redirect()->route('clinic.subscription.plans')
                    ->with('error', 'Your free trials have been exhausted. Please subscribe to continue.');
            }
        }
        
        return $next($request);
    }
    
    private function hasActiveSubscription($clinic)
    {
        if ($clinic->subscription_status === 'active') {
            if ($clinic->subscription_end_date && $clinic->subscription_end_date > now()) {
                return true;
            }
        }
        
        if ($clinic->subscription_status === 'trial') {
            if ($clinic->trial_used < $clinic->max_trials) {
                return true;
            }
        }
        
        return false;
    }
}
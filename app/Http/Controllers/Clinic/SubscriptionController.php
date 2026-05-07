<?php

namespace App\Http\Controllers\Clinic;

use App\Http\Controllers\Controller;
use App\Models\Clinic;
use App\Models\Payment;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class SubscriptionController extends Controller
{
    // خطط الاشتراك
    private $plans = [
        'monthly' => ['name' => 'Monthly Plan', 'price' => 5000, 'duration' => 'month', 'duration_days' => 30],
        'yearly' => ['name' => 'Yearly Plan', 'price' => 50000, 'duration' => 'year', 'duration_days' => 365, 'discount' => 'Save 16%']
    ];
    
    /**
     * عرض خطط الاشتراك
     */
    public function plans()
    {
        $clinic = auth()->user()->clinic;
        
        if (!$clinic) {
            return redirect()->route('clinic.settings')->with('error', 'Clinic not found.');
        }
        
        $plans = $this->plans;
        $remainingTrials = $clinic->max_trials - $clinic->trial_used;
        
        $currentSubscription = null;
        try {
            $currentSubscription = $clinic->subscriptions()
                ->where('status', 'active')
                ->where('end_date', '>', now())
                ->first();
        } catch (\Exception $e) {
            $currentSubscription = null;
        }
        
        return view('clinic.subscription.plans', compact('clinic', 'plans', 'remainingTrials', 'currentSubscription'));
    }
    
    /**
     * الاشتراك في خطة
     */
    public function subscribe(Request $request)
    {
        $request->validate([
            'plan' => 'required|in:monthly,yearly',
            'payment_method' => 'required|string|in:credit_card,cih,bank_transfer,edahabia'
        ]);
        
        $clinic = auth()->user()->clinic;
        
        if (!$clinic) {
            return redirect()->back()->with('error', 'Clinic not found.');
        }
        
        // التحقق من وجود اشتراك فعال
        if ($clinic->hasActiveSubscription()) {
            return redirect()->back()->with('error', 'You already have an active subscription.');
        }
        
        $plan = $this->plans[$request->plan];
        $amount = $plan['price'];
        
        // ✅ إنشاء سجل الدفع وفقاً لهيكل جدول payments
        $payment = Payment::create([
            'type' => 'clinic',                        // نوع الدفع (عيادة)
            'entity_id' => $clinic->id,                // معرف العيادة
            'entity_name' => $clinic->name,            // اسم العيادة
            'amount' => $amount,                       // المبلغ
            'commission' => 0,                         // العمولة (0 للاشتراك)
            'due_date' => now()->addDays(7),           // تاريخ الاستحقاق (بعد 7 أيام)
            'description' => 'Subscription payment for ' . $plan['name'], // الوصف
            'status' => 'paid',                        // الحالة (مدفوعة)
            'payment_date' => now(),                   // تاريخ الدفع
            'transaction_id' => 'TXN_' . time() . '_' . $clinic->id  // معرف المعاملة
        ]);
        
        // تفعيل الاشتراك
        $subscription = $clinic->subscribe($request->plan, $amount, $payment->id);
        
        return redirect()->route('clinic.dashboard')
            ->with('success', 'Subscription activated successfully! You can now use all clinic features.');
    }
    
    /**
     * بدء التجربة المجانية
     */
    public function useTrial()
    {
        $clinic = auth()->user()->clinic;
        
        if (!$clinic) {
            return redirect()->back()->with('error', 'Clinic not found.');
        }
        
        // التحقق من أن العيادة موافقة من الأدمن
        if (!$clinic->is_approved) {
            return redirect()->route('clinic.pending.approval')
                ->with('warning', 'Your clinic is waiting for admin approval.');
        }
        
        // التحقق من عدد التجارب المتبقية
        if ($clinic->trial_used >= $clinic->max_trials) {
            return redirect()->route('clinic.subscription.plans')
                ->with('error', 'You have already used all your free trials. Please subscribe to continue.');
        }
        
        // التحقق من وجود اشتراك فعال
        if ($clinic->hasActiveSubscription()) {
            return redirect()->route('clinic.dashboard')
                ->with('info', 'You already have an active subscription.');
        }
        
        // تفعيل التجربة
        $clinic->subscription_status = 'trial';
        $clinic->trial_used = $clinic->trial_used + 1;
        $clinic->save();
        
           $remaining = $clinic->max_trials - $clinic->trial_used;
    
    if ($remaining <= 0) {
        return redirect()->route('clinic.subscription.plans')
            ->with('warning', 'This was your last free trial. Please subscribe to continue using the platform.');
    }
    
    return redirect()->route('clinic.dashboard')
        ->with('success', "Trial started successfully! You have {$remaining} free trial" . ($remaining > 1 ? 's' : '') . " remaining.");
}
    
    /**
     * عرض تاريخ الاشتراكات
     */
    public function history()
    {
        $clinic = auth()->user()->clinic;
        
        if (!$clinic) {
            return redirect()->back()->with('error', 'Clinic not found.');
        }
        
        $subscriptions = collect();
        try {
            $subscriptions = $clinic->subscriptions()->orderBy('created_at', 'desc')->paginate(10);
        } catch (\Exception $e) {
            $subscriptions = collect();
        }
        
        return view('clinic.subscription.history', compact('subscriptions'));
    }
    
    /**
     * إلغاء الاشتراك
     */
    public function cancel()
    {
        $clinic = auth()->user()->clinic;
        
        try {
            $subscription = $clinic->subscriptions()->where('status', 'active')->first();
            if ($subscription) {
                $subscription->status = 'cancelled';
                $subscription->save();
                
                $clinic->subscription_status = 'expired';
                $clinic->save();
                
                return redirect()->route('clinic.subscription.plans')
                    ->with('success', 'Subscription cancelled successfully.');
            }
        } catch (\Exception $e) {
            // لا يوجد اشتراك نشط
        }
        
        return redirect()->back()->with('error', 'No active subscription found.');
    }
    
    /**
     * تجديد الاشتراك
     */
    public function renew(Request $request)
    {
        $request->validate([
            'plan' => 'required|in:monthly,yearly',
            'payment_method' => 'required|string'
        ]);
        
        $clinic = auth()->user()->clinic;
        $plan = $this->plans[$request->plan];
        $amount = $plan['price'];
        
        // ✅ إنشاء سجل دفع للتجديد
        $payment = Payment::create([
            'type' => 'clinic',
            'entity_id' => $clinic->id,
            'entity_name' => $clinic->name,
            'amount' => $amount,
            'commission' => 0,
            'due_date' => now()->addDays(7),
            'description' => 'Subscription renewal for ' . $plan['name'],
            'status' => 'paid',
            'payment_date' => now(),
            'transaction_id' => 'TXN_RENEW_' . time() . '_' . $clinic->id
        ]);
        
        // تفعيل الاشتراك الجديد
        $subscription = $clinic->subscribe($request->plan, $amount, $payment->id);
        
        return redirect()->route('clinic.dashboard')
            ->with('success', 'Subscription renewed successfully!');
    }
    
    /**
     * التحقق من حالة الاشتراك (API)
     */
    public function checkStatus()
    {
        $clinic = auth()->user()->clinic;
        
        if (!$clinic) {
            return response()->json(['success' => false, 'message' => 'Clinic not found']);
        }
        
        return response()->json([
            'success' => true,
            'is_approved' => $clinic->is_approved,
            'subscription_status' => $clinic->subscription_status,
            'trial_used' => $clinic->trial_used,
            'max_trials' => $clinic->max_trials,
            'remaining_trials' => $clinic->max_trials - $clinic->trial_used,
            'has_active_subscription' => $clinic->hasActiveSubscription(),
            'subscription_end_date' => $clinic->subscription_end_date
        ]);
    }
    
}
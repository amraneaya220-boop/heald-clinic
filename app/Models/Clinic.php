<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
class Clinic extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'name', 'email', 'phone', 'address', 'location',
        'description', 'subscription', 'paid_until', 'commission_rate', 'status','image','map_link', 'nearby_landmark', 'working_hours', 
    'price_range','subscription_status', 'trial_used', 'max_trials', 
    'subscription_end_date', 'is_approved', 'approved_at'
    ];

    protected $casts = [
        'paid_until' => 'date',
        'commission_rate' => 'decimal:2'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function doctors()
    {
        return $this->hasMany(Doctor::class);
    }
    public function reviews()
{
    return $this->hasMany(Review::class);
}
public function services()
{
    return $this->belongsToMany(Service::class);
}
public function useTrial()
    {
        if ($this->subscription_status === 'trial' && $this->trial_used < $this->max_trials) {
            $this->trial_used++;
            $this->save();
            return true;
        }
        return false;
    }
public function hasActiveSubscription()
    {
        // التحقق من حالة الاشتراك في العيادة
        if ($this->subscription_status === 'active') {
            // التحقق من صلاحية الاشتراك
            if ($this->subscription_end_date && $this->subscription_end_date > now()) {
                return true;
            } else {
                // الاشتراك منتهي الصلاحية
                $this->subscription_status = 'expired';
                $this->save();
                return false;
            }
        }
        
        return false;
    }

public function subscribe($plan, $amount, $paymentId = null)
    {
        $endDate = $plan === 'yearly' ? now()->addYear() : now()->addMonth();
        
        $this->subscription_status = 'active';
        $this->subscription_end_date = $endDate;
        $this->save();
        
        return Subscription::create([
            'clinic_id' => $this->id,
            'plan' => $plan,
            'amount' => $amount,
            'start_date' => now(),
            'end_date' => $endDate,
            'status' => 'active',
            'payment_id' => $paymentId
    ]);
}
public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    // ✅ الحصول على الاشتراك النشط
    public function activeSubscription()
    {
        return $this->hasOne(Subscription::class)
            ->where('status', 'active')
            ->where('end_date', '>', now())
            ->latest();
    }

public function approve()
    {
        $this->is_approved = true;
        $this->approved_at = now();
        $this->subscription_status = 'trial';  // تبدأ كتجربة
        $this->trial_used = 0;
        $this->max_trials = 2;
        $this->save();
    }

}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;

    protected $table = 'subscriptions';

    protected $fillable = [
        'clinic_id',
        'plan',
        'amount',
        'start_date',
        'end_date',
        'status',
        'payment_id'
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'amount' => 'decimal:2'
    ];

    // علاقة العيادة
    public function clinic()
    {
        return $this->belongsTo(Clinic::class);
    }

    // علاقة الدفع
    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }

    // التحقق من صلاحية الاشتراك
    public function isValid()
    {
        return $this->status === 'active' && $this->end_date > now();
    }
}
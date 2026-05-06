<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Invoice extends Model
{
    protected $fillable = [
        'clinic_id',
        'invoice_number',
        'patient_name',
        'patient_phone',
        'patient_id_ref',
        'doctor_name',
        'appointment_date',
        'appointment_time',
        'consultation_type',
        'consultation_fee',
        'lab_fee',
        'extra_fee',
        'total_amount',
        'payment_method',
        'payment_status',
    ];
    
    protected $casts = [
        'appointment_date' => 'date',
        'consultation_fee' => 'decimal:2',
        'lab_fee' => 'decimal:2',
        'extra_fee' => 'decimal:2',
        'total_amount' => 'decimal:2',
    ];
    
    public function clinic(): BelongsTo
    {
        return $this->belongsTo(User::class, 'clinic_id');
    }
}
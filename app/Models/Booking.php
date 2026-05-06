<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'clinic_id', 'patient_id', 'doctor_id', 'patient_name',
        'appointment_date', 'appointment_time', 'amount', 'commission', 'status'
    ];

    protected $casts = [
        'appointment_date' => 'date',
        'amount' => 'decimal:2',
        'commission' => 'decimal:2'
    ];

    public function clinic()
    {
        return $this->belongsTo(Clinic::class);
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }
}
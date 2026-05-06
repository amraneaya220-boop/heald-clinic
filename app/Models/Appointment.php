<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Appointment extends Model
{
   protected $fillable = [
    'patient_id', 'doctor_id', 'clinic_id', 'appointment_date', 'appointment_time',
    'status', 'notes', 'patient_name', 'patient_phone', 'payment_method'
];
    protected $casts = [
        'appointment_date' => 'date',
        'appointment_time' => 'datetime:H:i'
    ];
    
    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }
    
    public function doctor(): BelongsTo
    {
        return $this->belongsTo(Doctor::class);
    }
    public function clinic()
{
    return $this->belongsTo(Clinic::class);
}
public function medicalRecord()
{
    return $this->hasOne(MedicalRecord::class);
}

}
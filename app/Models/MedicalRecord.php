<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MedicalRecord extends Model
{
     protected $table = 'medical_records';
   protected $fillable = [
        'patient_id', 'appointment_id', 'doctor_id', 'clinic_id',
        'date', 'complaint', 'diagnosis', 'prescription', 'notes'
    ];

    protected $casts = [
        'visit_date' => 'date'
    ];

   public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
    
    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }
    
    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }
    
    public function clinic()
    {
        return $this->belongsTo(Clinic::class);
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DoctorSchedule extends Model
{
    protected $table = 'doctor_schedules';
    
    protected $fillable = [
        'doctor_id',
        'day_of_week',
        'time_slot',
        'work_type'
    ];
    
    protected $casts = [
        'day_of_week' => 'integer',
        'time_slot' => 'datetime:H:i',
        'work_type' => 'string',
    ];
    
    // العلاقة مع الطبيب
    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }
}
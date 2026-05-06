<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DoctorSetting extends Model
{
    protected $table = 'doctor_settings';

    protected $fillable = [
        'doctor_id', 'fullname', 'specialty', 'phone', 'email',
        'clinic_name', 'duration', 'break_time', 'working_days', 'profile_pic'
    ];

    protected $casts = [
        'working_days' => 'array'
    ];

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }
}
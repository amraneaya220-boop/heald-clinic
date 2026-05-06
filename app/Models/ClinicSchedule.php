<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClinicSchedule extends Model
{
    protected $table = 'clinic_schedules';
    
    protected $fillable = [
        'schedule_date',
        'start_time',
        'end_time',
        'break_start',
        'break_end'
    ];
    
    protected $casts = [
        'schedule_date' => 'date',
        'start_time' => 'datetime:H:i',
        'end_time' => 'datetime:H:i',
        'break_start' => 'datetime:H:i',
        'break_end' => 'datetime:H:i',
    ];
}
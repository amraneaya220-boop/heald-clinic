<?php
// app/Models/ClinicSetting.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClinicSetting extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'clinic_id', 'name', 'phone', 'location', 'emergency_mode', 
        'email', 'description', 'image'
    ];
}
<?php
// app/Models/ServicePrice.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServicePrice extends Model
{
    use HasFactory;
    
    protected $fillable = ['clinic_id', 'consult', 'radio', 'mri', 'scan'];
}
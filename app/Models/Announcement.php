<?php
// app/Models/Announcement.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    protected $fillable = [
        'title', 'clinic', 'city', 'doctor', 'type', 
        'description', 'price', 'start_date', 'end_date', 'image'
    ];
    
    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date'
    ];
}
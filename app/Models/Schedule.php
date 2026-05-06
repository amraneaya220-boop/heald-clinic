<?php
// app/Models/Schedule.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;
    
    protected $fillable = ['clinic_id', 'schedule_date', 'start_time', 'end_time', 'break_start', 'break_end'];
}
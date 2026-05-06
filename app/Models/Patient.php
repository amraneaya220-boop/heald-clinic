<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Patient extends Model
{
   protected $fillable = [
        'user_id', 'name', 'email', 'phone', 'dob', 'gender', 'address', 'status', 'avatar', 'last_visit','created_at'
    ];
    public function doctor()
{
    return $this->belongsTo(Doctor::class);
}
    
    public function user() { return $this->belongsTo(User::class); }
public function appointments()
{
    return $this->hasMany(Appointment::class);
}public function reviews() { return $this->morphMany(Review::class, 'reviewable'); }
public function invoices(): HasMany
    {
        return $this->hasMany(Invoice::class);
    }
}
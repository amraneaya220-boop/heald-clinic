<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Clinic extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'name', 'email', 'phone', 'address', 'location',
        'description', 'subscription', 'paid_until', 'commission_rate', 'status','image','map_link', 'nearby_landmark', 'working_hours', 
    'price_range'
    ];

    protected $casts = [
        'paid_until' => 'date',
        'commission_rate' => 'decimal:2'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function doctors()
    {
        return $this->hasMany(Doctor::class);
    }
    public function reviews()
{
    return $this->hasMany(Review::class);
}
public function services()
{
    return $this->belongsToMany(Service::class);
}
}

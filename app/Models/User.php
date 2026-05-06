<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'clinic_id',
        'doctor_id',
        'patient_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // علاقات
    public function clinic()
    {
         return $this->hasOne(Clinic::class, 'user_id');
         
    }

    public function doctor()
    {
       
        return $this->hasOne(Doctor::class);
    }

    public function patient()
    {
        return $this->hasOne(Patient::class, 'user_id');
    }

    // التحقق من الدور
    public function hasRole($role)
    {
        return $this->role === $role;
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isDoctor()
    {
        return $this->role === 'doctor';
    }

    public function isPatient()
    {
        return $this->role === 'patient';
    }

    public function isClinic()
    {
        return $this->role === 'clinic';
    }
    public function doctorAppointments()
    {
        return $this->hasManyThrough(
            Appointment::class,
            Doctor::class,
            'user_id', // المفتاح الأجنبي في جدول doctors
            'doctor_id', // المفتاح الأجنبي في جدول appointments
            'id', // المفتاح المحلي في جدول users
            'id' // المفتاح المحلي في جدول doctors
        );
    }
    public function invoices()
    {
        return $this->hasMany(Invoice::class, 'patient_id', 'id');
    }
     public function notifications()
    {
        return $this->hasMany(Notification::class, 'user_id', 'id');
    }
    
    protected static function booted()
{
    static::created(function ($user) {
        if ($user->type === 'doctor') {
            \App\Models\Doctor::create([
                'user_id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'phone' => $user->phone ?? '',
                'specialty' => 'تخصص غير محدد',
                'experience' => '0 سنوات',
                'consultation_fee' => 0,
                'about' => 'لا يوجد معلومات',
                'status' => 'pending', // أو 'active'
                'working_days' => json_encode(['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday']),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    });
}
}
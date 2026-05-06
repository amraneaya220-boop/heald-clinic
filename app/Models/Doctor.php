<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Doctor extends Model
{
    protected $fillable = ['user_id', 'name', 'specialty', 'email', 'phone', 'clinic_id', 'experience', 'consultation_fee', 'about', 'status','working_days'];
    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_active' => 'boolean',
    ];// أضف العلاقة مع العيادة
public function clinic()
{
    return $this->belongsTo(Clinic::class);
}
public function user()
{
    return $this->belongsTo(User::class);
}
public function appointments() { return $this->hasMany(Appointment::class); }
public function reviews()
{
    return $this->hasMany(Review::class);
}
    public function medicalRecords()
{
    return $this->hasMany(MedicalRecord::class);
}
public function settings()
{
    return $this->hasOne(DoctorSetting::class);
}
    public function schedules(): HasMany
    {
        return $this->hasMany(DoctorSchedule::class);
    }
}
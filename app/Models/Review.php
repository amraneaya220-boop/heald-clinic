<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = [
        'patient_name',
        'clinic_id',
        'rating',
        'review',
        'review_date'
    ];

    public $timestamps = false;

    protected $casts = [
        'review_date' => 'date'
    ];

    // ❌ احذف هذا
    // public function reviewable() { return $this->morphTo(); }

    // 👇 العلاقة الصحيحة
    public function clinic()
    {
        return $this->belongsTo(Clinic::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ad extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'type',
        'url',
        'link',
        'expiry_date',
        'status'
    ];

    protected $casts = [
        'expiry_date' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    // نطاق للإعلانات النشطة
    public function scopeActive($query)
    {
        return $query->where('status', 'active')
                     ->where('expiry_date', '>=', now());
    }
}
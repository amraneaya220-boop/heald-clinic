<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'entity_id',
        'entity_name',
        'amount',
        'commission',
        'due_date',
        'description',
        'status',
        'payment_date',
        'transaction_id'
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'commission' => 'decimal:2',
        'due_date' => 'date',
        'payment_date' => 'datetime'
    ];

    // علاقة متعددة الأشكال (Polymorphic)
    public function entity()
    {
        return $this->morphTo();
    }

    // علاقة العيادة (إذا كان type = clinic)
    public function clinic()
    {
        return $this->belongsTo(Clinic::class, 'entity_id');
    }
}
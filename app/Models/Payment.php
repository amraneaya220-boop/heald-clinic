<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'type', 'entity_id', 'entity_name', 'amount', 'due_date', 'description', 'status'
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'due_date' => 'date'
    ];
}
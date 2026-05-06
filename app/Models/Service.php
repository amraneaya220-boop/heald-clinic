<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $table = 'services';
    
    protected $fillable = [
        'name',
        'type',
        'price',
        'description',
        'is_default'
    ];
    
    protected $casts = [
        'price' => 'decimal:2',
        'is_default' => 'boolean',
    ];
}
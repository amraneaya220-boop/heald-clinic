<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $table = 'notifications';
    
    protected $fillable = [
        'user_type', 'user_id', 'message', 'is_read'
    ];
    
    protected $casts = [
        'is_read' => 'boolean'
    ];
}

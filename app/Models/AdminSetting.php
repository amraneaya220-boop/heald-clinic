<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminSetting extends Model
{
    use HasFactory;

    protected $table = 'admin_settings';

    protected $fillable = [
        'admin_name', 'admin_email', 'admin_password_hash', 'default_commission',
        'currency', 'email_notifications', 'sms_notifications', 'appointment_reminders'
    ];

    protected $casts = [
        'default_commission' => 'decimal:2',
        'email_notifications' => 'boolean',
        'sms_notifications' => 'boolean',
        'appointment_reminders' => 'boolean'
    ];

    public static function getSettings()
    {
        return self::first() ?? self::create([
            'admin_name' => 'Admin User',
            'admin_email' => 'admin@mediease.com',
            'admin_password_hash' => bcrypt('admin123'),
            'default_commission' => 5.00,
            'currency' => 'DZD',
            'email_notifications' => true,
            'sms_notifications' => false,
            'appointment_reminders' => true
        ]);
    }
}
<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class AdminSettingController extends Controller
{
    // إعدادات المشرف الافتراضية
    private $defaultSettings = [
        'admin_name' => 'Super Admin',
        'admin_email' => 'superadmin@mediease.com',
        'default_commission' => 10,
        'currency' => 'DZD',
        'email_notifications' => true,
        'sms_notifications' => false,
        'appointment_reminders' => true,
        'site_name' => 'MediEase',
        'site_description' => 'Your comprehensive healthcare management platform in Algeria',
        'timezone' => 'Africa/Algiers',
        'notification_email' => 'admin@mediease.com',
        'maintenance_mode' => false,
        'smtp_host' => 'smtp.gmail.com',
        'smtp_port' => 587,
        'smtp_encryption' => 'tls',
        'smtp_username' => '',
        'twilio_sid' => '',
        'twilio_token' => '',
        'twilio_phone' => '',
        'facebook_url' => '',
        'twitter_url' => '',
        'instagram_url' => '',
        'linkedin_url' => ''
    ];

    public function index()
    {
        // جلب الإعدادات من الكاش أو استخدام الإعدادات الافتراضية
        $settings = (object) [
            'admin_name' => session('super_admin_name', $this->defaultSettings['admin_name']),
            'admin_email' => session('super_admin_email', $this->defaultSettings['admin_email']),
            'default_commission' => Cache::get('default_commission', $this->defaultSettings['default_commission']),
            'currency' => Cache::get('currency', $this->defaultSettings['currency']),
            'email_notifications' => Cache::get('email_notifications', $this->defaultSettings['email_notifications']),
            'sms_notifications' => Cache::get('sms_notifications', $this->defaultSettings['sms_notifications']),
            'appointment_reminders' => Cache::get('appointment_reminders', $this->defaultSettings['appointment_reminders']),
            'site_name' => Cache::get('site_name', $this->defaultSettings['site_name']),
            'site_description' => Cache::get('site_description', $this->defaultSettings['site_description']),
            'timezone' => Cache::get('timezone', $this->defaultSettings['timezone']),
            'notification_email' => Cache::get('notification_email', $this->defaultSettings['notification_email']),
            'maintenance_mode' => Cache::get('maintenance_mode', $this->defaultSettings['maintenance_mode']),
            'smtp_host' => Cache::get('smtp_host', $this->defaultSettings['smtp_host']),
            'smtp_port' => Cache::get('smtp_port', $this->defaultSettings['smtp_port']),
            'smtp_encryption' => Cache::get('smtp_encryption', $this->defaultSettings['smtp_encryption']),
            'smtp_username' => Cache::get('smtp_username', $this->defaultSettings['smtp_username']),
            'twilio_sid' => Cache::get('twilio_sid', $this->defaultSettings['twilio_sid']),
            'twilio_token' => Cache::get('twilio_token', $this->defaultSettings['twilio_token']),
            'twilio_phone' => Cache::get('twilio_phone', $this->defaultSettings['twilio_phone']),
            'facebook_url' => Cache::get('facebook_url', $this->defaultSettings['facebook_url']),
            'twitter_url' => Cache::get('twitter_url', $this->defaultSettings['twitter_url']),
            'instagram_url' => Cache::get('instagram_url', $this->defaultSettings['instagram_url']),
            'linkedin_url' => Cache::get('linkedin_url', $this->defaultSettings['linkedin_url'])
        ];
        
        return view('super_admin.settings', compact('settings'));
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'password' => 'nullable|min:6'
        ]);

        try {
            session(['super_admin_name' => $request->name]);
            session(['super_admin_email' => $request->email]);
            
            if ($request->filled('password')) {
                session(['super_admin_password_hash' => Hash::make($request->password)]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Profile updated successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error updating profile: ' . $e->getMessage()
            ], 500);
        }
    }

    public function updateSystem(Request $request)
    {
        $request->validate([
            'default_commission' => 'required|numeric|min:0|max:100',
            'currency' => 'required|string|max:3'
        ]);

        try {
            Cache::forever('default_commission', $request->default_commission);
            Cache::forever('currency', $request->currency);
            
            return response()->json([
                'success' => true,
                'message' => 'System settings updated successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error updating system settings: ' . $e->getMessage()
            ], 500);
        }
    }

    public function updateNotifications(Request $request)
    {
        $request->validate([
            'email_notifications' => 'required|boolean',
            'sms_notifications' => 'required|boolean',
            'appointment_reminders' => 'required|boolean'
        ]);

        try {
            Cache::forever('email_notifications', $request->email_notifications);
            Cache::forever('sms_notifications', $request->sms_notifications);
            Cache::forever('appointment_reminders', $request->appointment_reminders);
            
            return response()->json([
                'success' => true,
                'message' => 'Notification settings updated successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error updating notification settings: ' . $e->getMessage()
            ], 500);
        }
    }
}
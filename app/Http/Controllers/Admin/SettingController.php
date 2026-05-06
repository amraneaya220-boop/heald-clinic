<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ClinicSetting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $settings = ClinicSetting::first() ?? new ClinicSetting();
        $prices = json_decode($settings->prices ?? '{}', true);
        
        return view('clinic.settings.index', compact('settings', 'prices'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'clinic_name' => 'required|string|max:255',
            'phone' => 'required|string',
            'location' => 'required|string',
            'email' => 'required|email',
            'description' => 'nullable|string',
            'emergency_mode' => 'boolean',
            'consult_price' => 'required|numeric',
            'radio_price' => 'required|numeric',
            'mri_price' => 'required|numeric',
            'scan_price' => 'required|numeric',
        ]);

        $setting = ClinicSetting::firstOrCreate([]);
        
        $setting->update([
            'clinic_name' => $validated['clinic_name'],
            'phone' => $validated['phone'],
            'location' => $validated['location'],
            'email' => $validated['email'],
            'description' => $validated['description'],
            'emergency_mode' => $validated['emergency_mode'] ?? false,
            'prices' => json_encode([
                'consult' => $validated['consult_price'],
                'radio'   => $validated['radio_price'],
                'mri'     => $validated['mri_price'],
                'scan'    => $validated['scan_price'],
            ])
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Settings saved successfully!'
        ]);
    }
}
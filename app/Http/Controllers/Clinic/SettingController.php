<?php
// app/Http/Controllers/Clinic/SettingsController.php

namespace App\Http\Controllers\Clinic;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\ClinicSetting;
use App\Models\ServicePrice;
use App\Models\CustomService;
use App\Models\Schedule;
use App\Models\Specialty;

class SettingController extends Controller
{
    public function index()
    {
        return view('clinic.settings.index');
    }
    
    public function getData()
    {
        $user = Auth::user();
        $clinicId = $user->id;
        
        // Get or create clinic settings
        $clinic = ClinicSetting::firstOrCreate(
            ['clinic_id' => $clinicId],
            [
                'name' => $user->clinic_name ?? 'HealD Clinic',
                'phone' => '',
                'location' => '',
                'emergency_mode' => 'OFF',
                'email' => $user->email,
                'description' => '',
                'image' => null
            ]
        );
        
        // Get or create service prices
        $prices = ServicePrice::firstOrCreate(
            ['clinic_id' => $clinicId],
            [
                'consult' => 2500,
                'radio' => 4000,
                'mri' => 12000,
                'scan' => 15000
            ]
        );
        
        // Get custom services
        $customServices = CustomService::where('clinic_id', $clinicId)->get();
        
        // Get schedules
        $schedules = Schedule::where('clinic_id', $clinicId)->get();
        
        // Get specialties
        $specialties = Specialty::where('clinic_id', $clinicId)->get();
        if ($specialties->isEmpty()) {
            $defaultSpecialties = ['Cardiology', 'Neurology', 'Dermatology', 'Radiology'];
            foreach ($defaultSpecialties as $spec) {
                Specialty::create([
                    'clinic_id' => $clinicId,
                    'name' => $spec
                ]);
            }
            $specialties = Specialty::where('clinic_id', $clinicId)->get();
        }
        
        return response()->json([
            'success' => true,
            'clinic' => $clinic,
            'prices' => $prices,
            'customServices' => $customServices,
            'schedules' => $schedules,
            'specialties' => $specialties
        ]);
    }
    
    public function updateClinicInfo(Request $request)
    {
        $user = Auth::user();
        $clinic = ClinicSetting::where('clinic_id', $user->id)->first();
        
        if ($clinic) {
            $clinic->update([
                'name' => $request->name,
                'phone' => $request->phone,
                'location' => $request->location,
                'emergency_mode' => $request->emergency_mode,
                'email' => $request->email,
                'description' => $request->description
            ]);
        }
        
        return response()->json(['success' => true]);
    }
    
    public function updatePrices(Request $request)
    {
        $user = Auth::user();
        $prices = ServicePrice::where('clinic_id', $user->id)->first();
        
        if ($prices) {
            $prices->update([
                'consult' => $request->consult,
                'radio' => $request->radio,
                'mri' => $request->mri,
                'scan' => $request->scan
            ]);
        }
        
        return response()->json(['success' => true]);
    }
    
    public function storeCustomService(Request $request)
    {
        $user = Auth::user();
        $service = CustomService::create([
            'clinic_id' => $user->id,
            'name' => $request->name,
            'price' => $request->price,
            'description' => $request->description
        ]);
        
        return response()->json(['success' => true, 'service' => $service]);
    }
    
    public function deleteCustomService($id)
    {
        $service = CustomService::findOrFail($id);
        $service->delete();
        
        return response()->json(['success' => true]);
    }
    
    public function storeSchedule(Request $request)
    {
        $user = Auth::user();
        $schedule = Schedule::create([
            'clinic_id' => $user->id,
            'schedule_date' => $request->schedule_date,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'break_start' => $request->break_start,
            'break_end' => $request->break_end
        ]);
        
        return response()->json(['success' => true, 'schedule' => $schedule]);
    }
    
    public function deleteSchedule($id)
    {
        $schedule = Schedule::findOrFail($id);
        $schedule->delete();
        
        return response()->json(['success' => true]);
    }
    
    public function storeSpecialty(Request $request)
    {
        $user = Auth::user();
        $specialty = Specialty::create([
            'clinic_id' => $user->id,
            'name' => $request->name
        ]);
        
        return response()->json(['success' => true, 'specialty' => $specialty]);
    }
    
    public function deleteSpecialty($id)
    {
        $specialty = Specialty::findOrFail($id);
        $specialty->delete();
        
        return response()->json(['success' => true]);
    }
    
    public function uploadImage(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);
        
        $user = Auth::user();
        $image = $request->file('image');
        $imageName = time() . '_' . $user->id . '.' . $image->getClientOriginalExtension();
        $path = $image->storeAs('clinic_images', $imageName, 'public');
        
        $clinic = ClinicSetting::where('clinic_id', $user->id)->first();
        if ($clinic) {
            $clinic->update(['image' => Storage::url($path)]);
        }
        
        return response()->json([
            'success' => true,
            'image_url' => Storage::url($path)
        ]);
    }
}
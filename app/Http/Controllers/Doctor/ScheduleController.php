<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ScheduleController extends Controller
{
    // عرض جدول العمل الأسبوعي للطبيب
    public function index()
    {
        $doctor = Auth::user()->doctor;
        // تخزين الجدول في جدول doctor_schedules أو في localStorage افتراضي
        // سنفترض أن لديك جدول doctor_schedules أو حقل في doctor
        $schedule = json_decode($doctor->work_schedule ?? '{}', true);
        $timeSlots = json_decode($doctor->time_slots ?? '["09:00","11:00","14:00","16:00"]', true);

        return view('doctor.schedule', compact('schedule', 'timeSlots'));
    }

    // تحديث الجدول (يستقبل workSchedule و timeSlots)
    public function update(Request $request)
    {
        $doctor = Auth::user()->doctor;
        $request->validate([
            'workSchedule' => 'required|array',
            'timeSlots'    => 'required|array',
        ]);

        $doctor->work_schedule = json_encode($request->workSchedule);
        $doctor->time_slots = json_encode($request->timeSlots);
        $doctor->save();

        return response()->json(['success' => true]);
    }

    // إعادة تعيين الجدول إلى الوضع الافتراضي
    public function resetDefault()
    {
        $doctor = Auth::user()->doctor;
        $defaultSchedule = $this->getDefaultSchedule();
        $defaultTimeSlots = ["09:00", "11:00", "14:00", "16:00"];

        $doctor->work_schedule = json_encode($defaultSchedule);
        $doctor->time_slots = json_encode($defaultTimeSlots);
        $doctor->save();

        return response()->json(['success' => true]);
    }

    private function getDefaultSchedule()
    {
        $days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
        $defaultTimeSlots = ["09:00", "11:00", "14:00", "16:00"];
        $schedule = [];
        foreach ($days as $dayIndex => $dayName) {
            foreach ($defaultTimeSlots as $time) {
                $type = 'exam';
                if ($dayIndex == 5 || $dayIndex == 6) $type = 'holiday';
                if ($time == '09:00' && $dayIndex != 5 && $dayIndex != 6) $type = 'surgery';
                $schedule[$dayIndex . '_' . $time] = ['type' => $type, 'timeLabel' => $time];
            }
        }
        return $schedule;
    }
}
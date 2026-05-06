<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Invoice;
use App\Models\MedicalRecord;
use App\Models\Notification;
use App\Models\Patient;

use App\Models\User; // <-- تأكد من استيراد نموذج User
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class PatientController extends Controller
{
    /**
     * الحصول على نموذج المريض المرتبط بالمستخدم الحالي
     * @return \App\Models\Patient|null
     */
    private function getPatient(): ?Patient
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        if (!$user) {
            return null;
        }
        return Patient::where('user_id', $user->id)->first();
    }

    /**
     * الصفحة الرئيسية للمريض
     */
    public function home()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }

        // التأكد من وجود سجل للمريض
        $patient = Patient::firstOrCreate(
            ['user_id' => $user->id],
            [
                'name'   => $user->name,
                'email'  => $user->email,
                'phone'  => '',
                'status' => 'active'
            ]
        );

        // المواعيد القادمة
        $upcomingAppointments = Appointment::where('patient_id', $patient->id)
            ->with(['doctor', 'clinic'])
            ->where('appointment_date', '>=', now())
            ->orderBy('appointment_date', 'asc')
            ->limit(5)
            ->get();

        // المواعيد السابقة
        $pastAppointments = Appointment::where('patient_id', $patient->id)
            ->with(['doctor', 'clinic'])
            ->where('appointment_date', '<', now())
            ->orderBy('appointment_date', 'desc')
            ->limit(5)
            ->get();

        // الإشعارات غير المقروءة
        $notifications = Notification::where('user_id', $user->id)
            ->where('is_read', false)
            ->latest()
            ->limit(5)
            ->get();

        // الفواتير
        $invoices = Invoice::where('patient_id', $patient->id)
            ->latest()
            ->limit(5)
            ->get();

        return view('patient.home', compact(
            'user',
            'patient',
            'upcomingAppointments',
            'pastAppointments',
            'notifications',
            'invoices'
        ));
    }

    /**
     * عرض جميع المواعيد مع ترقيم الصفحات
     */
    public function appointments()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $patient = $this->getPatient();

        if (!$patient) {
            return redirect()->route('patient.home')->with('error', 'لم يتم العثور على ملف المريض');
        }

        $appointments = Appointment::where('patient_id', $patient->id)
            ->with(['doctor', 'clinic'])
            ->orderBy('appointment_date', 'desc')
            ->paginate(10);

        return view('patient.appointments', compact('appointments', 'user', 'patient'));
    }

    /**
     * تفاصيل موعد محدد
     */
    public function appointmentDetails($id)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $patient = $this->getPatient();

        if (!$patient) {
            return redirect()->route('patient.home')->with('error', 'لم يتم العثور على ملف المريض');
        }

        $appointment = Appointment::with(['doctor', 'clinic', 'medicalRecord'])
            ->where('patient_id', $patient->id)
            ->findOrFail($id);

        return view('patient.appointment-details', compact('appointment', 'user', 'patient'));
    }

    /**
     * إلغاء موعد
     */
    public function cancelAppointment(Request $request, $id)
    {
        $patient = $this->getPatient();

        if (!$patient) {
            return back()->with('error', 'لم يتم العثور على ملف المريض');
        }

        $appointment = Appointment::where('id', $id)
            ->where('patient_id', $patient->id)
            ->firstOrFail();

        $appointment->update(['status' => 'cancelled']); // استخدام update() بدلاً من save()

        return back()->with('success', 'تم إلغاء الموعد بنجاح');
    }

    /**
     * تعيين تذكير للموعد (يمكن تطويرها لاحقاً)
     */
    public function setReminder(Request $request, $id)
    {
        // يمكن ربطها بإشعارات أو SMS
        return back()->with('success', 'تم تعيين التذكير بنجاح');
    }

    /**
     * عرض التشخيصات والتقارير الطبية
     */
    public function diagnoses()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $patient = $this->getPatient();

        if (!$patient) {
            return redirect()->route('patient.home')->with('error', 'لم يتم العثور على ملف المريض');
        }

        $diagnoses = MedicalRecord::where('patient_id', $patient->id)
            ->with('doctor')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('patient.diagnoses', compact('diagnoses', 'user', 'patient'));
    }

    /**
     * عرض الفواتير
     */
    public function invoices()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $patient = $this->getPatient();

        if (!$patient) {
            return redirect()->route('patient.home')->with('error', 'لم يتم العثور على ملف المريض');
        }

        $invoices = Invoice::where('patient_id', $patient->id)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('patient.invoices', compact('invoices', 'user', 'patient'));
    }

    /**
     * عرض صفحة الملف الشخصي
     */
    public function profile()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $patient = $this->getPatient();

        if (!$patient) {
            $patient = Patient::firstOrCreate(
                ['user_id' => $user->id],
                [
                    'name'   => $user->name,
                    'email'  => $user->email,
                    'phone'  => '',
                    'status' => 'active'
                ]
            );
        }

        return view('patient.profile', compact('user', 'patient'));
    }

    /**
     * تحديث بيانات الملف الشخصي (الاسم، الهاتف، العنوان)
     */
    public function updateProfile(Request $request)
    {
        $request->validate([
            'name'    => 'required|string|max:255',
            'phone'   => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
        ]);

        /** @var \App\Models\User $user */
        $user = Auth::user();
        
        // تحديث اسم المستخدم
        $user->update(['name' => $request->name]);

        // تحديث بيانات المريض
        $patient = $this->getPatient();
        if ($patient) {
            $patient->update($request->only('phone', 'address'));
        } else {
            // إنشاء سجل المريض إذا لم يكن موجوداً
            Patient::create([
                'user_id' => $user->id,
                'name'    => $user->name,
                'email'   => $user->email,
                'phone'   => $request->phone,
                'address' => $request->address,
                'status'  => 'active',
            ]);
        }

        return back()->with('success', 'تم تحديث الملف الشخصي بنجاح');
    }

    /**
     * تحديث كلمة المرور
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required|string',
            'password'         => 'required|string|min:6|confirmed',
        ]);

        /** @var \App\Models\User $user */
        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->with('error', 'كلمة المرور الحالية غير صحيحة');
        }

        $user->update(['password' => Hash::make($request->password)]);

        return back()->with('success', 'تم تحديث كلمة المرور بنجاح');
    }

    /**
     * تحديث إعدادات الإشعارات (نموذج أولي)
     */
    public function updateNotificationSettings(Request $request)
    {
        // يمكن تخزين التفضيلات في جدول settings أو patient_settings
        return back()->with('success', 'تم تحديث إعدادات الإشعارات');
    }

    /**
     * تعيين إشعار كمقروء
     */
    public function markNotificationRead($id)
    {
        $notification = Notification::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $notification->update(['is_read' => true]); // استخدام update()

        return response()->json(['success' => true]);
    }
}
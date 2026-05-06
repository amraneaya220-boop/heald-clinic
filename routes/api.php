<?php

// ==================== استخدامات الـ Controllers ====================
// Controllers الخاصة بلوحة التحكم (Admin) - تستخدم لإدارة البيانات
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DoctorController as AdminDoctorController;
use App\Http\Controllers\Clinic\DoctorController as ClinicDoctorController;
use App\Http\Controllers\Admin\PatientController;
use App\Http\Controllers\Admin\AppointmentController;
use App\Http\Controllers\Admin\StatisticsController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\NotificationController;
use App\Http\Controllers\Admin\InvoiceController;
use App\Http\Controllers\Admin\AnnouncementController;

// Controllers الخاصة بالواجهة الأمامية (Front) - تستخدم للمستخدمين العاديين
use App\Http\Controllers\Front\ClinicController;
use App\Http\Controllers\Front\DoctorController as FrontDoctorController;
use App\Http\Controllers\Front\AppointmentController as FrontAppointmentController;
use App\Http\Controllers\Front\ReviewController;
use App\Http\Controllers\Front\HomeController;

// ==================== Controllers الخاصة بالمريض (Patient) ====================
use App\Http\Controllers\Patient\ProfileController;
use App\Http\Controllers\Patient\AppointmentController as PatientAppointmentController;
use App\Http\Controllers\Patient\MedicalRecordController;
use App\Http\Controllers\Patient\InvoiceController as PatientInvoiceController;
use App\Http\Controllers\Patient\NotificationController as PatientNotificationController;

// ==================== Controllers الخاصة بالدكتور ====================
use App\Http\Controllers\Doctor\NotificationController as DoctorNotificationController;

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| جميع مسارات API تبدأ بـ /api ولا تخضع لـ CSRF Protection
|
*/

// ==================== مسارات لوحة التحكم (Admin) ====================

// Dashboard API
Route::get('/dashboard/stats', [DashboardController::class, 'getStats'])->name('api.dashboard.stats');

// Doctors API (إدارة الأطباء)
Route::get('/admin/doctors', [AdminDoctorController::class, 'apiIndex'])->name('api.doctors.index');
Route::post('/admin/doctors', [AdminDoctorController::class, 'store'])->name('api.doctors.store');
Route::put('/admin/doctors/{doctor}', [AdminDoctorController::class, 'update'])->name('api.doctors.update');
Route::delete('/admin/doctors/{doctor}', [AdminDoctorController::class, 'destroy'])->name('api.doctors.destroy');
Route::post('/admin/doctors/{doctor}/toggle-status', [AdminDoctorController::class, 'toggleStatus'])->name('api.doctors.toggle-status');
Route::get('/admin/doctors/{doctor}/schedule', [AdminDoctorController::class, 'getSchedule'])->name('api.doctors.schedule');
Route::post('/admin/doctors/{doctor}/schedule', [AdminDoctorController::class, 'updateSchedule'])->name('api.doctors.schedule.update');
Route::post('/admin/doctors/{doctor}/schedule/reset', [AdminDoctorController::class, 'resetDefaultSchedule'])->name('api.doctors.schedule.reset');

// Patients API (إدارة المرضى)
Route::get('/patients', [PatientController::class, 'apiIndex'])->name('api.patients.index');
Route::post('/patients', [PatientController::class, 'store'])->name('api.patients.store');
Route::put('/patients/{patient}', [PatientController::class, 'update'])->name('api.patients.update');
Route::delete('/patients/{patient}', [PatientController::class, 'destroy'])->name('api.patients.destroy');
Route::post('/patients/{patient}/toggle-status', [PatientController::class, 'toggleStatus'])->name('api.patients.toggle-status');
Route::get('/patients/{patient}/appointments', [PatientController::class, 'getAppointments'])->name('api.patients.appointments');

// Appointments API (إدارة المواعيد)
Route::get('/appointments', [AppointmentController::class, 'apiIndex'])->name('api.appointments.index');
Route::post('/appointments', [AppointmentController::class, 'store'])->name('api.appointments.store');
Route::put('/appointments/{appointment}', [AppointmentController::class, 'update'])->name('api.appointments.update');
Route::put('/appointments/{appointment}/status', [AppointmentController::class, 'updateStatus'])->name('api.appointments.update-status');
Route::delete('/appointments/{appointment}', [AppointmentController::class, 'destroy'])->name('api.appointments.destroy');
Route::get('/appointments/by-date', [AppointmentController::class, 'getByDate'])->name('api.appointments.by-date');
Route::get('/appointments/doctor/{doctor}', [AppointmentController::class, 'getByDoctor'])->name('api.appointments.by-doctor');

// Statistics API (إحصائيات لوحة التحكم)
Route::get('/statistics/data', [StatisticsController::class, 'getData'])->name('api.statistics.data');

// Reports API (تقارير لوحة التحكم)
Route::post('/reports/generate', [ReportController::class, 'generate'])->name('api.reports.generate');

// Settings API (إعدادات النظام)
Route::get('/settings/clinic', [SettingController::class, 'getClinicInfo'])->name('api.settings.clinic');
Route::post('/settings/clinic', [SettingController::class, 'updateClinicInfo'])->name('api.settings.clinic.update');
Route::post('/settings/image', [SettingController::class, 'updateClinicImage'])->name('api.settings.image');
Route::get('/settings/prices', [SettingController::class, 'getPrices'])->name('api.settings.prices');
Route::post('/settings/prices', [SettingController::class, 'updatePrices'])->name('api.settings.prices.update');
Route::post('/settings/services', [SettingController::class, 'addCustomService'])->name('api.settings.services.store');
Route::delete('/settings/services/{service}', [SettingController::class, 'deleteCustomService'])->name('api.settings.services.destroy');
Route::get('/settings/schedules', [SettingController::class, 'getSchedules'])->name('api.settings.schedules');
Route::post('/settings/schedules', [SettingController::class, 'addSchedule'])->name('api.settings.schedules.store');
Route::delete('/settings/schedules/{schedule}', [SettingController::class, 'deleteSchedule'])->name('api.settings.schedules.destroy');
Route::get('/settings/specialties', [SettingController::class, 'getSpecialties'])->name('api.settings.specialties');

// Notifications API (إشعارات لوحة التحكم)
Route::get('/notifications', [NotificationController::class, 'apiIndex'])->name('api.notifications.index');
Route::get('/notifications/latest', [NotificationController::class, 'getLatest'])->name('api.notifications.latest');
Route::post('/notifications/{notification}/read', [NotificationController::class, 'markAsRead'])->name('api.notifications.read');
Route::post('/notifications/mark-all-read', [NotificationController::class, 'markAllAsRead'])->name('api.notifications.mark-all-read');
Route::delete('/notifications/clear-all', [NotificationController::class, 'clearAll'])->name('api.notifications.clear-all');

// Invoices API (فواتير لوحة التحكم)
Route::get('/invoices', [InvoiceController::class, 'apiIndex'])->name('api.invoices.index');
Route::get('/invoices/{invoice}', [InvoiceController::class, 'show'])->name('api.invoices.show');
Route::post('/invoices', [InvoiceController::class, 'store'])->name('api.invoices.store');
Route::put('/invoices/{invoice}/payment', [InvoiceController::class, 'updatePaymentStatus'])->name('api.invoices.payment');
Route::delete('/invoices/{invoice}', [InvoiceController::class, 'destroy'])->name('api.invoices.destroy');
Route::get('/invoices/stats', [InvoiceController::class, 'getStats'])->name('api.invoices.stats');

// Patients search (for invoices) – بحث المرضى من الفواتير
Route::get('/patients/search', [InvoiceController::class, 'searchPatient'])->name('api.patients.search');
Route::get('/patients/{patient}/appointments', [InvoiceController::class, 'getPatientAppointments'])->name('api.patients.appointments');

// Announcements API (إعلانات لوحة التحكم)
Route::get('/announcements', [AnnouncementController::class, 'apiIndex'])->name('api.announcements.index');
Route::post('/announcements', [AnnouncementController::class, 'store'])->name('api.announcements.store');
Route::delete('/announcements/{announcement}', [AnnouncementController::class, 'destroy'])->name('api.announcements.destroy');

// ==================== مسارات الواجهة الأمامية (Frontend) ====================
// هذه المسارات تستخدمها الـ AJAX في صفحات المريض (الموقع العام)

// العيادات (للبحث والعرض)
Route::get('/clinics', [ClinicController::class, 'apiIndex'])->name('api.clinics.index');
Route::get('/clinics/{id}', [ClinicController::class, 'apiShow'])->name('api.clinics.show');
Route::get('/clinics/search', [HomeController::class, 'search'])->name('api.clinics.search');

// الأطباء (للبحث والعرض)
Route::get('/doctors/list', [FrontDoctorController::class, 'apiIndex'])->name('api.doctors.list');
Route::get('/doctors/{id}', [FrontDoctorController::class, 'apiShow'])->name('api.doctors.show');
Route::get('/clinic/{clinicId}/doctors', [FrontDoctorController::class, 'apiGetByClinic'])->name('api.clinic.doctors');

// المواعيد (حجز المواعيد للمرضى)
Route::post('/appointments/book', [FrontAppointmentController::class, 'apiStore'])->name('api.appointments.book');
Route::post('/appointments/clinic-book', [FrontAppointmentController::class, 'apiStoreClinic'])->name('api.appointments.clinic-book');
Route::get('/appointments/patient', [FrontAppointmentController::class, 'apiPatientAppointments'])->name('api.appointments.patient')->middleware('auth:sanctum');
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/reviews', [ReviewController::class, 'store']);
});
// التقييمات (إضافة وعرض)
Route::post('/reviews', [ReviewController::class, 'apiStore'])->name('api.reviews.store');
Route::get('/reviews/{type}/{id}', [ReviewController::class, 'apiGet'])->name('api.reviews.get');
Route::get('/reviews/clinic/{clinic}', [ReviewController::class, 'getClinicReviews']);
Route::get('/clinics/{clinic}/stats', [ClinicController::class, 'getStats']);
// ==================== مسارات API الخاصة بالمريض (Patient API) ====================
// هذه المسارات تستخدمها صفحات المريض عبر AJAX (تتطلب مصادقة)

Route::prefix('patient')->middleware('auth:sanctum')->group(function () {
    
    // الملف الشخصي
    Route::get('/profile', [ProfileController::class, 'apiGet'])->name('api.patient.profile');
    Route::put('/profile', [ProfileController::class, 'apiUpdate'])->name('api.patient.profile.update');
    
    // المواعيد
    Route::get('/appointments', [PatientAppointmentController::class, 'apiIndex'])->name('api.patient.appointments');
    Route::get('/appointments/upcoming', [PatientAppointmentController::class, 'apiUpcoming'])->name('api.patient.appointments.upcoming');
    Route::get('/appointments/past', [PatientAppointmentController::class, 'apiPast'])->name('api.patient.appointments.past');
    Route::get('/appointments/{id}', [PatientAppointmentController::class, 'apiShow'])->name('api.patient.appointments.show');
    Route::put('/appointments/{id}/cancel', [PatientAppointmentController::class, 'apiCancel'])->name('api.patient.appointments.cancel');
    Route::post('/appointments/{id}/reminder', [PatientAppointmentController::class, 'apiSetReminder'])->name('api.patient.appointments.reminder');
    
    // السجلات الطبية (Diagnoses)
    Route::get('/medical-records', [MedicalRecordController::class, 'apiIndex'])->name('api.patient.medical-records');
    Route::get('/medical-records/{id}', [MedicalRecordController::class, 'apiShow'])->name('api.patient.medical-records.show');
    
    // الفواتير
    Route::get('/invoices', [PatientInvoiceController::class, 'apiIndex'])->name('api.patient.invoices');
    Route::get('/invoices/{id}', [PatientInvoiceController::class, 'apiShow'])->name('api.patient.invoices.show');
    
    // الإشعارات
    Route::get('/notifications', [PatientNotificationController::class, 'apiIndex'])->name('api.patient.notifications');
    Route::post('/notifications/{id}/read', [PatientNotificationController::class, 'apiMarkAsRead'])->name('api.patient.notifications.read');
    Route::post('/notifications/mark-all-read', [PatientNotificationController::class, 'apiMarkAllAsRead'])->name('api.patient.notifications.mark-all-read');
    Route::delete('/notifications/clear-all', [PatientNotificationController::class, 'apiClearAll'])->name('api.patient.notifications.clear-all');
});

// ==================== مسارات API الخاصة بالدكتور ====================
Route::prefix('doctor')->middleware('auth:sanctum')->group(function () {
    Route::get('/notifications', [DoctorNotificationController::class, 'apiIndex']);
    Route::post('/notifications/{id}/read', [DoctorNotificationController::class, 'apiMarkAsRead']);
});
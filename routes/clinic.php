<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Clinic\DashboardController;
use App\Http\Controllers\Clinic\DoctorController as ClinicDoctorController;
use App\Http\Controllers\Clinic\PatientController;
use App\Http\Controllers\Clinic\AppointmentController;
use App\Http\Controllers\Clinic\StatisticsController;
use App\Http\Controllers\Clinic\ReportController;
use App\Http\Controllers\Clinic\SettingController;
use App\Http\Controllers\Clinic\NotificationController;
use App\Http\Controllers\Clinic\InvoiceController;
use App\Http\Controllers\Clinic\AnnouncementController;

/*
|--------------------------------------------------------------------------
| Clinic Routes
|--------------------------------------------------------------------------
*/

Route::prefix('clinic')->middleware(['auth', 'role:clinic'])->name('clinic.')->group(function () {

    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/stats', [DashboardController::class, 'getStats'])->name('dashboard.stats');
    Route::get('/dashboard/recent', [DashboardController::class, 'getRecentAppointments'])->name('dashboard.recent');
    Route::get('/dashboard/reviews', [DashboardController::class, 'getReviews'])->name('dashboard.reviews');
    Route::delete('/reviews/{id}', [DashboardController::class, 'deleteReview'])->name('reviews.delete');

    // Doctors
    Route::get('/doctors', [ClinicDoctorController::class, 'index'])->name('doctors.index');
    Route::get('/doctors/data', [ClinicDoctorController::class, 'getData'])->name('doctors.data');
    Route::get('/doctors/list', [ClinicDoctorController::class, 'list'])->name('doctors.list');
    Route::post('/doctors', [ClinicDoctorController::class, 'store'])->name('doctors.store');
    Route::get('/doctors/{doctor}/edit', [ClinicDoctorController::class, 'edit'])->name('doctors.edit');
    Route::put('/doctors/{doctor}', [ClinicDoctorController::class, 'update'])->name('doctors.update');
    Route::delete('/doctors/{doctor}', [ClinicDoctorController::class, 'destroy'])->name('doctors.destroy');
    Route::post('/doctors/{doctor}/toggle-status', [ClinicDoctorController::class, 'toggleStatus'])->name('doctors.toggle-status');
    Route::get('/doctors/{doctor}/schedule', [ClinicDoctorController::class, 'getSchedule'])->name('doctors.schedule');
    Route::post('/doctors/{doctor}/schedule', [ClinicDoctorController::class, 'updateSchedule'])->name('doctors.schedule.update');
    Route::post('/doctors/{doctor}/schedule/reset', [ClinicDoctorController::class, 'resetDefaultSchedule'])->name('doctors.schedule.reset');

    // Patients
    Route::get('/patients', [PatientController::class, 'index'])->name('patients.index');
    Route::get('/patients/data', [PatientController::class, 'getData'])->name('patients.data');
    Route::post('/patients', [PatientController::class, 'store'])->name('patients.store');
    Route::get('/patients/{patient}/edit', [PatientController::class, 'edit'])->name('patients.edit');
    Route::put('/patients/{patient}', [PatientController::class, 'update'])->name('patients.update');
    Route::delete('/patients/{patient}', [PatientController::class, 'destroy'])->name('patients.destroy');
    Route::post('/patients/{patient}/toggle-status', [PatientController::class, 'toggleStatus'])->name('patients.toggle-status');

    // Appointments
    Route::get('/appointments', [AppointmentController::class, 'index'])->name('appointments.index');
    Route::get('/appointments/data', [AppointmentController::class, 'getAppointments'])->name('appointments.data');
    Route::post('/appointments', [AppointmentController::class, 'store'])->name('appointments.store');
    Route::get('/appointments/{appointment}/edit', [AppointmentController::class, 'edit'])->name('appointments.edit');
    Route::put('/appointments/{appointment}', [AppointmentController::class, 'update'])->name('appointments.update');
    Route::delete('/appointments/{appointment}', [AppointmentController::class, 'destroy'])->name('appointments.destroy');
    Route::put('/appointments/{appointment}/status', [AppointmentController::class, 'updateStatus'])->name('appointments.status');

    // ========== ROUTES الجديدة لـ Manage Appointments ==========
    Route::get('/appointments/get-data', [AppointmentController::class, 'getAppointmentsData'])->name('appointments.get-data');
    Route::post('/appointments/store-appointment', [AppointmentController::class, 'storeAppointment'])->name('appointments.store-appointment');
    Route::put('/appointments/{id}/update-status', [AppointmentController::class, 'updateAppointmentStatus'])->name('appointments.update-status');
    Route::put('/appointments/{id}/update-appointment', [AppointmentController::class, 'updateAppointment'])->name('appointments.update-appointment');
    Route::delete('/appointments/{id}/delete-appointment', [AppointmentController::class, 'deleteAppointment'])->name('appointments.delete-appointment');
    Route::get('/doctors/list-ajax', [AppointmentController::class, 'getDoctorsList'])->name('doctors.list-ajax');
    // Invoices
    Route::get('/invoices', [InvoiceController::class, 'index'])->name('invoices.index');
    Route::get('/invoices/data', [InvoiceController::class, 'getInvoicesData'])->name('invoices.data');
    Route::post('/invoices', [InvoiceController::class, 'store'])->name('invoices.store');
    Route::put('/invoices/{id}/payment', [InvoiceController::class, 'updatePaymentStatus'])->name('invoices.payment');
    Route::delete('/invoices/{id}', [InvoiceController::class, 'destroy'])->name('invoices.destroy');
    Route::post('/invoices/settings', [InvoiceController::class, 'updateSettings'])->name('invoices.settings');
    Route::get('/invoices/stats', [InvoiceController::class, 'getStats'])->name('invoices.stats');
// Invoices Routes
Route::get('/invoices/generate-number', [InvoiceController::class, 'generateInvoiceNumber'])->name('invoices.generate-number');
    // Notifications
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::get('/notifications/data', [NotificationController::class, 'getData'])->name('notifications.data');
    Route::get('/notifications/unread', [NotificationController::class, 'unreadCount'])->name('notifications.unread');
    Route::post('/notifications/{notification}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::post('/notifications/mark-all-read', [NotificationController::class, 'markAllAsRead'])->name('notifications.mark-all-read');
    Route::delete('/notifications/clear-all', [NotificationController::class, 'clearAll'])->name('notifications.clear-all');

    // Statistics
    Route::get('/statistics', [StatisticsController::class, 'index'])->name('statistics.index');
    Route::get('/statistics/stats', [StatisticsController::class, 'getStats'])->name('statistics.stats');

    // Reports
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::post('/reports/generate', [ReportController::class, 'generate'])->name('reports.generate');

    // Settings
    Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
    Route::get('/settings/data', [SettingController::class, 'getData'])->name('settings.data');
    Route::post('/settings/clinic/update', [SettingController::class, 'updateClinicInfo'])->name('settings.clinic.update');
    Route::post('/settings/prices/update', [SettingController::class, 'updatePrices'])->name('settings.prices.update');
    Route::post('/settings/services/store', [SettingController::class, 'storeCustomService'])->name('settings.services.store');
    Route::delete('/settings/services/{id}', [SettingController::class, 'deleteCustomService'])->name('settings.services.delete');
    Route::post('/settings/schedules/store', [SettingController::class, 'storeSchedule'])->name('settings.schedules.store');
    Route::delete('/settings/schedules/{id}', [SettingController::class, 'deleteSchedule'])->name('settings.schedules.delete');
    Route::post('/settings/specialties/store', [SettingController::class, 'storeSpecialty'])->name('settings.specialties.store');
    Route::delete('/settings/specialties/{id}', [SettingController::class, 'deleteSpecialty'])->name('settings.specialties.delete');
    Route::post('/settings/image/upload', [SettingController::class, 'uploadImage'])->name('settings.image.upload');

    // Announcements
    Route::get('/announcements', [AnnouncementController::class, 'index'])->name('announcements.index');
    Route::get('/announcements/data', [AnnouncementController::class, 'getData'])->name('announcements.data');
    Route::post('/announcements', [AnnouncementController::class, 'store'])->name('announcements.store');
    Route::get('/announcements/{announcement}', [AnnouncementController::class, 'show'])->name('announcements.show');
    Route::delete('/announcements/{announcement}', [AnnouncementController::class, 'destroy'])->name('announcements.destroy');
});

// Route للاختبار
Route::get('/test-db', [App\Http\Controllers\Clinic\AppointmentController::class, 'testConnection']);
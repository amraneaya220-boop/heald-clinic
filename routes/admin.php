<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\AdminClinicController;
use App\Http\Controllers\Admin\AdminBookingController;
use App\Http\Controllers\Admin\AdminAdController;
use App\Http\Controllers\Admin\AdminPaymentController;
use App\Http\Controllers\Admin\AdminSettingController;
use App\Http\Controllers\Admin\AdminNotificationController;
use App\Http\Controllers\Admin\DoctorController as AdminDoctorController;

/*
|--------------------------------------------------------------------------
| Admin Routes (Super Admin)
|--------------------------------------------------------------------------
|
| هذه الملف مخصص لمسارات المشرف (Admin) ويتم تحميله تلقائياً من
| RouteServiceProvider.
|
*/

Route::prefix('admin')->middleware(['auth', 'role:admin'])->name('admin.')->group(function () {
    // Dashboard
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard.alternative');

    // Clinics
    Route::get('/clinics', [AdminClinicController::class, 'index'])->name('clinics');
    Route::post('/clinics', [AdminClinicController::class, 'store'])->name('clinics.store');
    Route::post('/clinics/{id}/renew', [AdminClinicController::class, 'renew'])->name('clinics.renew');
    Route::delete('/clinics/{id}', [AdminClinicController::class, 'destroy'])->name('clinics.destroy');

    // Bookings
    Route::get('/bookings', [AdminBookingController::class, 'index'])->name('bookings');

    // Ads
    Route::get('/ads', [AdminAdController::class, 'index'])->name('ads');
    Route::post('/ads', [AdminAdController::class, 'store'])->name('ads.store');
    Route::delete('/ads/{id}', [AdminAdController::class, 'destroy'])->name('ads.destroy');

    // Payments
    Route::get('/payments', [AdminPaymentController::class, 'index'])->name('payments');
    Route::post('/payments', [AdminPaymentController::class, 'store'])->name('payments.store');
    Route::post('/payments/{id}/paid', [AdminPaymentController::class, 'markAsPaid'])->name('payments.paid');
    Route::delete('/payments/{id}', [AdminPaymentController::class, 'destroy'])->name('payments.destroy');

    // Settings
    Route::get('/settings', [AdminSettingController::class, 'index'])->name('settings');
    Route::post('/settings/profile', [AdminSettingController::class, 'updateProfile'])->name('settings.profile');
    Route::post('/settings/system', [AdminSettingController::class, 'updateSystem'])->name('settings.system');
    Route::post('/settings/notifications', [AdminSettingController::class, 'updateNotifications'])->name('settings.notifications');

    // Notifications
    Route::get('/notifications', [AdminNotificationController::class, 'index'])->name('notifications');
    Route::post('/notifications/{id}/read', [AdminNotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::post('/notifications/mark-all-read', [AdminNotificationController::class, 'markAllAsRead'])->name('notifications.mark-all-read');
    Route::delete('/notifications/clear-all', [AdminNotificationController::class, 'clearAll'])->name('notifications.clear-all');

    // Doctors
    Route::get('/doctors', [AdminDoctorController::class, 'index'])->name('doctors');
});


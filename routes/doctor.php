<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Doctor\DoctorDashboardController;
use App\Http\Controllers\Doctor\DoctorAppointmentController;
use App\Http\Controllers\Doctor\PatientRecordController;
use App\Http\Controllers\Doctor\ScheduleController;
use App\Http\Controllers\Doctor\DoctorSettingController;

/*
|--------------------------------------------------------------------------
| Doctor Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:doctor'])->prefix('doctor')->name('doctor.')->group(function () {

    // Dashboard
    Route::get('/dashboard', [DoctorDashboardController::class, 'index'])->name('dashboard');
    Route::get('/', [DoctorDashboardController::class, 'index'])->name('home');

    // Appointments
    Route::prefix('appointments')->name('appointments.')->group(function () {
        Route::get('/', [DoctorAppointmentController::class, 'index'])->name('index');
        Route::get('/today', [DoctorAppointmentController::class, 'today'])->name('today');
        Route::get('/upcoming', [DoctorAppointmentController::class, 'upcoming'])->name('upcoming');
        Route::get('/completed', [DoctorAppointmentController::class, 'completed'])->name('completed');
        Route::get('/cancelled', [DoctorAppointmentController::class, 'cancelled'])->name('cancelled');
        Route::get('/create', [DoctorAppointmentController::class, 'create'])->name('create');
        Route::post('/', [DoctorAppointmentController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [DoctorAppointmentController::class, 'edit'])->name('edit');
        Route::put('/{id}', [DoctorAppointmentController::class, 'update'])->name('update');
        Route::delete('/{id}', [DoctorAppointmentController::class, 'destroy'])->name('destroy');
        Route::put('/{id}/status', [DoctorAppointmentController::class, 'updateStatus'])->name('update-status');
        Route::post('/{id}/medical-record', [DoctorAppointmentController::class, 'saveMedicalRecord'])->name('medical-record');
        Route::delete('/{id}/cancel', [DoctorAppointmentController::class, 'cancel'])->name('cancel');
        Route::get('/{id}/details', [DoctorAppointmentController::class, 'details'])->name('details');
        Route::get('/appointments/{id}/detail', [App\Http\Controllers\Doctor\DoctorDashboardController::class, 'appointmentDetail'])->name('appointments.detail');
        Route::get('/appointments/{id}/detail', [DoctorDashboardController::class, 'appointmentDetail'])->name('appointments.detail');
    Route::post('/appointments/save-diagnosis', [App\Http\Controllers\Doctor\DoctorDashboardController::class, 'saveDiagnosis'])->name('appointments.save-diagnosis');
    Route::post('/appointments/{id}/cancel', [App\Http\Controllers\Doctor\DoctorDashboardController::class, 'cancelAppointment'])->name('appointments.cancel');
    Route::post('/appointments/{id}/complete', [App\Http\Controllers\Doctor\DoctorDashboardController::class, 'completeAppointment'])->name('appointments.complete');
    Route::post('/notifications/{id}/mark-read', [App\Http\Controllers\Doctor\DoctorDashboardController::class, 'markNotificationAsRead'])->name('notifications.mark-read');
    Route::get('/settings', [App\Http\Controllers\Doctor\DoctorDashboardController::class, 'settings'])->name('settings');
    });

    // Schedule Management
    Route::get('/schedule', [ScheduleController::class, 'index'])->name('schedule');
    Route::prefix('schedule')->name('schedule.')->group(function () {
        Route::post('/update', [ScheduleController::class, 'update'])->name('update');
        Route::post('/reset', [ScheduleController::class, 'resetDefault'])->name('reset');
        Route::get('/slots', [ScheduleController::class, 'getAvailableSlots'])->name('slots');
    });

    // Patient Records
    Route::prefix('patients')->name('patients.')->group(function () {
        Route::get('/', [PatientRecordController::class, 'index'])->name('index');
        Route::get('/{patientId}', [PatientRecordController::class, 'show'])->name('show');
        Route::get('/{patientId}/records', [PatientRecordController::class, 'getRecords'])->name('records');
        Route::get('/{patientId}/record', [PatientRecordController::class, 'show'])->name('record');
        Route::post('/{patientId}/appointment', [PatientRecordController::class, 'addAppointment'])->name('add-appointment');
        Route::post('/{patientId}/prescription', [PatientRecordController::class, 'addPrescription'])->name('add-prescription');
        Route::post('/{patientId}/diagnosis', [PatientRecordController::class, 'addDiagnosis'])->name('add-diagnosis');
    });

    // Settings
    Route::get('/settings', [DoctorSettingController::class, 'index'])->name('settings');
    Route::prefix('settings')->name('settings.')->group(function () {
        Route::post('/update', [DoctorSettingController::class, 'update'])->name('update');
        Route::post('/profile', [DoctorSettingController::class, 'updateProfile'])->name('profile');
        Route::post('/password', [DoctorSettingController::class, 'updatePassword'])->name('password');
        Route::post('/notifications', [DoctorSettingController::class, 'updateNotifications'])->name('notifications');
    });
});


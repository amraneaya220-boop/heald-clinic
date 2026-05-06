<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Patient\PatientController;

/*
|--------------------------------------------------------------------------
| Patient Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:patient'])->prefix('patient')->name('patient.')->group(function () {
    Route::get('/dashboard', [PatientController::class, 'home'])->name('dashboard');
    Route::get('/', [PatientController::class, 'home'])->name('index');
    Route::get('/home', [PatientController::class, 'home'])->name('home');

    Route::get('/appointments', [PatientController::class, 'appointments'])->name('appointments');
    Route::get('/appointment/{id}', [PatientController::class, 'appointmentDetails'])->name('appointment.details');
    Route::patch('/appointment/{id}/cancel', [PatientController::class, 'cancelAppointment'])->name('appointments.cancel');
    Route::post('/appointment/{id}/reminder', [PatientController::class, 'setReminder'])->name('appointments.reminder');

    Route::get('/diagnoses', [PatientController::class, 'diagnoses'])->name('diagnoses');
    Route::get('/invoices', [PatientController::class, 'invoices'])->name('invoices');

    Route::get('/profile', [PatientController::class, 'profile'])->name('profile');
    Route::put('/profile', [PatientController::class, 'updateProfile'])->name('profile.update');
    Route::put('/profile/password', [PatientController::class, 'updatePassword'])->name('profile.password');
    Route::put('/profile/notifications', [PatientController::class, 'updateNotificationSettings'])->name('profile.notifications');

    Route::post('/notifications/{id}/read', [PatientController::class, 'markNotificationRead'])->name('notifications.markRead');
});


<?php

use Illuminate\Support\Facades\Route;
use App\Models\Clinic;
use App\Models\Doctor;

// ==================== Auth Controller ====================
use App\Http\Controllers\AuthController;

// ==================== Front Controllers ====================
use App\Http\Controllers\Front\HomeController;
use App\Http\Controllers\Front\ClinicController;
use App\Http\Controllers\Front\DoctorController as FrontDoctorController;
use App\Http\Controllers\Front\AppointmentController as FrontAppointmentController;
use App\Http\Controllers\Front\ReviewController;

// ==================== Admin Super Admin Controllers ====================
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
| Web Routes
|--------------------------------------------------------------------------
*/

// ==================== 1. الصفحة الرئيسية ====================
Route::get('/', function () {
    return view('startpage');
})->name('home');

// ==================== 2. الواجهة الأمامية (Front) ====================
Route::get('/front', [HomeController::class, 'index'])->name('front');
if (file_exists(__DIR__.'/clinic.php')) {
    require __DIR__.'/clinic.php';
}
// Clinic Routes (مستقلة)
Route::prefix('clinic')->name('clinic.')->group(function () {
    Route::get('/', [ClinicController::class, 'index'])->name('index');
    Route::get('/list', [ClinicController::class, 'list'])->name('list');
    Route::get('/{id}', [ClinicController::class, 'show'])->name('show');
    Route::get('/{id}/details', [ClinicController::class, 'details'])->name('details');
    Route::get('/{id}/doctors', [ClinicController::class, 'doctors'])->name('doctors');
});
Route::get('/clinics', [ClinicController::class, 'index'])->name('clinics.index');

// Doctor Routes (مستقلة)
Route::prefix('doctor')->name('doctor.')->group(function () {
    Route::get('/{id}', [FrontDoctorController::class, 'show'])
    ->where('id', '[0-9]+')
    ->name('show');
    Route::get('/clinic/{clinicId}', [FrontDoctorController::class, 'index'])->name('clinic.doctors');
});

// ==================== 3. حجز المواعيد (Appointments) ====================
Route::prefix('appointment')->name('appointment.')->group(function () {
    Route::get('/doctor/{doctorId}', [FrontAppointmentController::class, 'create'])->name('create');
    Route::post('/', [FrontAppointmentController::class, 'store'])->name('store');
    Route::get('/clinic/{clinicId}', [FrontAppointmentController::class, 'createClinic'])->name('clinic.create');
    Route::post('/clinic', [FrontAppointmentController::class, 'storeClinic'])->name('clinic.store');
});

Route::prefix('appointments')->name('appointments.')->group(function () {
    Route::get('/create', [FrontAppointmentController::class, 'create'])->name('create');
    Route::post('/store', [FrontAppointmentController::class, 'store'])->name('store');
    Route::get('/{id}', [FrontAppointmentController::class, 'show'])->name('show');
    Route::get('/user/{userId}', [FrontAppointmentController::class, 'userAppointments'])->name('user');
    Route::put('/{id}/cancel', [FrontAppointmentController::class, 'cancel'])->name('cancel');
});

// ==================== 4. التقييمات (Reviews) ====================
Route::prefix('reviews')->name('reviews.')->group(function () {
    Route::get('/clinic/{id}', [ReviewController::class, 'apiGet'])->name('clinic');
    Route::post('/', [ReviewController::class, 'apiStore'])->name('store');
});

// API Routes للتقييمات (متوافقة مع الـ fetch في frontend)
Route::get('/api/reviews/clinic/{id}', [ReviewController::class, 'apiGet']);
Route::post('/api/reviews', [ReviewController::class, 'apiStore']);
Route::get('/api/clinics/{id}/stats', [ClinicController::class, 'getStats']);

// ==================== 5. المصادقة (Authentication) ====================
Route::get('/login/{type?}', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/register/{type?}', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ==================== 6. تبديل اللغة ====================
Route::get('/lang/{locale}', function ($locale) {
    if (in_array($locale, ['en', 'ar', 'fr'])) {
        app()->setLocale($locale);
        session()->put('locale', $locale);
    }
    return redirect()->back();
})->name('lang.switch');

// ==================== 7. Super Admin Auth Routes ====================
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [App\Http\Controllers\Admin\AuthController::class, 'showLoginForm'])->name('login.form');
    Route::post('/login', [App\Http\Controllers\Admin\AuthController::class, 'login'])->name('login');
    Route::post('/logout', [App\Http\Controllers\Admin\AuthController::class, 'logout'])->name('logout');
});

// ==================== 8. Super Admin Dashboard Routes (محمية) ====================
Route::prefix('admin')->middleware('super.admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard.alternative');
Route::get('/clinics', [AdminClinicController::class, 'index'])->name('clinics');
    // Clinics Management
    Route::prefix('clinics')->name('clinics.')->group(function () {
        Route::get('/', [AdminClinicController::class, 'index'])->name('index');
        Route::post('/', [AdminClinicController::class, 'store'])->name('store');
        Route::post('/{id}/renew', [AdminClinicController::class, 'renew'])->name('renew');
        Route::delete('/{id}', [AdminClinicController::class, 'destroy'])->name('destroy');
        Route::get('/notifications/data', [AdminNotificationController::class, 'getNotifications'])->name('notifications.data');
    });
    
    // Bookings Management
    Route::prefix('bookings')->name('bookings.')->group(function () {
        Route::get('/', [AdminBookingController::class, 'index'])->name('index');
    });
    
    // Ads Management
    Route::prefix('ads')->name('ads.')->group(function () {
        Route::get('/', [AdminAdController::class, 'index'])->name('index');
        Route::post('/', [AdminAdController::class, 'store'])->name('store');
        Route::delete('/{id}', [AdminAdController::class, 'destroy'])->name('destroy');
    });
    
    // Payments Management
    Route::prefix('payments')->name('payments.')->group(function () {
        Route::get('/', [AdminPaymentController::class, 'index'])->name('index');
        Route::post('/', [AdminPaymentController::class, 'store'])->name('store');
        Route::post('/{id}/paid', [AdminPaymentController::class, 'markAsPaid'])->name('paid');
        Route::delete('/{id}', [AdminPaymentController::class, 'destroy'])->name('destroy');
    });
    
    // Settings
    Route::prefix('settings')->name('settings.')->group(function () {
        Route::get('/', [AdminSettingController::class, 'index'])->name('index');
        Route::post('/profile', [AdminSettingController::class, 'updateProfile'])->name('profile');
        Route::post('/system', [AdminSettingController::class, 'updateSystem'])->name('system');
        Route::post('/notifications', [AdminSettingController::class, 'updateNotifications'])->name('notifications');
    });
    
    // Notifications
    Route::prefix('notifications')->name('notifications.')->group(function () {
        Route::get('/', [AdminNotificationController::class, 'index'])->name('index');
        Route::post('/{id}/read', [AdminNotificationController::class, 'markAsRead'])->name('read');
        Route::post('/mark-all-read', [AdminNotificationController::class, 'markAllAsRead'])->name('mark-all-read');
        Route::delete('/clear-all', [AdminNotificationController::class, 'clearAll'])->name('clear-all');
    });
    
    // Doctors Management
    Route::prefix('doctors')->name('doctors.')->group(function () {
        Route::get('/', [AdminDoctorController::class, 'index'])->name('index');
    });
});
// ==================== Clinic Subscription Routes ====================
Route::middleware(['auth', 'role:clinic'])->prefix('clinic')->name('clinic.')->group(function () {
    
    // صفحة انتظار الموافقة
    Route::get('/pending-approval', function () {
        return view('clinic.pending_approval');
    })->name('pending.approval');
    
    // نظام الاشتراكات
    Route::get('/subscription/plans', [App\Http\Controllers\Clinic\SubscriptionController::class, 'plans'])
        ->name('subscription.plans');
    
    Route::post('/subscription/subscribe', [App\Http\Controllers\Clinic\SubscriptionController::class, 'subscribe'])
        ->name('subscription.subscribe');
    
    Route::get('/subscription/history', [App\Http\Controllers\Clinic\SubscriptionController::class, 'history'])
        ->name('subscription.history');
    
    Route::post('/subscription/use-trial', [App\Http\Controllers\Clinic\SubscriptionController::class, 'useTrial'])
        ->name('subscription.use-trial');
});

// ==================== Admin Approval Routes ====================
Route::middleware(['super.admin'])->prefix('admin')->name('admin.')->group(function () {
    
    Route::get('/clinics/pending', [App\Http\Controllers\Admin\AdminClinicController::class, 'pending'])
        ->name('clinics.pending');
    
    Route::post('/clinics/{id}/approve', [App\Http\Controllers\Admin\AdminClinicController::class, 'approve'])
        ->name('clinics.approve');
    
    Route::post('/clinics/{id}/reject', [App\Http\Controllers\Admin\AdminClinicController::class, 'reject'])
        ->name('clinics.reject');
    
    Route::get('/subscriptions',[App\Http\Controllers\Admin\AdminClinicController::class, 'index'])
        ->name('subscriptions.index');
});

// ==================== 9. Routes إضافية للحفاظ على التوافق ====================
// هذه الـ routes للحفاظ على التوافق مع الكود القديم
Route::get('/clinic/{id}', [ClinicController::class, 'show'])->name('clinic.show');
Route::get('/clinic/{id}/details', [ClinicController::class, 'details'])->name('clinic.details');
// Load external route files (إذا كانت موجودة)

if (file_exists(__DIR__.'/doctor.php')) {
    require __DIR__.'/doctor.php';
}
if (file_exists(__DIR__.'/patient.php')) {
    require __DIR__.'/patient.php';
}
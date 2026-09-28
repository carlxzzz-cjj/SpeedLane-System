<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;  
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\ManageServiceController;
use App\Http\Controllers\Admin\TransactionController;
use App\Http\Controllers\Customer\TrackController;  
use App\Http\Controllers\AdminPasswordResetController;

/*
|--------------------------------------------------------------------------
| TEMPORARY DATABASE SETUP ROUTE (RENDER FREE TIER)
|--------------------------------------------------------------------------
*/
Route::get('/setup-db', function () {
    try {
        Artisan::call('migrate', ['--force' => true]);
        Artisan::call('config:clear');
        Artisan::call('cache:clear');
        Artisan::call('route:clear');
        Artisan::call('view:clear');

        return '<h1>Success!</h1><p>Database migrations executed and application cache cleared successfully.</p>';
    } catch (\Exception $e) {
        return '<h1>Setup Failed</h1><p>Error: ' . $e->getMessage() . '</p>';
    }
});

/*
|--------------------------------------------------------------------------
| 1. PUBLIC & CUSTOMER ROUTES
|--------------------------------------------------------------------------
*/
Route::get('/', [TrackController::class, 'index'])->name('home');
Route::get('/track', [TrackController::class, 'track'])->name('customer.track');

/*
|--------------------------------------------------------------------------
| 2. ADMIN AUTHENTICATION & PASSWORD RESET ROUTES (PUBLIC)
|--------------------------------------------------------------------------
*/
Route::get('/admin/login', [AuthController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login', [AuthController::class, 'login'])->name('admin.login.submit');
Route::post('/admin/logout', [AuthController::class, 'logout'])->name('admin.logout');

// Unauthenticated Password Reset Routes (Gmail OTP)
Route::post('/admin/send-otp', [AdminPasswordResetController::class, 'sendOtp'])->name('admin.send-otp');
Route::post('/admin/reset-password-otp', [AdminPasswordResetController::class, 'resetPasswordWithOtp'])->name('admin.reset-password-otp');

/*
|--------------------------------------------------------------------------
| 3. PROTECTED ADMIN & SUPER ADMIN ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    // Admin Dashboard
    Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

    // Register Staff Accounts
    Route::post('/admin/create-staff', [AuthController::class, 'register'])->name('admin.register.store');

    // Vehicle Service Registration
    Route::get('/admin/register-service', [ServiceController::class, 'create'])->name('admin.register-service');
    Route::post('/admin/register-service', [ServiceController::class, 'store'])->name('services.store');

    // Update Status Page & Additional Services
    Route::get('/admin/update', [ServiceController::class, 'index'])->name('admin.update');
    Route::put('/admin/update/{id}', [ServiceController::class, 'updateStatus'])->name('admin.update-status');
    Route::patch('/admin/update/{id}', [ServiceController::class, 'updateStatus'])->name('services.updateStatus');

    Route::post('/admin/update/{id}/add-service', [ServiceController::class, 'addAdditional'])->name('admin.add-additional');
    Route::post('/admin/update/{id}/add-service-alt', [ServiceController::class, 'addAdditional'])->name('services.addAdditional');

    // Transactions History & PDF Export
    Route::get('/admin/transactions', [TransactionController::class, 'index'])->name('admin.transactions');
    Route::get('/admin/transactions/report/download', [TransactionController::class, 'downloadReport'])->name('admin.transactions.reports.download');
    Route::get('/admin/transactions/{id}/pdf', [TransactionController::class, 'downloadPdf'])->name('admin.transactions.pdf');

    /*
    |--------------------------------------------------------------------------
    | SUPER ADMIN ONLY: MANAGE SERVICES & STAFF
    |--------------------------------------------------------------------------
    */
    Route::prefix('admin/manage-services')->name('admin.manage-services.')->group(function () {
        Route::get('/', [ManageServiceController::class, 'index'])->name('index');
        Route::post('/services', [ManageServiceController::class, 'storeService'])->name('store-service');
        Route::put('/services/{id}', [ManageServiceController::class, 'updateService'])->name('update-service');
        Route::delete('/services/{id}', [ManageServiceController::class, 'destroyService'])->name('destroy-service');

        // Technician Roster Routes
        Route::post('/technicians', [ManageServiceController::class, 'storeTechnician'])->name('store-technician');
        Route::patch('/technicians/{id}/toggle-status', [ManageServiceController::class, 'toggleTechnicianStatus'])->name('toggle-technician-status');

        // Staff Roster Routes
        Route::post('/staff', [ManageServiceController::class, 'storeStaff'])->name('store-staff');
        Route::put('/staff/{id}', [ManageServiceController::class, 'updateStaff'])->name('update-staff');
        Route::delete('/staff/{id}', [ManageServiceController::class, 'destroyStaff'])->name('destroy-staff');
    });

});
<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;  
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\ManageServiceController;
use App\Http\Controllers\Admin\TransactionController;
use App\Http\Controllers\Customer\TrackController;  
use App\Http\Controllers\AdminPasswordResetController;

/*
|--------------------------------------------------------------------------
| TEMPORARY DATABASE SETUP & DEBUG ROUTES
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

Route::get('/debug-db', function () {
    try {
        return response()->json([
            'default_connection'     => config('database.default'),
            'database_name'          => DB::connection()->getDatabaseName(),
            'database_host'          => config('database.connections.' . config('database.default') . '.host'),
            'service_records_count'  => \App\Models\ServiceRecord::count(),
            'service_records_sample' => \App\Models\ServiceRecord::latest()->take(5)->get(),
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'error' => $e->getMessage()
        ], 500);
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
| 2. ADMIN AUTHENTICATION ROUTES (PUBLIC)
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

    // Transactions History, System Reports & PDF Export
    Route::get('/admin/transactions', [TransactionController::class, 'index'])->name('admin.transactions');
    
    // System Report Routes (Mapped to support all client-side route names)
    Route::get('/admin/reports/preview', [TransactionController::class, 'previewReport'])->name('admin.reports.preview');
    Route::get('/admin/transactions/report/preview', [TransactionController::class, 'previewReport'])->name('admin.transactions.reports.preview');
    
    Route::get('/admin/reports/download', [TransactionController::class, 'downloadReport'])->name('admin.reports.download');
    Route::get('/admin/reports/pdf', [TransactionController::class, 'downloadReport'])->name('admin.reports.pdf');
    Route::get('/admin/transactions/report/download', [TransactionController::class, 'downloadReport'])->name('admin.transactions.reports.download');
    
    Route::get('/admin/transactions/{id}/pdf', [TransactionController::class, 'downloadPdf'])->name('admin.transactions.pdf');
    
    // Route for deleting queued customer records on the Update Status page
Route::delete('/admin/update/{id}', [ServiceController::class, 'destroy'])->name('admin.update.destroy');

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

        // Technician Roster Routes & Report PDF Export
        Route::post('/technicians', [ManageServiceController::class, 'storeTechnician'])->name('store-technician');
        Route::patch('/technicians/{id}/toggle-status', [ManageServiceController::class, 'toggleTechnicianStatus'])->name('toggle-technician-status');
        Route::get('/technicians/report/download', [ManageServiceController::class, 'downloadTechnicianReport'])->name('technicians.reports.download');

        // Staff Roster Routes & Report PDF Export
        Route::post('/staff', [ManageServiceController::class, 'storeStaff'])->name('store-staff');
        Route::put('/staff/{id}', [ManageServiceController::class, 'updateStaff'])->name('update-staff');
        Route::patch('/staff/{id}/toggle-status', [ManageServiceController::class, 'toggleStaffStatus'])->name('toggle-staff-status');
        Route::delete('/staff/{id}', [ManageServiceController::class, 'destroyStaff'])->name('destroy-staff');
        Route::get('/staff/report/download', [ManageServiceController::class, 'downloadStaffReport'])->name('staff.reports.download');
    });

});
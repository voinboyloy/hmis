<?php

use App\Http\Controllers\PatientPortalController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Patient Portal Routes
|--------------------------------------------------------------------------
|
| These routes handle the patient portal functionality including
| landing page, login, dashboard, and related features.
|
*/

// Public portal routes
Route::get('/portal/landing', [PatientPortalController::class, 'landing'])->name('portal.landing');
Route::get('/portal/customer', [PatientPortalController::class, 'customerHome'])->name('portal.customer');

// Patient authentication routes
Route::get('/portal/login', [PatientPortalController::class, 'showLogin'])->name('portal.login');
Route::post('/portal/login', [PatientPortalController::class, 'login'])->name('portal.login.submit');
Route::get('/portal/logout', [PatientPortalController::class, 'logout'])->name('portal.logout');

// Protected patient portal routes
Route::middleware(['web'])->group(function () {
    Route::get('/portal/dashboard', [PatientPortalController::class, 'dashboard'])->name('portal.dashboard');
});

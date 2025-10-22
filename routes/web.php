<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PatientPortalController;

Route::get('/', [PatientPortalController::class, 'landing'])->name('home');

Route::prefix('portal')->group(function(){
    Route::get('/login', [PatientPortalController::class, 'showLogin'])->name('portal.login');
    Route::post('/login', [PatientPortalController::class, 'postLogin'])->name('portal.login.post');
    Route::get('/dashboard', [PatientPortalController::class, 'dashboard'])->name('portal.dashboard');
    Route::get('/home', [PatientPortalController::class, 'home'])->name('portal.home');
    Route::post('/logout', [PatientPortalController::class, 'logout'])->name('portal.logout');
    // placeholder for booking route
    Route::get('/book', fn()=> redirect()->route('portal.login'))->name('portal.book');
});

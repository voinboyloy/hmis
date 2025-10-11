<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Models\Appointment;

// --- Public Routes ---
Route::get('/', function () {
    return view('welcome');
});

// --- Patient Portal Routes (Authenticated) ---
Route::get('/dashboard', function () {
    /** @var \App\Models\User $user */
    $user = Auth::user();

    // Check if the user is a patient. If not, redirect to the admin panel.
    if (is_null($user->patient_id)) {
        return redirect('/admin');
    }

    // Find the patient profile linked to this user
    $patient = $user->patient;

    // If the patient profile doesn't exist, abort.
    if (is_null($patient)) {
        abort(404, 'Patient profile not found.');
    }

    // Find the patient's next upcoming appointment
    $nextAppointment = Appointment::where('patient_id', $patient->id)
        ->where('schedule', '>=', now())
        ->orderBy('schedule', 'asc')
        ->first();

    // Return the dashboard view with the patient and appointment data
    return view('dashboard', [
        'patient' => $patient,
        'nextAppointment' => $nextAppointment,
    ]);
})->middleware(['auth', 'verified'])->name('dashboard');


// This loads all the login, registration, and password reset routes
Route::get('/invoices/{record}/print', [App\Http\Controllers\PrintController::class, 'printInvoice'])
    ->name('filament.admin.resources.invoices.print')
    ->middleware(['auth']);

require __DIR__.'/auth.php';

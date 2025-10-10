<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Models\Patient;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Auth\Events\Registered;
use App\Providers\RouteServiceProvider; // <-- Import the Service Provider

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        // This returns the view, which must contain fields for first_name, last_name, date_of_birth, email, and password.
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'date_of_birth' => ['required', 'date'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // 1. Create the Patient record first
        $patient = Patient::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'date_of_birth' => $request->date_of_birth,
            // Simple UID generation: P + 5 digits
            'patient_uid' => 'P' . str_pad(mt_rand(1, 99999), 5, '0', STR_PAD_LEFT),
            'gender' => $request->input('gender', 'Not Specified'), // Added check for optional gender field
        ]);

        // 2. Now create the User record for authentication and link it
        $user = User::create([
            'name' => $request->first_name . ' ' . $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'patient_id' => $patient->id, // Link the user to the patient profile
        ]);

        event(new Registered($user));

        Auth::login($user);

        // Redirect to the HOME constant (e.g., '/dashboard'), which is standard practice
        return redirect(RouteServiceProvider::HOME);
    }
}

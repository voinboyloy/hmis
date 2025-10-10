<?php
namespace Database\Seeders;

use App\Models\User;
use App\Models\Patient; // <-- New import for Patient model
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Carbon; // Import Carbon for date handling

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // 1. NON-PATIENT USERS (Admin, Doctor, Receptionist)
        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@hmis.test',
            'password' => Hash::make('password'),
            'patient_id' => null, // Explicitly null for non-patients
        ]);

        User::factory()->create([
            'name' => 'Dr. Smith',
            'email' => 'doctor@hmis.test',
            'password' => Hash::make('password'),
            'patient_id' => null,
        ]);

        User::factory()->create([
            'name' => 'Receptionist',
            'email' => 'receptionist@hmis.test',
            'password' => Hash::make('password'),
            'patient_id' => null,
        ]);

        // 2. PATIENT USER (Requires a linked Patient record)

        // A. Create the Patient Profile
        $patient = Patient::create([
            'first_name' => 'John',
            'last_name' => 'Doe',
            'date_of_birth' => Carbon::parse('1985-06-15'),
            // Simplified UID generation for seeder
            'patient_uid' => 'P' . str_pad(1, 5, '0', STR_PAD_LEFT),
            'gender' => 'Male',
        ]);

        // B. Create the User Account, linking it to the Patient Profile
        User::factory()->create([
            'name' => $patient->first_name . ' ' . $patient->last_name,
            'email' => 'patient@hmis.test',
            'password' => Hash::make('password'),
            'patient_id' => $patient->id, // <-- CRITICAL: Link to the new Patient ID
        ]);

        // 3. ASSIGN ROLES (Assumes spatie/laravel-permission is used)
        User::where('email', 'admin@hmis.test')->first()->assignRole('Admin');
        User::where('email', 'doctor@hmis.test')->first()->assignRole('Doctor');
        User::where('email', 'receptionist@hmis.test')->first()->assignRole('Receptionist');

        // Assigning a Patient role (if applicable)
        User::where('email', 'patient@hmis.test')->first()->assignRole('Patient');
    }
}

<?php

namespace Database\Seeders;

use App\Models\Appointment;
use App\Models\Encounter;
use App\Models\Invoice;
use App\Models\LabOrder;
use App\Models\Medication;
use App\Models\Patient;
use App\Models\Prescription;
use App\Models\Service;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Disable foreign key checks to allow truncating tables
        Schema::disableForeignKeyConstraints();

        // 2. Call all the seeders that create your base data first
        $this->call([
            RolesAndPermissionsSeeder::class,
            UserSeeder::class,
            LabTestSeeder::class,
            ServiceSeeder::class,
            MedicationSeeder::class,
        ]);
        $staffUsers = User::whereNull('patient_id')->get();

        foreach ($staffUsers as $user) {
            $jobTitle = $user->getRoleNames()->first() ?? 'Staff';
            $department = match($jobTitle) {
                'Doctor' => 'General Medicine',
                'Lab Technician' => 'Laboratory',
                'Receptionist', 'Admin' => 'Administration',
                default => 'General',
            };

    \App\Models\StaffProfile::factory()->create([
        'user_id' => $user->id,
        'job_title' => $jobTitle,
        'department' => $department,
    ]);
}
        // 3. Get the records you just created to use in relationships
        $doctor = User::where('email', 'doctor@hmis.test')->first();
        $consultation = Service::where('name', 'Doctor Consultation')->first();
        $medication = Medication::first();

        // 4. Now, create Patients and their full history
        Patient::factory(50)->create()->each(function (Patient $patient) use ($doctor, $consultation, $medication) {

            // Create 1 to 5 appointments for the patient
            $appointments = Appointment::factory(rand(1, 5))->create([
                'patient_id' => $patient->id,
                'user_id' => $doctor->id,
            ]);

            // For the most recent appointment, create an encounter
            $latestAppointment = $appointments->last();
            $encounter = Encounter::factory()->create([
                'patient_id' => $patient->id,
                'appointment_id' => $latestAppointment->id,
            ]);

            // For that encounter, create a prescription
            if (rand(0, 1)) { // 50% chance
                Prescription::factory()->create([
                    'encounter_id' => $encounter->id,
                    'medication_id' => $medication->id,
                ]);
            }

            // For that encounter, create a lab order
            if (rand(0, 1)) { // 50% chance
                LabOrder::factory()->create([
                    'patient_id' => $patient->id,
                    'encounter_id' => $encounter->id,
                ]);
            }

            // For that encounter, generate an invoice
            $total = $consultation->price + ($encounter->prescriptions->sum('medication.price') ?? 0);
            Invoice::factory()->create([
                'patient_id' => $patient->id,
                'encounter_id' => $encounter->id,
                'total_amount' => $total,
                'paid_amount' => rand(0, 1) ? $total : 0, // 50% chance of being paid
                'status' => fn (array $attributes) => ($attributes['paid_amount'] == 0) ? 'Unpaid' : 'Paid',
            ]);
        });

        // 5. Re-enable foreign key checks
        Schema::enableForeignKeyConstraints();
    }
}

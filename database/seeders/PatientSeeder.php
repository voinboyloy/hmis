<?php
namespace Database\Seeders;

use App\Models\User;
use App\Models\Patient;
use App\Models\Appointment;
use Illuminate\Database\Seeder;

class PatientSeeder extends Seeder
{
    public function run(): void
    {
        $doctor = User::where('email', 'doctor@hmis.test')->first();

        // Create 50 patients
        Patient::factory(50)->create()->each(function ($patient) use ($doctor) {
            // For each patient, create 1 to 5 appointments
            $patient->appointments()->createMany(
                Appointment::factory(rand(1, 5))->make([
                    'user_id' => $doctor->id,
                ])->toArray()
            );
        });
    }
}

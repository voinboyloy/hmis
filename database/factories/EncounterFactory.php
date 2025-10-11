<?php

namespace Database\Factories;

use App\Models\Appointment;
use App\Models\IcdCode;
use App\Models\Patient;
use Illuminate\Database\Eloquent\Factories\Factory;

class EncounterFactory extends Factory
{
    public function definition(): array
    {
        return [
            'patient_id' => Patient::factory(),
            'appointment_id' => Appointment::factory(),            'vitals' => [
                'blood_pressure' => fake()->numberBetween(100, 140) . '/' . fake()->numberBetween(60, 90),
                'temperature' => fake()->randomFloat(1, 36.5, 37.5),
                'heart_rate' => fake()->numberBetween(60, 100),
            ],
            'notes' => fake()->paragraph(),
            'icd_code_id' => IcdCode::inRandomOrder()->first()->id,
        ];
    }
}

<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class AppointmentFactory extends Factory
{
    public function definition(): array
    {
        return [
            // Note: We don't need patient_id or user_id here
            // because they will be provided by the seeder.
            'schedule' => fake()->dateTimeBetween('now', '+1 month'),
            'reason' => fake()->sentence(),
            'status' => fake()->randomElement(['Scheduled', 'Confirmed', 'Completed']),
        ];
    }
}

<?php

namespace Database\Factories;

use App\Models\Service;
use Illuminate\Database\Eloquent\Factories\Factory;

class AppointmentFactory extends Factory
{
    public function definition(): array
    {
        return [
            // Note: We don't need patient_id or user_id here
            // because they will be provided by the seeder.
            'service_id' => Service::inRandomOrder()->first()->id,
            'schedule' => fake()->dateTimeBetween('now', '+1 month'),
            'reason' => fake()->sentence(),
            'status' => fake()->randomElement(['Scheduled', 'Confirmed', 'Completed']),
        ];
    }
}

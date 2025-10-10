<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PrescriptionFactory extends Factory
{
    public function definition(): array
    {
        return [
            'dosage' => fake()->randomElement(['1 tablet', '2 tablets', '10ml']),
            'frequency' => fake()->randomElement(['Once a day', 'Twice a day', 'Every 6 hours']),
            'duration' => fake()->randomElement(['7 days', '14 days', '30 days']),
            'notes' => fake()->sentence(),
        ];
    }
}

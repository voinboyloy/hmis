<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class StaffProfileFactory extends Factory
{
    public function definition(): array
    {
        return [
            'phone_number' => fake()->phoneNumber(),
            'address' => fake()->address(),
            'date_of_birth' => fake()->dateTimeBetween('-60 years', '-22 years')->format('Y-m-d'),
        ];
    }
}

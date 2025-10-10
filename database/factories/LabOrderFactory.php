<?php

namespace Database\Factories;

use App\Models\LabTest;
use Illuminate\Database\Eloquent\Factories\Factory;

class LabOrderFactory extends Factory
{
    public function definition(): array
    {
        return [
            // Get one or two random lab tests to order
            'tests_ordered' => LabTest::inRandomOrder()->limit(rand(1, 2))->pluck('id')->toArray(),
            'status' => 'Pending',
        ];
    }
}

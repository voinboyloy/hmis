<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\LabTest;

class LabTestSeeder extends Seeder
{
    public function run(): void
    {
        LabTest::truncate();

        $labTests = [
            ['name' => 'Complete Blood Count (CBC)', 'category' => 'Hematology', 'price' => 25.00],
            ['name' => 'Lipid Panel', 'category' => 'Chemistry', 'price' => 40.00],
            ['name' => 'Basic Metabolic Panel (BMP)', 'category' => 'Chemistry', 'price' => 30.00],
            ['name' => 'Thyroid-Stimulating Hormone (TSH)', 'category' => 'Endocrinology', 'price' => 35.00],
            ['name' => 'Urinalysis', 'category' => 'Microbiology', 'price' => 20.00],
            ['name' => 'Chest X-Ray', 'category' => 'Radiology', 'price' => 75.00],
            ['name' => 'Abdominal Ultrasound', 'category' => 'Radiology', 'price' => 150.00],
            ['name' => 'Hemoglobin A1c', 'category' => 'Endocrinology', 'price' => 45.00],
        ];

        foreach ($labTests as $test) {
            LabTest::create($test);
        }
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Medication;

class MedicationSeeder extends Seeder
{
    public function run(): void
    {
        Medication::truncate();

        $medications = [
            ['name' => 'Paracetamol 500mg', 'brand' => 'Generic', 'price' => 5.00],
            ['name' => 'Amoxicillin 250mg', 'brand' => 'Generic', 'price' => 12.50],
            ['name' => 'Ibuprofen 200mg', 'brand' => 'Advil', 'price' => 8.00],
            ['name' => 'Loratadine 10mg', 'brand' => 'Claritin', 'price' => 15.00],
            ['name' => 'Omeprazole 20mg', 'brand' => 'Prilosec', 'price' => 18.00],
            ['name' => 'Metformin 500mg', 'brand' => 'Glucophage', 'price' => 22.00],
            ['name' => 'Salbutamol Inhaler', 'brand' => 'Ventolin', 'price' => 30.00],
        ];

        foreach ($medications as $medication) {
            Medication::create($medication);
        }
    }
}

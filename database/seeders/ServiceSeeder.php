<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Service;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        Service::truncate();

        $services = [
            ['name' => 'Doctor Consultation', 'price' => 50.00],
            ['name' => 'Follow-up Visit', 'price' => 30.00],
            ['name' => 'Specialist Consultation', 'price' => 80.00],
            ['name' => 'Emergency Visit', 'price' => 100.00],
            ['name' => 'Standard Vaccination', 'price' => 25.00],
            ['name' => 'Wound Dressing', 'price' => 15.00],
        ];

        foreach ($services as $service) {
            Service::create($service);
        }
    }
}

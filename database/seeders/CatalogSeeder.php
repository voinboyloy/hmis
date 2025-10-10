<?php
namespace Database\Seeders;

use App\Models\Medication;
use App\Models\Service;
use App\Models\LabTest;
use Illuminate\Database\Seeder;

class CatalogSeeder extends Seeder
{
    public function run(): void
    {
        Service::create(['name' => 'Doctor Consultation', 'price' => 50.00]);
        Medication::create(['name' => 'Paracetamol', 'brand' => 'Generic', 'price' => 5.00]);
        LabTest::create(['name' => 'Complete Blood Count', 'category' => 'Hematology', 'price' => 25.00]);
    }
}

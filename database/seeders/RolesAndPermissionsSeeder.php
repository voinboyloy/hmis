<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
        Permission::create(['name' => 'manage patients']);
        Permission::create(['name' => 'manage appointments']);
        Permission::create(['name' => 'manage encounters']);
        Permission::create(['name' => 'manage lab orders']);
        Permission::create(['name' => 'manage billing']);
        Permission::create(['name' => 'delete patients']);
        Role::create(['name' => 'Patient']);
        // Create roles and assign permissions
        $receptionist = Role::create(['name' => 'Receptionist']);
        $receptionist->givePermissionTo(['manage patients', 'manage appointments']);

        $doctor = Role::create(['name' => 'Doctor']);
        $doctor->givePermissionTo(['manage patients', 'manage encounters', 'manage lab orders']);

        $admin = Role::create(['name' => 'Admin']);
        $admin->givePermissionTo(Permission::all());
    }
}

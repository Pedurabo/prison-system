<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            DepartmentSeeder::class,
            UserSeeder::class,
            StaffSeeder::class,
            InmateSeeder::class,
            SecurityIncidentSeeder::class,
            MedicalRecordSeeder::class,
            RehabilitationProgramSeeder::class,
            FoodServiceSeeder::class,
            MaintenanceRequestSeeder::class,
            VisitSeeder::class,
        ]);
    }
}

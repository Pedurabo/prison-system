<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Department;
use Carbon\Carbon;

class DepartmentSeeder extends Seeder
{
    public function run()
    {
        $departments = [
            [
                'name' => 'Security Department',
                'description' => 'Responsible for maintaining order, preventing escapes, and ensuring the safety of both inmates and staff. Includes custody, control, and intelligence operations.',
                'budget' => 2500000.00,
                'status' => 'active',
                'established_date' => Carbon::create(2010, 1, 1),
            ],
            [
                'name' => 'Inmate Management Department',
                'description' => 'Handles inmate intake, classification, record-keeping, and release processes. Manages specialized units for high-risk and vulnerable inmates.',
                'budget' => 1800000.00,
                'status' => 'active',
                'established_date' => Carbon::create(2010, 1, 1),
            ],
            [
                'name' => 'Medical Services Department',
                'description' => 'Provides comprehensive healthcare to inmates including primary care, mental health services, and emergency medical response.',
                'budget' => 3200000.00,
                'status' => 'active',
                'established_date' => Carbon::create(2010, 1, 1),
            ],
            [
                'name' => 'Administration Department',
                'description' => 'Handles overall management of the prison including finances, human resources, logistics, and operational oversight.',
                'budget' => 1500000.00,
                'status' => 'active',
                'established_date' => Carbon::create(2010, 1, 1),
            ],
            [
                'name' => 'Rehabilitation Programs Department',
                'description' => 'Offers programs aimed at reducing recidivism including substance abuse treatment, educational courses, and vocational training.',
                'budget' => 950000.00,
                'status' => 'active',
                'established_date' => Carbon::create(2012, 3, 15),
            ],
            [
                'name' => 'Food Services Department',
                'description' => 'Responsible for meal planning, preparation, and distribution to inmates and staff. Manages dietary requirements and food safety.',
                'budget' => 800000.00,
                'status' => 'active',
                'established_date' => Carbon::create(2010, 1, 1),
            ],
            [
                'name' => 'Maintenance Department',
                'description' => 'Handles the upkeep and repair of the prison\'s physical infrastructure including buildings, utilities, and security systems.',
                'budget' => 650000.00,
                'status' => 'active',
                'established_date' => Carbon::create(2010, 1, 1),
            ],
            [
                'name' => 'Laundry Services Department',
                'description' => 'Manages laundry services for inmates and staff including cleaning, maintenance of linens, and uniform distribution.',
                'budget' => 200000.00,
                'status' => 'active',
                'established_date' => Carbon::create(2010, 6, 1),
            ],
            [
                'name' => 'Chaplaincy Department',
                'description' => 'Provides religious and spiritual support to inmates of various faiths. Offers counseling, ceremonies, and faith-based programs.',
                'budget' => 150000.00,
                'status' => 'active',
                'established_date' => Carbon::create(2011, 9, 1),
            ],
        ];

        foreach ($departments as $department) {
            Department::create($department);
        }
    }
}

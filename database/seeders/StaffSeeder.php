<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Staff;
use App\Models\Department;

class StaffSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $departments = Department::pluck('id')->toArray();

        if (empty($departments)) {
            $this->command->info('Skipping StaffSeeder: No departments found.');
            return;
        }

        $staff = [
            [
                'first_name' => 'John',
                'last_name' => 'Smith',
                'position' => 'Senior Guard',
                'department_id' => $departments[array_rand($departments)],
                'employee_id' => 'EMP001',
                'phone' => '+1234567890',
                'email' => 'john.smith@prison.gov',
                'hire_date' => now()->subYears(5),
                'salary' => 45000.00,
                'status' => 'active',
                'address' => '123 Main Street, City, State 12345',
                'emergency_contact' => '+1234567890',
                'security_clearance' => 'high',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'first_name' => 'Sarah',
                'last_name' => 'Johnson',
                'position' => 'Medical Officer',
                'department_id' => $departments[array_rand($departments)],
                'employee_id' => 'EMP002',
                'phone' => '+1234567891',
                'email' => 'sarah.johnson@prison.gov',
                'hire_date' => now()->subYears(3),
                'salary' => 55000.00,
                'status' => 'active',
                'address' => '456 Oak Avenue, City, State 12345',
                'emergency_contact' => '+1234567891',
                'security_clearance' => 'medium',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'first_name' => 'Michael',
                'last_name' => 'Brown',
                'position' => 'Rehabilitation Counselor',
                'department_id' => $departments[array_rand($departments)],
                'employee_id' => 'EMP003',
                'phone' => '+1234567892',
                'email' => 'michael.brown@prison.gov',
                'hire_date' => now()->subYears(2),
                'salary' => 48000.00,
                'status' => 'active',
                'address' => '789 Pine Street, City, State 12345',
                'emergency_contact' => '+1234567892',
                'security_clearance' => 'medium',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'first_name' => 'Emily',
                'last_name' => 'Davis',
                'position' => 'Night Guard',
                'department_id' => $departments[array_rand($departments)],
                'employee_id' => 'EMP004',
                'phone' => '+1234567893',
                'email' => 'emily.davis@prison.gov',
                'hire_date' => now()->subYears(4),
                'salary' => 42000.00,
                'status' => 'active',
                'address' => '321 Elm Street, City, State 12345',
                'emergency_contact' => '+1234567893',
                'security_clearance' => 'high',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'first_name' => 'David',
                'last_name' => 'Wilson',
                'position' => 'Maintenance Supervisor',
                'department_id' => $departments[array_rand($departments)],
                'employee_id' => 'EMP005',
                'phone' => '+1234567894',
                'email' => 'david.wilson@prison.gov',
                'hire_date' => now()->subYears(6),
                'salary' => 52000.00,
                'status' => 'active',
                'address' => '654 Maple Avenue, City, State 12345',
                'emergency_contact' => '+1234567894',
                'security_clearance' => 'medium',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'first_name' => 'Lisa',
                'last_name' => 'Anderson',
                'position' => 'Food Service Manager',
                'department_id' => $departments[array_rand($departments)],
                'employee_id' => 'EMP006',
                'phone' => '+1234567895',
                'email' => 'lisa.anderson@prison.gov',
                'hire_date' => now()->subYears(3),
                'salary' => 46000.00,
                'status' => 'active',
                'address' => '987 Cedar Lane, City, State 12345',
                'emergency_contact' => '+1234567895',
                'security_clearance' => 'low',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'first_name' => 'Robert',
                'last_name' => 'Taylor',
                'position' => 'Security Officer',
                'department_id' => $departments[array_rand($departments)],
                'employee_id' => 'EMP007',
                'phone' => '+1234567896',
                'email' => 'robert.taylor@prison.gov',
                'hire_date' => now()->subYears(2),
                'salary' => 44000.00,
                'status' => 'active',
                'address' => '147 Birch Road, City, State 12345',
                'emergency_contact' => '+1234567896',
                'security_clearance' => 'high',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'first_name' => 'Jennifer',
                'last_name' => 'Martinez',
                'position' => 'Administrative Assistant',
                'department_id' => $departments[array_rand($departments)],
                'employee_id' => 'EMP008',
                'phone' => '+1234567897',
                'email' => 'jennifer.martinez@prison.gov',
                'hire_date' => now()->subYears(1),
                'salary' => 38000.00,
                'status' => 'active',
                'address' => '258 Spruce Street, City, State 12345',
                'emergency_contact' => '+1234567897',
                'security_clearance' => 'low',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($staff as $staffMember) {
            Staff::create($staffMember);
        }
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Department;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin user
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@prison.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'is_active' => true,
        ]);

        // Get departments for guard assignments
        $departments = Department::all();

        if ($departments->count() > 0) {
            // Create guard users
            $guardData = [
                [
                    'name' => 'John Smith',
                    'email' => 'john.smith@prison.com',
                    'department_id' => $departments->first()->id,
                ],
                [
                    'name' => 'Jane Doe',
                    'email' => 'jane.doe@prison.com',
                    'department_id' => $departments->first()->id,
                ],
                [
                    'name' => 'Mike Johnson',
                    'email' => 'mike.johnson@prison.com',
                    'department_id' => $departments->count() > 1 ? $departments->get(1)->id : $departments->first()->id,
                ],
                [
                    'name' => 'Sarah Wilson',
                    'email' => 'sarah.wilson@prison.com',
                    'department_id' => $departments->count() > 1 ? $departments->get(1)->id : $departments->first()->id,
                ],
                [
                    'name' => 'David Brown',
                    'email' => 'david.brown@prison.com',
                    'department_id' => $departments->count() > 2 ? $departments->get(2)->id : $departments->first()->id,
                ],
            ];

            foreach ($guardData as $guard) {
                User::create([
                    'name' => $guard['name'],
                    'email' => $guard['email'],
                    'password' => Hash::make('password'),
                    'role' => 'guard',
                    'department_id' => $guard['department_id'],
                    'is_active' => true,
                ]);
            }
        }
    }
}

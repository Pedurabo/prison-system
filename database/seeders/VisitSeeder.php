<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Visit;
use App\Models\Inmate;
use App\Models\Staff;

class VisitSeeder extends Seeder
{
    public function run(): void
    {
        $inmates = Inmate::pluck('id')->toArray();
        $staff = Staff::pluck('id')->toArray();

        // If no inmates or staff exist, skip seeding visits
        if (empty($inmates) || empty($staff)) {
            $this->command->info('Skipping VisitSeeder: No inmates or staff found.');
            return;
        }

        $visits = [
            [
                'inmate_id' => $inmates[array_rand($inmates)],
                'visitor_name' => 'John Smith',
                'visitor_relationship' => 'Father',
                'visitor_id_number' => 'ID123456789',
                'visitor_phone' => '+1234567890',
                'visit_date' => now()->addDays(2),
                'visit_time' => now()->addDays(2)->setTime(14, 0),
                'duration_minutes' => 60,
                'visit_type' => 'family',
                'status' => 'pending',
                'approved_by_staff_id' => null,
                'visitor_address' => '123 Main Street, City, State 12345',
                'notes' => 'Regular family visit',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'inmate_id' => $inmates[array_rand($inmates)],
                'visitor_name' => 'Sarah Johnson',
                'visitor_relationship' => 'Sister',
                'visitor_id_number' => 'ID987654321',
                'visitor_phone' => '+1987654321',
                'visit_date' => now()->addDays(1),
                'visit_time' => now()->addDays(1)->setTime(10, 30),
                'duration_minutes' => 45,
                'visit_type' => 'family',
                'status' => 'approved',
                'approved_by_staff_id' => $staff[array_rand($staff)],
                'visitor_address' => '456 Oak Avenue, City, State 12345',
                'notes' => 'Approved family visit',
                'created_at' => now()->subDays(1),
                'updated_at' => now()->subDays(1),
            ],
            [
                'inmate_id' => $inmates[array_rand($inmates)],
                'visitor_name' => 'Attorney Michael Brown',
                'visitor_relationship' => 'Legal Counsel',
                'visitor_id_number' => 'LAW123456',
                'visitor_phone' => '+1555123456',
                'visit_date' => now()->addDays(3),
                'visit_time' => now()->addDays(3)->setTime(15, 0),
                'duration_minutes' => 90,
                'visit_type' => 'legal',
                'status' => 'pending',
                'approved_by_staff_id' => null,
                'visitor_address' => '789 Legal Building, City, State 12345',
                'notes' => 'Legal consultation visit',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'inmate_id' => $inmates[array_rand($inmates)],
                'visitor_name' => 'Dr. Emily Wilson',
                'visitor_relationship' => 'Medical Professional',
                'visitor_id_number' => 'MED789012',
                'visitor_phone' => '+1555987654',
                'visit_date' => now()->addDays(5),
                'visit_time' => now()->addDays(5)->setTime(11, 0),
                'duration_minutes' => 30,
                'visit_type' => 'official',
                'status' => 'approved',
                'approved_by_staff_id' => $staff[array_rand($staff)],
                'visitor_address' => '321 Medical Center, City, State 12345',
                'notes' => 'Medical consultation',
                'created_at' => now()->subDays(2),
                'updated_at' => now()->subDays(2),
            ],
            [
                'inmate_id' => $inmates[array_rand($inmates)],
                'visitor_name' => 'Pastor David Miller',
                'visitor_relationship' => 'Religious Counselor',
                'visitor_id_number' => 'REL456789',
                'visitor_phone' => '+1555456789',
                'visit_date' => now()->addDays(7),
                'visit_time' => now()->addDays(7)->setTime(16, 30),
                'duration_minutes' => 60,
                'visit_type' => 'religious',
                'status' => 'pending',
                'approved_by_staff_id' => null,
                'visitor_address' => '654 Church Street, City, State 12345',
                'notes' => 'Spiritual counseling session',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($visits as $visit) {
            Visit::create($visit);
        }
    }
}

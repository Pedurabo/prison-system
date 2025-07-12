<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\RehabilitationProgram;
use App\Models\Staff;
use Carbon\Carbon;

class RehabilitationProgramSeeder extends Seeder
{
    public function run()
    {
        // Get staff members for instructors
        $staff = Staff::active()->get();

        if ($staff->isEmpty()) {
            $this->command->info('No active staff found. Please run StaffSeeder first.');
            return;
        }

        $programs = [
            [
                'program_name' => 'Substance Abuse Recovery Program',
                'program_type' => 'substance_abuse',
                'description' => 'Comprehensive treatment program for inmates struggling with substance abuse. Includes individual counseling, group therapy, and relapse prevention strategies.',
                'instructor_staff_id' => $staff->random()->id,
                'capacity' => 20,
                'duration_weeks' => 12,
                'start_date' => Carbon::now()->addDays(7),
                'end_date' => Carbon::now()->addDays(7)->addWeeks(12),
                'status' => 'planned',
                'cost' => 1500.00,
                'location' => 'Education Building - Room 101',
                'prerequisites' => 'Must be willing to participate in group sessions and individual counseling.',
                'certificate_provided' => true,
            ],
            [
                'program_name' => 'High School Equivalency Program',
                'program_type' => 'education',
                'description' => 'GED preparation program offering courses in mathematics, science, social studies, and language arts. Prepares inmates for successful completion of high school equivalency exam.',
                'instructor_staff_id' => $staff->random()->id,
                'capacity' => 25,
                'duration_weeks' => 16,
                'start_date' => Carbon::now()->addDays(14),
                'end_date' => Carbon::now()->addDays(14)->addWeeks(16),
                'status' => 'planned',
                'cost' => 800.00,
                'location' => 'Education Building - Room 102',
                'prerequisites' => 'Basic reading and writing skills required.',
                'certificate_provided' => true,
            ],
            [
                'program_name' => 'Carpentry Skills Training',
                'program_type' => 'vocational_training',
                'description' => 'Hands-on training in carpentry skills including woodworking, furniture making, and basic construction techniques. Provides practical skills for employment after release.',
                'instructor_staff_id' => $staff->random()->id,
                'capacity' => 15,
                'duration_weeks' => 8,
                'start_date' => Carbon::now()->addDays(21),
                'end_date' => Carbon::now()->addDays(21)->addWeeks(8),
                'status' => 'planned',
                'cost' => 2000.00,
                'location' => 'Vocational Training Center - Workshop A',
                'prerequisites' => 'No prior experience required. Must be physically capable of manual labor.',
                'certificate_provided' => true,
            ],
            [
                'program_name' => 'Anger Management Workshop',
                'program_type' => 'anger_management',
                'description' => 'Intensive workshop focused on identifying triggers, developing coping mechanisms, and learning conflict resolution skills. Includes role-playing and group discussions.',
                'instructor_staff_id' => $staff->random()->id,
                'capacity' => 12,
                'duration_weeks' => 6,
                'start_date' => Carbon::now()->addDays(5),
                'end_date' => Carbon::now()->addDays(5)->addWeeks(6),
                'status' => 'active',
                'cost' => 600.00,
                'location' => 'Counseling Center - Group Room 1',
                'prerequisites' => 'Must be willing to participate in group discussions and self-reflection.',
                'certificate_provided' => false,
            ],
            [
                'program_name' => 'Life Skills Development',
                'program_type' => 'life_skills',
                'description' => 'Comprehensive program covering essential life skills including financial literacy, job search techniques, communication skills, and personal responsibility.',
                'instructor_staff_id' => $staff->random()->id,
                'capacity' => 18,
                'duration_weeks' => 10,
                'start_date' => Carbon::now()->addDays(10),
                'end_date' => Carbon::now()->addDays(10)->addWeeks(10),
                'status' => 'active',
                'cost' => 900.00,
                'location' => 'Education Building - Room 103',
                'prerequisites' => 'Open to all inmates regardless of educational background.',
                'certificate_provided' => true,
            ],
            [
                'program_name' => 'Computer Literacy Program',
                'program_type' => 'education',
                'description' => 'Basic computer skills training including Microsoft Office, internet safety, and digital communication. Prepares inmates for modern workplace requirements.',
                'instructor_staff_id' => $staff->random()->id,
                'capacity' => 20,
                'duration_weeks' => 8,
                'start_date' => Carbon::now()->addDays(3),
                'end_date' => Carbon::now()->addDays(3)->addWeeks(8),
                'status' => 'active',
                'cost' => 1200.00,
                'location' => 'Computer Lab - Room 201',
                'prerequisites' => 'No prior computer experience required.',
                'certificate_provided' => true,
            ],
            [
                'program_name' => 'Welding Certification Program',
                'program_type' => 'vocational_training',
                'description' => 'Professional welding training program leading to industry-recognized certification. Covers various welding techniques and safety protocols.',
                'instructor_staff_id' => $staff->random()->id,
                'capacity' => 10,
                'duration_weeks' => 12,
                'start_date' => Carbon::now()->addDays(30),
                'end_date' => Carbon::now()->addDays(30)->addWeeks(12),
                'status' => 'planned',
                'cost' => 3500.00,
                'location' => 'Vocational Training Center - Welding Shop',
                'prerequisites' => 'Must pass safety assessment and demonstrate physical capability.',
                'certificate_provided' => true,
            ],
            [
                'program_name' => 'Conflict Resolution Skills',
                'program_type' => 'life_skills',
                'description' => 'Workshop focused on developing effective communication and conflict resolution skills. Uses real-world scenarios and interactive exercises.',
                'instructor_staff_id' => $staff->random()->id,
                'capacity' => 15,
                'duration_weeks' => 4,
                'start_date' => Carbon::now()->addDays(2),
                'end_date' => Carbon::now()->addDays(2)->addWeeks(4),
                'status' => 'active',
                'cost' => 400.00,
                'location' => 'Counseling Center - Group Room 2',
                'prerequisites' => 'Open to all inmates. No prerequisites required.',
                'certificate_provided' => false,
            ],
            [
                'program_name' => 'Culinary Arts Training',
                'program_type' => 'vocational_training',
                'description' => 'Professional culinary training program covering food safety, kitchen management, and various cooking techniques. Prepares inmates for careers in food service.',
                'instructor_staff_id' => $staff->random()->id,
                'capacity' => 12,
                'duration_weeks' => 10,
                'start_date' => Carbon::now()->addDays(25),
                'end_date' => Carbon::now()->addDays(25)->addWeeks(10),
                'status' => 'planned',
                'cost' => 2500.00,
                'location' => 'Kitchen Training Facility',
                'prerequisites' => 'Must pass food safety assessment and demonstrate kitchen safety awareness.',
                'certificate_provided' => true,
            ],
            [
                'program_name' => 'Parenting Skills Program',
                'program_type' => 'life_skills',
                'description' => 'Program designed to help inmates develop positive parenting skills and maintain healthy relationships with their children during and after incarceration.',
                'instructor_staff_id' => $staff->random()->id,
                'capacity' => 16,
                'duration_weeks' => 8,
                'start_date' => Carbon::now()->addDays(15),
                'end_date' => Carbon::now()->addDays(15)->addWeeks(8),
                'status' => 'planned',
                'cost' => 700.00,
                'location' => 'Family Services Center - Room 1',
                'prerequisites' => 'Open to inmates with children or planning to have children.',
                'certificate_provided' => false,
            ],
        ];

        foreach ($programs as $program) {
            RehabilitationProgram::create($program);
        }

        $this->command->info('Rehabilitation programs seeded successfully!');
    }
}

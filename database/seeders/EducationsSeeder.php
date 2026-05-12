<?php

namespace Database\Seeders;

use App\Models\Education;
use Illuminate\Database\Seeder;

class EducationsSeeder extends Seeder
{
    public function run(): void
    {
        $educations = [
            [
                'institution' => 'Google Developer Certification',
                'degree' => 'Advanced Flutter Development',
                'field' => 'Mobile Development',
                'start_date' => '2022-01-01',
                'end_date' => null,
                'is_current' => true,
                'description' => 'Specialized in advanced Flutter techniques, animations, custom render objects, and platform-channels integration.',
                'display_order' => 1,
            ],
            [
                'institution' => 'Tech University',
                'degree' => "Bachelor's Degree in Computer Science",
                'field' => 'Mobile Development & Computer Science',
                'start_date' => '2014-09-01',
                'end_date' => '2018-06-30',
                'is_current' => false,
                'description' => 'Foundation in algorithms, software engineering, mobile development, and computer-science fundamentals.',
                'display_order' => 2,
            ],
            [
                'institution' => 'Design Institute',
                'degree' => 'UI/UX Design Certification',
                'field' => 'Mobile UI/UX Design',
                'start_date' => '2019-01-01',
                'end_date' => '2019-06-30',
                'is_current' => false,
                'description' => 'Mastered mobile-first UI/UX design principles, Material Design, prototyping, and user-research methodology.',
                'display_order' => 3,
            ],
            [
                'institution' => 'Online Coding Academy',
                'degree' => 'Mobile Development Bootcamp',
                'field' => 'Dart Programming Language',
                'start_date' => '2018-07-01',
                'end_date' => '2018-12-31',
                'is_current' => false,
                'description' => 'Intensive bootcamp on Dart, Flutter framework basics, and modern mobile-app architecture patterns.',
                'display_order' => 4,
            ],
        ];

        foreach ($educations as $e) {
            Education::updateOrCreate(
                ['institution' => $e['institution'], 'degree' => $e['degree']],
                $e
            );
        }
    }
}

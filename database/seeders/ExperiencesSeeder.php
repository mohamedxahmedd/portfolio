<?php

namespace Database\Seeders;

use App\Models\Experience;
use Illuminate\Database\Seeder;

class ExperiencesSeeder extends Seeder
{
    public function run(): void
    {
        $experiences = [
            [
                'job_title' => 'Senior Flutter Developer',
                'company' => 'TechFlow Solutions',
                'location' => 'Remote',
                'start_date' => '2022-01-01',
                'end_date' => null,
                'is_current' => true,
                'description' => 'Leading Flutter app development for cross-platform mobile applications. Architected scalable BLoC patterns, integrated Firebase services, and mentored junior developers.',
                'display_order' => 1,
            ],
            [
                'job_title' => 'Mobile App Developer',
                'company' => 'AppVenture Studio',
                'location' => 'Cairo, Egypt',
                'start_date' => '2020-06-01',
                'end_date' => '2021-12-31',
                'is_current' => false,
                'description' => 'Developed production Flutter apps for fitness, e-commerce, and social-media clients. Implemented complex animations and real-time data synchronization.',
                'display_order' => 2,
            ],
            [
                'job_title' => 'Flutter Developer',
                'company' => 'Digital Innovations Ltd',
                'location' => 'Cairo, Egypt',
                'start_date' => '2019-03-01',
                'end_date' => '2020-05-31',
                'is_current' => false,
                'description' => 'Built mobile applications using Flutter for clients across the Middle East. Focused on UI/UX implementation, REST API integration, and Play Store deployments.',
                'display_order' => 3,
            ],
            [
                'job_title' => 'Junior Flutter Developer',
                'company' => 'StartUp Mobile Labs',
                'location' => 'Cairo, Egypt',
                'start_date' => '2018-08-01',
                'end_date' => '2019-02-28',
                'is_current' => false,
                'description' => 'Started professional Flutter development. Learned modern mobile-app architecture, contributed to client projects, and built foundational skills with state management.',
                'display_order' => 4,
            ],
        ];

        foreach ($experiences as $e) {
            Experience::updateOrCreate(
                ['company' => $e['company'], 'job_title' => $e['job_title']],
                $e
            );
        }
    }
}

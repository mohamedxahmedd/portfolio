<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\Technology;
use Illuminate\Database\Seeder;

class ProjectsSeeder extends Seeder
{
    public function run(): void
    {
        $projects = [
            [
                'data' => [
                    'slug' => 'saas-website-design',
                    'title' => 'SAAS Website Design',
                    'subtitle' => 'Comprehensive SAAS Platform',
                    'description' => 'A comprehensive SAAS platform with subscription management, real-time analytics, and a multi-tenant architecture.',
                    'body' => "A full-featured SAAS platform built end-to-end with Flutter for the front-end and Firebase for the back-end. Includes subscription management, real-time analytics dashboards, and a multi-tenant architecture supporting hundreds of organizations.",
                    'problem' => 'Clients needed a unified way to manage subscriptions across iOS and Android with real-time analytics.',
                    'solution' => 'Built a Flutter codebase with shared architecture that handles authentication, subscription state, and live data sync via Firestore.',
                    'features' => ['User authentication', 'Real-time data sync', 'Responsive design', 'Dark/light mode', 'Subscription management', 'Multi-tenant architecture'],
                    'year' => 2024,
                    'role' => 'Senior Flutter Developer',
                    'duration' => '3 months',
                    'platform' => 'iOS & Android',
                    'is_featured' => true,
                    'is_published' => true,
                    'display_order' => 1,
                    'app_store_url' => null,
                    'play_store_url' => null,
                    'github_url' => null,
                ],
                'technologies' => ['flutter', 'dart', 'firebase', 'rest-api', 'provider'],
            ],
            [
                'data' => [
                    'slug' => 'workout-app-design',
                    'title' => 'Workout App Design',
                    'subtitle' => 'Fitness Tracking Application',
                    'description' => 'A fitness-tracking application with custom workout plans, progress analytics, and social-sharing features.',
                    'body' => "A complete fitness companion built with Flutter — track workouts, follow custom exercise plans, and watch progress with detailed analytics. Includes social sharing, daily reminders, and personal-records tracking.",
                    'problem' => 'Existing fitness apps were either too complex or lacked custom plan creation.',
                    'solution' => 'A clean, focused Flutter app with intuitive workout logging, custom plan builder, and rich progress visualizations.',
                    'features' => ['Workout tracking', 'Custom exercise plans', 'Progress analytics', 'Social sharing', 'Push notifications', 'Personal records'],
                    'year' => 2024,
                    'role' => 'Senior Flutter Developer',
                    'duration' => '4 months',
                    'platform' => 'iOS & Android',
                    'is_featured' => true,
                    'is_published' => true,
                    'display_order' => 2,
                    'app_store_url' => null,
                    'play_store_url' => null,
                    'github_url' => null,
                ],
                'technologies' => ['flutter', 'dart', 'firebase', 'cloud-firestore', 'fcm-notifications', 'bloc'],
            ],
            [
                'data' => [
                    'slug' => 'e-commerce-mobile-app',
                    'title' => 'E-Commerce Mobile App',
                    'subtitle' => 'Full-Featured Shopping Platform',
                    'description' => 'A fully-featured e-commerce application with secure payments, product catalog, shopping cart, and order tracking.',
                    'body' => "A production e-commerce app built with Flutter and GetX state management. Integrated Stripe payments, full order lifecycle, real-time inventory, push notifications, and a beautiful shopping experience.",
                    'problem' => 'A retail brand needed a fast, branded mobile shopping experience to complement their web store.',
                    'solution' => 'Flutter app with shared API, branded UI matching their web identity, and a payments stack handling Stripe + Apple Pay + Google Pay.',
                    'features' => ['Product catalog', 'Shopping cart', 'Secure payments', 'Order history', 'Push notifications', 'Wishlist'],
                    'year' => 2023,
                    'role' => 'Senior Flutter Developer',
                    'duration' => '5 months',
                    'platform' => 'iOS & Android',
                    'is_featured' => true,
                    'is_published' => true,
                    'display_order' => 3,
                    'app_store_url' => null,
                    'play_store_url' => null,
                    'github_url' => null,
                ],
                'technologies' => ['flutter', 'dart', 'firebase', 'stripe', 'getx', 'rest-api'],
            ],
            [
                'data' => [
                    'slug' => 'personal-portfolio-app',
                    'title' => 'Personal Portfolio App',
                    'subtitle' => 'Modern Portfolio Showcase',
                    'description' => 'A modern portfolio application with smooth animations, project showcase, and interactive contact form.',
                    'body' => "A polished mobile portfolio built with Flutter — showcases projects, skills, and contact form with custom animations and Lottie graphics. Demonstrates Flutter's capability for marketing-quality apps.",
                    'problem' => 'Wanted a flagship sample app demonstrating advanced Flutter UI and animation skills.',
                    'solution' => 'Custom-built portfolio with custom render objects, hero transitions, and Lottie integrations.',
                    'features' => ['Animated UI', 'Project showcase', 'Skills presentation', 'Contact form', 'Lottie animations', 'Smooth transitions'],
                    'year' => 2024,
                    'role' => 'Senior Flutter Developer',
                    'duration' => '2 months',
                    'platform' => 'iOS & Android',
                    'is_featured' => false,
                    'is_published' => true,
                    'display_order' => 4,
                    'app_store_url' => null,
                    'play_store_url' => null,
                    'github_url' => 'https://github.com/mohamedxahmedd',
                ],
                'technologies' => ['flutter', 'dart', 'animations', 'custom-ui'],
            ],
        ];

        foreach ($projects as $entry) {
            $project = Project::updateOrCreate(['slug' => $entry['data']['slug']], $entry['data']);

            $techIds = Technology::whereIn('slug', $entry['technologies'])->pluck('id');
            $project->technologies()->sync($techIds);
        }
    }
}

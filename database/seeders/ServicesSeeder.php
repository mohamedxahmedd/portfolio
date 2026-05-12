<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

class ServicesSeeder extends Seeder
{
    public function run(): void
    {
        $services = [
            [
                'title' => 'Flutter Development',
                'short_description' => 'Cross-Platform Apps',
                'description' => 'Building beautiful, performant cross-platform mobile apps for iOS and Android with a single Flutter codebase. From MVP to production, I deliver pixel-perfect apps that users love.',
                'icon' => 'fas fa-mobile-alt',
                'proficiency' => 95,
                'features' => ['Pixel-perfect UI', 'Custom animations', 'Native integrations', 'Adaptive layouts'],
                'display_order' => 1,
            ],
            [
                'title' => 'State Management',
                'short_description' => 'Mobile Apps',
                'description' => 'Implementing robust state management solutions using BLoC, Provider, Riverpod, and GetX. Clean architecture, testable code, predictable state — built for scale.',
                'icon' => 'fas fa-cogs',
                'proficiency' => 92,
                'features' => ['BLoC pattern', 'Riverpod', 'Clean architecture', 'Testable code'],
                'display_order' => 2,
            ],
            [
                'title' => 'API Integration',
                'short_description' => 'Backend Connectivity',
                'description' => 'Seamless REST API integration, Firebase services, push notifications, real-time data sync, authentication flows, and third-party SDK integrations.',
                'icon' => 'fas fa-server',
                'proficiency' => 90,
                'features' => ['REST & GraphQL', 'Firebase Suite', 'Push notifications', 'OAuth & JWT'],
                'display_order' => 3,
            ],
        ];

        foreach ($services as $s) {
            Service::updateOrCreate(['title' => $s['title']], $s);
        }
    }
}

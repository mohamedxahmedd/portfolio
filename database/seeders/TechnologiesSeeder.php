<?php

namespace Database\Seeders;

use App\Models\Technology;
use Illuminate\Database\Seeder;

class TechnologiesSeeder extends Seeder
{
    public function run(): void
    {
        $techs = [
            ['name' => 'Flutter', 'slug' => 'flutter', 'color' => '#02569B', 'icon' => 'fas fa-mobile-alt', 'display_order' => 1],
            ['name' => 'Dart', 'slug' => 'dart', 'color' => '#0175C2', 'icon' => 'fas fa-code', 'display_order' => 2],
            ['name' => 'Firebase', 'slug' => 'firebase', 'color' => '#FFCA28', 'icon' => 'fas fa-fire', 'display_order' => 3],
            ['name' => 'BLoC', 'slug' => 'bloc', 'color' => '#1976D2', 'icon' => 'fas fa-cube', 'display_order' => 4],
            ['name' => 'Riverpod', 'slug' => 'riverpod', 'color' => '#3578E5', 'icon' => 'fas fa-water', 'display_order' => 5],
            ['name' => 'Provider', 'slug' => 'provider', 'color' => '#1389FD', 'icon' => 'fas fa-share-alt', 'display_order' => 6],
            ['name' => 'GetX', 'slug' => 'getx', 'color' => '#9B40A2', 'icon' => 'fas fa-bolt', 'display_order' => 7],
            ['name' => 'REST API', 'slug' => 'rest-api', 'color' => '#6C757D', 'icon' => 'fas fa-server', 'display_order' => 8],
            ['name' => 'Cloud Firestore', 'slug' => 'cloud-firestore', 'color' => '#FF9800', 'icon' => 'fas fa-database', 'display_order' => 9],
            ['name' => 'Stripe', 'slug' => 'stripe', 'color' => '#635BFF', 'icon' => 'fab fa-stripe', 'display_order' => 10],
            ['name' => 'FCM Notifications', 'slug' => 'fcm-notifications', 'color' => '#FF6F00', 'icon' => 'fas fa-bell', 'display_order' => 11],
            ['name' => 'Animations', 'slug' => 'animations', 'color' => '#E91E63', 'icon' => 'fas fa-magic', 'display_order' => 12],
            ['name' => 'Custom UI', 'slug' => 'custom-ui', 'color' => '#9C27B0', 'icon' => 'fas fa-paint-brush', 'display_order' => 13],
        ];

        foreach ($techs as $t) {
            Technology::updateOrCreate(['slug' => $t['slug']], $t);
        }
    }
}

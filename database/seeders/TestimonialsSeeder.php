<?php

namespace Database\Seeders;

use App\Models\Testimonial;
use Illuminate\Database\Seeder;

class TestimonialsSeeder extends Seeder
{
    public function run(): void
    {
        $testimonials = [
            [
                'client_name' => 'Andrew Bolar',
                'client_title' => 'Product Manager',
                'client_company' => 'TechFlow Solutions',
                'content' => 'Mohamed delivered our Flutter app ahead of schedule and exceeded every expectation. Communication was excellent, code quality was top-tier, and the final product launched smoothly on both stores.',
                'rating' => 5,
                'is_featured' => true,
                'is_approved' => true,
                'display_order' => 1,
            ],
            [
                'client_name' => 'Theresa Webb',
                'client_title' => 'UI Designer',
                'client_company' => 'Design Studio',
                'content' => 'Working with Mohamed was a pleasure. He translated our designs pixel-perfectly into Flutter and added subtle animations that made the app feel premium. Highly recommend.',
                'rating' => 5,
                'is_featured' => true,
                'is_approved' => true,
                'display_order' => 2,
            ],
            [
                'client_name' => 'Keil Johnson',
                'client_title' => 'Software Engineer',
                'client_company' => 'AppVenture Studio',
                'content' => 'Mohamed is a talented Flutter developer with deep knowledge of state management. He architected our app with BLoC and the codebase is clean, testable, and maintainable.',
                'rating' => 5,
                'is_featured' => false,
                'is_approved' => true,
                'display_order' => 3,
            ],
        ];

        foreach ($testimonials as $t) {
            Testimonial::updateOrCreate(
                ['client_name' => $t['client_name']],
                $t
            );
        }
    }
}

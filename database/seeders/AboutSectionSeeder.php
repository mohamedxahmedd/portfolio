<?php

namespace Database\Seeders;

use App\Models\AboutSection;
use Illuminate\Database\Seeder;

class AboutSectionSeeder extends Seeder
{
    public function run(): void
    {
        $about = AboutSection::updateOrCreate(['id' => 1], [
            'name' => 'Mohamed Ahmed',
            'title' => 'Senior Flutter Developer',
            'subtitle' => 'Building Amazing Mobile Apps with Flutter',
            'short_bio' => 'Flutter Developer delivering exceptional mobile applications.',
            'bio' => "I'm a passionate Flutter developer based in Cairo, Egypt, with 4+ years of experience in building cross-platform mobile applications.\n\nI specialize in creating beautiful, performant apps using Flutter and Dart, with deep expertise in state management patterns (BLoC, Provider, Riverpod, GetX), Firebase integration, REST APIs, and material design systems.\n\nFrom concept to deployment on the App Store and Play Store, I deliver production-ready apps that solve real problems for real users.",
            'location' => 'Cairo, Egypt',
            'years_experience' => 4,
            'projects_completed' => 10,
            'happy_clients' => 12,
            'availability' => 'Available for freelance & full-time roles',
        ]);

        // Seed default profile photo from the WordPress mirror if it exists
        // and the admin hasn't uploaded one yet.
        $sourcePhoto = base_path('../reeni-mirror/mePortfolio-Photoroom.png');

        if (file_exists($sourcePhoto) && ! $about->hasMedia('profile_photo')) {
            $about->addMedia($sourcePhoto)
                ->preservingOriginal()
                ->toMediaCollection('profile_photo');
        }
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            RolesAndAdminSeeder::class,
            SettingsSeeder::class,
            AboutSectionSeeder::class,
            ContactInfoSeeder::class,
            SocialLinksSeeder::class,
            SkillsSeeder::class,
            ServicesSeeder::class,
            ExperiencesSeeder::class,
            EducationsSeeder::class,
            TechnologiesSeeder::class,
            ProjectsSeeder::class,
            TestimonialsSeeder::class,
            PagesSeeder::class,
        ]);
    }
}

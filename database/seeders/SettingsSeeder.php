<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    public function run(): void
    {
        Setting::updateOrCreate(['id' => 1], [
            'site_name' => 'Mohamed Ahmed',
            'site_tagline' => 'Senior Flutter Developer · Cairo, Egypt',
            'site_description' => "Mohamed Ahmed — Senior Flutter developer in Cairo, building beautiful cross-platform mobile applications with state management and Firebase integration. Available for freelance & full-time work.",
            'theme_primary_color' => '#ff014f',
            'theme_dark_bg' => '#1a1a1a',
            'theme_font_body' => 'Rubik',
            'theme_font_display' => 'Rajdhani',
            'show_dark_light_toggle' => true,
            'default_dark_mode' => true,
        ]);
    }
}

<?php

namespace Database\Seeders;

use App\Models\Skill;
use App\Models\SkillCategory;
use Illuminate\Database\Seeder;

class SkillsSeeder extends Seeder
{
    public function run(): void
    {
        $design = SkillCategory::updateOrCreate(
            ['slug' => 'ui-ux-design'],
            ['name' => 'UI/UX Design', 'icon' => 'fas fa-pencil-ruler', 'display_order' => 1]
        );

        $development = SkillCategory::updateOrCreate(
            ['slug' => 'development-skill'],
            ['name' => 'Development Skill', 'icon' => 'fas fa-code', 'display_order' => 2]
        );

        $designSkills = [
            ['name' => 'Figma', 'proficiency' => 90, 'icon' => 'fab fa-figma'],
            ['name' => 'Adobe XD', 'proficiency' => 85, 'icon' => 'fab fa-adobe'],
            ['name' => 'Material Design', 'proficiency' => 95, 'icon' => 'fab fa-google'],
            ['name' => 'Prototyping', 'proficiency' => 80, 'icon' => 'fas fa-vector-square'],
        ];

        foreach ($designSkills as $i => $s) {
            Skill::updateOrCreate(
                ['skill_category_id' => $design->id, 'name' => $s['name']],
                array_merge($s, ['display_order' => $i + 1])
            );
        }

        $devSkills = [
            ['name' => 'Flutter', 'proficiency' => 95, 'icon' => 'fas fa-mobile-alt'],
            ['name' => 'Dart', 'proficiency' => 90, 'icon' => 'fas fa-code'],
            ['name' => 'Firebase', 'proficiency' => 85, 'icon' => 'fas fa-fire'],
            ['name' => 'REST APIs', 'proficiency' => 88, 'icon' => 'fas fa-server'],
        ];

        foreach ($devSkills as $i => $s) {
            Skill::updateOrCreate(
                ['skill_category_id' => $development->id, 'name' => $s['name']],
                array_merge($s, ['display_order' => $i + 1])
            );
        }
    }
}

<?php

namespace Database\Seeders;

use App\Models\SocialLink;
use Illuminate\Database\Seeder;

class SocialLinksSeeder extends Seeder
{
    public function run(): void
    {
        $links = [
            [
                'platform' => 'linkedin',
                'label' => 'LinkedIn',
                'url' => 'https://linkedin.com/in/mohamed-ahmed-517408238',
                'icon_class' => 'fab fa-linkedin-in',
                'show_in_header' => true,
                'show_in_footer' => true,
                'display_order' => 1,
            ],
            [
                'platform' => 'github',
                'label' => 'GitHub',
                'url' => 'https://github.com/mohamedxahmedd',
                'icon_class' => 'fab fa-github',
                'show_in_header' => true,
                'show_in_footer' => true,
                'display_order' => 2,
            ],
            [
                'platform' => 'instagram',
                'label' => 'Instagram',
                'url' => 'https://instagram.com/mohamedxahmedd',
                'icon_class' => 'fab fa-instagram',
                'show_in_header' => false,
                'show_in_footer' => true,
                'display_order' => 3,
            ],
            [
                'platform' => 'facebook',
                'label' => 'Facebook',
                'url' => 'https://facebook.com/share/1DDTyVTFSe',
                'icon_class' => 'fab fa-facebook-f',
                'show_in_header' => false,
                'show_in_footer' => true,
                'display_order' => 4,
            ],
        ];

        foreach ($links as $link) {
            SocialLink::updateOrCreate(
                ['platform' => $link['platform']],
                $link
            );
        }
    }
}

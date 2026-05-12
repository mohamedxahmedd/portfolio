<?php

namespace Database\Seeders;

use App\Models\Page;
use Illuminate\Database\Seeder;

class PagesSeeder extends Seeder
{
    public function run(): void
    {
        $pages = [
            [
                'slug' => 'privacy-policy',
                'title' => 'Privacy Policy',
                'excerpt' => 'How we handle your data.',
                'body' => "<p>This portfolio site collects only what you submit through the contact form (name, email, phone, message) to respond to your enquiry.</p><p>Your data is never sold or shared with third parties. Contact submissions are stored securely and may be deleted at your request by emailing <strong>hossamfarid71@gmail.com</strong>.</p><p>The site uses minimal first-party cookies for session management. No third-party tracking is in place.</p>",
                'is_published' => true,
                'published_at' => now(),
            ],
            [
                'slug' => 'terms',
                'title' => 'Terms of Use',
                'excerpt' => 'Terms governing use of this site.',
                'body' => "<p>This portfolio is provided as-is for informational purposes. All project case studies, code samples, and content are the intellectual property of Mohamed Ahmed unless otherwise credited.</p><p>You are welcome to view and share content. You may not republish substantial portions without permission.</p>",
                'is_published' => true,
                'published_at' => now(),
            ],
        ];

        foreach ($pages as $p) {
            Page::updateOrCreate(['slug' => $p['slug']], $p);
        }
    }
}

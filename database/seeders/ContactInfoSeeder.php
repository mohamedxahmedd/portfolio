<?php

namespace Database\Seeders;

use App\Models\ContactInfo;
use Illuminate\Database\Seeder;

class ContactInfoSeeder extends Seeder
{
    public function run(): void
    {
        ContactInfo::updateOrCreate(['id' => 1], [
            'email' => 'hossamfarid71@gmail.com',
            'phone' => null,
            'whatsapp' => null,
            'address_line_1' => null,
            'city' => 'Cairo',
            'country' => 'Egypt',
            'working_hours' => 'Mon — Fri · 9:00 AM — 6:00 PM (GMT+2)',
        ]);
    }
}

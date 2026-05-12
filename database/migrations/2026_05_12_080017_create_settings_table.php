<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('site_name')->default('Reeni');
            $table->string('site_tagline')->nullable();
            $table->text('site_description')->nullable();
            $table->string('theme_primary_color', 7)->default('#ff014f');
            $table->string('theme_dark_bg', 7)->default('#1a1a1a');
            $table->string('theme_font_body')->default('Rubik');
            $table->string('theme_font_display')->default('Rajdhani');
            $table->string('google_analytics_id')->nullable();
            $table->string('plausible_domain')->nullable();
            $table->string('default_meta_image')->nullable();
            $table->boolean('maintenance_mode')->default(false);
            $table->text('maintenance_message')->nullable();
            $table->boolean('show_dark_light_toggle')->default(true);
            $table->boolean('default_dark_mode')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};

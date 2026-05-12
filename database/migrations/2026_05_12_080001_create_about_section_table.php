<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('about_section', function (Blueprint $table) {
            $table->id();
            $table->string('name')->default('Mohamed Ahmed');
            $table->string('title')->default('Senior Flutter Developer');
            $table->string('subtitle')->nullable();
            $table->text('short_bio')->nullable();
            $table->longText('bio')->nullable();
            $table->string('location')->nullable();
            $table->unsignedSmallInteger('years_experience')->default(2);
            $table->unsignedSmallInteger('projects_completed')->default(10);
            $table->unsignedSmallInteger('happy_clients')->default(0);
            $table->string('cv_url')->nullable();
            $table->string('availability')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('about_section');
    }
};

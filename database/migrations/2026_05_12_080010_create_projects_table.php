<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('title');
            $table->string('subtitle')->nullable();
            $table->text('description');
            $table->longText('body')->nullable();
            $table->text('problem')->nullable();
            $table->text('solution')->nullable();
            $table->json('features')->nullable();

            $table->unsignedSmallInteger('year')->nullable();
            $table->string('client')->nullable();
            $table->string('role')->default('Senior Flutter Developer');
            $table->string('duration')->nullable();
            $table->string('platform')->nullable();

            // Store + repo links (explicit user requirement)
            $table->string('app_store_url')->nullable();
            $table->string('play_store_url')->nullable();
            $table->string('github_url')->nullable();
            $table->string('live_demo_url')->nullable();
            $table->string('video_url')->nullable();
            $table->string('case_study_url')->nullable();

            // Display flags
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_published')->default(true);
            $table->unsignedSmallInteger('display_order')->default(0);
            $table->timestamp('published_at')->nullable();
            $table->unsignedInteger('view_count')->default(0);

            $table->timestamps();
            $table->softDeletes();

            // Composite index for the homepage feature query
            $table->index(['is_published', 'is_featured', 'display_order'], 'projects_publish_feature_order_idx');
            $table->index('published_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};

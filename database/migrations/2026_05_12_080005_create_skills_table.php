<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('skills', function (Blueprint $table) {
            $table->id();
            $table->foreignId('skill_category_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('icon')->nullable();
            $table->unsignedTinyInteger('proficiency')->default(80);
            $table->unsignedSmallInteger('display_order')->default(0);
            $table->timestamps();

            $table->index(['skill_category_id', 'display_order']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('skills');
    }
};

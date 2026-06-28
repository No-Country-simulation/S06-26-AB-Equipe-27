<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ai_preferences', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->onDelete('cascade');
            $table->json('matching_priority')->nullable(); // ordered list: technical_skills, diversity_goals, location, experience, education
            $table->integer('candidate_radius')->default(50); // km
            $table->boolean('include_remote')->default(true);
            $table->json('talent_sources')->nullable(); // universities, bootcamps, experienced, career_transition
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ai_preferences');
    }
};

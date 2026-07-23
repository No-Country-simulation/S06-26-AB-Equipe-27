<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('candidates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('full_name')->nullable();
            $table->string('phone')->nullable();
            $table->string('city')->nullable();
            $table->string('country')->nullable();
            $table->string('linkedin')->nullable();
            $table->string('portfolio')->nullable();
            $table->string('resume_path')->nullable();
            $table->string('current_job_title')->nullable();
            $table->integer('years_experience')->nullable();
            $table->text('professional_summary')->nullable();
            $table->json('skills')->nullable();
            $table->json('languages')->nullable();
            $table->json('work_experience')->nullable();
            $table->json('education')->nullable();
            // Job Preferences
            $table->string('desired_position')->nullable();
            $table->json('employment_type')->nullable();
            $table->json('work_model')->nullable();
            $table->string('salary_expectation')->nullable();
            $table->string('salary_currency')->default('BRL');
            $table->string('availability')->nullable();
            $table->boolean('setup_completed')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('candidates');
    }
};

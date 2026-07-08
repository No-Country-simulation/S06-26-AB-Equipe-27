<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('industry')->nullable();
            $table->string('size')->nullable(); // 1-10, 11-50, 51-200, 201-1000, 1000+
            $table->string('country')->nullable();
            $table->string('website')->nullable();
            $table->string('work_model')->nullable(); // remote, hybrid, on-site
            $table->json('inclusion_programs')->nullable();
            $table->text('diversity_statement')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};

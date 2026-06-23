<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('company_diversity_goals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->onDelete('cascade');
            $table->string('group'); // women, black, disabled, lgbt, indigenous, over_50, etc.
            $table->decimal('target_percentage', 5, 2)->nullable();
            $table->integer('target_year')->nullable();
            $table->string('priority')->default('medium'); // low, medium, high
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('company_diversity_goals');
    }
};

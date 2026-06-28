<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('esg_goals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->onDelete('cascade');
            $table->string('pillar'); // environmental, social, governance
            $table->string('title');
            $table->text('description')->nullable();
            $table->integer('target_value')->nullable();
            $table->string('unit')->nullable(); // %, count, etc.
            $table->integer('current_value')->default(0);
            $table->date('deadline')->nullable();
            $table->enum('status', ['PENDING', 'IN_PROGRESS', 'ACHIEVED', 'CANCELLED'])->default('PENDING');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('esg_goals');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('esg_goals', function (Blueprint $table) {
            DB::statement("ALTER TABLE esg_goals MODIFY COLUMN status ENUM('NOT_STARTED', 'PENDING', 'IN_PROGRESS', 'COMPLETED', 'ACHIEVED', 'CANCELLED') DEFAULT 'PENDING'");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('esg_goals', function (Blueprint $table) {
            DB::statement("ALTER TABLE esg_goals MODIFY COLUMN status ENUM('PENDING', 'IN_PROGRESS', 'COMPLETED', 'CANCELLED') DEFAULT 'PENDING'");
        });
    }
};

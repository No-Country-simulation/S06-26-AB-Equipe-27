<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('esg_goals', function (Blueprint $table) {
            $table->enum('tracking_type', ['count', 'percentage', 'status'])->default('count')->after('unit');
            $table->text('notes')->nullable()->after('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('esg_goals', function (Blueprint $table) {
            $table->dropColumn('tracking_type');
            $table->dropColumn('notes');
        });
    }
};

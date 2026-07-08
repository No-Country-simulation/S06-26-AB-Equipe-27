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
        Schema::table('company_diversity_goals', function (Blueprint $table) {
            $table->decimal('current_value', 5, 2)->default(0)->after('priority');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('company_diversity_goals', function (Blueprint $table) {
            $table->dropColumn('current_value');
        });
    }
};

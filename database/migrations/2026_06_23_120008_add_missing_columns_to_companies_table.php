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
        Schema::table('companies', function (Blueprint $table) {
            $table->dropColumn('description');
            $table->string('industry')->nullable()->after('name');
            $table->string('size')->nullable()->after('industry'); // 1-10, 11-50, 51-200, 201-1000, 1000+
            $table->string('country')->nullable()->after('size');
            $table->string('website')->nullable()->after('country');
            $table->string('work_model')->nullable()->after('website'); // remote, hybrid, on-site
            $table->json('inclusion_programs')->nullable()->after('work_model');
            $table->text('diversity_statement')->nullable()->after('inclusion_programs');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->text('description')->nullable();
            $table->dropColumn(['industry', 'size', 'country', 'website', 'work_model', 'inclusion_programs', 'diversity_statement']);
        });
    }
};

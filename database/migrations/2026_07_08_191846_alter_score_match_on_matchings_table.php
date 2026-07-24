<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        if (DB::getDriverName() === 'pgsql') {
            DB::statement("
        ALTER TABLE matchings
        ALTER COLUMN score_match
        TYPE NUMERIC(5,2)
        USING score_match::NUMERIC
    ");
        } else {
            Schema::table('matchings', function (Blueprint $table) {
                $table->decimal('score_match', 5, 2)->change();
            });
        }
    }

    public function down(): void
    {
        DB::table('matchings')->update([
            'score_match' => DB::raw('ROUND(score_match)')
        ]);

        Schema::table('matchings', function (Blueprint $table) {
            $table->integer('score_match')->change();
        });
    }
};

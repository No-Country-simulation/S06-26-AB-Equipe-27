<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement('
            ALTER TABLE matchings
            ALTER COLUMN score_match
            TYPE NUMERIC(5,2)
            USING score_match::NUMERIC
        ');
    }

    public function down(): void
    {
        DB::statement('
            ALTER TABLE matchings
            ALTER COLUMN score_match
            TYPE INTEGER
            USING ROUND(score_match)::INTEGER
        ');
    }
};

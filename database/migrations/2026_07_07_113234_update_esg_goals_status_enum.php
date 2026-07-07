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
        // Check if using PostgreSQL
        if (config('database.default') === 'pgsql') {
            // For PostgreSQL: first drop the existing type, then create new one and update column
            DB::statement("ALTER TABLE esg_goals ALTER COLUMN status TYPE VARCHAR(255)");
            DB::statement("DROP TYPE IF EXISTS esg_goals_status_enum CASCADE");
            DB::statement("CREATE TYPE esg_goals_status_enum AS ENUM ('NOT_STARTED', 'PENDING', 'IN_PROGRESS', 'COMPLETED', 'ACHIEVED', 'CANCELLED')");
            DB::statement("ALTER TABLE esg_goals ALTER COLUMN status TYPE esg_goals_status_enum USING status::esg_goals_status_enum");
            DB::statement("ALTER TABLE esg_goals ALTER COLUMN status SET DEFAULT 'PENDING'");
        } else {
            // For MySQL
            DB::statement("ALTER TABLE esg_goals MODIFY COLUMN status ENUM('NOT_STARTED', 'PENDING', 'IN_PROGRESS', 'COMPLETED', 'ACHIEVED', 'CANCELLED') DEFAULT 'PENDING'");
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (config('database.default') === 'pgsql') {
            DB::statement("ALTER TABLE esg_goals ALTER COLUMN status TYPE VARCHAR(255)");
            DB::statement("DROP TYPE IF EXISTS esg_goals_status_enum CASCADE");
            DB::statement("CREATE TYPE esg_goals_status_enum AS ENUM ('PENDING', 'IN_PROGRESS', 'COMPLETED', 'CANCELLED')");
            DB::statement("ALTER TABLE esg_goals ALTER COLUMN status TYPE esg_goals_status_enum USING status::esg_goals_status_enum");
            DB::statement("ALTER TABLE esg_goals ALTER COLUMN status SET DEFAULT 'PENDING'");
        } else {
            DB::statement("ALTER TABLE esg_goals MODIFY COLUMN status ENUM('PENDING', 'IN_PROGRESS', 'COMPLETED', 'CANCELLED') DEFAULT 'PENDING'");
        }
    }
};

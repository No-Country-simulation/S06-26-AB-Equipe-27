<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $indices = [];
            try {
                $conn = Schema::getConnection();
                $sm = $conn->getDoctrineSchemaManager();
                $indexList = $sm->listTableIndexes($conn->getTablePrefix() . 'users');
                foreach ($indexList as $idx) {
                    $cols = $idx->getColumns();
                    if (count($cols) === 1 && ($cols[0] ?? null) === 'email' && $idx->isUnique()) {
                        $indices[] = $idx->getName();
                    }
                }
            } catch (\Throwable $e) {
            }
            foreach (array_unique($indices) as $idxName) {
                try {
                    $table->dropUnique($idxName);
                } catch (\Throwable $e) {
                }
            }
            try {
                if (count($indices) === 0) {
                    $table->dropUnique(['email']);
                }
            } catch (\Throwable $e) {
            }

            if (!Schema::hasColumn('users', 'account_type')) {
                $table->string('account_type', 20)->default('empresa');
            }
        });

        $driver = DB::getDriverName();
        if ($driver === 'pgsql') {
            DB::statement("UPDATE users SET account_type = CASE
                WHEN EXISTS (SELECT 1 FROM companies c WHERE c.user_id = users.id) AND
                     NOT EXISTS (SELECT 1 FROM candidates can WHERE can.user_id = users.id) THEN 'empresa'
                WHEN EXISTS (SELECT 1 FROM candidates can WHERE can.user_id = users.id) AND
                     NOT EXISTS (SELECT 1 FROM companies c WHERE c.user_id = users.id) THEN 'candidato'
                ELSE 'empresa' END");
        } else {
            DB::statement("UPDATE users SET account_type = CASE
                WHEN EXISTS (SELECT 1 FROM companies c WHERE c.user_id = users.id) AND
                     NOT EXISTS (SELECT 1 FROM candidates can WHERE can.user_id = users.id) THEN 'empresa'
                WHEN EXISTS (SELECT 1 FROM candidates can WHERE can.user_id = users.id) AND
                     NOT EXISTS (SELECT 1 FROM companies c WHERE c.user_id = users.id) THEN 'candidato'
                ELSE 'empresa' END");
        }

        Schema::table('users', function (Blueprint $table) {
            try {
                $table->unique(['email', 'account_type'], 'users_email_account_type_unique');
            } catch (\Throwable $e) {
                try {
                    $table->unique(['email', 'account_type']);
                } catch (\Throwable $e2) {
                }
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            try {
                $table->dropUnique('users_email_account_type_unique');
            } catch (\Throwable $e) {
                try {
                    $table->dropUnique(['email', 'account_type']);
                } catch (\Throwable $e2) {
                }
            }
            if (Schema::hasColumn('users', 'account_type')) {
                try {
                    $table->dropColumn('account_type');
                } catch (\Throwable $e) {
                }
            }
            try {
                $table->unique('email');
            } catch (\Throwable $e) {
            }
        });
    }
};

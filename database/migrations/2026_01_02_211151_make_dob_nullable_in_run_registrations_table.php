<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // For MySQL/MariaDB, alter the column to be nullable
        if (DB::getDriverName() !== 'sqlite') {
            Schema::table('run_registrations', function (Blueprint $table) {
                $table->date('dob')->nullable()->change();
            });
        } else {
            // For SQLite, we need to recreate the table
            Schema::table('run_registrations', function (Blueprint $table) {
                $table->date('dob')->nullable()->change();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (DB::getDriverName() !== 'sqlite') {
            Schema::table('run_registrations', function (Blueprint $table) {
                $table->date('dob')->nullable(false)->change();
            });
        }
    }
};

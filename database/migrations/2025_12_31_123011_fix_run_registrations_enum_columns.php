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
        // SQLite doesn't support ALTER COLUMN, so we need to recreate the table
        if (DB::getDriverName() === 'sqlite') {
            // Drop the old table and recreate with string columns
            Schema::dropIfExists('run_registrations');
            
            Schema::create('run_registrations', function (Blueprint $table) {
                $table->id();
                $table->string('registration_id')->unique()->nullable();
                $table->string('employee_id')->unique();
                $table->string('name');
                $table->string('designation');
                $table->string('company');
                $table->string('entity')->nullable();
                $table->date('dob');
                $table->string('run_category'); // Changed from enum to string
                $table->string('contact_number');
                $table->string('tshirt_size'); // Changed from enum to string
                $table->timestamps();
            });
        } else {
            // For MySQL/MariaDB, we can alter the columns
            Schema::table('run_registrations', function (Blueprint $table) {
                $table->string('run_category')->change();
                $table->string('tshirt_size')->change();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // This is a destructive migration, so we'll just note it
        // In production, you'd want to backup data first
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('run_registrations', function (Blueprint $table) {
            $table->id();
            $table->string('employee_id')->unique();
            $table->string('name');
            $table->string('designation');
            $table->string('company');
            $table->date('dob');
            $table->string('run_category'); // Using string instead of enum for SQLite compatibility
            $table->string('contact_number');
            $table->string('tshirt_size'); // Using string instead of enum for SQLite compatibility
            $table->timestamps();
        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('run_registrations');
    }
};

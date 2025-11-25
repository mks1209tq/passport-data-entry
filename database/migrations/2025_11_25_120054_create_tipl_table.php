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
        Schema::create('tipl', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('employee_id', 100)->nullable();
            $table->string('company_name', 100)->nullable();
            $table->string('phone_number', 20)->nullable();
            $table->string('pick_up_point', 100)->nullable();
            $table->string('in_house_talent', 10)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tipl');
    }
};

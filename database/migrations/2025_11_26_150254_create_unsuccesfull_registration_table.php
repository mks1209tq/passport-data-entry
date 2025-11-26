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
        Schema::create('unsuccesfull_registration', function (Blueprint $table) {
            $table->id();
            $table->string('id_code', 100);
            $table->string('name', 100)->nullable();
            $table->string('company_name', 100)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('unsuccesfull_registration');
    }
};

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
        Schema::create('guests', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('designation', 100)->nullable();
            $table->string('company', 100)->nullable();
            $table->string('category', 100)->nullable();
            $table->string('proposalBy', 100)->nullable();
            $table->string('guestOf', 100)->nullable();
            $table->string('RSVP', 100)->nullable();
            $table->string('tableAllocation', 100)->nullable();
            $table->string('attendance', 100)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('guests');
    }
};

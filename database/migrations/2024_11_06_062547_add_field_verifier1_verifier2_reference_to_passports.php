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
         Schema::table('passports', function (Blueprint $table) {
            $table->foreignId('verifier1')->nullable()->constrained('users');
            $table->foreignId('verifier2')->nullable()->constrained('users');
             $table->boolean('is_issue')->default(false);
         });
     }
   

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('passports', function (Blueprint $table) {
            //
        });
    }
};

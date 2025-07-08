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
            $table->foreignId('verifier1_id')->nullable()->constrained('users');
            $table->foreignId('verifier2_id')->nullable()->constrained('users');
            $table->foreignId('verifier1')->nullable()->constrained('users');
            $table->foreignId('verifier2')->nullable()->constrained('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('passports', function (Blueprint $table) {
            $table->dropForeign(['verifier1_id']);
            $table->dropForeign(['verifier2_id']);
            $table->dropForeign(['verifier1']);
            $table->dropForeign(['verifier2']);
            $table->dropColumn(['verifier1_id', 'verifier2_id', 'verifier1', 'verifier2']);
        });
    }
};

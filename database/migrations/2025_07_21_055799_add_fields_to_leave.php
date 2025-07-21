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
         Schema::table('leave_requests', function (Blueprint $table) {
            
            $table->integer('verify_count')->nullable()->default(0);
            
            
         });
     }
   

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('leave_requests', function (Blueprint $table) {
            $table->dropForeign(['verifier1_id']);
            $table->dropForeign(['verifier2_id']);
            $table->dropForeign(['verifier1']);
            $table->dropForeign(['verifier2']);
            $table->dropColumn(['verifier1_id', 'verifier2_id', 'verifier1', 'verifier2']);
        });
    }
};

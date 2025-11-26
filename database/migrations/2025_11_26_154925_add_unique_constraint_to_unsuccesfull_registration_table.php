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
        // First, remove duplicate entries (keep the oldest one for each id_code)
        // Get all id_codes that have duplicates
        $duplicateIds = DB::table('unsuccesfull_registration')
            ->select('id_code', DB::raw('MIN(id) as min_id'))
            ->groupBy('id_code')
            ->havingRaw('COUNT(*) > 1')
            ->get();
        
        foreach ($duplicateIds as $duplicate) {
            // Delete all entries for this id_code except the oldest one
            DB::table('unsuccesfull_registration')
                ->where('id_code', $duplicate->id_code)
                ->where('id', '!=', $duplicate->min_id)
                ->delete();
        }
        
        // Add unique constraint on id_code
        Schema::table('unsuccesfull_registration', function (Blueprint $table) {
            $table->unique('id_code');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('unsuccesfull_registration', function (Blueprint $table) {
            $table->dropUnique(['id_code']);
        });
    }
};

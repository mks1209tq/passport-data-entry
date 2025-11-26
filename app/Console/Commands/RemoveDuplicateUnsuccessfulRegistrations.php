<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class RemoveDuplicateUnsuccessfulRegistrations extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tipl:remove-duplicate-unsuccessful';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remove duplicate entries from unsuccessful_registration table';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Removing duplicate entries from unsuccessful_registration table...');
        
        // Get all duplicates grouped by id_code
        $duplicates = DB::table('unsuccesfull_registration')
            ->select('id_code', DB::raw('COUNT(*) as count'))
            ->groupBy('id_code')
            ->having('count', '>', 1)
            ->get();
        
        $totalRemoved = 0;
        
        foreach ($duplicates as $duplicate) {
            // Get all entries for this id_code, ordered by id (oldest first)
            $entries = DB::table('unsuccesfull_registration')
                ->where('id_code', $duplicate->id_code)
                ->orderBy('id', 'asc')
                ->get();
            
            // Keep the first (oldest) entry, delete the rest
            $keepId = $entries->first()->id;
            $toDelete = $entries->skip(1)->pluck('id');
            
            if ($toDelete->count() > 0) {
                DB::table('unsuccesfull_registration')
                    ->whereIn('id', $toDelete)
                    ->delete();
                
                $totalRemoved += $toDelete->count();
                $this->info("Removed {$toDelete->count()} duplicate(s) for ID: {$duplicate->id_code}");
            }
        }
        
        if ($totalRemoved > 0) {
            $this->info("Total duplicates removed: {$totalRemoved}");
        } else {
            $this->info('No duplicates found.');
        }
        
        return 0;
    }
}

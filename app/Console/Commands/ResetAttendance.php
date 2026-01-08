<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\RunRegistration;

class ResetAttendance extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'attendance:reset {--force : Force reset without confirmation}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reset all attendance status to pending (clears attendance data)';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Resetting attendance data...');
        
        // Count how many records will be affected
        $totalRegistrations = RunRegistration::count();
        $presentCount = RunRegistration::where('attendance_status', 'present')->count();
        
        $this->info("Total registrations: {$totalRegistrations}");
        $this->info("Registrations marked as present: {$presentCount}");
        
        $shouldReset = $this->option('force') || $this->confirm('Are you sure you want to reset all attendance data?', true);
        
        if ($shouldReset) {
            // Reset all attendance_status to 'pending'
            $updated = RunRegistration::query()->update(['attendance_status' => 'pending']);
            
            $this->info("✓ Successfully reset attendance for {$updated} registration(s).");
            $this->info('All attendance statuses have been set to "pending".');
            
            return Command::SUCCESS;
        }
        
        $this->info('Operation cancelled.');
        return Command::SUCCESS;
    }
}

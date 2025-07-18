<?php

namespace App\Console\Commands\leave;

use Illuminate\Console\Command;
use App\Models\LeaveRequest;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class AssignLeavesToVerifier extends Command
{
    protected $signature = 'lv:assign {count=10 : Number of leaves to assign per user}';
    protected $description = 'Assign leaves to verifiers';

    public function handle()
    {
        $this->info('Starting leave assignment process...');

        $countPerUser = $this->argument('count');

        $users = User::where('is_admin', false)->where('is_verifier', true)->get();

        if ($users->isEmpty()) {
            $this->error('No non-admin users found in the system.');
            return;
        }

        DB::beginTransaction();

        try {
            foreach ($users as $user) {
                $assignedCount = $this->assignLeavesToVerifier($user, $countPerUser);
                $this->info("Assigned $assignedCount leaves to user ID: " . $user->id);
            }

            DB::commit();
            $this->info('Leave assignment completed successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            $this->error('An error occurred: ' . $e->getMessage());
            $this->error('Changes have been rolled back.');
        }
    }

    private function assignLeavesToVerifier(User $user, int $count): int
    {
        $assignedCount = 0;

        // Find leaves that don't have this user as either verifier
        $unassignedLeaves = LeaveRequest::where(function($query) use ($user) {
                $query->whereNull('verifier1')
                    ->orWhereNull('verifier2');
            })
            ->where('is_data_entered', true)
            // Ensure user isn't already assigned as the other verifier
            ->where(function($query) use ($user) {
                $query->where('verifier1', '!=', $user->id)
                    ->orWhereNull('verifier1');
            })
            ->where(function($query) use ($user) {
                $query->where('verifier2', '!=', $user->id)
                    ->orWhereNull('verifier2');
            })
            ->limit($count)
            ->get();

        foreach ($unassignedLeaves as $leave) {
            // Assign to first empty verifier slot
            if (is_null($leave->verifier1)) {
                $leave->verifier1 = $user->id;
            } else {
                $leave->verifier2 = $user->id;
            }
            $leave->save();
            $assignedCount++;
        }

        return $assignedCount;
    }
}

<?php

namespace App\Console\Commands\leave;

use Illuminate\Console\Command;
use App\Models\LeaveRequest;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class AssignLeavesToUsers extends Command
{
    protected $signature = 'leaves:assign {count=10 : Number of leaves to assign per user}';
    protected $description = 'Assign unassigned leaves to users';

    public function handle()
    {
        $this->info('Starting leave assignment process...');

        $countPerUser = $this->argument('count');

        $users = User::where('is_admin', false)->where('is_verifier', false)->get();

        if ($users->isEmpty()) {
            $this->error('No non-admin users found in the system.');
            return;
        }

        DB::beginTransaction();

        try {
            foreach ($users as $user) {
                $assignedCount = $this->assignLeavesToUser($user, $countPerUser);
                if ($assignedCount > 0) {
                    $this->info("Assigned $assignedCount leaves to user ID: " . $user->id);
                } else {
                    $this->error('No leaves were assigned to user ID: ' . $user->id);
                }
            }

            DB::commit();
            $this->info('Leave assignment completed successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            $this->error('An error occurred: ' . $e->getMessage());
            $this->error('Changes have been rolled back.');
        }
    }

    private function assignLeavesToUser(User $user, int $count): int
    {
        $assignedCount = 0;

        $unassignedLeaves = LeaveRequest::whereNull('user_id')
            ->where('is_data_entered', false)
            ->limit($count)
            ->get();

        if ($unassignedLeaves->isEmpty()) {
            $this->error('No unassigned leaves(is_data_entered = false) found for user ID : ' . $user->id);
        }

        foreach ($unassignedLeaves as $leave) {
            $leave->user_id = $user->id;
            $leave->save();
            $assignedCount++;
        }

        return $assignedCount;
    }
}

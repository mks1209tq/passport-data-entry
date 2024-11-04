<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Passport;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class AssignPassportsToOneUser extends Command
{
    protected $signature = 'passports:assign-one {count : Number of passports to assign per user} {users* : Array of user IDs}';

    protected $description = 'Assign unassigned passports to particular user';

    public function handle()
    {
        $this->info('Starting passport assignment process...');

        $countPerUser = (int) $this->argument('count');
        if (!$countPerUser || $countPerUser <= 0) {
            $this->error('Count must be a positive number.');
            return;
        }
        $userIds = $this->argument('users');

        $users = User::whereIn('id', $userIds)
                    ->where('is_admin', false)
                    ->where('is_verifier', false)
                    ->get();

        

        if ($users->isEmpty()) {
            $this->error('No non-admin users found in the system.');
            return;
        }

        DB::beginTransaction();

        try {
            foreach ($users as $user) {
                $assignedCount = $this->assignPassportsToUser($user, $countPerUser);
                $this->info("Assigned $assignedCount passports to user ID: " . $user->id);
            }

            DB::commit();
            $this->info('Passport assignment completed successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            $this->error('An error occurred: ' . $e->getMessage());
            $this->error('Changes have been rolled back.');
        }
    }

    private function assignPassportsToUser(User $user, int $count): int
    {
        $assignedCount = 0;

        $unassignedPassports = Passport::whereNull('user_id')
            ->where('is_data_entered', false)
            ->limit($count)
            ->get();


        foreach ($unassignedPassports as $passport) {
            $passport->user_id = $user->id;
            $passport->save();
            $assignedCount++;
        }

        return $assignedCount;
    }
}

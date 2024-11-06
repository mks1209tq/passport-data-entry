<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Passport;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class AssignPassportsToVerifier extends Command
{
    protected $signature = 'pv:assign {count=10 : Number of passports to assign per user}';
    protected $description = 'Assign passports to verifiers';

    public function handle()
    {
        $this->info('Starting passport assignment process...');

        $countPerUser = $this->argument('count');

        $users = User::where('is_admin', false)->where('is_verifier', true)->get();

        if ($users->isEmpty()) {
            $this->error('No non-admin users found in the system.');
            return;
        }

        DB::beginTransaction();

        try {
            foreach ($users as $user) {
                $assignedCount = $this->assignPassportsToVerifier($user, $countPerUser);
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

    private function assignPassportsToVerifier(User $user, int $count): int
{
    $assignedCount = 0;

    // Find passports that don't have this user as either verifier
    $unassignedPassports = Passport::where(function($query) use ($user) {
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
        // ->toSql();
        ->get();

        // dd($unassignedPassports);

    foreach ($unassignedPassports as $passport) {
        // Assign to first empty verifier slot
        if (is_null($passport->verifier1)) {
            $passport->verifier1 = $user->id;
        } else {
            $passport->verifier2 = $user->id;
        }
        $passport->save();
        $assignedCount++;
    }

    return $assignedCount;
}
}

<?php

namespace App\Console\Commands\passport;

use Illuminate\Console\Command;
use App\Models\Passport;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class RemoveVerifier extends Command
{
    protected $signature = 'verifier:remove {user_ids*}';

    protected $description = 'Remove all passport assignments from a specific verifier';

    public function handle()
    {
        $userIds = $this->argument('user_ids');
        
        // Get only existing users
        $existingUsers = User::whereIn('id', $userIds)->get();
        $existingUserIds = $existingUsers->pluck('id')->toArray();

        if (empty($existingUserIds)) {
            $this->error('No valid users found!');
            return 1;
        }

        // Remove verifier assignments
        $updatedPassports = Passport::where(function($query) use ($existingUserIds) {
            $query->whereIn('verifier1', $existingUserIds)
                  ->orWhereIn('verifier2', $existingUserIds);
        })->update([
            'verifier1' => \DB::raw("CASE WHEN verifier1 IN (" . implode(',', $existingUserIds) . ") THEN NULL ELSE verifier1 END"),
            'verifier2' => \DB::raw("CASE WHEN verifier2 IN (" . implode(',', $existingUserIds) . ") THEN NULL ELSE verifier2 END"),
        ]);

        $userNames = $existingUsers->pluck('name')->implode(', ');
        $this->info("Successfully removed verifier assignments for users: $userNames");
        $this->info("Updated $updatedPassports passport records");
        
        return 0;
    }
}

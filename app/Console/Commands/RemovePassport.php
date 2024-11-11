<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Passport;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class RemovePassport extends Command
{
    protected $signature = 'passport:remove {user_ids*}';

    protected $description = 'Remove all passport assignments from a specific or multiple users';

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

        // Remove passport assignments
        $updatedPassports = Passport::where(function($query) use ($existingUserIds) {
            $query->whereIn('user_id', $existingUserIds);
        })->update([
            'user_id' => \DB::raw("CASE WHEN user_id IN (" . implode(',', $existingUserIds) . ") THEN NULL ELSE user_id END"),
        ]);

        $userNames = $existingUsers->pluck('name')->implode(', ');
        $this->info("Successfully removed passport assignments for users: $userNames");
        $this->info("Updated $updatedPassports passport records");
        
        return 0;
    }
}

<?php

namespace App\Console\Commands\leave;

use Illuminate\Console\Command;
use App\Models\LeaveRequest;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class RemoveLeaves extends Command
{
    protected $signature = 'leave:remove {user_ids*}';

    protected $description = 'Remove all leave assignments from a specific or multiple users';

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

        // Remove leave assignments
        $updatedLeaves = LeaveRequest::where(function($query) use ($existingUserIds) {
            $query->whereIn('user_id', $existingUserIds);
        })->update([
            'user_id' => \DB::raw("CASE WHEN user_id IN (" . implode(',', $existingUserIds) . ") THEN NULL ELSE user_id END"),
        ]);

        $userNames = $existingUsers->pluck('name')->implode(', ');
        $this->info("Successfully removed leave assignments for users: $userNames");
        $this->info("Updated $updatedLeaves leave records");
        
        return 0;
    }
}

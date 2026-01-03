<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class CreateSuperAdmins extends Command
{
    protected $signature = 'admin:create-super-admins';
    protected $description = 'Create super admin accounts from SUPER_ADMIN_EMAILS in .env';

    public function handle()
    {
        $superAdminEmails = env('SUPER_ADMIN_EMAILS', '');
        
        if (empty($superAdminEmails)) {
            $this->error('SUPER_ADMIN_EMAILS is not set in .env file!');
            return 1;
        }

        $emails = array_map('trim', explode(',', $superAdminEmails));
        $emails = array_filter($emails);
        
        if (empty($emails)) {
            $this->error('No super admin emails found in SUPER_ADMIN_EMAILS!');
            return 1;
        }

        $adminPassword = env('ADMIN_PASSWORD', 'admin123');
        
        $this->info('Creating super admin accounts...');
        $this->info('Using password from ADMIN_PASSWORD in .env');
        $this->newLine();

        foreach ($emails as $email) {
            $user = User::where('email', $email)->first();
            
            if ($user) {
                $this->warn("Super admin already exists: {$email}");
            } else {
                $name = explode('@', $email)[0];
                $name = ucfirst(str_replace(['.', '_'], ' ', $name));
                
                User::create([
                    'name' => $name,
                    'email' => $email,
                    'password' => Hash::make($adminPassword),
                ]);
                
                $this->info("✓ Created super admin: {$email}");
            }
        }

        $this->newLine();
        $this->info('Super admin accounts created successfully!');
        $this->info('You can now login with email and password to create more admin accounts.');
        
        return 0;
    }
}


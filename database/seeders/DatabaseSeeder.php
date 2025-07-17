<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Employee;
use App\Models\Passport;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        $this->call([
            LeaveRequestSeeder::class,
        ]);

        User::factory()->create([
            'name' => 'admin',
            'email' => 'a@a.com',
            'password' => '$2y$12$kt6DH3V.hOsZxbIJLNZFEOIaUPB4dSyJL1hepO8GSmE1UgMXvtp3q',
            'is_admin' => true,
        ]);

        // User::factory()->create([
        //     'name' => 'user1',
        //     'email' => 'user1@a.com',
        //     'password' => '$2y$12$kt6DH3V.hOsZxbIJLNZFEOIaUPB4dSyJL1hepO8GSmE1UgMXvtp3q',
        // ]);

        // User::factory()->create([
        //     'name' => 'user2',
        //     'email' => 'user2@a.com',
        //     'password' => '$2y$12$kt6DH3V.hOsZxbIJLNZFEOIaUPB4dSyJL1hepO8GSmE1UgMXvtp3q',
        // ]);

        // Employee::factory()->create([
        //     'name' => 'employee1',
        //     'user_id' => 2,
        // ]);

        // Employee::factory()->create([
        //     'name' => 'employee2',
        //     'user_id' => 2,
        // ]);

        // Employee::factory()->create([
        //     'name' => 'employee3',
        //     'user_id' => 1,
        // ]);

        // Employee::factory()->create([
        //     'name' => 'employee4',
        //     'user_id' => 2,
        // ]);

        // Passport::factory()->create([
        //     'employee_id' => 1,
        //     'file_name' => '10003.pdf',
        //     'passport_expiry_date' => '2025-01-01',
        //     'visa_expiry_date' => '2025-02-01',
        //     'user_id' => 1,
        // ]);

        // Passport::factory()->create([
        //     'employee_id' => 2,
        //     'file_name' => '10003.pdf',
        //     'passport_expiry_date' => '2025-01-01',
        //     'visa_expiry_date' => '2025-02-01',
        //     'user_id' => 2,
        // ]);

        // Passport::factory()->create([
        //     'employee_id' => 3,
        //     'file_name' => '10003-R.pdf',
        //     'passport_expiry_date' => '2025-01-01',
        //     'visa_expiry_date' => '2025-02-01',
        //     'user_id' => 2,
        // ]);
        
        // Passport::factory()->create([
        //     'employee_id' => 4,
        //     'file_name' => '10003-R.pdf',
        //     'passport_expiry_date' => '2025-01-01',
        //     'visa_expiry_date' => '2025-02-01',
        //     'user_id' => 2,
        // ]);

        // Passport::factory()->create([
        //     'employee_id' => 5,
        //     'file_name' => '10003.pdf',
        //     'passport_expiry_date' => '2025-01-01',
        //     'visa_expiry_date' => '2025-02-01',
        //     'user_id' => 2,
        // ]);
    }   
}

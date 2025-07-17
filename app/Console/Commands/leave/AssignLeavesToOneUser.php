<?php

namespace App\Console\Commands\leave;

use Illuminate\Console\Command;

class AssignLeavesToOneUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:assign-leaves-to-one-user';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Assigning leaves to one user...');
    }
}

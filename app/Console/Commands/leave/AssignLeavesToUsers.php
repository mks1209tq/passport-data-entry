<?php

namespace App\Console\Commands\leave;

use Illuminate\Console\Command;

class AssignLeavesToUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:assign-leaves-to-users';

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
        $this->info('Assigning leaves to users...');
    }
}

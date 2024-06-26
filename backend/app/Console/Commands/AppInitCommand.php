<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class AppInitCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:init';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Initialize the application';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Artisan::call('optimize');
        Artisan::call('migrate');
        Artisan::call('db:seed');
    }
}

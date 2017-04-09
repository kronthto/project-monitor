<?php

namespace App\Console\Commands;

use App\Services\Checkers\HttpCheckService;
use App\Services\RunManager;
use Illuminate\Console\Command;

class CheckCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'monitor:run';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Checks the registered projects';

    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $runManager = new RunManager();

        $runManager->register(new HttpCheckService());

        $runManager->processStack();
    }
}

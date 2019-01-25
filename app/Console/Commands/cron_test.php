<?php

namespace App\Console\Commands;

use App\Game;
use App\Http\Controllers\TestController;
use Carbon\Carbon;
use Illuminate\Console\Command;

class cron_test extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cron_test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'cron_test';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        
		$myController = app(TestController::class);
		$res = $myController->cron_test(); 		
 
		$this->line("$res");
		
    }
	
}












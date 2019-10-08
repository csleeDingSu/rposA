<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;

class crontest extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tn:tao';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'drunt';

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
    	$dd = \App\CronManager::where('id' , 9)->first();
        $dd->status = 2;
        $dd->save();
        event(new \App\Events\EventDynamicChannel('-tabao-cron', '' ,$dd ));
        sleep(5);
        
        $dd->status = 3;
        $dd->save();
        event(new \App\Events\EventDynamicChannel('-tabao-cron', '' ,$dd ));

        sleep(1);
        $dd->status = 1;
        $dd->save();
        event(new \App\Events\EventDynamicChannel('-tabao-cron', '' ,$dd ));


    }

}












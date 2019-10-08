<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Console\option;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class crontest extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'run:tao';

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
        try {
        
			

            $dd->status = 3;
            $dd->save();
            event(new \App\Events\EventDynamicChannel('-tabao-cron', '' ,$dd ));

            return $res;
        } 
        catch (\Exception $e) 
        { 
            //$data='console GetTaobaoCollectionList: ' . (string) $e;
          //  \Log::error($data);
            $dd->status = 3;
            $dd->save();
            event(new \App\Events\EventDynamicChannel('-tabao-cron', '' ,$dd ));



        }

    }

}












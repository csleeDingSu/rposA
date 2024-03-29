<?php

namespace App\Console\Commands;

use App\Http\Controllers\tabaoApiController;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Console\option;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class StoreAllCollectionIntoVouchers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:storeAllCollectionIntoVouchers';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'storeAllCollectionIntoVouchers taobao collection list';

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
    	// $dd = \App\CronManager::where('id' , 9)->first();
     //    $dd->status = 2;
     //    $dd->save();
     //    event(new \App\Events\EventDynamicChannel('-tabao-cron', '' ,$dd ));
        try {
        
			$this->comment('---Start:'.Carbon::now()->toDateTimeString().'---');
            \Log::info("This a command storeAllCollectionIntoVouchers - start");

            $_Controller = app(tabaoApiController::class);
            $res = $_Controller->storeAllCollectionIntoVouchers();

            $this->comment($res);

            \Log::info("This a command storeAllCollectionIntoVouchers - end");
            $this->comment('---End:'.Carbon::now()->toDateTimeString().'---');

            // $dd->status = 3;
            // $dd->save();
            // event(new \App\Events\EventDynamicChannel('-tabao-cron', '' ,$dd ));

            return json_encode($res);
            // return 'done';
        } 
        catch (\Exception $e) 
        { 
            $data='console storeAllCollectionIntoVouchers: ' . (string) $e;
            \Log::error($data);
            // $dd->status = 3;
            // $dd->save();
            // event(new \App\Events\EventDynamicChannel('-tabao-cron', '' ,$dd ));
            return 'error';



        }

    }

}












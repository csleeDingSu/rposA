<?php

namespace App\Console\Commands;

use App\Http\Controllers\tabaoApiController;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Console\option;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class Testrun extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'run:gc';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'get taobao collection list';

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
    	//sleep(1);
		$dd = \App\CronManager::where('id' , 9)->first();
		$dd->status = 2;
		$dd->save();
			
		event(new \App\Events\EventDynamicChannel('-tabao-cron', '' ,$dd ));
		
		
		for($i=1;$i<=15;$i++)
		{
			//\DB::table('test')->insert(['notes'=>$i,'created_at'=>now()]);
			$this->comment('insert data');
			sleep(2);
		}
		sleep(5);
		$dd->status = 3;
		$dd->save();
		event(new \App\Events\EventDynamicChannel('-tabao-cron', '' ,$dd ));
		//$dd->status = 1;
		//$dd->save();
		/*try {
        
			$this->comment('---Start:'.Carbon::now()->toDateTimeString().'---');
            \Log::info("This a command GetTaobaoCollectionList");

            $_Controller = app(tabaoApiController::class);
            $res = $_Controller->storeAllCollectionList();

            $this->comment($res);
            $this->comment('---End:'.Carbon::now()->toDateTimeString().'---');
            return $res;
        } 
        catch (\Exception $e) 
        { 
            $data='console GetTaobaoCollectionList: ' . (string) $e;
            \Log::error($data);

        }
*/
    }

}












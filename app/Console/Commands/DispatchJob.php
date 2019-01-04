<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Game;

class DispatchJob extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'game:generateresult';
	
	
	protected $cronname  = 'game_generate_result';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }
	
	 public function fire()
    {
        //$vars = new MMProcessGameResult();
		//$vars->handle();
		 
		 $this->call('game:gs', [ ]);
		 //$request = Request::create('generateresult', 'GET');
        //$this->info(app()['Illuminate\Contracts\Http\Kernel']->handle($request));
		 
		//C:\xampp\htdocs\newding\app\Console\Commands 
		//require app_path() . '/Console/Commands/pros/MMProcessGameResult.php' ;
		 
		 //App\Console\Commands\pros\
		//$vars = new MMProcessGameResult();
		//$vars = new ProcessGameResulta();
		 
		// if (!class_exists('MMProcessGameResult')) {
			//spl_autoload_unregister('MMProcessGameResult');
			 //echo 'yes';
			 //require app_path() . '/Console/Commands/pros/MMProcessGameResult.php' ;
		//}
		 
		 
		/* $autoloadFuncs = spl_autoload_functions();
//var_dump($autoloadFuncs);

foreach($autoloadFuncs as $unregisterFunc)
{
    spl_autoload_unregister($unregisterFunc);
	//$this->error($unregisterFunc);
	//print_r($unregisterFunc);
	//die();
	
}
		 */
		 
		 /*
		 $loader = require 'vendor/autoload.php';
		 $loader->unregister();
		 
		 
		 $res = get_declared_classes();
    $autoloaderClassName = '';
    foreach ( $res as $className) {
		//echo $className;
        if (strpos($className, 'App\Console\Commands\MMProcessGameResult') === 0) {
            $autoloaderClassName = $className; // ComposerAutoloaderInit323a579f2019d15e328dd7fec58d8284 for me
			
			 spl_autoload_unregister($autoloaderClassName);
			
            break;
        }
    }
		 $this->error($autoloaderClassName);
		 
		 require app_path() . '/Console/Commands/pros/MMProcessGameResult.php' ;
		 
		 */
		//echo $autoloaderClassName; 
		 
		// die();
		//if (!class_exists('ProcessGameResulta')) {
			//$vars = new ProcessGameResulta();
		//} 
	   // $vars = new MMProcessGameResult();
		//$vars->handle();
		//$this->call('game:gs', [ ]);
    }
	
	public function runtask()
	{
		$this->comment('Stared:'.'----------'.Carbon::now()->toDateTimeString().'----------');
		$this->call('game:gs', [ ]);

		

		$this->info(' ');			
		$this->info('-------------Waiting for next queue----------');
		$this->info(' ');	
	}
	
	private function heartbeat()
	{
		$cname  = 'game_generate_result';
		$row    = \DB::table('cron_manager')->where('cron_name',$cname)->first();
		
		if ($row)
		{
			if ($row->status == 1)
			{
				return FALSE;
			}
			
			$data = ['last_run'=>Carbon::now(),'status'=>1,'notes'=>'','unix_last_run'=>Carbon::now()->timestamp];
			
			
			\DB::table('cron_manager')
            	->where('cron_name', $cname)
            	->update($data);
			
			return TRUE;
			
		}
		$data  = ['cron_name'=>$cname,'last_run'=>Carbon::now(),'unix_last_run'=>Carbon::now()->timestamp,'status'=>1,'notes'=>'new task created'];
		$id    = \DB::table('cron_manager')->insertGetId($data);
		return TRUE;
	}
	
	

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $cname  = 'game_generate_result';
		 
		
		ob_start();
		$hb = $this->heartbeat();
		
		if (!$hb)
		{
			$this->error('Cron already running.');exit();
		}
		
		$x = 1;
		while($x <= 5) {
			
			$date  = Carbon::now();
			//$chunk =  ['created_at'=>$date,'last_run_end'=>'','last_run_status'=>'stared','notes'=>''];
			//$id    = \DB::table('test')->insertGetId($chunk);
			
			$this->runtask();
			
			//$chunk =  ['last_run_end'=>$date,'last_run_status'=>'end','notes'=>'success'];
			//$idd = \DB::table('test')->where('id', $id)->update($chunk);
			
			$chunk = ['last_run'=>Carbon::now(),'unix_last_run'=>Carbon::now()->timestamp,'status'=>1,'notes'=>'success'];
			\DB::table('cron_manager')->where('cron_name', $cname)->update($chunk);
			$x = 1;
			//$x++;
			if ( ob_get_length() or ob_get_contents() ) 
			{
				$this->error('Cleared Memory Cache.');
				ob_end_clean();
			}			
			sleep(4);
		}		
    }
		
	public function shutdown()
    {
        $this->info('stopping ResultGenerator...');
        $this->run = false;
    }
	
}

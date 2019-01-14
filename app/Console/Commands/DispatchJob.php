<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Game;
use App\CronManager;

class DispatchJob extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cron:dispatch {type=noaction}';
	
	/**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Initiate Cron Process';

    /**
     * Create a new command instance.
     *
     * @return void
     */
	
	public $cronname  = '';
	
	public $timelimit = '30';
	
    public function __construct()
    {
        parent::__construct();
    }
		 
	private function runtask()
	{
		$this->comment('Stared:'.'----------'.Carbon::now()->toDateTimeString().'----------');
		$this->call($this->console, $this->argvm);
		$this->info(' ');			
		$this->info('-------------Waiting for next queue----------');
		$this->info(' ');	
	}
	
	private function heartbeat()
	{
		$row    = \DB::table('cron_manager')->where('cron_name',$this->cronname)->first();
		
		if ($row)
		{
			if ($row->status == 1 || $row->status == 2)
			{
				$this->error('--> Cron already running or hold by another process.');exit();return FALSE;
			}
			
			$data = ['last_run'=>Carbon::now(),'status'=>1,'notes'=>'','unix_last_run'=>Carbon::now()->timestamp,'total_limit'=>$this->tcount];			
			
			\DB::table('cron_manager')
            	->where('cron_name', $this->cronname)
            	->update($data);
			
			return TRUE;			
		}
		$data  = ['cron_name'=>$this->cronname,'last_run'=>Carbon::now(),'unix_last_run'=>Carbon::now()->timestamp,'status'=>1,'notes'=>'new task created'];
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
        $arguments = $this->argument('type');
		
		$cron = CronManager::getcron($arguments);
		
		if (!$cron) { $this->error('New process terminated / Unknown Cron...');exit(); }
		
		ob_start();
		
		$x = 1;
		$this->tcount   = $count = $cron['limit'];
		$this->cronname = $cron['name'];
		$this->console  = $cron['action'];
		$this->argvm    = $cron['argvm'];
		//$count = env('GAME_GENERATOR_COUNT');
		
		if (empty($count) or $count >= 10000 )
		{
			$count = 100;
		}
		
		 
		$this->holdprocess('yes');
		
		while($x <= $count) {
			
			$date  = Carbon::now();
			//$chunk =  ['created_at'=>$date,'last_run_end'=>'','last_run_status'=>'stared','notes'=>''];
			//$id    = \DB::table('test')->insertGetId($chunk);
			
			$this->runtask();
			
			//$chunk =  ['last_run_end'=>$date,'last_run_status'=>'end','notes'=>'success'];
			//$idd = \DB::table('test')->where('id', $id)->update($chunk);
			
			$chunk = ['last_run'=>Carbon::now(),'unix_last_run'=>Carbon::now()->timestamp,'notes'=>'success','processed'=>$x];
			\DB::table('cron_manager')->where('cron_name', $this->cronname)->update($chunk);
			//$x = 1;
			//$x++;
			if ( ob_get_length() or ob_get_contents() ) 
			{
				$this->error('Cleared Memory Cache.');
				ob_end_clean();
			}	
			//sleep(3);
			$this->holdprocess();
			$this->error('--> Disconnecting DB...');
			\DB::disconnect('mysql');
			
			$this->info('Running Count : '.$x.' / '.$count);		
			
			
			$x++;			
			//sleep(1);
			
			$this->successrun = Carbon::now()->toDateTimeString(); 
		}
		$this->error('--> Reached Maximum routine...');
		$this->shutdown('Stopped on success');
		
    }
	
	public function getcronmanager($status = FALSE)
	{
		$row  = \DB::table('cron_manager')->where('cron_name',$this->cronname);
		
		if ($status) $row->where('status',$status);
		
		$result = $row->first();
		
		return $result;		
	}
	
	public function holdprocess($heartbeat = FALSE)
	{
		if ($heartbeat) $this->heartbeat();
		
		$this->line('--> cheking cron status');
		$x = 1;
		while($x <= 5) {				

			$row = $this->getcronmanager();
						
			if ($row) 
			{
				if ($row->status == 2)
				{
					$x = 1;
					$this->info('process on Hold..');					
					$finishTime = Carbon::now() ;
					$totalDuration = $finishTime->diffInSeconds($this->successrun);
					if ($totalDuration >= $this->timelimit)
					{
						$this->error('--> Time Limit Exceeded. process going to kill itself');
						$this->shutdown();
					}
					sleep(10);
				}
				elseif ($row->status == 3)
				{
					$this->error('--> Stopped by Admin');
					$this->shutdown('Stopped by Admin');
				}
				elseif ($row->status == 4)
				{
					$x = 1;
					$this->info('--> cron on reset mood..');
					$this->heartbeat();
					$this->info('--> cron reseted to active');
					return;
				}
				else{
					$x = 10;
					return;
				}
			}
		}		
	}
		
	public function shutdown($notes = 'Stopped by cron')
    {
        $this->info('--> stopping ResultGenerator...');	
        $this->run = false;
		//Stopping Result Generator
		$data = ['last_run'=>Carbon::now(),'status'=>3,'notes'=>$notes,'unix_last_run'=>Carbon::now()->timestamp];			
			
		\DB::table('cron_manager')
			->where('cron_name', $this->cronname)
			->update($data);
		$this->info('--> Process killed itself');	
		die();
    }
	
}

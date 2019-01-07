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
    protected $description = 'Process Game results';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }
		 
	private function runtask()
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
			if ($row->status == 1 || $row->status == 2)
			{
				$this->error('--> Cron already running or hold by another process.');exit();return FALSE;
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
		
		$x = 1;
		
		$this->holdprocess('yes');
		
		while($x <= 5) {
			
			$date  = Carbon::now();
			//$chunk =  ['created_at'=>$date,'last_run_end'=>'','last_run_status'=>'stared','notes'=>''];
			//$id    = \DB::table('test')->insertGetId($chunk);
			
			$this->runtask();
			
			//$chunk =  ['last_run_end'=>$date,'last_run_status'=>'end','notes'=>'success'];
			//$idd = \DB::table('test')->where('id', $id)->update($chunk);
			
			$chunk = ['last_run'=>Carbon::now(),'unix_last_run'=>Carbon::now()->timestamp,'notes'=>'success'];
			\DB::table('cron_manager')->where('cron_name', $cname)->update($chunk);
			$x = 1;
			//$x++;
			if ( ob_get_length() or ob_get_contents() ) 
			{
				$this->error('Cleared Memory Cache.');
				ob_end_clean();
			}	
			sleep(3);
			$this->holdprocess();
			$this->error('--> Disconnecting DB...');
			\DB::disconnect('mysql');
			sleep(1);
		}		
    }
	
	public function getcronmanager($cname = 'game_generate_result' , $status = FALSE)
	{
		$row  = \DB::table('cron_manager')->where('cron_name',$cname);
		
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

			$row = $this->getcronmanager('game_generate_result');
						
			if ($row) 
			{
				if ($row->status == 2)
				{
					$x = 1;
					$this->info('cron on Hold..');
					sleep(10);
				}
				elseif ($row->status == 3)
				{
					$this->info('--> stopping ResultGenerator...');
					$this->error('--> process killed itself...');
					die();
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
		
	public function shutdown()
    {
        $this->info('stopping ResultGenerator...');
        $this->run = false;
    }
	
}

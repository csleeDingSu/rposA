<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use App\Game;
use Validator;
use App\Wallet;
use App\member_game_result;
use App\member_game_bet_temp;

use App\member_game_notification;
use App\Package;

use App\Http\Controllers\RedisGameController;
use App\Events\EventGameSetting ;

class open_draw extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'game:opendraw {drawid=0}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Open new draw for all conencted Members';

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
        
		$this->comment('Stared:'.'----------'.Carbon::now()->toDateTimeString().'----------');	
		
		$drawid = $this->argument('drawid');
        $now           = Carbon::now();
        if ($drawid == '0') $drawid   = 6666;		
		
		$draw =  \DB::table('game_result')->select('id as result_id','game_id','game_level_id','created_at','expiry_time','game_result')->where('id', '=', $drawid)->first();		
		
		if (!$draw) dd('unknown draw');		
		$this->info('Draw ID :'.'--------'.$drawid.'----------');
		
		$gamesetting   = $ReportController->get_game_setting($draw , $now); 
		event(new \App\Events\EventDynamicChannel('activedraw','',$gamesetting));
		
		$gameid = $draw->game_id;
		$event_data = [];
		$mers = \DB::table('redis')->select('member_id')->get();
		$ReportController = new RedisGameController(); 
        				
		if ($mers)
		{			
			$setting       = \App\Admin::get_setting();
			$now           = Carbon::now();
			$latest_result = Game::get_latest_result($draw->game_id);
			//$futureresult  = Game::get_future_result($draw->game_id, $now );
			
			$gamehistory   = $ReportController->get_game_history($draw->game_id);			
			$this->comment('Get Data:'.'--------'.Carbon::now()->toDateTimeString().'----------');	
			foreach ($mers as $key => $val)
			{
				$memberid = $val->member_id;
				$vip = '';
				$level            = Game::get_member_current_level($gameid, $memberid, $vip);
				$consecutive_lose = Game::get_consecutive_lose($memberid,$gameid, $vip);
				
				$vip = 'yes';
				$vip_level        = Game::get_member_current_level($gameid, $memberid, $vip);
				$vip_con_lose     = Game::get_consecutive_lose($memberid,$gameid, $vip);
				
				$gamenotific      = $ReportController->get_game_notification($key,$draw->game_id);
				
				$data         = [ 'member'               => $memberid, 
								  'drawid'               => $draw->result_id, 
								 // 'futureresults'		 => $futureresult,
								  'wabaofee' 			 => $setting->wabao_fee,
								  'latest_result' 		 => $latest_result,
								  'gamesetting' 		 => $gamesetting,
								  'gamehistory' 		 => $gamehistory,
								  'level'				 => $level,
								  'viplevel' 			 => $vip_level,
								  'consecutive_lose'     => $consecutive_lose,
								  'vip_consecutive_lose' => $vip_con_lose
								];
				$event_data[$val->member_id] = 	$data ;	

				$channel[] = 'initsetting-'.$val->member_id;
				$message[] = $data ;	
			}
		}
			
			
		//foreach (array_chunk($event_data,500) as $key=>$val) {
		//   print_r($key);
		   //die();
		//}

				
		foreach (array_chunk($event_data,500) as $keyc=>$event) {
			foreach ($event as $val)
			{
			   //print_r($val);die();
			   event(new \App\Events\EventGameSetting($val['member'],$val));
			   $this->line('yes--'.$val['member']);
			}		   
		}
		

		$this->line('End:'.'-------------'.Carbon::now()->toDateTimeString().'----------');
		
		$this->info('-------------All done----------');
		
		$result =  \App\Report::game_win_lose();
		event(new \App\Events\EventDynamicChannel('dashboard-gameinfo','',$result));
		event(new \App\Events\EventDashboardChannel('master-reset',['type'=>'reset']));
    }
	
}












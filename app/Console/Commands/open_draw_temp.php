<?php

namespace App\Console\Commands;

use App\Events\EventGameSetting ;
use App\Game;
use App\Http\Controllers\RedisGameController;
use App\OpenDrawPre;
use App\Package;
use App\Wallet;
use App\member_game_bet_temp;
use App\member_game_notification;
use App\member_game_result;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Session;
use Validator;

class open_draw_temp extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'game:open_draw_temp {drawid=0}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'temp Open new draw for all conencted Members';

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
  //       $now           = Carbon::now();
  //       if ($drawid == '0') $drawid   = 6666;		
		
		// $draw =  \DB::table('game_result')->select('id as result_id','game_id','game_level_id','created_at','expiry_time','game_result')->where('id', '=', $drawid)->first();		
		
		// if (!$draw) dd('unknown draw');		
		// $this->info('Draw ID :'.'--------'.$drawid.'----------');
		// $ReportController = new RedisGameController(); 
		// $latest_result = Game::get_latest_result($draw->game_id);
		// $gamesetting   = $ReportController->get_game_setting($draw , $now); 
		// // event(new \App\Events\EventDynamicChannel('activedraw','',['gamesetting'=>$gamesetting,'latest_result'=>$latest_result]));
		
		// $gameid = $draw->game_id;
		// $event_data = [];
		// $mers = \DB::table('redis')
		// 	->join('v_oauth_access_tokens', 'v_oauth_access_tokens.user_id', '=', 'redis.member_id')
		// 	->where('v_oauth_access_tokens.expires_at', '>=', Carbon::now())
		// 	->select('redis.member_id')
		// 	->get();		
        				
		// if ($mers)
		// {	
		// 	$setting       = \App\Admin::get_setting();
		// 	$now           = Carbon::now();
			
		// 	//$futureresult  = Game::get_future_result($draw->game_id, $now );
			
		// 	$gamehistory   = $ReportController->get_game_history($draw->game_id);			
		// 	$this->comment('Get Data:'.'--------'.Carbon::now()->toDateTimeString().'----------');	
		// 	foreach ($mers as $key => $val)
		// 	{

		// 		var_dump($val->member_id);

		// 		$memberid = $val->member_id;
		// 		$vip = '';
				
		// 		$level            = Game::get_member_current_level($gameid, $memberid, $vip);
		// 		$consecutive_lose = Game::get_consecutive_lose($memberid,$gameid, $vip);
				
		// 		$vip = 'yes';
		// 		$vip_level        = Game::get_member_current_level($gameid, $memberid, $vip);
		// 		$vip_con_lose     = Game::get_consecutive_lose($memberid,$gameid, $vip);
				
		// 		$gamenotific      = $ReportController->get_game_notification($key,$draw->game_id);
		// 		/*
		// 		$gamenotific = '';
		// 		$consecutive_lose = [];
		// 		$level = [];
		// 		$vip_level = [];
		// 		$vip_con_lose = [];
		// 		*/
				
		// 		$data         = [ 'member'               => $memberid, 
		// 						  'drawid'               => $draw->result_id, 
		// 						 // 'futureresults'		 => $futureresult,
		// 						  'wabaofee' 			 => $setting->wabao_fee,
		// 						  'latest_result' 		 => $latest_result,
		// 						  'gamesetting' 		 => $gamesetting,
		// 						  'gamehistory' 		 => $gamehistory,
		// 						  'level'				 => $level,
		// 						  'viplevel' 			 => $vip_level,
		// 						  'consecutive_lose'     => $consecutive_lose,
		// 						  'vip_consecutive_lose' => $vip_con_lose
		// 						];
		// 		$event_data[$val->member_id] = 	$data ;	

		// 		$channel[] = 'initsetting-'.$val->member_id;
		// 		$message[] = $data ;	
		// 	}
			
		// 	$this->comment('End fetch Data:'.'--------'.Carbon::now()->toDateTimeString().'----------');	
		// }
			
			
		//foreach (array_chunk($event_data,500) as $key=>$val) {
		//   print_r($key);
		   //die();
		//}

		$result =  OpenDrawPre::select('*')->whereNull('deleted_at')->first();

		if (!empty($result)) {

			$event_data = json_decode($result->event_data,true);

			foreach (array_chunk($event_data,100) as $keyc=>$event) {
				foreach ($event as $val)
				{
				   //print_r($val);die();
				   event(new \App\Events\EventGameSetting($val['member'],$val));
				   $this->line('yes--'.$val['member']);
				}		   
			}

			$result = OpenDrawPre::where('id', $result->id)->update(['deleted_at' => Carbon::now()->toDateTimeString()]);		
		}
		
		$this->line('End:'.'-------------'.Carbon::now()->toDateTimeString().'----------');
		
		$this->info('-------------All done----------');
		
		$result =  \App\Report::game_win_lose();
		event(new \App\Events\EventDynamicChannel('dashboard-gameinfo','',$result));
		event(new \App\Events\EventDashboardChannel('master-reset',['type'=>'reset']));
    }
	
}












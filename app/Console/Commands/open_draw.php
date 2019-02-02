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
        
        if ($drawid == '0') $drawid = 66487;		
		
		//$drawid = 5676  ;
		
		$draw =  \DB::table('game_result')->where('id', '=', $drawid)->first();		
		
		if (!$draw) dd('unknown draw');		

		$gameid = $draw->game_id;

		$mers = \DB::table('redis')->select('member_id')->get();
		$ReportController = new RedisGameController(); 
        				
		if ($mers)
		{			
			$setting       = \App\Admin::get_setting();
			$now           = Carbon::now();
			$latest_result = Game::get_latest_result($draw->game_id);
			$futureresult  = Game::get_future_result($draw->game_id, $now );
			$gamesetting   = $ReportController->get_game_setting($draw , $now); 
			$gamehistory   = $ReportController->get_game_history($draw->game_id);			
			
			foreach ($mers as $key => $val)
			{
				$memberid = $val->member_id;
				$vip = '';
				$level            =  Game::get_member_current_level($gameid, $memberid, $vip);
				$consecutive_lose = Game::get_consecutive_lose($memberid,$gameid, $vip);
				$gamenotific      = $ReportController->get_game_notification($key,$draw->game_id);
				
				$data         = ['drawid'=> $draw->id, 'futureresults' => $futureresult,'wabaofee' => $setting->wabao_fee,'setting' => $setting,'latest_result' => $latest_result,'gamesetting' => $gamesetting,'gamehistory' => $gamehistory];

				//print_r($data);die();
				event(new \App\Events\EventGameSetting($val->member_id,$data)); //@todo:-move to outisde of the loop

				$this->line('yes--');
			}
		}
			
		$this->line('End:'.'-------------'.Carbon::now()->toDateTimeString().'----------');
		
		$this->info('-------------All done----------');
    }
	
}












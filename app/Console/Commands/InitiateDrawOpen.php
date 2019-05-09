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




use App\Events\Event;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class InitiateDrawOpen extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'draw:initiate {drawid=0}';

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
	
	public function test()
	{
		$this->info('imhere');
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
		$ReportController = new RedisGameController(); 
		$latest_result    = Game::get_latest_result($draw->game_id);
		$gamesetting      = $ReportController->get_game_setting($draw , $now); 
		$gamehistory      = $ReportController->get_game_history($draw->game_id);
		
		event(new \App\Events\EventDynamicChannel('activedraw','',['gamesetting'=>$gamesetting,'latest_result'=>$latest_result,'gamehistory'=>$gamehistory,'draw'=>$draw]));
		
		$gameid     = $draw->game_id;
		$event_data = [];
		$mers       = \DB::table('redis')->select('member_id')->count();
		
		$offset_limit = 10;
		
		$this->comment( $mers );
		$round = ceil ( $mers  / $offset_limit);
		$this->comment( $round );
		$i = 0;
		$mround = $round;
		//$drawid = 163596;
		
		do 
		{
			$lmt = $i*$offset_limit;
			if ($lmt<$mers) 
			{			
				$limit  = $lmt.'-'.$offset_limit  ;
				$this->info( $limit);  
				$pipe[$i] = popen('php artisan draw:open '.$limit.'-'.$drawid , 'w'); //dont change anything here
			}
			$i++;
		} 
		while ($i <= $round);	
		
		for ($m=0; $m<$i; ++$m) {
			pclose($pipe[$m]);
		}		
		
		$result =  \App\Report::game_win_lose();
		event(new \App\Events\EventDynamicChannel('dashboard-gameinfo','',$result));
		event(new \App\Events\EventDashboardChannel('master-reset',['type'=>'reset']));
		return true;
    }
	
}












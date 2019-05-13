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
class vip_result extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:vip_result {drawid=0}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate the VIP Game result every day';

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
		
		$broadcast_channel = [];
		
		$drawid = $this->argument('drawid');
        
        if ($drawid == '0') $drawid = 1546;  
		
		sleep(1); //fix for last sec betting
		/*
		//Testing
		$now      = Carbon::now()->toDateTimeString();
		$drawid   = Game::get_current_result(101, $now);		
		$this->info('DrawID:'.$drawid);
		//End
		*/
			
		$bettinglist =  member_game_bet_temp::where('drawid', $drawid)->where('gametype', 2)->get() ;		
		
		$current_result = Game::get_single_gameresult($drawid);
		
		$memid = [];
		$out   = [];
 
        foreach ($bettinglist as $row) {
			$result  = $this->GenerateBettingResult($row, $current_result);
			
			$out[$row->memberid] = $result;
			
			$memid[] = $row->memberid;						
        }
 					
		
		foreach ($out as $key=> $re)
		{
			$this->line('event key'. $key);
			event(new \App\Events\EventVIPBetting($key, $re));
		}
		
		$game_result = !empty($current_result->game_result) ? $current_result->game_result  : '' ;
		$gresult = ['game_result' => $game_result];
				
		$mers = \DB::table('redis')->select('member_id')->whereNotIn('member_id', $memid)->get();
				
				
		if ($mers)
		{
			foreach ($mers as $key => $val)
			{
				$broadcast_channel[] = 'no-vipbetting-user-'.$val->member_id;
			}
			event(new \App\Events\EventNoBetting($broadcast_channel, $gresult,'vip'));
		}
		
		$this->line('End:'.'-------------'.Carbon::now()->toDateTimeString().'----------');
		
		$this->info('-------------All done----------');
    }
	
	public function play_vip_game($vipdata)
    { 
		$point        = 0;
		$reward       = 0;
		$glevel       = '';
		$status       = 'lose';
		$is_win       = null;
		$player_level = 1;
		$close        = null;
		$memberid     = $vipdata['memberid'];
		$gameid       = $vipdata['gameid'];
		$level	      = $vipdata['gamelevel'];
		$bet          = $vipdata['bet'];
		$game_result  = $vipdata['game_result'];
		$drawid       = $vipdata['drawid'];
		
		
		$packageid = Package::get_current_package($memberid);		
		
		if (!$packageid)
		{
			$this->error('No active vip subscriptions');
			return ['success' => false, 'game_result' => $game_result,'message' => 'No active vip subscriptions'];
		}
				
		//check playable status
		$wallet = Wallet::get_wallet_details($memberid);
		
		if ($wallet->vip_life < 1) 
		{
			$this->error('not enough life to play');
			return response()->json(['success' => false, 'game_result' => $game_result,'message' => 'not enough life to play']);
		}
		
		if ($wallet->vip_point < $level->bet_amount) 
		{
			$this->error('not enough points to play');
			return response()->json(['success' => false, 'game_result' => $game_result,'message' => 'not enough points to play']);
		}
		
		//check game result
		
		/**
		 * if player & histoy win the increse to 1
		 * if player fail keep the value 
		 **/		

		$game_p_level = $this->get_player_level($gameid, $memberid, $player_level, $level,1);

		$gamelevel    = $game_p_level['gamelevel'];
		$player_level = $game_p_level['player_level'];

		$gen_result  = check_odd_even($game_result);
		if ($gen_result === $bet)
		{
			$status = 'win';
			$is_win = TRUE;	
		}	
		
		//update wallet
		
		if ($is_win) 
		{
			$wallet = Wallet::update_vip_wallet($memberid,$life = 0,$level->bet_amount,'VIP');
			$reward = $level->point_reward;
			$this->info('User Win');
		}
		else
		{
			$this->error('User Lose');
			$wallet = Wallet::update_vip_wallet($memberid,$life = 0,$level->bet_amount,'VIP','debit');
		}
			
		//update game history
		if ($wallet)
			{
				//Update Memeber game play history		
				$now     = Carbon::now()->toDateTimeString();
					
				$insdata = ['member_id'=>$memberid,'game_id'=>$gameid,'game_level_id'=>$gamelevel,'is_win'=>$is_win,'game_result'=>$status,'bet_amount'=>$level->bet_amount,'bet'=>$bet,'game_result'=>$game_result,'created_at'=>$now,'updated_at'=>$now,'player_level'=>$player_level, 'draw_id' => $drawid,'reward' => $reward,'package_id'=>$packageid->id];				
				
				$records =  Game::add_vip_play_history($insdata);
			
				if (!$is_win) 
				{
					$close  = Game::get_consecutive_lose($memberid, $gameid,'1');
					//echo 	$close ;
					if ($close == 'yes') {
						Wallet::update_vip_wallet($memberid,1,0,'VIP','debit');
						Game::reset_member_game_level($memberid , $gameid,'1');			
						$point = Wallet::merge_vip_wallet($memberid,'','nofee');									
						Package::reset_current_package($packageid->id);
						$this->error('User Consecutive Lose');
					}
				}
				$result = Game::get_betting_history_grouped($gameid, $memberid, 'vip');
                event(new \App\Events\EventVipBettingHistory($result,$memberid));
				$this->info('Event Triggerd');
				return ['success' => true, 'status' => $status, 'game_result' => $game_result,'mergepoint' => $point,'consecutive_loss'=>$close]; 
			}
	}
	
	public function GenerateBettingResult($row, $current_result)
    {	
		$now     = Carbon::now()->toDateTimeString();
		$reward = 0;
		$glevel = '';
		$status = 'lose';
		$is_win = null;
		$player_level = 1;	
		$type = 1;
		$gameid   = $row->gameid;
		$memberid = $row->memberid;
		$drawid   = $row->drawid;
		$bet      = $row->bet;
		$betamt   = $row->betamt;	
		$type     = $row->gametype;			
		$vip      = '';
		$table    = 'member_game_result';
		
		if ($type == 2) {
			$table = 'vip_member_game_result';
			$vip = 'yes';
			$this->info( 'vip' );  
			//return ;
		}
		
		
		
		$input = [
             'gameid'    => $gameid,
			 'memberid'  => $memberid,
			 'drawid'    => $drawid,
			 'bet'       => $bet,	
			 'betamt'    => $betamt,
			 'cdrawid'   => $drawid,
              ];
		//Check current bet request match with server draw result - fixed on 12/11/2018
		$validator = Validator::make($input, 
            [
                'gameid'   => 'required|exists:games,id',
				'memberid' => 'required|exists:members,id',
				'drawid'   => 'required|exists:game_result,id',
				'cdrawid'  => "unique:$table,draw_id,NULL,id,game_id,$gameid,member_id,$memberid",
            ],
			['cdrawid.unique' => 'user already played the game']
        );
		
		
		$game_result = !empty($current_result->game_result) ? $current_result->game_result  : '' ;
		
		
		if ($validator->fails()) {
			$this->error( 'validation error' );  
			return ['success' => false, 'game_result' => $game_result, 'message' => $validator->errors()->all()];		
		}
		
		//If empty then return the game result only
		if (empty($bet) || empty($memberid))
		{
			$this->error('no betting'); 
			return ['success' => false, 'game_result' => $game_result, 'message' => 'no betting'];
		}
		
		$gamelevel = Game::get_member_current_level($gameid, $memberid, $vip);
		
				
		$levelid = $gamelevel->levelid;
		
		$vipdata['memberid']    = $memberid;
		$vipdata['gameid']      = $gameid;
		$vipdata['gamelevel']   = $gamelevel;
		$vipdata['bet']         = $bet;
		$vipdata['game_result'] = $game_result;
		$vipdata['drawid']      = $drawid;
		
		if ($vip) return $this->play_vip_game($vipdata);
	}
	
	
	public function get_player_level($gameid, $memberid, $player_level,$gamelevel,$vip = FALSE)
	{	
		$level     = Game::get_player_level($gameid, $memberid,$vip );
		
		if ($level) 
		{
			$player_level = $level->player_level;
			//if the user previously win then add a increment
			if ($level->is_win == 1)
			{					
				$player_level++;
			}
			else{
				if (!empty($gamelevel->is_reseted))
				{
					$player_level++;
				}
			}
		}
		return array ('player_level'=>$player_level,'gamelevel'=>$gamelevel->levelid );
	}
	
	
	public function update_notification($memberid, $gameid, $flag)
    {
        $params = [ 'memberid' => $memberid, 'gameid' => $gameid ];		
        $record = member_game_notification::firstOrNew( $params );
        $record->flag_status = $flag;
        $record->memberid    = $memberid;
        $record->gameid      = $gameid;
        $record->save();
        return true;
    }
}












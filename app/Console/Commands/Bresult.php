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
class Bresult extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:br {drawid=0}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate the Game result every day';

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
        
        if ($drawid == '0') $drawid = 1546;  
		
		sleep(1); //fix for last sec betting
		
		$bettinglist =  v_member_game_bet_temp::where('drawid', $drawid)->where('gametype', 1)->get() ;

		
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
			echo 'here-'. $key;
			event(new \App\Events\EventBetting($key, $re));
		}
		
		$game_result = !empty($current_result->game_result) ? $current_result->game_result  : '' ;
		$gresult = ['game_result' => $game_result];
				
		$mers = \DB::table('redis')
			->join('members', 'members.id', '=', 'redis.member_id')
			->whereDate('members.updated_at', Carbon::today())
			->whereNotIn('member_id', $memid)
			->select('member_id')
			->get();
				
		if ($mers)
		{
			foreach ($mers as $key => $val)
			{
				$broadcast_channel[] = 'no-betting-user-'.$val->member_id;
			}
			event(new \App\Events\EventNoBetting($broadcast_channel, $gresult));
		}
		
		$this->line('End:'.'-------------'.Carbon::now()->toDateTimeString().'----------');
		
		$this->info('-------------All done----------');
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
		$firstwin = '';
		
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
		
		$res = Wallet::playable_status($memberid,$gameid,$levelid);
		$is_playable = $res['playablestatus'];	
		$is_redeemable = $res['redeempointstatus'];

		if ($res['life']<1)
		{
			$this->error('not enough life to play'); 
			return ['success' => false, 'game_result' => $game_result,'message' => 'not enough life to play'];
			
		}
		if (empty($is_playable)&&empty($is_redeemable))// 0
		{
			$this->error('not enough balance to play'); 
			return ['success' => false, 'game_result' => $game_result,'message' => 'not enough balance to play'];
			
		}elseif (empty($is_playable)&&!empty($is_redeemable))//1
		{
			$this->error('exceeded the coin limit'); 
			return ['success' => false, 'game_result' => $game_result,'message' => 'exceeded the coin limit'];
		}		
		else{
			/**
			 * if player & histoy win the increse to 1
			 * if player fail keep the value 
			 **/		
			
			$game_p_level = $this->get_player_level($gameid, $memberid, $player_level, $gamelevel);
			
			$gamelevel    = $game_p_level['gamelevel'];
			$player_level = $game_p_level['player_level'];
			
			$gen_result  = check_odd_even($game_result);
			
			
			//$gen_result  = 'even';
			if ($gen_result === $bet)
			{
				//win change balance
				$status = 'win';
				$is_win = TRUE;				
			}			
			
			//Add wallet update functions 				
			//$wallet = '100';
			$wallet = Wallet::game_walletupdate ($memberid, $gameid, $status, $gamelevel);
			
			$level = \DB::table('game_levels')->where('id', $gamelevel)->get()->first();
			
					
			if ($wallet)
			{
				
				if ($wallet['status'] =='win')
				{
					$this->info('win');
					//check first life win
					$firstwin = \App\Product::IsFirstWin($memberid,'win');
				}
				else 
				{
					$this->error('lose');
					$firstwin = \App\Product::IsFirstWin($memberid,'lose');
				}
				
				$this->info('success');
				
				//return ['status' => $status, 'game_result' => $game_result];
				
				//Update Memeber game play history		
				$now     = Carbon::now()->toDateTimeString();
				
				if ($wallet['status'] =='win') $reward = $level->point_reward;
				
					
				$insdata = ['member_id'=>$memberid,'game_id'=>$gameid,'game_level_id'=>$gamelevel,'is_win'=>$is_win,'game_result'=>$status,'bet_amount'=>$level->bet_amount,'bet'=>$bet,'game_result'=>$current_result->game_result,'created_at'=>$now,'updated_at'=>$now,'player_level'=>$player_level, 'draw_id' => $drawid,'wallet_point' => $wallet['point'],'reward' => $reward];
				
				
				$filter = ['member_id'=>$memberid,'game_id'=>$gameid,'draw_id' => $drawid];		

				$records =  Game::add_play_history($insdata,$filter);
				
                if ($wallet['acupoint'] >= 150 ) $this->update_notification($memberid, $gameid,'0');
				
				
				$result = Game::get_betting_history_grouped($gameid, $memberid, '');
                event(new \App\Events\EventBettingHistory($result,$memberid));
				
				return ['success' => true, 'status' => $status, 'game_result' => $game_result,'IsFirstLifeWin' => $firstwin]; 
			}
			
			return ['success' => false, 'message' => 'not enough points to play']; 
		}
		
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












<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Game;
use Validator;
use Carbon\Carbon;
use App\Wallet;
use App\member_game_result;
use App\member_game_bet_temp;

use App\member_game_notification;
use App\Package;

use App\Ledger;


class BackupController extends Controller
{
	
	public function betting_result(Request $request)
    {
		$now     = Carbon::now()->toDateTimeString();
		$reward = 0;
		$glevel = '';
		$status = 'lose';
		$is_win = null;
		$player_level = 1;	
		$type       = 1;
		$vip        = '';
		$gameid     = $request->gameid;
		$memberid   = $request->memberid;
		
		
		
		$res = member_game_bet_temp::whereNull('deleted_at')->where('gameid', $gameid)->where('memberid', $memberid)->where('gametype', $type)->first();	
		
		if(!$res)
		{
			return response()->json(['success' => false, 'message' => trans('dingsu.no_active_betting') ]);
		}
		
		//check point 
		
		$gamelevel = Game::get_member_current_level($gameid, $memberid, $vip);		
				
		$levelid = $gamelevel->levelid;
		
		$play_status   = Wallet::playable_status($memberid,$gameid,$levelid);
		$is_playable   = $play_status['playablestatus'];	
		$is_redeemable = $play_status['redeempointstatus'];
		
		if ($play_status['point']<1)
		{
			//return ['success' => false, 'message' =>  trans('dingsu.not_enough_point') ];			
		}
		
		if ($play_status['life']<1)
		{
			return response()->json(['success' => false,'message' => trans('dingsu.not_enough_life')]);
			
		}
		if (empty($is_playable)&&empty($is_redeemable))// 0
		{
			return response()->json(['success' => false, 'message' => trans('dingsu.not_enough_balance')]);
			
		}elseif (empty($is_playable)&&!empty($is_redeemable))//1
		{
			return response()->json(['success' => false, 'message' => trans('dingsu.exceeded_coin_limit')]);
		}
		
		
					
		$bet      = $res->bet;	
		$betamt   = $res->betamt ;
		$gametype = $res->gametype ;
	
		$input = [
             'gameid'    => $gameid,
			 'memberid'  => $memberid,
			 'bet'       => $bet,	
			 'betamt'    => $betamt,
              ];
		
		
		$player_level = 1;
		
		$gamelevel = Game::get_member_current_level($gameid, $memberid, $vip); 
		
		$data = ['player_level'=>$player_level, 'gamelevel'=>$gamelevel];
		//$wallet = Wallet::get_wallet_9details_all($memberid);
		
		$game_p_level = $this->get_player_level($gameid, $memberid, $player_level, $gamelevel);
			
		$gamelevel    = $game_p_level['gamelevel'];
		$player_level = $game_p_level['player_level'];
		
		
		$gameresult   = $this->decide_result_condition($memberid, $data);
			
		if ($gameresult)
		{
			$status = $gameresult->status;
			$is_win = $gameresult->is_win;
			
			$arr_even = ['2','4','6'];
			$arr_odd  = ['1','3','5'];
			
			if ($bet == 'even')
			{
				if($status === 'win')
				{
					$game_result = $arr_even [ array_rand($arr_even,1) ];
				}
				else
				{
					$game_result = $arr_odd [ array_rand($arr_odd,1) ];
				}
			}
			else
			{
				if($status === 'win')
				{
					$game_result = $arr_odd [ array_rand($arr_odd,1) ];
				}
				else
				{
					$game_result = $arr_even [ array_rand($arr_even,1) ];
				}				
			}
		}
		else 
		{				
			$game_result = generate_random_number(1,6);	
			
			$gen_result  = check_odd_even($game_result);
			//$gen_result  = 'evsn';
			if ($gen_result === $bet)
			{
				//win change balance
				$status = 'win';
				$is_win = TRUE;				
			}
		}	
		
		
		/*if ($memberid == 30)
		{
			$status = 'lose';
			$is_win = null;
		}
		*/

		$level = \DB::table('game_levels')->where('id', $gamelevel)->get()->first();
		//Update Memeber game play history		
		$now     = Carbon::now()->toDateTimeString();		
		
		///$status = 'lose';
		
		$wallet   = Wallet::new_game_wallet_update ($memberid,  $status, $level, $gameid);
		
		$r_status = 2;
		
		if ($status == 'win') 			
		{
			$reward = $wallet['credit'];
			
			$r_status = 1;
			
			if ($wallet['acupoint'] >= \Config::get('app.coin_max') ) $this->update_notification($memberid, $gameid,'0');
		}		

		$insdata = ['member_id'=>$memberid,'game_id'=>$gameid,'game_level_id'=>$gamelevel,'is_win'=>$is_win,'bet_amount'=>$level->bet_amount,'bet'=>$bet,'game_result'=>$game_result,'created_at'=>$now,'updated_at'=>$now,'player_level'=>$player_level,'reward' => $reward];		

		$filter = ['member_id'=>$memberid,'game_id'=>$gameid];		

		$records =  Game::add_play_history($insdata,$filter);
		
		$res->status     = 1;
		$res->deleted_at = $now;
		$res->save();
		
		//Play count update - 29/05/2019
		//Fixed multiple row updates - 14/08/2019
		$playcount = \App\PlayCount::firstOrCreate(['play_date' => Carbon::now()->toDateString(), 'member_id' => $memberid, 'game_id' => $gameid, 'result_status' => $r_status]);		
		if (!$playcount->wasRecentlyCreated) {			
			$playcount->increment('play_count', 1);
		}
		//End
		
		$firstwin = \App\Product::IsFirstWin($memberid,$status);

		return response()->json(['success' => true, 'status' => $status, 'game_result' => $game_result,'IsFirstLifeWin' => $firstwin]);
	}
	
}
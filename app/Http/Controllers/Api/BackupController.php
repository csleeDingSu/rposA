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
		
		
		if (!$packageid) return response()->json(['success' => false, 'game_result' => $game_result,'message' => 'No active vip subscriptions']);
		
		
		//check playable status
		$wallet = Wallet::get_wallet_details($memberid);
		
		if ($wallet->vip_life < 1) return response()->json(['success' => false, 'game_result' => $game_result,'message' => 'not enough life to play']);
		
		if ($wallet->vip_point < $level->bet_amount) return response()->json(['success' => false, 'game_result' => $game_result,'message' => 'not enough points to play']);
		
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
		}
		else
		{
			
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
						$point = Wallet::merge_vip_wallet($memberid);									
						Package::reset_current_package($packageid->id);
					}
				}
                				
				return response()->json(['success' => true, 'status' => $status, 'game_result' => $game_result,'mergepoint' => $point,'consecutive_loss'=>$close]); 
			}
	}
	
	public function new_update_game(Request $request)
    {
		//check game type 
		
		//get rules
		
		//play with rules
		
		//route to wallet update 
		
		//route to game play update
		
		//return statements
		
	}
	
	public function new_betting_result_103(Request $request)
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
			return response()->json(['success' => false, 'message' => "no betting"]);
		}	
		$bet      = $res->bet;	
		$betamt   = $res->betamt ;
		$gametype = $res->gametype ;
		
		$packageid = Package::get_current_package($memberid);		
		
		if (!$packageid) return response()->json(['success' => false,'message' => 'No active vip subscriptions']);
		
		
		//check point 
				
		$play_status   = Wallet::get_wallet_details($memberid);
		
		if ($play_status->vip_point<1)
		{
			return ['success' => false, 'message' => 'not enough point'];			
		}
		
		if ($play_status->vip_point< $betamt )
		{
			return ['success' => false, 'message' => 'not enough point'];			
		}
				
		if ($play_status->vip_life<1)
		{
			return response()->json(['success' => false,'message' => 'not enough life to play']);			
		}
		
		
	
		$input = [
             'gameid'    => $gameid,
			 'memberid'  => $memberid,
			 'bet'       => $bet,	
			 'betamt'    => $betamt,
              ];
		
			
		$gameresult   = $this->decide_result_condition($memberid, '');
			
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
		
		//Update Memeber game play history		
		$now     = Carbon::now()->toDateTimeString();
		
		
		$r_status = 2;
		
		if ($status == 'win') 			
		{
			$reward = 0;
			
			//$se_game  = \App\Game::where('id',$gameid)->first();
			
			$se_game  = \App\Game::gamesetting($gameid);
			
			if (!empty($se_game->win_ratio))
			{	
				if ($se_game->win_ratio < 1)
				{
					$se_game->win_ratio = 1;
				}				
				$reward = $betamt * $se_game->win_ratio;
				
				$reward = $reward - $betamt;
			}
			
			//Wallet::update_basic_wallet($memberid,0,$betamt,'GBV','credit', '.reward for betting');	//GBV - Game Betting VIP	
			
			Wallet::update_vip_wallet($memberid,0,$betamt,'GBV','credit', '.reward for betting');
		}	
		else
		{
			//Wallet::update_basic_wallet($memberid,0,$betamt,'GBV','debit', '.deducted for betting');	//GBV - Game Betting VIP
			
			$wallet = Wallet::update_vip_wallet($memberid,0,$betamt,'GBV','debit', '.deducted for betting');
			//reset life if point 0
			if ($wallet['point'] < 1)
			{
				Wallet::update_vip_wallet($memberid,1,0,'VIP','debit');		
				
				Package::reset_current_package($packageid->id);
			}
			
		}
				

		$insdata = ['member_id'=>$memberid,'game_id'=>$gameid,'is_win'=>$is_win,'bet_amount'=>$betamt,'bet'=>$bet,'game_result'=>$game_result,'created_at'=>$now,'updated_at'=>$now,'reward' => $reward];

		$records =  Game::add_play_history($insdata);
		
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
		$firstwin = '';
		//$firstwin = \App\Product::IsFirstWin($memberid,$status);

		return response()->json(['success' => true, 'status' => $status, 'game_result' => $game_result,'IsFirstLifeWin' => $firstwin]);
	}
	
	public function old_list_user_by_earned_point(Request $request)
    {
				
		//Global Ranks
		$select = \DB::raw("@i := coalesce(@i + 1, 1) rank, sum(credit) as credit, member_id, game_id,phone,wechat_name,username");
		$ranks  = \App\History::select($select);
		
		if ($request->filled('gameid')) 
		{
			$ranks = $ranks->where('game_id',$request->gameid);
		}
				
		$ranks  = $ranks->where(function($query) {
							$query->where('ledger_type' , 'LIKE' ,'AP%');
							$query->orWhere('ledger_type' , 'CRPNT');
						})
						->join('members', 'members.id', '=', \App\History::getTableName().'.member_id')
						->groupby('member_id','game_id')
						->orderBy('rank','ASC')
						->limit(30)
						->get();
		//End global rank
		
		//Current User rank
		
		$select = \DB::raw("(SELECT COUNT(*) FROM a_rank_view WHERE game_id = 102) AS rank, member_id, game_id,credit,debit");
		$row    = \DB::table('a_rank_view');
		$row    = $row->select($select);
		if ($request->filled('gameid')) 
		{
			$row = $row->where('game_id',$request->gameid);
		}
		$row = $row->where('member_id',$request->memberid);
		
		$row    = $row->first();
		
		//dd($row);
		//End
		
		//Friends rank
		$fr_ranks = [];
		
		
		$select = \DB::raw("@j := coalesce(@j + 1, 1) rank, sum(credit) as credit, member_id, game_id,phone,wechat_name,username");
		$fr_ranks  = \App\History::select($select);

		if ($request->filled('gameid')) 
		{
			$fr_ranks = $fr_ranks->where('game_id',$request->gameid);
		}

		$fr_ranks  = $fr_ranks
						->where(function($query) {
										$query->where('ledger_type' , 'LIKE' ,'AP%');
										$query->orWhere('ledger_type' , 'CRPNT');
									})					
						->groupby('member_id','game_id')
						->orderBy('rank','ASC')
						->join('members', 'members.id', '=', \App\History::getTableName().'.member_id')
						->whereIn('member_id', function($query) use ($request) {
							$query->select('id')
							->from('members')
							->where('referred_by', $request->memberid);
						})
						->limit(30)
						->get();
		//End
		
		return response()->json(['success' => true, 'my_rank' => $row, 'friends_rank' => $fr_ranks , 'global_ranks' => $ranks]); 
	}
	
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
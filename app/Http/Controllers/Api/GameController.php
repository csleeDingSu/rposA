<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Game;
use Validator;
use Carbon\Carbon;
use App\Wallet;
use App\member_game_result;

class GameController extends Controller
{
    
	public function listgames()
    {
		$records = Game::get_gamelist();
		return response()->json(['success' => true, 'record' => $records]); 
	}
	
	public function list_gamelevels($id = FALSE)
    {
		$records = Game::get_gamelevel($id);
		return response()->json(['success' => true, 'record' => $records]); 
	}
	
	public function listall($id = FALSE)
    {
		$records =  Game::listall($id);
		
		return response()->json(['success' => true, 'record' => $records]); 
	}
	
	
	public function mytest(Request $request)
    {
		$gameid   = $request->gameid;
		$memberid = $request->memberid;
		$levelid  = $request->level;
		
		$level  =  Game::get_game_next_position($gameid, $levelid);
		
		
		//print_r($level);
	}
	
	public function get_game_setting(Request $request)
    {
		$gameid   = $request->gameid;
		$memberid = $request->memberid;
		
		$level  =  Game::get_member_current_level($gameid, $memberid);
		
		$now        = Carbon::now();
		$out = Game::get_single_gameresult_by_gameid($gameid);
		
		$latest_result = Game::get_latest_result($gameid);
			
		$setting =  Game::gamesetting($gameid);
		
		if ($out)
		{
			$result_time = $this->processgametime( $now,$out );
			
			if ($result_time)
			{				
				$end_date = Carbon::parse($out->created_at);

				$duration = $end_date->diffInSeconds($out->expiry_time);
				
				//@todo :- get from config
				if ($setting->freeze_time>=30 or $setting->freeze_time<5) $setting->freeze_time = 5;
				
				$result = ['drawid'=>$out->result_id,'requested_time'=>$now , 'remaining_time'=>$result_time, 'duration'=>$duration, 'freeze_time' => $setting->freeze_time,'level'=>$level,'latest_result'=>$latest_result];
			
				return response()->json(['success' => true, 'record' => $result]);
			}
			return response()->json(['success' => false, 'record' => '', 'message' => 'result expired']); 
			 
		}
		return response()->json(['success' => false, 'record' => '', 'message' => 'invalid game']);
				
		//$records =  Game::gamesetting($gameid);
		
	}
	
	//need to work for wallet
	
	/**
	 *
	 * Fixed player_level number 11/oct/2018
	 *
	 **/
	public function update_game(Request $request)
    {	

		$glevel = '';
		$status = 'lose';
		$is_win = null;
		$player_level = 1;		
		$gameid   = $request->gameid;
		$memberid = $request->memberid;
		$drawid   = $request->drawid;
		$bet      = $request->bet;
		$betamt   = $request->betamt;	
		$gamelevel  = $request->level;
		//$life		= $request->life;
		$life		= 'yes';

		
		
		$input = [
             'gameid'    => $gameid,
			 'memberid'  => $memberid,
			 'drawid'    => $drawid,
			 'bet'       => $bet,	
			 'betamt'    => $betamt,	
              ];
		
		$validator = Validator::make($input, 
            [
                'gameid'   => 'required|exists:games,id',
				'memberid' => 'required|exists:members,id',
				'drawid'   => 'required|exists:game_result,id',
				//'bet'      => 'required',
            ]
        );
		
		
		$current_result = Game::get_single_gameresult($drawid);
		
		$game_result = !empty($current_result->game_result) ? $current_result->game_result  : '' ;
		
		
		
		
		if ($validator->fails()) {
			 return response()->json(['success' => false, 'game_result' => $game_result, 'message' => $validator->errors()->all()]);
		}
		
		
		//If empty then return the game result only
		if (empty($bet) || empty($memberid))
		{
			return response()->json(['success' => false, 'game_result' => $game_result]);
		}
		
		
		$gamelevel = Game::get_member_current_level($gameid, $memberid);
		
		$levelid = $gamelevel->levelid;
		
		$res = Wallet::playable_status($memberid,$gameid,$levelid);
		$is_playable = $res['playablestatus'];	
		$is_redeemable = $res['redeempointstatus'];
		//print_r($is_playable);


		if (empty($is_playable)&&empty($is_redeemable))// 0
		{
			$req = New Request;
			$req->merge(['memberid' => $memberid]);
			$req->merge(['gameid' => $gameid]);
			$req->merge(['life' => $life]);
			$this->redeem_life($req);//life_redemption($memberid,$gameid,$life);


			
			return response()->json(['success' => false, 'game_result' => $game_result,'message' => 'not enough balance to play']);
			
		}elseif (empty($is_playable)&&!empty($is_redeemable))//1
		{
			$this->redeem_life($memberid,$gameid,$life);

			return response()->json(['success' => false, 'game_result' => $game_result,'message' => 'exceeded the coin limit']);
		}		
		else{

			//Check current bet request match with server draw result
			if (member_game_result::where('member_id', '=', $memberid)->where('game_id', '=', $gameid)->where('draw_id', '=', $drawid)->exists()) {
			   // user found
				return response()->json(['success' => false, 'game_result' => $game_result]);
			}
			
			/**
			 * if player & histoy win the increse to 1
			 * if player fail keep the value 
			 **/		
			
			$game_p_level = $this->get_player_level($gameid, $memberid, $player_level, $gamelevel);
			
			$gamelevel    = $game_p_level['gamelevel'];
			$player_level = $game_p_level['player_level'];
			
			$gen_result  = check_odd_even($game_result);
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
				//Update Memeber game play history		
				$now     = Carbon::now()->toDateTimeString();
					
				$insdata = ['member_id'=>$memberid,'game_id'=>$gameid,'game_level_id'=>$gamelevel,'is_win'=>$is_win,'game_result'=>$status,'bet_amount'=>$level->bet_amount,'bet'=>$bet,'game_result'=>$current_result->game_result,'created_at'=>$now,'updated_at'=>$now,'player_level'=>$player_level, 'draw_id' => $drawid];
				$filter = ['member_id'=>$memberid,'game_id'=>$gameid,'draw_id' => $drawid];		

				$records =  Game::add_play_history($insdata,$filter);
				//$records = member_game_result::firstOrCreate($filter, $insdata)->id;
				
				return response()->json(['success' => true, 'status' => $status, 'game_result' => $game_result]); 
			}
			
			return response()->json(['success' => false, 'message' => 'not enough balance to play']); 
		}
		
	}
	
	public function get_player_level($gameid, $memberid, $player_level,$gamelevel)
	{	
		$level     = Game::get_player_level($gameid, $memberid);
		
		//$gamelevel = Game::get_member_current_level($gameid, $memberid);
		

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
	
	
			
	public function view_draw_result(Request $request)
    {	
		$gameid   = $request->gameid;
		$drawid   = $request->drawid;		
			
		$input = [
             'gameid'    => $gameid,
			 'drawid'    => $drawid,	
              ];
		
		$validator = Validator::make($input, 
            [
                'gameid'   => 'required|exists:games,id',
				'drawid'   => 'required|exists:game_result,id',
            ]
        );
		
		if ($validator->fails()) {
			 return response()->json(['success' => false, 'message' => $validator->errors()->all()]);
		}
		else{
			$status = Game::get_single_gameresult($drawid);
			return response()->json(['success' => true, 'status' => $status]); 
		}
		
	}
	
	public function get_game_history($id = false)
    {
		$result = Game::get_game_history($id,'DESC');
		return response()->json(['success' => true, 'records' => $result]); 
	}
	
	public function get_betting_history(Request $request)
    {
		$gameid   = $request->gameid;
		$memberid   = $request->memberid;
		
		$result = Game::get_betting_history_grouped($gameid, $memberid);
	
		return response()->json(['success' => true, 'records' => $result]); 
	}
	
	public function o9999_get_betting_history(Request $request)
    {
		$gameid   = $request->gameid;
		$memberid   = $request->memberid;
		
		$result = Game::get_betting_history($gameid, $memberid);
		return response()->json(['success' => true, 'records' => $result]); 
	}
	
	public function get_wallet_details(Request $request)
    {
		$gameid   = $request->gameid;
		$memberid   = $request->memberid;
		
		$records =  Wallet::get_wallet_details($memberid);
		return response()->json(['success' => true, 'record' => $records]); 
	}
	
	public function get_game_time($gameid = false)
    {
		$now        = Carbon::now();
		$out = Game::get_single_gameresult_by_gameid($gameid);		
		if ($out)
		{
			$result_time = $this->processgametime( $now,$out );
			
			if ($result_time)
			{
				
				$end_date = Carbon::parse($out->created_at);

				$duration = $end_date->diffInSeconds($out->expiry_time);
				
				$result = ['drawid'=>$out->result_id,'requested_time'=>$now , 'remaining_time'=>$result_time, 'duration'=>$duration, 'freeze_time' => '5'];
			
				return response()->json(['success' => true, 'record' => $result]);
			}
			return response()->json(['success' => false, 'record' => '', 'message' => 'result expired']); 
			 
		}
		return response()->json(['success' => false, 'record' => '', 'message' => 'invalid game']); 
		
	}
	
	private function processgametime($now,$result)
	{
		
		$start_time = $result->created_at;
		
		$end_time   = $result->expiry_time;
		
		if ($end_time<$now)
		{
			return false;
		}
		$end_date = Carbon::parse($end_time);

		return $end_date->diffInSeconds($now);
		
	}
	
	public function get_latest_result(Request $request)
    {	
		$gameid   = $request->gameid;
		
		if ($gameid)
		{
			$result = Game::get_latest_result($gameid);	
			return response()->json(['success' => true, 'record' => $result]);
		}
		return response()->json(['success' => false, 'record' => '', 'message' => 'unknown game']); 
	}
	
	/*public function view_game_result($id = false)
    {
		
			
	}*/
	
	public function redeem_life(Request $request){
		$memberid = $request->memberid;
		$gameid   = $request->gameid;
		$life   = $request->life; //life yes
		return $this->life_redemption($memberid,$gameid,$life);
	}



	public function life_redemption($memberid, $gameid, $life)
    {
		$credit_bal=0;



		if ($life == 'yes')
		{
			//print_r($life);
			//die();
			$wallet = Wallet::get_wallet_details($memberid);

			//print_r($wallet);
			//print_r($gameid);
			//print_r($memberid);
			if ($wallet) 
			{

				
				//print_r($wallet);
				if ($wallet->life >= 1) 
				{
					$res 			= Wallet::playable_status($memberid,$gameid,$wallet->level);	
					$is_redeemable 	= $res['redeempointstatus'];
					$status 		= false;
					$current_life	=$wallet->life-1;
					$credit        	= 0;
					$debit        	= $wallet->acupoint; //"{{ $level->bet_amount}}"



					
						//Wallet::life_redeem_post_ledgerhistory_pnt($memberid,$credit,$debit,$award_bal_before,$award_bal_after,$award_current_bal);
						//Wallet::life_redeem_post_ledgerhistory_bal($memberid,$credit_bal,$debit_bal,$balance_before,$balance_after,$current_balance);


// ---------------------Balance--------------------------------------
					$balance_before		=$wallet->balance;
					if($balance_before!=1200){
						$credit_bal= 1200-$wallet->balance;
						//$credit_bal=+1200;
						}
					$current_balance	= $wallet->balance +$credit_bal;
					$balance_after		= $current_balance;
					$debit_bal			= 0;
					$current_level 		= 1;
					$current_bet 		= $wallet->bet;
// ---------------------Point--------------------------------------
					
					$award_bal_before		= $wallet->acupoint;// $wallet->point;
					$award_bal_after		= $award_bal_before-$wallet->acupoint;
					$award_current_bal		= $award_bal_before-$wallet->acupoint;
					$current_life_acupoint	= $award_bal_before-$wallet->acupoint;

					if ($is_redeemable == true){
						$current_point=$wallet->point+ env('coin_max', 150);
						$status=true;

// ---------------------Credit--------------------------------------
					$crd_credit             = env('coin_max', 150);
					$crd_debit              = 0; //"{{ $level->bet_amount}}"
					if($wallet->acupoint>150){
						$wallet->acupoint=150;
					}
					$crd_bal_before			= $wallet->point;
					$crd_bal_after			= $crd_bal_before+env('coin_max', 150);
					$crd_current_bal		= $crd_bal_before+env('coin_max', 150);


					Wallet::life_redeem_post_ledgerhistory_bal($memberid,$credit_bal,$debit_bal,$balance_before,$balance_after,$current_balance);
					Wallet::life_redeem_post_ledgerhistory_pnt($memberid,$credit,$debit,$award_bal_before,$award_bal_after,$award_current_bal);
					Wallet::life_redeem_post_ledgerhistory_crd($memberid,$crd_credit,$crd_debit,$crd_bal_before,$crd_bal_after,$crd_current_bal);
					Wallet::life_redeem_update_mainledger($current_balance,$current_life,$memberid,$current_life_acupoint,$current_point);


					} else{
						$current_point=$wallet->point;
						// // ---------------------Balance--------------------------------------
						// $balance_before=$wallet->balance;
						// if($balance_before==0){
						// 	$credit_bal=+1200;
						// 	}
						// $current_balance = $wallet->balance +$credit_bal;
						// $balance_after= $current_balance;
						// $debit_bal=0;
						// $current_level = 1;
						// $current_bet = $wallet->bet;
						// // ---------------------Point--------------------------------------

						// $award_bal_before			= $wallet->acupoint;// $wallet->point;
						// $award_bal_after			= $award_bal_before-$wallet->acupoint;
						// $award_current_bal			= $award_bal_before-$wallet->acupoint;
						// $current_life_acupoint	 	= $award_bal_before-$wallet->acupoint;
						Wallet::life_redeem_post_ledgerhistory_bal($memberid,$credit_bal,$debit_bal,$balance_before,$balance_after,$current_balance);
						if($credit>0){
						Wallet::life_redeem_post_ledgerhistory_pnt($memberid,$credit,$debit,$award_bal_before,$award_bal_after,$award_current_bal);
						}
						//Wallet::life_redeem_post_ledgerhistory_crd($memberid,$crd_credit,$crd_debit,$crd_bal_before,$crd_bal_after,$crd_current_bal);
						Wallet::life_redeem_update_mainledger($current_balance,$current_life,$memberid,$current_life_acupoint,$current_point);
						//Wallet::life_redeem_post_ledgerhistory_bal($memberid,$credit_bal,$debit_bal,$balance_before,$balance_after,$current_balance);
					}

					// $history=array(
					// 	'current_life' 				=>	$current_life,
					// 	'balance_before' 			=>	$balance_before,
					// 	'credit_bal'                =>  $credit_bal,
					// 	'current_balance'	        =>  $current_balance,
					// 	'balance_after'	            =>  $balance_after,
					// 	'debit_bal' 				=>	$debit_bal,
					// 	'current_level' 		    =>	$current_level,
					// 	'current_bet'           	=>  $current_bet,
					// 	'current_point'	            =>  $current_point,
					// 	'current_life_acupoint'	    =>  $current_life_acupoint,
					// 	);

					// here update the life 
					//update wallet
					// Wallet::life_redeem_post_ledgerhistory_bal($memberid,$credit_bal,$debit_bal,$balance_before,$balance_after,$current_balance);
					// Wallet::life_redeem_post_ledgerhistory_pnt($memberid,$credit,$debit,$award_bal_before,$award_bal_after,$award_current_bal);
					// Wallet::life_redeem_post_ledgerhistory_crd($memberid,$crd_credit,$crd_debit,$crd_bal_before,$crd_bal_after,$crd_current_bal);
					// Wallet::life_redeem_update_mainledger($current_balance,$current_life,$memberid,$current_life_acupoint,$current_point);
					//update ledger history

					
					//Reset latest member game level
					Game::reset_member_game_level($memberid , $gameid);

					return response()->json(['success' => true, 'status' => $status, 'Acupoint' => $wallet->acupoint]); 
					//return response()->json(['success' => true]); 
				}else if($life <=0)
				{
					
					return response()->json(['success' => false, 'record' => '', 'message' => 'not enough life']); 
				}
				return response()->json(['success' => false, 'record' => '', 'message' => 'no data from wallet']);
			}
			return response()->json(['success' => false, 'record' => '', 'message' => 'want redeem']); 
		}
		return response()->json(['success' => false, 'record' => '', 'message' => 'dun want redeem']); 
	}
	
	
	public function showresult($gameid = false)
    {
	}
	
	public function saveresult($gameid = false)
    {
	}
	
	public function decideresult($gameid = false)
    {
	}
	
}
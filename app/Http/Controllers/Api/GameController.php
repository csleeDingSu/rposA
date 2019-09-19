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
	
	
	//without game bet
	public function master_withoutbet(Request $request)
	{
		$now         = Carbon::now();
		$gamesetting = $this->get_game_setting($request);
		$gamenotific = $this->get_game_notification($request);	
		
		$gamehistory = $this->get_game_history($request->gameid);		
		
		$futureresult= Game::get_future_result($request->gameid, $now );
		
		$setting     = \App\Admin::get_setting();
		
		return response()->json(['success' => true, 'gamesetting' => $gamesetting, 'gamenotification' => $gamenotific,'gamehistory' => $gamehistory,'futureresults' => $futureresult,'wabaofee' => $setting->wabao_fee]); 
	}
	
	//with  bet	
	public function master_out(Request $request)
	{
		$now         = Carbon::now();
		$gamesetting = $this->get_game_setting($request);
		$gamenotific = $this->get_game_notification($request);	
		
		$bethistory  = $this->get_betting_history($request);
		$gamehistory = $this->get_game_history($request->gameid);	
		
		$game_temp   = $this->get_update_game_temp($request);
		$wallet      = Ledger::all_ledger($request->memberid,$request->gameid);	
		
		$futureresult= Game::get_future_result($request->gameid, $now );
		$setting     = \App\Admin::get_setting();
		return response()->json(['success' => true, 'gamesetting' => $gamesetting, 'gamenotification' => $gamenotific,'bethistory' => $bethistory,'gamehistory' => $gamehistory,'game_temp' => $game_temp,'wallet' => $wallet,'futureresults' => $futureresult,'wabaofee' => $setting->wabao_fee]);  
	}
	
	
	public function get_game_setting(Request $request)
    {
		$now      = Carbon::now();
		$gameid   = $request->gameid;
		$memberid = $request->memberid;
		switch($gameid)
		{
			case '102':
				return $this->game_setting($request);
			break;
			case '103':
				$vip       = $request->vip;	
				
				$setting   =  Game::gamesetting($gameid);
				
				$setting   =  Game::gamesetting($gameid);
				$playcount = \App\PlayCount::where( 'member_id' , $memberid)->where( 'game_id' , $gameid)->sum('play_count');				
				
				$bettinghistory   = Game::get_betting_history_grouped($gameid, $memberid, $vip);

				$result = ['setting'=>$setting,'playcount' => $playcount,'bettinghistory' => $bettinghistory];

				return response()->json(['success' => true,'requested_time'=>$now,'response_time'=>now(),  'record' => $result]);
			break;
				
			case '104':
				$setting =  Game::gamesetting($gameid);
				
				$bettinghistory   = Game::get_betting_history_grouped($gameid, $memberid);

				$result = ['setting'=>$setting,'bettinghistory' => $bettinghistory];

				return response()->json(['success' => true,'requested_time'=>$now,'response_time'=>now(),  'record' => $result]);
			break;			
				
		}
		
		
		$memberid = $request->memberid;
		$vip       = $request->vip;	
		
		$level  =  Game::get_member_current_level($gameid, $memberid, $vip);
		
		$now        = Carbon::now()->toDateTimeString();
		$out = Game::get_single_gameresult_by_gameid($gameid,$now );
		
		$latest_result = Game::get_latest_result($gameid);
			
		$setting =  Game::gamesetting($gameid);
		
		$consecutive_lose = Game::get_consecutive_lose($memberid,$gameid, $vip);
		
		if ($out)
		{
			$result_time = $this->processgametime( $now,$out );
			
			if ($result_time)
			{				
				$end_date = Carbon::parse($out->created_at);

				$duration = $end_date->diffInSeconds($out->expiry_time);
				
				//@todo :- get from config
				if ($setting->freeze_time>=30 or $setting->freeze_time<5) $setting->freeze_time = 5;	
				
				$result = ['drawid'=>$out->result_id,'requested_time'=>$now , 'remaining_time'=>$result_time, 'duration'=>$duration, 'freeze_time' => $setting->freeze_time,'level'=>$level,'latest_result'=>$latest_result,'consecutive_lose'=>$consecutive_lose];
			
				return response()->json(['success' => true, 'record' => $result]);
			}
			return response()->json(['success' => false, 'record' => '', 'message' => 'result expired']); 
			 
		}
		return response()->json(['success' => false, 'record' => '', 'message' => 'invalid game']);
				
		//$records =  Game::gamesetting($gameid);
		
	}
	
	
	
	
	
	/**
	 *
	 * Fixed player_level number 11/oct/2018
	 *
	 **/
	public function update_game(Request $request)
    {	
		$now     = Carbon::now()->toDateTimeString();
		$reward = 0;
		$glevel = '';
		$status = 'lose';
		$is_win = null;
		$player_level = 1;	
		$type = 1;
		$gameid   = $request->gameid;
		$memberid = $request->memberid;
		$drawid   = $request->drawid;
		
		$drawid   = Game::get_current_result($gameid, $now);
		
		$bet      = $request->bet;
		$betamt   = $request->betamt;	
		$gamelevel  = $request->level;
		$vip       = $request->vip;	
		$life		= 'yes';
		$table    = 'member_game_result';
		
		if ($vip) {
			$table = 'vip_member_game_result';
			$type  = 2;
		}

		//add checking bet amount from member_game_bet_temp temporary table		
		// if (empty($bet)) {
		// 	$res = member_game_bet_temp::whereNull('deleted_at')->where('gameid', $request->gameid)->where('memberid', $request->memberid)->where('drawid', $request->drawid)->where('level', $request->level)->where('gametype', $type)->first();			
		// 	if (!empty($res)) {

		// 		$bet = $res->bet;
		// 		$betamt = $res->betamt;

		// 	}
		// }

		//bet => direct get from member_game_bet_temp
		$res = member_game_bet_temp::whereNull('deleted_at')->where('gameid', $gameid)->where('memberid', $memberid)->where('drawid', $drawid)->where('gametype', $type)->first();	
		$bet = isset($res->bet) ? $res->bet : '';	
		$betamt = isset($res->betamt) ? $res->betamt : '';
	
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
		
		$current_result = Game::get_single_gameresult($drawid);
		
		$game_result = !empty($current_result->game_result) ? $current_result->game_result  : '' ;
		
		if ($validator->fails()) {
			 return response()->json(['success' => false, 'game_result' => $game_result, 'message' => $validator->errors()->all()]);
		}
		
		
		//If empty then return the game result only
		if (empty($bet) || empty($memberid))
		{
			return response()->json(['success' => false, 'game_result' => $game_result, 'message' => 'no betting']);
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
		//print_r($is_playable);

		if ($res['life']<1)
		{
			return response()->json(['success' => false, 'game_result' => $game_result,'message' => 'not enough life to play']);
			
		}
		if (empty($is_playable)&&empty($is_redeemable))// 0
		{
			//life_redemption($memberid,$gameid,$life);
			
			return response()->json(['success' => false, 'game_result' => $game_result,'message' => 'not enough balance to play']);
			
		}elseif (empty($is_playable)&&!empty($is_redeemable))//1
		{
			//$this->life_redemption($memberid,$gameid,$life);

			return response()->json(['success' => false, 'game_result' => $game_result,'message' => 'exceeded the coin limit']);
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
				
				if ($wallet['status'] =='win') $reward = $level->point_reward;
				
					
				$insdata = ['member_id'=>$memberid,'game_id'=>$gameid,'game_level_id'=>$gamelevel,'is_win'=>$is_win,'game_result'=>$status,'bet_amount'=>$level->bet_amount,'bet'=>$bet,'game_result'=>$current_result->game_result,'created_at'=>$now,'updated_at'=>$now,'player_level'=>$player_level, 'draw_id' => $drawid,'wallet_point' => $wallet['point'],'reward' => $reward];
				
				
				$filter = ['member_id'=>$memberid,'game_id'=>$gameid,'draw_id' => $drawid];		

				$records =  Game::add_play_history($insdata,$filter);
				//$records = member_game_result::firstOrCreate($filter, $insdata)->id;
                
                if ($wallet['acupoint'] >= \Config::get('app.coin_max') ) $this->update_notification($memberid, $gameid,'0');
				
				return response()->json(['success' => true, 'status' => $status, 'game_result' => $game_result]); 
			}
			
			return response()->json(['success' => false, 'message' => 'not enough balance to play']); 
		}
		
	}
	
	public function get_player_level($gameid, $memberid, $player_level,$gamelevel,$vip = FALSE)
	{	
		$level     = Game::get_player_level($gameid, $memberid,$vip );
		
		//$gamelevel = Game::get_member_current_level($gameid, $memberid);
		
		//print_r($level);

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
		$gameid     = $request->gameid;
		$memberid   = $request->memberid;
		$vip        = $request->vip;
		
		$result = Game::get_betting_history_grouped($gameid, $memberid, $vip);
	
		return response()->json(['success' => true, 'records' => $result]); 
	}
	
	public function get_wallet_details(Request $request)
    {
		$gameid     = $request->gameid;
		$memberid   = $request->memberid;
		$records    = Ledger::all_ledger($request->memberid,$request->gameid);	
		
		return response()->json(['success' => true, 'record' => $records]); 
	}
	
	public function get_game_time($gameid = false)
    {
		$now        = Carbon::now();
		$out = Game::get_single_gameresult_by_gameid($gameid,$now );		
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
		$_bal = 1200;
		if ($gameid == 102) {
			$_bal = 120;  //temporary hardcoded... should refer to db.. configurable
		}

		if ($life == 'yes')
		{
			$wallet = Ledger::ledger($memberid, $gameid);
			
			$gamelevel = Game::get_member_current_level($gameid, $memberid);
			
			$close = Game::get_consecutive_lose($memberid,$gameid);

			if ($wallet) 
			{	
				$max_po = \Config::get('app.coin_max');
				
				
				
				if ($gamelevel->position != 1) 
				{
					if ($wallet->acupoint< $max_po)
					{
						return response()->json(['success' => false, 'record' => '', 'message' => 'reset first.cannt redeem.level must be one']); 
					}
				}
				if ($wallet->life >= 1) 
				{
					
					
					if ($close != 'yes') {
						
						if ($wallet->acupoint < $max_po) 
						{
							return response()->json(['success' => false, 'error_code'=>'33','record' => '', 'message' => 'not enough point to redeem.cannot redeem below '.$max_po.' point']); 
						}
						
						if($wallet->acupoint>$max_po){
							$wallet->acupoint=$max_po;
						}

					}else{
						$wallet->acupoint=0;
					}
					
					

					$status 		= false;
					$current_life	= $wallet->life-1;
					$credit        	= 0;
					$debit        	= $wallet->acupoint; //"{{ $level->bet_amount}}"



// ---------------------Balance--------------------------------------
					$balance_before		=$wallet->balance;
					if($balance_before!=$_bal){
						$credit_bal= $_bal-$wallet->balance;
						//$credit_bal=+1200;
						}
					$current_balance	= $wallet->balance +$credit_bal;
					//$current_balance	= $wallet->balance;
					$balance_after		= $current_balance;
					$debit_bal			= 0;
					$current_level 		= 1;
					$current_bet 		= $wallet->bet;
// ---------------------Point--------------------------------------
					
					$award_bal_before		= $wallet->acupoint;// $wallet->point;
					$award_bal_after		= $award_bal_before-$wallet->acupoint;
					$award_current_bal		= $award_bal_before-$wallet->acupoint;
					$current_life_acupoint	= $award_bal_before-$wallet->acupoint;
					
					$current_point=$wallet->point+ $wallet->acupoint;
					/*
					if ($wallet->point < 1)
					{
						$current_point = 1200 + $wallet->acupoint;
					}
					*/
					$status=true;

// ---------------------Credit--------------------------------------
					$crd_credit             = $wallet->acupoint;
					$crd_debit              = 0; //"{{ $level->bet_amount}}"
					
					$crd_bal_before			= $wallet->point;
					$crd_bal_after			= $crd_bal_before+$wallet->acupoint;
					$crd_current_bal		= $crd_bal_after;

					///update ledger
					$wallet->balance  = $current_balance;
					$wallet->life     = $current_life;
					$wallet->acupoint = $current_life_acupoint;
					$wallet->point    = $current_point;
					$wallet->save();

					//update balance in history table

					$data = [
					 'member_id'       => $memberid	
					 ,'account_id'     => $wallet->id
					 ,'game_id'        => $gameid
					 ,'credit'         => $credit_bal
					 ,'debit'          => $debit_bal
					 ,'balance_before' => $balance_before
					 ,'balance_after'  => $balance_after
					 ,'ledger_type'    => 'RBAL'
					];
					
					$uuid = \App\History::add_ledger_history($data);

					//update point in history table
					$data = [
					 'member_id'       => $memberid	
					 ,'account_id'     => $wallet->id
					 ,'game_id'        => $gameid
					 ,'credit'         => $credit
					 ,'debit'          => $debit
					 ,'balance_before' => $award_bal_before
					 ,'balance_after'  => $award_bal_after
					 ,'ledger_type'    => 'RPNT'
					];
					
					$uuid = \App\History::add_ledger_history($data);

					//update redeem point in history table
					$data = [
					 'member_id'       => $memberid	
					 ,'account_id'     => $wallet->id
					 ,'game_id'        => $gameid
					 ,'credit'         => $crd_credit
					 ,'debit'          => $crd_debit
					 ,'balance_before' => $crd_bal_before
					 ,'balance_after'  => $crd_bal_after
					 ,'ledger_type'    => 'CRPNT'
					];
					
					$uuid = \App\History::add_ledger_history($data);

					



					//Wallet::life_redeem_post_ledgerhistory_bal($memberid,$credit_bal,$debit_bal,$balance_before,$balance_after,$current_balance);
					//Wallet::life_redeem_post_ledgerhistory_pnt($memberid,$credit,$debit,$award_bal_before,$award_bal_after,$award_current_bal);
					//Wallet::life_redeem_post_ledgerhistory_crd($memberid,$crd_credit,$crd_debit,$crd_bal_before,$crd_bal_after,$crd_current_bal);
					//Wallet::life_redeem_update_mainledger($current_balance,$current_life,$memberid,$current_life_acupoint,$current_point);

					//Reset latest member game level
					Game::reset_member_game_level($memberid , $gameid);					

					return response()->json(['success' => true,  'Acupoint' => $wallet->acupoint]); 
					//return response()->json(['success' => true]); 
				}
				else 
				{
					
					if ($wallet->acupoint < 1) 
					{
						return response()->json(['success' => false, 'record' => '', 'message' => 'nothing to redeem']); 
					}
					$credit        	= 0;
					$debit        	= $wallet->acupoint; 
					$max_po = \Config::get('app.coin_max');
					
					if ($debit >= $max_po )
					{
						$debit = $max_po;
					}
										
					
					if ($close != 'yes') {
						
						if ($wallet->acupoint < $max_po) 
						{
							return response()->json(['success' => false, 'error_code'=>'33','record' => '', 'message' => 'not enough point to redeem.cannot redeem below '.$max_po.' point']); 
						}
					}

					$notes = '';
					$balance_after = $wallet->acpoint  + $debit ;
					if ($debit < $wallet->acupoint)
					{
						if ($wallet->acupoint > 15)
						{
							$purgedpoint = $wallet->acupoint - $debit ;
							$notes .= $purgedpoint.' points Purged. ';
						}
						$notes .= 'Acpoint: '.$debit.' Redeemed';
					}

					$balance_before = $wallet->point;
					$balance_after = $wallet->point + $debit;
					///update ledger
					$wallet->acupoint = 0;
					$wallet->point    = $balance_after;
					$wallet->save();

					//update balance in history table

					$data = [
					 'member_id'       => $memberid	
					 ,'account_id'     => $wallet->id
					 ,'game_id'        => $gameid
					 ,'credit'         => $debit
					 ,'debit'          => 0
					 ,'balance_before' => $balance_before
					 ,'balance_after'  => $balance_after
					 ,'ledger_type'    => 'APPNT'
					 ,'notes'          => $notes
					];
					
					$uuid = \App\History::add_ledger_history($data);
					
					
					
					return response()->json(['success' => true]); 
					
					
					
					//return response()->json(['success' => false, 'record' => '', 'message' => 'not enough life']); 
				}
				return response()->json(['success' => false, 'record' => '', 'message' => 'no data from wallet']);
			}
			return response()->json(['success' => false, 'record' => '', 'message' => 'want redeem']); 
		}
		return response()->json(['success' => false, 'record' => '', 'message' => 'dun want redeem']); 
	}
	
			
	public function decideresult($gameid = false)
    {
	}

	//fixed by Prem
	public function update_game_temp(Request $request)
    {	
    	$required = ['gameid','memberid','drawid','gametype'];

    	foreach($required as $element){
		  if($request->input($element) == null){
		      $error_msg = 'Missing ' .$element. ' .';
		      return response()->json(['success' => false, 'message' => $error_msg]);
		      break;
		  }
		}

		$params = [
				'gameid'   => $request->gameid, 
				'memberid' => $request->memberid, 
				'drawid'   => $request->drawid, 
				'bet'      => $request->bet, 
				'betamt'   => $request->betamt, 
				'level'    => $request->level, 
				'gametype' => $request->gametype
			];

		$res = 0;
		$deleted = 0;
		$channel = 'dashboard-vipplayer';
		if ($request->gametype ==1)
		{
			$channel = 'dashboard-basicplayer';
		}
		
		//insert | Update
		if(!empty($request->bet) && !empty($request->betamt))
		{
			
			$deleted = member_game_bet_temp::where('gameid', $request->gameid)->where('memberid', $request->memberid)->where('gametype', $request->gametype)->whereNull('deleted_at')->delete();			
						
			$res = member_game_bet_temp::insertGetId($params);
			
			$wordCount = member_game_bet_temp::where('drawid',  $request->drawid)->where('gametype',  $request->gametype)->count();
			
			event(new \App\Events\EventDashboardChannel($channel,['type'=>'','count'=>$wordCount]));	
		}
		else 
		{
			//delete
			member_game_bet_temp::where('gameid', $request->gameid)->where('memberid', $request->memberid)->where('gametype', $request->gametype)->delete();
			
			event(new \App\Events\EventDashboardChannel($channel,['type'=>'remove']));	
		}



	
		//update deleted_at - remove old bet
		//member_game_bet_temp::where('gameid', $request->gameid)->where('memberid', $request->memberid)->where('drawid', $request->drawid)->update(['deleted_at' => Carbon::now()]);
	//	member_game_bet_temp::where('gameid', $request->gameid)->where('memberid', $request->memberid)->where('gametype', $request->gametype)->whereNull('deleted_at')->update(['deleted_at' => Carbon::now()]);
		

				

        if ($res > 0) {

        	return response()->json(['success' => true, 'message' => "temparory member $request->memberid bet $request->betamt",'test'=>$deleted]);

        } else {

        	return response()->json(['success' => false, 'message' => "invalid bet request"]);

        }	
	

	}

	public function get_update_game_temp(Request $request)
    {	
    	$required = ['gameid','memberid','drawid','gametype'];

    	foreach($required as $element){
		  if($request->input($element) == null){
		      $error_msg = 'Missing ' .$element. ' .';
		      return response()->json(['success' => false, 'message' => $error_msg]);
		      break;
		  }
		}

		$res = member_game_bet_temp::whereNull('deleted_at')->where('gameid', $request->gameid)->where('memberid', $request->memberid)->where('drawid', $request->drawid)->where('gametype', $request->gametype)->first();

		if (empty($res)) {

			return response()->json(['success' => false, 'record' => $res, 'message' => "record not found"]);

		} else {

			return response()->json(['success' => true, 'record' => $res, 'message' => "return record successfully"]);

		}

	}
    
    public function change_game_notification(Request $request)
    {
        $memberid = $request->memberid;
        $gameid   = $request->gameid;
        $flag     = $request->flag;        
        $this->update_notification($memberid, $gameid, $flag);
        return response()->json(['success' => true, 'message' => 'success']);			
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
	
	public function get_game_notification(Request $request)
    {
        $memberid = $request->memberid;
        $gameid   = $request->gameid;        
        $record   = member_game_notification::select('memberid', 'gameid','flag_status')->where('memberid', $memberid)->where('gameid', $gameid)->first();    
        return response()->json(['success' => true, 'record' => $record ]);
	}
	
	
	public function vip_life_redemption(Request $request)
    {		
		$reset    = null;		
		$memberid = $request->memberid;
        $gameid   = $request->gameid; 		
		
		$package      = Package::get_current_package($memberid,'all');
		
		if (!$package) 
		{				
			return response()->json(['success' => false,  'message' => 'no active vip subscriptions']); 
		}
		$wallet       = Wallet::get_wallet_details_all($memberid);
		$redeemcount  = Package::get_redeemed_package_count($memberid);
		$redeemreward = Package::get_redeemed_package_reward($package->id,$memberid);
		
		//Rules are based on redeem_condition table
		//$redeemrules  = \App\Admin::list_redeem_condition();
		
		$verifyrule   = \App\Admin::check_redeem_condition($redeemcount);
		
		
		//return error message if user have vip life & didnt match the redeem criteria,
		if ($verifyrule){
			if ($redeemreward < $verifyrule->minimum_point)
			{
				if ($wallet->vip_life >= 1 )
				{ 
					return response()->json(['success' => false, 'message' => 'you must win '.$verifyrule->minimum_point.' points']); 
				}
			}
		}
		
		//Merge all vip points into current point
		if ($wallet->vip_point > 0 )
		{
			//merge point
			Wallet::merge_vip_wallet($memberid);
			$reset = TRUE;
		}
		//deduct a vip life
		if ($wallet->vip_life >= 1) 
		{	
			Wallet::update_vip_wallet($memberid,1,'','RVL','debit','life reseted');
			$reset = TRUE;			
		}
		
		if ($reset)
		{
			//change package status to completed 
			Package::reset_current_package($package->id);	
			//reset game level
			Game::reset_member_game_level($memberid , $gameid,'1');
			return response()->json(['success' => true]); 
		}
		else 
		{
			return response()->json(['success' => false, 'message' => 'nothing to reset']); 
		}
		
		
	}
	
	
	
	
	
	//New Game 102
	public function game_setting(Request $request)
    {
		$gameid   = $request->gameid;
		$memberid = $request->memberid;
		$vip      = $request->vip;	
		$now      = Carbon::now();
		//$user     = \Auth::guard('member')->user();
		$setting =  Game::gamesetting($gameid);
		
		$out = Game::get_single_gameresult_by_gameid($gameid,$now );
		
		$level            = Game::get_member_current_level($gameid, $memberid, $vip);
		
		$consecutive_lose = Game::get_consecutive_lose($memberid,$gameid, $vip);
		
		$bettinghistory   = Game::get_betting_history_grouped($gameid, $memberid, $vip);
		
		$usedlife         = \App\Game::IsFirstLife($memberid);
						
		//$gamehistory      = Game::get_game_member_history($memberid,$gameid);	
		
		$result = ['setting'=>$setting,'consecutive_lose'=>$consecutive_lose,'level' => $level,'bettinghistory' => $bettinghistory,'usedlife' => $usedlife];
			
		return response()->json(['success' => true,'requested_time'=>$now,'response_time'=>now(),  'record' => $result]);
	}
	
	//no use
	/*
	public function reserve_betting(Request $request)
    {
		$now      = Carbon::now()->toDateTimeString();
		$type     = 1;
		$gameid   = $request->gameid;
		$memberid = $request->memberid;
		//$type     = $request->gametype;			
		$vip      = '';
		$bet      = $request->betto;	
		$betamt   = $request->betamt;
		$table    = 'member_game_result';
		
		if ($type == 2) {
			$table = 'vip_member_game_result';
			$vip = 'yes';
			$this->info( 'vip' );
		}
		//check required fields 		
		$input = [
             'gameid'    => $gameid,
			 'memberid'  => $memberid,
			 'bet'       => $bet,
			 'betamt'    => $betamt,
              ];
		
		if (empty($bet))
		{
			return response()->json(['success' => false,'message' => 'no betting']);
		}
				
		//check point 
		
		$gamelevel = Game::get_member_current_level($gameid, $memberid, $vip);		
				
		$levelid = $gamelevel->levelid;
		
		$res           = Wallet::playable_status($memberid,$gameid,$levelid);
		$is_playable   = $res['playablestatus'];	
		$is_redeemable = $res['redeempointstatus'];
		
		if ($res['point']<1)
		{
			return ['success' => false, 'message' => 'not enough point'];			
		}
		
		if ($res['life']<1)
		{
			return response()->json(['success' => false,'message' => 'not enough life to play']);
			
		}
		if (empty($is_playable)&&empty($is_redeemable))// 0
		{
			return response()->json(['success' => false, 'message' => 'not enough balance to play']);
			
		}elseif (empty($is_playable)&&!empty($is_redeemable))//1
		{
			return response()->json(['success' => false, 'message' => 'exceeded the coin limit']);
		}
		
		//reserverd point 		
		//Wallet::update_basic_wallet($memberid,0,$gamelevel->bet_amount,'RSV','debit', 'Reserved for betting');			
		
		//update betting 		
		$params = ['gameid' => $gameid, 'memberid' => $memberid,'bet' =>$bet,'betamt'=>$gamelevel->bet_amount , 'gametype' => $type];
		$res    = member_game_bet_temp::Create($params)->id;
		
		//send event 
		if ($res > 0) {
			$params['id'] = $res;
			//event(new \App\Events\EventNewBetting($memberid,$params));			
        	return response()->json(['success' => true, 'message' => "temparory member $request->memberid bet $request->betamt"]);
        } 
		
		return response()->json(['success' => false, 'message' => "invalid bet request"]);
	}
	*/
	
	public function add_betting(Request $request)
    {
		//get Game category
		//get_game_category
		
		$gameid     = $request->gameid;
		
		$validator = $this->validate(
            $request,
            [
                 'gameid'   => 'required|exists:games,id',
				 'memberid' => 'required|exists:members,id',
            ]
        );
		
		$type  = 1;
		//$type  = $request->gametype;
		switch($gameid)
		{
			case '101':
				return response()->json(['success' => false, 'message' => 'inactive game']);			
				break;
			case '102':	
				return response()->json(['success' => false, 'message' => 'not in use']);
				$res = member_game_bet_temp::whereNull('deleted_at')->where('gameid', $request->gameid)->where('memberid', $request->memberid)->where('gametype', $type)->first();					
				if($res)
				{
					//update
					if ($request->betto)
					{
						member_game_bet_temp::where('id', $res->id)->update(['bet' => $request->betto]);
						$message = "temparory member $request->memberid bet $request->betamt";
					}
					else
					{
						member_game_bet_temp::where('id', $res->id)->delete();						
						$message = "bet removed";
					}					
					return response()->json(['success' => true, 'message' => $message]);
				}
				
				return $this->reserve_betting($request);
				
				break;
			case '103':
				$res = member_game_bet_temp::whereNull('deleted_at')->where('gameid', $request->gameid)->where('memberid', $request->memberid)->where('gametype', $type)->first();					
				if($res)
				{
					//update
					if ($request->betto)
					{
						member_game_bet_temp::where('id', $res->id)->update(['bet' => $request->betto,'betamt' => $request->betamt]);
						$message = "temparory member $request->memberid bet $request->betamt";
					}
					else
					{
						member_game_bet_temp::where('id', $res->id)->delete();						
						$message = "bet removed";
					}					
				}
				else
				{
					$params  = ['gameid' => $request->gameid, 'memberid' => $request->memberid,'bet' =>$request->betto,'betamt'=>$request->betamt , 'gametype' => $type];
					member_game_bet_temp::Create($params)->id;
					$message = "temparory member $request->memberid bet $request->betamt";					
				}
				return response()->json(['success' => true, 'message' => $message]);
				break;
				
			case '104':
				$res = member_game_bet_temp::whereNull('deleted_at')->where('gameid', $request->gameid)->where('memberid', $request->memberid)->where('gametype', $type)->first();					
				if($res)
				{
					//update
					if ($request->betto)
					{
						$draw = \App\Draw::latest()->first();
						$gbt = member_game_bet_temp::where('id', $res->id)->update(['bet' => $request->betto,'betamt' => $request->betamt,'drawid'=>$draw->id]);
						$message = "temporary member $request->memberid bet $request->betamt";
					}
					else
					{
						member_game_bet_temp::where('id', $res->id)->delete();						
						$message = "bet removed";
					}					
				}
				else
				{
					$params  = ['gameid' => $request->gameid, 'memberid' => $request->memberid,'bet' =>$request->betto,'betamt'=>$request->betamt , 'gametype' => $type];
					$gbt = member_game_bet_temp::Create($params);
					
					$draw = \App\Draw::latest()->first();
					$gbt->drawid = $draw->id;
					$gbt->save();
					$message = "temparory member $request->memberid bet $request->betamt";					
				}
				return response()->json(['success' => true, 'message' => $message]);
			break;
				
		}
	}
	
	
	/*
	no use
	public function reserve_betting_103(Request $request)
    {
		return false;
		$now      = Carbon::now()->toDateTimeString();
		$type     = 1;
		$gameid   = $request->gameid;
		$memberid = $request->memberid;
		//$type     = $request->gametype;			
		$vip      = '';
		$bet      = $request->betto;	
		$betamt   = $request->betamt;
		$table    = 'member_game_result';
		
		if ($type == 2) {
			$table = 'vip_member_game_result';
			$vip = 'yes';
			$this->info( 'vip' );
		}
		//check required fields 		
		$input = [
             'gameid'    => $gameid,
			 'memberid'  => $memberid,
			 'bet'       => $bet,
			 'betamt'    => $betamt,
              ];
		
		if (empty($bet))
		{
			return response()->json(['success' => false,'message' => 'no betting']);
		}
				
		//check point 
				
		
		$res           = Wallet::playable_status($memberid,$gameid,$levelid);
		$is_playable   = $res['playablestatus'];	
		$is_redeemable = $res['redeempointstatus'];
		
		
		if ($res['point']<$betamt)
		{
			return ['success' => false, 'message' => 'not enough point'];	
		}		
		if ($res['point']<1)
		{
			return ['success' => false, 'message' => 'not enough point'];			
		}
		
		if ($res['life']<1)
		{
			return response()->json(['success' => false,'message' => 'not enough life to play']);
			
		}
		if (empty($is_playable)&&empty($is_redeemable))// 0
		{
			return response()->json(['success' => false, 'message' => 'not enough balance to play']);
			
		}elseif (empty($is_playable)&&!empty($is_redeemable))//1
		{
			return response()->json(['success' => false, 'message' => 'exceeded the coin limit']);
		}
		
		//reserverd point 		
		Wallet::update_basic_wallet($memberid,0,$betamt,'RSV','debit', 'Reserved for betting');			
		
		//update betting 		
		$params = ['gameid' => $gameid, 'memberid' => $memberid,'bet' =>$bet,'betamt'=>$betamt , 'gametype' => $type];
		$res    = member_game_bet_temp::Create($params)->id;
		
		//send event 
		if ($res > 0) {
			$params['id'] = $res;
			//event(new \App\Events\EventNewBetting($memberid,$params));			
        	return response()->json(['success' => true, 'message' => "temparory member $request->memberid bet $request->betamt"]);
        } 
		
		return response()->json(['success' => false, 'message' => "invalid bet request"]);
	}
	*/
	public function get_betting_result(Request $request)
    {
		//get Game category
		//get_game_category		
				
		$validator = $this->validate(
            $request,
            [
                 'gameid'   => 'required|exists:games,id',
				 'memberid' => 'required|exists:members,id',
            ]
        );
		switch($request->gameid)
		{
			case '101':
				return response()->json(['success' => false, 'message' => 'inactive game']);			
			break;
			case '102':												
				return $this->betting_result_102($request);
			break;
			case '103':
				return $this->betting_result_103($request);
			break;	
			case '104':
				return $this->betting_result_104($request);
			break;	
		}
	}


	
	public function betting_result_102(Request $request)
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
			$previous_bet =  member_game_result::where('game_id',$gameid)->where('member_id',$memberid)->latest()->first();
			return response()->json(['success' => false, 'message' => trans('dingsu.no_active_betting'),'previous_bet ' => $previous_bet ]);
		}
		$res->status     = 1;
		$res->deleted_at = $now;
		
		//check point 
		
		$gamelevel = Game::get_member_current_level($gameid, $memberid, $vip);		
				
		$levelid = $gamelevel->levelid;
		
		$play_status   = Ledger::playable_status($memberid,$gameid,$levelid);
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
		
		$wallet   = Ledger::game_ledger_update ($memberid,  $gameid, $status, $level);
		
		$ledger   = $wallet['ledger'];
		
		$r_status = 2;
		
		if ($status == 'win') 			
		{
			$reward = $level->point_reward;
			
			$r_status = 1;
			
			if ($ledger->acupoint >= \Config::get('app.coin_max') ) $this->update_notification($memberid, $gameid,'0');
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
	
	public function betting_result_104(Request $request)
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
		$drawid     = $request->drawid;			
		$res = member_game_bet_temp::whereNull('deleted_at')->where('drawid', $drawid)->where('gameid', $gameid)->where('memberid', $memberid)->where('gametype', $type)->first();			
		if(!$res)
		{
			//add last betting detail
			$previous_bet =  member_game_result::where('game_id',$gameid)->where('member_id',$memberid)->latest()->first();
			return response()->json(['success' => false, 'message' => "no betting",'previous_bet ' => $previous_bet ]);
		}			
		$res->status     = 1;
		$res->deleted_at = $now;
		$bet      = $res->bet;	
		$betamt   = $res->betamt ;
		$gametype = $res->gametype ;		
		
		//check point 				
		$ledger   = Ledger::ledger($memberid, $gameid);
		
		if ($ledger->point<1)
		{
			$res->save();
			return ['success' => false, 'message' => trans('dingsu.not_enough_point')];			
		}		
		if ($ledger->point< $betamt )
		{
			$res->save();
			return ['success' => false, 'message' => trans('dingsu.not_enough_point')];			
		}				
		if ($ledger->life<1)
		{
			//$res->save();
			//return response()->json(['success' => false,'message' => 'not enough life to play']);			
		}					
		$input = [
             'gameid'    => $gameid,
			 'memberid'  => $memberid,
			 'bet'       => $bet,	
			 'betamt'    => $betamt,
              ];	
			
		$game_result = \App\Draw::select('result')->where('id',$res->id)->first();		
		$gen_result  = check_odd_even($game_result);
		if ($gen_result === $bet)
		{
			//win change balance
			$status = 'win';
			$is_win = TRUE;				
		}					
		$now = Carbon::now()->toDateTimeString();	
		$r_status = 2;		
		if ($status == 'win') 			
		{
			$reward   = 0;			
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
			$r_status = 1;			
			Ledger::credit($memberid,$gameid,$reward,'GBA', 'reward for betting'); //GBV - Game Betting 104			
		}	
		else
		{
			Ledger::debit($memberid,$gameid,$betamt,'GBA', 'amount deducted for betting'); //GBV - Game Betting 104
		}			

		$insdata = ['member_id'=>$memberid,'game_id'=>$gameid,'is_win'=>$is_win,'bet_amount'=>$betamt,'bet'=>$bet,'game_result'=>$game_result,'created_at'=>$now,'updated_at'=>$now,'reward' => $reward];
		$records =  Game::add_play_history($insdata);				
		$res->save();				
		//Play count update - 29/05/2019
		//Fixed multiple row updates - 14/08/2019
		$playcount = \App\PlayCount::firstOrCreate(['play_date' => Carbon::now()->toDateString(), 'member_id' => $memberid, 'game_id' => $gameid, 'result_status' => $r_status]);		
		if (!$playcount->wasRecentlyCreated) {			
			$playcount->increment('play_count', 1);
		}		
		//End
		$firstwin = '';
		return response()->json(['success' => true, 'status' => $status, 'game_result' => $game_result,'IsFirstLifeWin' => $firstwin]);		
	}
	
	
	
	
	public function betting_result_103(Request $request)
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
			$previous_bet =  member_game_result::where('game_id',$gameid)->where('member_id',$memberid)->latest()->first();
			return response()->json(['success' => false, 'message' => trans('dingsu.no_active_betting'),'previous_bet ' => $previous_bet ]);
		}
		$res->status     = 1;
		$res->deleted_at = $now;	
		
		$bet      = $res->bet;	
		$betamt   = $res->betamt ;
		$gametype = $res->gametype ;
		
		//check eligible 
		$eligible_to_play = \App\BasicPackage::check_vip_status($memberid);
		
		if ($eligible_to_play['eligible_to_enter'] != 'true')
		{
			$res->save();
			return response()->json(['success' => false, 'message' => trans('dingsu.not_eligible_to_play_vip')]);
		}		
		
		//check point 				
		$ledger   = Ledger::ledger($memberid, $gameid);
		
		if ($ledger->point<1)
		{
			$res->save();
			return ['success' => false, 'message' => trans('dingsu.not_enough_point')];			
		}		
		if ($ledger->point< $betamt )
		{
			$res->save();
			return ['success' => false, 'message' => trans('dingsu.not_enough_point')];			
		}				
		if ($ledger->life<1)
		{
			//$res->save();
			//return response()->json(['success' => false,'message' => 'not enough life to play']);			
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
				
		$now      = Carbon::now()->toDateTimeString();
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
						
			$r_status = 1;
			//echo $memberid.'-'.$gameid.'-'.$reward.'-win';
			Ledger::credit($memberid,$gameid,$reward,'GBV', 'reward for betting'); //GBV - Game Betting VIP			
		}	
		else
		{
			Ledger::debit($memberid,$gameid,$betamt,'GBV', 'amount deducted for betting'); //GBV - Game Betting VIP
		}	
		$insdata = ['member_id'=>$memberid,'game_id'=>$gameid,'is_win'=>$is_win,'bet_amount'=>$betamt,'bet'=>$bet,'game_result'=>$game_result,'created_at'=>$now,'updated_at'=>$now,'reward' => $reward];

		$records =  Game::add_play_history($insdata);
		
		$res->save();		
		//$queries = \DB::enableQueryLog();
		
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
	
	
	
	private function decide_result_condition($memberid, $data)
    {
		if ($memberid == 17)
		{
			return $this->result_condition('forcetolose', $memberid, $data);	
		}

		$IsFirstLife = Game::IsFirstLife($memberid);
		
		if ($data) 
		{
			$data['IsFirstLife'] = $IsFirstLife ;
			$gamelevel = $data['gamelevel'];
			$position  = $gamelevel->position;
			//if using first life consecutive_lose then make user win on the 6'th level				
			if (empty($IsFirstLife) && $position === 3)
			{
				//if need to add any functions can add into result_condition
				return $this->result_condition('conditionally_win', $memberid, $data);
			}
			
			if ($IsFirstLife == 1 && $position === 5)
			{
				return $this->result_condition('forcetowin', $memberid, $data);
			}
		}		
		return $this->result_condition('auto', $memberid, $data);		
	}
	
	private function result_condition($makeUserWin = 'auto', $memberid, $data)
    {		
		switch ($makeUserWin)
		{
			case 'forcetowin':
				return (object)['status'=>'win','is_win'=>TRUE];
			break;
			case 'conditionally_win':
				return (object) $this->conditionally_win($memberid, $data);
			break;
			case 'forcetolose':
				return (object) ['status'=>'lose','is_win'=>null];
			break;	
			case 'conditionally_lose':
				return (object) $this->conditionally_lose($memberid, $data);
			break;	
			case 'auto':
				return null;
			break;	
		}
	}
	
	private function conditionally_win($memberid, $data)
    {
		//condition 1
		return ['status'=>'win','is_win'=>TRUE];
	}
	
	private function conditionally_lose($memberid, $data)
    {
		//condition 1
		return ['status'=>'lose','is_win'=>null];
	}
	
	
	
	
	public function today_play_statistics(Request $request)
    {
		$records = Game::today_play_statistics($request->memberid,$request->gameid);
		return response()->json(['success' => true, 'record' => $records]); 
	}
	
	
	
	public function list_user_by_earned_point(Request $request)
    {
		
		//Global Ranks
		$ranks  = \App\Rank::select('rank','member_id','game_id','credit','username','phone','wechat_name','wechat_id')		
					->where('game_id',$request->gameid)
					->join('members', 'members.id', '=', \App\Rank::getTableName().'.member_id')
					->limit(30)
					->orderby('rank','ASC')
					->get();
		//End global rank
		
		//Current User rank
		
		$row = \App\Rank::select('rank','member_id','game_id','credit','username','phone','wechat_name','wechat_id')		
					->where('game_id',$request->gameid)
					->where('member_id',$request->memberid)
					->join('members', 'members.id', '=', \App\Rank::getTableName().'.member_id')
					->first();
		// $row->first();
		
		//dd($row);
		//End
		
		//Friends rank
		$fr_ranks = [];
		
		\DB::connection()->enableQueryLog();
		$fr_ranks  = \App\Rank::select('rank','member_id','game_id','credit','username','phone','wechat_name','wechat_id')
			->where('game_id',$request->gameid)
		    ->whereIn('member_id', function($query) use ($request) {
							$query->select('id')
							->from('members')
							->where('referred_by', $request->memberid);
						})
			->join('members', 'members.id', '=', \App\Rank::getTableName().'.member_id')
			->orderby('rank','ASC')
			->get();
		//End
		$queries = \DB::getQueryLog();		
		
		//dd($queries);
		
		
		
		return response()->json(['success' => true, 'my_rank' => $row, 'friends_rank' => $fr_ranks , 'global_ranks' => $ranks]); 
	}
	

}
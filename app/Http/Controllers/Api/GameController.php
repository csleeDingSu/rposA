<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Game;
use Validator;
use Carbon\Carbon;
use App\Wallet;
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
	public function get_game_setting($id = false)
    {
		$records =  Game::gamesetting($id);
		return response()->json(['success' => true, 'record' => $records]); 
	}
	
	//need to work for wallet
	public function update_game(Request $request)
    {			
		$status = 'lose';
		$is_win = null;
				
		$gameid   = $request->gameid;
		$memberid = $request->memberid;
		$drawid   = $request->drawid;
		$bet      = $request->bet;
		$betamt   = $request->betamt;		
			
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
				'bet'      => 'required',
            ]
        );
		
		if ($validator->fails()) {
			 return response()->json(['success' => false, 'message' => $validator->errors()->all()]);
		}
		else{
			
			$current_result = Game::get_single_gameresult($drawid);
			
			/**
			 * if player & histoy win the increse to 1
			 * if player fail keep the value 
			 **/
			$level = Game::get_player_level($gameid, $memberid);
			$player_level = $level->player_level;
			
			//if the user previously win then add a increment
			if ($level->is_win == 1)
			{					
				$player_level++;
			}			
			//Add wallet update functions 
			if ($current_result->game_result == $bet)
			{
				//win change balance
				$status = 'win';
				$is_win = TRUE;				
			}					
			$wallet = '100';
			//$wallet = Walletupdate ($input, $status, 'PNT');
			
			if ($wallet)
			{
				//Update Memeber game play history		
				$now     = Carbon::now('utc')->toDateTimeString();
				$insdata = ['member_id'=>$memberid,'game_id'=>$gameid,'game_level_id'=>'0','is_win'=>$is_win,'game_result'=>$status,'bet_amount'=>$betamt,'bet'=>$bet,'game_result'=>$current_result->game_result,'created_at'=>$now,'updated_at'=>$now,'player_level'=>$player_level];		

				$records =  Game::add_play_history($insdata);
				return response()->json(['success' => true, 'status' => $status]); 
			}
			
			return response()->json(['success' => false, 'status' => 'not enough balance to play']); 
		}
		
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
	
	public function get_betting_history($id = false)
    {
		$result = Game::get_betting_history_grouped($id);
		return response()->json(['success' => true, 'records' => $result]); 
	}
	
	public function o9999_get_betting_history($id = false)
    {
		$result = Game::get_betting_history($id);
		return response()->json(['success' => true, 'records' => $result]); 
	}
	
	public function get_wallet_details($id = false)
    {
		$records =  Wallet::get_wallet_details($id);
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
				
				$end_date = Carbon::parse($out->created);

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
		
		$start_time = $result->created;
		
		$end_time   = $result->expiry_time;
		
		if ($end_time<$now)
		{
			return false;
		}
		$end_date = Carbon::parse($end_time);

		return $end_date->diffInSeconds($now);
		
	}
	/*public function view_game_result($id = false)
    {
		
			
	}*/
	
	
	
	
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
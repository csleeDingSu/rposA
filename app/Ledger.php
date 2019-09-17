<?php
namespace App;
use Illuminate\Database\Eloquent\Model;

use Carbon\Carbon;
use App\History;

class Ledger extends Model
{   
    protected $fillable = [
        'member_id','game_id','point','reserved_point','life','bonus_point','bonus_life','used_point','used_life',];
	
    protected $table = 'ledger';
		
	protected $table_history = 'game_ledger_history';	
	/*
	//Add point
	credit($userid , $gameid, $amount , $category , $notes);
	//Debit point
	debit($userid , $gameid, $amount , $category , $notes);
	//Get Ledger
	ledger($userid , $gameid);
	//merge to main ledger
	merge_to_main_ledger($userid,$gameid,$credit)
	//merge bonus point
	merge_bonus_point($userid,$gameid,$point ,$category, $notes)
	//merge reserved point
	merge_reserved_point($userid,$gameid,$point = 0,$category, $notes)
	//add bonus point
	bonus($userid,$gameid,$credit = 0,$category = 'PNT', $notes = FALSE)
	//add reserve point
	reserve($userid,$gameid,$credit = 0,$category = 'PNT', $notes = FALSE)		
	*/
	//use only at registration 
	public static function intiateledger($userid,$point = 0)
	{		
		$result = \DB::table('games')->get();
		
		foreach ($result as $item)
		{
		  	$data['member_id'] = $userid;
			$data['game_id']   = $item->id;
			
			$ledger = Ledger::firstOrCreate($data);
			
			if ($ledger->wasRecentlyCreated)
			{
				$ledger->point = $point;
				$ledger->save();
			}
			$data = [];
		}		
	}
	
	public static function findorcreate($userid,$gameid,$point = 0)
	{
		//Ledger::firstOrCreate(['name' => $request->name]);
		
			$ledger = new ledger();
			$ledger->member_id = $userid;
			$ledger->game_id   = $gameid;
			$ledger->point     = $point;
			$ledger->save();		
		//}		
		return $ledger;
	}
	
	public static function all_ledger($userid,$gameid = FALSE)
	{
		$result = \DB::table('mainledger')->select('play_count','current_balance as balance','current_point as point', 'current_level as level', 'current_life as life','current_betting as bet','vip_life','vip_point'
			, \DB::raw('(case when current_life_acupoint is null then 0 else current_life_acupoint end) as acupoint')
			)->where('member_id', $userid)->first();
		
		$wallet = Ledger::where('member_id',$userid);		
		if ($gameid)
		{
			//$wallet = $wallet->where('game_id',$gameid);
		}
		$wallet = $wallet->get();
		
		
		$outwallet = array();
		foreach ($wallet as $item)
		{
		  $outwallet[$item->game_id] = $item;
		}
		
		return ['gameledger'=>$outwallet,'mainledger'=>$result];
	}
	public static function mainledger($userid)
	{
		return $result = \DB::table('mainledger')->select('play_count','current_balance as balance','current_point as point', 'current_level as level', 'current_life as life','current_betting as bet','vip_life','vip_point'
			, \DB::raw('(case when current_life_acupoint is null then 0 else current_life_acupoint end) as acupoint')
			)->where('member_id', $userid)->first();
	}
	public static function ledger($userid,$gameid)
	{
		$wallet     = Ledger::where('member_id',$userid)->where('game_id',$gameid)->first();		
		if (!$wallet)
		{
			$wallet = self::create($userid,$gameid);
		}		
		return $wallet;
	}
	
	public static function ledgerbyid($id, $userid = FALSE, $gameid = FALSE)
	{
		$wallet     = Ledger::where('id',$id);		
		if ($userid)
		{
			$wallet = $wallet->where('member_id',$userid)   ;
		}	
		if ($gameid)
		{
			$wallet = $wallet->where('game_id',$gameid)   ;
		}	
		$wallet = $wallet->first();
		return $wallet;
	}
	
	public static function create($userid,$gameid,$point = 0)
	{
		//$ledger = self::ledger($userid,$gameid);
		//if (!$ledger)
		//{
			$ledger = new ledger();
			$ledger->member_id = $userid;
			$ledger->game_id   = $gameid;
			$ledger->point     = $point;
			$ledger->save();		
		//}		
		return $ledger;
	}
	
	public static function merge_ledger_point($userid,$from_gameid,$to_gameid, $point = 0, $topoint = 0)
	{
		$ledger  = self::ledger($userid,$from_gameid);		
		if ($point <= 0)
		{
			return ['success'=>false,'message'=>'point cannot accepted to proceed'];	
		}		
		if ($point > $ledger->point)
		{
			return ['success'=>false,'message'=>'point cannot accepted to proceed'];	
		}
		$newpoint = $ledger->point - $point;		
		//Insert Ledger History			
		$data = [
				 'member_id'       => $userid	
				 ,'account_id'     => $ledger->id
				 ,'game_id'        => $from_gameid
				 ,'credit'         => 0
				 ,'debit'          => $point
				 ,'balance_before' => $ledger->point
				 ,'balance_after'  => $newpoint
				 ,'ledger_type'    => 'DPMLP'
				 ,'notes'          => $point.' point merged to gameledger '.$to_gameid
				];
		
		//update ledger 
		$result = self::credit($userid,$to_gameid,$topoint,'MLP');
		if ($result['success'] == true)
		{
			$ledger->point = $newpoint;
			$ledger->save();
			$uuid = History::add_ledger_history($data);
			return ['success'=>true,'message'=>'success'];			
		}		
		return ['success'=>false,'message'=>'ledger not updated'];		
	}
		
	public static function merge_to_main_ledger($userid,$gameid,$credit = 0)
	{
		$ledger     = self::ledger($userid,$gameid);
		$wallet     = \App\Wallet::get_wallet_details_all($userid);
		$uuid       = '';
		$newcredit  = '';		
		$prefix     = 'DPMGM';
		$action_sym = '-1';	
		if ($ledger->point <= 0)
		{
			return ['success'=>false,'message'=>'point cannot accepted to proceed'];	
		}
		
		if (!$credit) $credit = $ledger->point;
		
		//@todo :- Based on the Game ID point will merge with VIP & Basic Point		
		
		$result = \App\Wallet::update_basic_wallet($userid,0,$credit,'GPM','credit','points merged from '.$gameid);
		
		if ($result['success'] == 'true')
		{		
			$balance_before = $ledger->point;
			$newcredit      = $ledger->point + ($credit * $action_sym);			
			//Update Ledger Table			
			$ledger->exists  = TRUE;
			$ledger->point   = $newcredit;
			$ledger->save();

			//Insert Ledger History			
			$data = [
					 'member_id'       => $userid	
					 ,'account_id'     => $wallet->id
					 ,'game_id'        => $gameid
					 ,'credit'         => $credit
					 ,'debit'          => 0
					 ,'balance_before' => $balance_before
					 ,'balance_after'  => $newcredit
					 ,'ledger_type'    => $prefix
					 ,'notes'          => $credit.' point merged to mainledger'
					];
			$uuid = History::add_ledger_history($data);
			//fire Wallet event  
			event(new \App\Events\EventLedger($userid, $ledger));
			return ['success'=>true,'uuid'=>$uuid,'message'=>'success'];
		}
		return ['success'=>false,'message'=>'cannot merge'];
		
		
	}
	//merge bonus point 
	public static function merge_bonus_point($userid,$gameid,$point = 0,$category = 'PNT', $notes = FALSE)
	{
		$uuid       = '';
		$newcredit  = '';		
		$prefix     = 'MBP';
		$action_sym = '1';			
		$wallet     = self::ledger($userid,$gameid);
		if ($wallet)
		{
			if ($wallet->bonus_point <= 0)
			{
				return ['success'=>false,'message'=>'reserved point cannot accepted to proceed'];	
			}
			if($wallet->bonus_point < $point )
			{
				return ['success'=>false,'message'=>'reserved point not in the range'];	
			}
			//if point 0 then it will merge all reserved point to point
			$resered = $wallet->bonus_point;
			if ($point)
			{
				$resered = $point;
			}
			
			$balance_before = $wallet->point;
			$newcredit      = $wallet->point + ($resered * $action_sym);			
			//Update Ledger Table			
			$wallet->exists  = TRUE;
			$wallet->point   = $newcredit;
			$wallet->bonus_point   = $wallet->bonus_point - $resered;
			$wallet->save();
			
			//Insert Ledger History			
			$data = [
					 'member_id'       => $userid	
					 ,'account_id'     => $wallet->id
					 ,'game_id'        => $gameid
					 ,'credit'         => $resered
					 ,'debit'          => 0
					 ,'balance_before' => $balance_before
					 ,'balance_after'  => $newcredit
					 ,'ledger_type'    => $prefix.$category
					 ,'notes'          => $notes
					];
			$uuid = History::add_ledger_history($data);
			//fire Wallet event  
			event(new \App\Events\EventLedger($userid, $wallet));
			return ['success'=>true,'uuid'=>$uuid,'message'=>'success'];	
		}
	}
	
	//merge reserved point 
	public static function merge_reserved_point($userid,$gameid,$point = 0,$category = 'PNT', $notes = FALSE)
	{	
		$uuid       = '';
		$newcredit  = '';		
		$prefix     = 'MRP';
		$action_sym = '1';			
		$wallet     = self::ledger($userid,$gameid);
		if ($wallet)
		{
			if ($wallet->reserved_point <= 0)
			{
				return ['success'=>false,'message'=>'reserved point cannot accepted to proceed'];	
			}
			if($wallet->reserved_point < $point )
			{
				return ['success'=>false,'message'=>'reserved point not in the range'];	
			}
			//if point 0 then it will merge all reserved point to point
			$resered = $wallet->reserved_point;
			if ($point)
			{
				$resered = $point;
			}
			
			$balance_before = $wallet->point;
			$newcredit      = $wallet->point + ($resered * $action_sym);			
			//Update Ledger Table			
			$wallet->exists  = TRUE;
			$wallet->point   = $newcredit;
			$wallet->reserved_point   = $wallet->reserved_point - $resered;
			$wallet->save();
			
			//Insert Ledger History			
			$data = [
					 'member_id'       => $userid	
					 ,'account_id'     => $wallet->id
					 ,'game_id'        => $gameid
					 ,'credit'         => $resered
					 ,'debit'          => 0
					 ,'balance_before' => $balance_before
					 ,'balance_after'  => $newcredit
					 ,'ledger_type'    => $prefix.$category
					 ,'notes'          => $notes
					];
			$uuid = History::add_ledger_history($data);
			//fire Wallet event  
			event(new \App\Events\EventLedger($userid, $wallet));
			return ['success'=>true,'uuid'=>$uuid,'message'=>'success'];	
		}
	}
	
	//add bonus point
	public static function bonus($userid,$gameid,$credit = 0,$category = 'PNT', $notes = FALSE)
	{
		if ($credit<=0)
		{
			return ['success'=>false,'message'=>'credit value cannot accepted to proceed'];	
		}		
		$uuid       = '';
		$newcredit  = '';		
		$prefix     = 'BP';
		$action_sym = '1';
		//Get Ledger detail
		$wallet     = self::ledger($userid,$gameid);
		if ($wallet)
		{
			$balance_before = $wallet->bonus_point;
			$newcredit = $wallet->bonus_point + ($credit * $action_sym);			
			//Update Ledger Table			
			$wallet->exists  = TRUE;
			$wallet->bonus_point = $newcredit;
			$wallet->save();
			
			//Insert Ledger History			
			$data = [
					 'member_id'       => $userid	
					 ,'account_id'     => $wallet->id
					 ,'game_id'        => $gameid
					 ,'credit'         => $credit
					 ,'debit'          => 0
					 ,'balance_before' => $balance_before
					 ,'balance_after'  => $newcredit
					 ,'ledger_type'    => $prefix.$category
					 ,'notes'          => $notes
					];
			//dd($wallet);
			$uuid = History::add_ledger_history($data);
			//fire Wallet event  
			event(new \App\Events\EventLedger($userid, $wallet));
			return ['success'=>true,'uuid'=>$uuid,'message'=>'success'];	
		}		
		return ['success'=>false,'message'=>'unknown ledger / user'];			
	}
	
	//reserve point	
	public static function reserve($userid,$gameid,$credit = 0,$category = 'PNT', $notes = FALSE)
	{
		if ($credit<=0)
		{
			return ['success'=>false,'message'=>'credit value cannot accepted to proceed'];	
		}
		
		$uuid       = '';
		$newcredit  = '';		
		$prefix     = 'RP';
		$action_sym = '1';		
		
		$wallet     = self::ledger($userid,$gameid);
		if ($wallet)
		{
			$balance_before = $wallet->point;
			$newcredit      = $wallet->reserved_point + ($credit * $action_sym);			
			//Update Ledger Table			
			$wallet->exists  = TRUE;
			$wallet->point   = $wallet->point - $credit;
			$wallet->reserved_point   = $newcredit;
			$wallet->save();
			
			//Insert Ledger History			
			$data = [
					 'member_id'       => $userid
					 ,'account_id'     => $wallet->id
					 ,'game_id'        => $gameid
					 ,'credit'         => $credit
					 ,'debit'          => 0
					 ,'balance_before' => $wallet->reserved_point
					 ,'balance_after'  => $newcredit
					 ,'ledger_type'    => $prefix.$category
					 ,'notes'          => $notes
					];
			//dd($wallet);
			$uuid = History::add_ledger_history($data);
			//fire Wallet event  
			event(new \App\Events\EventLedger($userid, $wallet));
			return ['success'=>true,'uuid'=>$uuid,'message'=>'success'];	
		}
	}
	
	public static function credit($userid,$gameid,$credit = 0,$category = 'PNT', $notes = FALSE)
	{
		if ($credit<=0)
		{
			return ['success'=>false,'message'=>'credit value cannot accepted to proceed'];	
		}		
		$uuid       = '';
		$newcredit  = '';		
		$prefix     = 'CP';
		$action_sym = '1';
		//Get Ledger detail
		$wallet     = self::ledger($userid,$gameid);
		if ($wallet)
		{
			$balance_before = $wallet->point;
			$newcredit = $wallet->point + ($credit * $action_sym);			
			//Update Ledger Table			
			$wallet->exists  = TRUE;
			$wallet->point = $newcredit;
			$wallet->save();
			
			//Insert Ledger History			
			$data = [
					 'member_id'       => $userid	 
					 ,'account_id'     => $wallet->id
					 ,'game_id'        => $gameid
					 ,'credit'         => $credit
					 ,'debit'          => 0
					 ,'balance_before' => $balance_before
					 ,'balance_after'  => $newcredit
					 ,'ledger_type'    => $prefix.$category
					 ,'notes'          => $notes
					];
			//dd($wallet);
			$uuid = History::add_ledger_history($data);
			//fire Wallet event  
			event(new \App\Events\EventLedger($userid, $wallet));
			return ['success'=>true,'uuid'=>$uuid,'message'=>'success'];	
		}		
		return ['success'=>false,'message'=>'unknown ledger / user'];			
	}
	
	public static function debit($userid,$gameid,$debit = 0,$category = '', $notes = FALSE)
	{
		if ($debit<=0)
		{
			return ['success'=>false,'message'=>'debit value cannot accepted to proceed'];	
		}		
		$uuid       = '';
		$newcredit  = '';		
		$prefix     = 'DP';
		$action_sym = '-1';
		$wallet     = self::ledger($userid,$gameid);
		if ($wallet)
		{
			$balance_before = $wallet->point;
			$newcredit      = $wallet->point + ($debit * $action_sym);			
			//Update Ledger Table			
			$wallet->exists  = TRUE;
			$wallet->point   = $newcredit;
			$wallet->save();			
			//Insert Ledger History			
			$data = [
					 'member_id'       => $userid
					 ,'account_id'     => $wallet->id
					 ,'game_id'        => $gameid
					 ,'credit'         => 0
					 ,'debit'          => $debit
					 ,'balance_before' => $balance_before
					 ,'balance_after'  => $newcredit
					 ,'ledger_type'    => $prefix.$category
					 ,'notes'          => $notes
					];			
			$uuid = History::add_ledger_history($data);			
			//fire Wallet event  
			event(new \App\Events\EventLedger($userid, $wallet));
			return ['success'=>true,'uuid'=>$uuid,'message'=>'success'];	
		}		
		return ['success'=>false,'message'=>'unknown ledger / user'];			
	}
	
	public static function life($userid,$gameid,$type = 'debit',$life = 0,$category = '', $notes = FALSE)
	{
		if ($life<=0)
		{
			return ['success'=>false,'message'=>'value cannot accepted to proceed'];	
		}
		$newlife      = '';
		$action_sym   = '-1';
		$action_type  = 'DEBITED';
		$debit        = $life ; 
		$credit       = '';
		$prefix       = 'DL';
		if ($type == 'credit')
		{
			$action_sym  = '1';
			$action_type = 'CREDITED';
			$credit      = $life;
			$debit       = '' ; 
			$prefix      = 'AL';
		}
		
		$uuid       = '';
		$wallet     = self::ledger($userid,$gameid);
		if ($wallet)
		{
			$balance_before = $wallet->life;
			$newlife      = $wallet->life + ($life * $action_sym);			
			//Update Ledger Table			
			$wallet->exists  = TRUE;
			$wallet->life   = $newlife;
			$wallet->save();			
			//Insert Ledger History			
			$data = [
					 'member_id'       => $userid
					 ,'account_id'     => $wallet->id
					 ,'game_id'        => $gameid
					 ,'credit'         => $credit
					 ,'debit'          => $debit
					 ,'balance_before' => $balance_before
					 ,'balance_after'  => $newlife
					 ,'ledger_type'    => $prefix.$category
					 ,'notes'          => $notes
					];			
			$uuid = History::add_ledger_history($data);			
			//fire Wallet event  
			event(new \App\Events\EventLedger($userid, $wallet));
			return ['success'=>true,'uuid'=>$uuid,'message'=>'success'];	
		}		
		return ['success'=>false,'message'=>'unknown ledger / user'];			
	}
	
	
	public static function balance($userid,$gameid,$type = 'debit',$balance = 0,$category = '', $notes = FALSE)
	{
		if ($balance<=0)
		{
			return ['success'=>false,'message'=>'value cannot accepted to proceed'];	
		}
		$newbalance      = '';
		$action_sym   = '-1';
		$action_type  = 'DEBITED';
		$debit        = $balance ; 
		$credit       = '';
		$prefix       = 'DB';
		if ($type == 'credit')
		{
			$action_sym  = '1';
			$action_type = 'CREDITED';
			$credit      = $balance;
			$debit       = '' ; 
			$prefix      = 'AB';
		}
		
		$uuid       = '';
		$wallet     = self::ledger($userid,$gameid);
		if ($wallet)
		{
			$balance_before = $wallet->balance;
			$newbalance      = $wallet->balance + ($balance * $action_sym);			
			//Update Ledger Table			
			$wallet->exists  = TRUE;
			$wallet->balance   = $newbalance;
			$wallet->save();			
			//Insert Ledger History			
			$data = [
					 'member_id'       => $userid
					 ,'account_id'     => $wallet->id
					 ,'game_id'        => $gameid
					 ,'credit'         => $credit
					 ,'debit'          => $debit
					 ,'balance_before' => $balance_before
					 ,'balance_after'  => $newbalance
					 ,'ledger_type'    => $prefix.$category
					 ,'notes'          => $notes
					];			
			$uuid = History::add_ledger_history($data);			
			//fire Wallet event  
			event(new \App\Events\EventLedger($userid, $wallet));
			return ['success'=>true,'uuid'=>$uuid,'message'=>'success'];	
		}		
		return ['success'=>false,'message'=>'unknown ledger / user'];			
	}
	
	public static function game_ledger_update($userid,$gameid,$status,$level)
	{
		$ledger     = self::ledger($userid,$gameid);
		if($status=="win")
		{
			$ledger->balance  = 120;
			$bal_be = $ledger->acupoint;
			$ledger->acupoint = $ledger->acupoint + $level->point_reward;
			$ledger->played   = $ledger->played + 1;
			
			$data = [
				 'member_id'       => $userid
				 ,'account_id'     => $ledger->id
				 ,'game_id'        => $gameid
				 ,'credit'         => $level->point_reward
				 ,'debit'          => 0
				 ,'balance_before' => $bal_be
				 ,'balance_after'  => $ledger->acupoint
				 ,'ledger_type'    => 'ABAL'
				];
			
		}
		if($status=="lose")
		{			
			$debit = $ledger->balance - (is_null($level->bet_amount) ? 0 : $level->bet_amount);	
			$ledger->balance = $debit;				
			$data = [
				 'member_id'       => $userid
				 ,'account_id'     => $ledger->id
				 ,'game_id'        => $gameid
				 ,'credit'         => 0
				 ,'debit'          => $level->bet_amount
				 ,'balance_before' => $ledger->balance
				 ,'balance_after'  => $debit
				 ,'ledger_type'    => 'DBAL'
				];
			
			
			
		}
		
		
		$ledger->played   = $ledger->played + 1;
		$ledger->save();
		
		
					
		$uuid = History::add_ledger_history($data);		
		
		return ['status'=>$status,'ledger'=>$ledger ];	
	}
	
	
	public static function playable_status($userid,$gameid,$gamelevel)
	{
		$playablestatus    = false;
		$redeempointstatus = false;
		
		$acpoint = \Config::get('app.coin_max') ;
		
		if (empty($acpoint)) $acpoint = 15;
		
		$ledger     = self::ledger($userid,$gameid);
		
		$game_levels = \DB::table('game_levels')->where('id', $gamelevel)->get()->first();
		$current_balance = isset($ledger->balance) ? $ledger->balance : 0;
		$bet_amount = isset($game_levels->bet_amount) ? $game_levels->bet_amount : 0;
		$current_life_acupoint= isset($ledger->acupoint) ? $ledger->acupoint : 0;
		
		if ($ledger->life >=1)
		{
			if($current_balance>=$bet_amount && $current_life_acupoint<$acpoint){
				$playablestatus = true;
				$redeempointstatus = false;
			}else if($current_life_acupoint>=$acpoint){
				$redeempointstatus = true;
				$playablestatus = false;
			}else{
				$playablestatus = false;
				$redeempointstatus = false;
			}
		}
		$point = $ledger->point;
		if ($ledger->point < $game_levels->bet_amount)
		{
			$point = 0;
		}
		

		return ['playablestatus' => $playablestatus, 'redeempointstatus' => $redeempointstatus, 'life' => $ledger->life, 'point' => $point];
	}
	
	
}







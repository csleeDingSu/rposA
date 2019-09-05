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
	\App\Ledger::credit($memberid , $gameid, $amount , $category , $notes);
	\App\Ledger::debit($memberid , $gameid, $amount , $category , $notes);
	*/
	
	public static function ledger($userid,$gameid)
	{
		$wallet     = Ledger::where('member_id',$userid)->where('game_id',$gameid)->first();		
		if (!$wallet)
		{
			$wallet = self::create($userid,$gameid);
		}		
		return $wallet;
	}
	
	public static function create($userid,$gameid)
	{
		//$ledger = self::ledger($userid,$gameid);
		//if (!$ledger)
		//{
			$ledger = new ledger();
			$ledger->member_id = $userid;
			$ledger->game_id   = $gameid;
			$ledger->save();		
		//}		
		return $ledger;
	}
		
	public static function merge_to_main_ledger($userid,$gameid,$credit = 0)
	{
		$ledger     = self::ledger($userid,$gameid);
		$wallet     = \App\Wallet::get_wallet_details_all($userid);
		$uuid       = '';
		$newcredit  = '';		
		$prefix     = 'MGM';
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
	
	public static function debit($userid,$debit = 0,$category = 'M', $notes = FALSE)
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
	
	
}







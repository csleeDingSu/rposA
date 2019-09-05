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
		return $wallet;
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







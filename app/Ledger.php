<?php
namespace App;
use Illuminate\Database\Eloquent\Model;

use Carbon\Carbon;
use App\History;


class Ledger extends Model
{   
    protected $fillable = [
        'member_id','game_id','point','reserved_point','life','bonus_point','bonus_life','used_point','used_life',];
	
    protected $table = 'game_ledger';
		
	protected $table_history = 'game_ledger_history';
	
	
	public static function credit($userid,$gameid,$credit = 0,$category = 'PNT', $notes = FALSE)
	{
		if ($credit<=0)
		{
			return ['success'=>false,'message'=>'credit value cannot accepted to proceed'];	
		}		
		$uuid       = '';
		$newcredit  = '';		
		$prefix     = 'C';
		$action_sym = '1';
		$wallet     = Ledger::where('user_id',$userid)->first();
		if ($wallet)
		{
			$balance_before = $wallet->balance;
			$newcredit = $wallet->balance + ($credit * $action_sym);			
			//Update Ledger Table			
			$wallet->exists  = TRUE;
			$wallet->balance = $newcredit;
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
			
			$uuid = History::add_ledger_history($data);
			//fire Wallet event  
			//event(new \App\Events\EventWalletUpdate($userid));
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
		$prefix     = 'D';
		$action_sym = '-1';
		$wallet     = Ledger::where('user_id',$userid)->first();
		if ($wallet)
		{
			$balance_before = $wallet->balance;
			$newcredit      = $wallet->balance + ($debit * $action_sym);			
			//Update Ledger Table
			
			$wallet->exists  = TRUE;
			$wallet->balance = $newcredit;
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
			//event(new \App\Events\EventWalletUpdate($userid));
			return ['success'=>true,'uuid'=>$uuid,'message'=>'success'];	
		}		
		return ['success'=>false,'message'=>'unknown ledger / user'];			
	}
	
	
}







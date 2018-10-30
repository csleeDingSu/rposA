<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
use DB;
use Carbon\Carbon;
use SoftDeletes; 
class Wallet extends Model
{   
    protected $fillable = [
        'member_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $table = 'mainledger';
	
	protected $table_life = 'game_life';
	
	protected $table_history = 'ledger_history';
	
	
	public static function get_wallet_details($memberid)
	{		
		
		$result = [];
		if (!empty($memberid))
		{
			
			return $result = DB::table('mainledger')->select('current_point as point', 'current_life as life','current_balance as balance','current_betting as bet')->where('member_id', $memberid)->latest()->first();
		}

		return $result;
	}
	
	public static function get_wallet_details_all($memberid)
	{		
		$result = [];
		if (!empty($memberid))
		{
			
			return $result = DB::table('mainledger')->where('member_id', $memberid)->latest()->first();
		}
		return $result;
	}
	
	public static function update_ledger_life($memberid,$new_life,$category = 'LFE',$notes = FALSE)
	{
		$wallet    = self::get_wallet_details_all($memberid);
		
		if ($wallet)
		{

			$now = Carbon::now();

			$newlife = $wallet->current_life + $new_life;
			$history = [
				'created_at' 	  => $now,
				'updated_at' 	  => $now,
				'member_id'       => $memberid,
				'credit'	      => '0',
				'debit'	          => '0',
				'notes'           => $new_life.' LIFE ADDED '.$notes,
				'credit_type'	  => $category,
				];


			$data = [ 
				'updated_at'    => $now,
				'current_life'  => $newlife,
			];

			$ledger  = DB::table('mainledger')
					   ->where('member_id', $memberid)
					   ->update($data);

			$history = self::add_ledger_history($history);
			
			return ['success'=>true,'life'=>$newlife];
		
		}
		return ['success'=>false,'message'=>'unknown record'];
	}
	
	public static function update_ledger($memberid,$type,$amendpoint,$category = 'PNT',$notes = FALSE)
	{
		$wallet    = self::get_wallet_details_all($memberid);
		
		$mainfield  = 'current_balance';
		if ($category == 'PNT')
		{
			$mainfield = 'current_point';
		}
		
		$credit = 0;
		$debit  = 0;
		$balance    = $wallet->{$mainfield};
		
		
		if ($type == 'credit')
		{
			//add	
			$credit = $amendpoint;
			$balance_after = $balance  + $credit ;
		}
		else if ($type == 'debit'){
			$debit = $amendpoint;
			$balance_after = $balance  - $debit ;
		}
		$now = Carbon::now();
		
		$history = [
			'created_at' 	  => $now,
			'updated_at' 	  => $now,
			'member_id'       => $memberid,
			'credit'	      => $credit,
			'debit'	          => $debit,
			'balance_before'  => $balance,
			'balance_after'   => $balance_after,
			'current_balance' => $balance_after,
			'notes'           => $notes,
			'credit_type'	  => $category,
			];
		
		
		$data = [ 
			'updated_at'   => $now,
			"$mainfield"   => $balance_after,
		];
		
		$ledger  = DB::table('mainledger')
				   ->where('member_id', $memberid)
				   ->update($data);
		
		$history = self::add_ledger_history($history);
	}
	
		
	public static function add_ledger_history($data)
	{
		return DB::table('ledger_history')->insertGetId($data);
	}



	public static function game_walletupdate ($memberid, $gameid, $status, $gamelevel)
	{
		//$wallet = Game::get_ledger_details($member_id);
		$mainledger = Self:: current_wallet($memberid);

		//$level = Self::current_level($id);
		$level = Self::current_level_details($gamelevel);
		$levelid = Game::get_member_current_level($gameid, $memberid);
		$currentlevelid = Self::get_current_level($gameid,$memberid);

		
		if($status=="win")
		{
			$credit_type                    ='PNT';
			//$member_id                      = $memberid;
			$balance_before                 = $mainledger->current_balance;
			$credit                         = $level->point_reward;
			$debit                          = '0';
			$credit_bal  					= 1200- $balance_before;
			$debit_bal                      = 0;
			$current_balance                = '1200';
			$balance_after                  = '1200';
			$current_point					= $mainledger->current_point + $level->point_reward;
			$current_bet                    = $level->bet_amount;//how much they bet
			$current_life                   = $mainledger->current_life;
			$current_balance				= $balance_after;
			$current_level					= $level->game_level;

			$award_bal_before				=$current_point- $level->point_reward;
			$award_bal_after				=$award_bal_before+$credit;
			$award_current_bal				=$award_bal_before+$credit;
			
			Self::updatemainledger($memberid,$balance_before,$current_balance,$current_bet,$current_life,$current_level,$current_point);
			Self::postledger_history($memberid,$credit,$debit,$credit_bal,$debit_bal,$balance_before,$balance_after,$current_balance,$credit_type,$award_bal_before,$award_bal_after,$award_current_bal,$current_point);

			

		}else if ($status=="lose")
		{
			//check for PNT
			//$member_id                      = $memberid;
			$credit_type                    ='PNT';
			$balance_before                 = $mainledger->current_balance;
			$current_balance                = $mainledger->current_balance - (is_null($level->bet_amount) ? 0 : $level->bet_amount);
			$balance_after                  = $mainledger->current_balance - (is_null($level->bet_amount) ? 0 : $level->bet_amount);
			$current_point					= $mainledger->current_point;
			$current_bet                    = $level->bet_amount;
			$current_life                   = $mainledger->current_life;
			$current_level					= $level->game_level;
			$credit                   = 0;
			$debit                    = 0; //"{{ $level->bet_amount}}"
			$credit_bal  					= 0;
			$debit_bal                      = $balance_before-$balance_after;

			$award_bal_before				=$current_point;
			$award_bal_after				=$award_bal_before+$credit_bal;
			$award_current_bal				=$award_bal_before+$credit_bal;


			Self::updatemainledger($memberid,$balance_before,$current_balance,$current_bet,$current_life,$current_level,$current_point);
			Self::postledger_history($memberid,$credit,$debit,$credit_bal,$debit_bal,$balance_before,$balance_after,$current_balance,$credit_type,$award_bal_before,$award_bal_after,$award_current_bal,$current_point);

			

		}
		//get the current balance/point
		//then based on the status debit/credit the wallet
		   // amend the mainledger
		   // add history
		   // life
		
		return $status;
	}




public static function updatemainledger($memberid,$balance_before,$current_balance,$current_bet,$current_life,$current_level,$current_point)
{
	$now = Carbon::now()->toDateTimeString();
		$updatemainledger=array(
		'created_at' 				=>	$now,
		'updated_at' 				=>	$now,
		'member_id'                 =>  $memberid,
		'balance_before'            =>  $balance_before,
		'current_balance'           =>  $current_balance,
		'current_point'	            =>	$current_point,
		'current_betting'	        =>  $current_bet, // amount
		'current_life'	            =>  $current_life,
		'current_level'	            =>  $current_level,
		
		
		);
	
		DB::table('mainledger')->
			where('member_id', $memberid)
			->update($updatemainledger);


	
	
	return true;
}


public static function postledger_history($memberid,$credit,$debit,$credit_bal,$debit_bal,$balance_before,$balance_after,$current_balance,$credit_type,$award_bal_before,$award_bal_after,$award_current_bal,$current_point)
{
	$now = Carbon::now()->toDateTimeString();


	$postledger_history_PNT=array(
	'created_at' 				=>	$now,
	'updated_at' 				=>	$now,
	'member_id'                 =>  $memberid,
	'credit'	                =>  $credit,
	'debit'	                    =>  $debit,
	'balance_before' 			=>	$award_bal_before,
	'balance_after' 		    =>	$award_bal_after,
	'current_balance'           =>  $award_current_bal,
	'credit_type'	            =>  'PNT',
	);


	// For the betting balance

	$postledger_history_BAL=array(
	'created_at' 				=>	$now,
	'updated_at' 				=>	$now,
	'member_id'                 =>  $memberid,
	'credit'	                =>  $credit_bal,
	'debit'	                    =>  $debit_bal,
	'balance_before' 			=>	$balance_before,
	'balance_after' 		    =>	$balance_after,
	'current_balance'           =>  $current_balance,
	'credit_type'	            =>  'BAL',
	);




	$insdata = $postledger_history_PNT;
	$insdata2= $postledger_history_BAL;

	DB::table('ledger_history')->
			insert($insdata);
		DB::table('ledger_history')->
			insert($insdata2);


		return true;
	}
	public static function current_wallet($member_id)
	{

		return $result =  DB::table('mainledger')->where('member_id',$member_id)->get()->first();

	}
	public static function current_level_details($level_id)
	{

		return $result = DB::table('game_levels')->where('id', $level_id)->get()->first();

	}

	

	public static function playable_status($memberid,$gameid,$gamelevel)
	{
		Self:: current_wallet($memberid);
		$mainledger =DB::table('mainledger')->where('member_id',$memberid)->get()->first();
		$game_levels =DB::table('game_levels')->where('id', $gamelevel)->get()->first();
		$current_balance= isset($mainledger->current_balance) ? $mainledger->current_balance : 0;
		$bet_amount= isset($game_levels->bet_amount) ? $game_levels->bet_amount : 0;

		if($current_balance>=$bet_amount){
			$playablestatus=true;
		}else if($current_balance<=$bet_amount){
			$playablestatus=false;
		}
		return $playablestatus;
	}
	
	public static function get_current_level($gameid,$memberid)
	{
		return $result = DB::table('member_game_result')->where('game_id', $gameid)->where('member_id', $memberid)->latest()->first();

	}

	public static function postledger_history_life($memberid,$credit_bal,$debit_bal,$balance_before,$balance_after,$current_balance)
{
	$now = Carbon::now()->toDateTimeString();

	// For the betting balance

	$postledger_history_life=array(
	'created_at' 				=>	$now,
	'updated_at' 				=>	$now,
	'member_id'                 =>  $memberid,
	'credit'	                =>  $credit_bal,
	'debit'	                    =>  $debit_bal,
	'balance_before' 			=>	$balance_before,
	'balance_after' 		    =>	$balance_after,
	'current_balance'           =>  $current_balance,
	'credit_type'	            =>  'BAL',
	);


	$insdata= $postledger_history_life;

	DB::table('ledger_history')->
			insert($insdata);

		return true;
	}



	
	
	public static function life_redeem_post_ledgerhistory($memberid,$credit_bal,$debit_bal,$balance_before,$balance_after,$current_balance)
	{
		$now = Carbon::now()->toDateTimeString();

		$postledger_history_BAL=array(
			'created_at' 				=>	$now,
			'updated_at' 				=>	$now,
			'member_id'                 =>  $memberid,
			'credit'	                =>  $credit_bal,
			'debit'	                    =>  $debit_bal,
			'balance_before' 			=>	$balance_before,
			'balance_after' 		    =>	$balance_after,
			'current_balance'           =>  $current_balance,
			'credit_type'	            =>  'BAL',
		);




		$insdata= $postledger_history_BAL;

		DB::table('ledger_history')->
				insert($insdata);
			
	
		
        return true;
	}
	public static function life_redeem_update_mainledger($current_balance,$current_life,$memberid)
{
	$now = Carbon::now()->toDateTimeString();
		$updatemainledger=array(
		'updated_at' 				=>	$now,
		'current_balance'           =>  $current_balance,
		'current_life'	            =>  $current_life,
		
		
		);
	
		DB::table('mainledger')->
			where('member_id', $memberid)
			->update($updatemainledger);


	
	
	return true;
}


}










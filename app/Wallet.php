<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
use DB;
use SoftDeletes; 
use Carbon\Carbon;
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
	
	
	public static function get_wallet_details($gameid, $memberid)
	{		
		//$queries = DB::enableQueryLog();
		//print_r(DB::getQueryLog());
		$result = [];
		$gameid = 101;
		if (!empty($memberid))
		{
			
			return $result = DB::table('mainledger')->select('current_point as point', 'current_life as life','current_balance as balance')->where('member_id', $memberid)->latest()->first();
		}
			
			/*
			$result = DB::table('mainledger')
				->select('mainledger.current_point as point', 'game_life.remaining_life as life','mainledger.current_balance as balance','game_life.gameid')
				->leftjoin('game_life', 'mainledger.member_id', '=', 'game_life.member_id')
				->where('mainledger.member_id', $memberid);			
			if ($gameid)
			{
				$result = $result->where('game_life.gameid', $gameid);
				$result = $result->get()->take(1);
			}	
			else 
			{				
				$result = $result->get();
			}				
		}	print_r(DB::getQueryLog());
		
		//echo DB::raw($gameid);
		$result = DB::table('mainledger')
                     ->distinct()
                     ->leftJoin('game_life', function($join)
                         {
                             $join->on('mainledger.member_id', '=', 'game_life.member_id');
							 $join->on('game_life.gameid','=',DB::raw("'101'"));
                         })
                     ->where('mainledger.member_id', $memberid)
					 ->select('mainledger.current_point as point', 'game_life.remaining_life as life','mainledger.current_balance as balance','game_life.gameid') 
                     ->get();
		
		/*
		$results = DB::table('rooms')
                     ->distinct()
                     ->leftJoin('bookings', function($join)
                         {
                             $join->on('rooms.id', '=', 'bookings.room_type_id');
                             $join->on('arrival','>=',DB::raw("'2012-05-01'"));
                             $join->on('arrival','<=',DB::raw("'2012-05-10'"));
                             $join->on('departure','>=',DB::raw("'2012-05-01'"));
                             $join->on('departure','<=',DB::raw("'2012-05-10'"));
                         })
                     ->where('bookings.room_type_id', '=', NULL)
                     ->get();
		*/
		
		/*
		$result->join('mainledger', function($join)
		 {
		   $join->on('mainledger.member_id', '=', 'game_life.member_id');

		 })
		 ->select('mainledger.current_point as point', 'game_life.remaining_life as life','mainledger.current_balance as balance','game_life.gameid') 
		 ->where('mainledger.member_id', $memberid)
		 ->get();
		*/
		
		return $result;
	}
	
	//get ledger detail
	public static function get_ledger_details($playerid)
	{				
		return $result =  DB::table('mainledger')->where('id',$playerid)->get()->take(1);
	}
	
	private static function rules($condition = 'donothing', $memberid, $gameid = false)
	{
		switch ($condition)
		{
			case 'resetpoints':
			break;
			case 'resetlife':
			break;
			case 'donothing':
			break;
		}
	}
	public static function oldgame_walletupdate($input,$status,$type)
	{
		$mainledger = self::get_ledger_details($member_id);
		
		if($status === "win")
		{
			//
		}
		else{
			
		}
	}
	//update ledger
	public static function updateledger()
	{
		
	}
	//update ledger history
	public static function add_ledger_history()
	{
		
	}
	
	
	
	public static function game_walletupdate ($memberid, $gameid, $status, $gamelevel)
	{
		//$wallet = Game::get_ledger_details($member_id);
		$mainledger = Self:: current_wallet($memberid);

		//$level = Self::current_level($id);
		$level = Self::current_level_details($gamelevel);
		$levelid = Game::get_member_current_level($gameid, $memberid);
		$currentlevelid = Self::get_current_level($gameid,$memberid);
		//$level = Self::current_level_details($levelid)
		//print_r($level);
		//print_r($levelid);
		//print_r($currentlevelid);
		//print_r($mainledger);
			//die();

		//print
		//echo $mainledger->current_balance;
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
			
			Self::postmainledger($memberid,$balance_before,$current_balance,$current_bet,$current_life,$current_level,$current_point);
			Self::postledger_history($memberid,$credit,$debit,$credit_bal,$debit_bal,$balance_before,$balance_after,$current_balance,$credit_type,$award_bal_before,$award_bal_after,$award_current_bal,$current_point);
			$print=array($memberid,$balance_before,$current_balance,$current_bet,$current_life,$current_level,$current_point);
			$print2=array($memberid,$credit,$debit,$credit_bal,$debit_bal,$balance_before,$current_balance,$balance_after,$current_balance,$credit_type,$award_bal_before,$award_bal_after,$award_current_bal,$current_point);
			//print_r($status);
			//print_r($print);
			//print_r($print2);
			//print_r($member_id);
			//die();

			

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

			//print_r($memberid);
			//die();
			Self::postmainledger($memberid,$balance_before,$current_balance,$current_bet,$current_life,$current_level,$current_point);
			Self::postledger_history($memberid,$credit,$debit,$credit_bal,$debit_bal,$balance_before,$balance_after,$current_balance,$credit_type,$award_bal_before,$award_bal_after,$award_current_bal,$current_point);
			$print=array($memberid,$balance_before,$current_balance,$current_bet,$current_life,$current_level,$current_point);
			$print2=array($memberid,$credit,$debit,$credit_bal,$debit_bal,$balance_before,$current_balance,$balance_after,$current_balance,$credit_type,$award_bal_before,$award_bal_after,$award_current_bal,$current_point);
			//print_r($status);
			//print_r($print);
			//print_r($print2);
			
			
			//die();
		}
		//get the current balance/point
		//then based on the status debit/credit the wallet
		   // amend the mainledger
		   // add history
		   // life
		
		return $status;
	}




public static function postmainledger($memberid,$balance_before,$current_balance,$current_bet,$current_life,$current_level,$current_point)
{
	$now = Carbon::now()->toDateTimeString();
		$postmainledger=array(
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
			->update($postmainledger);


	
	
	return true;
}


public static function postledger_history($memberid,$credit,$debit,$credit_bal,$debit_bal,$balance_before,$balance_after,$current_balance,$credit_type,$award_bal_before,$award_bal_after,$award_current_bal,$current_point)
{
	$now = Carbon::now()->toDateTimeString();
	// For the reward point
	//$award_bal_before=$mainledger->current_point;
	//s$award_bal_before=$current_point;
	//$award_bal_after=$award_bal_before;
	//$award_current_bal=
	

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

	//print_r($award_bal_before);
	//print_r($award_bal_before);
	//print_r($current_point);
	//print_r($currentlevel);

	//print_r($postledger_history_PNT);
	//print_r($postledger_history_BAL);
	//die();


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

		if($current_balance>$bet_amount){
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
	
}










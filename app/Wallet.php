<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
use DB;
use Carbon\Carbon;
class Wallet extends Model
{   
    protected $fillable = [
        'member_id','current_life','current_balance','balance_before'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $table = 'mainledger';
	
	protected $table_life = 'game_life';
	
	protected $table_history = 'ledger_history';
	
	
	//update source ref id
	public static function add_ledger_ref($data)
	{
		if (empty($data['refid']))
		{	
			return FALSE;			
		}
		
		$id     = $data['refid'];
		$data   = [ 'ref_id'=>$data['id'], 'ref_type'=>$data['type'] ];		 
		$ledger = DB::table('ledger_history')
					   ->where('id', $id)
					   ->update($data );
		return TRUE;
	}
	
	
	public static function get_wallet_details($memberid)
	{		
		
		$result = [];
		if (!empty($memberid))
		{			
			return $result = DB::table('mainledger')->select('play_count','current_balance as balance','current_point as point', 'current_level as level', 'current_life as life','current_betting as bet','vip_life','vip_point'
			//,'current_life_acupoint as acupoint'
			, DB::raw('(case when current_life_acupoint is null then 0 else current_life_acupoint end) as acupoint')
			)->where('member_id', $memberid)->latest()->first();
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
	
	public static function merge_vip_wallet($memberid,$notes = FALSE,$nofee = FALSE)
	{
		$newpoint     = '';
		
		
		$wallet    = self::get_wallet_details_all($memberid);
		if ($wallet)
		{
			$now = Carbon::now();
			if ($wallet->vip_point > 0)
			{
				//Fee
				$setting     = \App\Admin::get_setting();
				$rfee = $fee = $setting->wabao_fee;
				//To avoid Admin Fee
				if ($nofee) $rfee = 0; 
				
				if ($rfee >=1 ) 
				{
					if ($wallet->vip_point >= $fee)
					{
						$wallet->vip_point = $adminfee = $wallet->vip_point - $fee;
					}
					else
					{
						$fee = $fee - $wallet->vip_point;
						$wallet->vip_point = 0;
					}
					$history = [
						'created_at' 	    => $now,
						'updated_at' 	    => $now,
						'member_id'         => $memberid,
						'credit'	        => $fee,
						'debit'	            => '0',
						'notes'             => $adminfee." Fee collected. ",
						'credit_type'	    => 'WVRFE',
						];

					$history = self::add_ledger_history($history);
				
				}
				//update VIP point
				$newpoint = 0;
				
				$history = [
					'created_at' 	    => $now,
					'updated_at' 	    => $now,
					'member_id'         => $memberid,
					'credit'	        => '0',
					'debit'	            => $wallet->vip_point,
					'before_vip_point'  => $wallet->vip_point,
					'current_vip_point' => $newpoint,
					'notes'             => $wallet->vip_point." VIP POINTS MERGED TO POINT. ".$notes,
					'credit_type'	    => 'DPVIP',
					];

				$data = [ 
					'updated_at'   => $now,
					'vip_point'    => $newpoint,
				];
				
				
				
				$history = self::add_ledger_history($history);
				
				
				
				
				$newpoint = $wallet->vip_point + $wallet->current_point;
				
				$history = [
					'created_at' 	    => $now,
					'updated_at' 	    => $now,
					'member_id'         => $memberid,
					'credit'	        => $wallet->vip_point,
					'debit'	            => 0,
					'balance_before'    => $wallet->current_point,
					'balance_after'     => $newpoint ,
					'current_balance'   => $newpoint ,
					'notes'             => $wallet->vip_point." VIP POINTS MERGED FROM POINT. ".$notes,
					'credit_type'	    => 'APMNT',
					];

				$data = [ 
					'updated_at'    => $now,
					'current_point' => $newpoint,
					'vip_point'     => 0,
				];
				
				$ledger  = DB::table('mainledger')
					   ->where('member_id', $memberid)
					   ->update($data);
				
				
				$history = self::add_ledger_history($history);
				
				event(new \App\Events\EventWalletUpdate($memberid));
				
				return $wallet->vip_point;
			}
		}
	}
	
	public static function update_basic_wallet($memberid,$life = 0,$point = 0,$category = 'PNT',$type = 'credit', $notes = FALSE)
	{
		$history      = '';
		$newpoint     = '';
		$newlife      = '';
		$action_sym   = '-1';
		$action_type  = 'DEBITED';
		$debit        = $point ; 
		$credit       = '';
		$prefix       = 'D';
		if ($type == 'credit')
		{
			$action_sym  = '1';
			$action_type = 'CREDITED';
			$credit      = $point;
			$debit       = '' ; 
			$prefix      = 'A';
		}
		
		$wallet    = self::get_wallet_details_all($memberid);
		if ($wallet)
		{
			$now = Carbon::now();
			if ($life > 0)
			{
				$newlife = $wallet->current_life + ($life * $action_sym) ;
				$history = [
					'created_at' 	   => $now,
					'updated_at' 	   => $now,
					'member_id'        => $memberid,
					'credit'	       => '0',
					'debit'	           => '0',
					'before_life'      => $wallet->current_life,
					'current_life'     => $newlife,					
					'notes'            => $life." LIFE $action_type ".$notes,
					'credit_type'	   => $prefix.'L'.$category,
					];

				$data = [ 
					'updated_at'    => $now,
					'current_life'  => $newlife,
				];
				
				$ledger  = DB::table('mainledger')
					   ->where('member_id', $memberid)
					   ->update($data);

				$history = self::add_ledger_history($history);
			}

			if ($point > 0)
			{
				$newpoint = $wallet->current_point + ($point * $action_sym);
				$history = [
					'created_at' 	    => $now,
					'updated_at' 	    => $now,
					'member_id'         => $memberid,
					'credit'	        => $credit,
					'debit'	            => $debit,
					'balance_before'    => $wallet->current_point,
					'balance_after'	    => $newpoint,
					'current_balance'	=> $newpoint,
					'notes'             => $point." POINTS $action_type ".$notes,
					'credit_type'	    => $prefix.'P'.$category,
					];

				$data = [ 
					'updated_at'    => $now,
					'current_point' => $newpoint,
				];
				
				$ledger  = DB::table('mainledger')
					   ->where('member_id', $memberid)
					   ->update($data);
				$history = self::add_ledger_history($history);
			}	
			event(new \App\Events\EventWalletUpdate($memberid));
			return ['success'=>true,'life'=>$newlife,'point'=>$newpoint,'refid'=>$history];		
		}
		return ['success'=>false,'message'=>'unknown record'];
	}
	
	public static function update_vip_wallet($memberid,$life = 0,$point = 0,$category = 'VIP',$type = 'credit', $notes = FALSE)
	{
		$history      = '';
		$newpoint     = '';
		$newlife      = '';
		$action_sym   = '-1';
		$action_type  = 'DEBITED';
		$debit        = $point ; 
		$credit       = '';
		$prefix       = 'D';
		if ($type == 'credit')
		{
			$action_sym  = '1';
			$action_type = 'CREDITED';
			$credit      = $point;
			$debit       = '' ; 
			$prefix      = 'A';
		}
		
		$wallet    = self::get_wallet_details_all($memberid);
		if ($wallet)
		{
			$now = Carbon::now();
			if ($life > 0)
			{
				$newlife = $wallet->vip_life + ($life * $action_sym) ;
				$history = [
					'created_at' 	   => $now,
					'updated_at' 	   => $now,
					'member_id'        => $memberid,
					'credit'	       => '0',
					'debit'	           => '0',
					'before_vip_life'  => $wallet->vip_life,
					'current_vip_life' => $newlife,					
					'notes'            => $life." VIP LIFE $action_type ".$notes,
					'credit_type'	   => $prefix.'L'.$category,
					];

				$data = [ 
					'updated_at'    => $now,
					'vip_life'  => $newlife,
				];
				
				$ledger  = DB::table('mainledger')
					   ->where('member_id', $memberid)
					   ->update($data);

				$history = self::add_ledger_history($history);
			}

			if ($point > 0)
			{
				$newpoint = $wallet->vip_point + ($point * $action_sym);
				$history = [
					'created_at' 	    => $now,
					'updated_at' 	    => $now,
					'member_id'         => $memberid,
					'credit'	        => $credit,
					'debit'	            => $debit,
					'before_vip_point'  => $wallet->vip_point,
					'current_vip_point' => $newpoint,
					'notes'             => $point." VIP POINTS $action_type ".$notes,
					'credit_type'	    => $prefix.'P'.$category,
					];

				$data = [ 
					'updated_at'   => $now,
					'vip_point'    => $newpoint,
				];
				
				$ledger  = DB::table('mainledger')
					   ->where('member_id', $memberid)
					   ->update($data);
				$history = self::add_ledger_history($history);
			}
			event(new \App\Events\EventWalletUpdate($memberid));
			return ['success'=>true,'life'=>$newlife,'point'=>$newpoint,'refid'=>$history];		
		}
		return ['success'=>false,'message'=>'unknown record'];
	}
	
	
	
	public static function update_bonus_life($memberid,$bonus = 0,$column = 'introduce_bonus_life')
	{
		//second_level_bonus_life
		/*
		$bonuslife = \App\Bonuslife::updateOrCreate(['member_id' => $memberid], [ 
						$column => DB::raw("$column" + $bonus)
					]);
		*/
		/*
		DB::table('bonus_life_count')
		   ->where('member_id', $memberid)
		   ->update([
			   $column => DB::raw("$column" + $bonus)
		   ]);
		   */
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
				'credit_type'	  => 'A'.$category,
				];

			$data = [ 
				'updated_at'    => $now,
				'current_life'  => $newlife,
			];

			$ledger  = DB::table('mainledger')
					   ->where('member_id', $memberid)
					   ->update($data);

			$history = self::add_ledger_history($history);
			event(new \App\Events\EventWalletUpdate($memberid));
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
			$prefix      = 'A';
		}
		else if ($type == 'debit'){
			$debit = $amendpoint;
			$balance_after = $balance  - $debit ;
			$prefix      = 'D';
		}
		
		else if ($type == 'acpoint'){
			$credit = $amendpoint;
			$balance_after = $balance  + $amendpoint ;
			
			if ($amendpoint < $wallet->current_life_acupoint)
			{
				if ($wallet->current_life_acupoint > 150)
				{
					$purgedpoint = $wallet->current_life_acupoint - $amendpoint ;
					$notes .= $purgedpoint.' points Purged. ';
				}
			}
			$prefix      = 'AP';
			$notes .= 'Acpoint: '.$amendpoint.' Redeemed';
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
			'credit_type'	  => $prefix.$category,
			];		
		
		$data = [ 
			'updated_at'   => $now,
			"$mainfield"   => $balance_after,
		];
		
		if ($type == 'acpoint') {
			$data['current_life_acupoint'] = 0;
		}		
		$ledger  = DB::table('mainledger')
				   ->where('member_id', $memberid)
				   ->update($data);
		
		$history = self::add_ledger_history($history);
		
		event(new \App\Events\EventWalletUpdate($memberid));
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
		//$levelid = Game::get_member_current_level($gameid, $memberid);
		//$currentlevelid = Self::get_current_level($gameid,$memberid);

		
		if($status=="win")
		{
			//$credit_type                    ='PNT';
			//$member_id                      = $memberid;
			$balance_before                 = $mainledger->current_balance;
			$credit                         = $level->point_reward;
			$debit                          = '0';
			$credit_bal  					= 1200- $balance_before;
			$debit_bal                      = 0;
			$current_balance                = '1200';
			$balance_after                  = '1200';
			$current_point					= $mainledger->current_point;// + $level->point_reward;
			$current_bet                    = $level->bet_amount;//how much they bet
			$current_life                   = $mainledger->current_life;
			$current_balance				= $balance_after;
			$current_level					= $level->game_level;
			$current_life_acupoint			= $mainledger->current_life_acupoint+$level->point_reward;

			$award_bal_before				= $mainledger->current_life_acupoint;;//- $level->point_reward;
			$award_bal_after				= $award_bal_before+$credit;
			$award_current_bal				= $award_bal_before+$credit;
			$category                       = 'A';
			Self::updatemainledger($memberid,$balance_before,$current_balance,$current_bet,$current_life,$current_level,$current_point,$current_life_acupoint);
			Self::postledger_history($memberid,$credit,$debit,$credit_bal,$debit_bal,$balance_before,$balance_after,$current_balance,$award_bal_before,$award_bal_after,$award_current_bal,$current_point,$category);

			

		}else if ($status=="lose")
		{
			//check for PNT
			//$member_id                      = $memberid;
			//$credit_type                    ='PNT';
			$balance_before                 = $mainledger->current_balance;
			$current_balance                = $mainledger->current_balance - (is_null($level->bet_amount) ? 0 : $level->bet_amount);
			$balance_after                  = $mainledger->current_balance - (is_null($level->bet_amount) ? 0 : $level->bet_amount);
			$current_point					= $mainledger->current_point;
			$current_bet                    = $level->bet_amount;
			$current_life                   = $mainledger->current_life;
			$current_level					= $level->game_level;
			$credit                   		= 0;
			$debit                    		= 0; //"{{ $level->bet_amount}}"
			$credit_bal  					= 0;
			$debit_bal                      = $balance_before-$balance_after;
			$current_life_acupoint			= $mainledger->current_life_acupoint+$credit;
			$award_bal_before				= $mainledger->current_life_acupoint;
			$award_bal_after				= $award_bal_before+$credit_bal;
			$award_current_bal				= $award_bal_before+$credit_bal;
			$category                       = 'D';
			

			// Self::updatemainledger($memberid,$balance_before,$current_balance,$current_bet,$current_life,$current_level,$current_point,$current_life_acupoint);
			// Self::postledger_history($memberid,$credit,$debit,$credit_bal,$debit_bal,$balance_before,$balance_after,$current_balance,$credit_type,$award_bal_before,$award_bal_after,$award_current_bal,$current_point);
			Self::updatemainledger($memberid,$balance_before,$current_balance,$current_bet,$current_life,$current_level,$current_point,$current_life_acupoint);
			Self::postledger_history($memberid,$credit,$debit,$credit_bal,$debit_bal,$balance_before,$balance_after,$current_balance,$award_bal_before,$award_bal_after,$award_current_bal,$current_point,$category);

			

		}
		//get the current balance/point
		//then based on the status debit/credit the wallet
		   // amend the mainledger
		   // add history
		   // life
		event(new \App\Events\EventWalletUpdate($memberid));
		return ['status'=>$status,'point'=>$current_point,'balance'=>$current_balance,'acupoint'=>$current_life_acupoint];
		return $status;
	}




public static function updatemainledger($memberid,$balance_before,$current_balance,$current_bet,$current_life,$current_level,$current_point,$current_life_acupoint)
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
		'current_life_acupoint'		=>	$current_life_acupoint,	
		
		);
	
		DB::table('mainledger')->
			where('member_id', $memberid)
			->update($updatemainledger);
	event(new \App\Events\EventWalletUpdate($memberid));
	return true;
}


public static function postledger_history($memberid,$credit,$debit,$credit_bal,$debit_bal,$balance_before,$balance_after,$current_balance,$award_bal_before,$award_bal_after,$award_current_bal,$current_point,$category = FALSE)
{
	$now = Carbon::now()->toDateTimeString();

	if (!empty($credit) || !empty($debit)) {
		$postledger_history_PNT=array(
		'created_at' 				=>	$now,
		'updated_at' 				=>	$now,
		'member_id'                 =>  $memberid,
		'credit'	                =>  $credit,
		'debit'	                    =>  $debit,
		'balance_before' 			=>	$award_bal_before,
		'balance_after' 		    =>	$award_bal_after,
		'current_balance'           =>  $award_current_bal,
		'credit_type'	            =>  $category.'PNT',
		);
		
		DB::table('ledger_history')->
			insert($postledger_history_PNT);
	}

	// For the betting balance
	if (!empty($credit_bal) || !empty($debit_bal)) {
		$postledger_history_BAL=array(
		'created_at' 				=>	$now,
		'updated_at' 				=>	$now,
		'member_id'                 =>  $memberid,
		'credit'	                =>  $credit_bal,
		'debit'	                    =>  $debit_bal,
		'balance_before' 			=>	$balance_before,
		'balance_after' 		    =>	$balance_after,
		'current_balance'           =>  $current_balance,
		'credit_type'	            =>  $category.'BAL',
		);
		
		DB::table('ledger_history')->
			insert($postledger_history_BAL);

	}
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
		$playablestatus = false;
		$redeempointstatus = false;
		
		$mainledger = Self::current_wallet($memberid);
		//$mainledger = DB::table('mainledger')->where('member_id',$memberid)->get()->first();
		$game_levels = DB::table('game_levels')->where('id', $gamelevel)->get()->first();
		$current_balance = isset($mainledger->current_balance) ? $mainledger->current_balance : 0;
		$bet_amount = isset($game_levels->bet_amount) ? $game_levels->bet_amount : 0;
		$current_life_acupoint= isset($mainledger->current_life_acupoint) ? $mainledger->current_life_acupoint : 0;
		//$life= 'yes';
		//$redeempointstatus = false;
		if ($mainledger->current_life >=1)
		{
			if($current_balance>=$bet_amount && $current_life_acupoint<150){
				$playablestatus = true;
				$redeempointstatus = false;
			}else if($current_life_acupoint>=150){
				$redeempointstatus = true;
				$playablestatus = false;
			}else{
				$playablestatus = false;
				$redeempointstatus = false;
			}
		}
		$point = $mainledger->current_point;
		if ($mainledger->current_point < $game_levels->bet_amount)
		{
			$point = 0;
		}
		

		return ['playablestatus' => $playablestatus, 'redeempointstatus' => $redeempointstatus, 'life' => $mainledger->current_life, 'point' => $point];
	}
	
	public static function get_current_level($gameid,$memberid)
	{
		return $result = DB::table('member_game_result')->where('game_id', $gameid)->where('member_id', $memberid)->latest()->first();

	}

// 	public static function postledger_history_life($memberid,$credit_bal,$debit_bal,$balance_before,$balance_after,$current_balance)
// {
// 	$now = Carbon::now()->toDateTimeString();

// 	// For the betting balance

// 	$postledger_history_life=array(
// 	'created_at' 				=>	$now,
// 	'updated_at' 				=>	$now,
// 	'member_id'                 =>  $memberid,
// 	'credit'	                =>  $credit_bal,
// 	'debit'	                    =>  $debit_bal,
// 	'balance_before' 			=>	$balance_before,
// 	'balance_after' 		    =>	$balance_after,
// 	'current_balance'           =>  $current_balance,
// 	'credit_type'	            =>  'BAL',
// 	);


// 	$insdata= $postledger_history_life;

// 	DB::table('ledger_history')->
// 			insert($insdata);

// 		return true;
// 	}



	
	
	public static function life_redeem_post_ledgerhistory_bal($memberid,$credit_bal,$debit_bal,$balance_before,$balance_after,$current_balance)
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
			'credit_type'	            =>  'RBAL',
		);

		$insdata= $postledger_history_BAL;

		DB::table('ledger_history')->
				insert($insdata);
		
        return true;
	}
	public static function life_redeem_post_ledgerhistory_pnt($memberid,$credit,$debit,$award_bal_before,$award_bal_after,$award_current_bal)
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
			'credit_type'	            =>  'RPNT',

		);

		$insdata= $postledger_history_PNT;

		DB::table('ledger_history')->
				insert($insdata);		
        return true;
	}


	public static function life_redeem_post_ledgerhistory_crd($memberid,$credit,$debit,$crd_bal_before,$crd_bal_after,$crd_current_bal)
	{
		$now = Carbon::now()->toDateTimeString();
		$postledger_history_CRD=array(
			'created_at' 				=>	$now,
			'updated_at' 				=>	$now,
			'member_id'                 =>  $memberid,
			'credit'	                =>  $credit,
			'debit'	                    =>  $debit,
			'balance_before' 			=>	$crd_bal_before,
			'balance_after' 		    =>	$crd_bal_after,
			'current_balance'           =>  $crd_current_bal,
			'credit_type'	            =>  'CRPNT',
		);

		$insdata= $postledger_history_CRD;

		DB::table('ledger_history')->
				insert($insdata);
			
        return true;


	}
	public static function life_redeem_update_mainledger($current_balance,$current_life,$memberid,$current_life_acupoint,$current_point)
{
	$now = Carbon::now()->toDateTimeString();
		$updatemainledger=array(
		'updated_at' 				=>	$now,
		'current_balance'           =>  $current_balance,
		'current_life'	            =>  $current_life,
		'current_life_acupoint'	    =>  $current_life_acupoint,
		'current_point'	    		=>  $current_point,
		);
	
		DB::table('mainledger')->
			where('member_id', $memberid)
			->update($updatemainledger);
	
	return true;
}
	
	public static function new_game_wallet_update ($memberid, $status, $level, $gameid = FALSE)
	{
		$mainledger = self::current_wallet($memberid);
		$now = Carbon::now()->toDateTimeString();
		$_bal = 1200;
		if ($gameid == 102) {
			$_bal = 120; //temporary hardcoded... need to move into db.. configurable
		}

		if($status=="win")
		{
			/*
			$se_game  = \App\Game::where('id',$gameid)->first();
			
			if (!empty($se_game->win_ratio))
			{
				$level->point_reward = $level->point_reward * $se_game->win_ratio;
			}
			*/
			
			$balance_before                 = $mainledger->current_balance;
			$credit                         = $level->point_reward;
			$debit                          = '0';
			$credit_bal  					= $_bal - $balance_before;
			$debit_bal                      = 0;
			$current_balance                = $_bal;
			$balance_after                  = $_bal;
			$current_point					= $mainledger->current_point;// + $level->point_reward;
			$current_bet                    = $level->bet_amount;//how much they bet
			$current_life                   = $mainledger->current_life;
			$current_balance				= $balance_after;
			$current_level					= $level->game_level;
			$current_life_acupoint			= $mainledger->current_life_acupoint+$level->point_reward;

			$award_bal_before				= $mainledger->current_life_acupoint;;//- $level->point_reward;
			$award_bal_after				= $award_bal_before+$credit;
			$award_current_bal				= $award_bal_before+$credit;
			$category                       = 'A';
			
			
			
			$updatemainledger = [				
				'updated_at' 				=>	$now,
				'balance_before'            =>  $balance_before,
				'current_balance'           =>  $current_balance,
				'current_life_acupoint'		=>	$current_life_acupoint,	
				'play_count'		        =>	$mainledger->play_count+1,	
				];

			DB::table('mainledger')->
				where('member_id', $memberid)
				->update($updatemainledger);	
			
			
			Self::postledger_history($memberid,$credit,$debit,$credit_bal,$debit_bal,$balance_before,$balance_after,$current_balance,$award_bal_before,$award_bal_after,$award_current_bal,$current_point,$category);
			
			
		}
		else if($status=="lose")
		{
			$balance_before                 = $mainledger->current_balance;
			$current_balance                = $mainledger->current_balance - (is_null($level->bet_amount) ? 0 : $level->bet_amount);
			$balance_after                  = $mainledger->current_balance - (is_null($level->bet_amount) ? 0 : $level->bet_amount);
			$current_point					= $mainledger->current_point;
			$current_bet                    = $level->bet_amount;
			$current_life                   = $mainledger->current_life;
			$current_level					= $level->game_level;
			$credit                   		= 0;
			$debit                    		= 0; //"{{ $level->bet_amount}}"
			$credit_bal  					= 0;
			$debit_bal                      = $balance_before-$balance_after;
			$current_life_acupoint			= $mainledger->current_life_acupoint+$credit;
			$award_bal_before				= $mainledger->current_life_acupoint;
			$award_bal_after				= $award_bal_before+$credit_bal;
			$award_current_bal				= $award_bal_before+$credit_bal;
			$category                       = 'D';
			
						
			
			$updatemainledger = [				
				'updated_at' 				=>	$now,
				'balance_before'            =>  $balance_before,
				'current_balance'           =>  $current_balance,
				'current_life_acupoint'		=>	$current_life_acupoint,	
				'play_count'		        =>	$mainledger->play_count+1,	
				];

			DB::table('mainledger')->
				where('member_id', $memberid)
				->update($updatemainledger);
			
			
			self::postledger_history($memberid,$credit,$debit,$credit_bal,$debit_bal,$balance_before,$balance_after,$current_balance,$award_bal_before,$award_bal_after,$award_current_bal,$current_point,$category);
			
			
		}
		
		event(new \App\Events\EventWalletUpdate($memberid));
		return ['status'=>$status,'point'=>$current_point,'balance'=>$current_balance,'acupoint'=>$current_life_acupoint,'credit'=>$credit ];
	}
	
	public static function add_topup_request($chunk)
	{
		$id = \DB::table('request_topup')->insertGetId($chunk);
		return $id;
	}
	
	public static function update_topup_request($id, $data = [])
	{
		if ($id)
		{
			\DB::table('request_topup')
            	->where('id', $id)
            	->update($data);
		}		
	}



}










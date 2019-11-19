<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use DB;



class Members extends Model
{   
    use Notifiable;
	
	protected $dates = ['key_expired_at'];
	
	protected $fillable = [
        'username',
        'email',
		'password',
		'affiliate_id',
		'referred_by',
		'wechat_name',
		'phone',
		'wechat_verification_status',
		'game_life',
		'current_life',
		'gender','profile_pic','openid',
		'activation_code',
		'activation_code_expiry',
		'number_location',
		'alipay_account'
		
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $table = 'members';
	
	public static function save_member($request)
	{		
		print_r($request);
	}
	
	public static function update_member($id,$data)
	{	
		print_r($data);die();
		 return $result = DB::table('members')
            ->where('id', $id)
            ->update($data);
		/*
		DB::enableQueryLog();
		print_r(DB::getQueryLog());
		try {
				DB::table('members')
					->where('id', $id)
					->update($data);
				 return TRUE;
			}  catch (\Exception $ex) {

				 //dd($ex);
				 return response()->json(['success' => false, 'record' => '']);
			}
		*/
		
	}
	
	public static function get_member($id)
	{
		$result = DB::table('members')->where('id', $id)->first();
		
		return $result;
	}
	
	public static function get_child($refid)
	{
		$result = Members::select('username','created_at','wechat_name','wechat_verification_status','member_status')->where('referred_by', $refid)->get();
		return $result;
	}
	
	public static function get_child_with_page($refid,$status,$limit = 50)
	{
		$result = Members::select('username','created_at','wechat_name','wechat_verification_status','member_status')->where('referred_by', $refid);
				
		if ($status != '') $result->whereIn('wechat_verification_status', $status);
		
		$out = $result->paginate($limit);
		return $out;
	}
	
	public static function get_view_member($id)
	{
		$result = DB::table('view_members')->where('id', $id)->first();
		
		return $result;
	}
	
	public static function get_member_referral_list($id)
	{
		if (empty($id)) return [];
		
		$result = DB::table('members')->select('id','affiliate_id','username','firstname','firstname')->where('referred_by', $id)->get();
		
		return $result;
	}
	
	public static function CheckReferral($refid)
	{
		$result = DB::table('members')->select('id','affiliate_id','username','firstname','firstname','realname')->where('affiliate_id', $refid)->first();
		
		return $result;
	}
	
	
	public static function get_pending_wechat_members($limit = 100)
	{
		$result =  DB::table('members')->whereNotNull('wechat_name')->where('wechat_verification_status', 1)->paginate($limit);
		
		return $result;
	}
	
	public static function get_introducer_life($id = 1)
	{
		//$result = DB::table('settings')->where('id', $id)->pluck('introduce_life');
		$result = DB::table('settings')->select('introduce_life','second_level_introduce_life')->where('id', $id)->first();
		return $result;
	}
	
	public static function get_introducer_count($id, $status = null)
	{
		if (empty($status)) {
			$result = DB::table('view_member_introduce_count')->where('memberid', $id)->first();
		} else {
			$result = DB::table('view_member_introduce_count')->where('memberid', $id)->where('wechat_verification_status', $status)->first();
		}
		
		
		return $result;
	}
	
	public static function get_introducer_history($refid,$status,$limit = 50)
	{
		$result = Members::select('id','username','firstname','created_at','phone','introducer_life','wechat_verification_status','wechat_name','profile_pic')->where('referred_by', $refid);
				
		if ($status != '') $result->whereIn('wechat_verification_status', $status);
		
		$out = $result->orderby('created_at','DESC')->paginate($limit);
		return $out;
	}
	
	
	public static function get_wabao_coin_history($id)
	{
		$result = DB::table('view_wabao_point')->where('memberid', $id)->orderby('created_at','DESC')->get();
		
		return $result;
	}
	
	public static function get_second_level_child_count($memberid)
	{
		$result = DB::select( DB::raw("SELECT
					id,username,firstname,created_at,phone,introducer_life,wechat_verification_status,referred_by
				FROM
					( SELECT * FROM members ORDER BY referred_by, id ) child_sorted,
					( SELECT @pv := :memberid ) initialisation 
				WHERE
					find_in_set( referred_by, @pv ) 
					AND length( @pv := concat( @pv, ',', id ) )"), array(
									   'memberid' => $memberid,
									 ));
				
		$result = self::removeElementWithValue($result, "referred_by", $memberid);
		
		return $result;
	}
	
	public static function removeElementWithValue($array, $key, $value)
	{
		$rv    = [];
		$count = 0;
		$child = [];
		//find first level childs
		foreach($array as $subKey => $subArray)
		{
			if($subArray->{$key} == $value)
			{
				$rv[] = $subArray->id;
				unset($array[$subKey]);
			}
		 }
				
		//find second level childs		
		foreach($array as $subKey => $subArray)
		{
			if (in_array($subArray->referred_by, $rv)) 
			{
				$child[] = $subArray;
				$count++;
			}
		}
		return ['count'=>$count,'data'=>$child];
	}
	
	public static function get_second_level_child_data($memberid, $status = 0)
	{
		$result = DB::table('members')->select('id','username','firstname','created_at','phone','introducer_life','wechat_verification_status','referred_by','introducer_bonus_life','wechat_name','profile_pic')
				->whereIn('referred_by', function($query) use ($memberid)
				{
					$query->select('id')
						  ->from('members')
						  ->whereRaw('referred_by = '.$memberid);
				})
				->whereIn('wechat_verification_status',$status)
				->paginate(15);
		return $result;
	}
	public static function get_second_level_child_count_new($memberid)
	{	
		$result_count = DB::table('members')->select('wechat_verification_status',DB::raw('count(1) as count'))
				->whereIn('referred_by', function($query) use ($memberid)
				{
					$query->select('id')
						  ->from('members')
						  ->whereRaw('referred_by = '.$memberid);
				})
				->groupBy('wechat_verification_status')->get();
		
		
		return $result_count;
	}
	public static function generate_apikey($memberid,$expire)
	{
		
		$apikey  = unique_numeric_random('members', 'apikey', 8);
		$data = [
				'key_expired_at' => $expire,
				'apikey' => $apikey,
			];
		
		$result = Members::where('id', $memberid)
            ->update($data);
		
		return ['apikey'=>$apikey, 'expired_at'=>$expire];
		
	}
	
	
	public static function purge_game_life($user)
    {				
		$msg = 'no changes on life';
		$gameid = 102;
		if ($user->is_purged_gamelife != 1)
		{
			$usedlife = \App\Game::IsFirstLife($user->id);
			
			//\Log::debug(json_encode(['used life' =>$usedlife,'phone'=>$user->phone,'wechat_name'=>$user->wechat_name], true));
						
			if ($usedlife < 1)
			{
				if (\Carbon\Carbon::parse($user->created_at)->lt(\Carbon\Carbon::now()->subDay(1)))
				{
					//\Log::debug(json_encode(['date gt 24 hrs' =>'yes','phone'=>$user->phone,'wechat_name'=>$user->wechat_name], true));
					
					$wallet = \App\Wallet::get_wallet_details($user->id);
					
					if (!empty($wallet->life))
					{
						$max_po = \Config::get('app.coin_max');
						
						if (!$max_po) $max_po = 15;
						
						if ($wallet->acupoint < $max_po) 
						{
							$wallet->acupoint = 0;
						}
						else
						{
							$wallet->acupoint = $max_po;
						}
						
						$credit_bal=0;
						$_bal = 120;
						
						$current_life	= $wallet->life-1;
						$credit        	= 0;
						$debit        	= $wallet->acupoint; 


	// ---------------------Balance--------------------------------------
						$balance_before		=$wallet->balance;
						if($balance_before!=$_bal){
							$credit_bal= $_bal-$wallet->balance;
						}
						$current_balance	= $wallet->balance +$credit_bal;
						$balance_after		= $current_balance;
						$debit_bal			= 0;
						$current_level 		= 1;
						$current_bet 		= $wallet->bet;
	// ---------------------Point--------------------------------------

						$award_bal_before		= $wallet->acupoint;
						$award_bal_after		= $award_bal_before-$wallet->acupoint;
						$award_current_bal		= $award_bal_before-$wallet->acupoint;
						$current_life_acupoint	= $award_bal_before-$wallet->acupoint;

						$current_point=$wallet->point+ $wallet->acupoint;
					
						
						//ac credit 
						$crd_credit             = $wallet->acupoint;
						$crd_debit              = 0; 
						$crd_bal_before			= $wallet->point;
						$crd_bal_after			= $crd_bal_before+$wallet->acupoint;
						$crd_current_bal		= $crd_bal_after;
						
						
						//update main ledger
						$mainledger = [ 
							'current_point'         => $current_point,
							'current_balance'       => $current_balance,
							'current_life_acupoint' => $wallet->acupoint,
						];
						
						DB::table('mainledger')->
							where('member_id', $user->id)
							->update($mainledger);
						
						//update point ledger balance
						\App\Wallet::life_redeem_post_ledgerhistory_bal($user->id,$credit_bal,$debit_bal,$balance_before,$balance_after,$current_balance);
						//update point ledger history
						\App\Wallet::life_redeem_post_ledgerhistory_pnt($user->id,$credit,$debit,$award_bal_before,$award_bal_after,$award_current_bal);						
						//ac credit
						\App\Wallet::life_redeem_post_ledgerhistory_crd($user->id,$crd_credit,$crd_debit,$crd_bal_before,$crd_bal_after,$crd_current_bal);
						
						//reset game level
						Game::reset_member_game_level($user->id , $gameid);
						
						
						
						//reduce one life 
						\App\Wallet::update_basic_wallet($user->id,1,0,'PWL','deduct', '.Auto purged 1 life');
						\Log::debug(json_encode(['purged life' => 1,'phone'=>$user->phone,'wechat_name'=>$user->wechat_name], true));
						
						$msg = '1 purged life';
					}					
					//update flag
					$user->is_purged_gamelife = 1;
					$user->save();
					
					return response()->json(['success' => true,'message' => $msg]);
				}	
			}
			else
			{
				//update flag
				$user->is_purged_gamelife = 1;
				$user->save();
				
				$msg = 'flag updated.no changes on life';
			}	
		}
		
		return response()->json(['success' => false,'message' => $msg]);
	}
	
		
		
}
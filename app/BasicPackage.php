<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
use DB;

use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;
class BasicPackage extends Model
{   
    use SoftDeletes;
	
	protected $fillable = [
        'package_name','seq'
    ];
	
	protected $softDelete = true;
	protected $dates = ['deleted_at'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $table   = 'basic_package';
	
	
	public static function get_package($id)
	{
		$result = DB::table('basic_package')->where('id', $id)->first();
		
		return $result;
	}
	public static function get_view_package($id)
	{
		$result = DB::table('view_basic_package')->where('id', $id)->first();
		
		return $result;
	}
	
	
	public static function list_available_redeem_package($point)
	{		
		$result = DB::table('view_basic_package')->where('package_status', '=', 1);
		
		if (!empty($point))
		{
			//$result = $result->where('min_point', '<=', $point);
		}
		//$result = $result->paginate(50);
		
		$result = $result->get();
		
		return $result;
	}
	
	public static function get_package_history($memberid, $limit = 100)
	{
		$result =  DB::table('view_basic_package')->where('member_id', $memberid)->orderBy('request_at', 'DESC')->paginate($limit);
		return $result;
	}	
	
	
	public static function get_active_package_by_member($memberid)
	{
		$result =  DB::table('view_active_basic_package')->where('member_id', $memberid)->first();
		
		return $result;
	}
	
	public static function get_redeem_package($id, $memberid)
	{
		$result =  DB::table('view_active_basic_package')->where('id', $id)->where('member_id', $memberid)->where('redeem_state', 2)->first();
		
		return $result;
	}
	
	public static function get_package_byid($id)
	{
		$result = DB::table('view_active_basic_package')->where('id', $id)->first();
		
		return $result;
	}
	
	public static function update_package($id,$data)
	{	
		if (!empty($id))
		{
			return $result = DB::table('basic_package')
            ->where('id', $id)
            ->update($data);
		}		 		
	}
	
	public static function save_package($chunk)
	{
		return DB::table('basic_package')->insertGetId($chunk);
	}
	
	public static function delete_package($id)
	{
		
		BasicPackage::find($id)->delete();
		return true;
		//DB::table('package')->delete($id);
	}
	
	public static function save_manybasic_package($chunk)
	{
		return DB::table('basic_redeemed')->insert($chunk);
	}
	
	public static function save_basic_package($chunk)
	{
		return DB::table('basic_redeemed')->insertGetId($chunk);
	}	
	
	public static function update_redeemed($id,$data)
	{	
		if (!empty($id))
		{
			return $result = DB::table('basic_redeemed')
            ->where('id', $id)
            ->update($data);
		}		 		
	}
	
	public static function get_basic_package($id)
	{
		$result = DB::table('basic_redeemed')->where('id', $id)->first();
		
		return $result;
	}
	
	public static function update_basicpackage($id,$data)
	{	
		if (!empty($id))
		{
			return $result = DB::table('basic_redeemed')
            ->where('id', $id)
            ->update($data);
		}		 		
	}	
	
	public static function get_basicpackage_list($memberid, $limit = 100)
	{
		$result =  DB::table('view_basic_package_user_list')->select('*',DB::raw("(CASE WHEN redeem_state='3' THEN passcode WHEN redeem_state='2' THEN passcode ELSE ''  END) as passcode"))->where('member_id', $memberid)->orderBy('created_at', 'DESC')->get();
		return $result;
	}
	
	public static function get_available_quantity($id)
	{
		$result =  DB::table('basic_package')->select('available_quantity')->where('id', $id)->first();
		return $result;
	}
	
	public static function get_redeem_package_passcode($passcode, $memberid)
	{
		$result =  DB::table('view_active_basic_package')->where('passcode', $passcode)->where('member_id', $memberid)->where('redeem_state', 2)->first();
		
		return $result;
	}
		
	public static function get_current_package($memberid,$all = FALSE)
	{
		$result =  DB::table('basic_redeemed');
		if (!$all) $result->select('id');
		
		$out = $result->where('member_id', $memberid)->where('redeem_state', 3)->first();
		return $out;
	}
	
	public static function reset_current_package($id)
	{	
		if (!empty($id))
		{
			return $result = DB::table('basic_redeemed')
            ->where('id', $id)
            ->update(['redeem_state'=>4]);
		}		 		
	}
	
	public static function get_redeemed_package_count($memberid)
	{
		//$count = DB::table('vip_redeemed')->where('member_id',$memberid)->where('redeem_state',4)->count();
		
		$count = DB::table('view_basic_status')->where('member_id',$memberid)->where('redeem_state',4)->first();
				
		if (!$count) return 0;
		else return $count->count;
	}
	
	public static function get_redeemed_package_reward($packageid = FALSE,$memberid = FALSE)
	{
		$result = DB::table('view_basic_betting');
		
		if ($memberid)  $result->where('member_id',$memberid);
		
		if ($packageid) $result->where('package_id',$packageid);
		
		$out = $result->sum('rewardamt');
		if (empty($out))
		{
			$out = '0';
		}
		
		return $out ;
		
	}
	
	public static function get_redeem_history($memberid, $status ,$limit = 100)
	{		
		$result = DB::table('view_basic_package_user_list')->where('member_id', $memberid);
				
		if ($status != '') $result->whereIn('redeem_state', $status);
		
		$result = $result->orderby('created_at','DESC')->paginate($limit);
		
		return $result;		
	}
	
	public static function today_redeemded($memberid,$type = 'count')
	{
		
		$count  = '';
		$c_data = DB::table('view_basic_package_user_list')->where('member_id',$memberid)->whereDate('created_at', '=', Carbon::today()->toDateString())->count();
		
		if ($c_data >= 1)
		{
			$count = DB::table('view_basicpackage_status')->where('member_id',$memberid)->wherein('redeem_state',[1,2,3,4]);
		
			if ($type == 'count')
			{
				$count = $count->count();
			}
			else
			{
				$count = $count->get();
			}	
		}		
				
		if (!$count) return 0;
		else return $count;
	}
	
	
	public static function today_redeemded_new($memberid,$type = 'count')
	{		
		
		$count = DB::table('view_basic_package_user_list')->wherein('redeem_state',[1,2,3,4])->where('member_id',$memberid)->whereDate('created_at', '=', Carbon::today()->toDateString());

		if ($type == 'count')
		{
			$count = $count->count();
		}
		else
		{
			$count = $count->get();
		}	
				
				
		if (!$count) return 0;
		else return $count;
	}
	
	public static function check_vip_status($memberid)
	{
		//no special check requirement
		return ['eligible_to_enter'=>'true','debug_'=>['no_requirement']];
		
		//check requirement		
		$eligible_to_enter = FALSE;
		$basic_count       = [];
		$vip_count         = [];
		$ito_count         = [];
		$rede_count        = [];
		$playcount         = \DB::table('member_game_result')->where('game_id',103)->where('member_id',$memberid)->count();
		$trueon            = ['playcount'];
		//print_r($playcount );
		
		if ($playcount < 1 )
		{
			$basic_count = \DB::table('view_basic_member_redeem_count')->where('member_id',$memberid)->first();
			//$vip_count   = \DB::table('view_vip_member_redeem_count')->where('member_id',$memberid)->first();
			$ito_count   = \DB::table('view_member_introduce_count')->where('wechat_verification_status',0)->where('memberid',$memberid)->first();
			$rede_count  = \DB::table('view_buy_product_count')->where('member_id',$memberid)->first();
			$ledger      = \DB::table('mainledger')->where('member_id',$memberid)->first();
							 
			//purchased package
			if ($basic_count)
			{
				if ($basic_count->used_quantity >= 1)
				{
					$eligible_to_enter = TRUE;
					$trueon[] = 'basic_count';
				}
			}
			//redeemed product
			if ($rede_count)
			{
				if ($rede_count->used_quantity >= 1)
				{
					$eligible_to_enter = TRUE;
					$trueon[] = 'rede_count';
				}
			}
			//success invite a friend
			if (!empty($ito_count))
			{
				if ($ito_count->count >= 1)
				{
					$eligible_to_enter = TRUE;
					$trueon[] = 'ito_count';
				}
			}
			/*
			//bet require minimum 120 point in wallet
			if ($ledger)
			{
				if ($ledger->current_point >= 120)
				{
					$eligible_to_enter = TRUE;
					$trueon[] = 'ledger';
				}
			}
			*/
			if ($eligible_to_enter == TRUE)
			{
				$eligible_to_enter = 'true';
			}
		}
		else
		{
			$eligible_to_enter = 'true';
		}
		
		return ['eligible_to_enter'=>$eligible_to_enter,'debug_'=>$trueon];
	}
	
}






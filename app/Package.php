<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
use DB;

use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;
class Package extends Model
{   
    use SoftDeletes;
	
	protected $fillable = [
        'package_name',
    ];
	
	protected $softDelete = true;
	protected $dates = ['deleted_at'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $table   = 'package';
	
	public $table_vip  = 'vip_redeemed';
	
	public static function get_package($id)
	{
		$result = DB::table('package')->where('id', $id)->first();
		
		return $result;
	}
	public static function get_view_package($id)
	{
		$result = DB::table('view_package')->where('id', $id)->first();
		
		return $result;
	}
	
	
	public static function list_available_redeem_package($point)
	{		
		$result = DB::table('package')->where('package_status', '=', 1);
		
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
		$result =  DB::table('view_package')->where('member_id', $memberid)->orderBy('request_at', 'DESC')->paginate($limit);
		return $result;
	}	
	
	
	public static function get_active_package_by_member($memberid)
	{
		$result =  DB::table('view_active_vip_package')->where('member_id', $memberid)->first();
		
		return $result;
	}
	
	public static function get_redeem_package($id, $memberid)
	{
		$result =  DB::table('view_active_vip_package')->where('id', $id)->where('member_id', $memberid)->where('redeem_state', 2)->first();
		
		return $result;
	}
	
	public static function get_package_byid($id)
	{
		$result = DB::table('view_active_vip_package')->where('id', $id)->first();
		
		return $result;
	}
	
	public static function update_package($id,$data)
	{	
		if (!empty($id))
		{
			return $result = DB::table('package')
            ->where('id', $id)
            ->update($data);
		}		 		
	}
	
	public static function save_package($chunk)
	{
		return DB::table('package')->insertGetId($chunk);
	}
	
	public static function delete_package($id)
	{
		
		Package::find($id)->delete();
		return true;
		//DB::table('package')->delete($id);
	}
	
	public static function save_manyvip_package($chunk)
	{
		return DB::table('vip_redeemed')->insert($chunk);
	}
	
	public static function save_vip_package($chunk)
	{
		return DB::table('vip_redeemed')->insertGetId($chunk);
	}	
	
	public static function update_redeemed($id,$data)
	{	
		if (!empty($id))
		{
			return $result = DB::table('vip_redeemed')
            ->where('id', $id)
            ->update($data);
		}		 		
	}
	
	public static function get_vip_package($id)
	{
		$result = DB::table('view_vip_list')->where('id', $id)->first();
		
		return $result;
	}
	
	public static function update_vip($id,$data)
	{	
		if (!empty($id))
		{
			return $result = DB::table('vip_redeemed')
            ->where('id', $id)
            ->update($data);
		}		 		
	}	
	
	public static function get_vip_list($memberid, $limit = 100)
	{
		$result =  DB::table('view_vip_list')->select('*',DB::raw("(CASE WHEN redeem_state='3' THEN passcode WHEN redeem_state='2' THEN passcode ELSE ''  END) as passcode"))->where('member_id', $memberid)->get();
		return $result;
	}
	
	public static function get_available_quantity($id)
	{
		$result =  DB::table('package')->select('available_quantity')->where('id', $id)->first();
		return $result;
	}
	
	public static function get_redeem_package_passcode($passcode, $memberid)
	{
		$result =  DB::table('view_active_vip_package')->where('passcode', $passcode)->where('member_id', $memberid)->where('redeem_state', 2)->first();
		
		return $result;
	}
	
	public static function get_current_package($memberid)
	{
		$result =  DB::table('vip_redeemed')->select('id')->where('member_id', $memberid)->where('redeem_state', 3)->first();
		
		return $result;
	}
	
	public static function reset_current_package($id)
	{	
		if (!empty($id))
		{
			return $result = DB::table('vip_redeemed')
            ->where('id', $id)
            ->update(['redeem_state'=>4]);
		}		 		
	}
	
	public static function get_redeemed_package_count($memberid)
	{
		$count = DB::table('vip_redeemed')->where('redeem_state',4)->count();
		
		if (!$count) $count = 1;
		
		return $count;
	}
	
	public static function get_redeemed_package_count($packageid = FALSE,$memberid = FALSE)
	{
		$result = DB::table('view_vip_betting');
		
		if (!$memberid)  $result->where('member_id',$memberid);
		
		if (!$packageid) $result->where('package_id',$packageid);
		
		return $result->sum('rewardamt');
	}
	
}






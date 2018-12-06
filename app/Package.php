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
		$result = DB::table('package')->where('package_status', '=', 0);
		
		if (!empty($point))
		{
			$result = $result->where('min_point', '<=', $point);
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
	
	public static function delete_package($chunk)
	{
		DB::table('package')->delete($chunk);
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
		$result =  DB::table('view_vip_list')->select('*',DB::raw("(CASE WHEN redeem_state='3' THEN '0' WHEN redeem_state='2' THEN '0' ELSE passcode  END) as passcode"))->where('member_id', $memberid)->get();
		return $result;
	}
	
}






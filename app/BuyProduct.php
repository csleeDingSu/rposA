<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
use DB;

use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class BuyProduct extends Model
{   
    use SoftDeletes;
	
	protected $fillable = [
        'name','point_to_redeem','price','status','created_at','picture_url','description','available_quantity','discount_price','type','seq'

    ];
	
	protected $softDelete = true;
	
	protected $dates = ['deleted_at'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $table   = 'buy_product';
	
	
	public static function get_product($id)
	{
		$result = BuyProduct::where('id', $id)->first();
		
		return $result;
	}
	public static function get_view_product($id)
	{
		$result = DB::table('view_buy_product')->where('id', $id)->first();
		
		return $result;
	}
	
	
	public static function list_available_redeem_package($point, $limit = null, $skip = null)
	{		
		if (empty($limit)) {
			$result = DB::table('view_buy_product')->where('status', '=', 1)->orderBy('seq');	
		} else {
			if (empty($skip)) {
				$result = DB::table('view_buy_product')->where('status', '=', 1)->take($limit)->orderBy('seq');	
			} else {
				$result = DB::table('view_buy_product')->where('status', '=', 1)->skip($skip)->take($limit)->orderBy('seq');	
			}
		}
		
		
		if (!empty($point))
		{
			//$result = $result->where('min_point', '<=', $point);
		}
		
		$result = $result->get();
		
		return $result;
	}
	
	public static function get_package_history($memberid, $limit = 100)
	{
		$result =  DB::table('view_buy_product')->where('member_id', $memberid)->orderBy('request_at', 'DESC')->paginate($limit);
		return $result;
	}	
	
	public static function update_product($id,$data)
	{	
		if (!empty($id))
		{
			return $result = DB::table('buy_product')
            ->where('id', $id)
            ->update($data);
		}		 		
	}
	
	public static function save_package($chunk)
	{
		return BuyProduct::insertGetId($chunk);
	}
	
	public static function delete_package($id)
	{		
		BuyProduct::find($id)->delete();
		return true;
	}
			
	public static function save_redeemed($chunk)
	{
		return DB::table('buy_product_redeemed')->insertGetId($chunk);
	}	
	
	public static function update_redeemed($id,$data)
	{	
		if (!empty($id))
		{
			return $result = DB::table('buy_product_redeemed')
            ->where('id', $id)
            ->update($data);
		}		 		
	}
	
	public static function get_product_redeemed($id)
	{
		$result = DB::table('buy_product_redeemed')->where('id', $id)->first();
		
		return $result;
	}	
	
	public static function get_available_quantity($id)
	{
		$result =  BuyProduct::select('available_quantity')->where('id', $id)->first();
		return $result;
	}
	
	public static function get_current_package($memberid,$all = FALSE)
	{
		$result =  DB::table('buy_product_redeemed');
		if (!$all) $result->select('id');
		
		$out = $result->where('member_id', $memberid)->where('redeem_state', 3)->first();
		return $out;
	}
	
	public static function reset_current_package($id)
	{	
		if (!empty($id))
		{
			return $result = DB::table('buy_product_redeemed')
            ->where('id', $id)
            ->update(['redeem_state'=>4]);
		}		 		
	}
	
	public static function product_redeem_count($id)
	{		
		$result = DB::table('view_buy_product_user_count')->where('product_id',$id)->first();
		return $result;
	}
	
	
	
	
}






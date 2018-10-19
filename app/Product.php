<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
use DB;

use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;
class Product extends Model
{   
    use SoftDeletes;
	
	protected $fillable = [
        'product_name',
    ];
	
	protected $softDelete = true;
	protected $dates = ['deleted_at'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $table = 'product';
	
	public $table_pins    = 'softpins';
	
	public $table_redeem  = 'redeemed';
	
	public $table_product = 'product';
	
	
	public static function get_product($id)
	{
		$result = DB::table('product')->where('id', $id)->first();
		
		return $result;
	}
	
	public static function get_pin_list($limit = 100)
	{
		$result =  DB::table('softpins')->paginate($limit);
		
		return $result;
	}
	
	public static function get_pin_detail_by_view($productid, $point)
	{
		$result = DB::table('view_softpins')->where('productid', $productid)->where('product_status', 0)->first();
		return $result;
	}
	
	public static function get_pin_list_by_view($limit = 100)
	{
		$result =  DB::table('view_softpins')->paginate($limit);
		
		return $result;
	}
	
	public static function get_redeemlist_history($memberid, $limit = 100)
	{
		$result =  DB::table('view_redeem_list')->where('member_id', $memberid)->orderby('DESC')->paginate($limit);
		
		return $result;
	}
	
	public static function get_redeemlist_by_view($limit = 100)
	{
		$result =  DB::table('view_redeem_list')->paginate($limit);
		
		return $result;
	}
	
	public static function get_pending_redeemlist($limit = 100)
	{
		$result =  DB::table('view_redeem_list')->where('pin_status',4)->paginate($limit);
		
		return $result;
	}
	
	
		
	public static function get_product_list($limit = 100)
	{
		$result =  DB::table('product')->paginate($limit);
		
		return $result;
	}
	
	public static function get_ajax_product_list()
	{
		$result =  DB::table('product')->select('id','product_name')->get();
		
		return $result;
	}
	
	
	
	public static function update_product($id,$data)
	{	
		if (!empty($id))
		{
			return $result = DB::table('product')
            ->where('id', $id)
            ->update($data);
		}		 		
	}
	
	public static function save_product($chunk)
	{
		DB::table('product')->insert($chunk);
	}
	
	public static function delete_product($chunk)
	{
		DB::table('product')->insert($chunk);
	}
	
	
	public static function get_pin($id)
	{
		$result = DB::table('view_redeem_list')->where('id', $id)->first();
		
		return $result;
	}
	
	public static function save_pin($chunk)
	{
		return DB::table('softpins')->insertGetId($chunk);
	}
	
	public static function delete_pin($id)
	{
		return DB::table('softpins')->where('id', $id)->delete();
	}
	
	public static function update_pin($id,$data)
	{	
		if (!empty($id))
		{
			return $result = DB::table('softpins')
            ->where('id', $id)
            ->update($data);
		}		 		
	}	
	
	public static function list_available_redeem_product($point)
	{		
		$result = Product::where('product_status', '=', 0);
		
		if (!empty($point))
		{
			$result = $result->where('min_point', '<=', $point);
		}
		$result = $result->paginate(50);
		
		return $result;
	}
	
	public static function get_available_pin($product = false, $point = false)
	{
		$result = DB::table('view_softpins')->where('product_status', '=', 0)->where('pin_status', '=', 0);
		
		if (!empty($product))
		{
			$result = $result->where('productid', '=', $product);
		}
		if (!empty($point))
		{
			$result = $result->where('min_point', '<=', $point);
		}
		$result = $result->first();
		
		return $result;
	}
	
}






<?php
namespace App;
use App\ad_display;
use App\v_blog_buy_product_redeemed;
use Carbon\Carbon;
use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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
	public static function get_view_product($id)
	{
		$result = DB::table('view_product')->where('id', $id)->first();
		
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
	
	//deprecated
	public static function get_redeemlist_history($memberid, $limit = 100)
	{
		$result =  DB::table('view_redeem_list')->where('member_id', $memberid)->orderBy('request_at', 'DESC')->paginate($limit);
		
		return $result;
	}
	//deprecated
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
	
	public static function get_product_view_list($limit = 100)
	{
		$result =  DB::table('view_product')->orderByRaw('-seq desc')->paginate($limit);
		
		return $result;
	}
		
	public static function get_product_list($limit = 100)
	{
		$result =  DB::table('product')->paginate($limit);
		
		return $result;
	}
	
	public static function get_ajax_product_list()
	{
		$result =  DB::table('product')->select('id','product_name','product_display_id')->get();
		
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
	
	public static function list_available_redeem_product($point,$quantity = 0)
	{		
		//$result = Product::where('product_status', '=', 0);
		
		$result = DB::table('view_product')->where('product_status', '=', 0);
		
		if (!empty($point))
		{
			//$result = $result->where('min_point', '<=', $point);
		}
		if (!empty($quantity))
		{
			$result = $result->where('available_quantity', '>=', 1);
		}
		$result = $result->orderByRaw('-seq desc')->paginate(50);
		
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
	
	public static function get_csvtitle($type = 'softpin')
	{
		$result = DB::table('csv_title')->where('category',$type)->select('id', 'title', 'is_mandatory')->get();
				
		return $result;
	}
	
	public static function QueuedList($filename)
	{
		$result = DB::table('excel_upload')->select('sys_field_id', 'file_title_loc_id')->where('filename', $filename)->get();
			
		return $result;
	}
	
	//ad
	
	
	public static function get_ad_product_list($limit = 100)
	{
		$result =  ad_display::paginate($limit);
		
		return $result;
	}
	
	public static function get_ad_product($id)
	{
		$result = ad_display::where('id', $id)->first();
		
		return $result;
	}
	
	public static function update_ad_product($id,$data)
	{	
		if (!empty($id))
		{
			return $result = ad_display::where('id', $id)
            ->update($data);
		}		 		
	}
	
	public static function save_ad_product($chunk)
	{
		ad_display::insert($chunk);
	}
	
	public static function delete_ad_product($id)
	{
		return ad_display::where('id', $id)->delete();
	}
	
	
	public static function get_ad_paginate($limit = 10)
	{
		//$result = DB::table('ad_display')->latest()->paginate($limit);
		$result = ad_display::latest()->paginate($limit);
		
		return $result;
	}
	
	public static function clean($ids = false)
	{
		$result = DB::table('ad_display')->truncate();
		return $result;
	}
	
	
	public static function get_redeem_history($memberid, $limit = 100)
	{
		$result =  DB::table('view_redeem_history_all')->where('member_id', $memberid)->orderBy('request_at', 'DESC')->paginate($limit);
		
		return $result;
	}

	public static function IsFirstWin($memberid,$type = 'lose')
	{
		/*
		switch($type)
		{
			case'win':
				$result =  DB::table('member_game_result')->select(DB::raw('COUNT(CASE WHEN is_reset = 1 THEN 1 END) AS firstwin'))->where('member_id',$memberid)->first();
			break;
			case'lose':
				$result =  DB::table('member_game_result')->select(DB::raw('COUNT(CASE WHEN is_reset = 1 THEN 1 END) AS firstwin'))->where('member_id',$memberid)->first();
			break;	
		}
		*/
		$result =  DB::table('member_game_result')->select(DB::raw('COUNT(CASE WHEN is_reset = 1 THEN 1 END) AS firstwin'))->where('member_id',$memberid)->first();
		
		if ($result->firstwin <= 2)
		{
			return 'yes';
		}
		// return 'yes'; //for testing
		return '';
	}

	public static function get_redeem_history_blog($memberid, $limit = 100)
	{
		$result =  v_blog_buy_product_redeemed::select('*')->where('member_id', $memberid)->orderBy('request_at', 'DESC')->paginate($limit);
		
		return $result;
	}
	
}






<?php

namespace App\Http\Controllers\Api;

use App\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Validator;
use Carbon\Carbon;
use App\Wallet;
use App\Product;
class ProductController extends Controller
{
   
    public function parent() {
		return $this->belongsTo('App\Category', 'parent_id');
	}

	public function children() {
		return $this->hasMany('App\Category', 'parent_id'); 
	}
	
	public function list_product_by_point(Request $request)
    {
		$member_id = $request->memberid;
		
		$wallet = Wallet::get_wallet_details($member_id);
		
		$result =  Product::list_available_redeem_product($member_id,$wallet->point);
		return response()->json(['success' => true, 'records' => $result]);
	}
	
	public function redeem_request(Request $request)
    {
	
	}
	
	
}
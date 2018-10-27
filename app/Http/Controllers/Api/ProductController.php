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
		
		$result =  Product::list_available_redeem_product($wallet->point);
		return response()->json(['success' => true, 'records' => $result]);
	}
	
	public function redeem_request(Request $request)
    {
		$member_id = $request->memberid;
		$wallet = Wallet::get_wallet_details($member_id);
		//check point
	}
	
	public function get_redeem_history(Request $request)
    {
		$member_id = $request->memberid;
		$result    = Product::get_redeemlist_history($member_id,30);
		return response()->json(['success' => true, 'records' => $result]);
	}
	
	
	public function request_redeem(Request $request)
    {
		$memberid  = $request->memberid;
		
		$productid = $request->productid;		
		
		$input = [
			 'memberid'  => $request->memberid,
			 'productid' => $request->productid,			
			  ];
		$validator = Validator::make($input, 
			[
				'memberid' => 'required',
				'productid' => 'required'
			]
		);
		if ($validator->fails()) {
			return response()->json(['success' => false, 'message' => $validator->errors()->all()]);
		}
		
		$wallet    = Wallet::get_wallet_details($memberid);
		
		$product   = Product::get_available_pin($productid,$wallet->point);
		
		if ($product)
		{
			$now = Carbon::now();
			
			$data = ['member_id'=>$memberid,'pin_status'=>4,'request_at'=>$now,'used_point'=>$product->min_point];
			
			Wallet::update_ledger($memberid,'debit',$product->min_point,'PNT');
			
			Product::update_pin($product->id, $data);
			
			return response()->json(['success' => true, 'message' => 'success']);
		}
		
		return response()->json(['success' => false, 'message' => 'insufficient point/pin not available']);
	}
	
	
	
	public function index()
    {		
		$result = Product::get_ad_paginate(100);
		$productcount = $result->count();
        return view('ad.ad', compact('result','productcount'));
		
		
    }

    public function show()
    {
		$result = Product::get_ad_paginate(100);
		
		$productcount = Category::all();
        return view('ad.ad', compact('result','productcount'));		
		
    }
	
		
	
}
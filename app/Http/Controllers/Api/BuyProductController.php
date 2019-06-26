<?php

namespace App\Http\Controllers\Api;

use App\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Validator;
use Carbon\Carbon;
use App\Wallet;
use App\BuyProduct;
class BuyProductController extends Controller
{	
	
	public function list_package(Request $request)
    {
		$member_id = $request->memberid;
		
		$result =  BuyProduct::list_available_redeem_package(0);
		
		return response()->json(['success' => true,  'records' => $result]);
	}
	
	public function request_product_upgrade(Request $request)
    {
		$memberid  = $request->memberid;
		
		$packageid = $request->packageid;	
		
		$insdata = [];
		$card = $request->card;	
		
		$input = [
			 'memberid'  => $request->memberid,
			 'packageid' => $request->packageid,			
			  ];
		$validator = Validator::make($input, 
			[
				'memberid' => 'required',
				'packageid' => 'required'
			]
		);
		if ($validator->fails()) {
			return response()->json(['success' => false, 'message' => $validator->errors()->all()]);
		}
				
		$package   = BuyProduct::get_view_product($packageid);
		
		
		
		if (!$package) return response()->json(['success' => false, 'message' => 'unknown package']);
		
		//check quantity	
		
		
		
		$used_count = $package->used_quantity + $package->reserved_quantity;
		
		if ($used_count >= $package->available_quantity)
		{
			return response()->json(['success' => false, 'message' => 'no available quantity to buy']);
		}
				
		$setting   = \App\Admin::get_setting();
		
		$now = Carbon::now();
		switch ($package->type)
		{ 			
			case '1':
				//card type
				$data =  [
							'product_id'     => $package->id
							,'created_at'    => $now
							,'updated_at'    => $now
							,'member_id'     => $memberid
							,'redeem_state'  => 1
							,'used_point'    => 0
							,'ref_note'      => $request->ref_note
						];
				$id = BuyProduct::save_redeemed($data);
				return response()->json(['success' => true, 'message' => 'success','ref_id'=>$id]);
			break;				
			case '2':
				
				//product
				$data =  [
							'product_id'     => $package->id
							,'created_at'    => $now
							,'updated_at'    => $now
							,'member_id'     => $memberid
							,'redeem_state'  => 1
							,'used_point'    => $package->price
							,'ref_note'      => $request->ref_note
						];
				$id = BuyProduct::save_redeemed($data);
				return response()->json(['success' => true, 'message' => 'success','ref_id'=>$id]);
			break;					
				
			

			
		}		
		
		return response()->json(['success' => false, 'message' => 'unknown package type']);
	}
	
	
}

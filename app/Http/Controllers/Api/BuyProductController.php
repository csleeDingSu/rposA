<?php

namespace App\Http\Controllers\Api;

use App\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Validator;
use Carbon\Carbon;
use App\Wallet;
use App\BuyProduct;

use App\RedeemedProduct;
use App\OrderDetail;
use App\ShippingDetail;

class BuyProductController extends Controller
{	
	
	public function list_package(Request $request)
    {
		$member_id = $request->memberid;
		
		$result =  BuyProduct::list_available_redeem_package(0);
		
		$type = ['1'=>'virtual card','2'=>'Product'];
		
		return response()->json(['success' => true,'type_reference'=>$type ,  'records' => $result]);
	}

	public function buyproduct_history(Request $request)
    {
		$member_id = $request->memberid;
		
		$result =  RedeemedProduct::with('order_detail')->where('member_id', $member_id)->get();
		$result =  RedeemedProduct::with('neworder_detail')->where('member_id', $member_id)->get();
		//$result =  RedeemedProduct::where('member_id', $member_id)->get();
		
		$type = ['1'=>'virtual card','2'=>'Product'];
		
		return response()->json(['success' => true,'type_reference'=>$type ,  'records' => $result]);
	}

	
	
	public function request_product_upgrade(Request $request)
    {
		$memberid  = $request->memberid;
		
		$packageid = $request->packageid;
		
		$quantity  = $request->quantity;
		
		$insdata   = [];
		$card      = $request->card;	
		
		$input = [
			 'memberid'  => $request->memberid,
			 'packageid' => $request->packageid,	
			 'quantity'  => $request->quantity,	
			  ];
		$validator = Validator::make($input, 
			[
				'memberid' => 'required',
				'packageid' => 'required',
				'quantity' => 'required|min:1'
			]
		);
		if ($validator->fails()) {
			return response()->json(['success' => false, 'message' => $validator->errors()->all()]);
		}
		
		//check package
		$package   = BuyProduct::get_view_product($packageid);
		
		if (!$package) return response()->json(['success' => false, 'message' => 'unknown package']);
		
		//check quantity	
		$used_count = $package->used_quantity + $package->reserved_quantity;
		
		if ($used_count >= $package->available_quantity)
		{
			return response()->json(['success' => false, 'message' => 'no available quantity to buy']);
		}
		
		//check point
		$wallet      = Wallet::get_wallet_details($memberid);
		
		$required_point = $package->point_to_redeem * $quantity;
		
		if ($required_point > $wallet->point)
		{
			return response()->json(['success' => false, 'message' => 'not enough point to redeem']);
		}		
				
		//$setting   = \App\Admin::get_setting();
		
		$now = Carbon::now();
		switch ($package->type)
		{ 			
			case '1':
				
				$wallet  = Wallet::update_basic_wallet($memberid,0,$required_point,'RBP','debit', 'reserved for buy product');	
				
				//card type
				$data =  [
							'product_id'     => $package->id
							,'created_at'    => $now
							,'updated_at'    => $now
							,'member_id'     => $memberid
							,'redeem_state'  => 1
							,'used_point'    => $required_point
							,'quantity'      => $request->quantity
							,'ref_note'      => $request->ref_note
						];
				$id = BuyProduct::save_redeemed($data);
				
				$quantity;
				for ($i=1;$i<=$quantity;$i++)
				{
					$order[] = ['order_id'=>$id];
				}
				
				\DB::table('order_details')->insert($order);
				
				
				
				return response()->json(['success' => true, 'message' => 'success','ref_id'=>$id]);
			break;				
			case '2':
				
				$input = [
						 'address'        => $request->address,
						 'receiver_name'  => $request->receiver_name,	
						 'contact_numer'  => $request->contact_numer,	
						 'city'           => $request->city,	
						 'zip'            => $request->zip,	
						];				
				
				$validator = Validator::make($input, 
					[
						'address'       => 'required|min:10',
						'receiver_name' => 'required',
						'contact_numer' => 'required|min:1',
						'city'          => 'required',
						'zip'           => 'required',
					]
				);
				if ($validator->fails()) {
					return response()->json(['success' => false, 'message' => $validator->errors()->all()]);
				}
				
				$wallet  = Wallet::update_basic_wallet($memberid,0,$required_point,'RBP','debit', 'reserved for buy product');	
								
				//product
				$data =  [
							'product_id'     => $package->id
							,'created_at'    => $now
							,'updated_at'    => $now
							,'member_id'     => $memberid
							,'redeem_state'  => 1
							,'used_point'    => $required_point
							,'ref_note'      => $request->ref_note
							,'quantity'      => $request->quantity
						];
				$id = BuyProduct::save_redeemed($data);
				
				$order = ['address'=>$request->address,'receiver_name'=>$request->receiver_name,'contact_numer'=>$request->contact_numer,'city'=>$request->city,'zip'=>$request->zip,'order_id'=>$id];
				
				\DB::table('shipping_details')->insert($order);				
				
				return response()->json(['success' => true, 'message' => 'success','ref_id'=>$id]);
			break;					
				
		}		
		
		return response()->json(['success' => false, 'message' => 'unknown package type']);
	}
}

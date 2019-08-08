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
	
	public function get_virtual_card_details(Request $request)
	{
		$orderid = $request->orderid;
		$result  = OrderDetail::where('order_id',$orderid)->get();
		return response()->json(['success' => true,'records' => $result]);
	}
	
	public function get_latest_address(Request $request)
	{
		$memberid = $request->memberid;
		// $result   = \DB::table('order_shipping_detail')->select('name','description','value')->where('member_id', $memberid)->latest('order_date')->first();		
		$result   = \DB::table('order_shipping_detail')->select('receiver_name','contact_number','city','address')->where('member_id', $memberid)->latest('order_date')->first();		
		$type     = \DB::table('ref_credit_type')->get();
		
		return response()->json(['success' => true,'records' => $result,'credit_type' => $type]);
	}
	
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
		//\DB::connection()->enableQueryLog();
		$result =  RedeemedProduct::with('product','order_detail','shipping_detail')->where('member_id', $member_id)->get();

		 //$queries = \DB::getQueryLog();
         //dd($queries);


		//$result =  RedeemedProduct::with('neworder_detail')->where('member_id', $member_id)->get();
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
			],
			 [
				'memberid.required'   =>trans('auth.memberid_empty'),
				'packageid.required'  =>trans('auth.packageid_empty'),
				'quantity.required'   =>trans('auth.quantity_empty'),				
			]
		);
		if ($validator->fails()) {
			return response()->json(['success' => false, 'message' => $validator->errors()->all()]);
		}
		
		//check package
		$package   = BuyProduct::get_view_product($packageid);
		
		if (!$package) return response()->json(['success' => false, 'message' => trans('dingsu.unknown_package')]);

		if (!empty($package->deleted_at)) return response()->json(['success' => false, 'message' => trans('dingsu.package_deleted')]);

		if ($package->status != 1) return response()->json(['success' => false, 'message' => trans('dingsu.package_inactive')]);
		
		//check quantity	
		$used_count = $package->used_quantity + $package->reserved_quantity;
		
		if ($used_count >= $package->available_quantity)
		{
			return response()->json(['success' => false, 'message' => trans('dingsu.no_available_quantity')]);
		}
		
		//check point
		$wallet      = Wallet::get_wallet_details($memberid);
		
		$required_point = $package->point_to_redeem * $quantity;
		
		if ($required_point > $wallet->point)
		{
			return response()->json(['success' => false, 'message' => trans('dingsu.not_enough_point_to_redeem')]);
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
						 'contact_number'  => $request->contact_number,	
						 'city'           => $request->city,	
						 'zip'            => $request->zip,	
						];				
				
				$validator = Validator::make($input, 
					[
						'address'        => 'required|min:1',
						'receiver_name'  => 'required',
						'contact_number' => 'required|min:1',
					],
					[
						'address.required'        =>trans('auth.address_empty'),
						'receiver_name.required'  =>trans('auth.receiver_name_empty'),
						'contact_number.required' =>trans('auth.contact_number_empty'),				
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
				
				$order = ['address'=>$request->address,'receiver_name'=>$request->receiver_name,'contact_number'=>$request->contact_number,'city'=>$request->city,'zip'=>$request->zip,'order_id'=>$id];
				
				\DB::table('shipping_details')->insert($order);				
				
				return response()->json(['success' => true, 'message' => 'success','ref_id'=>$id]);
			break;					
				
		}		
		
		return response()->json(['success' => false, 'message' => 'unknown package type']);
	}
}

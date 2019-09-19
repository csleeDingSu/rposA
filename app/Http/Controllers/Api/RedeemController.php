<?php

namespace App\Http\Controllers\Api;

use App\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Validator;
use Carbon\Carbon;
use App\Wallet;
use App\Product;
use App\Package;
use App\Ledger;
class RedeemController extends Controller
{
   public function request_vip(Request $request)
    {
		$memberid  = $request->memberid;
		$gameid    = $request->gameid;	
		$packageid = $request->packageid;	
		
		$insdata = [];
		$card = $request->card;	
		
		$input = [
			 'memberid'  => $request->memberid,
			 'packageid' => $request->packageid,	
			 'gameid'    => $request->gameid,	
			  ];
		$validator = Validator::make($input, 
			[
				'memberid'  => 'required',
				'packageid' => 'required',
				'gameid'    => 'required'
			]
		);
	   
		if ($validator->fails()) {
			return response()->json(['success' => false, 'message' => $validator->errors()->all()]);
		}
		
		$ledger    = Ledger::ledger($memberid, $gameid);
		
		//$basic_count = \DB::table('basic_redeem')->where('member_id',$request->memberid)->count();
		$basic_count = \DB::table('view_basic_member_redeem_count')->where('member_id',$memberid)->first();
		$basic_count = $basic_count->used_quantity + $basic_count->reserved_quantity;
		
		if ($basic_count < 1)
		{
			return response()->json(['success' => false, 'message' => 'buy basic package before upgrade']);
			
			if ($wallet->point < 120)
			{
				return response()->json(['success' => false, 'message' => 'insufficient points to upgrade.']);
			}
		}
		
		$package   = Package::get_package($packageid);
		
		if (!$package) return response()->json(['success' => false, 'message' => 'unknown package']);
		
		$now = Carbon::now();
		switch ($package->package_type)
		{
			//flexi type
			case '1':
				if ($package->min_point <= $ledger->point)
				{
					
					$passcode = unique_random('vip_redeemed','passcode',8);
					
					$data = ['package_id'=>$package->id,'created_at'=>$now,'updated_at'=>$now,'member_id'=>$memberid,'redeem_state'=>2,'request_at'=>$now,'used_point'=>$package->min_point,'package_life'=>$package->package_life,'package_point'=>$package->package_freepoint,'confirmed_at'=>$now,'passcode'=>$passcode,'ledger_id'=>$ledger->id,'ledger_id'=>$ledger->id];
					
					$wallet = Ledger::credit($memberid,$game_id,$package->min_point,'BVP',$package->min_point.' Point reserved for VIP package');
					
					$data['ledger_history_id'] = $wallet->id;
					
					$id     = Package::save_vip_package($data);	
					
					
			
					
					

					return response()->json(['success' => true, 'message' => 'success','refid'=>$id]);
				}
			break;
			
			//prepaid
			case '2':
				
				$data = ['package_id'=>$package->id,'created_at'=>$now,'updated_at'=>$now,'member_id'=>$memberid,'redeem_state'=>1,'request_at'=>$now,'used_point'=>0,'package_life'=>$package->package_life,'package_point'=>$package->package_freepoint,'ref_note'=>$request->ref_note];
				
				$id = Package::save_vip_package($data);
				
				return response()->json(['success' => true, 'message' => 'success','refid'=>$id]);
				
				/*
				$a = 0 ;
				$r = 0 ;
				$parepaid = explode(',',$card);
				foreach ($parepaid as $pcard)
				{
					$card = array_map('trim', explode(' ', $pcard));
					
					if (!empty($card[0]) && !empty($card[1]) )
					{
						$data = ['package_id'=>$package->id,'created_at'=>$now,'updated_at'=>$now,'member_id'=>$memberid,'redeem_state'=>1,'request_at'=>$now,'used_point'=>$package->min_point,'package_life'=>$package->package_life,'package_point'=>$package->package_freepoint,'cardnum'=>$card[0],'cardpass'=>$card[1]];
						
						$insdata[] = $data;
						$a++;
					}
					else{
						$r++;
					}
				}
				
				Package::save_manyvip_package($insdata);

				return response()->json(['success' => true, 'message' => 'success','rejected'=>$r,'added'=>$a]);
				*/
				
			break;	
		}		
		
		
		return response()->json(['success' => false, 'message' => 'unknown type/ package deleted']);
	}
	
	
	public function redeem_vip(Request $request)
    {
		$memberid  = $request->memberid;
		$passcode  = $request->passcode;
		
		$input = [
			 'memberid'  => $memberid,
			 'passcode'  => $passcode,
			  ];
		$validator = Validator::make($input, 
			[
				'memberid'  => 'required',
				'passcode'  => 'required'
			]
		);
		if ($validator->fails()) {
			return response()->json(['success' => false, 'message' => $validator->errors()->all()]);
		}
		
				
		$package   = Package::get_redeem_package_passcode($passcode, $memberid );
		
		if ($package)
		{
			$cpackage = Package::get_current_package($memberid);	
		
			if ($cpackage)
			{
				return response()->json(['success' => false, 'message' => 'user already entitled with VIP']);
			}
			
			if ($passcode === $package->passcode)
			{
				$ledger = Ledger::ledgerbyid($package->ledger_id);
				
				$history = Ledger::credit($memberid,$ledger->game_id,$package->package_point,'RV');
				
				
				Ledger::life($memberid,$ledger->game_id,'credit',$package->package_life,'RV');
					
				$now  = Carbon::now();
				$data = ['redeem_state'=>3,'redeemed_at'=>$now, 'ledger_id'=> $ledger->id, 'ledger_history_id'=>$history->id ];
						
				Package::update_vip($package->id, $data);
				
				return response()->json(['success' => true, 'message' => '']);
			}
			return response()->json(['success' => false, 'message' => 'wrong redeem code']);
		}
		
		return response()->json(['success' => false, 'message' => 'unknown vip package / user not authorise to use this package']);
	}
	
	
	public function request_redeem(Request $request)
    {
		$memberid  = $request->memberid;
		$productid = $request->productid;		
		$gameid    = $request->gameid;		
		
		
		$input = [
			 'memberid'  => $request->memberid,
			 'productid' => $request->productid,			
			 'gameid'    => $request->gameid,			
			  ];
		$validator = Validator::make($input, 
			[
				'memberid'  => 'required',
				'productid' => 'required',
				'gameid'    => 'required'
			]
		);
		
		
		if ($validator->fails()) {
			return response()->json(['success' => false, 'message' => $validator->errors()->all()]);
		}
		
		$ledger    = Ledger::ledger($memberid, $gameid);
		
		$product   = Product::get_available_pin($productid,$ledger->point);
		
		$setting   = \App\Admin::get_setting();
		
		
		if ($product)
		{
			$now = Carbon::now();
			
			//$pin_status = 4;
			
			$data = ['member_id'=>$memberid, 'request_at'=>$now,'used_point'=>$product->min_point];
			
			$data['pin_status'] = 4;
			
			if($setting->auto_product_redeem =='Y')
			{
				$data['pin_status']  = 2;
				//$data['redeemed_at'] = $now;
				$data['confirmed_at'] = $now;
			}			
			
			$wallet = Ledger::debit($memberid,$gameid,$product->min_point,'RPO', $product->min_point.' Point used for buy product');
			
			$data['ledger_id']         = $ledger->id;
			$data['ledger_history_id'] = $wallet->id;

			Product::update_pin($product->id, $data);
			
			
			
			return response()->json(['success' => true, 'message' => 'success']);
		}
		
		return response()->json(['success' => false, 'message' => 'insufficient point/pin not available']);
	}
	
	public function vip_redeem_condition(Request $request)
    {		
		$reset    = null;		
		$memberid = $request->memberid;	
		$gameid   = $request->gameid;	
		
		$package      = Package::get_current_package($memberid,'all');
		
		if (!$package) 
		{				
			return response()->json(['success' => false,  'message' => 'no active vip subscriptions']); 
		}
		$wallet       = Ledger::ledger($memberid, $gameid);
		$redeemcount  = Package::get_redeemed_package_count($memberid);
		$redeemreward = Package::get_redeemed_package_reward($package->id,$memberid);
		
		//Rules are based on redeem_condition table
		
		$verifyrule   = \App\Admin::check_redeem_condition($redeemcount);
		
		
		//echo 'rc-';print_r($redeemcount);
		//echo 'rr-';print_r($redeemreward);
		//echo 'ru-';print_r($verifyrule);
		
		//return error message if user have vip life & didnt match the redeem criteria,
		if ($verifyrule){
			if ($redeemreward < $verifyrule->minimum_point)
			{
				if ($wallet->life >= 1 )
				{ 
					return response()->json(['success' => false, 'message' => '你必须赢得'.$verifyrule->minimum_point.'积分','min_point'=>$verifyrule->minimum_point,'vip_point'=>$wallet->point,'win_point'=>$redeemreward,'redeem_count'=>$redeemcount]); 
				}
			}
		}
		
		return response()->json(['success' => 'true','message' => 'eligible to withdraw','vip_point'=>$wallet->point,'wabao_point'=>$wallet->point,'redeem_point'=>$wallet->point]);  
		
	}
	
	
	public function request_product_upgrade(Request $request)
    {
		$memberid  = $request->memberid;
		
		$packageid = $request->packageid;
		$gameid    = $request->gameid;
		
		$quantity  = $request->quantity;
		
		$insdata   = [];
		$card      = $request->card;	
		
		$input = [
			 'memberid'  => $request->memberid,
			 'packageid' => $request->packageid,	
			 'quantity'  => $request->quantity,	
			'gameid'     => $request->gameid,	
			  ];
		$validator = Validator::make($input, 
			[
				'memberid'  => 'required',
				'packageid' => 'required',
				'gameid'    => 'required',
				'quantity'  => 'required|min:1'
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
		$package   = \App\BuyProduct::get_view_product($packageid);
		
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
		$wallet       = Ledger::ledger($memberid, $gameid);
		
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
				
				$result  = Ledger::debit($memberid,$gameid,$required_point,'RBP', ' reserved for buy product');
				
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
							,'ledger_id'     => $wallet->id
							,'ledger_history_id'      => $result->id
					
						];
				$id = \App\BuyProduct::save_redeemed($data);
				
				
				
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
				
				$result  = Ledger::debit($memberid,$gameid,$required_point,'RBP', ' reserved for buy product');				
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
							,'ledger_id'     => $wallet->id
							,'ledger_history_id'      => $result->id
						];
				$id = \App\BuyProduct::save_redeemed($data);
				
				
				
				$order = ['address'=>$request->address,'receiver_name'=>$request->receiver_name,'contact_number'=>$request->contact_number,'city'=>$request->city,'zip'=>$request->zip,'order_id'=>$id];
				
				\DB::table('shipping_details')->insert($order);				
				
				return response()->json(['success' => true, 'message' => 'success','ref_id'=>$id]);
			break;					
				
		}		
		
		return response()->json(['success' => false, 'message' => 'unknown package type']);
	}
}

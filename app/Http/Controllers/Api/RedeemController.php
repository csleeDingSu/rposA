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
		
		//$wallet    = Wallet::get_wallet_details($memberid);
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
					
					$data = ['package_id'=>$package->id,'created_at'=>$now,'updated_at'=>$now,'member_id'=>$memberid,'redeem_state'=>2,'request_at'=>$now,'used_point'=>$package->min_point,'package_life'=>$package->package_life,'package_point'=>$package->package_freepoint,'confirmed_at'=>$now,'passcode'=>$passcode,'ledger_id'=>$ledger->id];
					
					$wallet = Wallet::update_basic_wallet($memberid,0,$package->min_point, 'BVP','debit', $package->min_point.' Point reserved for VIP package');

					$id     = Package::save_vip_package($data);					
					
					$refdata = [ 'id'=>$id, 'refid'=>$wallet['refid'], 'type'=>'product' ];
					Wallet::add_ledger_ref($refdata);

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
				
				Ledger::credit($memberid,$ledger->game_id,$package->package_point,'RV');
				
				
				Ledger::life($memberid,$ledger->game_id,'credit',$package->package_life,'RV');
					
					
			//	Wallet::update_vip_wallet($memberid,$package->package_life,$package->package_point,'RV');
			
				
				$now = Carbon::now();
				$data = ['redeem_state'=>3,'redeemed_at'=>$now];
						
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

			Product::update_pin($product->id, $data);
			
			$refdata = [ 'id'=>$product->id, 'refid'=>$wallet['uuid'], 'type'=>'product' ];
			Wallet::add_ledger_ref($refdata);
			
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
}

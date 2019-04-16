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
		
		if ($wallet)
		{
			$result =  Product::list_available_redeem_product($wallet->point, 0);
			$package =  Package::list_available_redeem_package($wallet->point);
			
			return response()->json(['success' => true, 'current_point'=>$wallet->point , 'records' => $result, 'packages' => $package]);
		}
		return response()->json(['success' => false, 'records' => '']);
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
		$result    = Product::get_redeem_history($member_id,30);		
		return response()->json(['success' => true, 'records' => $result]);
		
		//deprecated 
		return FALSE;
		$result    = Product::get_redeemlist_history($member_id,30);
		$result->getCollection()->transform(function ($value) {
			$code = $value->code;
			$passcode = $value->passcode;
			$value->code = null;
			$value->passcode = null;
			if ( $value->pin_status == 1 or $value->pin_status == 2 )
			{
				$value->code     = $code;
				$value->passcode = $passcode;
			}
			return $value;
		});		
		$package    = Package::get_vip_list($member_id); 		
		
		return response()->json(['success' => true, 'records' => $result, 'package' => $package]);
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
			
			Wallet::update_basic_wallet($memberid,0,$product->min_point, 'RPO','debit', $product->min_point.' Point used for buy product');

			Product::update_pin($product->id, $data);
			
			return response()->json(['success' => true, 'message' => 'success']);
		}
		
		return response()->json(['success' => false, 'message' => 'insufficient point/pin not available']);
	}
	
	
	
	public function index(Request $request)
    {		
		$result = Product::get_ad_paginate(10);
		
		
		if ($request->ajax()) {
    		$view = view('ad.ajaxlist',compact('result'))->render();
            return response()->json(['html'=>$view]);
        }
		
		$productcount = $result->count();
        return view('ad.ad', compact('result','productcount'));
		
		
    }

    public function show(Request $request)
    {
		$result = Product::get_ad_paginate(10);
		
		$productcount = Category::all();
		
		if ($request->ajax()) {
    		$view = view('ad.ajaxlist',compact('result'))->render();
            return response()->json(['html'=>$view]);
        }
		
        return view('ad.ad', compact('result','productcount'));		
		
    }
	
	
	//package
	public function request_vip(Request $request)
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
		
		$wallet    = Wallet::get_wallet_details($memberid);
		
		$package   = Package::get_package($packageid);
		
		if (!$package) return response()->json(['success' => false, 'message' => 'unknown package']);
		
		$now = Carbon::now();
		switch ($package->package_type)
		{
			//flexi type
			case '1':
				if ($package->min_point <= $wallet->point)
				{
					
					$passcode = unique_random('vip_redeemed','passcode',8);
					
					$data = ['package_id'=>$package->id,'created_at'=>$now,'updated_at'=>$now,'member_id'=>$memberid,'redeem_state'=>2,'request_at'=>$now,'used_point'=>$package->min_point,'package_life'=>$package->package_life,'package_point'=>$package->package_freepoint,'confirmed_at'=>$now,'passcode'=>$passcode];
					
					Wallet::update_basic_wallet($memberid,0,$package->min_point, 'BVP','debit', $package->min_point.' Point reserved for VIP package');

					$dd = Package::save_vip_package($data);

					return response()->json(['success' => true, 'message' => 'success']);
				}
			break;
			
			//prepaid
			case '2':
				
				$data = ['package_id'=>$package->id,'created_at'=>$now,'updated_at'=>$now,'member_id'=>$memberid,'redeem_state'=>1,'request_at'=>$now,'used_point'=>0,'package_life'=>$package->package_life,'package_point'=>$package->package_freepoint];
				
				$dd = Package::save_vip_package($data);
				
				return response()->json(['success' => true, 'message' => 'success']);
				
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
		
		
		return response()->json(['success' => false, 'message' => 'insufficient point']);
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
				Wallet::update_vip_wallet($memberid,$package->package_life,$package->package_point,'RV');
				
				$now = Carbon::now();
				$data = ['redeem_state'=>3,'redeemed_at'=>$now];
						
				Package::update_vip($package->id, $data);
				
				return response()->json(['success' => true, 'message' => '']);
			}
			return response()->json(['success' => false, 'message' => 'wrong redeem code']);
		}
		
		return response()->json(['success' => false, 'message' => 'unknown vip package / user not authorise to use this package']);
	}	
	
	
	public function vip_redeem_condition(Request $request)
    {		
		$reset    = null;		
		$memberid = $request->memberid;	
		
		$package      = Package::get_current_package($memberid,'all');
		
		if (!$package) 
		{				
			return response()->json(['success' => false,  'message' => 'no active vip subscriptions']); 
		}
		$wallet       = Wallet::get_wallet_details_all($memberid);
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
				if ($wallet->vip_life >= 1 )
				{ 
					return response()->json(['success' => false, 'message' => '你必须赢得'.$verifyrule->minimum_point.'积分','min_point'=>$verifyrule->minimum_point,'vip_point'=>$wallet->vip_point,'win_point'=>$redeemreward,'redeem_count'=>$redeemcount]); 
				}
			}
		}
		
		return response()->json(['success' => 'true','message' => 'eligible to withdraw','vip_point'=>$wallet->vip_point,'wabao_point'=>$wallet->current_point,'redeem_point'=>$wallet->vip_point]);  
		
	}	
	//check Setting table
	public function wabaofee(Request $request)
    {
		$setting   = \App\Admin::get_setting();
		return response()->json(['success' => 'true','wabaofee' => $setting->wabao_fee]); 
	}
	
	
}

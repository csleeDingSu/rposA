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
			$result =  Product::list_available_redeem_product($wallet->point, 1);
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
					

					$data = ['package_id'=>$package->id,'created_at'=>$now,'updated_at'=>$now,'member_id'=>$memberid,'redeem_state'=>1,'request_at'=>$now,'used_point'=>$package->min_point,'package_life'=>$package->package_life,'package_point'=>$package->package_freepoint];

					Wallet::update_ledger($memberid,'debit',$package->min_point,'PNT',$package->min_point.' Point reserved for VIP package');

					$dd = Package::save_vip_package($data);

					return response()->json(['success' => true, 'message' => 'success']);
				}
			break;
			
			//prepaid
			case '2':
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
			if ($passcode === $package->passcode)
			{
				Wallet::update_vip_wallet($memberid,$package->package_life,$package->package_point,'VIP');
				
				$now = Carbon::now();
				$data = ['redeem_state'=>3,'redeemed_at'=>$now];
						
				Package::update_vip($package->id, $data);
				
				return response()->json(['success' => true, 'message' => '']);
			}
			return response()->json(['success' => false, 'message' => 'wrong redeem code']);
		}
		
		return response()->json(['success' => false, 'message' => 'unknown vip package / user not authorise to use this package']);
	}	
	
}
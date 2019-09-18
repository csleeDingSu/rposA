<?php

namespace App\Http\Controllers\Api;

use App\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Validator;
use Carbon\Carbon;
use App\Wallet;
use App\Product;
use App\BasicPackage as Package;
class BasicPackageController extends Controller
{	
	
	public function list_package(Request $request)
    {
		$member_id = $request->memberid;
		
		$result =  Package::list_available_redeem_package(0);
		
		$data = Package::today_redeemded_new($member_id,'get');
		
		return response()->json(['success' => true,  'records' => $result,'purchase_data'=>$data]);
	}
	
	//no use
	public function request_package_upgrade(Request $request)
    {
		return response()->json(['success' => false, 'message' => 'deprecated']);
		
		$memberid  = $request->memberid;
		
		$packageid = $request->packageid;	
		
		$insdata   = [];
		
		$input = [
			 'memberid'    => $request->memberid,
			 'packageid'   => $request->packageid,			
			 'cardpass'    => $request->cardpass,		
			 'cardnum'     => $request->cardnum,	
			  ];
		$validator = Validator::make($input, 
			[
				'memberid'    => 'required',
				'packageid'   => 'required',
				//'cardpass'    => 'required',
				//'cardnum'     => 'required',
			]
		);
		if ($validator->fails()) {
			return response()->json(['success' => false, 'message' => $validator->errors()->all()]);
		} 
		
		//$wallet    = Wallet::get_wallet_9details($memberid);
		
		$package   = Package::get_package($packageid);
		
		if (!$package) return response()->json(['success' => false, 'message' => 'unknown package']);
		
		$setting   = \App\Admin::get_setting();
		$buy_count = Package::today_redeemded_new($memberid);
		
		if ($buy_count >= $setting->daily_basicpackage_redeem_limit) return response()->json(['success' => false, 'message' => 'you’ve reached the maximum units allowed for the today order ']);
		
		$usedprice = $package->package_price;
		
		if ($buy_count < 1 ) 
		{
			if ($package->package_discount_price >= 1)
			{
				$usedprice = $package->package_discount_price;
			}
		}		
		
		$now = Carbon::now();
		switch ($package->package_type)
		{
			//flexi type
			case '1':
				
				$data = ['package_id'=>$package->id,'created_at'=>$now,'updated_at'=>$now,'member_id'=>$memberid,'redeem_state'=>1,'request_at'=>$now,'used_point'=>0,'package_life'=>$package->package_life,'package_point'=>$package->package_freepoint,'ref_note'=>$request->ref_note,'buy_price'=>$usedprice,'cardpass'=>$request->cardpass,'cardnum'=>$request->cardnum];

				$dd = Package::save_basic_package($data);

				return response()->json(['success' => true, 'message' => 'success']);
				
			break;
		}		
		
		return response()->json(['success' => false, 'message' => 'insufficient point']);
	}
	
	public function get_redeem_history(Request $request)
    {
		$status = '';
		switch ($request->status)
		{
			case 'failed':
				$status = ['0'];
			break;
			case 'pending':
				$status = ['1'];
			break;
			case 'verified':
				$status = ['2','3'];
			break;	
		}
		$member_id = $request->memberid;
		$result    = Package::get_redeem_history($member_id,$status,30);		
		return response()->json(['success' => true, 'records' => $result]);
	}
	
	
}

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
		
		return response()->json(['success' => true,  'records' => $result]);
	}
	
	public function request_package_upgrade(Request $request)
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
				
				$data = ['package_id'=>$package->id,'created_at'=>$now,'updated_at'=>$now,'member_id'=>$memberid,'redeem_state'=>1,'request_at'=>$now,'used_point'=>0,'package_life'=>$package->package_life,'package_point'=>$package->package_freepoint,'ref_note'=>$request->ref_note];

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

<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Members as Member;
use Validator;
use Carbon\Carbon;
use App\Wallet;
class LedgerController extends Controller
{
	public function get_wallet_detail(Request $request)
	{
		$memberid = $request->memberid;
		$wallet   = Wallet::get_wallet_details($memberid);
		return $wallet;
	}
    
	public function get_wallet_detail_all(Request $request)
	{
		$memberid = $request->memberid;
		$wallet   = Wallet::get_wallet_details_all($memberid);
		return $wallet;
	}
	
	public function buy_point(Request $request)
	{
		$validator = $this->validate(
            $request,
            [
                 'points_to_add'   => 'required|min:1',
				 'memberid' => 'required|exists:members,id',
            ]
        );
		
		$memberid = $request->memberid;
		$newpoint = $request->points_to_add;	
		$data     = ['created_at'=>now(),'updated_at'=>now(),'status'=>1,'member_id'=>$memberid,'point'=>$newpoint,'notes'=>'',];
		
		$result   = Wallet::add_topup_request($data);
		
		if ($result)
		{
			return ['success' => true, 'refid' => $result];
		}
		return ['success' => false, 'message' => 'cannot add data.please contact admin'];
	}
	
	/**
	 * Status 1 - pending
	 * Status 2 - confirmed
	 * Status 3 - rejected
	 *
	 **/
	public function confirm_point_purchase(Request $request)
	{
		$memberid = $request->memberid;
		$refid    = $request->refid;		
		$result   = \DB::table('request_topup')->where('member_id',$memberid)->where('id', $refid)->where('status', 1)->first();
		
		if ($result)
		{
			$wallet  = Wallet::update_basic_wallet($memberid,0,$result->point,'TOP','credit', $result->notes);			
			$data    = ['confirmed_at'=>now(),'updated_at'=>now(),'status'=>2];
			$result  = Wallet::update_topup_request($result->id, $data);
			
			return ['success' => true, 'data' => $wallet];
		}
		return ['success' => false, 'message' => 'unknown record / redeemd already'];
	}
	
	public function reject_point_purchase(Request $request)
	{
		$memberid = $request->memberid;
		$refid    = $request->refid;		
		$result   = \DB::table('request_topup')->where('member_id',$memberid)->where('id', $refid)->where('status', 1)->first();
		
		if ($result)
		{
			$data    = ['confirmed_at'=>now(),'updated_at'=>now(),'status'=>3,'notes'=>'rejected by admin'];
			$result  = Wallet::update_topup_request($result->id, $data);
			
			return ['success' => true];
		}
		return ['success' => false, 'message' => 'unknown record/ rejected already'];
	}
	
}
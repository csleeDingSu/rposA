<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Members as Member;
use Validator;
use Carbon\Carbon;
use App\Wallet;
use App\Ledger;
class LedgerController extends Controller
{
	public function get_notifications(Request $request)
	{
		$memberid      = $request->memberid;
		$notification  = \App\Notification::with('ledger')->where('game_id',$request->gameid)->where('member_id',$memberid)->where('is_read',0)->orderby('created_at','DESC')->get();		
		return response()->json(['success' => true, 'count'=>$notification->count(), 'records' => $notification]);
	}
	
	public function mark_all_notifications(Request $request)
	{
		$memberid      = $request->memberid;		
		$notification  =\App\Notification::where('member_id',$memberid)->where('game_id',$request->gameid)->where('is_read',0)->update(['read_at' => now(),'is_read'=>1]);
		if ($notification)
		{
			return response()->json(['success' => true]);
		}		
		return response()->json(['success' => false]);
	}
	
	public function mark_notifications(Request $request)
	{
		$memberid      = $request->memberid;		
		$notification  =\App\Notification::where('member_id',$memberid)->where('id',$request->id)->update(['read_at' => now(),'is_read'=>1]);
		if ($notification)
		{
			return response()->json(['success' => true]);
		}		
		return response()->json(['success' => false]);
	}
	
	public function get_wallet_detail(Request $request)
	{
		$memberid = $request->memberid;
		$wallet   = Ledger::all_ledger($memberid);
		return $wallet;
	}
    
	public function get_wallet_detail_all(Request $request)
	{
		$memberid = $request->memberid;
		$wallet   = Ledger::all_ledger($memberid);
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
			//$result->point = $result->point * 10;
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
			$data    = ['confirmed_at'=>now(),'updated_at'=>now(),'status'=>3,'reject_notes'=>$request->notes];
			$result  = Wallet::update_topup_request($result->id, $data);
			
			return ['success' => true];
		}
		return ['success' => false, 'message' => 'unknown record/ rejected already'];
	}
	
	public function topup_history(Request $request)
	{
		$memberid = $request->memberid;
		$result   = \DB::table('request_topup')->where('member_id',$memberid)->get();
		$status   = ['1'=>'pending confirmation','2'=>'confirmed','3'=>'rejected'];
		return ['success' => true , 'records'=>$result , 'status_reference'=>$status]; 
		return $result;
	}
	
	public function merge_point(Request $request)
	{
		return $wallet = Ledger::merge_ledger_point($request->memberid,$request->fromgameid,$request->togameid, $request->point,$request->topoint);
	}
	
	public function convertbonustolife(Request $request)
	{
		$gameid = 102;
		
		$camout = \DB::table('games')->where('id' , 102)->first();
		
		if ($camout->bonus_point_to_life < 1)
		{
			return ['success' => false, 'message' => 'its not configured '];
		}
		
		$ledger = Ledger::ledger($request->memberid , $gameid);
		
		if ($ledger->bonus_point < $camout->bonus_point_to_life)
		{
			return ['success' => false, 'message' => 'you dont have enough bonus point to redeem '];
		}		
		
		$debit = Ledger::updateledger('debit','bonus_point',$request->memberid,$gameid,$camout->bonus_point_to_life,'BRBL', 'bonus point redeemd for life');
		
		
		$life  = Ledger::life($request->memberid,$gameid,'credit',1,$category = 'RBL', 'bonus life for bonus point');
		
		return ['success' => true ]; 
	}
	
	
}
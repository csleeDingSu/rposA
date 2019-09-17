<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Members as Member;
use Validator;
use Carbon\Carbon;
use App\Wallet;
use Illuminate\Support\Facades\Auth;
class MemberController extends Controller
{
    
	public function get_summary(Request $request)
    {
		if ($request->type == 'vip')
		{
			$request->type = 'buyproduct';
		}
		else
		{
			$request->type = 'basicpackage';
		}
		$result  = \App\History::get_summary($request->memberid,$request->type);
		$ref_cre = \DB::table('ref_credit_type')->select('name','value','type')->get();
		return response()->json(['success' => true,'records'=>$result,'credit_type_ref'=>$ref_cre]); 
	}
	public function update_profile()
    {
		return response()->json(['success' => true]); 
	}
		
	public function update_wechat (Request $request)
	{

		$id = $request->memberid;
		$record = Member::find($id);
		if ($record)
		{
			$input = [
				 'wechat_name'   => $request->wechat_name
				  ];
			$validator = Validator::make($input, 
				[
					'wechat_name' => 'nullable|unique:members,wechat_name,'.$id,
				]
			);
			if ($validator->fails()) {
				return response()->json(['success' => false, 'message' => $validator->errors()->all()]);
			}	
			else
			{
				$data = ['wechat_name' => $request->wechat_name,'wechat_verification_status' => 1];
				$res = Member::update_member($record->id,$data);				
				return response()->json(['success' => true]);
			}	
		}		
		return response()->json(['success' => false]);
	}
	
	
	public function member_referral_list(Request $request)
	{
		$id = $request->memberid;
		$result =  Member::get_member_referral_list($id);
		return response()->json(['success' => true,'data'=>$result]);
	}
	
	public function child_list(Request $request)
	{
		
		$result = Member::get_child($request->memberid);  
		return response()->json(['success' => true,'result' => $result]);
	}
	
	public function get_second_level_child_data(Request $request)
	{
		$status = '';
		$validator = $this->validate($request, 
            [
                'memberid' => 'required|exists:members,id',
            ]
        );
		
		
		switch ($request->status)
		{
			case 'verified':
				$status = ['0'];
			break;
			case 'pending':
				$status = ['1'];
			break;
			case 'failed':
				$status = ['2','3'];
			break;
			case 'default':
				$status = ['0','1','2','3'];
			break;	
		}
		$result = Member::get_second_level_child_data($request->memberid, $status); 
		return response()->json(['success' => true,'result' => $result]);
	}
	
	public function get_introducer_count(Request $request)
	{
		$validator = $this->validate($request, 
            [
                'memberid' => 'required|exists:members,id',
            ]
        );
		
		$result = Member::get_introducer_count($request->memberid);  
		$data   = Member::get_second_level_child_count($request->memberid);  
		$count  = $data['count'];
		$slcda  = $data['data'];
		
		$newcount = Member::get_second_level_child_count_new($request->memberid);
		
		return response()->json(['success' => true,'result' => $result,'slc_count'=>$count,'slc_data'=>$slcda,'slc_count_new'=>$newcount]);
	}
	
	public function get_introducer_history(Request $request)
	{
		$validator = $this->validate($request, 
            [
                'memberid' => 'required|exists:members,id',
            ]
        );
		
		$status = '';
		switch ($request->status)
		{
			case 'verified':
				$status = ['0'];
			break;
			case 'pending':
				$status = ['1'];
			break;
			case 'failed':
				$status = ['2','3'];
			break;
			case 'default':
				$status = ['0','1','2','3'];
			break;	
		}
		$result = Member::get_introducer_history($request->memberid, $status); 
		return response()->json(['success' => true,'result' => $result]);
	}
	
	
	public function get_wabao_coin_history(Request $request)
	{
		$validator = $this->validate($request, 
            [
                'memberid' => 'required|exists:members,id',
            ]
        );
		$result = Member::get_wabao_coin_history($request->memberid); 
		return response()->json(['success' => true,'result' => $result]);
	}
	
	
	public function generate_apikey(Request $request)
	{
		/*if (!Auth::Guard('member')->check())
		{
			return response()->json(['success' => false]);
		}
		$member = Auth::guard('member')->user()->id	;
		*/
		$member = $request->memberid;		
		$record = Member::find($member);
		
		if ($record)
		{
			$now = now();
			$now = Carbon::parse(now());
			
			if (Carbon::parse($record->key_expired_at)->gt(Carbon::now()))
			{
				$exp    = Carbon::parse($record->key_expired_at);
				$result =  ['apikey'=>$record->apikey, 'expired_at'=>$exp->toDateTimeString()];
				return response()->json(['success' => true,'result' => $result]);
			}
			
			$expire  = $now->addHour(1);
			$expire  = $expire->toDateTimeString();
			$result  = Member::generate_apikey($member,$expire ); 
			return response()->json(['success' => true,'result' => $result]);
		}
		return response()->json(['success' => false,'message' => 'unknown member']);
	}
	
	public function check_vip_status(Request $request)
	{
		$member = $request->memberid;
		$record = \App\BasicPackage::check_vip_status($member);
		return response()->json(['success' => true,'result' => $record]);
	}
	
	public function purge_game_life(Request $request)
	{
		$user = Member::find($request->memberid);
		if (!$user) return response()->json(['success' => false,'message' => 'unknown member']);
		$result = Member::purge_game_life($user);		
		return $result;
	}
	
	
	public function update_phone (Request $request)
	{
		$id = $request->memberid;
		$record = Member::find($id);
		if ($record)
		{
			$input = [
				 'phone'   => $request->phone
				  ];
			$validator = Validator::make($input, 
				[
					'phone' => 'required|unique:members,phone,'.$id,
				]
			);
			if ($validator->fails()) {
				return response()->json(['success' => false, 'message' => $validator->errors()->all()]);
			}	
			$record->phone = $request->phone;
			$record->save();				
			return response()->json(['success' => true]);	
		}		
		return response()->json(['success' => false,'message' =>['Unknown user']]);
	}	
		
	public function list_receipt(Request $request)
	{
		$receipt = \App\Receipt::where('member_id', $request->memberid);	
		
		if ($request->receipt)
		{
			$receipt = $receipt->where('receipt', $request->receipt);
		}
		$receipt = $receipt->latest()->get();
		
		return response()->json(['success' => true, 'records'=>$receipt]); 
	}
	
	public function add_receipt(Request $request)
	{
		$validator = $this->validate($request, 
            [
                'memberid' => 'required|exists:members,id',
				'receipt'  => 'required',
            ]
        );
				
		$receipt = \App\Receipt::where('member_id', $request->memberid)->where('receipt', $request->receipt)->first();		
		if ($receipt)
		{
			return response()->json(['success' => false,'message' => 'receipt already exist']);
		}		
		$receipt = \App\Receipt::create(['member_id' => $request->memberid , 'receipt' => $request->receipt ]);
		
		return response()->json(['success' => true, 'refid'=>$receipt->id]);
	}
	
}
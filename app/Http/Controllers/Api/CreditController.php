<?php

namespace App\Http\Controllers\Api;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Validator;
use Carbon\Carbon;

use App\CreditResell;
use App\ResellStatus;


class CreditController extends Controller
{
   public function request_resell(Request $request)
   {
		
		$validator = Validator::make($request->all(), 
			[
				'memberid'  => 'required',
				'passcode'  => 'required',		
				'point'     => 'required',				
			]
		);
	   
		if ($validator->fails()) {
			return response()->json(['success' => false, 'message' => $validator->errors()->all()]);
		}

		$ledger = \App\Ledger::ledger($request->memberid, 103);

		if ($ledger->point < $request->point)
		{
			return response()->json(['success' => false, 'message' => 'not enough point' ]);
		}

		//debit point
		$debit   = \App\Ledger::updateledger('debit','point',$request->memberid,103,$request->point,'PRCP', 'point deducted for sell');

		$reserve = \App\Ledger::reserve($request->memberid,103,$request->point,'RCP', 'point reserved for sell');



		
		//reserve point

		$resell 		   = new \App\CreditResell();
		$resell->member_id = $request->memberid;
		$resell->point     = $request->point;
		$resell->amount    = $request->amount;
		$resell->status_id = 1;
		$resell->image     = $request->image;
		$resell->passcode  = $request->passcode;
		$resell->barcode   = $request->barcode;
		
		$resell->save();
		//add history
		$history            = new \App\ResellHistory();
		$history->cid       = $resell->id;
		$history->status_id = 1;
		$history->point     = $request->point;
		$history->save();
		
		return response()->json(['success' => true]);
	}

    public function get_buyer(Request $request)
    {
    	$type        = '';
    	$companydata = '';
    	$record      = \App\CreditResell::with('status','member')->where('is_locked', null)->where('status_id', 2)->where('point', $request->point)->oldest()->first();
    	if ($record)
    	{
    		$record->is_locked   = 1;
    		$record->locked_time = Carbon::now()->addMinutes(10);
    		$record->save();
    	}    	

    	if (!$record)
    	{
    		//use default data
    		$companydata = \App\CompanyBank::with('member')->first();
    		$type        = 'companyaccount';

    		$amdata = \DB::table('resell_amount')->where('point',$request->point)->first();
    		$amount = 0;
    		if ($amdata)
    		{
    			$amount = $amdata->amount;
    		}

    		//reserve point
			$record 		     = new \App\CreditResell();
			$record->member_id   = $companydata->member->id;
			$record->buyer_id    = $request->memberid;
			$record->point       = $request->point;
			$record->amount      = $amount;
			$record->status_id   = 1;
			$record->is_locked   = 1;
    		$record->locked_time = Carbon::now()->addMinutes(10);			
    		$record->type        = 1;			
			$record->save();
			//add history
			$history             = new \App\ResellHistory();
			$history->cid        = $record->id;
			$history->status_id  = 1;
			$history->point      = $request->point;
			$history->save();


    	}
    	return response()->json(['success' => true, 'record'=>$record,'company'=>$companydata, 'type'=>$type]);
    }

    public function make_resell_success(Request $request)
    {
    	$record  = \App\CreditResell::with('status','member')->where('is_locked', 1)->where('id', $request->id)->first();
    	if ($record)
    	{
    		$record->status_id   = 3; // in progress
	    	$record->is_locked   = null;
	    	$record->locked_time = null;
	    	$record->buyer_id    = $request->buyerid;
	    	$record->buyer_name  = $request->buyer_name;
	    	
	    	$record->save();

	    	$history            = new \App\ResellHistory();
			$history->cid       = $record->id;
			$history->status_id = 3;
			$history->amount    = $record->amount;
			$history->point     = $record->point;
			$history->save();

			return response()->json(['success' => true]);
    	}
    	return response()->json(['success' => false, 'message' => 'unknown record' ]);
    }

    public function make_resell_expired(Request $request)
    {
    	$record  = \App\CreditResell::with('status','member')->where('is_locked', 1)->where('id', $request->id)->first();
    	if ($record)
    	{
    		$reason              = 'pay time exceeded';

    		$new = $record->replicate();       
            $expired             = new \App\ExpiredResell();
            $expired->fill($new->toArray());
            $expired->status_id  = 5;
            $expired->reason     = $reason;
            $expired->save();

    		$record->status_id   = 2;
	    	$record->is_locked   = null;
	    	$record->locked_time = null;
	    	$record->reason      = $reason;
	    	$record->save();

	    	$history             = new \App\ResellHistory();
			$history->cid        = $record->id;
			$history->status_id  = 5;
			$history->amount     = $record->amount;
			$history->point      = $record->point;
			$history->reason     = $reason;
			$history->save();

			return response()->json(['success' => true]);		
    	}


    	return response()->json(['success' => false, 'message' => 'unknown record' ]);
    }

    public function resell_list(Request $request)
    {
    	$result = \App\CreditResell::with('status','buyer')->where('member_id', $request->memberid)->latest()->paginate(30);

    	return response()->json(['success' => true,  'result'=>$result]);
    }

    public function buyer_list(Request $request)
    {
    	$result = \App\CreditResell::with('status','member')->where('buyer_id', $request->memberid)->latest()->paginate(30);

    	return response()->json(['success' => true,  'result'=>$result]);
    }

    public function resell_tree(Request $request)
    {
    	
    	$record = \App\CreditResell::where('member_id', $request->memberid)->first();
    	if ($record)
    	{
    		$result = \App\ResellHistory::with('status')->where('cid', $request->id)->latest()->paginate(30);
    		return response()->json(['success' => true,  'result'=>$result]);	
    	}
    	return response()->json(['success' => false, 'message' => 'unknown record' ]);
    }

    public function pending_list(Request $request)
    {    	

    	if ($request->type == 'buy')
    	{
    		$type   = 'buyer_id';
    		$result = \DB::table('view_credit_resell')->where($type, $request->memberid)->where('is_locked', 1)->latest()->get();
    	}
    	else
    	{
    		$type = 'member_id';
    		$status = [1,2,3];
    		$result = \DB::table('view_credit_resell')->where($type, $request->memberid)->latest()->wherein('status_id', $status)->latest()->get();
    	}

    	$count  = $result->count();

    	return response()->json(['success' => true,  'count'=>$count,  'records'=>$result]);
    }


	public function expired_list(Request $request)
    {    
    	if ($request->type == 'buy')
    	{
    		$type   = 'buyer_id';
    	}
    	else
    	{
    		$type = 'member_id';
    	}

    	$result = \DB::table('credit_resell_expired')->where($type, $request->memberid)->latest()->get();

    	$count  = $result->count();

    	return response()->json(['success' => true,  'count'=>$count,  'records'=>$result]);
    }






	
}

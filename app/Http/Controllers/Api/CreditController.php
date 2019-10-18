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
		$resell->status_id = 1;
		$resell->image     = $request->image;
		$resell->passcode  = $request->passcode;
		$resell->save();
		//add history
		$history            = new \App\ResellHistory();
		$history->cid       = $resell->id;
		$history->status_id = 1;
		$history->point     = $request->point;
		$history->save();
		
		return response()->json(['success' => true]);
	}


	






	
}

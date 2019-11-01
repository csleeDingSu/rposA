<?php
/***
 *
 *
 ***/
namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

use Carbon\Carbon;
use App\ResellStatus;

class CreditController extends BaseController
{
	use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

	public function completed_listdata (Request $request)
	{		
		$input  = [];
		$data['firstload'] = '';
		if ($request->ajax()) 
		{
			parse_str($request->_data, $input);
			$input  = array_map('trim', $input);
			
			$callback = function($q) use($input) {
	            if (!empty($input['s_buyer'])) {
	            	$q->where('phone','LIKE', "%{$input['s_buyer']}%") ;
	            }
	            
	        };
			$result = \App\CreditResell::with('buyer')
						->whereHas('member', function($q) use($input) {
							if (!empty($input['s_member'])) {
								$q->where('phone','LIKE', "%{$input['s_member']}%") ;
							}	
						})
						->whereHas('status', function($q) use($input) {
							if (!empty($input['s_status'])) 
							{
								$q->where('status_id','LIKE', "%{$input['s_status']}%") ;
							} 
							else
							{
								$q->whereIn('status_id',[4,5]) ;
							}
								
						});
							
					if (!empty($input['s_buyer']))  
					{
						$result = $result->whereHas('buyer',$callback) ;
					}	
	
			$result =  $result->latest('updated_at')->paginate(30);
					
            return view('resell.ajaxlist', ['result' => $result])->render();  
        }	
        $data['firstload'] = 'yes';
        $data['page']      = 'resell.list'; 		
		$data['statuses']  = \App\ResellStatus::whereIn('id',[4,5]);
		dd($data['statuses']);
		$data['result']    = collect([]); 

		return view('main', $data);	
	}

    public function listdata (Request $request)
	{		
		$input  = [];
		$data['firstload'] = '';
		if ($request->ajax()) 
		{
			parse_str($request->_data, $input);
			$input  = array_map('trim', $input);
			
			$callback = function($q) use($input) {
	            if (!empty($input['s_buyer'])) {
	            	$q->where('phone','LIKE', "%{$input['s_buyer']}%") ;
	            }
	            
	        };
			$result = \App\CreditResell::with('buyer')
						->whereHas('member', function($q) use($input) {
							if (!empty($input['s_member'])) {
								$q->where('phone','LIKE', "%{$input['s_member']}%") ;
							}	
						})
						->whereHas('status', function($q) use($input) {
							if (!empty($input['s_status']))  
								$q->where('status_id','LIKE', "%{$input['s_status']}%") ;
						});
					if (!empty($input['s_buyer']))  
					{
						$result = $result->whereHas('buyer',$callback) ;
					}	
	
			$result =  $result->latest('updated_at')->paginate(30);
					
            return view('resell.ajaxlist', ['result' => $result])->render();  
        }	
        $data['firstload'] = 'yes';
        $data['page']      = 'resell.list'; 		
		$data['statuses']  = \App\ResellStatus::all();
		$data['result']    = collect([]); 

		return view('main', $data);	
	}


	public function render_data($id)
    {
    	$record    = \App\CreditResell::with('status','member')->where('id',$id)->get();	
		$statuses  = \App\ResellStatus::all();
		return view('resell.render_data', ['result' => $record]) ->render();
    }


    public function show(Request $request)
    {
    	//dd($request->id);	
    	//$request->id = 8;
    	$record    = \App\CreditResell::with('status','member')->where('id',$request->id)->first();	
		$statuses  = \App\ResellStatus::all();
		switch ($record->status_id)
		{
			case '1':			
				$statuses = $statuses->only(['1','2','7']);
			break;
			case '2':
				$statuses = $statuses->only(['2','7']);
			break;
			case '3':
				$statuses = $statuses->only(['3', '4', '5']);
			break;
			case '4':
				$statuses = $statuses->only(['4']);
			break;
			case '5':
				$statuses = $statuses->only(['5']);
			break;
			case '7':
				$statuses = $statuses->only(['7']);
			break;
		}
		$render    =  view('resell.render_edit', ['result' => $record , 'id'=>$record->id , 'statuses'=>$statuses]) ->render();
		return response()->json(['success' => true,'id'=>$request->id,'record'=>$render]);	
    }
    
    public function update_resell(Request $request)
    {
    	$updatehistory = '';	
		$ledger        = '';
		$reason = '';

    	$validator = $this->validate(
            $request,
            [
                //'amount' => 'required|string|min:4',
				///'email' => 'required|email|unique:users,email,'.$request->id,
            ]
        );

        $record  = \App\CreditResell::with('status')->where('id', $request->id)->first();
        
		if ($record->status_id == 4)
		{
			return response()->json(['success' => false,'errors'=> ['status_id'=>['already completed'] ] ],422);	
		}
		else if ($record->status_id == 5)
		{
			return response()->json(['success' => false,'errors'=> ['status_id'=>['unsuccessful payment.you cant use this option'] ] ],422);	
		}
		else if ($record->status_id == 6)
		{
			if(!in_array($request->status_id, [1,4,5]))
			{
				return response()->json(['success' => false,'errors'=> ['status_id'=>['you cant use this option'] ] ],422);	
			}					
		}
		else if ($record->status_id == 7)
		{
			return response()->json(['success' => false,'errors'=> ['status_id'=>['already rejected'] ] ],422);	
		}

		$member  = \App\Member::where('phone', $request->buyer_id )->first();

		
        switch($request->status_id)
        {
        	case '1':
        		
        	break;
        	case '2':        		        		
        		//update only in unknow 
	        	if ($record->status_id == 6)
				{
					$record->buyer_id    = null; 
					$record->is_locked   = null; 
					$record->locked_time = null;
					$record->buyer_id    = null; 
					$record->reason      = null; 
					//$record->barcode     = null; 
        			$record->status_id   = 1;
        			$reson               = 'admin reset to active';
        			$record->save();
        			$updatehistory = 'yes';		
				}
				else
				{
					//$record->buyer_id  = $member->id; 
	        		$record->status_id = $request->status_id;
					$record->save();				
	        		$updatehistory = 'yes';	
				}
        	break;
        	case '3':
        		//update buyer data  
	        	if (!$request->buyer_id)
				{
					return response()->json(['success' => false,'errors'=> ['buyer_id'=>['unknown member'] ] ],422);	
				}
				if ($record->status_id != 3)
				{
					$updatehistory = 'yes';	
				}

        		$record->buyer_id  = $member->id; 
        		$record->status_id = $request->status_id;
				$record->save();

        	break;
        	case '4':
        		//update buyer data & add points to buyer account
        		if (!$request->buyer_id)
				{
					return response()->json(['success' => false,'errors'=> ['buyer_id'=>['unknown member'] ] ],422);	
				}
        		$record->buyer_id = $member->id;   
        		//add points 
        		$ledger = \App\Ledger::credit($member->id,103,$record->point,'PRS','point bought from resell');
        		//$record->ledger_history_id = $ledger['id'];
        		$record->status_id  = $request->status_id;
        		$record->ledger_history_id = $ledger['id'];
				$record->save();

				$updatehistory = 'yes';			
				
        	break;
        	case '5':
        		//return the point

        		if (!$request->reason)
				{
					return response()->json(['success' => false,'errors'=> ['reason'=>['add your reason here'] ] ],422);	
				}
        		$ledger = \App\Ledger::merge_reserved_point($member->id,103,$record->point,'PRRP', 'point refunded');
        		//print_r($ledger);
        		$record->status_id  = $request->status_id;
        		$record->reason     = $request->reason;
        		$record->ledger_history_id = $ledger['id'];
        		$record->save();

        		$updatehistory = 'yes';		
        	break;
        	case '6':
        		return response()->json(['success' => false,'errors'=> ['status_id'=>['you cant use this option'] ] ],422);	
        	break;
        	case '7':
        		if (!$request->reason)
				{
					return response()->json(['success' => false,'errors'=> ['reason'=>['add your reason here'] ] ],422);	
				}
        		$ledger = \App\Ledger::merge_reserved_point($record->member_id,103,$record->point,'PRRP', 'point refunded');
        		$record->status_id  = 7;
        		$record->reason     = $request->reason;
        		$record->ledger_history_id = $ledger['id'];
        		$record->save();
        		$updatehistory = 'yes';	
        	break; 
        }

        if ($updatehistory)
        {        	
        	$memid = null;
        	if (!empty($member->id))
        	{
        		$memid = $member->id;
        	}
        	//add history
    		$history            = new \App\ResellHistory();
			$history->cid       = $record->id;
			$history->status_id = $request->status_id;
			$history->amount    = $record->amount;
			$history->point     = $record->point;
			$history->member_id = $record->member_id;
			$history->buyer_id  = $memid;
			$history->reason    = $reason;

			if ($ledger)
			{
				$history->ledger_history_id = $ledger['id'];
			}

			$history->save();
        }

        return response()->json(['success' => true, 'id'=>$record->id, 'record' => $this->render_data($record->id) ]);
    }
    
    public function confirm(Request $request)
    {
    	$record  = \App\CreditResell::with('status')->where('id', $request->id)->first();
    	$status  = 3;
    	if ($record)
		{
			if ($record->status_id == '3')
			{
				//no action
				return response()->json(['success' => false, 'message' => 'confirmed already']);
			}

			//add History

			$history            = new \App\ResellHistory();
			$history->cid       = $record->id;
			$history->status_id = $status;
			$history->amount    = $record->amount;

			$record->status_id  = $status;
			$record->save();
		}

		return response()->json(['success' => false, 'message' => 'unknown record']);
    }

    public function reject(Request $request)
    {
    	$record  = \App\CreditResell::with('status')->where('id', $request->id)->first();
    	$status  = 4;
    	if ($record)
		{
			if ($record->status_id == '4')
			{
				//no action
				return response()->json(['success' => false, 'message' => 'rejected already']);
			}

			//add History

			$history            = new \App\ResellHistory();
			$history->cid       = $record->id;
			$history->status_id = $status;
			$history->amount    = $record->amount;

			$record->status_id  = $status;
			$record->save();
		}

		return response()->json(['success' => false, 'message' => 'unknown record']);
    }
}

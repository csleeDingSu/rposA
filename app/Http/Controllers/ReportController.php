<?php
/***
 *
 *
 ***/

namespace App\Http\Controllers;
use DB;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Report;
use Carbon\Carbon;

class ReportController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
	
	protected $hidden = ['password', 'password_hash', 'age', 'created_at'];
	
	public function dashboard ()
	{
		$data['page']   = 'admin.dashboard';
		$data['result'] =  DB::table('dashboard')->first();
		return view('main', $data);
	}
	
	public function gameinfo ()
	{
		$result =  Report::game_win_lose();
		return response()->json(['success' => true, 'record' => $result]);
	}
	
	
	public function redeem_product (Request $request)
	{
				
		$result =  \DB::table('view_redeem_history');
		$input = array();		
		parse_str($request->_data, $input);
		$input = array_map('trim', $input);
		
    	if ($input) 
		{
			//filter					
			if (!empty($input['s_username'])) {
				$result = $result->where('username','LIKE', "%{$input['s_username']}%") ;				
			}
			if (!empty($input['s_code'])) {
				$result = $result->where('code','LIKE', "%{$input['s_code']}%") ;				
			}
			if (!empty($input['s_product_name'])) {
				$result = $result->where('product_name','LIKE', "%{$input['s_product_name']}%") ;				
			}
			if (isset($input['s_status'])) {
				if ($input['s_status'] != '' )
					$result = $result->where('pin_status','=',$input['s_status']);
			}
		}		
		$result         =  $result->orderby('created_at','ASC')->paginate(30);
				
		$data['page']   = 'reports.redeem_product.list'; 	
				
		$data['result'] = $result; 
				
		if ($request->ajax()) {
            return view('reports.redeem_product.ajaxlist', ['result' => $result])->render();  
        }					
		return view('main', $data);	
	}
	
	
	public function ledger_report (Request $request)
	{
				
		$result =  \DB::table('view_ledger_details');
		$input = array();		
		parse_str($request->_data, $input);
		$input = array_map('trim', $input);
		
    	if ($input) 
		{
			//filter					
			if (!empty($input['s_username'])) {
				$result = $result->where('username','LIKE', "%{$input['s_username']}%") ;				
			}
			if (!empty($input['s_phone'])) {
				$result = $result->where('phone','LIKE', "%{$input['s_phone']}%") ;				
			}
						
			if (isset($input['s_type'])) {
				if ($input['s_type'] != '' )
					$result = $result->where('credit_type','=',$input['s_type']);
			}
		}		
		$result         =  $result->orderby('created_at','DESC')->paginate(50);
				
		$data['page']   = 'reports.point_report.list'; 	
				
		$data['result'] = $result; 
				
		if ($request->ajax()) {
            return view('reports.point_report.ajaxlist', ['result' => $result])->render();  
        }					
		return view('main', $data);	
	}
	
}

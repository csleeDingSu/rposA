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
		
		$order_by = 'DESC';
		
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
			if (!empty($input['order_by'])) {
				$order_by = $input['order_by'] ;				
			}
		}		
		$result         =  $result->orderby('created_at',$order_by)->paginate(50);
				
		$data['page']   = 'reports.point_report.list'; 	
				
		$data['result'] = $result; 
				
		if ($request->ajax()) {
            return view('reports.point_report.ajaxlist', ['result' => $result])->render();  
        }					
		return view('main', $data);	
	}
	
	public function list_gameplayed (Request $request)
	{
				
		$result =  \DB::table('report_played_count');
		$input = array();		
		parse_str($request->_data, $input);
		$input = array_map('trim', $input);
		
    	if ($input) 
		{
			//filter					
			if (!empty($input['s_drawid'])) {
				$result = $result->where('draw_id', "{$input['s_drawid']}") ;				
			}
		}		
		$result =  $result->orderby('draw_id','ASC')->paginate(30);
				
		$data['page']    = 'reports.draw.list'; 	
				
		$data['result']  = $result; 
				
		if ($request->ajax()) {
            return view('reports.draw.ajaxlist', ['result' => $result])->render();  
        }
					
		return view('main', $data);	
	}
	
	public function list_redeemed (Request $request)
	{
				
		$result =  \DB::table('report_redeem_count');
		$input = array();		
		parse_str($request->_data, $input);
		$input = array_map('trim', $input);
		
    	if ($input) 
		{
			//filter					
			if (!empty($input['s_drawid'])) {
				//$result = $result->where('title', "{$input['draw_id']}") ;				
			}
			if (!empty($input['s_content'])) {
				//$result = $result->where('content','LIKE', "%{$input['s_content']}%") ;				
			}
		}		
		$result =  $result->paginate(30);
				
		$data['page']    = 'reports.redeem_count.list'; 	
				
		$data['result'] = $result; 
				
		if ($request->ajax()) {
            return view('reports.redeem_count.ajaxlist', ['result' => $result])->render();  
        }
					
		return view('main', $data);	
	}
	
	
	public function get_played_members (Request $request)
	{
		$drawid = $request->id;
		$type   = $request->type;
		if (empty($drawid))
		{
			$drawid = '0';
		}		
		$result =  \DB::table('report_played_member')->where('draw_id',$drawid);
		
		switch ($type)
		{
			case 'all':
				//$result = $result->where('draw_id',$drawid);
			break;
			case 'odd':
				$result = $result->where('bet','odd');
			break;
			case 'even':
				$result = $result->where('bet','even');
			break;
		}
		$result = $result->get();			
		
		return view('reports.draw.playedmembers', ['result' => $result])->render();  		
	}
	
	public function get_redeem_members (Request $request)
	{
		$id     = $request->id;
		$type   = $request->type;
		$pack   = $request->ptype;
		$page   = 'members';
		
		switch ($pack)
		{
			case 'product':
				$result =  \DB::table('view_redeem_history_all')->where('id',$id); 				
				$page = 'product_member';			
				
			break;
			case 'basic_package':
				$result =  \DB::table('view_basic_package_user_list')->where('package_id',$id); 
				if ($type)
				{
					switch ($type)
					{
						case 'all':
						break;
						case 'rejected':
							$result = $result->where('redeem_state',0);
						break;	
						case 'reserved':
							$result = $result->where('redeem_state',1);
						break;
						case 'used':
							$result = $result->wherein('redeem_state',[2,3,4]);
						break;	
					}					
				}
			break;
			case 'vip':
				$result = $result->where('bet','even');
			break;
		}
		$result = $result->get();
		return view('reports.redeem_count_new.'.$page, ['result' => $result])->render(); 
	}
	
	public function played_details (Request $request)
	{
		$drawid = $request->id;
		
		if (empty($drawid))
		{
			$drawid = '0';
		}		
		$result =  \DB::table('report_played_member')->where('game_id','101');
		
		//filters
		$input = array();		
		parse_str($request->_data, $input);
		$input = array_map('trim', $input);
		
		$order_by = 'DESC';
		
    	if ($input) 
		{
			//filter					
			if (!empty($input['s_username'])) {
				$result = $result->where('username','LIKE', "%{$input['s_username']}%") ;				
			}
			if (!empty($input['s_phone'])) {
				$result = $result->where('phone','LIKE', "%{$input['s_phone']}%") ;				
			}
			if (!empty($input['s_drawid'])) {
				$result = $result->where('draw_id','LIKE', "%{$input['s_drawid']}%") ;				
			}
						
			
		}		
		$result         =  $result->orderby('created_at',$order_by)->paginate(30);
			
		$data['page']   = 'reports.play.list'; 	
				
		$data['result'] = $result; 
				
		if ($request->ajax()) {
            return view('reports.play.ajaxlist', ['result' => $result])->render();  
        }
		return view('main', $data);			
	}
}

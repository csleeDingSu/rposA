<?php
/***
 *
 *
 ***/

namespace App\Http\Controllers;
use App;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Wallet;

use Carbon\Carbon;
use App\BasicPackage;


class BasicPackageController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
	
	public $pagination_count = 100;
	
	
	/*** Basic package ***/
	public function list_basicpackage (Request $request)
	{
				
		$result =  \DB::table('view_basic_package')->whereNull('deleted_at');
		$input = array();		
		parse_str($request->_data, $input);
		$input = array_map('trim', $input);
		
    	if ($input) 
		{
			//filter					
			if (!empty($input['s_name'])) {
				$result = $result->where('package_name','LIKE', "%{$input['s_name']}%") ;				
			}						
			if (isset($input['s_status'])) {
				if ($input['s_status'] != '' )
					$result = $result->where('package_status','=',$input['s_status']);
			}
		}	
		$result         =  $result ->orderByRaw('-seq desc')->paginate(30);
		//$result         =  $result->orderby('created_at','DESC')->paginate(30);
				
		$data['page']   = 'basicpackage.list'; 	
				
		$data['result'] = $result; 
				
		if ($request->ajax()) {
            return view('basicpackage.ajaxlist', ['result' => $result])->render();  
        }					
		return view('main', $data);	
	}
	
	public function updatebasicpackage($input)
    {
		$id = $input['hidden_void'];
		
		$validator = Validator::make($input, [
			'package_name'   => 'required|string|min:2',
			'package_discount_price' => 'nullable|between:0,99999.99',
			'price' => 'numeric|between:0,99999.99',
			'package_pic_url' => 'required',
			'package_life' => 'sometimes|numeric|min:0',
			'package_freepoint' => 'sometimes|numeric|min:0',
		]);
 
		if ($validator->fails()) {
			return response()->json(['success' => false, 'message' => $validator->errors()->all()]);
		}
		
		$now = Carbon::now();
		$data = ['package_name' => $input['package_name'],'package_discount_price' => $input['package_discount_price'],'package_status' => $input['status'],'package_price' => $input['price'],'updated_at' => $now,'package_picurl' => $input['package_pic_url'],'package_description' => $input['package_description'], 'package_life' => $input['package_life'],
				 'package_freepoint' => $input['package_freepoint'] , 'seq' => $input['seq']
				];
		 
		BasicPackage::update_package($id,$data);
		$row = $this->render_basicpackage($id);
		return response()->json(['success' => true,'mode'=>'edit','dataval'=>$row]);
	}
	
	public function save_basicpackage(Request $request)
    {
		$input = array();		
		parse_str($request->_data, $input);
		$input = array_map('trim', $input);
		
		
		if ($input['mode'] =='edit')
		{
			return $this->updatebasicpackage($input);
		}
		
		$validator = Validator::make($input, [
			'package_name'   => 'required|string|min:2',
			'package_discount_price' => 'nullable|between:0,99999.99',
			'price' => 'numeric|between:0,99999.99',
			'package_pic_url' => 'required',
			'package_life' => 'sometimes|numeric|min:0',
			'package_freepoint' => 'sometimes|numeric|min:0',
		]);
 
		if ($validator->fails()) {
			return response()->json(['success' => false, 'message' => $validator->errors()->all()]);
		}
		
		$now = Carbon::now();
		$data = ['package_name' => $input['package_name'],
				 'package_discount_price' => $input['package_discount_price'],
				 'package_status' => $input['status'],
				 'package_price' => $input['price'],
				 'created_at' => $now,
				 'package_picurl' => $input['package_pic_url'],
				 'package_description' => $input['package_description'],
				 'package_life' => $input['package_life'],
				 'package_freepoint' => $input['package_freepoint'] ,
				 'package_type' => 1 ,
				 'seq' => $input['seq']  
				];
		 
		$id = BasicPackage::save_package($data);
		
		$row = $this->render_basicpackage($id);
		
		
		return response()->json(['success' => true, 'message' => trans('dingsu.new_package_success_message'),'record'=>$row]);
	}
	
	public function getbasicpackage(Request $request)
	{
		$id = $request->id;
		$record = BasicPackage::get_package($id);
		return response()->json(['success' => true, 'record' => $record]);
	}
	public function delete_basicpackage(Request $request)
	{
		$id = $request->id;
		$record = BasicPackage::get_view_package($id);
		if ($record)
		{
			if ($record->reserved_quantity)
			{
				return response()->json(['success' => false, 'message' => 'entitled with user']);
			}
			//Package::delete_package($record->id);
			$now = Carbon::now();
			BasicPackage::update_package($id, ['deleted_at'=>$now, 'package_status'=> 3 ]);
			return response()->json(['success' => true, 'record' => '']);
		}
		else{
			return response()->json(['success' => false, 'message' => 'unknown package']);
		}	
	}
	
	public function render_basicpackage ($id)
	{
		$package = BasicPackage::get_package($id);
		$row  = '<tr id=tr_'.$package->id.'>';
		$row .= "<td>$package->id</td>";
		$row .= "<td>$package->created_at</td>";		
		$row .= "<td>$package->seq</td>";	
		$row .= '<td>'.$package->package_name.'</td>';
		$row .= '<td>'.$package->package_price.'</td>';
		$row .= '<td>'.$package->package_life.'</td>';
		
		switch ($package->package_status)
			{
				case '1':
					$badge = "<label class='badge badge-success'>".trans('dingsu.active')."</label> ";
				break;
				case '2':
					$badge = "<label class='badge badge-warning'>".trans('dingsu.inactive')."</label> ";
				break;				
					
			}
		$row .= "<td>$badge</td>";
		
		$row .= '<td><a href="javascript:void(0)" data-id="'.$package->id.'" class="editrow btn btn-icons btn-rounded btn-outline-info btn-inverse-info"><i class=" icon-pencil "></i></a>
									
				<a href="javascript:void(0)" onClick="confirm_Delete('.$package->id.');return false;" class="btn btn-icons btn-rounded btn-outline-danger btn-inverse-danger"><i class=" icon-trash  "></i></a></td>';
		$row .= '</tr>';
		return $row;
	}
	
	public function list_redeem_basicpackage(Request $request)
    {
		$result =  \DB::table('view_basic_package_pending');		
		
		$input = array();
		
		parse_str($request->_data, $input);
		$input = array_map('trim', $input);
		
    	if ($input) 
		{
			//filter					
			if (!empty($input['s_package_name'])) {
				$result = $result->where('package_name','LIKE', "%{$input['s_package_name']}%") ;				
			}
			if (!empty($input['s_phone'])) {
				$result = $result->where('phone','LIKE', "%{$input['s_phone']}%") ;				
			}
			if (!empty($input['s_wechat_name'])) {
				$result = $result->where('wechat_name','LIKE', "%{$input['s_wechat_name']}%") ;				
			}
		}
		
		//DB::enableQueryLog();
		
		$result =  $result->orderby('id','DESC')->paginate(30);
		
		//$queries = DB::getQueryLog();
		//print_r(DB::getQueryLog());
		//print_r($queries);
		
		
		//die();
		$data['page'] = 'basicpackage.pendinglist.list'; 	
				
		$data['result'] = $result; 
		
		if ($request->ajax()) {
            return view('basicpackage.pendinglist.ajaxlist', ['result' => $result])->render();  
        }
					
		return view('main', $data);
	}
	
		
	public function list_basicredeem_history(Request $request)
    {
		$result =  \DB::table('view_basic_package_user_list');		
		
		$input = array();
		
		parse_str($request->_data, $input);
		$input = array_map('trim', $input);
		
    	if ($input) 
		{
			//filter					
			if (!empty($input['s_package_name'])) {
				$result = $result->where('package_name','LIKE', "%{$input['s_package_name']}%") ;				
			}
			if (!empty($input['s_phone'])) {
				$result = $result->where('phone','LIKE', "%{$input['s_phone']}%") ;				
			}
			if (!empty($input['s_wechat_name'])) {
				$result = $result->where('wechat_name','LIKE', "%{$input['s_wechat_name']}%") ;				
			}
		}
		
		$result =  $result->orderby('id','DESC')->paginate(30);
		
		$data['page'] = 'basicpackage.history.list'; 	
				
		$data['result'] = $result; 
		
		
		 if ($request->ajax()) {
            return view('basicpackage.history.ajaxlist', ['result' => $result])->render();  
        }
					
		return view('main', $data);
	}
	
	/**
	 * @todo:- get random length from config
	 *
	 **/
	public function confirm_basicpackage(Request $request)
    {
		$id = $request->id;
		$record = BasicPackage::get_basic_package($id);
		
		if ($record)
		{
			$now = Carbon::now();
			$passcode = unique_random('basic_redeemed','passcode',8);
			$data = ['redeem_state'=>3,'confirmed_at'=>$now,'passcode'=>$passcode,'redeemed_at'=>$now];
			BasicPackage::update_basicpackage($record->id, $data);
			
			$wallet  = Wallet::update_basic_wallet($record->member_id,$record->package_life,$record->package_point,'BPR');
			
			$refdata = [ 'id'=>$id, 'refid'=>$wallet['refid'], 'type'=>'basicpackage' ];
			Wallet::add_ledger_ref($refdata);
			
			
			return response()->json(['success' => true, 'message' => 'success']);
		}
		else{
			return response()->json(['success' => false, 'message' => 'unknown product']);
		}	
	}
	
	public function reject_basicpackage(Request $request)
    {
		//return false;
		
		$id = $request->id;
		$record = BasicPackage::get_basic_package($id);
		if ($record)
		{
			$now = Carbon::now();
			$data = ['redeem_state'=>0,'confirmed_at'=>$now,'reject_notes'=>$request->reason];		
			//no need to refund anything
			//Wallet::update_basic_wallet($record->member_id, 0,$record->used_point, 'RBP','credit', 'basic package rejected,point refund to customer');
			
			BasicPackage::update_basicpackage($record->id, $data);
			
			return response()->json(['success' => true, 'message' => 'success']);
		}
		else{
			return response()->json(['success' => false, 'message' => 'unknown package']);
		}	
	}
	
	public function get_basicpackage_quantity (Request $request)
	{
		$id     = $request->input('id');
		$record = BasicPackage::get_available_quantity($id);
		return response()->json(['success' => true, 'record' => $record]);
	}
	

	public function adjust_basicpackage_quantity (Request $request)
	{	
		
		$input = array();		
		parse_str($request->_data, $input);
		$data = array_map('trim', $input);
		
		$id = $data['tid'];
		
		$record = BasicPackage::find($id);
		if ($record)
		{
			$quantity = $record->available_quantity + $data['add_quantity'];
			BasicPackage::update_package($id, ['available_quantity'=>$quantity ]);			
			
			return response()->json(['success' => true,'quantity'=>$quantity]);
		}
		
		return response()->json(['success' => false, 'message' => 'unknown record']);		
	}
	
	
	public function backorder()
    {
		$data['page']    = 'basicpackage.backorder';
		$data['package'] = BasicPackage::where('package_status',1)->get(); 
		
		return view('main', $data);		
	}
	
	public function confirm_backorder(Request $request)
	{
		$insdata   = [];
		
		$validator = $this->validate($request, 
			[
				'package' => 'required',
				'phone'   => 'required|exists:members,phone',
			]
		);
		
		$member = \App\Members::where('phone',$request->phone)->first();
		
		$package = BasicPackage::where('id',$request->package)->first();
		
		if ($package)
		{
			$usedprice = $package->package_price; 		
			
			if ($request->discount_price)
			{
				$usedprice = $request->discount_price;
			}
			
			$passcode = unique_random('basic_redeemed','passcode',8);
			
			$now = Carbon::now();
			
			$data = ['package_id'=>$package->id,'created_at'=>$now,'updated_at'=>$now,'member_id'=>$member->id,'redeem_state'=>3,'confirmed_at'=>$now,'request_at'=>$now,'used_point'=>0,'package_life'=>$package->package_life,'package_point'=>$package->package_freepoint,'ref_note'=>'backorder','buy_price'=>$usedprice,'cardpass'=>$request->cardpass,'cardnum'=>$request->cardnum,'passcode'=>$passcode,'redeemed_at'=>$now,'created_by'=>\Auth::guard('admin')->user()->name];
			
			
			$wallet = Wallet::update_basic_wallet($member->id,$package->package_life,$package->package_freepoint,'BPR','credit','BackOrder');
			
			$id = BasicPackage::save_basic_package($data);
			
			$refdata = [ 'id'=>$id, 'refid'=>$wallet['refid'], 'type'=>'basicpackage' ];
			Wallet::add_ledger_ref($refdata);

			return response()->json(['success' => true, 'message' => 'success']);
			
						
		}
		else{
			return response()->json(['success' => false, 'message' => 'unknown product']);
		}	
	}
}

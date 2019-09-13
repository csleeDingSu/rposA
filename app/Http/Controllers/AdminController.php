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
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Auth;
use App\User;
use App\Admin;
use App\Members;
use App\redeemed;
use Carbon\Carbon;
use Jackiedo\DotenvEditor\Facades\DotenvEditor;
use Illuminate\Support\Arr;

class AdminController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
	
	protected $hidden = ['password', 'password_hash', 'age', 'created_at'];
	
	public function get_env(Request $request)
	{	
		$record  = DotenvEditor::getKeys(); // Get all keys		
		$data['protec']  = config('dotenv-editor.protected_key'); 		
		$data['page']    = 'env.list';
		$data['result']  = $record;
		return view('main', $data);
	}
	
	public function add_env_record(Request $request)
	{			
		$validator = $this->validate(
            $request,
            [
                'name'      => 'required|string',
                'env_value' => 'nullable',
            ]
        );
		
		$keys  = DotenvEditor::getKeys(); // Get all keys
		
		if (Arr::exists($keys, $request->name))
		{
			return response()->json(['success' => false,'errors'=>[ 'name'=>trans('dingu.key_exists') ] ],422);
		}		
		$file = DotenvEditor::setKey($request->name, $request->env_value, $request->comment); 
		$file = DotenvEditor::save();
		$render = '<tr class=""><td>new</td>
								<td>'.$request->name.'</td>
								<td>'.$request->env_value.'</td> </tr>';
		return response()->json(['success' => true,'record'=>$render]);
	}
	
	public function edit_env_record(Request $request)
	{			
		$keys  = DotenvEditor::getKeys(); 		
		if (!Arr::exists($keys, $request->name))
		{
			return response()->json(['success' => false,'errors'=>[ 'name'=>trans('dingu.unknown_key') ] ],422);
		}		
		$file = DotenvEditor::setKey($request->name, $request->value); 
		$file = DotenvEditor::save();
		return response()->json(['success' => true]);
	}
	
	public function delete_env_record(Request $request)
	{
		$keys = config('dotenv-editor.protected_key');
		$keys = array_flip($keys);		
		if (Arr::exists($keys, $request->name))
		{
			return response()->json(['success' => false,'errors'=>[ 'name'=>trans('dingu.cannot_delete_protected_key') ] ],422);
		}		
		$file = DotenvEditor::deleteKey($request->name);
		$file = DotenvEditor::save();		
		return response()->json(['success' => true,'record'=>$request->name]);
	}
	
	public function mytest ()
	{
		\DB::connection()->enableQueryLog();
		
		
		$someVariable = '3';
		$results = DB::select( DB::raw("SELECT * FROM members WHERE id = :somevariable"), array(
					   'somevariable' => $someVariable,
					 ));
		
		$result = DB::select( DB::raw("SELECT
	id,
	referred_by,
	username 
FROM
	( SELECT * FROM members ORDER BY referred_by, id ) child_sorted,
	( SELECT @pv := 3 ) initialisation 
WHERE
	find_in_set( referred_by, @pv ) 
	AND length( @pv := concat( @pv, ',', id ) )"));
		
		$result = DB::select("SELECT
	id,
	referred_by,
	username 
FROM
	( SELECT * FROM members ORDER BY referred_by, id ) child_sorted,
	( SELECT @pv := 3 ) initialisation 
WHERE
	find_in_set( referred_by, @pv ) 
	AND length( @pv := concat( @pv, ',', id ) )");
		
		
		
		$queries = DB::getQueryLog();
		$last_query = end($queries);
		print_r($last_query);echo '<br><br>';
		print_r($results);echo '<br><br>';
		print_r($result);
		die();
	}
	
	public function setting ()
	{
		$data['page']    = 'admin.setting';
		$data['record']  = Admin::get_setting();
		
		return view('main', $data);
	}
	
	public function update_setting (Request $request)
	{
		$data['page']    = 'admin.setting';
		
		
		$validator = $this->validate(
            $request,
            [
                'auto_maintenance' => 'sometimes',
      			'maintenance_start_time'  => 'required_with:auto_maintenance,on',
				'maintenance_end_time'    => 'required_with:auto_maintenance,on',
                'introduce_life' => 'required|integer|between:0,10',
				'game_default_life' => 'required|integer|between:0,10',
				'second_level_introduce_life' => 'required|integer|between:0,10',
				
				//'wabao_fee' => 'required|integer|between:0,1000',
            ]
        );
		
		

		
		// $data = ['allow_login'            	=> $request->allow_login,
		// 		 'allow_registration'     	=> $request->allow_registration,
		// 		 'site_maintenance'       	=> $request->site_maintenance,
		// 		 'maintenance_message'    	=> $request->maintenance_message,
		// 		 'auto_maintenance'       	=> $request->auto_maintenance,
		// 		 'maintenance_start_time' 	=> $request->maintenance_start_time,
		// 		 'maintenance_end_time'   	=> $request->maintenance_end_time,
  //                'introduce_life'         	=> $request->introduce_life,
		// 		 'game_default_life'      	=> $request->game_default_life,
		// 		 'mobile_default_image_url' => $request->mobile_default_image_url,
		// 		 'desktop_default_image_url'=> $request->desktop_default_image_url,
		// 		 'auto_product_redeem'      => $request->auto_product_redeem,
		// 		 'wabao_fee'     			=> $request->wabao_fee,
  //               ];

		$data = [
			'introduce_life'         	=> $request->introduce_life,
			'game_default_life'      	=> $request->game_default_life,
		 	'auto_product_redeem'      => $request->auto_product_redeem,
			'second_level_introduce_life'      => $request->second_level_introduce_life
			
                ];
		
		$id = $request->id;
		
		$res = Admin::update_setting($id,$data);
				
		return redirect()->back()->with('message', trans('dingsu.setting_success_save_message') );
		return view('main', $data);
	}
	
	
	public function index() {
		if (Auth::Guard('member')->check())
		{
			//redirect to member
			//return redirect()->route('/');
			return redirect('/profile');
		}
		else if (Auth::Guard('admin')->check())
		{
			if (Auth::user()->username == 'admin2') {

			return redirect()->route('ad.product.show');

			} else {
			//redirect to member list
			return redirect()->route('admindashboard');	
			}
			
		}
		else
		{
			return redirect()->route('adminlogin');
		}
	}
	/*
	public function dashboard ()
	{
		$data['page'] = 'admin.dashboard';

		$user = Auth::user();
		
		if (Auth::guard('admin')->check()){
		//	$user = Auth::user();
			$data['total_members'] = Members::count();
			$data['today_registration'] = Members::whereDate('created_at',Carbon::today())->count();
			$data['today_online'] = Members::whereNotNull('active_session')->count();
			$data['total_redeemed'] = redeemed::count();
		}
		//print_r($user);die();
		
		
		return view('main', $data);
	}
	
	*/
	public function userlist(Request $request)
	{
		$result =  DB::table('users');		
		
		$input = array();
		
		parse_str($request->_data, $input);
		$input = array_map('trim', $input);
		
    	if ($input) 
		{
			//filter
					
			if (!empty($input['s_username'])) {
				$result = $result->where('username','LIKE', "%{$input['username']}%") ;
				
			}
			
			if (isset($input['s_status'])) {
				if ($input['s_status'] != '' )
					$result = $result->where('user_status','=',$input['s_status']);
			}
		}
		
		//DB::enableQueryLog();
		
		$result =  $result->orderby('id','DESC')->paginate(30);
		
		//$queries = DB::getQueryLog();
		//print_r(DB::getQueryLog());
		//print_r($queries);
		
		
		//die();
		$data['page'] = 'admin.userlist'; 
				
		$data['result'] = $result; 
		
		//return view('purpleadmin.main', $data);
		
		 if ($request->ajax()) {
            return view('admin.ajaxlist', ['result' => $result])->render();  
        }
					
		return view('main', $data);
	}
	
	public function add_user ()
	{
		$data['page'] = 'admin.adduser';
		return view('main', $data);
	}
				
	public function create(Request $request)
	{		
		$validator = $this->validate(
            $request,
            [
                'firstname' => 'required|string|min:4',
                'email' => 'required|email|unique:users,email',
				'username' => 'required|unique:users,username',
            ]
        );
		
		try{
		    $member = new User();
			$member->name = $request->firstname;
			$member->username = $request->username;
			$member->email = $request->email;
			$member->password = Hash::make($request->password);
			$member->user_status = $request->status;
			$member->save();
		}
		catch(\Exception $e){
		   echo $e->getMessage();   
		}
		return redirect()->back()->with('message', trans('dingsu.user_account_success_message') );
		
		//@todo : add mail
		//self::sendmail($request->all());		
		
	}
	
	public function edit_user ($id = FALSE)
	{
		$data['user'] = $user = User::find($id);
		
		$data['page'] = 'common.error';
		
		if ($user)
		{
			$data['page'] = 'admin.edituser';
		}		
		
		return view('main', $data);
	}
	
	public function update($id,Request $request)
	{
		
		$validator = $this->validate(
            $request,
            [
                'firstname' => 'required|string|min:4',
				'email' => 'required|email|unique:users,email,'.$id,
            ]
        );
		$data = ['name' => $request->firstname,'email' => $request->email,'user_status' => $request->status];
		
		User::update_user($id, $data);
		
		return redirect()->back()->with('message', trans('dingsu.user_accountupdate_success_message') );
		
	}
	
	public function destroy ($id)
	{
		$user = User::find($id);
		
		if ($user)
		{
			User::destroy($id);
			return 'true';
		}
		return 'false';
	}
	
	public function change_password (Request $request)
	{
		$inputs = $request->input('datav');		
		$id     = $request->input('id');
		
		$record = User::find($id);
		
		foreach ($inputs as $key=>$val)
		{
			$data[$val['name']] = $val['value'];			
		}		
		
		$input = [            
		     'password'   => $data['password'],
			 'password_confirmation'   => $data['confirmpassword'],
              ];
		
		$validator = Validator::make($input, 
            [                
                'password' => 'required|alphaNum|min:5|max:50|confirmed',
            ]
        );
		
		if ($validator->fails()) {
			 return response()->json(['success' => false, 'message' => $validator->errors()->all()]);
		}
		else
		{			
			$data = [ 'password'=> Hash::make($data['password']) ];
			$res = User::update_user($record->id,$data);
			
			return response()->json(['success' => true]);
		}
	}
	
	public function update_password (Request $request)
	{
		$inputs = $request->input('datav');		
		
		$id = Auth::guard('admin')->user()->id;
		
		foreach ($inputs as $key=>$val)
		{
			$data[$val['name']] = $val['value'];			
		}		
		
		$input = [            
		     'password'   => $data['password'],
			 'password_confirmation'   => $data['confirmpassword'],
              ];
		
		$validator = Validator::make($input, 
            [                
                'password' => 'required|alphaNum|min:5|max:50|confirmed',
            ]
        );
		
		if ($validator->fails()) {
			 return response()->json(['success' => false, 'message' => $validator->errors()->all()]);
		}
		else
		{			
			$data = [ 'password'=> Hash::make($data['password']) ];
			$res = User::update_user($id,$data);
			
			return response()->json(['success' => true]);
		}
	}
	
	public function profile ()
	{
		$data['page']    = 'admin.profile';
		$data['user'] = Auth::guard('admin')->user();
		
		return view('main', $data);
	}
	
	public function update_profile(Request $request)
	{
		$id = Auth::guard('admin')->user()->id;
		$validator = $this->validate(
            $request,
            [
                'firstname' => 'required|string|min:4',
				'email' => 'required|email|unique:users,email,'.$id,
            ]
        );
		$data = ['name' => $request->firstname,'email' => $request->email,'user_status' => $request->status];
		
		User::update_user($id, $data);
		
		return redirect()->back()->with('message', trans('dingsu.user_accountupdate_success_message') );
		
	}
	
	public function getfaq(Request $request)
    {
		$id = $request->id;
		$record = Admin::get_faq($id);
		return response()->json(['success' => true, 'record' => $record]);
	}
	
	public function listfaq (Request $request)
	{
		
		//$data['record']  = Admin::get_faq();
		
		
		$result =  \DB::table('faq');
		$input = array();		
		parse_str($request->_data, $input);
		$input = array_map('trim', $input);
		
    	if ($input) 
		{
			//filter					
			if (!empty($input['s_title'])) {
				$result = $result->where('title','LIKE', "%{$input['s_title']}%") ;				
			}
		}
		
		$result =  $result->orderby('id','DESC')->paginate(30);
				
		$data['page']    = 'faq.list'; 	
				
		$data['result'] = $result; 
				
		if ($request->ajax()) {
            return view('faq.ajaxlist', ['result' => $result])->render();  
        }
					
		return view('main', $data);	
		
		
	}
	
	public function savefaq(Request $request)
    {
		
		$data = $request->_datav;
		
		foreach($data as $val)
		{
			
				$dbi[$val['name']] = $val['value'];
		
		}
		
		
		if ($dbi['mode'] =='edit')
		{
			return $this->updatefaq($dbi);
		}
		
		$input = [
					'title'   => $dbi['title'], 			 
					'content' => $dbi['content'],
					'seq'     => $dbi['seq'],
			  	 ];
		
		$validator = Validator::make($input, [
			'title'   => 'required|unique:faq,title',
			'content' => 'required',
			'seq'     => 'nullable|numeric|min:1|max:99|unique:faq,seq',
		]);
 
		
		
		if ($validator->fails()) {
			return response()->json(['success' => false, 'message' => $validator->errors()->all()]);
		}
		
		
		
		$now = Carbon::now();
		$data = ['seq' => $input['seq'],'title' => $input['title'],'content' => $input['content'],'created_at' => $now];
		
		$id = Admin::create_faq($data);
		
		
		$faq  = Admin::get_faq($id);
		$row  = '<tr id=tr_'.$faq->id.'>';
		$row .= "<td>$faq->id</td>";
		$row .= "<td>$now</td>";
		$row .= '<td>'.$faq->seq.'</td>';			
		$row .= '<td>'.$faq->title.'</td>';
		$row .= '<td>'.$faq->content.'</td>';
		$row .= '<td><a href="javascript:void(0)" data-id="'.$faq->id.'"  class="editfaq btn btn-icons btn-rounded btn-outline-info btn-inverse-info"><i class=" icon-pencil "></i></a>';
		$row .= '<a href="javascript:void(0)" onClick="confirm_Delete('.$faq->id.');return false;" class="btn btn-icons btn-rounded btn-outline-danger btn-inverse-danger"><i class=" icon-trash  "></i></a></td>';
		$row .= '</tr>';
		
		return response()->json(['success' => true, 'message' => trans('dingsu.softpin_update_success_message'),'record'=>$row]);
	}
	
	//for update faq from ajax
	public function updatefaq ($data)
	{
		$id = $data['hidden_void'];
		
		$input = [
					'title' => $data['title'], 
					'content'   => $data['content'],
					'seq'     => $data['seq'],
			  	 ];
		$validator = Validator::make($input, [
			 'title' => 'required|unique:faq,title,'.$id,
      		 'content'  => 'required',
      		 'seq'     => 'nullable|numeric|min:1|max:99|unique:faq,seq',
		]);
		if ($validator->fails()) {
			return response()->json(['success' => false, 'message' => $validator->errors()->all()]);
		}
		
		$insdata = ['seq' => $data['seq'],'title' => $data['title'],
				 'content' => $data['content'],];		
		
		$res = Admin::update_faq($id,$insdata);		
		return response()->json(['success' => true,'mode'=>'edit','dataval'=>$input]);
	}
	
	public function update_faq (Request $request)
	{
		$data['page']    = 'admin.setting';
		
		$id = $request->id;
		$validator = $this->validate(
            $request,
            [
                'title' => 'required',
      			'faq_content'  => 'required',
            ]
        );
		
		$data = ['seq' => $request->seq,'title' => $request->title,
				 'content' => $request->faq_content,];		
		
		$res = Admin::update_faq($id,$data);		
		
		
		return redirect()->back()->with('message', trans('dingsu.faq_success_save_message') );
		return view('main', $data);
	}
	
	public function delete_faq (Request $request)
	{
		$id = $request->id;
		Admin::delete_faq($id);
		return response()->json(['success' => true, 'message' => 'success']);
	}
	
	/**Tips**/
	public function gettips(Request $request)
    {
		$id = $request->id;
		$record = Admin::get_tips($id);
		return response()->json(['success' => true, 'record' => $record]);
	}	
	
	public function listtips (Request $request)
	{
				
		$result =  \DB::table('tips');
		$input = array();		
		parse_str($request->_data, $input);
		$input = array_map('trim', $input);
		
    	if ($input) 
		{
			//filter					
			if (!empty($input['s_title'])) {
				$result = $result->where('title','LIKE', "%{$input['s_title']}%") ;				
			}
			if (!empty($input['s_content'])) {
				$result = $result->where('content','LIKE', "%{$input['s_content']}%") ;				
			}
		}		
		$result =  $result->orderby('seq','ASC')->paginate(30);
				
		$data['page']    = 'tips.list'; 	
				
		$data['result'] = $result; 
				
		if ($request->ajax()) {
            return view('tips.ajaxlist', ['result' => $result])->render();  
        }
					
		return view('main', $data);	
	}
	
	public function savetips(Request $request)
    {
		
		$data = $request->_datav;
		
		foreach($data as $val)
		{
			$dbi[$val['name']] = $val['value'];		
		}		
		
		if ($dbi['mode'] =='edit')
		{
			return $this->updatetips($dbi);
		}		
		$input = [
					'title'   => $dbi['title'], 			 
					'content' => $dbi['content'],
					'seq'     => $dbi['seq'],
					'content' => $dbi['content'],
					'btn_txt' => $dbi['btn_txt'],
					'btn_url' => $dbi['btn_url'],
					'step'    => $dbi['step'],
			  	 ];
		
		$validator = Validator::make($input, [
			'title'   => 'required|unique:tips,title',
			'content' => 'required',
			'step'    => 'required',
			'seq'     => 'required|numeric|min:1|max:99|unique:tips,seq',
			'btn_txt' => 'required',
			'btn_url' => 'required|url',
		]);
		
		if ($validator->fails()) {
			return response()->json(['success' => false, 'message' => $validator->errors()->all()]);
		}		
		$now  = Carbon::now();
		$data = ['title' => $input['title'],'content' => $input['content'],'seq' => $input['seq'],'step' => $input['step'],'btn_txt' => $input['btn_txt'],'btn_url' => $input['btn_url'],'created_at' => $now];		
		$id = Admin::create_tips($data);		
		
		$tip  = Admin::get_tips($id);
		$row  = '<tr id=tr_'.$tip->id.'>';
		$row .= "<td>$tip->id</td>";
		$row .= "<td>$now</td>";
		$row .= '<td>'.$tip->step.'</td>';
		$row .= '<td id="st_'.$tip->id.'">'.$tip->title.'</td>';
		$row .= '<td id="sc_'.$tip->id.'">'.$tip->content.'</td>';
		$row .= '<td id="ss_'.$tip->id.'">'.$tip->seq.'</td>';
		$row .= '<td><a href="javascript:void(0)" data-id="'.$tip->id.'"  class="edittip btn btn-icons btn-rounded btn-outline-info btn-inverse-info"><i class=" icon-pencil "></i></a>';
		$row .= '<a href="javascript:void(0)" onClick="confirm_Delete('.$tip->id.');return false;" class="btn btn-icons btn-rounded btn-outline-danger btn-inverse-danger"><i class=" icon-trash  "></i></a></td>';
		$row .= '</tr>';		
		return response()->json(['success' => true, 'message' => trans('dingsu.tips_update_success_msg'),'record'=>$row]);
	}
	
	//for update tip from ajax
	public function updatetips ($data)
	{
		$id = $data['hidden_void'];		
		$input = [
					'title'   => $data['title'], 
					'content' => $data['content'],
					'seq'     => $data['seq'],
					'content' => $data['content'],
					'btn_txt' => $data['btn_txt'],
					'btn_url' => $data['btn_url'],
					'step'    => $data['step'],
			  	 ];
		$validator = Validator::make($input, [
			 'title'   => 'required|unique:tips,title,'.$id,
      		 'content' => 'required',
			 'step' => 'required',
			 'seq'     => 'required|numeric|min:1|max:99|unique:tips,seq,'.$id,
			 'btn_txt' => 'required',
			 'btn_url' => 'required|url',
		]);
		if ($validator->fails()) {
			return response()->json(['success' => false, 'message' => $validator->errors()->all()]);
		}
		
		$insdata = ['title'   => $data['title'],
				 	'content' => $data['content'],
					'seq'     => $data['seq'],
					'step'    => $data['step'],
					'btn_txt' => $data['btn_txt'],
					'btn_url' => $data['btn_url'],
				   ];		
		
		$res = Admin::update_tips($id,$insdata);		
		return response()->json(['success' => true,'mode'=>'edit','dataval'=>$input]);
	}
	
	
	public function update_tips (Request $request)
	{		
		$id = $request->id;
		$validator = $this->validate(
            $request,
            [
                'title'   => 'required',
      			'content' => 'required',
				'step'    => 'required',
				'seq'     => 'required|numeric|min:1|max:99|unique:tips,seq,'.$id,
				'btn_txt' => 'required',
				'btn_url' => 'required|url',
            ]
        );		
		$data = ['title'   => $request->title,
				 'content' => $request->tips_content,
				 'seq'     => $request->seq,
				 'step'    => $request->seq,
				 'btn_txt' => $request->btn_txt,
				 'btn_url' => $request->btn_url,];		
		
		$res = Admin::update_tips($id,$data);		
		if ($request->ajax()) {
            return response()->json(['success' => true]); 
        }
		
		return redirect()->back()->with('message', trans('dingsu.tips_success_save_message') );
		return view('main', $data);
	}
	
	public function delete_tips (Request $request)
	{
		$id = $request->id;
		Admin::delete_tips($id);
		return response()->json(['success' => true, 'message' => 'success']);
	}
	/**Tips END**/
	
	/**Banner**/
	public function getbanner(Request $request)
    {
		$id = $request->id;
		$record = Admin::get_banner($id);
		return response()->json(['success' => true, 'record' => $record]);
	}
	
	
	public function listbanner (Request $request)
	{
				
		$result =  \DB::table('banner');
		$input = array();		
		parse_str($request->_data, $input);
		$input = array_map('trim', $input);
		
    	if ($input) 
		{
			//filter	
			if (!empty($input['s_status'])) {
				$result = $result->where('is_status','=', "{$input['s_status']}") ;				
			}
		}
		
		$result =  $result->orderby('id','ASC')->paginate(30);
				
		$data['page']    = 'banner.list'; 	
				
		$data['result'] = $result; 
				
		if ($request->ajax()) {
            return view('banner.ajaxlist', ['result' => $result])->render();  
        }
					
		return view('main', $data);	
		
		
	}
	
	public function savebanner(Request $request)
    {
		$imagename = '';
		if ($request->mode == 'edit')
		{
			return $this->updatebanner($request);
		}
		
		$input = [
					'status'       => $request->status, 			 
					'banner_image' => $request->banner_image,
					'banner_url'   => $request->banner_url,
			  	 ];
		
		$validator = Validator::make($input, [			
			'banner_image' => 'required_without:banner_url|image|nullable|mimes:jpeg,jpg,png,jpg,gif,svg|max:2048',
			'status'       => 'required',
			'banner_url'   => 'required_without:banner_image',
		]);
		
		if ($validator->fails()) {
			return response()->json(['success' => false, 'message' => $validator->errors()->all()]);
		}
		
		$now = Carbon::now();
		$image = $request->file('banner_image');
        
		if ($image)
		{
			$imagename = time().'.'.$image->getClientOriginalExtension();
        	$destinationPath = public_path('banner');
        	$image->move($destinationPath, $imagename);
		}
        		
		
		$data = ['banner_image' => $imagename,'is_status' => $input['status'],'created_at' => $now,'banner_url' => $input['banner_url']];
		
		$badge = '';
		$id = Admin::create_banner($data);
		
		$bnr  = Admin::get_banner($id);
		$row  = '<tr id=tr_'.$bnr->id.'>';
		$row .= "<td>$bnr->id</td>";
		$row .= "<td>$now</td>";
		switch ($bnr->is_status)
			{
				case '1':
					$badge = "<label class='badge badge-success'>".trans('dingsu.active')."</label> ";
				break;
				case '2':
					$badge = "<label class='badge badge-warning'>".trans('dingsu.inactive')."</label> ";
				break;				
					
			}
		$row .= "<td>$badge</td>";
		$row .= '<td id="ss_'.$bnr->id.'"><img style="width: 200px !important;height: 200px !important" width="300px" height="200px" class="img-md  mb-4 mb-md-0 d-block mx-md-auto" src="/banner/'.$bnr->banner_image.'" alt="image"></td>';
		$row .= '<td><a href="javascript:void(0)" data-id="'.$bnr->id.'"  class="editbanner btn btn-icons btn-rounded btn-outline-info btn-inverse-info"><i class=" icon-pencil "></i></a>';
		$row .= '<a href="javascript:void(0)" onClick="confirm_Delete('.$bnr->id.');return false;" class="btn btn-icons btn-rounded btn-outline-danger btn-inverse-danger"><i class=" icon-trash  "></i></a></td>';
		$row .= '</tr>';
		
		return response()->json(['success' => true, 'message' => trans('dingsu.banner_update_success_msg'),'record'=>$row]);
	}
	
	//for update banner from ajax
	public function updatebanner ($data)
	{
		$id = $data->hidden_void;
		
		$input = [
					'status'   => $data->status, 			 
					'banner_image' =>$data->banner_image,
					'banner_new_picture' =>$data->banner_new_picture,
					'banner_url' =>$data->banner_url,
			  	 ];
		$validator = Validator::make($input, [
			 'banner_image' => 'required_without:banner_url|image|nullable|mimes:jpeg,jpg,png,jpg,gif,svg|max:2048',
			 'status'       => 'required',
			 'banner_url'   => 'required_without:banner_image',
		]);
		if ($validator->fails()) {
			return response()->json(['success' => false, 'message' => $validator->errors()->all()]);
		}
		$imagename = '';
		$now = Carbon::now();
		if ($data->banner_image)
		{
			$image = $data->file('banner_image');
			$imagename = time().'.'.$image->getClientOriginalExtension();
			$destinationPath = public_path('banner');
			$image->move($destinationPath, $imagename);
			$insdata['banner_image'] = $imagename;
		}
		
		$insdata['is_status']  = $data->status;
		$insdata['banner_url'] = $data->banner_url;
				
		$res = Admin::update_banner($id,$insdata);		
		return response()->json(['success' => true,'mode'=>'edit','dataval'=>$insdata]);
	}

	
	public function delete_banner (Request $request)
	{
		$id = $request->id;
		Admin::delete_banner($id);
		return response()->json(['success' => true, 'message' => 'success']);
	}
	
	public function delete_banner_image(Request $request)
    {
		$id = $request->id;
		$data = ['banner_image' => ''];
		Admin::update_banner($id, $data);		
		return response()->json(['success' => true, 'message' => 'done']);
	}
	/**Banner END**/
	
	
	/**Game Redeem Condition**/
	public function get_redeem_condition(Request $request)
    {
		$id = $request->id;
		$record = Admin::get_redeem_condition($id);
		return response()->json(['success' => true, 'record' => $record]);
	}	
	
	public function listredeem_condition (Request $request)
	{				
		$result =  \DB::table('redeem_condition');
		$input = array();		
		parse_str($request->_data, $input);
		$input = array_map('trim', $input);		
    			
		$result =  $result->orderby('position','ASC')->paginate(30);
				
		$data['page']    = 'redeem.list'; 	
				
		$data['result'] = $result; 
				
		if ($request->ajax()) {
            return view('redeem.ajaxlist', ['result' => $result])->render();  
        }					
		return view('main', $data);	
	}
	
	public function saveredeem_condition(Request $request)
    {		
		$data = $request->_datav;
		
		foreach($data as $val)
		{			
			$dbi[$val['name']] = $val['value'];		
		}
				
		if ($dbi['mode'] =='edit')
		{
			return $this->updateredeem_condition($dbi);
		}
		
		$input = [
					'position'     => $dbi['seq'],
					'minimum_point' => $dbi['min_point'],
					'description' => $dbi['description']
			  	 ];
		
		$validator = Validator::make($input, [			
			'minimum_point'    => 'required|numeric|min:1|max:9999',
			'position'     => 'required|numeric|min:1|max:99|unique:redeem_condition,position',
		]);
		
		if ($validator->fails()) {
			return response()->json(['success' => false, 'message' => $validator->errors()->all()]);
		}
		
		$now  = Carbon::now();
		$data = ['position' => $input['position'],'minimum_point' => $input['minimum_point'],'description' => $input['description'],'created_at' => $now];
		
		$id = Admin::create_redeem_condition($data);
				
		$tip  = Admin::get_redeem_condition($id);
		$row  = '<tr id=tr_'.$tip->id.'>';
		$row .= '<td>'.$tip->id.'</td>';
		$row .= '<td id="sp_'.$tip->id.'">'.$tip->position.'</td>';
		$row .= '<td id="sm_'.$tip->id.'">'.$tip->minimum_point.'</td>';
		$row .= '<td id="sd_'.$tip->id.'">'.$tip->description.'</td>';
		$row .= '<td><a href="javascript:void(0)" data-id="'.$tip->id.'"  class="editrecord btn btn-icons btn-rounded btn-outline-info btn-inverse-info"><i class=" icon-pencil "></i></a>';
		$row .= '<a href="javascript:void(0)" onClick="confirm_Delete('.$tip->id.');return false;" class="btn btn-icons btn-rounded btn-outline-danger btn-inverse-danger"><i class=" icon-trash  "></i></a></td>';
		$row .= '</tr>';
		
		return response()->json(['success' => true, 'message' => trans('dingsu.tips_update_success_msg'),'record'=>$row]);
	}
	
	//for update tip from ajax
	public function updateredeem_condition ($data)
	{
		$id = $data['hidden_void'];
		
		$input = [			
					'position'      => $data['seq'],
					'minimum_point' => $data['min_point'],
					'description'   => $data['description']
			  	 ];
		$validator = Validator::make($input, [
			 'position'       => 'required|numeric|min:1|max:99|unique:redeem_condition,position,'.$id,
			 'minimum_point'  => 'required|numeric|min:1|max:9999',
		]);
		if ($validator->fails()) {
			return response()->json(['success' => false, 'message' => $validator->errors()->all()]);
		}	
		
		$res = Admin::update_redeem_condition($id,$input);		
		return response()->json(['success' => true,'mode'=>'edit','dataval'=>$input]);
	}
		
	public function delete_redeem_condition (Request $request)
	{
		$id = $request->id;
		Admin::delete_redeem_condition($id);
		return response()->json(['success' => true, 'message' => 'success']);
	}
	
	/**Game Redeem Condition END**/
	
	
	
	/**Cron manager**/
	public function get_cron(Request $request)
    {
		$id = $request->id;
		$record = \DB::table('cron_manager')->where('id',$id)->first();
		return response()->json(['success' => true, 'record' => $record]);
	}	
	
	public function cronlist (Request $request)
	{				
		$result =  \DB::table('cron_manager');
		$input = array();		
		parse_str($request->_data, $input);
		$input = array_map('trim', $input);
		
		$result =  $result->paginate(30);
				
		$data['page']    = 'cronmanager.list'; 	
				
		$data['result'] = $result; 
				
		if ($request->ajax()) {
            return view('cronmanager.ajaxlist', ['result' => $result])->render();  
        }					
		return view('main', $data);	
	}
	
	
	public function edit_cron (Request $request)
	{		
		$data = $request->_datav;		
		foreach($data as $val)
		{	
			$dbi[$val['name']] = $val['value'];		
		}		
		
		$id = $dbi['hidden_void'];
		
		$input = [	'status'      => $dbi['model_status']	 ];
		$validator = Validator::make($input, [
			 'status'  => 'required',
		]);
		if ($validator->fails()) {
			return response()->json(['success' => false, 'message' => $validator->errors()->all()]);
		}	
		
		//DB::table('cron_manager')
            //	->where('id', $id)
            //	->update($input);
		
		$badge = '';
		
		$dbi['model_status'] = \App\CronManager::cron($id,$dbi['model_status']);
		
		switch ( $dbi['model_status'] )
			{
				case '1':
					$badge = "<label class='badge badge-success'>".trans('dingsu.active')."</label> ";
				break;
				case '2':
					$badge = "<label class='badge badge-info'>".trans('dingsu.onhold')."</label> ";
				break;	
				case '3':
					$badge = "<label class='badge badge-danger'>".trans('dingsu.suspended')."</label> ";
				break;
				case '4':
					$badge = "<label class='badge badge-warning'>".trans('dingsu.restart')."</label> ";
				break;
				case '99':
					$badge = "<label class='badge badge-warning'>".trans('dingsu.not_updated')."</label> ";
				break;					
			}
		$input['status'] = $badge ;
		
		return response()->json(['success' => true,'mode'=>'edit','dataval'=>$input]);
	}
	
	public function receipt_list (Request $request)
	{
		$input = array();		
		parse_str($request->_data, $input);
		$input = array_map('trim', $input);		
		$result = \App\Receipt::with('member','reason');
										 
		if ($input)
		{
			if (!empty($input['s_receipt'])) { 
				$result = $result->where('receipt','LIKE', "%{$input['s_receipt']}%") ;
			}
			if (!empty($input['s_status'])) { 
				$result = $result->where('status',$input['s_status']) ;
			}
			if (!empty($input['s_member'])) {
				$result = $result->where('members.phone','LIKE', "%{$input['s_member']}%")->orwhere('wechat_name' , 'LIKE', "%{$input['s_member']}%") ;
			}
			if (!empty($input['reason_id']))  {
					$result = $result->where('id', $input['reason_id']) ;
			}
		}
		
		$result =  $result->orderby('id','DESC')->paginate(30);				
		 				
		if ($request->ajax()) {
            return view('receipt.ajaxlist', ['result' => $result])->render();  
        }
		$data['page']    = 'receipt.list'; 				
		$data['result']  = $result;		
		return view('main', $data);	
	}
	
	public function receipt_get(Request $request)
    {
    	$record    = \App\Receipt::where('id',$request->id)->first();	
		$reason    = \DB::table('receipt_reason')->get();
		$record    =  view('receipt.render_edit', ['result' => $record , 'id'=>$record->id , 'reason'=>$reason]) ->render();
		return response()->json(['success' => true,'id'=>$request->id,'record'=>$record]);	
    }
	
	public function receipt_update(Request $request)
    {
    	$record    = \App\Receipt::where('id',$request->id)->first(); 		
		if ($record->status != 1)
		{
			return response()->json(['success' => false, 'errors' => trans('lang.record_already_settled') ]); 
		}		
		$record->status     = $request->status;	
		$record->amount     = $request->amount;	
		$record->reason_id  = $request->reason_id;	
		$record->remark     = $request->remark;			
		$record->save();
		$row = $this->render_receiptdata($request->id);
		return response()->json(['success' => true,'id'=>$request->id,'record'=>$row]);
    }
	
	public function render_receiptdata($id)
    {
    	$record    = \App\Receipt::with('reason')->where('id',$id)->get();		
		$record    =  view('receipt.render_data', ['result' => $record])->render();						
		return $record;
    }
		
	public function receipt_get_to_module(Request $request)
    {
		$table = '';
		switch($request->module)
		{
			case 'buyproduct':
				$table = 'view_buy_product_user_list';		
			break;
			case 'product':
				$table = 'redeemed';	
			break;
			case 'basicpackage':				
				$table = 'view_basic_package_user_list';		
			break;
			case 'package':
				$table = 'vip_redeemed';		
			break;
		}
		
		if (!$table)
		{
			return response()->json(['success' => false,'message'=>'unknown module']); 
		}
		
		$result  =  \DB::table($table)->where('id', $request->id)->first();	
		$record  =  view('receipt.render_update', ['result' => $result , 'id'=>$request->id , 'module'=>$request->module ])->render();						
		return response()->json(['success' => true,'id'=>$request->id,'record'=>$record]); 
	}
	
	public function receipt_update_to_module(Request $request)
    {
		$table = '';
		if (!$request->receipt)
		{
			return response()->json(['success' => false,'message'=>'no receipt to update']); 
		}
		switch($request->module)
		{
			case 'buyproduct':
				$table =  'buy_product_redeemed';		
			break;
			case 'product':
				$table =  'redeemed';		
			break;
			case 'basicpackage':
				$table =  'basic_redeemed';		
			break;	
			case 'package':
				$table =  'vip_redeemed';		
			break;					
		}
		
		if (!$table)
		{
			return response()->json(['success' => false,'message'=>'unknown module']); 
		}
		
		\DB::table($table)
            	->where('id', $request->id)
            	->update(['receipt'=>$request->receipt]);
		
		$record = $this->receipt_get_to_module($request);
		return response()->json(['success' => true,'id'=>$request->id,'record'=>$request->receipt]); 
	}
	
}

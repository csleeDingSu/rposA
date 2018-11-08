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

class AdminController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
	
	protected $hidden = ['password', 'password_hash', 'age', 'created_at'];
	
	
	
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
            ]
        );
		
		

		
		$data = ['allow_login' => $request->allow_login,
				 'allow_registration' => $request->allow_registration,
				 'site_maintenance' => $request->site_maintenance,
				 'maintenance_message' => $request->maintenance_message,
				 'auto_maintenance' => $request->auto_maintenance,
				 'maintenance_start_time' => $request->maintenance_start_time,
				 'maintenance_end_time' => $request->maintenance_end_time,];
		
		
		$res = Admin::update_setting(1,$data);
		
		
		
		return redirect()->back()->with('message', trans('dingsu.setting_success_save_message') );
		return view('main', $data);
	}
	
	
	public function index() {
		if (Auth::Guard('member')->check())
		{
			//redirect to member
			return redirect()->route('/');
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
			  	 ];
		
		$validator = Validator::make($input, [
			'title'   => 'required|unique:faq,title',
			'content' => 'required',
		]);
 
		
		
		if ($validator->fails()) {
			return response()->json(['success' => false, 'message' => $validator->errors()->all()]);
		}
		
		
		
		$now = Carbon::now();
		$data = ['title' => $input['title'],'content' => $input['content'],'created_at' => $now];
		
		$id = Admin::create_faq($data);
		
		
		$faq  = Admin::get_faq($id);
		$row  = '<tr id=tr_'.$faq->id.'>';
		$row .= "<td>$faq->id</td>";
		$row .= "<td>$now</td>";			
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
			  	 ];
		$validator = Validator::make($input, [
			 'title' => 'required|unique:faq,title,'.$id,
      		 'content'  => 'required',
		]);
		if ($validator->fails()) {
			return response()->json(['success' => false, 'message' => $validator->errors()->all()]);
		}
		
		$insdata = ['title' => $data['title'],
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
		
		$data = ['title' => $request->title,
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
	
	
}

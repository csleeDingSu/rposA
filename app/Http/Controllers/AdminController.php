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
                'introduce_life' => 'required|integer|between:0,10',
                'game_default_life' => 'required|integer|between:0,10',
            ]
        );
		
		

		
		$data = ['allow_login'            => $request->allow_login,
				 'allow_registration'     => $request->allow_registration,
				 'site_maintenance'       => $request->site_maintenance,
				 'maintenance_message'    => $request->maintenance_message,
				 'auto_maintenance'       => $request->auto_maintenance,
				 'maintenance_start_time' => $request->maintenance_start_time,
				 'maintenance_end_time'   => $request->maintenance_end_time,
                 'introduce_life'         => $request->introduce_life,
                 'game_default_life'      => $request->game_default_life,
                ];
		
		
		$res = Admin::update_setting(1,$data);
		
		
		
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
		if ($request->mode == 'edit')
		{
			return $this->updatebanner($request);
		}
		
		$input = [
					'status'   => $request->status, 			 
					'banner_image' =>$request->banner_image,
			  	 ];
		
		$validator = Validator::make($input, [			
			'banner_image' => 'required|image|mimes:jpeg,jpg,png,jpg,gif,svg|max:2048',
			'status' => 'required',
		]);
		
		if ($validator->fails()) {
			return response()->json(['success' => false, 'message' => $validator->errors()->all()]);
		}
		
		$now = Carbon::now();
		$image = $request->file('banner_image');
        $imagename = time().'.'.$image->getClientOriginalExtension();
        $destinationPath = public_path('ad/banner');
        $image->move($destinationPath, $imagename);		
		
		$data = ['banner_image' => $imagename,'is_status' => $input['status'],'created_at' => $now];
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
		$row .= '<td id="ss_'.$bnr->id.'"><img style="width: 200px !important;height: 200px !important" width="300px" height="200px" class="img-md  mb-4 mb-md-0 d-block mx-md-auto" src="/ad/banner/'.$bnr->banner_image.'" alt="image"></td>';
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
			  	 ];
		$validator = Validator::make($input, [
			 'banner_image' => 'nullable|image|mimes:jpeg,jpg,png,jpg,gif,svg|max:2048',
			 'status' => 'required',
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
			$destinationPath = public_path('ad/banner');
			$image->move($destinationPath, $imagename);
			$insdata['banner_image'] = $imagename;
		}
		
		$insdata['is_status'] = $data->status;
				
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
}

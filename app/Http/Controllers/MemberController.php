<?php
/***
 *
 *
 ***/
namespace App\Http\Controllers;


use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

use DB;
use App;
use Auth;
use session;
use App\Wallet;

use App\Members as Member;

class MemberController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
	public function __construction()
	{
		$this->middleware('auth:admin');
	}
	public function index() {		
		
		if (Auth::Guard('member')->check())
		{
			$this->member_profile();
			//return redirect('/profile');
			//return redirect()->route('/profile'); //change to homepage
		}
		else if (Auth::Guard('admin')->check())
		{
			$this->member_list();
			//redirect to member list
			//return redirect()->route('memberlist');
		}
		else
		{
			//echo 'here';
			return redirect()->route('login');
		}		
	}
	
	public function dashboard() {
		return $this->member_list();
	}
	public function member_list()
	{
		
		$result =  DB::table('view_members')->select(['id', 'created_at','email','credit_balance','firstname','lastname', 'username','member_status','wechat_name','wechat_verification_status','parent','wechat_notes'])->paginate(25);		
				
		$data['page'] = 'member.memberlist'; 
				
		$data['result'] = $result; 
		
		//return view('purpleadmin.main', $data);
					
		return view('main', $data);
	}
	
	public function add_member ()
	{
		$data['page'] = 'member.addmember';
		return view('main', $data);
	}
				
	public function save_member(Request $request)
	{		
		$validator = $this->validate(
            $request,
            [
                'firstname' => 'required|string|min:4',
                'email' => 'required|email|unique:members,email',
				'username' => 'required|unique:members,username',
            ]
        );
		
		try{
		    $member = new Member();
			$member->firstname = $request->firstname;
			$member->lastname = $request->lastname;
			$member->username = $request->username;
			$member->email = $request->email;
			$member->password = Hash::make($request->password);
			$member->member_status = $request->status;
			$member->withdrawal_password = $request->w_password;			
			$member->affiliate_id = unique_random('members', 'affiliate_id', 10);
			$member->save();
		}
		catch(\Exception $e){
		   echo $e->getMessage();   
		}
		return redirect()->back()->with('message', trans('dingsu.member_account_success_message') );
		
		//@todo : add mail
		//self::sendmail($request->all());		
		
	}
	
	public function edit_member ($id = FALSE)
	{
		$data['member'] = $member = Member::get_member($id);
		
		$data['page'] = 'common.error';
		
		if ($member)
		{
			$data['page'] = 'member.editmember';
		}		
		
		return view('main', $data);
	}
	
	public function update_member($id,Request $request)
	{
		
		$validator = $this->validate(
            $request,
            [
                'firstname' => 'required|string|min:4',
				'email' => 'required|email|unique:members,email,'.$id,
				'wechat_name' => 'nullable|unique:members,wechat_name,'.$id,
				'phone' => 'nullable|min:7|max:12|unique:members,phone,'.$id,
            ]
        );
		$data = ['firstname' => $request->firstname,'lastname' => $request->lastname,'email' => $request->email,'member_status' => $request->status,'wechat_name' => $request->wechat_name,'wechat_verification_status' => $request->wechat_verification_status,'phone' => $request->phone];
		
		Member::update_member($id, $data);
		
		return redirect()->back()->with('message', trans('dingsu.member_accountupdate_success_message') );
		
	}
	
	public function delete_member ($id)
	{
		$member = Member::find($id);
		
		if ($member)
		{
			//@todo : check user bidding information & referral commision
			Member::destroy($id);
			return 'true';
		}
		return 'false';
	}
	
	public function list_pending_wechat_account ()
	{
		$result = Member::get_pending_wechat_members(20);
		
		$data['page'] = 'member.pendingwechat';  		
		$data['result'] = $result;
		
		return view('main', $data);
	}
	
	public function reject_wechat_verification (Request $request)
	{
		$id = $request->id;
		$notes = $request->notes;
		
		$input = [
			 'notes'   => $notes
			  ];
		$validator = Validator::make($input, 
			[
				'notes' => 'required'
			]
		);
		if ($validator->fails()) {
			 return response()->json(['success' => false, 'message' => $validator->errors()->all()]);
		}	
		else
		{
			$data = ['wechat_verification_status'=>2,'wechat_notes'=>$notes];
			$res = Member::update_member($id,$data);
		}
		return response()->json(['success' => true]);
	}
	
	//prem
	public function verify_wechat_account (Request $request)
	{
		$data = $request->_data;
		
		foreach($data as $val)
		{
			$dbi[$val['name']] = $val['value'];		
		}
		
		$id     = $dbi['hidden_void'];
		$status = $dbi['model_wechat_status'];
		$wechat = $dbi['model_wechat_name'];
		
		$record = Member::find($id);
		if ($record)
		{
			//$wechat = $record->wechat_name
			
			$input = [
				 'wechat_name'   => $wechat,
				 'notes'         => $dbi['notes']
				  ];			
			
			$validator = Validator::make($input, 
				[
					'wechat_name' => 'required|unique:members,wechat_name,'.$id,
					'notes' => 'required'
				]
			);
			
						
			
			if ($validator->fails()) {
				return response()->json(['success' => false, 'message' => $validator->errors()->all()]);
			}	
			else
			{
				$data = ['wechat_name'=> $wechat,'wechat_verification_status'=>$status,'wechat_notes'=>$dbi['notes']];
				$res = Member::update_member($record->id,$data);
			}	
			
			switch ($status)
			{
				case '1':
					$badge = "<label class='badge badge-info'>".trans('dingsu.unverified')."</label> ";
				break;
				case '2':
					$badge = "<label class='badge badge-warning'>".trans('dingsu.rejected')."</label> ";
				break;
				case '3':
					$badge = "<label class='badge badge-danger'>".trans('dingsu.suspended')."</label> ";
				break;
				default:
					$badge = "<label class='badge badge-success'>".trans('dingsu.verified')."</label> ";
				break;
					
			}
			
			return response()->json(['success' => true,'wechat_name'=>$wechat,'wechat_status'=>$status,'badge'=>$badge]);
		}		
		return response()->json(['success' => false]);
	}
	
	public function change_status (Request $request)
	{
		$id     = $request->id;
		$status = $request->status;
		
		$record = Member::find($id);
		if ($record)
		{
			$data = ['member_status'=> $status];
			$res = Member::update_member($record->id,$data);
			
			
			switch ($status)
			{
				case '1':
					$badge = "<label class='badge badge-danger'>".trans('dingsu.inactive')."</label> ";
				break;
				case '2':
					$badge = "<label class='badge badge-warning'>".trans('dingsu.suspended')."</label> ";
				break;
				default:
					$badge = "<label class='badge badge-success'>".trans('dingsu.active')."</label> ";
				break;
					
			}
			
			return response()->json(['success' => true,'memberstatus'=>$status,'badge'=>$badge]);
			
			
		}
		return response()->json(['success' => false,'message'=>['unknown user']  ]);
	}
	
	public function change_password (Request $request)
	{
		$inputs = $request->input('datav');		
		$id     = $request->input('id');
		
		$record = Member::find($id);
		
		
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
			$res = Member::update_member($record->id,$data);
			
			return response()->json(['success' => true]);
		}
	}
	
	public function reset_password ()
	{
		
	}
	
	
	
	public function verify_wechat ()
	{
		
	}
	
	public function check_member_verification ()
	{
		
	}
	
	public function credit_details ($member = FALSE)
	{
		
	}
	
	public function generate_referal_key ()
	{
		
	}
	
	public function view_toplevel_members ()
	{
		
	}
	
	public function view_downlevel_members ()
	{
		
	}
	
	public function request_withdrawal ()
	{
		
	}
	
	
	public function member_profile()
	{
		$member = Auth::guard('member')->user()->id	;
		$data['member'] = Member::get_member($member);
		
		$data['wallet'] = Wallet::get_wallet_details($member);
		$data['page'] = 'client.member'; 
			return response()->json(['success' => true]);		
		return view('main', $data);
		return view('client.member', $data);
	}
	
	public function today_transaction()
	{
		
	}
	
	public function transaction_history()
	{
		
	}
	
	public function payment_history()
	{
		
	}
	
}

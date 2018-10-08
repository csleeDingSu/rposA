<?php
/***
 *
 *
 ***/

namespace App\Http\Controllers;
use App;
use App\Helpers\QRCodeGenerator;
use App\MainLedger;
use App\Member;
use Auth;
use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use session;
class MemberController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
	public function __construction()
	{
		//$this->middleware('member');
		//$this->middleware('auth:member');
		$this->middleware('auth:admin');
	}
	public function index() {		
		
		print_r(Auth::Guard('member')->check());

		if (Auth::Guard('member')->check())
		{
			//redirect to member
			$member = Auth::Guard('member')->user();
			$mainledger = MainLedger::where('member_id',$member->id)->first();
			$member['current_balance'] = $member['pending'] = $member['success']=$member['history']= 0;
			$member['invitation_link'] = url('/') . "/register/$member->affiliate_id";
			//$member['qrcode'] = QRCodeGenerator::generate('url',array('url' => $member['invitation_link']));

			if (count($mainledger)>0) {

				$member['current_balance'] = $mainledger->current_balance;
				$member['pending'] = 6;
				$member['success'] = 20;
				$member['history'] = 100;

			}
			
			return view('client/member', compact('member'));
			//return redirect()->route('memberdashboard'); //change to homepage
		}
		else if (Auth::Guard('admin')->check())
		{
			//redirect to member list
			return redirect()->route('memberlist');
		}
		else
		{
			return redirect()->route('login');
		}		
	}
	
	public function dashboard() {
		return $this->member_list();
	}
	public function member_list()
	{
		
		$result =  DB::table('members')->select(['id', 'created_at','email','credit_balance','firstname','lastname', 'username','member_status'])->paginate(25);		
		//die();
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
            ],
            [
                'firstname.required' => 'Firstname is required',
                'email.required' => 'Email is required',
				'username.required' => 'Username is required',
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
		
		//print_r($member);die();
		
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
            ]
        );
		
		 //Member::where('id', '=', $id)->update(array('firstname' => $request->firstname,'lastname' => $request->lastname));
		
		try{
		    $member = new Member();
			$member->firstname     = $request->firstname;
			$member->lastname      = $request->lastname;
			$member->email         = $request->email;
			$member->member_status = $request->status;
			$member->account_type  = '';
			$member->update_member($id);
		}
		catch(\Exception $e){
		   echo $e->getMessage();   
		}
		
		
		//return redirect()->back()->with('message', trans('dingsu.member_accountupdate_success_message') );
		
	}
	
	public function delete_member ($id)
	{
		//$member = Member::findOrFail($id);
		$member = Member::find($id);
		
		if ($member)
		{
			//@todo : check user bidding information & referral commision
			//Member::destroy($id);
			return 'true';
		}
		return 'false';
	}
	
	public function reset_password ()
	{
		
	}
	
	public function change_password ()
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

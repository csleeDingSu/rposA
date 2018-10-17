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

use App\Voucher;


class ClientController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
	
	public function __construction()
	{
		$this->middleware('auth:member');
	}
	public function index() {		
		
		if (Auth::Guard('member')->check())
		{
			return redirect('/profile');
		}
		else if (Auth::Guard('admin')->check())
		{
			//return redirect('/member/list');
			//redirect to member list
			return redirect()->route('memberlist');
		}
		else
		{
			//echo 'here';
			return redirect()->route('login');
		}		
	}
	
	
	
	public function member_profile()
	{
		
		$member = Auth::guard('member')->user()->id	;
		$data['member'] = Member::get_member($member);
		
		//$data['wallet'] = Wallet::get_wallet_details_all($member);
		$data['page'] = 'client.member'; 
		return view('client/member', $data);
	}
	
	
}

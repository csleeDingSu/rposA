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
use App\tips;

use App\Http\Controllers\Api\MemberController;

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
		if (Auth::Guard('member')->check()) {

			$member = Auth::guard('member')->user()->id	;
			$data['member'] = Member::get_member($member);
			
			$data['wallet'] = Wallet::get_wallet_details_all($member);
			$data['page'] = 'client.member'; 
			return view('client/member', $data);

		} else {

			return redirect()->route('login');
		}		
		
	}

	public function member_access_game()
	{
		if (!Auth::Guard('member')->check())
		{
			$msg = trans('dingsu.please_login');
			\Session::flash('success',$msg);

			return redirect('/login');

		} else {

			$member = Auth::guard('member')->user()->id	;
			$data['member'] = Member::get_member($member);

			if (is_null($data['member']->wechat_name)) {

				//return redirect('/verify');

			}

		}

		return view('client/game');

	}

	public function member_update_wechatname(Request $request)
	{
		$memberid = $request->input('memberid');
		$wechat_name = $request->input('wechat_name');

		if (!Auth::Guard('member')->check())
		{
			$msg = trans('dingsu.please_login');
			\Session::flash('success',$msg);

			return redirect('/login');

		} else {

			if (is_null($wechat_name)) {

				$msg = trans('dingsu.please_fill_wechatid');
				\Session::flash('warning',$msg);

				return redirect('/arcade');

			} else {

				$m = new MemberController;

				$res = $m->update_wechat($request);

				if ($res) {

					// $msg = trans('dingsu.success_update_wechatid');
					// \Session::flash('success',$msg);

					return redirect('/arcade');

				} else {

					// $msg = trans('dingsu.please_fill_wechatid');
					// \Session::flash('success',$msg);

					return redirect('/arcade');


				}



			}

		}

	}
	
	public function member_referral_list(Request $request)
	{
		$id = $request->id;
		$result =  Member::get_member_referral_list($id);
		
		print_r($result);
	}

	public function tips()
	{

		$tips =  tips::whereNull('deleted_at')->orderBy('seq')->get();
		return view( 'client/tips', compact( 'tips' ) );

	}
	
	
}

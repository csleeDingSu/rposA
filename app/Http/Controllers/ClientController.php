<?php
/***
 *
 *
 ***/
namespace App\Http\Controllers;

use \App\helpers\WeiXin as WX;
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

use App\tips;

use App\member_game_result;

use App\view_vip_status;

//use App\Http\Controllers\Api\MemberController;

class ClientController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
	
	
	public function index() {		
		if (Auth::Guard('member')->check())
		{
			return redirect('/profile');
		}
		else if (Auth::Guard('admin')->check())
		{
			return redirect()->route('memberlist');
		}
		else
		{
			//wechat integration

			return redirect()->route('render.member.register');
		}		
	}
	
	
	
	public function member_profile()
	{
		$member = Auth::guard('member')->user()->id	;
		$data['member']    = Member::get_member($member);
		$data['wallet']    = Wallet::get_wallet_details_all($member);
		$data['usedpoint'] = \DB::table('view_usedpoint')->where('member_id',$member)->sum('point');
		$data['page'] = 'client.member'; 
		$data['vip_status'] = view_vip_status::where('member_id',$member)->whereNotIn('redeem_state', [0,4])->get(); 

		return view('client/member', $data);
	}

	public function member_access_game()
	{
		$betting_count = 0;

		if (!Auth::Guard('member')->check())
		{
			$msg = trans('dingsu.please_login');
			\Session::flash('success',$msg);

			return redirect('/nlogin');

		} else {

			$member = Auth::guard('member')->user()->id	;
			$data['betting_count'] = member_game_result::where("member_id", $member)->get()->count();
			return view('client/game', $data);

		}

		// if (Auth::Guard('member')->check())
		// {
		// 	$member = Auth::guard('member')->user()->id	;
		// 	$data['betting_count'] = member_game_result::where("member_id", $member)->get()->count();

		// } else {
		// 	$data['betting_count'] = 0;
		// }

		// return view('client/game', $data);

	}

	public function member_access_vip()
	{
		if (!Auth::Guard('member')->check())
		{
			$msg = trans('dingsu.please_login');
			\Session::flash('success',$msg);

			return redirect('/nlogin');

		} else {

			$member = Auth::guard('member')->user()->id	;
			$data['member'] = Member::get_member($member);

			if(isset(Auth::Guard('member')->user()->vip_life) and Auth::Guard('member')->user()->vip_life > 0) {

				return view('client/vip');

			} else {

				return redirect('/arcade');
			}

		}
	}

	public function member_access_game_node()
	{
		$betting_count = 0;



		if (!Auth::Guard('member')->check())
		{
			// $msg = trans('dingsu.please_login');
			// \Session::flash('success',$msg);

			// return redirect('/nlogin');

			//weixin_verify
			$this->wx = new WX();
			if ($this->wx->isWeiXin()) {
            	$request = new Request;
	            return $this->wx->index($request,'snsapi_userinfo',env('wabao666_domain'));
	        } else {
	            $data['betting_count'] = 0;
				return view('client/game-node', $data);
	        }
			
		} else {

			$member = Auth::guard('member')->user()->id	;
			$data['betting_count'] = member_game_result::where("member_id", $member)->get()->count();
			return view('client/game-node', $data);

		}

	}

	public function member_access_vip_node()
	{
		if (!Auth::Guard('member')->check())
		{
			$msg = trans('dingsu.please_login');
			\Session::flash('success',$msg);

			return redirect('/nlogin');

		} else {

			// $member = Auth::guard('member')->user()->id	;
			// $data['member'] = Member::get_member($member);

			// if(isset(Auth::Guard('member')->user()->vip_life) and Auth::Guard('member')->user()->vip_life > 0) {

			// 	return view('client/vip-node');

			// } else {

			// 	return redirect('/arcade');
			// }

			return view('client/vip-node');

		}
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

	public function invitation_list () {

		$member_id = Auth::guard('member')->user()->id;

		$invitation_list = DB::table( 'view_members' )->where('referred_by', $member_id)->select( '*' )->orderBy( 'id', 'desc' )->get();

		return view( 'client/invitation_list', compact( 'invitation_list' ) );

	}

	public function round () {

		$member_id = Auth::guard('member')->user()->id;

		$round = DB::table( 'view_members' )->where('referred_by', $member_id)->select( '*' )->orderBy( 'id', 'desc' )->get();

		return view( 'client/round', compact( 'round' ) );

	}
	
	public function share(Request $request)
	{		
		$viewed = Session::get('sharepic');
		
		$data = \App\Share::status(1);
		
		if ($viewed) $data = $data->whereNotIn('id', Session::get('sharepic'));
		
		$data = $data->first();
						
		if (!$data)
		{
			Session::forget('sharepic');
			Session::save();
			$data = \App\Share::status(1)->first();			
		}
		
		Session::push('sharepic', $data->id);
		Session::save();
		
		return view('client/share', ['data'=>$data]);
	}
	
	public function sharetest(Request $request)
	{		
		$viewed = Session::get('sharepic');
		
		$data = \App\Share::status(1);
		
		if ($viewed) $data = $data->whereNotIn('id', Session::get('sharepic'));
		
		$data = $data->first();
						
		if (!$data)
		{
			Session::forget('sharepic');
			Session::save();
			$data = \App\Share::status(1)->first();			
		}
		
		Session::push('sharepic', $data->id);
		Session::save();
		
		return view('client/share_new', ['data'=>$data]);
	}
	
	
}

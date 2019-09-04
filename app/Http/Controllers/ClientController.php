<?php
/***
 *
 *
 ***/
namespace App\Http\Controllers;

use App;
use App\Category;
use App\Members as Member;
use App\Wallet;
use App\helpers\VIPApp;
use App\member_game_result;
use App\tips;
use App\view_vip_status;
use Auth;
use Carbon\ Carbon;
use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Khsing\WechatAgent\WechatAgent;
use \App\helpers\WeiXin as WX;
use session;

use Jenssegers\Agent\Agent;
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
			// return redirect('/nlogin?goto=profile');
		}		
	}
	
	
	public function set_payment_browser()
	{
		// return '';
		//$ua = Request::server('HTTP_USER_AGENT');
		$ua = $_SERVER['HTTP_USER_AGENT'];
		\Log::debug(json_encode(['useragent' => $ua], true)); 
		
		$agent = new Agent();
		
		\Log::debug(json_encode(['useragent' => $agent], true)); 
		
		$wbp['wbp']   = '';
		
		$platform = $agent->platform();
		$browser  = $agent->browser();
		$wbp['platform'] = $platform;
		$wbp['browser'] = $browser;
		
		// if ($platform == 'AndroidOS')
		// {
			if ($browser == 'Chrome')
			{
				$wbp['wbp'] = 'googlechrome://navigate?url=';
				//\Log::warning(json_encode(['imhere' => 'ya'], true));
			}
		// }
			
		\Log::warning(json_encode(['platform' => $platform,'browser' => $browser], true));
		
		return $wbp;
	}
	
	
	
	public function member_profile()
	{
		$member = Auth::guard('member')->user()->id	;
		$data['member']    = Member::get_member($member);
		$data['wallet']    = Wallet::get_wallet_details_all($member);
		$usedpoint         = \DB::table('view_usedpoint')->where('member_id',$member);
		
		$this->vp = new VIPApp();
		if ($this->vp->isVIPApp()) {
			$usedpoint = $usedpoint->whereIn('credit_type',['DPRBP']);
		}				
		$data['usedpoint']  = $usedpoint->sum('point');		
		$data['page']       = 'client.member'; 
		$data['vip_status'] = view_vip_status::where('member_id',$member)->whereNotIn('redeem_state', [0,4])->get(); 

		//isVIP APP
		$this->vp = new VIPApp();
		if ($this->vp->isVIPApp()) {
						
			$data['wbp'] = $this->set_payment_browser();
			
			return view('client/member_vip', $data);
		} else {
			return view('client/member', $data);
		}
		
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

	public function member_access_game_node($cid = 220, Request $request)
	{
		$ua = $request->server('HTTP_USER_AGENT');
		
		//\Log::debug(json_encode(['useragent' => $ua], true)); 
		
		$betting_count = 0;

		// $setting = \DB::table('settings')->where('id', 1)->select('mobile_default_image_url','product_home_popup_size')->first();

		if ($cid)
		{
			//$vouchers = Voucher::latest()->where('category' ,'=' , $cid)->paginate(5);
			//$vouchers = Voucher_category::latest()
			$vouchers = \DB::table('voucher_category')
			->join('vouchers', 'voucher_category.voucher_id', '=', 'vouchers.id')
			->where('voucher_category.category' ,'=' , $cid)
			->whereDate('vouchers.expiry_datetime' ,'>=' , Carbon::today())
			->groupBy('vouchers.id')
			->orderby('vouchers.created_at', 'DESC')
			->orderby('vouchers.id','DESC')
			->paginate(6);

			//$vouchers = Voucher::get_vouchers($cid)->paginate(5);
			//pagination already have the count data so no need to call again
			//$vouchers_total = Voucher::where('category' ,'=' , $cid)->count(); 
			
		}
		else{
			$vouchers = Voucher::latest()->whereDate('vouchers.expiry_datetime' ,'>=' , Carbon::today())->orderby('created_at', 'DESC')->orderby('id', 'DESC')->paginate(6);
			
		}

		if ($request->ajax()) {
			// \Log::warning('get vouchers 2nd page');
    		$view = view('client.productv2',compact('vouchers'))->render();
            return response()->json(['html'=>$view]);
            // return view('client/game-node', compact('vouchers'));
        }

        // $category = Category::where('parent_id', 0)->orderby('position','ASC')->get();
		
        // $banner = \DB::table('banner')->where('is_status' ,'1')->get();	


		if (!Auth::Guard('member')->check())
		{
			
			$member_mainledger = null;
			$firstwin 		   = null;

			//weixin_verify
			$this->wx = new WX();
			if ($this->wx->isWeiXin()) {
            	$request = new Request;
	            return $this->wx->index($request,'snsapi_userinfo',env('wabao666_domain'));
	        } else {
	            $data['betting_count'] = 0;
				return view('client/game-node',compact('betting_count','vouchers','cid','member_mainledger','firstwin'));
	        }
			
		} else {

			$member_id = Auth::guard('member')->user()->id;

        	$member_mainledger = \DB::table('mainledger')->where('member_id', $member_id)->select('*')->first();
			
			if($request->session()->get('firstwin') == 'no'){
				$firstwin = null;
			} else {
				$firstwin = \App\Product::IsFirstWin($member_id);
			}

			$data['betting_count'] = member_game_result::where("member_id", $member_id)->get()->count();
			return view('client/game-node', compact('betting_count','vouchers','cid','member_mainledger','firstwin'));

		}

	}

	public function member_access_vip_node()
	{	

		// if (!Auth::Guard('member')->check())
		// {
		// 	$msg = trans('dingsu.please_login');
		// 	\Session::flash('success',$msg);

		// 	return redirect('/nlogin');

		// } else {

			// $member = Auth::guard('member')->user()->id	;
			// $data['member'] = Member::get_member($member);

			// if(isset(Auth::Guard('member')->user()->vip_life) and Auth::Guard('member')->user()->vip_life > 0) {

			// 	return view('client/vip-node');

			// } else {

			// 	return redirect('/arcade');
			// }

		if (env('THISVIPAPP', false) == false) {			
			return redirect('/arcade');
		}
					
		$wbp = $this->set_payment_browser();
		
		return view( 'client/vip-node', compact( 'wbp' ) );
		
		// }
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
	
	public function wechat_otp_login($otp = FALSE, $goto = null) {		
			
		$url	= '/profile';
		
		\Log::warning(json_encode(['otp' => $otp, 'goto' => $goto], true));

		if( !preg_match('/micromessenger/i', strtolower($_SERVER['HTTP_USER_AGENT'])) ) {
			\Log::debug(json_encode(['wechat' =>'not in wechat browser'], true));
			dd('use wechat to login');
		}
		
		if (empty($otp))
		{
			\Log::warning(json_encode(['unauthorised_login' => 'empty OTP'], true));
			return redirect($url);
		}
		
		$record = \App\Member::where('activation_code', $otp)->first();
		
		if ($record)
		{
			if ($record->wechat_verification_status == 1)
			{
				//\Log::warning(json_encode(['unauthorised_wechat_login' => 'wechat verification failed'], true));
				//dd('waiting for admin verification');
			}
			
			if (Carbon::parse($record->activation_code_expiry)->gt(Carbon::now()))
			{
				\Auth::guard('member')->loginUsingId($record->id,true);
				
				$user = \Auth::guard('member')->user();
				$user->active_session  = Session::getId();
				// $user->activation_code = null;
				// $user->activation_code_expiry = '';
				$user->save();	
				
				\Log::debug(json_encode(['wechat_login' => 'verified and redirect to game'], true));
				
				// if (empty($goto)) {
				// 	return redirect('/arcade');				
				// } else {
				// 	return redirect("/$goto");				
				// }
				return redirect("/$goto");
				
			}
			\Log::warning(json_encode(['unauthorised_wechat_login' => 'expired OTP'], true));
			return redirect($url);
		}
		\Log::warning(json_encode(['unauthorised_wechat_login' => 'unknown OTP'], true));
		
		return redirect($url);	
	}
	
	
	public function vregister($refcode = NULL, Request $request)
	{
		$agent = new WechatAgent;
		$goto = $request->input('goto');
		
		if ($agent->is("Wechat")) {
			return redirect(\Config::get('app.url').'/weixin/'.urlEncode(\Config::get('app.wabao666_domain').'?refcode='.$refcode.'&goto=' . $goto)); 
		}
		return view('client/angpao'); 
	}

	public function member_access_profile()
	{
		// if (!Auth::Guard('member')->check())
		// {
			//weixin_verify
			// if( !preg_match('/micromessenger/i', strtolower($_SERVER['HTTP_USER_AGENT'])) ) {
			// 	return redirect('/profile');
			// } else {
				$this->wx = new WX();
				$request = new Request;
            	$request->merge(['goto' => 'profile']); 
	            return $this->wx->index($request,'snsapi_userinfo',env('wabao666_domain'));
			// }
			
			// $this->wx = new WX();
			// if ($this->wx->isWeiXin()) {
   //          	$request = new Request;
   //          	$request->merge(['goto' => 'profile']); 
	  //           return $this->wx->index($request,'snsapi_userinfo',env('wabao666_domain'));
	  //       } else {
	  //           return redirect('/profile'); 
	  //       }
			
		// } else {

			// return redirect('/profile');

		// }
		
	}

	public function member_access_redeem()
	{
		if (!Auth::Guard('member')->check())
		{
			//weixin_verify
			// if( !preg_match('/micromessenger/i', strtolower($_SERVER['HTTP_USER_AGENT'])) ) {
			// 	return redirect('/redeem');
			// } else {
				$this->wx = new WX();
				$request = new Request;
            	$request->merge(['goto' => 'redeem']); 
	            return $this->wx->index($request,'snsapi_userinfo',env('wabao666_domain'));
			// }
			
			// $this->wx = new WX();
			// if ($this->wx->isWeiXin()) {
   //          	$request = new Request;
   //          	$request->merge(['goto' => 'redeem']); 
	  //           return $this->wx->index($request,'snsapi_userinfo',env('wabao666_domain'));
	  //       } else {
	  //           return redirect('/redeem'); 
	  //       }
			
		} else {

			return redirect('/redeem');

		}
		
	}

	public function how_to_play()
	{
		return view('client/how_to_play');

	}

	public function tips_new()
	{
		$wbp = $this->set_payment_browser();
		
		return view( 'client/tips_new', compact( 'wbp' ) );

	}

	public function download_app()
	{
		$devices = "android";
		$isMacDevices = false;

		//Detect special conditions devices
		$iPod    = stripos($_SERVER['HTTP_USER_AGENT'],"iPod");
		$iPhone  = stripos($_SERVER['HTTP_USER_AGENT'],"iPhone");
		$iPad    = stripos($_SERVER['HTTP_USER_AGENT'],"iPad");
		$Android = stripos($_SERVER['HTTP_USER_AGENT'],"Android");
		$webOS   = stripos($_SERVER['HTTP_USER_AGENT'],"webOS");

		//do something with this information
		if( $iPod || $iPhone ){
		    //browser reported as an iPhone/iPod touch -- do something here
		    $devices = "iphone";
		    $isMacDevices = true;
		}else if($iPad){
		    //browser reported as an iPad -- do something here
		    $devices = "ipad";
		    $isMacDevices = true;
		}else if($Android){
		    //browser reported as an Android device -- do something here
		    $devices = "android";
		}else if($webOS){
		    //browser reported as a webOS device -- do something here
		    $devices = "webos";
		}

		$title_customize = '挖宝网app下载-玩无限抽奖，换超值奖品';

		return view('client/download_app',compact('devices', 'isMacDevices', 'title_customize'));
	}

	public function member_access_game_ranking(Request $request)
	{
	
		if (!Auth::Guard('member')->check())
		{
			
			$member_mainledger = null;
			$firstwin 		   = null;

			//weixin_verify
			$this->wx = new WX();
			if ($this->wx->isWeiXin()) {
            	$request = new Request;
            	$request->merge(['goto' => 'arcade_ranking']); 
	            return $this->wx->index($request,'snsapi_userinfo',env('wabao666_domain'));
	        } else {
				return view('client/game-ranking',compact('member_mainledger','firstwin'));
	        }
			
		} else {

			$member_id = Auth::guard('member')->user()->id;
        	$member_mainledger = \DB::table('mainledger')->where('member_id', $member_id)->select('*')->first();			
			if($request->session()->get('firstwin') == 'no'){
				$firstwin = null;
			} else {
				$firstwin = \App\Product::IsFirstWin($member_id);
			}

			return view('client/game-ranking', compact('member_mainledger','firstwin'));

		}

	}
	
	
}

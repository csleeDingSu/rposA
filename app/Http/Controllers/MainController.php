<?php
/***
 *
 *
 ***/
namespace App\Http\Controllers;


use App;
use App\Helpers\TracePhoneNumber;
use App\Helpers\VIPApp;
use App\Http\Controllers\Api\CreditController;
use App\Http\Controllers\tabaoApiController;
use App\Members as Member;
use App\Members;
use App\Shareproduct;
use App\Voucher;
use App\Wallet;
use App\member_game_bet_temp_log;
use App\resell_amount;
use App\view_buy_product_user_list;
use App\vouchers_yhq;
use Auth;
use Carbon\Carbon;
use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Session;
use Tymon\JWTAuth\Facades\JWTAuth;

class MainController extends BaseController
{
    // use AuthorizesRequests, DispatchesJobs, ValidatesRequests;	
	
	public function index() {
	}
	
	public function shop(Request $request)
	{
		$this->vp = new VIPApp();

        if (Auth::Guard('member')->check())
		{
			$member = Auth::guard('member')->user()->id	;
			$data['member'] = Member::get_member($member);
			$data['wallet'] = Wallet::get_wallet_details_all($member, $this->vp->isVIPApp());
			// $data['buy'] = view_buy_product_user_list::select('*')->groupby('product_id','member_id','updated_at')->orderBy('updated_at', 'DESC')->skip(0)->take(1)->get();

		} else {
			$member = null;
			$data['member'] = null;
			$data['wallet'] = null;	
			$data['buy'] = null;	
		}

		return view('client/shop', $data);
		
	}

	public function newMainPage(Request $request)
	{
		$this->vp = new VIPApp();
		if (Auth::Guard('member')->check())
		{
			$member = Auth::guard('member')->user()->id	;
			$data['member']    = Member::get_member($member);
			$data['wallet']    = Wallet::get_wallet_details_all($member, $this->vp->isVIPApp());
			$data['game_102_usedpoint'] = \DB::table('a_view_used_point')->where('member_id',$member)->where('game_id',102)->sum('point');

		} else {
			$member = null;
			$data['member'] = null;
			$data['wallet'] = null;	
			$data['game_102_usedpoint'] = 0;
		}
		
		$total_redeem =  \App\Game::get_total_redeem();
		
		$total_redeem = (int) $total_redeem;
		
		$data['total_redeem']  = array_map('intval', str_split($total_redeem));

		$this->tabao = new tabaoApiController();
		// $res = $this->tabao->getCollectionListWithDetail($request);
		// if (!empty($res['data'])) {
		// 	$data['product'] = $res['data'];
		// 	$data['pageId'] = $res['data']['pageId'];
		// }
		// $res = $this->tabao->getTaobaoCollection(1);
		$res = $this->tabao->getTaobaoCollectionVouchersGreater12(1,$request);
		if (!empty($res)) {
 			$data['product'] = $res['data'];
 			$data['pageId'] = $res['data']['pageId'];	
 		}

 		$res = $this->tabao->getTaobaoCollectionVouchersLess12(1,$request);
		if (!empty($res)) {
 			$data['product_zero'] = $res['data'];
 			$data['pageId_zero'] = $res['data']['pageId'];	
 		}
		
		return view('client/newMainPage', $data);
		
	}

	public function tabaoSearch($search = null)
	{
		$this->vp = new VIPApp();
		if (Auth::Guard('member')->check())
		{
			$member = Auth::guard('member')->user()->id	;
			$data['member']    = Member::get_member($member);
			$data['wallet']    = Wallet::get_wallet_details_all($member, $this->vp->isVIPApp());
			$data['game_102_usedpoint'] = \DB::table('a_view_used_point')->where('member_id',$member)->where('game_id',102)->sum('point');

		} else {
			$member = null;
			$data['member'] = null;
			$data['wallet'] = null;	
			$data['game_102_usedpoint'] = 0;
		}
		
		$data['search'] = $search;
		return view('client/newSearchPage', $data);

	}

	public function preShare(Request $request)
	{
		if (Auth::Guard('member')->check()) {
			$member_id = Auth::guard('member')->user()->id;
			// $point_used = \App\Game::earned_points($member_id , 102);
			// $point_all = \App\History::get_point($member_id,102);
			// return view('client/pre_share', compact('point_used','point_all'));
			return view('client/pre_share');	
		} else {
			return redirect('/login');
		}
		
	}

	public function getProductForHighlight(Request $request)
	{
		$from = empty($request->input('from')) ? 0 : $request->input('from');
		$to = empty($request->input('to')) ? 1 : $request->input('to');
		$data = view_buy_product_user_list::select('*')->groupby('product_id','member_id','updated_at')->orderBy('updated_at', 'DESC')->skip($from)->take($to)->get();
		return response()->json(['success' => true, 'data' => $data]); 
	}

	public function tabaoProductDetail(Request $request)
	{
		$data[] = null;

		// $this->tabao = new tabaoApiController();
		// $res = $this->tabao->getGoodsDetails($request);
		// if (!empty($res['data'])) {
		// 	$data['data'] = $res['data'];
		// }

		$data['data'] = ['id' => $request->id,'goodsId' => $request->goodsId,'mainPic' => $request->mainPic, 'title' => $request->title, 'monthSales' => $request->monthSales,'originalPrice' => $request->originalPrice,'couponPrice' => $request->couponPrice, 'couponLink' => $request->couponLink, 'commissionRate' => $request->commissionRate, 'voucher_pass' => null, 'life' => $request->life];

		$data['usedpoint'] = 0;
		if (Auth::Guard('member')->check()) {
			$gameid = 102;
			$member_id = Auth::guard('member')->user()->id;
			$data['usedpoint'] = \DB::table('a_view_used_point')->where('member_id',$member_id)->where('game_id',$gameid)->sum('point');
		}

		return view('client/tabao_product_detail', $data);
	}

	public function showLoginFormExternal()
    {
    	if (Auth::Guard('member')->check()) {
	    	return redirect('/logout?external=login');
	    }
    	$data['RunInApp'] = false;
        return view('auth/login_external', $data);
        
    }

    public function showRegisterFormExternal($ref = FALSE)
	{
		if (Auth::Guard('member')->check()) {
			return redirect('/logout?external=register');
		}

		$data = [];
				
		if (!empty($ref))
		{
			Session::forget('refcode');

			$data['ref']  = Members::CheckReferral($ref);
			
			$data['refcode'] = $ref;

			if (!empty($data['ref'])) {
				session(['refcode' => $ref]);	
			}
			
		}
		$data['RunInApp'] = false;

		// return view('auth.register_external', $data);
		return view('auth/login_external', $data);
	}

	public function tabaoZeroPriceProduct(Request $request)
	{
		$this->vp = new VIPApp();
		if (Auth::Guard('member')->check())
		{
			$member = Auth::guard('member')->user()->id	;
			$data['member']    = Member::get_member($member);
			$data['wallet']    = Wallet::get_wallet_details_all($member, $this->vp->isVIPApp());
			$data['game_102_usedpoint'] = \DB::table('a_view_used_point')->where('member_id',$member)->where('game_id',102)->sum('point');
			$data['life'] = empty($data['wallet']['gameledger']['102']['life']) ? 0 : $data['wallet']['gameledger']['102']['life'];
			
		} else {
			$member = null;
			$data['member'] = null;
			$data['wallet'] = null;	
			$data['game_102_usedpoint'] = 0;
			$data['life'] = 0;
		}

		$this->tabao = new tabaoApiController();

 		$res = $this->tabao->getTaobaoCollectionVouchersLess12(1,$request);
		if (!empty($res)) {
 			$data['product'] = $res['data'];
 			$data['pageId'] = $res['data']['pageId'];	
 		}
		
		return view('client/zeroPricePage', $data);
	}

	public function newbieProduct(Request $request)
	{ 	
 		$data['devices'] = "android";
		$data['isMacDevices'] = false;

		//Detect special conditions devices
		$iPod    = stripos($_SERVER['HTTP_USER_AGENT'],"iPod");
		$iPhone  = stripos($_SERVER['HTTP_USER_AGENT'],"iPhone");
		$iPad    = stripos($_SERVER['HTTP_USER_AGENT'],"iPad");
		$Android = stripos($_SERVER['HTTP_USER_AGENT'],"Android");
		$webOS   = stripos($_SERVER['HTTP_USER_AGENT'],"webOS");

		//do something with this information
		if( $iPod || $iPhone ){
		    //browser reported as an iPhone/iPod touch -- do something here
		    $data['devices'] = "iphone";
		    $data['isMacDevices'] = true;
		}else if($iPad){
		    //browser reported as an iPad -- do something here
		    $data['devices'] = "ipad";
		    $data['isMacDevices'] = true;
		}else if($Android){
		    //browser reported as an Android device -- do something here
		    $data['devices'] = "android";
		}else if($webOS){
		    //browser reported as a webOS device -- do something here
		    $data['devices'] = "webos";
		}
		
		return view('client/newBiePage', $data);
	}

	public function coin(Request $request)
	{
		$this->vp = new VIPApp();
		$member = Auth::guard('member')->user()->id	;
		$data['member']    = Member::get_member($member);
		$data['wallet']    = Wallet::get_wallet_details_all($member, $this->vp->isVIPApp());
		$data['resell_amount'] = resell_amount::select('*')->get();

		return view('client/coin', $data);
		
	}

	public function coinList(Request $request)
	{
		$this->vp = new VIPApp();
		$member = Auth::guard('member')->user()->id	;
		$data['member']    = Member::get_member($member);
		$data['wallet']    = Wallet::get_wallet_details_all($member, $this->vp->isVIPApp());

		return view('client/coinList', $data);
		
	}

	public function coinListInComplete(Request $request)
	{
		$this->vp = new VIPApp();
		$member = Auth::guard('member')->user()->id	;
		$data['member']    = Member::get_member($member);
		$data['wallet']    = Wallet::get_wallet_details_all($member, $this->vp->isVIPApp());

		return view('client/coinListInComplete', $data);
		
	}


	public function coinDetail($id = null, Request $request)
	{
		$this->vp = new VIPApp();
		$member = Auth::guard('member')->user()->id	;
		$data['member']    = Member::get_member($member);
		$data['wallet']    = Wallet::get_wallet_details_all($member, $this->vp->isVIPApp());
		$data['resell_id']	= $id;

		return view('client/coinDetail', $data);
		
	}

	public function coinReady(Request $request)
	{
		$this->vp = new VIPApp();
		$member = Auth::guard('member')->user()->id	;
		$data['member']    = Member::get_member($member);
		$data['wallet']    = Wallet::get_wallet_details_all($member, $this->vp->isVIPApp());

		return view('client/coinReady', $data);
		
	}

	public function coinPayIng(Request $request)
	{
		$this->vp = new VIPApp();
		$member = Auth::guard('member')->user()->id	;
		$data['member']    = Member::get_member($member);
		$data['wallet']    = Wallet::get_wallet_details_all($member, $this->vp->isVIPApp());

		return view('client/coinPayIng', $data);
		
	}

	public function coinPayOver(Request $request)
	{
		$this->vp = new VIPApp();
		$member = Auth::guard('member')->user()->id	;
		$data['member']    = Member::get_member($member);
		$data['wallet']    = Wallet::get_wallet_details_all($member, $this->vp->isVIPApp());

		return view('client/coinPayOver', $data);
		
	}

	public function coinFail(Request $request)
	{
		$this->vp = new VIPApp();
		$member = Auth::guard('member')->user()->id	;
		$data['member']    = Member::get_member($member);
		$data['wallet']    = Wallet::get_wallet_details_all($member, $this->vp->isVIPApp());

		return view('client/coinFail', $data);
		
	}

	public function recharge(Request $request)
	{
		$this->vp = new VIPApp();
		$member = Auth::guard('member')->user()->id	;
		$data['member']    = Member::get_member($member);
		$data['wallet']    = Wallet::get_wallet_details_all($member, $this->vp->isVIPApp());
		$data['resell_amount'] = resell_amount::select('*')->get();

		return view('client/recharge', $data);
		
	}

	public function rechargeType(Request $request)
	{
		$this->vp = new VIPApp();
		$member = Auth::guard('member')->user()->id	;
		$data['member']    = Member::get_member($member);
		$data['wallet']    = Wallet::get_wallet_details_all($member, $this->vp->isVIPApp());

		$credit_resell_id = $request->input('credit_resell_id');

		if (!empty($credit_resell_id)) {
			$c = new CreditController();
			$request->merge(['id' => $credit_resell_id]); 
			$res = json_encode($c->get_resell_record($request));
			$data['content'] = json_decode($res)->original;
			$data['coin'] = $request->input('coin');
			$data['cash'] = $request->input('cash');
		} else {
			$data['content'] = json_decode($request->input('hidTypeContent'));
			$data['coin'] = $request->input('hidSelectedCoin');
			$data['cash'] = $request->input('hidSelectedCash');
		}

		// dd($data['content']);
		
		$type = !empty($data['content']->type) ? $data['content']->type : '';

		if ($type == 'companyaccount' || $type == '1') {
			return view('client/rechargeCard', $data);	
		}else{
			return view('client/rechargeAlipay', $data);	
		}
		
	}

	public function rechargeList(Request $request)
	{
		$this->vp = new VIPApp();
		$member = Auth::guard('member')->user()->id	;
		$data['member']    = Member::get_member($member);
		$data['wallet']    = Wallet::get_wallet_details_all($member, $this->vp->isVIPApp());

		return view('client/rechargeList', $data);
		
	}

	public function rechargeDetail($id = null, Request $request)
	{
		$this->vp = new VIPApp();
		$member = Auth::guard('member')->user()->id	;
		$data['member']    = Member::get_member($member);
		$data['wallet']    = Wallet::get_wallet_details_all($member, $this->vp->isVIPApp());
		$data['recharge_id']	= $id;

		return view('client/rechargeDetail', $data);
		
	}

	public function rechargeListInComplete(Request $request)
	{
		$this->vp = new VIPApp();
		$member = Auth::guard('member')->user()->id	;
		$data['member']    = Member::get_member($member);
		$data['wallet']    = Wallet::get_wallet_details_all($member, $this->vp->isVIPApp());

		return view('client/rechargeListInComplete', $data);
		
	}

	public function rechargeAlipay(Request $request)
	{
		$this->vp = new VIPApp();
		$member = Auth::guard('member')->user()->id	;
		$data['member']    = Member::get_member($member);
		$data['wallet']    = Wallet::get_wallet_details_all($member, $this->vp->isVIPApp());

		return view('client/rechargeAlipay', $data);
		
	}

	public function rechargeCard(Request $request)
	{
		$this->vp = new VIPApp();
		$member = Auth::guard('member')->user()->id	;
		$data['member']    = Member::get_member($member);
		$data['wallet']    = Wallet::get_wallet_details_all($member, $this->vp->isVIPApp());

		return view('client/rechargeCard', $data);
		
	}

	public function storeAlipayAccount(Request $request)
	{
		$id = empty($request->memberid) ? 0 : $request->memberid;
		if ($id > 0) {
			// $filter = ['id' => $id];
			// $array = ['id' => $id, 'alipay_account' => $request->alipay_account, 'phone' => $request->phone ];
			// $id = Members::updateOrCreate($filter,$array)->id;

			//check alreadt exist in wabaoshop or wabao666
			$_modal = new Members;
			$_modal->setConnection('mysql2');
			$_member = $_modal->where('phone' , $request->phone)->first();
			if (empty($_member)) {
				return response()->json(['success' => true, 'code' => '200', 'data' => 'updated member id ' . $id]); 	
			} else {
				$_db = DB::connection('mysql2')->getDatabaseName();
				return response()->json(['success' => false, 'code' => '001', 'data' => 'already exist in ' . $_db . ' DB member id: ' . $id]); 	
			}	
		} else {
			return response()->json(['success' => false, 'code' => '002', 'data' => 'Invalid member id: ' . $id]); 	
		}
		
	}

}

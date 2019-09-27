<?php
/***
 *
 *
 ***/
namespace App\Http\Controllers;


use App;
use App\Helpers\VIPApp;
use App\Http\Controllers\tabaoApiController;
use App\Members as Member;
use App\Members;
use App\Shareproduct;
use App\Voucher;
use App\Wallet;
use App\member_game_bet_temp_log;
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
			$data['buy'] = view_buy_product_user_list::select('*')->groupby('product_id','member_id','updated_at')->orderBy('updated_at', 'DESC')->skip(0)->take(1)->get();

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

		} else {
			$member = null;
			$data['member'] = null;
			$data['wallet'] = null;	
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
		$res = $this->tabao->getTaobaoCollection(1);
		if (!empty($res)) {
 			$data['product'] = $res['data'];
 			$data['pageId'] = $res['data']['pageId'];	
 		}
		
		return view('client/newMainPage', $data);
		
	}

	public function tabaoSearch($search = null)
	{
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

		$data['data'] = ['id' => $request->id,'goodsId' => $request->goodsId,'mainPic' => $request->mainPic, 'title' => $request->title, 'monthSales' => $request->monthSales,'originalPrice' => $request->originalPrice,'couponPrice' => $request->couponPrice, 'couponLink' => $request->couponLink, 'voucher_pass' => null];

		// dd($data);

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

		return view('auth.register_external', $data);
	}  

}

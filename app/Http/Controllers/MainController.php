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
use session;

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
			$earnedpoint = \App\Game::earned_points($member_id , 102);
			return view('client/pre_share', compact('earnedpoint'));	
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

}

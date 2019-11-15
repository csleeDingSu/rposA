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
use App\v_getTaobaoCollectionVouchersLess12;
use App\v_getTaobaoCollectionVouchersLess15;
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

class ShareProductController extends BaseController
{
    // use AuthorizesRequests, DispatchesJobs, ValidatesRequests;	
	
	public function index($id = FALSE) {		

		if (is_null($id)) {

			// $data['item'] = Voucher::where('share_product',1)->orderBy('updated_at', 'desc')->select('*')->first();
			$data['item'] = Voucher::select('*')->first();

		} else {

			$data['item'] = Shareproduct::where('id',$id)->select('*')->first();

		}		

		$data['item_featured'] = Voucher::join('voucher_category','voucher_category.voucher_id', '=', 'vouchers.id')->where('voucher_category.category',env('voucher_featured_id',220))->select('vouchers.*')->orderBy('vouchers.id', 'desc')->take(10)->get();
		
		return view('client/share_product', $data);
	}

	public function temp_log()
	{
		$gameid = $gametype = $memberid = $drawid = $bet = $betamt = $level = $error = null;

		$data = $_POST['data'];
		$arr  = explode('&', $data); 
		foreach($arr as $a) {
			$_a  = explode('=', $a);
			if (strpos($_a[0],'gameid') !== false) {
				$gameid = $_a[1];
			}
			if ($_a[0] == 'gametype') {
				$gametype = $_a[1];
			}
			if ($_a[0] == 'memberid') {
				$memberid = $_a[1];
			}
			if ($_a[0] == 'drawid') {
				$drawid = $_a[1];
			}
			if ($_a[0] == 'bet') {
				$bet = $_a[1];
			}
			if ($_a[0] == 'betamt') {
				$betamt = $_a[1];
			}
			if ($_a[0] == 'level') {
				$level = $_a[1];
			}
			if ($_a[0] == 'error') {
				$error = $_a[1];
			}
			
		}

		// var_dump($arr);
		// $fname = time() . ".txt";//generates random name

		// $file = fopen("http://localhost:8877/" .$fname, 'w');//creates new file
		// fwrite($file, $data);
		// fclose($file);

		$array = ['log' => $data, 'gameid' => $gameid, 'gametype' => $gametype, 'memberid' => $memberid, 'drawid' => $drawid, 'bet' => $bet, 'betamt' => $betamt, 'level' => $level, 'error' => $error];
		$res = member_game_bet_temp_log::Create($array)->id;

		return "done";
		
	}

	public function yhq_search()
	{

		// $url = "http://192.168.1.154:8888/nobet";
		$url = "http://yhq.cn/index.php?r=index/search&kw=三只松鼠";

		// $url = "http://yhq.cn/index.php?r=index/search&s_type=1&kw=";
		var_dump($url);
	    $client = new \GuzzleHttp\Client();
	    // Send an asynchronous request.
	    $request = new \GuzzleHttp\Psr7\Request('GET', $url);

	 //    $promise = $client->sendAsync($request)->then(function ($response) {
	 //    // echo 'I completed! ' . $response->getBody();
	 //     echo 'Completed!';
		// });

	 //    $promise->wait();

	    $promise = $client->requestAsync('GET', $url);
		$promise->then(function ($response) {
			echo 'Got a response! ' . $response->getStatusCode(); }
		);

		var_dump('done');

		// $url = "http://www.google.com";
  //       $payload = [];
  //       $headers = ['Content-Type: application/x-www-form-urlencoded'];
  //       $option = ['connect_timeout' => 60, 'timeout' => 180];
  //       $client = new \GuzzleHttp\Client(['http_errors' => true, 'verify' => false]);
  //       $request = $client->get($url, ['headers' => $headers, 'form params' => $payload]);
  //       $response = $request->getBody()->getContents();
  //       var_dump($response);

  //       // Get cURL resource
		// $curl = curl_init();
		// // Set some options - we are passing in a useragent too here
		// curl_setopt_array($curl, [
		//     CURLOPT_RETURNTRANSFER => 1,
		//     CURLOPT_URL => 'www.wabao666.com',
		//     CURLOPT_USERAGENT => 'Codular Sample cURL Request'
		// ]);
		// // Send the request & save response to $resp
		// $resp = curl_exec($curl);

		// var_dump($resp);
		// // Close request to clear up some resources
		// curl_close($curl);
	}

	public function new_share_product($id = FALSE) {		

		if (is_null($id)) {

			// $data['item'] = Voucher::where('share_product',1)->orderBy('updated_at', 'desc')->select('*')->first();
			$data['item'] = Voucher::select('*')->first();

		} else {

			$data['item'] = Shareproduct::where('id',$id)->select('*')->first();

		}		

		$data['item_featured'] = Voucher::join('voucher_category','voucher_category.voucher_id', '=', 'vouchers.id')->where('voucher_category.category',env('voucher_featured_id',220))->select('vouchers.*')->orderBy('vouchers.id', 'desc')->take(10)->get();
		
		return view('client/new_share_product', $data);
	}

	public function new_share_product2($id = FALSE) {		

		if (is_null($id)) {

			// $data['item'] = Voucher::where('share_product',1)->orderBy('updated_at', 'desc')->select('*')->first();
			$data['item'] = Voucher::select('*')->first();

		} else {

			$data['item'] = Shareproduct::where('id',$id)->select('*')->first();

		}		

		$data['item_featured'] = Voucher::join('voucher_category','voucher_category.voucher_id', '=', 'vouchers.id')->where('voucher_category.category',env('voucher_featured_id',220))->select('vouchers.*')->orderBy('vouchers.id', 'desc')->take(10)->get();
		
		return view('client/new_share_product2', $data);
	}

	public function getVoucherDetail($id)
	{
		$_modal = new v_getTaobaoCollectionVouchersLess15;
        if (!env('THISVIPAPP')) {
            $_modal->setConnection('mysql2');
        }
        $data['voucher'] = $_modal->where('id',$id)->select('*')->first();
        
		// $data['voucher'] = Voucher::where('id',$id)->select('*')->first();
		return view('client/productv2_detail', $data);
		
	}

	public function shop(Request $request)
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

}

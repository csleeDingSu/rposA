<?php
/***
 *
 *
 ***/
namespace App\Http\Controllers;


use App;
use App\Voucher;
use App\member_game_bet_temp_log;
use App\vouchers_yhq;
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

class ShareProductController extends BaseController
{
    // use AuthorizesRequests, DispatchesJobs, ValidatesRequests;	
	
	public function index($id = FALSE) {		

		if (is_null($id)) {

			// $data['item'] = Voucher::where('share_product',1)->orderBy('updated_at', 'desc')->select('*')->first();
			$data['item'] = Voucher::select('*')->first();

		} else {

			$data['item'] = Voucher::where('id',$id)->select('*')->first();

		}		

		$data['item_featured'] = Voucher::where('is_featured', 1)->select('*')->orderBy('created_at', 'desc')->take(4)->get();
		
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

}

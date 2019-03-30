<?php
/***
 *
 *
 ***/
namespace App\Http\Controllers;


use App;
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
	
	public function index() {		

		$data['voucher'] = vouchers_yhq::select('*')->first();
		
		return view('client/share_product', $data);
	}

	public function temp_log()
	{

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
			
		}

		// var_dump($arr);
		// $fname = time() . ".txt";//generates random name

		// $file = fopen("http://localhost:8877/" .$fname, 'w');//creates new file
		// fwrite($file, $data);
		// fclose($file);

		$array = ['log' => $data, 'gameid' => $gameid, 'gametype' => $gametype, 'memberid' => $memberid, 'drawid' => $drawid, 'bet' => $bet, 'betamt' => $betamt, 'level' => $level];
		$res = member_game_bet_temp_log::Create($array)->id;

		return "done";
		
	}

}

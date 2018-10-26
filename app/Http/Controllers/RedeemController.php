<?php
/***
 *
 *
 ***/

namespace App\Http\Controllers;
use App;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Wallet;
use App\Redeem;
use Carbon\Carbon;



class RedeemController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
	
	public $pagination_count = 100;
	
	public function getRedeemList()
    {
		$result =  Redeem::get_redeem_product_list(100);
		$data['page'] = 'redeem.redeemproduct'; 	
		$data['result'] = $result;
		
		return view('redeem.redeemproduct', $data);		
	}
	

	
}

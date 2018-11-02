<?php
/***
 *
 *
 ***/

namespace App\Http\Controllers;
use DB;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use Illuminate\Database\Eloquent\Model;
use Auth;
use App\redeemed;
use App\Members;
use Carbon\Carbon;

class AdminController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
	public function __construct()
    {
        $this->middleware('auth:admin');
    }
	public function index() {
		if (Auth::Guard('member')->check())
		{
			//redirect to member
			return redirect()->route('/');
		}
		else if (Auth::Guard('admin')->check())
		{
			if (Auth::user()->username == 'admin2') {

			return redirect()->route('ad.product.show');

			} else {
			//redirect to member list
			return redirect()->route('admindashboard');	
			}
			
		}
		else
		{
			return redirect()->route('adminlogin');
		}
	}
	
	public function dashboard ()
	{
		$data['page'] = 'admin.dashboard';

		$user = Auth::user();
		
		if (Auth::guard('admin')->check()){
		//	$user = Auth::user();
			$data['total_members'] = Members::count();
			$data['today_registration'] = Members::whereDate('created_at',Carbon::today())->count();
			$data['today_online'] = Members::whereNotNull('active_session')->count();
			$data['total_redeemed'] = redeemed::count();
		}
		//print_r($user);die();
		
		
		return view('main', $data);
	}
	
}

<?php
/***
 *
 *
 ***/
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Lead\Lead;
use App\Lead\Status;
use DB;
use App\Services\ExportCSV;

class CronManagerController extends Controller
{   
	public function invitation_list () {

		$member_id = Auth::guard('member')->user()->id;

		$invitation_list = DB::table( 'view_members' )->where('referred_by', $member_id)->select( '*' )->orderBy( 'id', 'desc' )->get();

		return view( 'client/invitation_list', compact( 'invitation_list' ) );

	}
	
	
}

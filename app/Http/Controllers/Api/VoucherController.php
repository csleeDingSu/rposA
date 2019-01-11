<?php

namespace App\Http\Controllers\Api;

use App\Voucher;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


use App\Unreleasedvouchers;
use App\Category;
use App\redeemed;
use Auth;

class VoucherController extends Controller
{
    
    public function index(Request $request)
    {
        /*
		$category = Category::orderby('position','ASC')->get();
		
		$vouchers = Voucher::latest()->paginate(5);

		$total = ['redeemed' => redeemed::count(), 'vouchers' => Voucher::count()];
		
		if ($request->ajax()) {
    		$view = view('client.ajaxhome',compact('vouchers'))->render();
            return response()->json(['html'=>$view]);
        }
		$cid = false;
        //return view('client.home', compact('vouchers','category'));
        return view('client.home3', compact('vouchers','category','total','cid'));
		*/
		return redirect('/cs/1');
		
    }

    public function show($cid = false,Request $request)
    {
		$setting = \DB::table('settings')->where('id', 1)->select('mobile_default_image_url')->first();

        if ($cid)
		{
			$vouchers = Voucher::latest()->where('category' ,'=' , $cid)->paginate(5);		
			//pagination already have the count data so no need to call again
			//$vouchers_total = Voucher::where('category' ,'=' , $cid)->count(); 
			
		}
		else{
			$vouchers = Voucher::latest()->paginate(5);
			
		}

		if ($request->ajax()) {
    		$view = view('client.ajaxhome',compact('vouchers', 'setting'))->render();
            return response()->json(['html'=>$view]);
        }
		
		//$total = ['redeemed' => redeemed::count(), 'vouchers' => $vouchers_total];
		
		$category = Category::orderby('position','ASC')->get();
		
        $banner = \DB::table('banner')->where('is_status' ,'1')->get();	

		if (Auth::Guard('member')->check()) {

			$member_id = Auth::guard('member')->user()->id;

        	$member_mainledger = \DB::table('mainledger')->where('member_id', $member_id)->select('*')->first();	
		}
        else{

        	$member_mainledger = null;

        }

		
        return view('client.home3', compact('vouchers','category','cid','banner','member_mainledger', "setting"));
		
    }
}
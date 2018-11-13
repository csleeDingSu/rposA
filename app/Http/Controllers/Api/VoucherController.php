<?php

namespace App\Http\Controllers\Api;

use App\Voucher;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


use App\Unreleasedvouchers;
use App\Category;
use App\redeemed;

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
        if ($cid)
		{
			$vouchers = Voucher::latest()->where('category' ,'=' , $cid)->paginate(5);
			$vouchers_total = Voucher::where('category' ,'=' , $cid)->count();
		}
		else{
			$vouchers = Voucher::latest()->paginate(5);
			$vouchers_total = Voucher::count();
		}
		
		$category = Category::orderby('position','ASC')->get();

		$total = ['redeemed' => redeemed::count(), 'vouchers' => $vouchers_total];

		if ($request->ajax()) {
    		$view = view('client.ajaxhome',compact('vouchers'))->render();
            return response()->json(['html'=>$view]);
        }
		
        //return view('client.home', compact('vouchers','category'));		
        return view('client.home3', compact('vouchers','category','total','cid'));
		
    }
}
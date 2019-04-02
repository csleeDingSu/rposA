<?php

namespace App\Http\Controllers\Api;

use App\Voucher;
use App\Voucher_category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Pagination\Paginator;


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

		//$category = Category::where('display_name',env('voucher_featured_label','精选'))->where('parent_id',0)->select('id')->first();

		// return redirect('/cs/' . $category->id);
		return redirect('/cs/' . env('voucher_featured_id','220'));
		
    }

    public function show($cid = false,Request $request)
    {
		$setting = \DB::table('settings')->where('id', 1)->select('mobile_default_image_url')->first();

        if ($cid)
		{
			//$vouchers = Voucher::latest()->where('category' ,'=' , $cid)->paginate(5);
			//$vouchers = Voucher_category::latest()
			$vouchers = \DB::table('voucher_category')
			->join('vouchers', 'voucher_category.voucher_id', '=', 'vouchers.id')
			->where('voucher_category.category' ,'=' , $cid)
			->groupBy('vouchers.id')
			->orderby('vouchers.created_at','DESC')
			->paginate(5);

			//$vouchers = Voucher::get_vouchers($cid)->paginate(5);
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
		
		$category = Category::where('parent_id', 0)->orderby('position','ASC')->get();
		
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

    public function search($strSearch = '', Request $request)
    {
    	$setting = \DB::table('settings')->where('id', 1)->select('mobile_default_image_url')->first();

        $vouchers = new Paginator([], 5);

    	if ($strSearch)
		{
	    	$vouchers = \DB::table('vouchers')
	    		->where('product_name', 'LIKE', '%'.$strSearch.'%')
				->orderby('vouchers.created_at','DESC')
				->paginate(5);			
		}

		if ($request->ajax()) {
    		$view = view('client.ajaxhome',compact('vouchers', 'setting'))->render();
            return response()->json(['html'=>$view]);
        }

        if (Auth::Guard('member')->check()) {

			$member_id = Auth::guard('member')->user()->id;

        	$member_mainledger = \DB::table('mainledger')->where('member_id', $member_id)->select('*')->first();	
		}
        else{

        	$member_mainledger = null;

        }

    	return view('client.search', compact('vouchers', 'setting', 'strSearch', 'member_mainledger'));
    }
}
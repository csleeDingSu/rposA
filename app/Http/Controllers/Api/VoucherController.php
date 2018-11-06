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
    
    public function index()
    {
        
		$category = Category::all();
		
		$vouchers = Voucher::latest()->paginate(25);

		$total = ['redeemed' => redeemed::count(), 'vouchers' => Voucher::count()];

        //return view('client.home', compact('vouchers','category'));
        return view('client.home3', compact('vouchers','category','total'));
		
		
    }

    public function show($cid = false)
    {
        if ($cid)
		{
			$vouchers = Voucher::latest()->where('category' ,'=' , $cid)->paginate(5);
		}
		else{
			$vouchers = Voucher::latest()->paginate(25);
		}
		
		$category = Category::all();

		$total = ['redeemed' => redeemed::count(), 'vouchers' => Voucher::count()];


        //return view('client.home', compact('vouchers','category'));		
        return view('client.home3', compact('vouchers','category','total'));
		
    }
}
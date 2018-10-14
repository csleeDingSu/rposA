<?php

namespace App\Http\Controllers\Api;

use App\Voucher;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


use App\Unreleasedvouchers;
use App\Category;

class VoucherController extends Controller
{
    
    public function index()
    {
        
		$category = Category::all();
		
		$vouchers = Voucher::latest()->paginate(5);
        return view('client.home', compact('vouchers','category'));
		
		
    }

    public function show($cid = false)
    {
        if ($cid)
		{
			$vouchers = Voucher::latest()->where('category' ,'=' , $cid)->paginate(5);
		}
		else{
			$vouchers = Voucher::latest()->paginate(5);
		}
		
		$category = Category::all();
        return view('client.home', compact('vouchers','category'));		
		
    }
}
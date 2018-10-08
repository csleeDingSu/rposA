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
		
		$vouchers = Unreleasedvouchers::latest()->paginate(10);
        return view('client.home', compact('vouchers','category'));
		
		
    }

    public function show($cid = false)
    {
        if ($cid)
		{
			$vouchers = Voucher::latest()->where('category' ,'=' , $cid)->paginate(10);
		}
		else{
			$vouchers = Voucher::latest()->paginate(10);
		}
		
		$category = Category::all();
        return view('client.home', compact('vouchers','category'));		
		
    }
}
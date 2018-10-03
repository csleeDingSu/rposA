<?php

namespace App\Http\Controllers\Api;

use App\Voucher;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class VoucherController extends Controller
{
   
    public function index()
    {
		$vouchers = Voucher::latest()->paginate(10);
        return view('client.home', compact('vouchers'));		
		
    }    
    public function show()
    {
        $vouchers = Voucher::latest()->paginate(10);
        return view('client.home', compact('vouchers'));		
		
    }
	
}
<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


use App\Unreleasedvouchers;

class UnreleasedvoucherController extends Controller
{
   
    public function index()
    {
		$vouchers = Unreleasedvouchers::latest()->paginate(10);
        return view('client.home', compact('vouchers'));		
		
    }

    
    public function show(Signature $signature)
    {
        $vouchers = Unreleasedvouchers::latest()->paginate(10);
        return view('client.home', compact('vouchers'));	
    }
	
	
}
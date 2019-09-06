<?php

namespace App\Http\Controllers;

use App\blog;
use App\buy_product_redeemed;
use App\v_blog_buy_product_records;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReceiptController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
        if (!Auth::Guard('member')->check())
        {
            return redirect('/');
        }   
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {        
        $receipt = blog::select('*')->whereNull('deleted_at')->orderBy('updated_at','desc')->paginate(3);
        // dd($receipt);
        if ($request->ajax()) {
            $view = view('client.receipt_list',compact('receipt'))->render();
            return response()->json(['html'=>$view]);
            // return view('client/game-node', compact('vouchers'));
        }
        return view('client.receipt', compact('receipt'));
    }

   
}

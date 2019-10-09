<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Carbon\ Carbon;
use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;


class ReceiptController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // dd(Auth::guard('member')->check());
        // $this->middleware('auth');
        // if (!Auth::Guard('member')->check())
        // {
        //     return redirect('/');
        // }   
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {   
        if (Auth::guard('member')->check()) {
            return view('client.receipt');
        } else {
            return redirect('/login');
        }
    }

    public function showGuide()
    {
        return view('client.receipt_guide');
    }

   
}

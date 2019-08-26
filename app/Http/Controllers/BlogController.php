<?php

namespace App\Http\Controllers;

use App\blog;
use App\buy_product_redeemed;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BlogController extends Controller
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
    public function index()
    {        
        $data['blog'] = blog::select('*')->whereNull('deleted_at')->orderBy('updated_at','desc')->get();
        return view('client/blog', $data);
    }

    public function createform()
    {
        return view('client/blog_create');   
    }

    public function create(Request $request)
    {
        $member_id = Auth::guard('member')->user()->id;
        $detail = \App\RedeemedProduct::with('shipping_detail')->where('member_id', $member_id)->latest()->first();
        
        if (empty($detail->shipping_detail->contact_number)) {
            $phone = Auth::guard('member')->user()->phone;
            $address = "empty address";
        } else {
            $phone = $detail->shipping_detail->contact_number;
            $address = $detail->shipping_detail->address;
        }

        $content = $request->input('content');
        $uploads = $request->input('uploads');
        
        $arr = ['member_id' => $member_id, 'phone' => $phone, 'address' => $address, 'content' => $content, 'uploads' => $uploads];
        $data = $arr;
        $b = blog::updateOrCreate($arr,$data)->id;
        return ['success' => true]; 
            
    }
}

<?php

namespace App\Http\Controllers;

use App\blog;
use App\buy_product_redeemed;
use App\v_blog_buy_product_records;
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
    public function index(Request $request)
    {        
        $blog = blog::select('*')->whereNull('deleted_at')->orderBy('updated_at','desc')->paginate(20);
        if ($request->ajax()) {
            $view = view('client.blog_list',compact('blog'))->render();
            return response()->json(['html'=>$view]);
            // return view('client/game-node', compact('vouchers'));
        }
        return view('client.blog', compact('blog'));
    }

    public function createform()
    {
        return view('client/blog_create');   
    }

    public function create(Request $request)
    {
        $member_id = Auth::guard('member')->user()->id;
        $detail = v_blog_buy_product_records::where('member_id', $member_id)->first();
        
        if (empty($detail->contact_number)) {
            $phone = Auth::guard('member')->user()->phone;
            $address = null;
        } else {
            $phone = $detail->contact_number;
            $address = $detail->address;
        }

        $content = $request->input('content');
        $uploads = is_array($request->input('uploads')) ? json_encode($request->input('uploads')) : $request->input('uploads');
        
        $arr = ['member_id' => $member_id, 'phone' => $phone, 'address' => $address, 'content' => $content, 'uploads' => $uploads];
        $data = $arr;
        $b = blog::updateOrCreate($arr,$data)->id;
        return ['success' => true]; 
            
    }
}

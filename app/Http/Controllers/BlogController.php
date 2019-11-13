<?php

namespace App\Http\Controllers;

use App\helpers\TracePhoneNumber;
use App\blog;
use App\buy_product_redeemed;
use App\v_blog_buy_product_records;
use App\v_blog_detail;
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
        $page = empty($request->page) ? 1 : $request->page;
        $blog = blog::select('*')->whereNull('deleted_at')->orderBy('updated_at','desc')->paginate(10);
        if ($request->ajax()) {
            $view = view('client.blog_list',compact('blog','page'))->render();
            return response()->json(['html'=>$view]);
            // return view('client/game-node', compact('vouchers'));
        }
        return view('client.blog', compact('blog','page'));
    }

    public function createform(Request $request)
    {
        $buy_product_redeemed_id = $request->buy_product_redeemed_id;

        return view('client/blog_create', compact('buy_product_redeemed_id'));   
    }

    public function create(Request $request)
    {
        $member_id = Auth::guard('member')->user()->id;
        $detail = v_blog_buy_product_records::where('member_id', $member_id)->first();
        
        // if (empty($detail->contact_number)) {
        //     $phone = Auth::guard('member')->user()->phone;
        //     $address = null;
        // } else {
        //     $phone = $detail->contact_number;
        //     $address = $detail->city . ' ' . $detail->address;
        // }

        $phone = Auth::guard('member')->user()->phone;
        $address = (!empty($detail->city) ? $detail->city . ' ' : '') . (!empty($detail->address) ? $detail->address: '');
        $content = $request->input('content');
        $uploads = is_array($request->input('uploads')) ? json_encode($request->input('uploads')) : $request->input('uploads');
        $buy_product_redeemed_id = $request->input('buy_product_redeemed_id');

        $this->tpn = new TracePhoneNumber();
        $res = $this->tpn->getLocation($phone);
        // var_dump($res);
        // var_dump($res['province']);
        // dd('sadsa');
        if (!empty($res['city'])) {
            // $address = (!empty($res['city']) ? ($res['city'] . ' - ') : '') . $res['province'];
            $address = $res['city'];
        }
        
        $arr = ['member_id' => $member_id, 'phone' => $phone, 'address' => $address, 'content' => $content, 'uploads' => $uploads, 'buy_product_redeemed_id' => $buy_product_redeemed_id];
        $data = $arr;
        $b = blog::updateOrCreate($arr,$data)->id;
        return ['success' => true]; 
            
    }

    public function listAll(Request $request)
    {        
        $page = empty($request->page) ? 1 : $request->page;
        $blog = blog::select('*')->whereNull('deleted_at')->orderBy('updated_at','desc')->paginate(10);       
        return response()->json(['success' => true, 'records' => $blog]);
    }
    public function listMy(Request $request)
    {        
        $page = empty($request->page) ? 1 : $request->page;
        $memberid = empty($request->memberid) ? 0 : $request->memberid;
        $blog = blog::select('*')->where('member_id',$memberid)->whereNull('deleted_at')->orderBy('updated_at','desc')->paginate(10);       
        return response()->json(['success' => true, 'records' => $blog]);
    }

    public function detail(Request $request)
    {
        $id = $request->id;
        $blog = null;

        if (!empty($id)) {
            $blog = v_blog_detail::select('*')->where('id',$id)->first();    
        }

        return view('client/blog_detail', compact('blog')); 
        
    }

    public function delete(Request $request)
    {
        $id = $request->id;
        $blog = blog::where('id', $id)->delete();

        return response()->json(['success' => true, 'records' => $blog]);
        
    }

    public static function getJson($url){
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); 
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE); 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);

        curl_close($ch);
        return json_decode($output, true);
    }
}

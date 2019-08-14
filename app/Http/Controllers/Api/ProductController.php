<?php

namespace App\Http\Controllers\Api;

use App\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Validator;
use Carbon\Carbon;
use App\Wallet;
use App\Product;
use App\Package;
class ProductController extends Controller
{
   
    public function parent() {
		return $this->belongsTo('App\Category', 'parent_id');
	}

	public function children() {
		return $this->hasMany('App\Category', 'parent_id'); 
	}
	
	public function list_package(Request $request)
    {
		$package =  Package::list_available_redeem_package();
		return response()->json(['success' => true,  'records' => $package]);
	}
	
	public function list_product_by_point(Request $request)
    {
		$member_id = $request->memberid;
		
		$wallet = Wallet::get_wallet_details($member_id);
		
		if ($wallet)
		{
			$result =  Product::list_available_redeem_product($wallet->point, 0);
			$package =  Package::list_available_redeem_package($wallet->point);
			
			return response()->json(['success' => true, 'current_point'=>$wallet->point , 'records' => $result, 'packages' => $package]);
		}
		return response()->json(['success' => false, 'records' => '']);
	}
	
	public function redeem_request(Request $request)
    {
		$member_id = $request->memberid;
		$wallet = Wallet::get_wallet_details($member_id);
		//check point
	}
	
	public function get_redeem_history(Request $request)
    {
		$member_id = $request->memberid;
		$result    = Product::get_redeem_history($member_id,30);		
		return response()->json(['success' => true, 'records' => $result]);
		
		//deprecated 
		return FALSE;
		$result    = Product::get_redeemlist_history($member_id,30);
		$result->getCollection()->transform(function ($value) {
			$code = $value->code;
			$passcode = $value->passcode;
			$value->code = null;
			$value->passcode = null;
			if ( $value->pin_status == 1 or $value->pin_status == 2 )
			{
				$value->code     = $code;
				$value->passcode = $passcode;
			}
			return $value;
		});		
		$package    = Package::get_vip_list($member_id); 		
		
		return response()->json(['success' => true, 'records' => $result, 'package' => $package]);
	}
	
	
	public function request_redeem(Request $request)
    {
		$memberid  = $request->memberid;
		
		$productid = $request->productid;		
		
		$input = [
			 'memberid'  => $request->memberid,
			 'productid' => $request->productid,			
			  ];
		$validator = Validator::make($input, 
			[
				'memberid' => 'required',
				'productid' => 'required'
			]
		);
		if ($validator->fails()) {
			return response()->json(['success' => false, 'message' => $validator->errors()->all()]);
		}
		
		$wallet    = Wallet::get_wallet_details($memberid);
		
		$product   = Product::get_available_pin($productid,$wallet->point);
		
		$setting   = \App\Admin::get_setting();
		
		
		if ($product)
		{
			$now = Carbon::now();
			
			//$pin_status = 4;
			
			$data = ['member_id'=>$memberid, 'request_at'=>$now,'used_point'=>$product->min_point];
			
			$data['pin_status'] = 4;
			
			if($setting->auto_product_redeem =='Y')
			{
				$data['pin_status']  = 2;
				//$data['redeemed_at'] = $now;
				$data['confirmed_at'] = $now;
			}			
			
			$wallet = Wallet::update_basic_wallet($memberid,0,$product->min_point, 'RPO','debit', $product->min_point.' Point used for buy product');

			Product::update_pin($product->id, $data);
			
			$refdata = [ 'id'=>$product->id, 'refid'=>$wallet['refid'], 'type'=>'product' ];
			Wallet::add_ledger_ref($refdata);
			
			return response()->json(['success' => true, 'message' => 'success']);
		}
		
		return response()->json(['success' => false, 'message' => 'insufficient point/pin not available']);
	}
	
	
	
	public function index(Request $request)
    {		
		$result = Product::get_ad_paginate(10);
		
		
		if ($request->ajax()) {
    		$view = view('ad.ajaxlist',compact('result'))->render();
            return response()->json(['html'=>$view]);
        }
		
		$productcount = $result->count();
        return view('ad.ad', compact('result','productcount'));
		
		
    }

    public function show(Request $request)
    {
		$result = Product::get_ad_paginate(10);
		
		$productcount = Category::all();
		
		if ($request->ajax()) {
    		$view = view('ad.ajaxlist',compact('result'))->render();
            return response()->json(['html'=>$view]);
        }
		
        return view('ad.ad', compact('result','productcount'));		
		
    }
	
	
	//package
	public function request_vip(Request $request)
    {
		$memberid  = $request->memberid;
		
		$packageid = $request->packageid;	
		
		$insdata = [];
		$card = $request->card;	
		
		$input = [
			 'memberid'  => $request->memberid,
			 'packageid' => $request->packageid,			
			  ];
		$validator = Validator::make($input, 
			[
				'memberid' => 'required',
				'packageid' => 'required'
			]
		);
		if ($validator->fails()) {
			return response()->json(['success' => false, 'message' => $validator->errors()->all()]);
		}
		
		$wallet    = Wallet::get_wallet_details($memberid);
		
		
		//$basic_count = \DB::table('basic_redeem')->where('member_id',$request->memberid)->count();
		$basic_count = \DB::table('view_basic_member_redeem_count')->where('member_id',$memberid)->first();
		$basic_count = $basic_count->used_quantity + $basic_count->reserved_quantity;
		
		if ($basic_count < 1)
		{
			return response()->json(['success' => false, 'message' => 'buy basic package before upgrade']);
			
			if ($wallet->point < 120)
			{
				return response()->json(['success' => false, 'message' => 'insufficient points to upgrade.']);
			}
		}
		
		$package   = Package::get_package($packageid);
		
		if (!$package) return response()->json(['success' => false, 'message' => 'unknown package']);
		
		$now = Carbon::now();
		switch ($package->package_type)
		{
			//flexi type
			case '1':
				if ($package->min_point <= $wallet->point)
				{
					
					$passcode = unique_random('vip_redeemed','passcode',8);
					
					$data = ['package_id'=>$package->id,'created_at'=>$now,'updated_at'=>$now,'member_id'=>$memberid,'redeem_state'=>2,'request_at'=>$now,'used_point'=>$package->min_point,'package_life'=>$package->package_life,'package_point'=>$package->package_freepoint,'confirmed_at'=>$now,'passcode'=>$passcode];
					
					$wallet = Wallet::update_basic_wallet($memberid,0,$package->min_point, 'BVP','debit', $package->min_point.' Point reserved for VIP package');

					$id = Package::save_vip_package($data);					
					
					$refdata = [ 'id'=>$id, 'refid'=>$wallet['refid'], 'type'=>'product' ];
					Wallet::add_ledger_ref($refdata);

					return response()->json(['success' => true, 'message' => 'success','refid'=>$id]);
				}
			break;
			
			//prepaid
			case '2':
				
				$data = ['package_id'=>$package->id,'created_at'=>$now,'updated_at'=>$now,'member_id'=>$memberid,'redeem_state'=>1,'request_at'=>$now,'used_point'=>0,'package_life'=>$package->package_life,'package_point'=>$package->package_freepoint,'ref_note'=>$request->ref_note];
				
				$id = Package::save_vip_package($data);
				
				return response()->json(['success' => true, 'message' => 'success','refid'=>$id]);
				
				/*
				$a = 0 ;
				$r = 0 ;
				$parepaid = explode(',',$card);
				foreach ($parepaid as $pcard)
				{
					$card = array_map('trim', explode(' ', $pcard));
					
					if (!empty($card[0]) && !empty($card[1]) )
					{
						$data = ['package_id'=>$package->id,'created_at'=>$now,'updated_at'=>$now,'member_id'=>$memberid,'redeem_state'=>1,'request_at'=>$now,'used_point'=>$package->min_point,'package_life'=>$package->package_life,'package_point'=>$package->package_freepoint,'cardnum'=>$card[0],'cardpass'=>$card[1]];
						
						$insdata[] = $data;
						$a++;
					}
					else{
						$r++;
					}
				}
				
				Package::save_manyvip_package($insdata);

				return response()->json(['success' => true, 'message' => 'success','rejected'=>$r,'added'=>$a]);
				*/
				
			break;	
		}		
		
		
		return response()->json(['success' => false, 'message' => 'unknown type/ package deleted']);
	}
	
	public function redeem_vip(Request $request)
    {
		$memberid  = $request->memberid;
		$passcode  = $request->passcode;
		
		$input = [
			 'memberid'  => $memberid,
			 'passcode'  => $passcode,
			  ];
		$validator = Validator::make($input, 
			[
				'memberid'  => 'required',
				'passcode'  => 'required'
			]
		);
		if ($validator->fails()) {
			return response()->json(['success' => false, 'message' => $validator->errors()->all()]);
		}
		
				
		$package   = Package::get_redeem_package_passcode($passcode, $memberid );
		
		if ($package)
		{
			$cpackage = Package::get_current_package($memberid);	
		
			if ($cpackage)
			{
				return response()->json(['success' => false, 'message' => 'user already entitled with VIP']);
			}
			
			if ($passcode === $package->passcode)
			{
				Wallet::update_vip_wallet($memberid,$package->package_life,$package->package_point,'RV');
				
				$now = Carbon::now();
				$data = ['redeem_state'=>3,'redeemed_at'=>$now];
						
				Package::update_vip($package->id, $data);
				
				return response()->json(['success' => true, 'message' => '']);
			}
			return response()->json(['success' => false, 'message' => 'wrong redeem code']);
		}
		
		return response()->json(['success' => false, 'message' => 'unknown vip package / user not authorise to use this package']);
	}	
	
	
	public function vip_redeem_condition(Request $request)
    {		
		$reset    = null;		
		$memberid = $request->memberid;	
		
		$package      = Package::get_current_package($memberid,'all');
		
		if (!$package) 
		{				
			return response()->json(['success' => false,  'message' => 'no active vip subscriptions']); 
		}
		$wallet       = Wallet::get_wallet_details_all($memberid);
		$redeemcount  = Package::get_redeemed_package_count($memberid);
		$redeemreward = Package::get_redeemed_package_reward($package->id,$memberid);
		
		//Rules are based on redeem_condition table
		
		$verifyrule   = \App\Admin::check_redeem_condition($redeemcount);
		
		
		//echo 'rc-';print_r($redeemcount);
		//echo 'rr-';print_r($redeemreward);
		//echo 'ru-';print_r($verifyrule);
		
		//return error message if user have vip life & didnt match the redeem criteria,
		if ($verifyrule){
			if ($redeemreward < $verifyrule->minimum_point)
			{
				if ($wallet->vip_life >= 1 )
				{ 
					return response()->json(['success' => false, 'message' => '你必须赢得'.$verifyrule->minimum_point.'积分','min_point'=>$verifyrule->minimum_point,'vip_point'=>$wallet->vip_point,'win_point'=>$redeemreward,'redeem_count'=>$redeemcount]); 
				}
			}
		}
		
		return response()->json(['success' => 'true','message' => 'eligible to withdraw','vip_point'=>$wallet->vip_point,'wabao_point'=>$wallet->current_point,'redeem_point'=>$wallet->vip_point]);  
		
	}	
	//check Setting table
	public function wabaofee(Request $request)
    {
		$setting   = \App\Admin::get_setting();
		return response()->json(['success' => 'true','wabaofee' => $setting->wabao_fee]); 
	}
	
	private function goodsid($id)
	{
		$curl = curl_init();
        $userAgent = 'Mozilla/5.0 (Windows NT 5.1; rv:31.0) Gecko/20100101 Firefox/31.0';
		$userAgent = 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/44.0.2403.89 Safari/537.36"';
        curl_setopt_array($curl, array(
            //CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => 'http://www.shimaigou.com/index.php?r=l/d&u=4413&id='.$id,
           // CURLOPT_USERAGENT => $userAgent,
			//CURLOPT_HEADER => 0,
           // CURLOPT_POST => 1,
			CURLOPT_VERBOSE => 0,
			CURLOPT_RETURNTRANSFER => 1,
            
        ));
        $resp = curl_exec($curl);        
       
        if($resp) { 
            $str  = '"goodsid":"';
			$arr  = explode($str, $resp);
			
			if (empty($arr[1])) 
			{
				return $id;
			}
			
			$arr  = explode('","title"', $arr[1]);	
			
			$id = $arr[0];
			return $id;
			
        } 
	}
	
	public function passcode(Request $request)
    {
		$id = $pid = $request->_keyword;
		if (!$id) return response()->json(['success' => 'false']); 
		//$record   = \App\Passcode::where('goodsid',$id)->first();
		$record   = \App\Passcode::where('pid',$id)->orwhere('goodsid',$id)->first();
		
		if ($record)
		{
			return response()->json(['success' => 'true','record' => $record]); 
		}
		
		$id    = $this->goodsid($id);
		if (empty($id))
		{
			return response()->json(['success' => 'false','message'=>'we cant find the ID']); 	
		}
		$url   = "http://item.taobao.com/item.htm?id=".$id;
		$data  = $this->getcurl($url);
		
		if ($data)
		{
			$data = ['passcode'=>$data,'goodsid'=>$id,'pid'=>$pid  ];
			$record   = \App\Passcode::create($data);
			return response()->json(['success' => 'true','record' => $data]); 
		}
		return response()->json(['success' => 'false']); 		
	}
	
	private function getcurl($keyword)
    {        
        //'https://detail.tmall.com/item.htm?id=579853855835',
        $curl = curl_init();
        $userAgent = 'Mozilla/5.0 (Windows NT 5.1; rv:31.0) Gecko/20100101 Firefox/31.0';
        curl_setopt_array($curl, array(
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => 'http://www.iwangshang.com/taokouling/index.php',
            CURLOPT_USERAGENT => $userAgent,
            CURLOPT_POST => 1,
            CURLOPT_POSTFIELDS => array(
                'keyword'=> $keyword,
            )
        ));
        
        $resp = curl_exec($curl);
        
        if($resp) {            
            return $this->filter_content( $resp );
        } 
    }
    
    private function filter_content($content) 
    {
        $str  = '<button class="itemCopy"';
		$arr  = explode($str, $content);
		$arr  = explode('</button', $arr[1]);	
		$from = '￥';
		$to   = '￥';
		$sub  = substr($arr[0], strpos($arr[0],$from)+strlen($from),strlen($arr[0]));
		$sub  = substr($sub,0,strpos($sub,$to));
		$sub  = trim($sub);
		
		if ($sub)
		{
			$sub = '￥'.$sub.'￥';
			return $sub;
		}		
        return FALSE;
    }
}

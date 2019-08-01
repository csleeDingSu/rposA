<?php
/***
 *
 *
 ***/

namespace App\Http\Controllers;
use App;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Wallet;
use App\Product;
use Carbon\Carbon;
use App\Package;


class ProductController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
	
	public $pagination_count = 100;
	
	public function show_product()
    {
		$result =  Product::get_ad_product_list(100);
		$data['page'] = 'ad.productlist'; 	
		$data['result'] = $result;
		
		return view('main', $data);		
	}
	
	public function add_ad_product()
    {
		$data['page'] = 'ad.addproduct'; 	
		
		return view('main', $data);		
	}
	
	
	
	public function save_ad_product(Request $request)
    {
    	$curentID = \DB::table('ad_display')->orderBy('id','desc')->first();

    	$product_display_id = isset($curentID->id) ? 1 : $curentID + 1; //$request->product_display_id;

		$validator = $this->validate(
            $request,
            [
                'product_name' => 'required|string|min:4',
				//'product_display_id' => 'required|integer|not_in:0|min:1|unique:product,product_display_id',
				'required_point' => 'required|numeric',
				'product_price' => 'numeric|between:0,99999.99',
				'discount_price' => 'numeric|between:0,99999.99',
				'product_quantity' => 'numeric|between:0,99999.99',	
				'product_image' => 'sometimes|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
				'product_picurl' => 'nullable|url',
            ]
        );	
		$now = Carbon::now();
		$imagename= '';
		if ($request->product_image)
		{
			$image = $request->file('product_image');
			$imagename = time().'.'.$image->getClientOriginalExtension();
			$destinationPath = public_path('ad/product_image');
			$image->move($destinationPath, $imagename);
		}
		
		$data = ['product_name' => $request->product_name,'product_quantity' => $request->product_quantity,'required_point' => $request->required_point,'product_status' => $request->status,'product_price' => $request->product_price,'discount_price' => $request->discount_price,'created_at' => $now,'product_picurl' => $request->product_picurl,'product_image' => $imagename,'product_description' => $request->product_description];
		
		Product::save_ad_product($data);
		
		return redirect()->back()->with('message', trans('dingsu.product_update_success_message') );
	}
	
	
	
	public function edit_ad_product($id = FALSE)
    {
		$data['record'] = $record = Product::get_ad_product($id);
		
		//print_r($record );die();
		
		$data['page'] = 'common.error';
		
		if ($record)
		{
			$data['page'] = 'ad.editproduct';
		}		
		
		return view('main', $data);
	}
	
	public function update_ad_product($id, Request $request)
    {
		$rules =  [
            'product_name'   => 'required|string|min:4',
			'required_point' => 'required|numeric',
			'product_price'  => 'numeric|between:0,99999.99',
			'discount_price' => 'numeric|between:0,99999.99',
			'product_quantity' => 'numeric|between:0,99999.99',
			'id'            => 'unique:product,id,'.$id,
			'product_image' => 'sometimes|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
			'product_picurl' => 'sometimes|url',
        ];
		
		
		$validator = $this->validate(
            $request,
            [
                $rules
            ]
        );	
		$now = Carbon::now();
		
		$data = ['product_name' => $request->product_name,'required_point' => $request->required_point,'product_status' => $request->status,'product_price' => $request->product_price,'discount_price' => $request->discount_price,'product_quantity' => $request->product_quantity,'created_at' => $now,'product_description' => $request->product_description,'product_picurl' => $request->product_picurl];
		
		
		if ($request->product_image)
		{
			$image = $request->file('product_image');
			$imagename = time().'.'.$image->getClientOriginalExtension();
			$destinationPath = public_path('ad/product_image');
			$image->move($destinationPath, $imagename);			
			
			$data['product_image'] = $imagename;
		}
				
		Product::update_ad_product($id, $data);		
			
		
		return redirect()->back()->with('message', trans('dingsu.product_update_success_message') );
		 
	}
	
	public function delete_ad_image(Request $request)
    {
		$id = $request->id;
		$data = ['product_image' => ''];
		Product::update_ad_product($id, $data);		
		return response()->json(['success' => true, 'message' => 'done']);
	}
	
	public function delete_ad_product(Request $request)
    {
		$id = $request->id;
		Product::delete_ad_product($id);
		return response()->json(['success' => true, 'message' => 'done']);
	}
	
	//old
	
	
	
	public function list_product()
    {
		$result =  Product::get_product_view_list(100);
		$data['page'] = 'product.productlist'; 	
		$data['result'] = $result;
		
		return view('main', $data);		
	}
	
	public function ajax_list_product()
    {
		$result =  Product::get_ajax_product_list();
		return response()->json(['success' => true, 'records' => $result]);
	}
	
	public function add_product()
    {
		$data['page'] = 'product.addproduct'; 	
		
		return view('main', $data);		
	}
	
	
	
	public function save_product(Request $request)
    {
		$validator = $this->validate(
            $request,
            [
                'product_name' => 'required|string|min:4',
				//'product_display_id' => 'required|integer|not_in:0|min:1|unique:product,product_display_id',
				'min_point' => 'required|numeric',
				'product_price' => 'numeric|between:0,99999.99',
				//'product_pic_url' => 'required',
            ]
        );	
		$now = Carbon::now();
		$product_display_name = unique_numeric_random('product', 'product_display_id', 4);
		$data = ['product_name' => $request->product_name,'product_display_id' => $product_display_name,'min_point' => $request->min_point,'product_status' => $request->status,'product_price' => $request->product_price,'created_at' => $now,'product_picurl' => $request->product_pic_url,'product_description' => $request->description];
		
		Product::save_product($data);
		
		return redirect()->back()->with('message', trans('dingsu.product_update_success_message') );
	}
	
	public function edit_product($id = FALSE)
    {
		$data['record'] = $record = Product::get_view_product($id);
		
		$data['page'] = 'common.error';
		
		if ($record)
		{
			$data['page'] = 'product.editproduct';
		}		
		
		return view('main', $data);
	}
	
	public function update_product($id, Request $request)
    {
		$validator = $this->validate(
            $request,
            [
                'product_name'  => 'required|string|min:4',
				'min_point'     => 'required|numeric',
				'product_price' => 'numeric|between:0,99999.99',
				'id'            => 'unique:product,id,'.$id,
				//'product_pic_url' => 'required',
            ]
        );	
		$now = Carbon::now();
		$data = ['product_name' => $request->product_name,'min_point' => $request->min_point,'product_status' => $request->status,'product_price' => $request->product_price,'created_at' => $now,'product_picurl' => $request->product_pic_url,'product_description' => $request->description];
		
		Product::update_product($id, $data);
		
		return redirect()->back()->with('message', trans('dingsu.product_update_success_message') );
		 
	}
	
	public function list_pins(Request $request)
    {
		$result =  \DB::table('view_softpins');
		$input = array();		
		parse_str($request->_data, $input);
		$input = array_map('trim', $input);
		
    	if ($input) 
		{
			//filter					
			if (!empty($input['s_product_name'])) {
				$result = $result->where('product_name','LIKE', "%{$input['s_product_name']}%") ;				
			}
			if (isset($input['s_status'])) {
				if ($input['s_status'] != '' )
					$result = $result->where('pin_status','=',$input['s_status']);
			}
		}
		
		$result =  $result->orderby('id','DESC')->paginate(30);
				
		$data['page'] = 'product.pinlist'; 	
				
		$data['result'] = $result; 
				
		if ($request->ajax()) {
            return view('product.pin_ajaxlist', ['result' => $result])->render();  
        }
					
		return view('main', $data);		
	}
	
	public function old_list_pins()
    {
		$result =  Product::get_pin_list_by_view(100);
		$data['page'] = 'product.pinlist'; 	
		$data['result'] = $result;		
		return view('main', $data);		
	}
	
	public function save_pins(Request $request)
    {
		
		$data = $request->_datav;
		
		foreach($data as $val)
		{
			
				$dbi[$val['name']] = $val['value'];
		
		}
		$input = [
					'product_id' => $dbi['product_list'], 
					'pin_name'   => $dbi['pin_name'],			 
					'code'       => $dbi['code'],
					'passcode'   => $dbi['passcode'],
					'code_hash'   => $dbi['code_hash'],
			  	 ];
		
		$validator = Validator::make($input, [
			'product_id'   => 'required|exists:product,id',
			'pin_name'     => 'required',
			'code'         => 'required|unique:softpins,code',
			'passcode'     => 'required|unique:softpins,passcode',
		]);
 
		
		
		if ($validator->fails()) {
			return response()->json(['success' => false, 'message' => $validator->errors()->all()]);
		}
		
		
		
		$now = Carbon::now();
		$data = ['product_id' => $input['product_id'],'pin_name' => $input['pin_name'],'code' => $input['code'],'passcode' => $input['passcode'],'created_at' => $now, 'code_hash' => $input['code_hash']];
		
		$id = Product::save_pin($data);
		
		
		$softpin = Product::get_pin($id);
		$row  = '<tr id=tr_'.$softpin->id.'>';
		$row .= "<td>$softpin->id</td>";
		$row .= "<td>$now</td>";		
		$row .= "<td>$softpin->expiry_at</td>";		
		$row .= '<td>'.$softpin->pin_name.'</td>';
		$row .= '<td>'.$softpin->product_name.'</td>';
		$row .= '<td>'.$softpin->code.'</td>';
		$row .= "<td><label class='badge badge-warning'>".trans('dingsu.active')."</label></td>";
		$row .= '<td><a href="javascript:void(0)" onClick="confirm_Delete('.$softpin->id.');return false;" class="btn btn-icons btn-rounded btn-outline-danger btn-inverse-danger"><i class=" icon-trash  "></i></a></td>';
		$row .= '</tr>';
		
		return response()->json(['success' => true, 'message' => trans('dingsu.softpin_update_success_message'),'record'=>$row]);
	}
	
	
	
	public function remove_pin(Request $request)
    {
		$id = $request->id;
		$record = Product::get_pin($id);
		
		if ($record)
		{
			if ($record->member_id)
			{
				return response()->json(['success' => false, 'message' => 'entitled with user']);
			}
			Product::delete_pin($record->id);
			return response()->json(['success' => true, 'record' => '']);
		}
		else{
			return response()->json(['success' => false, 'message' => 'unknown product']);
		}	
	}
	
	
	public function redeemed_list()
    {
		$result =  Product::get_redeemlist_by_view(100);
		$data['page'] = 'product.redeemlist'; 	
		$data['result'] = $result;		
		return view('main', $data);		
	}
	
	public function get_pending_redeemlist(Request $request)
    {
		$result =  \DB::table('view_pending_redeem')->where('pin_status',4);		
		
		$input = array();
		
		parse_str($request->_data, $input);
		$input = array_map('trim', $input);
		
    	if ($input) 
		{
			//filter					
			if (!empty($input['s_product_name'])) {
				$result = $result->where('product_name','LIKE', "%{$input['s_product_name']}%") ;
				
			}
			if (!empty($input['s_username'])) {
				$result = $result->where('username','LIKE', "%{$input['s_username']}%") ;				
			}
			if (!empty($input['s_phone'])) {
				$result = $result->where('phone','LIKE', "%{$input['s_phone']}%") ;				
			}
			if (!empty($input['s_wechat_name'])) {
				$result = $result->where('wechat_name','LIKE', "%{$input['s_wechat_name']}%") ;				
			}
		}
		$result =  $result->orderby('id','DESC')->paginate(30);
		
		$data['page'] = 'product.redeemlist'; 	
				
		$data['result'] = $result; 
		
		if ($request->ajax()) {
            return view('product.redeem_ajaxlist', ['result' => $result])->render();  
        }
					
		return view('main', $data);
	}
	
	public function old_get_pending_redeemlist()
    {
		$result =  Product::get_pending_redeemlist(100);
		$data['page'] = 'product.redeemlist'; 	
		$data['result'] = $result;		
		return view('main', $data);		
	}
	
	public function confirm_redeem(Request $request)
    {
		$id = $request->id;
		$record = Product::get_pin($id);
		
		if ($record)
		{
			$now = Carbon::now();
			$data = ['pin_status'=>2,'confirmed_at'=>$now];
			Product::update_pin($record->id, $data);
			return response()->json(['success' => true, 'message' => 'success']);
		}
		else{
			return response()->json(['success' => false, 'message' => 'unknown product']);
		}	
	}
	
	public function reject_redeem(Request $request)
    {
		$id = $request->id;
		$record = Product::get_pin($id);
		if ($record)
		{
			$now = Carbon::now();
			$data = ['pin_status'=>3,'confirmed_at'=>$now];						
			Wallet::update_basic_wallet($record->member_id, 0,$record->used_point, 'RFN','credit', 'redeem rejected,point refund to customer');			
			
			Product::update_pin($record->id, $data);
			return response()->json(['success' => true, 'message' => 'success']);
		}
		else{
			return response()->json(['success' => false, 'message' => 'unknown product']);
		}	
	}
	
	public function get_redeemhistory(Request $request)
    {
		$result =  \DB::table('view_redeem_history');	
		$input = array();
		
		parse_str($request->_data, $input);
		$input = array_map('trim', $input);
		
    	if ($input) 
		{
			//filter					
			if (!empty($input['s_product_name'])) {
				$result = $result->where('product_name','LIKE', "%{$input['s_product_name']}%") ;
				
			}
			if (!empty($input['s_username'])) {
				$result = $result->where('username','LIKE', "%{$input['s_username']}%") ;				
			}
			if (!empty($input['s_phone'])) {
				$result = $result->where('phone','LIKE', "%{$input['s_phone']}%") ;				
			}
			if (!empty($input['s_wechat_name'])) {
				$result = $result->where('wechat_name','LIKE', "%{$input['s_wechat_name']}%") ;				
			}
			if (isset($input['s_status'])) {
				if ($input['s_status'] != '' )
					$result = $result->where('redeem_state','=',$input['s_status']);
			}
		}
		
		$result =  $result->orderby('created_at','DESC')->paginate(30);
				
		$data['page'] = 'product.redeemhistory'; 	
				
		$data['result'] = $result; 		
		
		 if ($request->ajax()) {
            return view('product.redeemhistory_ajaxlist', ['result' => $result])->render();  
        }					
		return view('main', $data);
	}
	
	public function clean_ad_product()
    {
		Product::clean();
		return response()->json(['success' => true, 'message' => 'success']);
	}
	
	
	/*** package ***/
	public function list_package (Request $request)
	{
				
		$result =  \DB::table('view_package')->whereNull('deleted_at');
		$input = array();		
		parse_str($request->_data, $input);
		$input = array_map('trim', $input);
		
    	if ($input) 
		{
			//filter					
			if (!empty($input['s_name'])) {
				$result = $result->where('package_name','LIKE', "%{$input['s_name']}%") ;				
			}						
			if (isset($input['s_status'])) {
				if ($input['s_status'] != '' )
					$result = $result->where('package_status','=',$input['s_status']);
			}
		}		
		$result         =  $result->orderby('created_at','DESC')->paginate(30);
				
		$data['page']   = 'package.list'; 	
				
		$data['result'] = $result; 
				
		if ($request->ajax()) {
            return view('package.ajaxlist', ['result' => $result])->render();  
        }					
		return view('main', $data);	
	}
	
	public function updatepackage($input)
    {
		$id = $input['hidden_void'];
		
		$validator = Validator::make($input, [
			'package_name'   => 'required|string|min:2',
			'min_point' => 'required|numeric',
			'price' => 'numeric|between:0,99999.99',
			'package_pic_url' => 'required',
			'package_life' => 'sometimes|numeric|min:0',
			'package_freepoint' => 'sometimes|numeric|min:0',
		]);
 
		if ($validator->fails()) {
			return response()->json(['success' => false, 'message' => $validator->errors()->all()]);
		}
		
		$now = Carbon::now();
		$data = ['package_name' => $input['package_name'],'min_point' => $input['min_point'],'package_status' => $input['status'],'package_price' => $input['price'],'updated_at' => $now,'package_picurl' => $input['package_pic_url'],'package_description' => $input['package_description'], 'package_life' => $input['package_life'],
				 'package_freepoint' => $input['package_freepoint'] ];
		 
		Package::update_package($id,$data);
		$row = $this->render_package($id);
		return response()->json(['success' => true,'mode'=>'edit','dataval'=>$row]);
	}
	
	public function save_package(Request $request)
    {
		$input = array();		
		parse_str($request->_data, $input);
		$input = array_map('trim', $input);
		
		
		if ($input['mode'] =='edit')
		{
			return $this->updatepackage($input);
		}
		
		$validator = Validator::make($input, [
			'package_name'   => 'required|string|min:2',
			'min_point' => 'required|numeric',
			'price' => 'numeric|between:0,99999.99',
			'package_pic_url' => 'required',
			'package_life' => 'sometimes|numeric|min:0',
			'package_freepoint' => 'sometimes|numeric|min:0',
			'package_type' => 'required',
		]);
 
		if ($validator->fails()) {
			return response()->json(['success' => false, 'message' => $validator->errors()->all()]);
		}
		
		$now = Carbon::now();
		$data = ['package_name' => $input['package_name'],
				 'min_point' => $input['min_point'],
				 'package_status' => $input['status'],
				 'package_price' => $input['price'],
				 'created_at' => $now,
				 'package_picurl' => $input['package_pic_url'],
				 'package_description' => $input['package_description'],
				 'package_life' => $input['package_life'],
				 'package_freepoint' => $input['package_freepoint'] ,
				 'package_type' => $input['package_type'] 
				];
		 
		$id = Package::save_package($data);
		
		$row = $this->render_package($id);
		
		
		return response()->json(['success' => true, 'message' => trans('dingsu.new_package_success_message'),'record'=>$row]);
	}
	
	public function getpackage(Request $request)
	{
		$id = $request->id;
		$record = Package::get_package($id);
		return response()->json(['success' => true, 'record' => $record]);
	}
	public function delete_package(Request $request)
	{
		$id = $request->id;
		$record = Package::get_view_package($id);
		if ($record)
		{
			if ($record->reserved_quantity)
			{
				return response()->json(['success' => false, 'message' => 'entitled with user']);
			}
			//Package::delete_package($record->id);
			$now = Carbon::now();
			Package::update_package($id, ['deleted_at'=>$now, 'package_status'=> 3 ]);
			return response()->json(['success' => true, 'record' => '']);
		}
		else{
			return response()->json(['success' => false, 'message' => 'unknown package']);
		}	
	}
	
	public function render_package ($id)
	{
		$package = Package::get_package($id);
		$row  = '<tr id=tr_'.$package->id.'>';
		$row .= "<td>$package->id</td>";
		$row .= "<td>$package->created_at</td>";			
		$row .= '<td>'.$package->package_name.'</td>';
		$row .= '<td>'.$package->package_price.'</td>';
		$row .= '<td>'.$package->min_point.'</td>';
		
		//$row .= '<td>'.$package->available_quantity.'</td>';
		//$row .= '<td>'.$package->used_quantity.'</td>';
		//$row .= '<td>'.$package->rejected_quantity.'</td>';
		
		switch ($package->package_type)
			{
				case '1':
					$badge = "<label class='badge badge-success'>".trans('dingsu.flexi')."</label> ";
				break;
				case '2':
					$badge = "<label class='badge badge-warning'>".trans('dingsu.prepaid')."</label> ";
				break;				
					
			}
		$row .= "<td>$badge</td>";
		
		
		switch ($package->package_status)
			{
				case '1':
					$badge = "<label class='badge badge-success'>".trans('dingsu.active')."</label> ";
				break;
				case '2':
					$badge = "<label class='badge badge-warning'>".trans('dingsu.inactive')."</label> ";
				break;				
					
			}
		$row .= "<td>$badge</td>";
		
		$row .= '<td><a href="javascript:void(0)" data-id="'.$package->id.'" class="editrow btn btn-icons btn-rounded btn-outline-info btn-inverse-info"><i class=" icon-pencil "></i></a>
									
				<a href="javascript:void(0)" onClick="confirm_Delete('.$package->id.');return false;" class="btn btn-icons btn-rounded btn-outline-danger btn-inverse-danger"><i class=" icon-trash  "></i></a></td>';
		$row .= '</tr>';
		return $row;
	}
	
	public function list_redeem_package(Request $request)
    {
		$result =  \DB::table('view_pending_vip');		
		
		$input = array();
		
		parse_str($request->_data, $input);
		$input = array_map('trim', $input);
		
    	if ($input) 
		{
			//filter					
			if (!empty($input['s_package_name'])) {
				$result = $result->where('package_name','LIKE', "%{$input['s_package_name']}%") ;				
			}
			if (!empty($input['s_username'])) {
				$result = $result->where('username','LIKE', "%{$input['s_username']}%") ;				
			}
			if (!empty($input['s_phone'])) {
				$result = $result->where('phone','LIKE', "%{$input['s_phone']}%") ;				
			}
			if (!empty($input['s_wechat_name'])) {
				$result = $result->where('wechat_name','LIKE', "%{$input['s_wechat_name']}%") ;				
			}
		}
		
		//DB::enableQueryLog();
		
		$result =  $result->orderby('id','DESC')->paginate(30);
		
		//$queries = DB::getQueryLog();
		//print_r(DB::getQueryLog());
		//print_r($queries);
		
		
		//die();
		$data['page'] = 'package.pendinglist.list'; 	
				
		$data['result'] = $result; 
		
		if ($request->ajax()) {
            return view('package.pendinglist.ajaxlist', ['result' => $result])->render();  
        }
					
		return view('main', $data);
	}
	
		
	public function list_redeem_history(Request $request)
    {
		$result =  \DB::table('view_vip_list');		
		
		$input = array();
		
		parse_str($request->_data, $input);
		$input = array_map('trim', $input);
		
    	if ($input) 
		{
			//filter					
			if (!empty($input['s_package_name'])) {
				$result = $result->where('package_name','LIKE', "%{$input['s_package_name']}%") ;				
			}
			if (!empty($input['s_username'])) {
				$result = $result->where('username','LIKE', "%{$input['s_username']}%") ;				
			}
			if (!empty($input['s_phone'])) {
				$result = $result->where('phone','LIKE', "%{$input['s_phone']}%") ;				
			}
			if (!empty($input['s_wechat_name'])) {
				$result = $result->where('wechat_name','LIKE', "%{$input['s_wechat_name']}%") ;				
			}
		}
		
		$result =  $result->orderby('id','DESC')->paginate(30);
		
		$data['page'] = 'package.vip_history.list'; 	
				
		$data['result'] = $result; 
		
		
		 if ($request->ajax()) {
            return view('package.vip_history.ajaxlist', ['result' => $result])->render();  
        }
					
		return view('main', $data);
	}
	
	/**
	 * @todo:- get random length from config
	 *
	 **/
	public function confirm_vip(Request $request)
    {
		$id = $request->id;
		$record = Package::get_vip_package($id);
		
		if ($record)
		{
			$now = Carbon::now();
			$passcode = unique_random('vip_redeemed','passcode',8);
			$data = ['redeem_state'=>2,'confirmed_at'=>$now,'passcode'=>$passcode];
			Package::update_vip($record->id, $data);
			return response()->json(['success' => true, 'message' => 'success']);
		}
		else{
			return response()->json(['success' => false, 'message' => 'unknown product']);
		}	
	}
	
	public function reject_vip(Request $request)
    {
		//return false;
		$message = 'vip package rejected,point refund to customer';
		$id = $request->id;
		$record = Package::get_vip_package($id);
		if ($record)
		{
			$now = Carbon::now();
			$data = ['redeem_state'=>0,'confirmed_at'=>$now,'ref_note'=>$request->note];
			
			if (!empty($request->note))
			{
				$message = $request->note;
			}
						
			Wallet::update_basic_wallet($record->member_id, 0,$record->used_point, 'RFN','credit', $message);
			
			Package::update_vip($record->id, $data);
			
			return response()->json(['success' => true, 'message' => 'success']);
		}
		else{
			return response()->json(['success' => false, 'message' => 'unknown package']);
		}	
	}
	
	public function get_quantity (Request $request)
	{
		$id     = $request->input('id');
		$record = Package::get_available_quantity($id);
		return response()->json(['success' => true, 'record' => $record]);
	}
	

	public function adjust_quantity (Request $request)
	{	
		
		$input = array();		
		parse_str($request->_data, $input);
		$data = array_map('trim', $input);
		
		$id = $data['tid'];
		
		$record = Package::find($id);
		if ($record)
		{
			$quantity = $record->available_quantity + $data['add_quantity'];
			Package::update_package($id, ['available_quantity'=>$quantity ]);			
			
			return response()->json(['success' => true,'quantity'=>$quantity]);
		}
		
		return response()->json(['success' => false, 'message' => 'unknown record']);		
	}
}

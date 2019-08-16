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
use Auth;
use App\Wallet;

use Carbon\Carbon;
use App\BuyProduct;


class BuyProductController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
	
	public $pagination_count = 100;
	
	
	/*** Basic package ***/
	public function list_product (Request $request)
	{
				
		$result =  \DB::table('view_buy_product')->whereNull('deleted_at');
		$input = array();		
		parse_str($request->_data, $input);
		$input = array_map('trim', $input);
		
    	if ($input) 
		{
			//filter					
			if (!empty($input['s_name'])) {
				$result = $result->where('name','LIKE', "%{$input['s_name']}%") ;				
			}						
			if (isset($input['s_status'])) {
				if ($input['s_status'] != '' )
					$result = $result->where('status','=',$input['s_status']);
			}
			if (isset($input['s_type'])) {
				if ($input['s_type'] != '' )
					$result = $result->where('type','=',$input['s_type']);
			}
		}		
		$result         =  $result->orderby('created_at','DESC')->paginate(30);
		
		if ($request->ajax()) {
            return view('buyproduct.ajaxlist', ['result' => $result])->render();  
        }
				
		$data['page']   = 'buyproduct.list'; 	
				
		$data['result'] = $result; 
				
							
		return view('main', $data);	
	}
	
	/*
	public function updateproduct($input)
    {
		$id = $input['hidden_void'];
		
		$validator = Validator::make($input, [
			'name'   => 'required|string|min:2',
			'discount_price' => 'nullable|between:0,99999.99',
			'price' => 'numeric|between:0,99999.99',
			'picture_url' => 'required',
		]);
 
		if ($validator->fails()) {
			return response()->json(['success' => false, 'message' => $validator->errors()->all()]);
		}
		
		$now = Carbon::now();
		$product = new Buyproduct();
		$product->exists = true;
		$product->id = $id;
		$product->fill($input);
		$product->save();
		 
		//BuyProduct::update_product($id,$data);
		$row = $this->render_BuyProduct($product->id);
		return response()->json(['success' => true,'mode'=>'edit','dataval'=>$row]);
	}
	
	*/
		
	public function updateproduct($request)
    {
		$id = $request->hidden_void;
		
		$input = [
					'name'   => $request->name, 			 
					'discount_price' =>$request->discount_price,
					'price' =>$request->price,
					'picture_url' =>$request->picture_url,
					'product_image' =>$request->product_image,
			  	 ];
		
		
		$validator = Validator::make($input, [
			'name'   => 'required|string|min:2',
			'discount_price' => 'nullable|between:0,99999.99',
			'price' => 'numeric|between:0,99999.99',
			'picture_url' => 'required_without:product_image',
			'product_image' => 'required_without:picture_url',
		]);
 
		if ($validator->fails()) {
			return response()->json(['success' => false, 'message' => $validator->errors()->all()]);
		}
		
		$now = Carbon::now();
		$product = new Buyproduct();
		$product->exists = true;
		$product->id = $id;
		$product->fill($input);
		
		$image = $request->file('product_image');
		if ($image)
		{
			$imagename = time().'.'.$image->getClientOriginalExtension();
        	$destinationPath = public_path('product');
        	$image->move($destinationPath, $imagename);			
			$product->picture_url = url('/').'/product/'.$imagename;
		}
		$product->save();		 
		
		$row = $this->render_BuyProduct($product->id);
		return response()->json(['success' => true,'mode'=>'edit','dataval'=>$row]);
	}	
	
	public function save_product(Request $request)
    {	
		if ($request->mode =='edit')
		{
			return $this->updateproduct($request);
		}		
		$input = [
					'name'   => $request->name, 			 
					'discount_price' =>$request->discount_price,
					'price' =>$request->price,
					'picture_url' =>$request->picture_url,
					'product_image' =>$request->product_image,
			  	 ];
				
		$validator = Validator::make($input, [
			'name'   => 'required|string|min:2',
			'discount_price' => 'nullable|between:0,99999.99',
			'price' => 'numeric|between:0,99999.99',
			'picture_url' => 'required_without:product_image',
			'product_image' => 'required_without:picture_url',
			
		]);
 
		if ($validator->fails()) {
			return response()->json(['success' => false, 'message' => $validator->errors()]);
		}
		
		$product = new Buyproduct();
		$product->fill($input);
		
		$image = $request->file('product_image');
		if ($image)
		{
			$imagename = time().'.'.$image->getClientOriginalExtension();
        	$destinationPath = public_path('product');
        	$image->move($destinationPath, $imagename);
			$product->picture_url = url('/').'/product/'.$imagename;
		}		
		$now  = Carbon::now();
		$product->save();
		
		$id = $product->id;
		
		$row = $this->render_BuyProduct($id);		
		
		return response()->json(['success' => true, 'message' => trans('dingsu.new_package_success_message'),'record'=>$row]);
	}
	
	/*
	public function save_product(Request $request)
    {
		$input = array();		
		parse_str($request->_data, $input);
		$input = array_map('trim', $input);
		
		
		if ($input['mode'] =='edit')
		{
			return $this->updateproduct($input);
		}
		
		$validator = Validator::make($input, [
			'name'   => 'required|string|min:2',
			'discount_price' => 'nullable|between:0,99999.99',
			'price' => 'numeric|between:0,99999.99',
			'picture_url' => 'required',
		]);
 
		if ($validator->fails()) {
			return response()->json(['success' => false, 'message' => $validator->errors()->all()]);
		}
		
		$now  = Carbon::now();
		
		$product = new Buyproduct();
		$product->fill($input);
		$product->save();
		
		//print_r($product->id);die();
		
		$id = $product->id;
		
		/*
		$data = BuyProduct::fill($request->all());
		$datad = ['name' => $input['name'],
				 'package_discount_price' => $input['package_discount_price'],
				 'status' => $input['status'],
				 'package_price' => $input['price'],
				 'created_at' => $now,
				 'package_picurl' => $input['package_pic_url'],
				 'package_description' => $input['package_description'],
				 'package_life' => $input['package_life'],
				 'package_freepoint' => $input['package_freepoint'] ,
				 'package_type' => 1 
				];
		 
		$id = BuyProduct::save_package($data);
		*/
		$row = $this->render_BuyProduct($id);
		
		
		return response()->json(['success' => true, 'message' => trans('dingsu.new_package_success_message'),'record'=>$row]);
	}
	*/
	public function getBuyProduct(Request $request)
	{
		$id = $request->id;
		$record = BuyProduct::get_product($id);
		return response()->json(['success' => true, 'record' => $record]);
	}
	public function delete_product(Request $request)
	{
		$id = $request->id;
		$record = BuyProduct::get_view_product($id);
		if ($record)
		{
			if ($record->reserved_quantity)
			{
				return response()->json(['success' => false, 'message' => 'entitled with user']);
			}
			//Package::delete_package($record->id);
			$now = Carbon::now();
			BuyProduct::update_product($id, ['deleted_at'=>$now, 'status'=> 3 ]);
			return response()->json(['success' => true, 'record' => '']);
		}
		else{
			return response()->json(['success' => false, 'message' => 'unknown package']);
		}	
	}
	
	public function render_BuyProduct ($id)
	{
		$package = BuyProduct::get_product($id);
		
		switch ($package->type)
		{
			case '1':
				$package->type = "<label class='badge badge-success'>".trans('dingsu.virtual_card')."</label> ";
			break;
			case '2':
				$package->type = "<label class='badge badge-info'>".trans('dingsu.product')."</label> ";
			break;				

		}
		
		
		$row  = '<tr id=tr_'.$package->id.'>';
		$row .= "<td>$package->id</td>";
		$row .= "<td>$package->created_at</td>";		
		$row .= "<td>$package->type</td>";	
		$row .= "<td><img class='img-sm rounded-circle' src='$package->picture_url' alt='image'></td>";			
		$row .= '<td>'.$package->name.'</td>';
		$row .= '<td>'.$package->price.'</td>';
		$row .= "<td>$package->point_to_redeem</td>";
		$row .= "<td>$package->available_quantity</td>";
		$row .= "<td>$package->used_quantity</td>";
		$row .= "<td>$package->reserved_quantity</td>";
		
		switch ($package->status)
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
	
	public function list_redeem_product(Request $request)
    {
		$result =  \DB::table('view_buy_product_pending');		
		
		$input = array();
		
		parse_str($request->_data, $input);
		$input = array_map('trim', $input);
		
    	if ($input) 
		{
			//filter					
			if (!empty($input['s_product'])) {
				$result = $result->where('name','LIKE', "%{$input['s_product']}%") ;				
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
		$data['page'] = 'buyproduct.pendinglist.list'; 	
				
		$data['result'] = $result; 
		
		if ($request->ajax()) {
            return view('buyproduct.pendinglist.ajaxlist', ['result' => $result])->render();  
        }
					
		return view('main', $data);
	}
	
		
	public function list_product_history(Request $request)
    {
		$result =  \DB::table('view_buy_product_user_list');		
		
		$input = array();
		
		parse_str($request->_data, $input);
		$input = array_map('trim', $input);
		
    	if ($input) 
		{
			//filter					
			if (!empty($input['s_product'])) {
				$result = $result->where('name','LIKE', "%{$input['s_product']}%") ;				
			}
			if (!empty($input['s_phone'])) {
				$result = $result->where('phone','LIKE', "%{$input['s_phone']}%") ;				
			}
			if (isset($input['s_status'])) {
				if ($input['s_status'] != '' )
					$result = $result->where('redeem_state','=',$input['s_status']);
			}
			if (!empty($input['s_wechat_name'])) {
				$result = $result->where('wechat_name','LIKE', "%{$input['s_wechat_name']}%") ;				
			}
		}
		
		$result =  $result->orderby('id','DESC')->paginate(30);
		
		$data['page'] = 'buyproduct.history.list'; 	
				
		$data['result'] = $result; 
		
		
		 if ($request->ajax()) {
            return view('buyproduct.history.ajaxlist', ['result' => $result])->render();  
        }
					
		return view('main', $data);
	}
	
	public function update_redeem_buyproduct(Request $request)
    {
    	$id = $request->id;
		$record = \App\RedeemedProduct::with('product','order_detail','shipping_detail')->where('id', $id)->first();
		if ($record)
		{
		}
    }

    public function get_shipping_detail(Request $request)
    {
    	$id = $request->id;
    	$result = \App\ShippingDetail::where('order_id', $id)->first();
    	return response()->json(['success' => true,'result'=>$result]);
    }


	public function render_card_detail(Request $request)
    {
    	$id       = $request->id;
		$record   = \App\RedeemedProduct::with('product','order_detail','shipping_detail')->where('id', $id)->first();
		$product  = $record->product;
		$order    = $record->order_detail;
		$shipping = $record->shipping_detail;
		switch ($product->type)
		{
			case '1':
				$dd =  view('buyproduct.pendinglist.render_card_detail', ['result' => $order, 'orderid' => $id])->render();
			break;
			case '2':
				$dd =  view('buyproduct.pendinglist.render_shipping_detail', ['result' => $shipping, 'orderid' => $id])->render();
			break;
		}				
		return response()->json(['success' => true,'data'=>$dd]);
    }
    
	
	public function confirm_product(Request $request)
    {
		parse_str($request->_data, $input);
		$input = array_map('trim', $input);
		
		$id = $input['rid'];
		$record  = \App\RedeemedProduct::with('product','order_detail','shipping_detail')->where('id', $id)->first();
		$order   = $record->order_detail;
		$product = $record->product;
		$shi_de  = $record->shipping_detail;
		$card = [];
		if ($record)
		{			
			$quantity = $record->quantity;
			switch ($product->type)
			{
				case '1':					
					$validate_array = [];
					for($i=0;$i<$quantity;$i++) {
						$validate_array['card_num_'. $order[$i]->id ]  = 'required';
						$validate_array['card_pass_'. $order[$i]->id ] = 'required';
					}					
					$validator = Validator::make($input,$validate_array );
					if ($validator->fails()) {
						return response()->json(['success' => false, 'message' => $validator->errors()]);
					}
					
					for($i=0;$i<$quantity;$i++) 
					{
						$card    = ['card_num'=> $input['card_num_'.$order[$i]->id],'card_pass'=>$input['card_pass_'.$order[$i]->id]];
						
						$card_up = new \App\OrderDetail();
						$card_up->exists = true;
						$card_up->id = $order[$i]->id ;
						$card_up->fill($card);
						$card_up->save();
					}
					
				break;
				case '2':
					
					$validator = Validator::make($input, [
						// 'position'       => 'required|numeric|min:1|max:99|unique:redeem_condition,position,'.$id,
						// 'minimum_point'  => 'required|numeric|min:1|max:9999',						
						
						//'shipping_method'      => 'required',
						'address'              => 'required',
						//'unit_detail'          => 'required',
						//'city'                 => 'required',
						//'zip'                  => 'required',
						//'country'              => 'required',
						'tracking_number'      => 'required',
						//'notes'                => 'required',
						'tracking_partner'     => 'required',
						'contact_number'        => 'required',						
						'receiver_name'        => 'required',
						//'alternative_contact_number'  => 'required',
						
					]);
					if ($validator->fails()) {
						return response()->json(['success' => false, 'message' => $validator->errors()]);
					}
					$shi_de = $shi_de[0];				

					$sdetails = new \App\ShippingDetail();
					$sdetails->exists = true;
					$sdetails->id = $shi_de->id;
					$sdetails->fill($input);
					$sdetails->save();
				break;
			}

			$now = Carbon::now();
			$data = ['redeem_state'=>3,'confirmed_at'=>$now,'redeemed_at'=>$now];
			BuyProduct::update_redeemed($record->id, $data);
			
		//	Wallet::update_basic_wallet($record->member_id,$record->package_life,$record->package_point,'BPR');			
			
			return response()->json(['success' => true, 'message' => 'success']);
		}
		else{
			return response()->json(['success' => false, 'message' => 'unknown product']);
		}	
	}
	
	public function reject_product(Request $request)
    {
		$id = $request->id;
		//$record = BuyProduct::get_basic_package($id);
		$record = \App\RedeemedProduct::with('product','order_detail','shipping_detail')->where('id', $id)->first();
		if ($record)
		{
			$now = Carbon::now();
			$data = ['redeem_state'=>0,'confirmed_at'=>$now,'reject_notes'=>$request->reason];		
			
			Wallet::update_basic_wallet($record->member_id, 0,$record->used_point, 'RBP','credit', 'redeem product rejected,point refund to customer');
			
			BuyProduct::update_redeemed($record->id, $data);
			
			return response()->json(['success' => true, 'message' => 'success']);
		}
		else{
			return response()->json(['success' => false, 'message' => 'unknown package']);
		}	
	}
	
	public function get_BuyProduct_quantity (Request $request)
	{
		$id     = $request->input('id');
		$record = BuyProduct::get_available_quantity($id);
		return response()->json(['success' => true, 'record' => $record]);
	}
	

	public function adjust_BuyProduct_quantity (Request $request)
	{	
		
		$input = array();		
		parse_str($request->_data, $input);
		$data = array_map('trim', $input);
		
		$id = $data['tid'];
		
		$record = BuyProduct::find($id);
		if ($record)
		{
			$quantity = $record->available_quantity + $data['add_quantity'];
			BuyProduct::update_product($id, ['available_quantity'=>$quantity ]);			
			
			return response()->json(['success' => true,'quantity'=>$quantity]);
		}
		
		return response()->json(['success' => false, 'message' => 'unknown record']);		
	}
	
	
	public function backorder()
    {
		$data['page']    = 'buyproduct.backorder';
		$data['package'] = BuyProduct::where('status',1)->get(); 
		
		return view('main', $data);		
	}
	
	public function confirm_backorder(Request $request)
	{
		$insdata   = [];
		
		$validator = $this->validate($request, 
			[
				'package' => 'required',
				'phone'   => 'required|exists:members,phone',
			]
		);
		
		$member = \App\Members::where('phone',$request->phone)->first();
		
		$package = BuyProduct::where('id',$request->package)->first();
		
		if ($package)
		{
			$usedprice = $package->package_price; 		
			
			if ($request->discount_price)
			{
				$usedprice = $request->discount_price;
			}
			
			$passcode = unique_random('basic_redeemed','passcode',8);
			
			$now = Carbon::now();
			
			$data = ['package_id'=>$package->id,'created_at'=>$now,'updated_at'=>$now,'member_id'=>$member->id,'redeem_state'=>3,'confirmed_at'=>$now,'request_at'=>$now,'used_point'=>0,'package_life'=>$package->package_life,'package_point'=>$package->package_freepoint,'ref_note'=>'backorder','buy_price'=>$usedprice,'cardpass'=>$request->cardpass,'cardnum'=>$request->cardnum,'passcode'=>$passcode,'redeemed_at'=>$now,'created_by'=>\Auth::guard('admin')->user()->name];
			
			
			Wallet::update_basic_wallet($member->id,$package->package_life,$package->package_freepoint,'BPR','credit','BackOrder');
			
			BuyProduct::save_redeemed($data);

			return response()->json(['success' => true, 'message' => 'success']);
			
						
		}
		else{
			return response()->json(['success' => false, 'message' => 'unknown product']);
		}	
	}

	public function confirm(Request $request){
		$id = $request->hid_package_id;
		$record = BuyProduct::get_product($id);	
		$member = Auth::guard('member')->user()->id	;		
		$wallet = Wallet::get_wallet_details($member);
		return view( 'client/confirm', ['request' => $request, 'record' => $record, 'wallet' => $wallet]);
	}

	public function buy(Request $request){
		$id = $request->hid_package_id;
		$record = BuyProduct::get_product($id);
		if($record->type == 1){
			$member = Auth::guard('member')->user()->id	;		
			$wallet = Wallet::get_wallet_details($member);
			return view( 'client/confirm', ['request' => $request, 'record' => $record, 'wallet' => $wallet]);
		} else {
			return view( 'client/buy', ['request' => $request]);
		}
	}
}

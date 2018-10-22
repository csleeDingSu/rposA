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



class ProductController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
	
	public $pagination_count = 100;
	
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
				'product_display_id' => 'required|integer|not_in:0|min:1|unique:product,product_display_id',
				'min_point' => 'required|numeric',
				'product_price' => 'numeric|between:0,99999.99',
            ]
        );	
		$now = Carbon::now();
		$data = ['product_name' => $request->product_name,'product_display_id' => $request->product_display_name,'min_point' => $request->min_point,'product_status' => $request->status,'product_price' => $request->product_price,'created_at' => $now];
		
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
				'id'            => 'unique:product,id,'.$id
            ]
        );	
		$now = Carbon::now();
		$data = ['product_name' => $request->product_name,'min_point' => $request->min_point,'product_status' => $request->status,'product_price' => $request->product_price,'created_at' => $now];
		
		Product::update_product($id, $data);
		
		return redirect()->back()->with('message', trans('dingsu.product_update_success_message') );
		 
	}
	
	
	public function list_pins()
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
					'code_hash'  => $dbi['code_hash'],
			  	 ];
		
		$validator = Validator::make($input, [
			'product_id'   => 'required|exists:product,id',
			'pin_name'     => 'required',
			'code'         => 'required|unique:softpins,code',
			'code_hash'    => 'required',
		]);
 
		
		
		if ($validator->fails()) {
			return response()->json(['success' => false, 'message' => $validator->errors()->all()]);
		}
		
		
		
		$now = Carbon::now();
		$data = ['product_id' => $input['product_id'],'pin_name' => $input['pin_name'],'code' => $input['code'],'code_hash' => $input['code_hash'],'created_at' => $now];
		
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
	
	public function get_pending_redeemlist()
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
			$data = ['pin_status'=>2,'confimed_at'=>$now];
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
			$data = ['pin_status'=>3,'confimed_at'=>$now];
						
			Wallet::update_ledger($record->memberid,'credit',$record->used_point,'PNT','redeem rejected,point refund to customer');
			
			Product::update_pin($record->id, $data);
			return response()->json(['success' => true, 'message' => 'success']);
		}
		else{
			return response()->json(['success' => false, 'message' => 'unknown product']);
		}	
	}
	
	
	public function test()
    {
	}
	
}

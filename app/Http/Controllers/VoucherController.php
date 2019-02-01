<?php
/***
 *
 *
 ***/

namespace App\Http\Controllers;
use DB;
use App;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

use App\Voucher;
use App\Unreleasedvouchers;
use Carbon\Carbon;




class VoucherController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
	
	public function destroy_unr_voucher($id)
	{
		$record = Unreleasedvouchers::find($id);
		if ($record)
		{
			$now = Carbon::now()->toDateTimeString();
			$record['source_type'] = '2'; 
			$record['created_at']  = $now; 
			$record['updated_at']  = $now; 
			unset($record['id']);
			unset($record['source_file']);
            Voucher::archived_vouchers_insert($record);
			Unreleasedvouchers::destroy($id);
			return response()->json(['success' => true, 'record' => '']);
		}
		else{
			return response()->json(['success' => false, 'record' => '']);
		}
		
	}
	
	
	public function destroy($id)
	{		
		$record = Voucher::find($id);
		if ($record)
		{
			$now = Carbon::now()->toDateTimeString();
			$record['source_type'] = '1'; 
			$record['created_at']  = $now; 
			$record['updated_at']  = $now; 
			
			
			unset($record['id']);
			unset($record['source_file']);
            Voucher::archived_vouchers_insert($record);
			Voucher::destroy($id);
			return response()->json(['success' => true, 'record' => '']);
		}
		return response()->json(['success' => false, 'record' => '']);
	}
	// public function get_voucher_list()
	// {		
	// 	$result =  DB::table('vouchers')->latest()->paginate(200);
	// 	$data['page'] = 'voucher.voucherlist'; 
	// 	$data['sys_title']  = Voucher::get_csvtitle();
	// 	$data['category']  = Voucher::get_category();  		
	// 	$data['result'] = $result;
		
	// 	return view('main', $data);
	// }
	
	public function edit_voucher ($id = FALSE)
	{
		$data['record'] = $record = Voucher::find($id);
		
		$data['page'] = 'common.error';
		
		if ($record)
		{
			$data['page'] = 'voucher.edit_voucher';
			$data['category']  = Voucher::get_category();  
			
			$data['sys_title']  = Voucher::get_csvtitle(); 
		}


		return view('main', $data);
	}
	
	public function update_voucher ($id,Request $request)
	{
		$insdata = array();
		/*
		$validator = $this->validate(
            $request,
            [
                'firstname' => 'required|string|min:4',
				'email' => 'required|email|unique:members,email,'.$id,
            ]
        );
		*/
				
		$inputs = $request->vi;
		
		$systit = $request->sys_tit;
		
		foreach ($systit as $key=>$val)
		{
			$insdata[$val] = $inputs[$key];
			
		}
		 $msg = Voucher::where('id', '=', $id)->update($insdata);
		if ($msg) return redirect()->back()->with('message', trans('dingsu.voucher_update_success_message') );
		else return redirect()->back()->with('error', trans('dingsu.voucher_update_error_message') );
		
	}
	
	
	
	public function post_unreleasedvoucher_list()
	{
		return Voucher::search($request, 'unreleased');
	}
	public function get_unreleasedvoucher_list()
	{
		
		
		$result =  DB::table('unreleased_vouchers')->latest()->paginate(204);
		$data['page'] = 'voucher.unreleasedvoucherlist'; 	
		$data['files'] =  DB::table('excel_upload')->select('filename')->distinct()->get();
		$data['sys_title']  = Voucher::get_csvtitle(); 
		
		$data['result'] = $result;
		
		return view('main', $data);
	}
	public function check_voucher_duplicate()
	{
		//check_dulicate
		$result = Voucher::check_duplicate();
		
		if ($result)
		{
			$out = $result[0];
			if ($out->duplicate_count>0)
			{
				echo '<code class="text-danger text-bold display-3"><mark><a href="/voucher/showduplicate">'.$out->duplicate_count.'</a></mark></code>';
			}
		}
		else
		{
			return response()->json(['success' => false]);
		}
	}
	
	public function check_unrvoucher_duplicate()
	{
		//check_dulicate
		$result = Unreleasedvouchers::check_duplicate();
		
		if ($result)
		{
			$out = $result[0];
			if ($out->duplicate_count>0)
			{
				echo '<code class="text-danger text-bold display-3"><mark><a href="/voucher/un-
				duplicate">'.$out->duplicate_count.'</a></mark></code>';
			}
		}
		else
		{
			return response()->json(['success' => true]);
		}
	}
	
	public function remove_unrvoucher_duplicate()
	{
		Unreleasedvouchers::remove_duplicate();
		//sleep(2);
		return response()->json(['success' => true]);
	}
	
	public function remove_voucher_duplicate()
	{
		Voucher::remove_duplicate();
		return response()->json(['success' => true]);
	}
	
	
	public function publishvoucher ($id)
	{
		
		$record = Unreleasedvouchers::find($id);
		if ($record)
		{
			$item['id'] = null; 
			unset($item['source_file']);
            Voucher::insert($item);
			Unreleasedvouchers::destroy($id);
			return response()->json(['success' => true]);
		}
		return response()->json(['success' => true]);
	}
	public function publishfile ($filename)
	{
		
		if (empty($filename)) return response()->json(['success' => false]);	
		$items = Unreleasedvouchers::where('source_file', '=', $filename )->get()->toArray();
        foreach ($items as $item) 
        {
            $item['id'] = null; 
			unset($item['source_file']);
            Voucher::insert($item);
        }
		
		Unreleasedvouchers::where('source_file', '=', $filename)->delete();
		$dd = Voucher::delete_excel_upload($filename);
		
		return response()->json(['success' => true]);
	}
	
	public function bulkdata_update (Request $request)
	{
		
		$dbi = array();
		$insdata = array();
		$data = $request->_data;
		$type = $request->_type;
		
		
		foreach($data as $val)
		{
			if ($val['value'] == 1)
			{
				$dbi[] = $val['name'];
			}
		}
		//DB::enableQueryLog();
		$models = Voucher::whereIn('id', $dbi)->get();
		//print_r(DB::getQueryLog());
		
		$now = Carbon::now()->toDateTimeString();
		
		switch ($type)
		{
			
			case 'delete':
				Voucher::destroy($dbi);
				print_r($dbi);
				die();
			break;	
			// case 'tag':
			// 	Voucher::tag_voucher($id, $data);
			// break;	
		}
		
		echo json_encode($dbi);
	
	}
	
	public function bulkdata_unrv_update (Request $request)
	{
		
		$dbi = array();
		$insdata = array();
		$data = $request->_data;
		$type = $request->_type;
		
		foreach($data as $val)
		{
			if ($val['value'] == 1)
			{
				$dbi[] = $val['name'];
			}
		}
		//DB::enableQueryLog();
		$models = Unreleasedvouchers::whereIn('id', $dbi)->get();
		//print_r(DB::getQueryLog());
		
		
		
		$now = Carbon::now()->toDateTimeString();
		
		foreach ($models as $row)
		{
			if ($type != 'move') {
				$row['source_type'] = '1'; 
				unset($row['source_file']);
			}
			
			$row['created_at']  = $now; 
			$row['updated_at']  = $now; 
			unset($row['id']);
			
			$insdata[] = $row;
		}
		
		switch ($type)
		{
			case 'move':
				//move data to voucher table
				Voucher::vouchers_insert($models);
			break;
			case 'delete':
				Voucher::archived_vouchers_insert($models);
			break;	
		}
		Unreleasedvouchers::destroy($dbi);
		
		echo json_encode($dbi);
	
	}



	public function listvoucher (Request $request)
	{
		
		//$data['record']  = Admin::get_faq();
		
		
		//$result =  \DB::table('tips');
		$result =  \DB::table('vouchers');
		$data['page'] = 'voucher.list'; 
		$data['sys_title']  = Voucher::get_csvtitle();
		$data['category']  = Voucher::get_category();
		//$data['category']  = Voucher::get_category();
		$category = $data['category'];  		
		//$data['tags'] = Voucher::get_categorytag($id);

		$data['result'] = $result;


		
		

		//$result =  DB::table('vouchers')->latest()->paginate(200);
	// 	$data['page'] = 'voucher.voucherlist'; 
	// 	$data['sys_title']  = Voucher::get_csvtitle();
	// 	$data['category']  = Voucher::get_category();  		
	// 	$data['result'] = $result;
		
	// 	return view('main', $data);

	
		$input = array();		
		parse_str($request->_data, $input);
		$input = array_map('trim', $input);
		
    	if ($input) 
		{
			//filter					
			if (!empty($input['s_title'])) {
				$result = $result->where('product_category','LIKE', "%{$input['s_title']}%") ;				
			}
		}


		// public function getfaq(Request $request)
		// {
		// 	$id = $request->id;
		// 	$record = Admin::get_faq($id);
		// 	return response()->json(['success' => true, 'record' => $record]);
		// }



		
		$result =  $result->orderby('id','DESC')->paginate(200);
		//$result =  $result->orderby('id','DESC')->paginate(30);
				
		$data['page']    = 'voucher.list'; 	
				
		$data['result'] = $result; 
				
		if ($request->ajax()) {
			return view('voucher.ajaxlist', ['result' => $result, 'category' =>$category])->render();  

        }
					
		return view('main', $data);
		
		
	}




	public function show_voucher ($id)
	{
		$record = Voucher::find($id);
		if ($record)
		{
			$syscategory = Voucher::get_category()->toArray();
			$tagcategory = Voucher::get_categorytag($id)->toArray();
			$temp = ['record'=>$record,'syscategory'=>$syscategory,'tagcategory'=>$tagcategory];
			return response()->json(['success' => true, 'record' => $record,'syscategory'=>$syscategory,'tagcategory'=>$tagcategory]);			
		} else {
			return response()->json(['success' => false, 'record' => 'empty']);	
		}
	}
	
	public function show_unreleased_voucher ($id)
	{
		$record = Unreleasedvouchers::find($id);		
		if ($record)
		{
			$syscategory = Voucher::get_category()->toArray();
			return response()->json(['success' => true, 'record' => $record,'syscategory'=>$syscategory]);
		}		
		return response()->json(['success' => false]);
		//$record = DB::table('unreleased_vouchers')->where('id', $id)->first();
	}
	
	
		
	public function ajax_update_voucher (Request $request)
	{
		$now = Carbon::now()->toDateTimeString();
		$data = $request->_data;
		$id   = $request->id;
		$insdata = array();
		$tagdata = array();
		$datat = array();
		$arr_system_category = [];
		$record = Voucher::find($id);
		
		if ($record)
		{			
			foreach($data as $key=>$val)
			{

				$insdata[$val['name']] = $val['value'];
				$insdata['created_at']  = $now; 
				$insdata['updated_at']  = $now; 
				if ($val['name'] == 'system_category[]') {

					$arr_system_category[] = $val['value'];

				}
				
			}
			//$tagdata['category']= implode(",", $arr_system_category);


			//$datat =$tagdata['category'];

			
			

			//var_dump($arr_system_category);

			if (is_array($arr_system_category))
			{
				//var_dump("done");
				$tagdata['category']= implode(",", $arr_system_category);
				var_dump($tagdata['category']);
				foreach ($arr_system_category as $data_)
				{
					
					//var_dump("done2");

					
					//if (!is_null($data_['value'])) {
						$temp_t['voucher_id'] = $id;
						$temp_t['created_at']  = $now; 
						
						$temp_t['category'] = $data_;
						DB::table('voucher_category')
							 ->insert($temp_t);
							 
							 
						
					//}
				
				}
			}
					

			var_dump($arr_system_category);
			var_dump($temp_t['category']);
			var_dump($temp_t);

			unset($insdata['system_category[]']);
			unset($insdata['category[]']);
			unset($insdata['_token']);
			unset($insdata['hidden_void']);

			DB::enableQueryLog();
			 try {
				DB::table('vouchers')
				->where('id', $id)
				->update($insdata);

				 DB::table('voucher_category')
				->where('id', $id)
				->update($insdata);
				 return response()->json(['success' => true]);

			}  catch (\Exception $ex) {
				 //dd($ex);
				 return response()->json(['success' => false, 'record' =>'']);
			}
		}
		return response()->json(['success' => false, 'record' => '']);		
	}

	public function ajax_update_tag(Request $request)
	{
		$now = Carbon::now()->toDateTimeString();
		$dbi = array();
		$insdata = array();
		$indata = array();
		$data = $request->_data;
		$datat = $request->_datat;
		$arr_tag = [];
		$tag =  DB::table('voucher_category')->select(['id', 'created_at','voucher_id','category']);		
		//$tag = Voucher::get_categorytag();

		
		foreach($data as $val)
		{
			if ($val['value'] == 1)
			{
				$dbi[] = $val['name'];
			}
		}
		//DB::enableQueryLog();
		$models = Voucher::whereIn('id', $dbi)->get();

		// if ($record)
		// {			

			foreach($dbi as $datav){
				$temp_t['voucher_id'] = $datav;
					// DB::table('voucher_category')
					// 		->insert($temp_t);
					var_dump($datav);
					

				foreach($datat as $data_){

					
					if (!is_null($data_['value'])) {
						$temp_t['created_at']  = $now; 
						$temp_t['category'] = $data_['value'];

						//if($temp_t['category']!=$tag['category']){
						DB::table('voucher_category')
			 				->insert($temp_t);
						//}else{

						//}
						
					}
				
				}
					
					
			}

			DB::enableQueryLog();
			try {
			   //DB::table('voucher_category')
			   //->where('id', $dbi)
			//    ->update($insdata);
				//->insert($temp_t);



				 return response()->json(['success' => true]);
			}  catch (\Exception $ex) {
				 dd($ex);
				 return response()->json(['success' => false, 'record' =>'']);
			}
		//}
		return response()->json(['success' => false, 'record' => '']);		
	}
	
	public function ajax_unrv_update_voucher (Request $request)
	{
		$now = Carbon::now()->toDateTimeString();
		$data = $request->_data;
		$id   = $request->id;
		$insdata = array();
		$arr_system_category = [];
		$record = Unreleasedvouchers::find($id);
		if ($record)
		{			
			foreach($data as $key=>$val)
			{
				$insdata[$val['name']] = $val['value'];
				$insdata['created_at']  = $now; 
				$insdata['updated_at']  = $now; 
				if ($val['name'] == 'system_category[]') {

					$arr_system_category[] = $val['value'];

				}
			}

			$insdata['category']= implode(",", $arr_system_category);
			unset($insdata['_token']);
			unset($insdata['hidden_void']);			
			
			unset($insdata['system_category[]']);
			//DB::enableQueryLog();

			 try {
				DB::table('unreleased_vouchers')
				->where('voucher_id', $id)
				->update($insdata);
				 return response()->json(['success' => true]);
			}  catch (\Exception $ex) {
				 //dd($ex);
				 return response()->json(['success' => false]);
			}
		}

		
		return response()->json(['success' => false]);		
	}
	
		
	public function get_voucher_detail($id)
	{		
		if (!empty($id))
		{
			$record = Voucher::find($id);
			if ($record)
			{
				$data['page']   = 'client.details';
				$data['record'] = $record;	
			}
		}		
		$data['page'] = 'common.error';		
		return view('client/details',$data);
	}
	
	
	
	
}

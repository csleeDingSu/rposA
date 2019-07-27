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
			Voucher::delete_unr_voucher_category($id);
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
			Voucher::delete_voucher_category($id);

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


	public function edit_category ($id = FALSE)
	{
		$data['category'] = $category = Voucher::get_category_setting($id);
		
		$data['page'] = 'common.error';
		
		if ($category)
		{
			$data['page'] = 'voucher.edit_category';
		
			$data['sub_category'] = Voucher::get_subcategory($id);
	
			//$data['levels_opt'] = Game::get_gamelevel_options($id);
			//$data['category']  = Voucher::get_category();  
			
			//$data['sys_title']  = Voucher::get_csvtitle(); 
		}


		return view('main', $data);
	}
	// public function update_editcategory ($id,Request $request)
	// {
	// 	$insdata = array();
	
				
	// 	$inputs = $request->vi;
		
	// 	$systit = $request->sys_tit;
		
	// 	foreach ($systit as $key=>$val)
	// 	{
	// 		$insdata[$val] = $inputs[$key];
			
	// 	}
	// 	 $msg = Voucher::where('id', '=', $id)->update($insdata);
	// 	if ($msg) return redirect()->back()->with('message', trans('dingsu.voucher_update_success_message') );
	// 	else return redirect()->back()->with('error', trans('dingsu.voucher_update_error_message') );
		
	// }
	
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
	
	
	
	// public function post_unreleasedvoucher_list()
	// {
	// 	return Voucher::search($request, 'unreleased');
	// }

	public function get_unreleasedvoucher_list(Request $request)
	{
		
		$result = DB::table('unreleased_vouchers')
			->join('voucher_category', 'unreleased_vouchers.id', '=', 'voucher_category.unr_voucher_id')
			->join('category', 'voucher_category.category', '=', 'category.id')
			->select('unreleased_vouchers.*')
			->groupBy('unreleased_vouchers.id');
			//->orderBy('unreleased_vouchers'."."."{$sortby}",'DESC');
			// ->orderBy('unreleased_vouchers.month_sales','DESC');
			// ->orderBy('unreleased_vouchers.product_price','DESC');
			// ->orderBy('unreleased_vouchers.voucher_price','DESC');

		$data['page'] = 'voucher.unreleasedvoucherlist'; 	
		$data['files'] =  DB::table('excel_upload')->select('filename')->distinct()->get();
		$data['sys_title']  = Voucher::get_csvtitle(); 
		$data['category']  = Voucher::get_maincategory();
		$data['categories']  = Voucher::get_category();  
		$category = $data['category']; 
		$data['result'] = $result;
		
        $input = array();		
		parse_str($request->_data, $input);
		$input = array_map('trim', $input);
		

			if ($input) 
			{
				//filter
				if (!empty($input['s_title'])) { 
					$result = $result->where('product_name','LIKE', "%{$input['s_title']}%");
				}
				if (isset($input['s_cate'])) {
					if ($input['s_cate'] != '' )
					$result = $result->where('category.display_name','LIKE', "%{$input['s_cate']}%") ;							
				}
				if (isset($input['s_sort'])) {
					if ($input['s_sort'] != '' ){
						if($input['s_sort'] =='created_at')
						{
							$sortby = "{$input['s_sort']}";
						}
						else if($input['s_sort'] == 'month_sales')
						{
							$sortby = "{$input['s_sort']}";
						}
						else if($input['s_sort'] == 'product_price')
						{
							$sortby = "{$input['s_sort']}";
						}
						else if($input['s_sort'] == 'voucher_price')
						{
							$sortby = "{$input['s_sort']}";
						}
					}
				}
			}else{
				$sortby= 'created_at';
			}

			if (isset($input['s_order'])) {
				if ($input['s_order'] != '' ){
					if($input['s_order'] =='ASC')
					{
						$orderby = "{$input['s_order']}";
					}
					else if($input['s_order'] == 'DESC')
					{
						$orderby = "{$input['s_order']}";
					}
				}
			}else{
				$orderby= 'DESC';
			}

		$result =  $result->orderBy('unreleased_vouchers'."."."{$sortby}","{$orderby}")->paginate(200);
		// $result =  $result->orderBy('unreleased_vouchers.month_sales','DESC')->paginate(200);
		// $result =  $result->orderby('unreleased_vouchers.id','DESC')->paginate(200);
		//$result =  $result->orderby('id','DESC')->paginate(30);
				
		$data['page']    = 'voucher.unreleasedvoucherlist'; 	
				
		$data['result'] = $result; 
				
		if ($request->ajax()) {
			
			return view('voucher.ajax_unr_list', ['result' => $result, 'category' =>$category])->render();  
			

        }
					
		return view('main', $data);
		
		
	}

	public function check_voucher_duplicate()
	{
		$scron  = \App\CronManager::where('cron_name','pro_voucher_bulk_delete')->first();
		if ($scron->status != 3)
		{
			event(new \App\Events\EventDynamicChannel('bulkdelete','','yes'));
		}
		else{
			event(new \App\Events\EventDynamicChannel('bulkdelete','',''));
		}
		
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
		$scron  = \App\CronManager::where('cron_name','voucher_bulk_move')->first();
		if ($scron->status != 3)
		{
			event(new \App\Events\EventDynamicChannel('unr-bulkmove','','yes'));
		}
		else{
			event(new \App\Events\EventDynamicChannel('unr-bulkmove','',''));
		}
		
		$scron  = \App\CronManager::where('cron_name','voucher_bulk_delete')->first();
		if ($scron->status != 3)
		{
			event(new \App\Events\EventDynamicChannel('unr-bulkdelete','','yes'));
		}
		else{
			event(new \App\Events\EventDynamicChannel('unr-bulkdelete','',''));
		}
		
		$scron  = \App\CronManager::where('cron_name','import_voucher')->first();
		if ($scron->status != 3)
		{
			event(new \App\Events\EventDynamicChannel('unr-import','','yes'));
		}
		else{
			event(new \App\Events\EventDynamicChannel('unr-import','',''));
		}
		
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
		/*
		$models = Voucher::select('*');
		
		if (!in_array($type, array("delete_all")))
		{
			$models = $models->whereIn('id', $dbi);
		}
		$models = $models->get();
		//$models = $models->toArray();
		*/
		
		//DB::enableQueryLog();
		//$models = Voucher::whereIn('id', $dbi)->get();
		//print_r(DB::getQueryLog());
		
		$now = Carbon::now()->toDateTimeString();
		
		switch ($type)
		{
			
			case 'delete':
				Voucher::destroy($dbi);
				// Voucher::delete_voucher_category($dbi);
				
				foreach($dbi as $val)
				{
					Voucher::delete_voucher_category($val);
				}
				// die();
			break;
			case 'delete_all':
				Voucher::query()->delete();
				Voucher::empty_category('vo');
			break;
			case 'share':
				
				$models = Voucher::select('*');
				
				$models = $models->whereIn('id', $dbi);
				
				$models = $models->get();
				
				$models = $models->toArray();
				
				foreach ($models as $row)
				{
					unset($row['id']);
					unset($row['created_at']);
					unset($row['updated_at']);
					\App\Shareproduct::create($row);
				}
			break;
			// case 'tag':
			// 	Voucher::tag_voucher($id, $data);
			// break;	
		}
		
		echo json_encode($dbi);
	
	}
	
	public function bulkdata_unrv_update (Request $request)
	{
		
		$dbi = array(); // unrelease voucher id 
		$insdata = array();
		$tagdata = array();
		$data = $request->_data;
		$type = $request->_type;
		
		//print_r($data );
		//print_r($type);
		//print_r($dbi);
		//die();
		if (!empty($data))
		{
			foreach($data as $val)
			{
				if ($val['value'] == 1)
				{
					$dbi[] = $val['name'];
				}
			}
		}
		//DB::enableQueryLog();
		$models = Unreleasedvouchers::select('*');
		
		if (!in_array($type, array("move_all", "delete_all")))
		{
			$models = $models->whereIn('id', $dbi);
			echo 'imin';
		}
		$models = $models->get();
		$models = $models->toArray();
		//print_r(DB::getQueryLog());
				
		$now = Carbon::now()->toDateTimeString();
		
		foreach ($models as $row)
		{
			if (!in_array($type, array("move_all", "move"))) 
			{
				//if ($type != 'move') {
				$row['source_type'] = '1'; 
				unset($row['source_file']);
			}
			
			$row['created_at']  = $now; 
			$row['updated_at']  = $now; 
			//$array_id[]=$row['id'];
			//unset($row['id']);
			
			$insdata[] = $row;
		}
		switch ($type)
		{
			case 'move':

				foreach ($insdata as $key=>$row)
				{
					// print_r($array_id);
					// die('--ll');
					$rid = $row['id'];
					unset($row['id']);
					$id = DB::table('vouchers')->insertGetId($row);
					Voucher::update_voucher_id($rid, $id);
					// echo $id;
					// Voucher::update_voucher_id($dbi, $id);
				}
				
				Unreleasedvouchers::destroy($dbi);
			break;
			case 'delete':
				//Voucher::archived_unr_vouchers_insert($insdata);
				
				foreach($models as $key=>$val)
				{
					$id = $val['id'];
				// 	// $val['created_at']  = $now; 
				// 	// $val['updated_at']  = $now; 
				// 	// //print_r($key);
				// 	// print_r($val['id']);
				// 	//Voucher::archived_unr_vouchers_insert($val);
					Voucher::destroy($id);
					Voucher::delete_unr_voucher_category($id);
				}
				
				Unreleasedvouchers::destroy($dbi);
			break;	
				
			case 'move_all':
				//$i=1;
				$cron  = \App\CronManager::where('cron_name','voucher_bulk_move')->first();
				if ($cron->status != 3)
				{
					return response()->json(['success' => false, 'error_message' => 'cron running already']);
					return FALSE;
				}
				$max  = Unreleasedvouchers::max('id');
				$cron->status      = 2;
				$cron->total_limit = $max ;
				$cron->save();
				
				
				/*
				foreach (array_chunk($insdata,800) as $t) {	
					foreach ($t as $key=>$row)
					{
						$rid = $row['id'];
						unset($row['id']);
						$id = DB::table('vouchers')->insertGetId($row);
						Voucher::update_voucher_id($rid, $id);
						//$i=$i+1;
						//print_r($row);die();
						//echo $rid.' -- '. $i.'<br>';
					}
				}
				
				Unreleasedvouchers::query()->delete();
				*/
			break;
				
			case 'delete_all':
				//Voucher::archived_unr_vouchers_insert($insdata);
				
				$cron  = \App\CronManager::where('cron_name','voucher_bulk_delete')->first();
				if ($cron->status != 3)
				{
					return response()->json(['success' => false, 'error_message' => 'cron running already']);
					return FALSE;
				}
				$max  = Unreleasedvouchers::max('id');
				$cron->status      = 2;
				$cron->total_limit = $max ;
				$cron->save();
				
				
				/*
				foreach($models as $key=>$val)
				{
					$id = $val['id'];
					//Voucher::destroy($id);
					Voucher::delete_unr_voucher_category($id);
					
				}
				
				Unreleasedvouchers::query()->delete();
				*/
			break;		
		}
		
		
		echo json_encode($dbi);
	
	}



	public function listvoucher (Request $request)
	{
		
		//$data['record']  = Admin::get_faq();
		
		
		//$result =  \DB::table('tips');
		// $result =  \DB::table('vouchers');
		$result = DB::table('vouchers')
			->join('voucher_category', 'vouchers.id', '=', 'voucher_category.voucher_id')
			->join('category', 'voucher_category.category', '=', 'category.id')
			->select('vouchers.*' )
			->groupBy('vouchers.id');


		$data['page'] = 'voucher.list'; 
		$data['sys_title']  = Voucher::get_csvtitle();
		$data['category']  = Voucher::get_maincategory();
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
					$result = $result->where('product_name','LIKE', "%{$input['s_title']}%");
				}
				if (!empty($input['s_share'])) { 
					if ($input['s_share'] == 1 ) $result = $result->where('share_product', 1);
				}
				if (isset($input['s_cate'])) {
					if ($input['s_cate'] != '' )
					$result = $result->where('category.display_name','LIKE', "%{$input['s_cate']}%") ;							
				}
				if (isset($input['s_sort'])) {
					if ($input['s_sort'] != '' ){
						if($input['s_sort'] =='created_at')
						{
							$sortby = "{$input['s_sort']}";
						}
						else if($input['s_sort'] == 'month_sales')
						{
							$sortby = "{$input['s_sort']}";
						}
						else if($input['s_sort'] == 'product_price')
						{
							$sortby = "{$input['s_sort']}";
						}
						else if($input['s_sort'] == 'voucher_price')
						{
							$sortby = "{$input['s_sort']}";
						}
					}
				}
			}else{
				$sortby= 'created_at';
			}

			if (isset($input['s_order'])) {
				if ($input['s_order'] != '' ){
					if($input['s_order'] =='ASC')
					{
						$orderby = "{$input['s_order']}";
					}
					else if($input['s_order'] == 'DESC')
					{
						$orderby = "{$input['s_order']}";
					}
				}
			}else{
				$orderby= 'DESC';
			}

		// public function getfaq(Request $request)
		// {
		// 	$id = $request->id;
		// 	$record = Admin::get_faq($id);
		// 	return response()->json(['success' => true, 'record' => $record]);
		// }



		$result =  $result->orderBy('vouchers'."."."{$sortby}","{$orderby}")->paginate(200);
		// $result =  $result->orderby('vouchers.id','DESC')->paginate(200);
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

// ------------------------------------------------------------------------------------------------
	public function listvouchersetting (Request $request)
	{
		$result =  \DB::table('category')->where('parent_id',0);
		$data['page'] = 'voucher.setting'; 
		$data['sys_title']  = Voucher::get_csvtitle();
		$data['category']  = Voucher::get_category();
		// $data['category'] = $category = Voucher::get_category_setting($id);
		$category = $data['category'];  		
		$data['result'] = $result;

	
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

		
		$result =  $result->orderby('id','ASC')->paginate(200);
				
		$data['page']    = 'voucher.setting'; 	
				
		$data['result'] = $result; 
				
		if ($request->ajax()) {
			return view('voucher.ajaxlist', ['category' =>$category])->render();  
        }
		return view('main', $data);
	}

	public function show_voucher_setting ($id)
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



// --------------------------------------------------------------------------

	
	public function show_unreleased_voucher ($id)
	{
		$record = Unreleasedvouchers::find($id);		
		if ($record)
		{
			$syscategory = Voucher::get_category()->toArray();
			$tagcategory = Voucher::get__unr_categorytag($id)->toArray();
			$temp = ['record'=>$record,'syscategory'=>$syscategory,'tagcategory'=>$tagcategory];
			return response()->json(['success' => true, 'record' => $record,'syscategory'=>$syscategory,'tagcategory'=>$tagcategory]);	
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
		// print("check");
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
			
			if (!isset($insdata['share_product']))
			{
				$insdata['share_product']  = '0'; 
			}

			if (is_array($arr_system_category))
			{
				// print("check2");
				// print("id");
				// print($id);
				// $tagdata['category']= implode(",", $arr_system_category);
				//App\Voucher_category::destroy($id);
				//Voucher_category::delete_tag($id);
				DB::table('voucher_category') -> where('voucher_id', $id) ->delete();

				foreach ($arr_system_category as $data_)
				{
					// print("check3");
						// $temp_t['voucher_id'] = $id;
						// $temp_t['updated_at']  = $now; 
						
						// $temp_t['category'] = $data_;
						// DB::table('voucher_category')
						// 	 ->insert($temp_t);

							 $voucher_tags = App\Voucher_category::updateOrCreate(
								[
									'voucher_id' => $id, 
									'category' => $data_
									
								],
								[
									'updated_at'  => $now,
								]
								
							);
							 
						
					//}
				
				}
			}
					

			// print($voucher_tags);
			unset($insdata['system_category[]']);
			unset($insdata['category[]']);
			unset($insdata['_token']);
			unset($insdata['hidden_void']);

			DB::enableQueryLog();
			 try {
				DB::table('vouchers')
				->where('id', $id)
				->update($insdata);


				


				//  DB::table('voucher_category')
				// ->where('id', $id)
				// ->update($temp_t);
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
		//$tag =  DB::table('voucher_category')->select(['id', 'updated_at','unr_voucher_id','category']);		
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
				//DB::table('voucher_category') -> where('voucher_id', $datav) ->delete();
				// $temp_t['unr_voucher_id'] = $datav;
					// DB::table('voucher_category')
					// 		->insert($temp_t);
					//var_dump($datav);
					

				foreach($datat as $data_){

					
					if (!is_null($data_['value'])) {

						$voucher_tags = App\Voucher_category::updateOrCreate(
						[
								'voucher_id' => $datav, 
								'category' => $data_['value']
								
							],
							[
								'updated_at'  => $now,
							]
							
						);

						// var_dump($datav);

						// $temp_t['updated_at']  = $now; 
						// $temp_t['category'] = $data_['value'];

						//if($temp_t['category']!=$tag['category']){
						//DB::table('voucher_category')
			 			//	->insert($temp_t);
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


	public function ajax_update_unr_tag(Request $request)
	{
		$now = Carbon::now()->toDateTimeString();
		$dbi = array();
		$insdata = array();
		$indata = array();
		$data = $request->_data;
		$datat = $request->_datat;
		$arr_tag = [];
		
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
				//DB::table('voucher_category') -> where('unr_voucher_id', $datav) ->delete();

				foreach($datat as $data_){

					
					if (!is_null($data_['value'])) {

						$voucher_tags = App\Voucher_category::updateOrCreate(
						[
								'unr_voucher_id' => $datav, 
								'category' => $data_['value']
								
							],
							[
								'updated_at'  => $now,
							]
							
						);
					}
				}
				

			}
			DB::enableQueryLog();
			try {


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


			if (is_array($arr_system_category))
			{
				// print("check2");
				// print("id");
				// print($id);
				// $tagdata['category']= implode(",", $arr_system_category);
				//App\Voucher_category::destroy($id);
				//Voucher_category::delete_tag($id);
				DB::table('voucher_category') -> where('unr_voucher_id', $id) ->delete();

				foreach ($arr_system_category as $data_)
				{
					// print("check3");
						// $temp_t['voucher_id'] = $id;
						// $temp_t['updated_at']  = $now; 
						
						// $temp_t['category'] = $data_;
						// DB::table('voucher_category')
						// 	 ->insert($temp_t);

							 $voucher_tags = App\Voucher_category::updateOrCreate(
								[
									'unr_voucher_id' => $id, 
									'category' => $data_
									
								],
								[
									'updated_at'  => $now,
								]
								
							);
							 
						
					//}
				
				}
			}

			$insdata['category']= implode(",", $arr_system_category);

			
			unset($insdata['_token']);
			unset($insdata['hidden_void']);			
			
			unset($insdata['system_category[]']);
			//DB::enableQueryLog();

			 try {
				DB::table('unreleased_vouchers')
				->where('id', $id)
				->update($insdata);
				 return response()->json(['success' => true]);
			}  catch (\Exception $ex) {
				 dd($ex);
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
	
	public function add_cate (Request $request)
	{
		//$record = Category::find($id);
		$data = $request->_data;
		// print_r($data);
		// die();
		
		foreach($data as $key=>$val)
		{
			//$insdata[$val['name']] = $val['value'];
			//print_r($insdata[$val['name']]);
			$insdata[$val['name']] = $val['value'];
			//$insdata['parent_id'] = $val['value'];
			// if ($val['name'] == 'system_category[]') {
			// 	$arr_system_category[] = $val['value'];
			// }
		}
		
		try {
			DB::table('category')->insert($insdata);
			 return response()->json(['success' => true]);
		}  catch (\Exception $ex) {
			 //dd($ex);
			 return response()->json(['success' => false]);
		}
	}

public function add_subcate (Request $request)
{
	//$record = Category::find($id);
	$data = $request->_data;
	// print_r($data);
	// die();
	
	foreach($data as $key=>$val)
	{
		//$insdata[$val['name']] = $val['value'];
		//print_r($insdata[$val['name']]);
		$insdata[$val['name']] = $val['value'];
		//$insdata['parent_id'] = $val['value'];
		// if ($val['name'] == 'system_category[]') {
		// 	$arr_system_category[] = $val['value'];
		// }
	}
	
	try {
		DB::table('category')->insert($insdata);
		 return response()->json(['success' => true]);
	}  catch (\Exception $ex) {
		 //dd($ex);
		 return response()->json(['success' => false]);
	}
}


public function delete_category ($id)
{
	// $data = $request->_data;
	// print();
	$category = Voucher::delete_category_by_id($id);
	
	if ($category)
	{
		//@todo : check user bidding information & referral commision
		Voucher::delete_category_by_id($id);
		return 'true';
	}
	return 'false';
}
public function delete_subcategory ($id)
{
	// $data = $request->_data;
	// print();
	$category = Voucher::delete_subcategory_by_id($id);
	
	if ($category)
	{
		//@todo : check user bidding information & referral commision
		Voucher::delete_subcategory_by_id($id);
		return 'true';
	}
	return 'false';
}

public function update_category($id, Request $request)
{
	print_r($request->category);
	$validator = $this->validate(
		$request,
		[
			'category' => 'required|string',
		]
	);	
	$data = [
	'display_name' => $request->category];

	Voucher::update_category_by_id($id,$data);
	
	return redirect()->back()->with('message', trans('dingsu.game_update_success_message'));
	//return redirect()->route('gamelist')->with('status', ('dingsu.game_add_success_message'));
}
	
	
	public function shareproductlist (Request $request)
	{
		
		//$data['record']  = Admin::get_faq();
		
		
		//$result =  \DB::table('tips');
		

		$data['page'] = 'voucher.sharelist'; 
		
	
		$input = array();		
		parse_str($request->_data, $input);
		$input = array_map('trim', $input);
		$sortby= 'created_at';
		$orderby= 'DESC';
		
		$result =  \App\Shareproduct::select('*');
		
    	if ($input) 
			{
				//filter
				if (!empty($input['s_title'])) { 
					$result = $result->where('product_name','LIKE', "%{$input['s_title']}%");
				}				
			}

			if (isset($input['s_order'])) {
				if ($input['s_order'] != '' ){
					if($input['s_order'] =='ASC')
					{
						$orderby = "{$input['s_order']}";
					}
					else if($input['s_order'] == 'DESC')
					{
						$orderby = "{$input['s_order']}";
					}
				}
			}

		$result =  $result->orderBy("{$sortby}","{$orderby}")->paginate(200);		
				
		$data['result'] = $result; 
				
		if ($request->ajax()) {
			return view('voucher.shareajaxlist', ['result' => $result])->render();  

        }					
		return view('main', $data);
	}
	
	public function update_shareproduct (Request $request)
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
		
		
		$now = Carbon::now()->toDateTimeString();
		
		switch ($type)
		{
			
			case 'delete':
				\App\Shareproduct::destroy($dbi);
				
			break;
			case 'delete_all':
				\App\Shareproduct::query()->delete();
			break;	
		}		
		echo json_encode($dbi);
	}

	public function ajax_update_rank($id)
	{
		try {
			$now = Carbon::now()->toDateTimeString();
			//update datetime
			Voucher::where('id', $id)->update(['created_at' => $now, 'updated_at' => $now]);

			return response()->json(['success' => true]);
		
		}  catch (\Exception $ex) {
			 \log::error($ex);
			 return response()->json(['success' => false, 'message' => $ex.message]);
		}
	}	
}



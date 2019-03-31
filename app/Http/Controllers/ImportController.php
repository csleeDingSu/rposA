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
use App\Product;
use Excel;
use File;
use Storage;


//new
use App\Events\GenerateVoucher;
use App\Events\ImportSoftpins;
use App\Events\ImportAds;

class ImportController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
	
	public $document_ext = ['xls', 'xlsx'];
	
	public function getImport()
    {
        $max_size = ini_get('upload_max_filesize') ;
		
		$max_size = 90000 ;
		
		$data['page'] = 'voucher.import'; 
		
		return view('main', $data);
    }
	
	public function getPinImport()
    {
        $max_size = ini_get('upload_max_filesize') ;
		
		$max_size = 90000 ;
		
		$data['page'] = 'product.import'; 
		
		return view('main', $data);
    }
	
	public function PostpinImport(Request $request)
	{

		ini_set('memory_limit', '3024M'); // or you could use 1G
		
		$max_size = (int)ini_get('upload_max_filesize') * 10000;
		
		
		$max_size = 900000 ;
		
		$all_ext = implode(',', $this->document_ext);
		
		
		// $validator = $this->validate(
  //           $request,
  //           [
  //               'file' => 'required|file|mimes:' . $all_ext 
  //           ]
  //       );
		
		$extension = $request->file->getClientOriginalExtension(); //$request->file->extension();
						
		$filename = 'softpin'.time(); 
		
		$path = $request->file->storeAs('softpins', $filename.'.'.$extension, 'public_uploads');
		
		$url = Storage::url('uploads/'.$path);
		
		$excelChecker = Excel::selectSheetsByIndex(0)->load($url, function($reader){})->get()->toArray();
				
		$arrayhead = $excelChecker[0];
				
		$data['page']       = 'product.importparse'; 
		$data['file_title'] = array_keys($arrayhead);
		$data['sys_title']  = Product::get_csvtitle(); 
		$data['filename']   = $filename;
		return view('main', $data);
		
	}
	
	public function PinProcessImport(Request $request)
	{
		
		$file_title = $request->file_title;
		$sys_title  = $request->sys_tit;
		$filename  = $request->filename;
				
		foreach ($sys_title as $key=>$val)
		{
			
			$arr['sys_field_id'] = $val;
			$arr['file_title_loc_id'] = $file_title[$key];
			$arr['filename'] = $filename;
			
			$dbc[] = $arr;
		}
		
		//die();
		
		DB::table('excel_upload')->insert($dbc);
		
		event(new ImportSoftpins($request,$filename));
		
		$data['page'] = 'common.success'; 
		
		$data['msg']  = 'message_import_success';
		
		return view('main', $data);
		
	}
	
	
	
	public function parseImport(Request $request)
	{

		ini_set('memory_limit', '3024M'); // or you could use 1G
		
		$max_size = (int)ini_get('upload_max_filesize') * 10000;
		
		
		$max_size = 900000 ;
		
		$all_ext = implode(',', $this->document_ext);
		
		
		// $validator = $this->validate(
  //           $request,
  //           [
  //               'file' => 'required|file|mimes:' . $all_ext 
  //           ]
  //       );
		
		$extension = $request->file->getClientOriginalExtension(); //$request->file->extension();
		
		
		
		$filename = 'upv'.time(); 
		
		$path = $request->file->storeAs('excel', $filename.'.'.$extension, 'public_uploads');
		
		$url = Storage::url('uploads/'.$path);
		
		$excelChecker = Excel::selectSheetsByIndex(0)->load($url, function($reader){})->get()->toArray();
				
		$arrayhead = $excelChecker[0];
				
		$data['page'] = 'voucher.importparse'; 
		$data['file_title'] = array_keys($arrayhead);
		$data['sys_title']  = Voucher::get_csvtitle(); 
		$data['filename']   = $filename;
		return view('main', $data);
		
	}
	
	
	public function testparseImport()
	{
		ini_set('memory_limit', '1024M'); 
		
		$filename = 'testfile.xls';
		$path = 'uploads/excel/'.$filename;
		$url = Storage::url($path);
		
		
		
		$excelChecker = Excel::selectSheetsByIndex(0)->load($url, function($reader){})->get()->toArray();
			
		$arrayhead = $excelChecker[0];
		
		
		
		
		
		/*
		$ddd  =  Excel::create('itsolutionstuff_example', function($excel) use ($excelChecker) {
			$excel->sheet('mySheet', function($sheet) use ($excelChecker)
	        {
				$sheet->fromArray($excelChecker);
	        });
		})->download($type);
		
		*/
		
		
		$data['page'] = 'voucher.importparse'; 
		
		$data['file_title'] = array_keys($arrayhead);
		$data['sys_title']  = Voucher::get_csvtitle();
		
		return view('main', $data);
		
	}
	
	public function ProcessparseImport(Request $request)
	{
		ini_set('memory_limit', '3024M'); // or you could use 1G
		
		$max_size = (int)ini_get('upload_max_filesize') * 10000;
		
		
		$max_size = 900000 ;
		
		$all_ext = implode(',', $this->document_ext);
		
		
		// $validator = $this->validate(
  //           $request,
  //           [
  //               'file' => 'required|file|mimes:' . $all_ext 
  //           ]
  //       );
		
		$extension = $request->file->getClientOriginalExtension(); //$request->file->extension();
		
		
		
		$filename = 'upv'.time(); 
		
		$path = $request->file->storeAs('excel', $filename.'.'.$extension, 'public_uploads');
		
		$url = Storage::url('uploads/'.$path);
		
		$excelChecker = Excel::selectSheetsByIndex(0)->load($url, function($reader){})->get()->toArray();
				
		$arrayhead = $excelChecker[0];
				
		$data['page'] = 'voucher.importparse'; 
		$data['file_title'] = $file_title = array_keys($arrayhead);
		$data['sys_title'] = $sys_title = Voucher::get_csvtitle(15); 
		$data['filename']   = $filename;
		
		//print_r($sys_title);echo '<br><Br><br>';
		
		print_r($data['file_title']);echo '<br><Br><br>';
		
		$rr = 2;
		
		print_r($file_title[$rr]);echo '<br><Br><br>';
		
		//die();

		$file_title = array(1,2,3,4,5,6,7,8,9);
		//$sys_title  = array(1,2,3,4,5,6,7,8);
		
		$vouchercombination = new Voucher();
		
		foreach ($sys_title as $key=>$val)
		{
			if (!empty($file_title[$key] ) )
			{
				echo $key;print_r($file_title[$key]);echo $file_title{[$key]};echo $val->title;echo '<br<br>';
				if ($file_title[$key] == $val->title)
				{				
					$arr['sys_field_id'] = $val->id;
					$arr['file_title_loc_id'] = $file_title[$key];
					$arr['filename'] = $filename;
					$dbc[] = $arr;
				}
			}
		}
		die();
		DB::table('excel_upload')->insert($dbc);
		
		//die();
		event(new GenerateVoucher($request,$filename));
		
		$data['page'] = 'common.success'; 
		
		$data['msg']  = 'message_import_success';
		
		// return view('main', $data);
		return redirect('voucher/unreleased')->with('message', 'Successfully imported! 导入完成!');
	}
	
		
	public function downloadExcel($type = 'csv', Request $request)
	{
		
		$filename = 'upv1534469598'.'.xls';
		
		$filename = 'upv1534487822';
		
		// Fire an event that the user has now logged in
		//event(new GenerateVoucher($request));
		event(new UserLoggedIn($request,$filename));
		
		die();
		
		$data = Excel::load('storage\\uploads\\excel\\testfile.xls')->get();
		
		
		
		print_r($data);
		die();
		
		
		//$data = array('tit','ff');
		return Excel::create('itsolutionstuff_example', function($excel) use ($data) {
			$excel->sheet('mySheet', function($sheet) use ($data)
	        {
				$sheet->fromArray($data);
	        });
		})->download($type);
	}
	
	
	public function processImport(Request $request)
	{
		$data = CsvData::find($request->csv_data_file_id);
		$csv_data = json_decode($data->csv_data, true);
		foreach ($csv_data as $row) {
			$contact = new Contact();
			foreach (config('app.db_fields') as $index => $field) {
				if ($data->csv_header) {
					$contact->$field = $row[$request->fields[$field]];
				} else {
					$contact->$field = $row[$request->fields[$index]];
				}
			}
			$contact->save();
		}

		return view('import_success');
	}
	
	//ads import
	
	public function getAdImport()
    {
        $max_size = ini_get('upload_max_filesize') ;
		
		$max_size = 90000 ;
		
		$data['page'] = 'ad.import'; 
		
		return view('main', $data);
    }
	
	public function PostAdImport(Request $request)
	{

		ini_set('memory_limit', '3024M'); // or you could use 1G
		
		$max_size = (int)ini_get('upload_max_filesize') * 10000;
		
		
		$max_size = 900000 ;
		
		$all_ext = implode(',', $this->document_ext);
		
		
		// $validator = $this->validate(
  //           $request,
  //           [
  //               'file' => 'required|file|mimes:' . $all_ext 
  //           ]
  //       );
		
		$extension = $request->file->getClientOriginalExtension(); //$request->file->extension();
		$extension = empty($extension) ? 'xls' : $extension;
		
		$filename = 'ads'.time(); 
		
		$path = $request->file->storeAs('ads', $filename.'.'.$extension, 'public_uploads');
		
		$url = Storage::url('uploads/'.$path);
		
		$excelChecker = Excel::selectSheetsByIndex(0)->load($url, function($reader){})->get()->toArray();
				
		$arrayhead = $excelChecker[0];
				
		$data['page']       = 'ad.importparse'; 
		$data['file_title'] = array_keys($arrayhead);
		$data['sys_title']  = Product::get_csvtitle('ads'); 
		$data['filename']   = $filename;
		return view('main', $data);
		
	}
	
	public function AdProcessImport(Request $request)
	{
		
		$file_title = $request->file_title;
		$sys_title  = $request->sys_tit;
		$filename  = $request->filename;
				
		foreach ($sys_title as $key=>$val)
		{
			
			$arr['sys_field_id'] = $val;
			$arr['file_title_loc_id'] = $file_title[$key];
			$arr['filename'] = $filename;
			
			$dbc[] = $arr;
		}
		
		DB::table('excel_upload')->insert($dbc);
		
		event(new ImportAds($request,$filename));
				
		$data['page'] = 'common.success'; 
		
		$data['msg']  = 'message_import_success';
		
		return view('main', $data);
		
	}
	
}

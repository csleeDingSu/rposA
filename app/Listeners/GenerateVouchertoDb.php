<?php

namespace App\Listeners;

use App\Events\GenerateVoucher;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Storage;

use App\Voucher;
use App\Voucher_category;
use Carbon\Carbon;
use Excel;
use DB;
class GenerateVouchertoDb
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  GenerateVoucher  $event
     * @return void
     */
    public function handle(GenerateVoucher $event)
    {
		$categories= Voucher::get_category();

        ini_set('memory_limit', '4024M');
		ini_set('max_execution_time', 900);
		
		$filename = $event->filename ;
		
		$queuet   = Voucher::QueuedList($filename)->toArray();
		$systitle = Voucher::get_csvtitle()->toArray();
		
		$now = Carbon::now()->toDateTimeString();
		$cfile = array();
		$flist = $queuet;
		foreach ($systitle as $key=>$filecolumn)
		{
			$slist[$filecolumn->id] = $filecolumn->title;
		}
		
		foreach ($flist as $key=>$filecolumn)
		{
			if (!empty($filecolumn->file_title_loc_id))
			{
				$file[$filecolumn->file_title_loc_id] = $filecolumn->sys_field_id;
				
				$cfile[$filecolumn->file_title_loc_id] = $slist[$filecolumn->sys_field_id];
			}			
		}		
		
		if (empty($cfile)) die('No rows to process');
		
		$filename = $filename.'.xls';
		$path = 'uploads/excel/'.$filename;
		$url = Storage::url($path);
		
		//print_r($cfile);echo '<br><br>';
		//print_r($file);echo '<br><br>';

		$array_data = [];
		
		$data = Excel::selectSheetsByIndex(0)->load($url, function($reader){})->get()->toArray();
		
		$count = count($data);
		
		if ($count > 0) {			
			$arrayhead = $data[0];
			$i = 1;
			foreach ($data as $key=> $val) 
			{
				if (empty($val['product_name'])) {

					break;

				}
				
				//new
				/*foreach ($val as $akey=>$voar) 
				{
					$insdata = array();
					foreach ($flist as $key=>$filecolumn) 
					{
						
					}
		
				}
				*/
				//end
				
				//if (!empty($val['id']))
				//{
				//	unset($val['id']);
				//}

				$ke = array_keys($val);
				
				//print_r($val);echo '<br><br>';

				foreach ($val as $akey=>$voar) 
				{	
					$m = 0;
					$insdata = array();
					print_r($cfile);die();
					foreach($ke as $mkey=>$mva)
					{	
						if (!empty($cfile[$m]))
						{
							$re_field = $cfile[$m];
							
							$insdata[$re_field] = $val[$mva];
							$insdata['source_file'] = $filename;
							$insdata['updated_at']  = $now; 
							$insdata['created_at']  = $now;


							if ($re_field == 'product_category')
							{
								
								$_data= explode("/", $insdata['product_category']);								
								
									if(empty($kk[$i])){
										foreach($_data as $key=> $item){
											$get_data = self::sort_voucher($item, $categories);
											// if(!empty($get_data)){
											$array_data[]=$get_data;
											// print_r("123");
											// }
											//print_r($array_data);
											//print_r($array_data);
											//  print_r("check1");
											//  
										}
									$kk[$i] = $array_data;
									unset($array_data);
								}						
								
							}
						}						
						$m++;
					}
				}	

				if (!empty($insdata))
				{
					$dbc[$i] = $insdata;
				}
				$i++;
			}

			// print_r($dbc);
			// die();
			foreach ($dbc as $key=> $t) {

			   
				// print_r($kk[$key]);
			   //die();
			   if(!empty($kk[$key])){
				$id = DB::table('unreleased_vouchers')->insertGetId($t);
				foreach($kk[$key] as $vkey=>$val)
					{
						$catedata['unr_voucher_id']  = $id; 
						$catedata['category']  = $val; 
						$catedata['updated_at']  = $now; 
						$catedata['created_at']  = $now; 
						DB::table('voucher_category')->insert($catedata);
					}
				}
			}
		}
		else { die('File Missing/No excel rows to process'); }
	}
	


	private function sort_voucher($gencate, $categories)
	{

				foreach($categories as $key=> $cate){
					$category= '';

					if($gencate == $cate->display_name){
						
						if($cate->parent_id == '0'){
							$category= $cate->id;

						}else{
							$category= $cate->parent_id;
						}
						// echo 'GC--'.$gencate;
						// echo 'DN---'.$cate->display_name;
						// echo '<br><br>';
						// echo 'PI---'.$cate->parent_id;
						// echo '<br><br>';
						//  echo '--YES';
						return $category;
					// }
					}else{
						$category= '180';
					}
				}
		return $category;
	}



}
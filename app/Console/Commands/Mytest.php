<?php

namespace App\Console\Commands;


use App\Http\Controllers\TestController;
use Carbon\Carbon;
use Illuminate\Console\Command;
use App\Voucher;

//use Excel;


class Mytest extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mytest:import';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import Voucher';
	
	public $cronname  = 'import_voucher';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        ini_set('max_execution_time', 0);
		ini_set('memory_limit', '-1');
		$this->info('-- Cron start to work');
		//Check Cron Status 
		$cron  = \App\CronManager::where('cron_name',$this->cronname)->first();
		if ($cron->status != 3)
		{
			$this->error('-- Cron already running or hold by another process.');
			//exit();return FALSE;
		}
		//$cron->status = 1;
		//$cron->save();
		
		//Check Files in pipeline
		$result  = \DB::table('excel_upload')->where('filename', 'like', 'upv%')->groupBy('filename')
                 ->get();
		
		if (!$result->isEmpty())
		{
			event(new \App\Events\EventDynamicChannel('unr-import','','yes'));
			
			$categories = Voucher::get_category();
			$systitle   = Voucher::get_csvtitle()->toArray();						
				
			//Process File			
			foreach($result as $row)
			{
				//print_r($row);
				$this->info('-- Vouchers importing from file: '.$row->filename);
				
				$importfile   = \App\FileVoucher::where('file_name',$row->filename)->first();
				
				if (is_null($importfile)) {
					
					\DB::table('excel_upload')->where('filename',$row->filename)->delete();	
					continue;
				}

				$importfile->status = 2;
				$importfile->updated_at = now();
				$importfile->save();				
				
				$imresult = Voucher::get_pipeline_import();		
		 		event(new \App\Events\EventDynamicChannel('importnoti','',$imresult));
				
				$this->info('-- Update Event');
				
				$filename = $row->filename;
				$fname    = $row->filename;
				$queuet   = Voucher::QueuedList($filename)->toArray();
				$now = Carbon::now()->toDateTimeString();
				$cfile = array();
				$flist = $queuet;
				
				foreach ($systitle as $key=>$filecolumn)
				{
					$slist[$filecolumn->id] = $filecolumn->title;
				}

				foreach ($flist as $key=>$filecolumn)
				{
					if (isset($filecolumn->file_title_loc_id))
					{
						//$file[$filecolumn->file_title_loc_id] = $filecolumn->sys_field_id;

						$cfile[$filecolumn->file_title_loc_id] = $slist[$filecolumn->sys_field_id];
					}			
				}	
				
				$sysval = array_flip($cfile);

				if (empty($cfile)) 
				{
					$this->error('-- No rows to process');
					//$cron->status = 3;
				//	$cron->save();
					die();
				}				
				$this->info('-- getting file from server');
				
				//$filename = 'upv1547179877';
				$filename = $filename.'.xls';
				$path     = 'uploads/excel/'.$filename;
				$url      = \Storage::url($path);
				$array_data = [];
				
				$this->info($url);
				/*
				$tdata = \Excel::selectSheetsByIndex(0)->load($url, function($reader){})->get()->toArray();
				$this->info('-- as');
				
				$rows = \Excel::load($url)->get();
				$this->info('-- as');
				
				$data = \Excel::load($url, function($reader) {})->get();
				$count = count($data);
				$this->info('-- as');
				die();
				
				Excel::load($url, function ($reader) {

				 $reader->each(function($sheet) {    
					 foreach ($sheet->toArray() as $row) {
						$this->info(json_encode($row));
					 }
				 });
			});
				
				
				die();
				*/

				$tdata = \Excel::selectSheetsByIndex(0)->load($url, function($reader){})->get()->toArray();
				$insdata = [];
				$count = count($tdata);
				$this->info('-- processing file');

				if ($count > 0) {			
					$arrayhead = $tdata[0];
					$i = 1;
					
					foreach (array_chunk($tdata,500) as $keyc=>$data) 
					{
						$dbc = [];
						foreach ($data as $key=> $val) 
						{
							$com = array_intersect_key($val, $sysval);
							$z = 0;
							$insdata = [];
							foreach ($com as $ck=>$cv) 
							{
								$insdata['source_file'] = $filename;
								$insdata['updated_at']  = $now; 
								$insdata['created_at']  = $now;
								$insdata[$ck]  			= $cv;
								
								$ci[] = $i;
								if ($ck == 'expiry_datetime')
								{
									if (!empty($cv))
									{
										$ud = $cv;
										$ud = str_replace('.','/',$ud);		
										$insdata['expiry_datetime'] = Carbon::parse($ud)->format('Y-m-d H:i:s');
									}
									else
									{
										$insdata['expiry_datetime'] = null;
									}
								}
								if ($ck == 'product_category')
								{
									$_data= explode("/", $insdata['product_category']);										
									if(empty($kk[$i])){
										foreach($_data as $key=> $item){
											$get_data = self::sort_voucher($item, $categories);
											$array_data[]=$get_data;
										}
									$kk[$i] = $array_data;
									unset($array_data);
									}								
								}
							
								if (!empty($insdata))
								{								
									$dbc[$i] = $insdata;
								}							
							}
							$i++;
						}
						
						//Update Data
						foreach ($dbc as $key=> $t) 
						{
						   if(!empty($kk[$key]))
						   {
							   $id = \DB::table('unreleased_vouchers')->insertGetId($t);

							   $this->line('-- New record Inserted. '.$id);

							   if(isset($t['is_featured']) && $t['is_featured'] == 1)
							   {
								   $catedata['unr_voucher_id'] = $id; 
								   $catedata['category']       = 220; 
								   $catedata['updated_at']     = $now; 
								   $catedata['created_at']     = $now; 
								   \DB::table('voucher_category')->insert($catedata);
								   unset($catedata);
							   }
							   foreach($kk[$key] as $vkey=>$val)
							   {
								   $catedata['unr_voucher_id']  = $id; 
								   $catedata['category']  = $val; 
								   $catedata['updated_at']  = $now; 
								   $catedata['created_at']  = $now; 
								   \DB::table('voucher_category')->insert($catedata);
							   }
							}
						}						
					}										
					
				}
				else 
				{ 
					$this->error('-- File Missing/No excel rows to process');
					//$cron->status = 3;
					//$cron->save();
					die(); 
				}
				
				//Delete File
				$this->info('-- deleting file from server.');
				//\DB::table('excel_upload')->where('filename',$fname)->delete();	
				
				$importfile->delete();
				//Send Notification
				$result = Voucher::get_pipeline_import();
		
		 		event(new \App\Events\EventDynamicChannel('importnoti','',$result));
				
				$this->info('-- file deleted.event fired');
			}
			
		}
		else
		{
			$this->error('-- no files in pipeline.');
		}
		$this->info('-- cron status updated.');
		//Update Cron Status
		$cron->status = 3;
		$cron->save();
		
		event(new \App\Events\EventDynamicChannel('unr-import','',''));
    }
	
	
	private function sort_voucher($gencate, $categories)
	{
		foreach($categories as $key=> $cate)
		{
			$category= '';

			if($gencate == $cate->display_name)
			{

				if($cate->parent_id == '0')
				{
					$category= $cate->id;
				}
				else
				{
					$category= $cate->parent_id;
				}
				
				return $category;
			}
			else
			{
				$category= '180';
			}
		}
		return $category;
	}
	
}












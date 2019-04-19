<?php

namespace App\Console\Commands;


use App\Http\Controllers\TestController;
use Carbon\Carbon;
use Illuminate\Console\Command;
use App\Voucher;
class NouseImher extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = '';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import Voucher';
	
	public $cronname  = 'simport_voucher';

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
        $this->error('-- moved to another file');exit();return FALSE;
		ini_set('max_execution_time', 0);
		ini_set('memory_limit', '-1');
		$this->info('-- Cron start to work');
		//Check Cron Status 
		$cron  = \App\CronManager::where('cron_name',$this->cronname)->first();
		if ($cron->status != 3)
		{
			$this->error('-- Cron already running or hold by another process.');exit();return FALSE;
		}
		$cron->status = 1;
		$cron->save();
		
		//Check Files in pipeline
		$result  = \DB::table('excel_upload')->groupBy('filename')
                 ->get();
		//print_r($result);
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
						$file[$filecolumn->file_title_loc_id] = $filecolumn->sys_field_id;

						$cfile[$filecolumn->file_title_loc_id] = $slist[$filecolumn->sys_field_id];
					}			
				}	

				if (empty($cfile)) 
				{
					$this->error('-- No rows to process');
					die();
				}				

				$filename = $filename.'.xls';
				$path     = 'uploads/excel/'.$filename;
				$url      = \Storage::url($path);
				$array_data = [];

				$tdata = \Excel::selectSheetsByIndex(0)->load($url, function($reader){})->get()->toArray();

				$count = count($tdata);

				if ($count > 0) {			
					$arrayhead = $tdata[0];
					$i = 1;
					
					foreach (array_chunk($tdata,500) as $keyc=>$data) {
						
					foreach ($data as $key=> $val) 
					{
						if (empty($val['product_name'])) {
							break;
						}
						$ke = array_keys($val);

						foreach ($val as $akey=>$voar) 
						{	
							$m = 0;
							$insdata = array();
							foreach($ke as $mkey=>$mva)
							{	
								if (!empty($cfile[$m]))
								{
									$re_field = $cfile[$m];

									$insdata[$re_field] = $val[$mva];
									$insdata['source_file'] = $filename;
									$insdata['updated_at']  = $now; 
									$insdata['created_at']  = $now;
									
									if ($re_field == 'expiry_datetime')
									{
										
										if (!empty($insdata['expiry_datetime']))
										{
											$ud = $insdata['expiry_datetime'];
											$ud = str_replace('.','/',$ud);		
											$insdata['expiry_datetime'] = Carbon::parse($ud)->format('Y-m-d H:i:s');
										}
										else
										{
											$insdata['expiry_datetime'] = null;
										}
									}

									if ($re_field == 'product_category')
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
				else 
				{ 
					$this->error('-- File Missing/No excel rows to process');
					die(); 
				}
				//Send Notification
				//Delete File
				//$filename = 'upv1555031330';
				$this->info('-- deleting file from server.');
				\DB::table('excel_upload')->where('filename',$fname)->delete();	
				
				$importfile->delete();
				
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












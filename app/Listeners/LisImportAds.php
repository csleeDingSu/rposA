<?php

namespace App\Listeners;

use App\Events\ImportAds;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Storage;

use App\Product;
use Excel;
use DB;
use Carbon\Carbon;
use App\ad_display;

class LisImportAds
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
     * @param  ImportAds  $event
     * @return void
     */
    public function handle(ImportAds $event)
    {
        ini_set('memory_limit', '4024M');
		ini_set('max_execution_time', 900);
		
		$fname = $event->filename ;
		
		$queuet   = Product::QueuedList($fname)->toArray();
		$systitle = Product::get_csvtitle('ads')->toArray();
				
		$cfile = array();
		$flist = $queuet;
		foreach ($systitle as $key=>$filecolumn)
		{
			$slist[$filecolumn->id] = $filecolumn->title;
		}
		
		foreach ($flist as $key=>$filecolumn)
		{
			$file[$filecolumn->file_title_loc_id] = $filecolumn->sys_field_id;

			$cfile[$filecolumn->file_title_loc_id] = $slist[$filecolumn->sys_field_id];
		}		
		
		
		if (empty($cfile)) die('No rows to process');
		
		$filename = $fname.'.xls';
		$path = 'uploads/ads/'.$filename;
		$url = Storage::url($path);
		
		$data = Excel::selectSheetsByIndex(0)->load($url, function($reader){})->get()->toArray();
		
		$count = count($data);
		
		if ($count > 0) {			
			$arrayhead = $data[0];
			$i = 1;
			foreach ($data as $key=> $val) 
			{
				$ke = array_keys($val);
				
				foreach ($val as $akey=>$voar) 
				{	
					$m = 0;
					$insdata = array();
					foreach($ke as $mkey=>$mva)
					{	
						$now = Carbon::now();
						
						if (!empty($cfile[$m]))
						{
							$insdata['created_at'] = $now ;
							
							$re_field = $cfile[$m];								
							
							$insdata[$re_field] = $val[$mva];							
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
			foreach (array_chunk($dbc,800) as $t) {
			   //DB::table('ad_display')->insert($t);
				ad_display::insert($t);
			}
		}
		else { die('File Missing/No excel rows to process'); }
    }	
	
}
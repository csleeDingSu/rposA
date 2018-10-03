<?php

namespace App\Listeners;

use App\Events\GenerateVoucher;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Storage;

use App\Voucher;
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
        ini_set('memory_limit', '4024M');
		ini_set('max_execution_time', 900);
		
		$filename = $event->filename ;
		
		$queuet   = Voucher::QueuedList($filename)->toArray();
		$systitle = Voucher::get_csvtitle()->toArray();
		
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
						if (!empty($cfile[$m]))
						{
							$re_field = $cfile[$m];
							
							$insdata[$re_field] = $val[$mva];
							$insdata['source_file'] = $filename;
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
			   DB::table('unreleased_vouchers')->insert($t);
			}
		}
		else { die('File Missing/No excel rows to process'); }
    }
}
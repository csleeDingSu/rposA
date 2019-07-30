<?php

namespace App\Listeners;

use App\Events\ImportSoftpins;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Storage;

use App\Product;
use Excel;
use DB;
use Carbon\Carbon;

class LisImportSoftpins
{
    
	public $product = '';
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
     * @param  ImportSoftpins  $event
     * @return void
     */
    public function handle(ImportSoftpins $event)
    {
        ini_set('memory_limit', '4024M');
		ini_set('max_execution_time', 900);
		
		$fname = $event->filename ;
		
		$queuet   = Product::QueuedList($fname)->toArray();
		$systitle = Product::get_csvtitle()->toArray();
				
		$this->product = Product::get_ajax_product_list()->toArray();
		$cfile = array();
		$flist = $queuet;
		foreach ($systitle as $key=>$filecolumn)
		{
			$slist[$filecolumn->id] = $filecolumn->title;
		}
		
		foreach ($flist as $key=>$filecolumn)
		{
			//if (!empty($filecolumn->file_title_loc_id))
			//{
				$file[$filecolumn->file_title_loc_id] = $filecolumn->sys_field_id;
				
				$cfile[$filecolumn->file_title_loc_id] = $slist[$filecolumn->sys_field_id];
			//}			
		}		
		
		
		if (empty($cfile)) die('No rows to process');
		
		$filename = $fname.'.xls';
		$path = 'uploads/softpins/'.$filename;
		$url = Storage::url($path);
		
		$data = Excel::selectSheetsByIndex(0)->load($url, function($reader){})->get()->toArray();
		
		$count = count($data);
		
		if ($count > 0) {			
			$arrayhead = $data[0];
			$i = 1;
			foreach ($data as $key=> $val) 
			{
				if (empty($val)) continue;
				
				$ke = array_keys($val);
				
				foreach ($val as $akey=>$voar) 
				{
					// if (empty($voar)) continue;
						
					$m = 0;
					$insdata = array();
					foreach($ke as $mkey=>$mva)
					{	
						if (!empty($cfile[$m]))
						{
							$re_field = $cfile[$m];
							
							$now = Carbon::now();
							
							$insdata['created_at'] = $now ;
							
							if ($re_field == 'product_name')
							{
								$insdata['product_id'] = self::findproduct($val[$mva]);
							}							
							else if ($re_field == 'expiry_at')
							{
								$dat =  $val[$mva];
								
								$expdate = Carbon::createFromFormat('Y-m-d',  $dat); 
								
								$insdata[$re_field] = $expdate;
							}
							else 
							{
								$insdata[$re_field] = $val[$mva];
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
			
			foreach (array_chunk($dbc,800) as $t) {
			   DB::table('softpins')->insert($t);
			}
		}
		else { die('File Missing/No excel rows to process'); }
    }
	
	private function findproduct($gencate)
	{
		foreach($this->product as $key => $product)
		{
			if ( $product->product_display_id == $gencate )
			{
				return $product->id;
			}			
		}
		return 0;
	}
}
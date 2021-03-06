<?php

namespace App\Console\Commands;


use App\Http\Controllers\TestController;
use Carbon\Carbon;
use Illuminate\Console\Command;
use App\Voucher;
class DeleteVoucher extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bulkdelete:voucher';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Bulk Delete Voucher';
	
	public $cronname       = 'voucher_bulk_delete';

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
		$cat_id = [];
		//Check Cron Status 
		$cron  = \App\CronManager::where('cron_name',$this->cronname)->first();
		$cs    = array(2, 3);
		if (!in_array($cron->status, $cs)) 
		{	
			$this->error('-- Cron already running or hold by another process.');exit();return FALSE;
		}
		$cron->status = 1;
		$cron->save();
		
		$last_process_id = $cron->total_limit;
		
		$models = \App\Unreleasedvouchers::where('id', '<=', $cron->total_limit)->get()->toArray();
		
		foreach (array_chunk($models,500) as $keyc=>$data) 
		{
			
			foreach($data as $key=>$val)
			{
				$cat_id[] = $val['id'] ;
				
				$this->info('-- getting data '.$val['id']);
			}
			$this->info('-- deleting records.');
			\DB::table('voucher_category')
			->whereIn('unr_voucher_id',$cat_id)
			->delete();
			$this->info('-- deleting vouchers.');
			\App\Unreleasedvouchers::destroy($cat_id);
			
			$cat_id = [];
		}
		
		$this->info('-- All Deleted.');
		
		event(new \App\Events\EventDynamicChannel('unr-bulkdelete','',''));
		
		//Update Cron Status
		$cron->status          = 3;
		$cron->total_limit     = 0;
		$cron->last_process_id = $last_process_id;
		$cron->save();
		$this->info('-- cron status updated.');
		$this->info('-- Done');		
    }		
	
}












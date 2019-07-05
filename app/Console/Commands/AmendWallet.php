<?php

namespace App\Console\Commands;

use App\Game;
use App\Http\Controllers\TestController;
use Carbon\Carbon;
use Illuminate\Console\Command;

class AmendWallet extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'amend:wallet';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'amend wallet point';

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
       /*
	   $data = \DB::table('mainledger')->where('is_batched',0)->where('current_point','>',9)->get()->toArray();
		foreach (array_chunk($data,100) as $key=>$value) {
			foreach ($value as $val)
			{
				$opoint = $val->current_point;
				$npoint = $opoint / 10;
				$opoint = $val->current_point;
				$npoint = $opoint / 10;
				
				\DB::table('mainledger')
				->where('id', $val->id)
				->update(['current_point'=>$npoint,'is_batched'=>1]);				
				$this->info($val->member_id.'-- updated point from '.$opoint. ' to '.$npoint);
			}		   
		}		
		*/
		
		$data = \DB::table('mainledger')->where('is_batched',0)->where('current_life_acupoint','>',9)->get()->toArray();
		foreach (array_chunk($data,100) as $key=>$value) {
			foreach ($value as $val)
			{
				$opoint = $val->current_life_acupoint;
				$npoint = $opoint / 10;
				
				\DB::table('mainledger')
				->where('id', $val->id)
				->update(['current_life_acupoint'=>$npoint,'is_batched'=>1]);				
				$this->info($val->member_id.'-- updated point from '.$opoint. ' to '.$npoint);
			}		   
		}	
		
		
		
    }	
}












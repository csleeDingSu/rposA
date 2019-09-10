<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use App\Draw;
class GenerateResult extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'batch:run';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'batch';

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
		$this->comment('-- Stared:'.' '.Carbon::now()->toDateTimeString());	
		
		$this->line('-- fetch members');
		
		$games   = \DB::table('games')->get();
		$members = \App\Member::where('is_batched' , 1)
			//->where('id' , 71)
			->limit(100)->get();
				
		foreach ($members as $row) {
			$this->line('-- create ledger for user. '.$row->phone);
			\App\Ledger::intiateledger($row->id);	
			$this->info('-- done');
			$this->line('-- get main ledger for. '.$row->phone);
			$wallet = \App\Wallet::where('member_id',$row->id)->first();	
						
			if ($wallet)
			{
				//ledger point migrate	
				$this->line('-- create ledger data');
				
				\App\Ledger::intiateledger($row->id);
				$this->info('-- done');
				$this->line('-- migrate points');
				$ledger = \App\Ledger::where('member_id',$row->id )->where('game_id', 102)->first();	

				$ledger->point      = $ledger->point + $wallet->current_point;
				$ledger->life       = $ledger->life  + $wallet->current_life;
				$ledger->balance    = $ledger->balance + $wallet->current_balance;
				$ledger->acupoint   = $ledger->acupoint + $wallet->current_life_acupoint;
				$ledger->played     = $ledger->played + $wallet->play_count;

				$ledger->save();
				$this->info('-- done');
				$this->line('-- updating mainedger');
				$wallet->current_point   = 0;
				$wallet->current_life    = 0;
				$wallet->current_balance = 0;
				$wallet->current_life_acupoint = 0;
				$wallet->play_count      = 0;
				$wallet->save();
				$this->info('-- done');
				$row->is_batched = 2;
			}
			else
			{
				$this->error('-- missing wallet');
				$row->is_batched = 3;
			}
			
			
			$this->line('-- update member row');
			
			$row->save();
			$this->info('-- done');
        }
 			
			
		$this->line('-- End:'.' '.Carbon::now()->toDateTimeString());		
		$this->info('-- All done');
    }		
}












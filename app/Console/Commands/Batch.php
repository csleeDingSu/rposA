<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use App\WalletHistory;
class Batch extends Command
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


    public $historytable = '';
    public $progressBar = '';
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
			//->where('id' , 17)
			->limit(100)->get();
				
		foreach ($members as $row) {
				$this->line('-- create ledger for user '.$row->phone);
			\App\Ledger::intiateledger($row->id);	
				$this->info('-- done');
				$this->line('-- get main ledger for '.$row->phone);
			$wallet = \App\Wallet::where('member_id',$row->id)->first();	
						
			if ($wallet)
			{
				//ledger point migrate	
					$this->line('-- create ledger data');				
				\App\Ledger::intiateledger($row->id);
					$this->info('-- done');
					$this->line('-- migrate points');
				$ledger = \App\Ledger::where('member_id',$row->id )->where('game_id', 102)->first();
				$ledger->point      = $ledger->point    + $wallet->current_point;
				$ledger->life       = $ledger->life     + $wallet->current_life;
				$ledger->balance    = $ledger->balance  + $wallet->current_balance;
				$ledger->acupoint   = $ledger->acupoint + $wallet->current_life_acupoint;
				$ledger->played     = $ledger->played   + $wallet->play_count;
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
				//update ledger history
				$query      = \App\WalletHistory::where('is_batched' , 1)->where('member_id', $row->id);
				$queryCount = $query->count();
					$this->line('-- Total History '.$queryCount);
					$this->line('-- migrate History ');
				$this->progressBar = $this->output->createProgressBar($queryCount);
        		$this->progressBar->start();

				$this->historytable = \App\History::getTableName();

				$query->chunk(200, function ($rows) use ($queryCount) {										
		            $rows->each(function ($oldhis) {
		            		$this->progressBar->advance();	
		                $ledgerhistory = new \App\History();
		                $ledgerhistory->created_at   = $oldhis->created_at;
		                $ledgerhistory->updated_at   = $oldhis->updated_at;
		                $ledgerhistory->member_id    = $oldhis->member_id;
		                $ledgerhistory->ledger_type  = $oldhis->credit_type;
		                $ledgerhistory->credit       = $oldhis->credit;
		                $ledgerhistory->debit        = $oldhis->debit;
		                $ledgerhistory->uuid         = unique_numeric_random($this->historytable, 'uuid', 15);			
		                $ledgerhistory->notes        = $oldhis->notes;
		                if ( $oldhis->current_life)
		                {
		                	$ledgerhistory->balance_before = $oldhis->before_life;
		                	$ledgerhistory->balance_after  = $oldhis->current_life;
		                }
		                else
		                {
		                	$ledgerhistory->balance_before = $oldhis->balance_before;
		                	$ledgerhistory->balance_after  = $oldhis->balance_after;
		                }
		                $ledgerhistory->is_migrated  = 1;
		                $ledgerhistory->game_id      = 102;

		                //update record
		                $oldhis->is_batched = 2;
		                $oldhis->save();
		                //save new history data
		                $ledgerhistory->save();
		            });
		        });
		        $this->progressBar->finish();
					$this->line('');
					$this->info('-- done');				
			}
			else
			{
					$this->error('-- missing wallet');
				$row->is_batched = 3;
			}			
			//update member table
			$row->save();
			$this->info('-- migrated completed to '.$row->phone);
        }				
		$this->line('-- End:'.' '.Carbon::now()->toDateTimeString());		
		$this->info('-- All done');
    }	

}












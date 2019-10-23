<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
class RankGenerator extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:rank';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'generate rank';

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
		$this->line('-- fetch games');		
		$games = \App\Game::select('*')
				->get();
		
		$this->info('-- done');		
		
		$this->line('-- truncate old records');		
			\App\RankNew::query()->truncate();
		$this->info('-- done');
		
		foreach ($games as $key=>$game)
		{
					
			$this->line('-- generate ranks for game : '.$game->id);
			
			$cards = \DB::select("set @i = 0");
			
			//\DB::connection()->enableQueryLog();
			$select  = \DB::raw("totalreward,totallose,balance, member_id, game_id,phone,wechat_name,username");
			$ranks   = \App\Betting::select($select);
			$ranks   = $ranks->where('game_id',$game->id);
			$orderBy = 'balance';
			if ($game->id == '102') $orderBy = 'totalreward';
			$ranks  = $ranks->orderBy($orderBy,'DESC')
							->get();
			//@i := coalesce(@i + 1, 1) rank, 		

			$this->info('-- done');
			//$queries = \DB::getQueryLog();		
		
			//dd($queries);		
			$preval  = '';
			$prerank = '';	
			$newrank = 0;
			foreach ($ranks->chunk(200) as $records)
			{
				foreach ($records as $row)
				{
					if ($row->balance != $prerank)
					{
						$newrank++;
					}
					$prerank = $row->balance;

					if ($game->id != '102')
					{
						if ($row->balance > 0 )
						{
							$this->line('-- update ranks for game : '.$game->id);
							$rank = \App\RankNew::firstOrNew( ['member_id'=>$row->member_id,'game_id'=>$game->id] );
							$rank->rank        = $newrank;					
							$rank->totalreward = $row->totalreward;
							$rank->balance     = $row->balance;
							$rank->save();
							$this->info('-- done');
						}
						else
						{
							$this->error('-- balance in negative.skipping record');
						}
					}
					else
					{
						$rank = \App\RankNew::firstOrNew( ['member_id'=>$row->member_id,'game_id'=>$game->id] );
						$rank->rank        = $newrank;					
						$rank->totalreward = $row->totalreward;
						$rank->balance     = $row->balance;
						$rank->save();
						$this->info('-- done');
					}				


					
				}
			}			
			$this->line('-- ranks update completed for : '.$game->id);
			$this->line(' ');
		}
				
		$this->line('-- End:'.' '.Carbon::now()->toDateTimeString());		
		$this->info('-- All done');
    }		
}












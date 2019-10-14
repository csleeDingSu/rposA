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
		
			//@i := coalesce(@i + 1, 1) rank, 
			$select = \DB::raw("betamt,rewardamt, member_id, game_id,phone,wechat_name,username");
			$ranks  = \App\Betting::select($select);
			$ranks = $ranks->where('game_id',$game->id);		

			$ranks  = $ranks->orderBy('lose','DESC')
							->get();	

			$this->info('-- done');
			//$queries = \DB::getQueryLog();		
		
			//dd($queries);			
			$newrank = 1;
			foreach ($ranks->chunk(200) as $records)
			{
				foreach ($records as $row)
				{
					$this->line('-- update ranks for game : '.$game->id);
					$rank = \App\RankNew::firstOrNew( ['member_id'=>$row->member_id,'game_id'=>$game->id] );
					$rank->rank      = $newrank;
					$rank->total_bet = $row->betamt;
					$rank->win       = $row->rewardamt;
					$rank->balance   = $row->rewardamt- $row->betamt;
					$rank->save();

					$this->info('-- done');
					$newrank++;
				}
			}
			
			$this->line('-- ranks update completed for : '.$game->id);
			$this->line(' ');
		}
				
		$this->line('-- End:'.' '.Carbon::now()->toDateTimeString());		
		$this->info('-- All done');
    }		
}












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
		
		//mysql data seek pointer not reset to 0 so to fix that we pass the dynamic variibale 
		$arr = ['0'=>'i','1'=>'j','2'=>'k','3'=>'l','4'=>'m','5'=>'n','6'=>'p','7'=>'q',];
		
		foreach ($games as $key=>$game)
		{
			$ds = $arr[$key];			
			$this->line('-- generate ranks for game : '.$game->id);
			
			$cards = \DB::select("set @i = 0");
			
			//\DB::connection()->enableQueryLog();
		
			//@i := coalesce(@i + 1, 1) rank, 
			$select = \DB::raw("sum(credit) as credit, member_id, game_id,phone,wechat_name,username");
			$ranks  = \App\History::select($select);
			$ranks = $ranks->where('game_id',$game->id);		

			$ranks  = $ranks->where(function($query) {
								$query->where('ledger_type' , 'LIKE' ,'AP%');
								$query->orWhere('ledger_type' , 'CRPNT');
							})
							->join('members', 'members.id', '=', \App\History::getTableName().'.member_id')
							->groupby('member_id','game_id')
							->orderBy('credit','DESC')
							->get();
			$this->info('-- done');
			//$queries = \DB::getQueryLog();		
		
			//dd($queries);
			
			$newrank = 1;
			foreach ($ranks->chunk(200) as $records)
			{
				//dd($records);
				foreach ($records as $row)
				{
					$this->line('-- update ranks for member : '.$row->member_id);
					$rank = \App\Rank::firstOrNew( ['member_id'=>$row->member_id,'game_id'=>$game->id] );
					$rank->rank   = $newrank;
					$rank->credit = $row->credit;
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












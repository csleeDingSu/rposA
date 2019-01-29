<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use App\Game;

class GenerateGameResult extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:gameresult';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate the Game result every day';

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
        
		$this->comment('Stared:'.'----------'.Carbon::now()->toDateTimeString().'----------');
		//get Game list
		$gamelist  = Game::all();
 
        foreach ($gamelist as $game) {
			//Get Game Category
			$category  = Game::get_game_category($game->game_category);
			
			$category = json_decode ($category);
			if (isset($category->id))
			{
				switch($category->id)
				{
					//fortune game
					case '1':
						//$result = $this->GenerateRandomresult($game,$category);
						$result = $this->GenerateGameRandomresult($game,$category->game_time,$category->block_time);
					break;
				}
			}
        }
 		
		$this->line('End:'.'-------------'.Carbon::now()->toDateTimeString().'----------');
		
		$this->info('-------------All done----------');
    }
	
	private function GenerateGameRandomresult($game,$game_time = 30,$freeze_time = 10)
	{
		$sec = 0;
		$tomorrow = Carbon::tomorrow();
		$totalDuration = 0;
		$result =  \DB::table('game_result')->where('game_id', '=', $game->id)->latest()->first();
		
		if ($result)
		{
			$gexptime = Carbon::parse($result->expiry_time);		
		
			$now = Carbon::now()->toDateTimeString();
			
			$totalDuration = $tomorrow->diffInSeconds($gexptime);
		}
		
		if ($totalDuration>0)
		{
			$sec = $totalDuration;
		}
		
		$insdata = [];
		
		$now = Carbon::now()->toDateTimeString();
		
		$sec = 0;
		$tomorrow = Carbon::tomorrow();
		$i = 1;
		$unix = 0;
		while ($i<=3)
		{				
			$someTime = Carbon::now()->addSeconds($sec);
			
			$d['now']   = $someTime->toDateTimeString();
			
			$someTime1  = $someTime->addSeconds($game_time);			
					
			$unix = $someTime1->timestamp;
			
			$d['expiry'] = $someTime1;
			$d['unix']   = $unix;
			
			$sds = Carbon::parse($someTime1);
			
			$someTime2  = $sds->subSeconds($freeze_time);
			
			$d['block_time'] = $someTime2;
			
			$da    = $this->ResultGenerate($game->id,$d);
			
			$sec = $sec +  $game_time;			
						
			$insdata[] = $da;			
			$this->info('----------- '.$i.' - Generating result----------');			
			if ($d['now'] >= $tomorrow)
			{
				$i = 10;
			}
			
			$i++;
		}
		foreach (array_chunk($insdata,800) as $t) {
		   \DB::table('game_result')->insert($t);
		}
		
		//$id = '1';
		
		$this->info('-------------New Result set Inserted----------');
		
		$this->info('-------------Clean expired Result----------');
        $this->Cleanexpiredresult($game->id);
		
		return $result;
	}
	
	private function ResultGenerate($id,$date)
	{
		$now     = $date['now'];
		$expiry  = $date['expiry'];
		$unixnow = $date['unix'];
		$b_time  = $date['block_time'];
		
		$row['game_id']           = $id; 
		$row['game_level_id']     = null;			
		$row['created_at']        = $now; 
		$row['updated_at']        = $now; 
		$row['result_generation_time']        = $b_time;
		$row['expiry_time']       = $expiry; 
		$row['unix_expiry_time']  = $unixnow; 
		$row['game_result']       = generate_random_number(1,6); //generate random number		
		return $row;
	}
	
	
	private function Cleanexpiredresult($gameid = FALSE)
	{
		$now = Carbon::now()->timestamp;
		$items = Game::get_expiredresult($now, $gameid);	
		
		if ($items)
		{
			Game::archive_data($items);
		}
		
		//delete old data
		Game::clean_expiredresult($now, $gameid);
	}
	
	
	private function GenerateRandomresult($game,$category = false)
	{
		$result  = '';
		$insdata = [];
		
		$now = Carbon::now()->toDateTimeString();
				
		//Generate result for levels
		$insdata = $this->Generateresult($game->id,$value = false);
		
		$items = Game::get_gameresult($game->id);		
		
		//update new result
		if ($items)
		{
			//remove expired results
			Game::archive_data($items);
		}
		
		//delete old data
		Game::force_delete($game->id);
		
		Game::insert_gameresult($insdata);
		return $result;
	}
	
	
	private function OldGenerateRandomresult($game,$category = false)
	{
		return false;
		/*$level   = Game::get_gamelevel($game->id);
		$result  = '';
		$insdata = [];
		
		$now = Carbon::now()->toDateTimeString();
		
		//Generate result for levels
		foreach ($level as $key=>$value)
		{
			$insdata = $this->Generateresult($game->id,$value);
		}
		$items = Game::get_gameresult($game->id);
		if ($items)
		{
			//remove expired results
			Game::archive_data($items);
		}
		//delete old data
		Game::force_delete($game->id);
		//update new result
		if ($insdata)
		{
			Game::insert_gameresult($insdata);
		}
			
		return $result;*/
	}
	
	private function Generateresult($id,$value)
	{
		$now    = Carbon::now()->toDateTimeString();
		$expiry = Carbon::now()->addSeconds(60)->toDateTimeString(); 
		
		//@todo -: use this for live
		//$expiry = Carbon::now()->addSeconds($value->play_time)->toDateTimeString(); 

		$row['game_id']       = $id; 
		//$row['game_level_id'] = $value->id;			
		$row['game_level_id'] = null;			
		$row['created_at']   = $now; 
		$row['updated_at']   = $now; 		
		$row['expiry_time']  = $expiry; 
		$row['game_result']  = generate_random_number(1,6); //generate random number
		
		return $row;
	}
}












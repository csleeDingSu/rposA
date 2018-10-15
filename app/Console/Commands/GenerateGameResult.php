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
    protected $description = 'Generate the Game result every x min';

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
						$result = $this->GenerateRandomresult($game,$category);
					break;
				}
			}
        }
 		
		$this->line('End:'.'-------------'.Carbon::now()->toDateTimeString().'----------');
		
		$this->info('-------------All done----------');
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












<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use Carbon\Carbon;
use App\Game;

class ProcessGameResult extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'game:gs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate Game Result';

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
		//Get Game category
		$this->error('This not in use');exit();
		$this->info('-------------Getting Game Category----------');
		$rdate['now']    = $data['last_run'] = Carbon::now()->toDateTimeString();
		$rdate['to']     = $to   = Carbon::now()->addSeconds(2)->toDateTimeString(); 
		//$rdate['to_ts']  = Carbon::now()->addSeconds(2)->timestamp(); 
		
		$rdate['unix_next_run']  = Carbon::now()->addSeconds(2)->timestamp;		
		
		$category  = Game::get_game_category('',$rdate);		
		
		if (!empty($category))
		{
			$this->info('-------------Process Game Category----------');
			foreach ($category as $cat) {
				$this->info('-------------Getting Game List by Category ID----------');
				//Get Games list
				$gamelist  = Game::get_game_bycategory($cat->id);

				foreach ($gamelist as $game) {
					//Generate Result
					switch($cat->id)
					{
						//fortune games
						case '1':
							$this->info('-------------Generate Result for - '.$game->game_name.' ----------');
							$this->GenerateGameRandomresult($game,$cat->game_time);
							
							
							$this->info('-------------Clean expired Result----------');
							$this->Cleanexpiredresult($game->id);
						break;
					}					
				}

				$this->info('-------------Update next run details - '.$cat->name.' ----------');
				//Update Cron Time
				$data['next_run']      = Carbon::now()->addSeconds($cat->game_time)->toDateTimeString();
				$data['unix_next_run'] = Carbon::now()->addSeconds($cat->game_time)->timestamp;
				
				$gamelist  = Game::update_category($cat->id, $data);
			}
		}
		else 
		{
			$this->error('-------------Nothing to Process----------');
		}

		
		$this->info('-------------All done----------');
		$this->line('End:'.'-------------'.Carbon::now()->toDateTimeString().'----------');
		$this->info('');
		
    }
	
	private function Cleanexpiredresult($gameid = FALSE)
	{
		$now = Carbon::now()->timestamp;
		$items = Game::get_expiredresult($now, $gameid);	
		if ($items)
		{
			//remove expired results
			Game::archive_data($items);
		}
		
		//delete old data
		Game::clean_expiredresult($now, $gameid);
	}
	
	private function GenerateGameRandomresult($game,$game_time = 30)
	{
		$result  = '';
		//return;
		$insdata = [];
		
		$now = Carbon::now()->toDateTimeString();
		//Generate result for levels
		$insdata = $this->Generateresult($game->id,$game_time);
		
		
		/*
		$items = Game::get_expiredresult($now, $game->id);	
		if ($items)
		{
			//remove expired results
			Game::archive_data($items);
		}
		
		//delete old data
		Game::clean_expiredresult($now, $game->id);
		
		*/
		
		/*
		$items = Game::get_gameresult($game->id);		
		
		//update new result
		if ($items)
		{
			//remove expired results
			Game::archive_data($items);
		}
		
		//delete old data
		Game::force_delete($game->id);
		*/
		$id = Game::insert_gameresult($insdata);
		//echo 'insid-'.$id;
		
		$this->info('-------------New Result Inserted '.$id.'----------');
		
		return $result;
	}
	
	
	private function Generateresult($id,$sec)
	{
		$now     = Carbon::now()->toDateTimeString();
		$expiry  = Carbon::now()->addSeconds($sec)->toDateTimeString(); 
		$unixnow = Carbon::now()->addSeconds($sec)->timestamp;
		
		$row['game_id']           = $id; 
		$row['game_level_id']     = null;			
		$row['created_at']        = $now; 
		$row['updated_at']        = $now; 		
		$row['expiry_time']       = $expiry; 
		$row['unix_expiry_time']  = $unixnow; 
		$row['game_result']       = generate_random_number(1,6); //generate random number
		
		return $row;
	}
}

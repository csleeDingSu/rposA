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
    protected $signature = 'generate:result {gameid=0}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate the Game result for game 104';

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
		
		$drawid = $this->argument('gameid');
		
		if (empty($drawid ) )
		{
			$this->error('-- unknown gameid');
		}		
		$draw = new draw();
		$draw->game_id = $drawid;
		$draw->result  = generate_random_number(1,6); 
		$draw->save();
		$this->info('-- Result Generated');
		event(new \App\Events\EventDynamicChannel('ResultUpdated', '',$draw->id));		
		$this->line('-- End:'.' '.Carbon::now()->toDateTimeString());		
		$this->info('-- All done');
    }		
}












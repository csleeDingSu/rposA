<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use App\Game;
class ArchiveExpiredResult extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'game:archiveresult';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Archive Expired Game result';

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
        $this->info('-------------Getting Expired result----------');
		$now = Carbon::now()->timestamp;
		$items = Game::get_expiredresult($now);
		if ($items)
		{
			$this->info('-------------Data Found----------');
			
			Game::archive_data($items);
			$this->info('-------------Data Archived----------');
		}
		$this->info('-------------Delete Archived result from Main Table----------');
		//delete old data
		Game::clean_expiredresult($now);
    }	
	
}

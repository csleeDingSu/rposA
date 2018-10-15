<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use App\Game;
class DeleteOldGameResults extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'clean:gamehistory';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'remove game history old records from the table';

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
        //
		//$date = Carbon::yesterday();
		$this->line('Start:'.'-------------'.Carbon::now()->toDateTimeString().'----------');
		$this->info('cleaning game result history');
		$date = Carbon::now()->subDays(1)->toDateTimeString();
		$gamelist  = Game::DeleteGameHistory($date);
		$this->line('End:'.'-------------'.Carbon::now()->toDateTimeString().'----------');
    }
}

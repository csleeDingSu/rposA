<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;


use App\Members;

class GenerateApiKey extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:apikey';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate API key for Members';

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
				
        $now    = Carbon::now();		
		
		$users = Members::whereNull('apikey')->get();
		foreach ($users as $user) {
			$user->apikey = unique_numeric_random('members', 'apikey', 8);
			$user->save();
			$this->info('--> API key added to '.$user->username);		
		}
				
		$this->line('End:'.'-------------'.Carbon::now()->toDateTimeString().'----------');
		
		$this->info('-------------All done----------');		
    }
	
}












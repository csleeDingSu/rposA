<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use App\Game;
use Validator;
use App\Wallet;
use App\member_game_result;
use App\member_game_bet_temp;

use App\member_game_notification;
use App\Package;
class open_draw extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'game:opendraw {drawid=0}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Open new draw for all conencted Members';

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
		
		
		$drawid = $this->argument('drawid');
        
        if ($drawid == '0') $drawid = 1546;
		
		
		//$drawid = 5676  ;
		
		$draw =  \DB::table('game_result')->where('id', '=', $drawid)->first();
		
		
		if (!$draw) dd('unknown draw');
		
		$mers = \DB::table('redis')->select('member_id')->get();
				
		if ($mers)
		{			
			foreach ($mers as $key => $val)
			{
				$now = Carbon::now();
				$futureresult = Game::get_future_result($draw->game_id, $now );
				$setting      = \App\Admin::get_setting();
				$data         = ['drawid'=> $draw->id, 'futureresults' => $futureresult,'wabaofee' => $setting->wabao_fee];
				event(new \App\Events\EventGameSetting($val->member_id,$data)); //@todo:-move to outisde of the loop
			}
		}
				
		$this->line('End:'.'-------------'.Carbon::now()->toDateTimeString().'----------');
		
		$this->info('-------------All done----------');
    }
	
}












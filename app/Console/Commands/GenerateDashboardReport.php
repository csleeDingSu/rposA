<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use App\Report;

class GenerateDashboardReport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:dashboardreport';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate dashboard result data';

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
        $today = Now(); //Carbon::today();
		$this->comment('Stared:'.'----------'.Carbon::now()->toDateTimeString().'----------');
		//get Game list
		$report['pending_wechat']               = Report::pending_wechat();
		$report['pending_vip_verification']     = Report::pending_vip_verification();
		$report['pending_redeem_verification']  = Report::pending_redeem_verification();
		$report['total_active_user']  			= Report::total_active_user();
		$report['total_inactive_user']  		= Report::total_inactive_user();
		$report['today_user_registration']  	= Report::today_user_registration( $today );
		$report['total_game_bet']  				= Report::total_game_bet();
		$report['total_game_lose']  			= Report::total_game_lose();
		$report['today_game_player']  			= Report::today_game_player( $today );
		$report['today_game_bet']  				= Report::total_game_bet( $today );
		$report['today_game_lose'] 				= Report::total_game_lose( $today );		
		$report['total_vip_game_bet']  			= Report::total_game_bet('','vip');
		$report['total_vip_game_lose']  		= Report::total_game_lose('','vip');
		$report['today_vip_game_player']  		= Report::today_game_player( $today ,'vip');
		$report['today_vip_game_bet']  			= Report::total_game_bet( $today ,'vip');
		$report['today_vip_game_lose']  		= Report::total_game_lose( $today ,'vip');		
		$report['total_product_redeem']  		= Report::total_product_redeem();
		$report['total_package_redeem']  		= Report::total_package_redeem();		
		$report['today_product_redeem']  		= Report::total_product_redeem($today);
		$report['today_package_redeem']  		= Report::total_package_redeem($today);
		$report['ledger_points']    			= Report::ledger_points();
		$report['ledger_vip_points']  			= Report::ledger_points('vip');
		$report['unreleased_voucher_count']     = Report::voucher_count(true);
		$report['pending_basic_package_verification']     = Report::pending_basic_verification();
		
		//right now data
		$report['current_game_player']  			= Report::current_game_player( $today );
		$report['current_vip_game_player']  			= Report::current_game_player($today, 'vip');
		
		$re = Report::wabao_redeem_user();		
		foreach ($re as $ruser)
		{
			switch ($ruser->package_type)
			{
				case '1':
					$report['total_flexi_user']    			= $ruser->count; 
					break;
				case '2':
					$report['total_prepaid_user']    		= $ruser->count;
					break;
			}
		}
		
		$now = Carbon::now()->toDateTimeString();
		$nextupdate = Carbon::now()->addMinutes(5)->toDateTimeString(); 
		$report['updated_at']  = $now;
		$report['next_update']  = $nextupdate;






		$this->info('Updating to server');
		 Report::update_data($report);
 		$this->info('Completed');
        
 		
		$this->line('End:'.'-------------'.Carbon::now()->toDateTimeString().'----------');
		
		event(new \App\Events\EventDashboardChannel('dashboard-info',$report));
		
		$this->info('-------------All done----------');
    }
	
	
}












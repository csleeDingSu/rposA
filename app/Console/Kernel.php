<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        Commands\GenerateGameResult::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $date = date('Ymd', time());
		// $schedule->command('inspire')
        //          ->hourly();
		//$schedule->command('generate:gameresult')->everyMinute();
		$this
           ->scheduleInDayCommands($schedule);
		
		
    }
	
	protected function scheduleInDayCommands(Schedule $schedule) {
		$date = date('Ymd', time());
		$schedule->command('generate:gameresult')
            ->everyMinute()->appendOutputTo(storage_path('logs/gameresult_'.$date.'.log'));
		//$schedule->command('mail:sendmail')->everyFiveMinutes(); //to send mail
	}
	
	protected function scheduleDailyCommands(Schedule $schedule) {
		//no action
	}
	
	protected function scheduleOnDayCommands(Schedule $schedule) {
	}

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}

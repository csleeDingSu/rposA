<?php

namespace App\Console\Commands;

use App\Http\Controllers\PaymentController;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Console\option;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class payment extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:payment {option=0}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'monitor payment status';

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
    	try {

            // $option = $this->option('param');
            $option = $this->argument('option');
        
			$this->comment('---Start:'.Carbon::now()->toDateTimeString().'---');
			$this->comment("option: $option");		
            \Log::info("This a command payment. option value: $option");

            $_Controller = app(PaymentController::class);
            if ($option == 'trade_query') {
                $res = $_Controller->MonTradeQuery();
            } else if ($option == 'trade_expired') {
                $res = $_Controller->MonTradeExpired();
            }else if ($option == 'trade_query_vip') {
                $res = $_Controller->MonTradeQuery_vip();
            } else if ($option == 'trade_expired_vip') {
                $res = $_Controller->MonTradeExpired_vip();
            } else {
                $res = "do nothing [option => trade_query, trade_expired, trade_query_vip, trade_expired_vip]";
            }

            $this->comment($res);
            $this->comment('---End:'.Carbon::now()->toDateTimeString().'---');
            return $res;
        } 
        catch (\Exception $e) 
        { 
            $data='console payment: ' . (string) $e;
            \Log::error($data);

        }

    }

}












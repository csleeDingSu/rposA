<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
class ResellAutoBuy extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'resell:autobuy';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'auto buy resell';

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
        $this->line('-- fetch data');       
        $result = \App\CreditResell::where('status_id' , 2)->where('created_at' ,'<' , Carbon::now()->subHours(3))->get();
        
        $this->info('-- done');
                
        foreach ($result as $key=>$resell)
        {
            $this->line('-- add buy data');
            $companydata = \App\CompanyBank::with('member')->first();
            $type        = 'companyaccount';
            
            $resell->buyer_id    = $companydata->member->id;
            $resell->status_id   = 3;
            $resell->is_locked   = null;
            $resell->locked_time = null;       
            $resell->is_autobuy  = 1;       
            $resell->save();            
            //add history
            $history             = new \App\ResellHistory();
            $history->cid        = $resell->id;
            $history->status_id  = 3;
            $history->point      = $resell->point;
            $history->member_id  = $resell->member_id;
            $history->buyer_id   = $resell->buyer_id;
            $history->reason     = 'auto buy from admin member'; 
            $history->uuid       = $record->uuid;
            $history->save();           
                        
            $this->line('-- done');
        }
                
        $this->line('-- End:'.' '.Carbon::now()->toDateTimeString());       
        $this->info('-- All done');
    }       
}












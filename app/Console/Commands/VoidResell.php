<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
class VoidResell extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'resell:void';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'update void resell';

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
        $result = \App\CreditResell::where('is_locked' , 1)->where('locked_time' ,'<' , now())->get();
        
        $this->info('-- done');     
                
        foreach ($result as $key=>$record)
        {
                    
            $this->line('-- reset row : '.$record->id);
            $record->buyer_id    = null; 
            $record->is_locked   = null; 
            $record->locked_time = null;
            $record->buyer_id    = null; 
            $record->reason      = null; 
            $record->barcode     = null; 
            $record->status_id   = 1;
            $status              = 'cron reset';
            $record->save();   
            //add history
            $history             = new \App\ResellHistory();
            $history->cid        = $record->id;
            $history->status_id  = 5;
            $history->point      = $record->point;
            $history->save();             
                        
            $this->line('-- record reset with default values');
            $this->line(' ');
        }
                
        $this->line('-- End:'.' '.Carbon::now()->toDateTimeString());       
        $this->info('-- All done');
    }       
}












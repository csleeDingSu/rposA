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
       // \DB::enableQueryLog();    
        $result = \App\CreditResell::where('is_locked' , 1)->where('locked_time' ,'<' , Carbon::now()->toDateTimeString() )->get();
        //print_r(\DB::getQueryLog());
       // print_r($result);
        $this->info('-- done');     
                
        foreach ($result as $key=>$record)
        {
            $this->line('-- replicate row : '.$record->id); 
            $new = $record->replicate();       
            $expired             = new \App\ExpiredResell();
            $expired->fill($new->toArray());
            $expired->status_id   = 5;
            $expired->reason      = 'time exceeded';
            $expired->save();
            $notification         = '';
            $this->line('-- reset row : '.$record->id);
            if ($record->type == 1)
            {
                $record->status_id   = 5;
                $record->reason      = 'time exceeded';
                $record->is_locked   = null; 
                $record->locked_time = null; 
            }
            else 
            {
                $record->buyer_id    = null; 
                $record->is_locked   = null; 
                $record->locked_time = null;
                $record->buyer_id    = null; 
                $record->reason      = null; 
                $record->barcode     = null; 
                $record->status_id   = 2; 
                $notification        = 'yes';
            }
            
            $record->save();  

            //add history
            $history             = new \App\ResellHistory();
            $history->cid        = $record->id;
            $history->status_id  = 5;
            $history->member_id  = $record->member_id;
            $history->buyer_id   = $record->buyer_id;
            $history->point      = $record->point;
            $history->reason     = 'time expired'; 
            $history->uuid       = $record->uuid;
            $history->save();             
                        
            $this->line('-- record reset with default values');
            $this->line(' ');
           // if ($notification)
           // {
                $this->line('-- send notification');  
                $result = \App\CreditResell::with('status','member','buyer')->where('buyer_id', $record->member_id)->where('is_locked', 1)->latest()->get();

                $count  = $result->count();

                $data   = [ 'count'=>$count,  'records'=>$result];

                //buyer
                event(new \App\Events\EventDynamicChannel($record->member_id.'-pending-buyer','',$data ));
                $data   = '';
                $status = [1,2,3];
                $result = \App\ViewCreditResell::with('status','member','buyer')->where('member_id' , $record->member_id)->latest()->wherein('status_id', $status)->latest()->get();

                $count  = $result->count();

                $data   = [ 'count'=>$count,  'records'=>$result];
                //seller
                event(new \App\Events\EventDynamicChannel($record->member_id.'-pending-seller','',$data ));
                $this->info('-- done');
           // }            
            
        }
                
        $this->line('-- End:'.' '.Carbon::now()->toDateTimeString());       
        $this->info('-- All done');
    }       
}












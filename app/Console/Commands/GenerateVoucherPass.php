<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use App\Voucher;
class GenerateVoucherPass extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:vpass {type=vo}';
    
    public $limit = 1;
    public $table = 'vouchers';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate Voucher pass using CURL & third party website';

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
        $srate = 0;
        $frate = 0;
        $starttime = Carbon::now()->toDateTimeString();
       
       // $this->comment('Stared:'.'----------'.$starttime.'----------');
        
        $arguments = $this->argument('type');
        
        if ($arguments == 'uv') $this->table = 'unreleased_vouchers';        
        
        $vouchers = Voucher::get_voucher_withoutpass($this->table, $this->limit);
        $count    = $vouchers->count();
        foreach ($vouchers as $row) {
            $keyword = $row->product_detail_link;
            $flag = 2;            
            if ($row->product_detail_link)
            {
                $pass =  $this->getcurl($keyword);
                $pass =  trim($pass);
                if ($pass) 
                {
                    $flag = 1;
                    $srate++;
                    $this->info(' Id:'.$row->id.' pass :'.$pass);
                }
                else
                {
                    $frate++;
                    $this->error(' Cannot find pass for ID :'.$row->id);
                }
                                    
                $data = ['voucher_pass'=>$pass, 'pass_access_flag'=>$flag ];
            } 
            else
            {
                $this->error(' Unknown Product Link. ID:'.$row->id);
                $data = ['pass_access_flag'=>$flag ];
            }            
            Voucher::update_voucher($this->table, $row->id, $data);
        }
        
        $endtime = Carbon::now()->toDateTimeString();
        
         
        $this->info('Processed Count :'.$count);
        $this->info('Success Process Count :'.$srate);
        $this->info('Failed Process Count :'.$frate);
        //$this->info('Process Start Time :'.$starttime);
        $this->info('Process End Time   :'.$endtime);
        
        $this->line(' ');        
		
    }
    
    private function getcurl($keyword)
    {        
        //'https://detail.tmall.com/item.htm?id=579853855835',
        $curl = curl_init();
        
        curl_setopt_array($curl, array(
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => 'http://www.iwangshang.com/taokouling/index.php',
            CURLOPT_USERAGENT => 'cURL Request',
            CURLOPT_POST => 1,
            CURLOPT_POSTFIELDS => array(
                'keyword'=> $keyword,
            )
        ));
        
        $resp = curl_exec($curl);
        
        if($resp) {            
            return $this->filter_content( $resp );
        } 
    }
    
    private function filter_content($content) 
    {
        $str  = '<button class="itemCopy"';
		$arr  = explode($str, $content);
		$arr  = explode('</button', $arr[1]);	
		$from = '￥';
		$to   = '￥';
		$sub  = substr($arr[0], strpos($arr[0],$from)+strlen($from),strlen($arr[0]));
		$sub  = substr($sub,0,strpos($sub,$to));
		$sub  = trim($sub);
		
		if ($sub)
		{
			$sub = '￥'.$sub.'￥';
			return $sub;
		}		
        return FALSE;
    }
}







<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use App\vouchers_yhq;
class GetProductFromYHQ extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'getproduct';
    
    public $limit = 60;
    public $table = 'vouchers_yhq';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get product and voucher info from yhq.cn website';

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
        //start
        $starttime = Carbon::now()->toDateTimeString();
        $this->info('Process Start Time   :'.$starttime);

        //test url - 居家日用
        $product_category = '居家日用';
        $url = "http://yhq.cn/index.php?r=l&u=767538&cid=4"; 
        $this->info('URL :'.$url);

        //original response
        $res =  $this->getcurl($url);
        $this->info('Original response :'.$res);

/*
        //filter unwanted data
        $content = $this->filter_content($res);
        $this->info('Filter unwanted data :'.$content);

        //update data into database
        $filter = ['voucher_id'=>$voucher_id];
        $params = ['product_name' => '', 'product_picurl' => '', 'product_category' => $product_category, 'product_price' => '', 'voucher_price' => '', 'discount_price' => '', 'voucher_pass' => '', 'pass_access_flag' => 1];
        $array = array_merge($filter, $params);
        $result = vouchers_yhq::updateOrCreate($filter, $array)->id;
        $this->info('Result ID :'.$result);

        //end
        $endtime = Carbon::now()->toDateTimeString();
        $this->info('Process End Time   :'.$endtime);
        
        $this->line(' ');        
*/		
    }
    
    private function getcurl($url)
    {        
        $payload = [];
        $headers = [];//['Content-Type: application/x-www-form-urlencoded'];
        $option = ['connect_timeout' => 60, 'timeout' => 180];
        $client = new \GuzzleHttp\Client(['http_errors' => true, 'verify' => false]);
        $request = $client->get($url, ['headers' => $headers, 'form params' => $payload]);
        $response = $request->getBody()->getContents();
        return $response;
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







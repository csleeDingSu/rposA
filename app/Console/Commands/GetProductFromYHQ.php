<?php

namespace App\Console\Commands;

use App\vouchers_yhq;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
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

        //test url 
        $url = "http://yhq.cn"; //"http://yhq.cn/index.php?r=l&u=767538&cid=4"; //居家日用 
        $this->info('URL :'.$url);

        //original response
        $this->getcurl($url);
        
        //$this->info('Original response');
        //var_dump($res);

        //filter unwanted data
        //$content = $this->filter_content($res);
        //$this->info('Filter unwanted data :'.$content);
/*
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
        // $client = new \GuzzleHttp\Client();
        // // Send an asynchronous request.
        // $request = new \GuzzleHttp\Psr7\Request('GET', $url);
        // $promise = $client->sendAsync($request)->then(function ($response) {
        //     // echo 'I completed! ' . $response->getBody();
        //     echo 'Completed! ';
        //     $res = $response->getBody();
        //     $this->info($res);
        //     $content = $this->filter_content($res);
        //     $this->info($content);

        // });
        // $promise->wait();
        
        $remote_file_url = "http://localhost:8899/yhq_test.txt";
        $file = fopen($remote_file_url, "r");
        $temp = null;
        while (($line = fgets($file)) !== false) {
            $temp .= $line;
          // echo $line;
        }
        fclose($file);
        $content = $this->filter_content($temp);

    }
    
    private function filter_content($content) 
    {
        $items = [];

        //get total page
        $str  = '<a class="item more" href="javascript:void(0);">...</a>';
        $arr  = explode($str, $content);
        if (isset($arr[1])) {
            $arr  = explode('<a class="next-page"', $arr[1]);   
            $from = '">';
            $to   = '</a>';
            $sub  = substr($arr[0], strpos($arr[0],$from)+strlen($from),strlen($arr[0]));
            $sub  = substr($sub,0,strpos($sub,$to));
            $pages  = trim($sub);    
        } else {
            $pages = -1;
        }

        //get product list
        $str  = '<div class="list_cent">';
        $arr  = explode($str, $content);
        if (isset($arr[1])) {

            //products
            $arr  = explode('<a target="_blank" class="goods_list" ', $arr[1]);   
            var_dump($arr[0]);
            $from = 'href="';
            $to   = '">';
            $sub  = substr($arr[0], strpos($arr[0],$from)+strlen($from),strlen($arr[0]));
            $sub  = substr($sub,0,strpos($sub,$to));
            var_dump($sub);
            $items[]  = trim($sub);    
        
            // $products = $arr[1];

            // do{
            //     $_str  = '<a target="_blank" class="goods_list" ';
            //     $_arr  = explode($_str, $products);
            //     if ($_arr[1]) {

            //         //get product detail url
            //         $from = 'href="';
            //         $to   = '">';
            //         $sub  = substr($_arr[0], strpos($_arr[0],$from)+strlen($from),strlen($_arr[0]));
            //         $sub  = substr($sub,0,strpos($sub,$to));
            //         $product_detail_url  = trim($sub);
            //         $items[] = $product_detail_url;

            //         //get next product
            //         $__str  = '<a target="_blank" class="goods_list" ';
            //         $products  = explode($__str, $products);

            //     } else {
            //         break;
            //     }
            // }while(false);
                
        }

        $result = ['pages' => $pages, 'items' => $items];
        var_dump($result);
        die('dasdsa');
        
		return $result;
    }
}







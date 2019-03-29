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
    protected $signature = 'getproduct {arg=main}';
    
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

        //url 
        $url = ""; //"http://yhq.cn/index.php?r=l&u=767538"; //"http://yhq.cn"; //"http://yhq.cn/

        //get arguments
        $arguments = $this->argument('arg');

        switch ($arguments) {
            case "main":
                $url = "http://yhq.cn";
                break;
            case "selection":
                $url = "http://yhq.cn/index.php?r=l&u=767538";
                break;
            case "green":
                echo "Your favorite color is green!";
                break;
            default:
                echo "Your favorite color is neither red, blue, nor green!";
        }
        
        //url 
        $url = "http://yhq.cn/index.php?r=l&u=767538"; //"http://yhq.cn"; //"http://yhq.cn/index.php?r=l&u=767538&cid=4"; //居家日用 
        $this->info('URL :'.$url);

        //response
        $this->getcurl($url);
                        		
    }
    
    private function getcurl($url)
    {        
        $client = new \GuzzleHttp\Client();
        // Send an asynchronous request.
        $request = new \GuzzleHttp\Psr7\Request('GET', $url);
        $promise = $client->sendAsync($request)->then(function ($response) {
            // echo 'I completed! ' . $response->getBody();
            echo 'Completed! ';
            $res = $response->getBody();
            // $this->info($res);
            $content = $this->filter_content($res);

            if (count($content['items']) > 0) {

                foreach($content['items'] as $i) {

                    var_dump($i->voucher_id);

                }

            } else {
                $this->error("do nothing");
            }
            
            // //update data into database
            // $filter = ['voucher_id'=>$voucher_id];
            // $params = ['product_name' => '', 'product_picurl' => '', 'product_category' => $product_category, 'product_price' => '', 'voucher_price' => '', 'discount_price' => '', 'voucher_pass' => '', 'pass_access_flag' => 1];
            // $array = array_merge($filter, $params);
            // $result = vouchers_yhq::updateOrCreate($filter, $array)->id;
            // $this->info('Result ID :'.$result);

            // //end
            // $endtime = Carbon::now()->toDateTimeString();
            // $this->info('Process End Time   :'.$endtime);
            
            // $this->line(' ');

        });
        $promise->wait();
        
        // $remote_file_url = "http://localhost:8899/yhq_test.txt";
        // $file = fopen($remote_file_url, "r");
        // $temp = null;
        // while (($line = fgets($file)) !== false) {
        //     $temp .= $line;
        //   // echo $line;
        // }
        // fclose($file);
        // $content = $this->filter_content($temp);

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

            $arr_  = explode('<a target="_blank" class="goods_list" ', $arr[1]);
            $t = 1;

            do {

                // var_dump($arr_[$t]);

                $item = [];

                //url               
                $from = 'href="';
                $to   = '">';
                $sub  = substr($arr_[$t], strpos($arr_[$t],$from)+strlen($from),strlen($arr_[$t]));
                $sub  = substr($sub,0,strpos($sub,$to));
                $item['url']  = trim($sub);
                //img 
                $from = '<img src="';
                $to   = '" ';
                $sub  = substr($arr_[$t], strpos($arr_[$t],$from)+strlen($from),strlen($arr_[$t]));
                $sub  = substr($sub,0,strpos($sub,$to));
                $item['pic_url']  = trim($sub); 
                //id
                $from = '<span data-gid="';
                $to   = '">';
                $sub  = substr($arr_[$t], strpos($arr_[$t],$from)+strlen($from),strlen($arr_[$t]));
                $sub  = substr($sub,0,strpos($sub,$to));
                $item['voucher_id']  = trim($sub);
                //title   
                $from = '</i>';
                $to   = '</span>';
                $sub  = substr($arr_[$t], strpos($arr_[$t],$from)+strlen($from),strlen($arr_[$t]));
                $sub  = substr($sub,0,strpos($sub,$to));
                $item['title']  = trim($sub);
                //original price
                $from = '<span class="fl">';                
                $to   = '</span>';
                $sub  = substr($arr_[$t], strpos($arr_[$t],$from)+strlen($from),strlen($arr_[$t]));
                $sub  = substr($sub,0,strpos($sub,$to));
                $item['original_price']  = trim(str_replace('</i>','', str_replace('<i>','',str_replace('原价','',$sub))));
                //sales
                $from = '<span class="fr">';
                $to   = '</span>';
                $sub  = substr($arr_[$t], strpos($arr_[$t],$from)+strlen($from),strlen($arr_[$t]));
                $sub  = substr($sub,0,strpos($sub,$to));
                $item['sales']  = trim(str_replace('</i>','', str_replace('<i>','',str_replace('销量','',$sub))));
                //discount price
                $from = '<i class="p">';
                $to   = '</span>';
                $sub  = substr($arr_[$t], strpos($arr_[$t],$from)+strlen($from),strlen($arr_[$t]));
                $sub  = substr($sub,0,strpos($sub,$to));
                $item['discount_price']  = trim(str_replace('<span>','',str_replace('</i>','', str_replace('<i>','',str_replace('￥','',$sub)))));
                //voucher price
                $from = '<b class="fr">';
                $to   = '</span>';
                $sub  = substr($arr_[$t], strpos($arr_[$t],$from)+strlen($from),strlen($arr_[$t]));
                $sub  = substr($sub,0,strpos($sub,$to));
                $item['voucher_price']  = trim(str_replace('</i>','', str_replace('<i>','',str_replace('元券','',$sub))));

                $t += 1;

                $items[] = $item;

                // break;

            // }while(isset($arr_[$t]));
            }while($t == 2);
                
        }

        $result = ['pages' => $pages, 'items' => $items];
        var_dump($result);
        die('dsadsa');
		return $result;
    }
}







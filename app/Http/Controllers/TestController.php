<?php

namespace App\Http\Controllers;

use App\helpers\Sha256Generator;
use App\cron_test;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class TestController extends BaseController
{

    public function __construct() {

        //today
       
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function Test()
    {
    	//return response()->json(['success' => true, 'message' => ' any .. vue test'], 200);      
        return view('test.test');
    }

    public function cron_test()
    {
        $array = ['name' => Carbon::now(), 'description' => '', 'value' => Carbon::now()->timestamp];
        $filter = ['name' => Carbon::now()]; 
        $result = cron_test::updateOrCreate($filter, $array)->id;
        return $result;
    }

    public function reload_card_validation(Request $request)
    {
        try {

            $memberid = $request->input('memberid');
            $amount = $request->input('amount');
            $cardno = $request->input('cardno');
            $cardpwd = $request->input('cardpwd');
            $ext = empty($request->input('ext')) ? '' : $request->input('ext'); //optional
            $orderno = trim($memberid . Carbon::now()->timestamp);
            $sid = env('RELOAD_CARD_API_SID', '10017565');
            $type = empty($request->input('type')) ? 6 : $request->input('type');; //骏网一卡通
            $url = url('/api/reload-card-callback?output=yes');        
            
            $params = "amount=$amount&cardno=$cardno&cardpwd=$cardpwd&ext=$ext&orderno=$orderno&sid=$sid&type=$type&url=$url";

            $signature = Sha256Generator::generateHash($params); 

            $payload = array (
              'amount' => $amount,
              'cardno' => $cardno,
              'cardpwd' => $cardpwd,
              'ext' => $ext,
              'orderno' => $orderno,
              'sid' => $sid,
              'type' => $type,
              'url' => urlencode($url),
              'sign' => $signature
            );

            $API_URL = env('RELOAD_CARD_API_URL');
            
            //log parameter
            \Log::info(['reload card api url' => $API_URL, 'payload' => $payload]);
                       
            $headers = [ 'Content-Type' => "application/x-www-form-urlencoded"];
            $option = ['connect_timeout' => 60, 'timeout' => 180];
            $client = new \GuzzleHttp\Client(['http_errors' => true, 'verify' => false]);
            $response = $client->post($API_URL, ['headers' => $headers, 'form params'=>$payload]);

            //log response
            \Log::info(['reload card api response' => $response]);
            return $response;

        } catch (\Exception $e) {
            //log error
            \Log::error($e);
            return $e->getMessage();
        }
    }

    public function reload_card_callback(Request $request)
    {
        $output = empty($request->input('output')) ? ' - ' : $request->input('output');
        $response = "callback success. output: $output";
        return $response;        
    }

    public function Pay_Index(Request $request)
    {
        try {

            $pay_memberid = env('PAY_ID', '10003');//"10002";   //商户ID
            $pay_orderid = 'E'.Carbon::now()->timestamp.rand(100000,999999);
            //'E'.date("YmdHis").rand(100000,999999);    //订单号
            $pay_amount = $request->input('amount');    //交易金额
            $pay_applydate = Carbon::now()->toDateTimeString(); //date("Y-m-d H:i:s");  //订单时间
            $pay_notifyurl = url('/api/pay_notify');
            //"http://www.yourdomain.com/demo/server.php";   //服务端返回地址
            $pay_callbackurl = url('/api/pay_callback');
            //"http://www.yourdomain.com/demo/page.php";  //页面跳转返回地址
            $Md5key = env('PAY_APIKEY', 'sdq9jiji9i6n181di8faidoln1eqza6g');
            //"t4ig5acnpx4fet4zapshjacjd9o4bhbi";   //密钥
            $tjurl = env('PAY_URL', 'http://d.yvcdv.cn/Pay_Index.html');
            //"http://www.yourdomain.com/Pay_Index.html";   //提交地址
            $pay_bankcode = env('PAY_BANKCODE','915'); //"903";   //银行编码

            //扫码
            $native = array(
                "pay_memberid" => $pay_memberid,
                "pay_orderid" => $pay_orderid,
                "pay_amount" => $pay_amount,
                "pay_applydate" => $pay_applydate,
                "pay_bankcode" => $pay_bankcode,
                "pay_notifyurl" => $pay_notifyurl,
                "pay_callbackurl" => $pay_callbackurl,
            );
            ksort($native);
            $md5str = "";
            foreach ($native as $key => $val) {
                $md5str = $md5str . $key . "=" . $val . "&";
            }
            $sign = strtoupper(md5($md5str . "key=" . $Md5key));
            $native["pay_md5sign"] = $sign;

            //log parameter
            \Log::info(['Pay_Index URL' => $tjurl, 'native' => $native]);
                       
            $headers = [ 'Content-Type' => "text/html; charset=utf-8"];
            $option = ['connect_timeout' => 60, 'timeout' => 180];
            $client = new \GuzzleHttp\Client(['http_errors' => true, 'verify' => false]);
            $response = $client->post($tjurl, ['headers' => $headers, 'form_params'=>$native]);

            //log response
            \Log::info(['Pay_Index response' => $response]);
            return $response;

        } catch (\Exception $e) {
            //log error
            \Log::error($e);
            return $e->getMessage();
        }
        
    }

    public function Pay_Trade_query(Request $request)
    {
        try {
            
            $pay_memberid = env('PAY_ID', '10003');  
            $pay_orderid = $request->input('pay_orderid');            
            $Md5key = env('PAY_APIKEY', 'sdq9jiji9i6n181di8faidoln1eqza6g');
            
            if(empty($pay_memberid)||empty($pay_orderid)){
                    return "信息不完整！";
            }
            $tjurl = env('PAY_TRADE_QUERY', 'http://d.yvcdv.cn/Pay_Trade_query.html');
            $native = array(
                "pay_memberid" => $pay_memberid,
                "pay_orderid" => $pay_orderid
            );
            ksort($native);
            $md5str = "";
            foreach ($native as $key => $val) {
                $md5str = $md5str . $key . "=" . $val . "&";
            }
            $sign = strtoupper(md5($md5str . "key=" . $Md5key));
            $param = $native;
            $param["pay_md5sign"] = $sign;

            //log 
            \Log::info(['Pay_Trade_query URL' => $tjurl, 'param' => $param]);
                       
            $headers = [ 'Content-Type' => "text/html; charset=utf-8"];
            $option = ['connect_timeout' => 60, 'timeout' => 180];
            $client = new \GuzzleHttp\Client(['http_errors' => true, 'verify' => false]);
            $response = $client->post($tjurl, ['headers' => $headers, 'form_params'=>$param]);

            return $response;

        } catch (\Exception $e) {
            //log error
            \Log::error($e);
            return $e->getMessage();
        }
        
    }

    public function pay_callback(Request $request)
    {
        try {

            $returnArray = array( // 返回字段
                "memberid" => $request->input("memberid"), // 商户ID
                "orderid" =>  $request->input("orderid"), // 订单号
                "amount" =>  $request->input("amount"), // 交易金额
                "datetime" =>  $request->input("datetime"), // 交易时间
                "transaction_id" =>  $request->input("transaction_id"), // 流水号
                "returncode" => $request->input("returncode")
            );
            $Md5key = env('PAY_APIKEY', 'sdq9jiji9i6n181di8faidoln1eqza6g');
            // $md5key = "t4ig5acnpx4fet4zapshjacjd9o4bhbi";
            ksort($returnArray);
            reset($returnArray);
            $md5str = "";
            foreach ($returnArray as $key => $val) {
                $md5str = $md5str . $key . "=" . $val . "&";
            }
            $sign = strtoupper(md5($md5str . "key=" . $md5key)); 
            if ($sign == $request->input("sign")) {
                if ($_REQUEST["returncode"] == "00") {
                       $str = "交易成功！订单号：".$request->input("orderid");
                       // exit($str);
                       return $str;
                }
            }

        } catch (\Exception $e) {
            //log error
            \Log::error($e);
            return $e->getMessage();
        }
        
    }

    public function pay_notify(Request $request)
    {
        try {

            $returnArray = array( // 返回字段
                "memberid" => $request->input("memberid"), // 商户ID
                "orderid" =>  $request->input("orderid"), // 订单号
                "amount" =>  $request->input("amount"), // 交易金额
                "datetime" =>  $request->input("datetime"), // 交易时间
                "transaction_id" =>  $request->input("transaction_id"), // 支付流水号
                "returncode" => $request->input("returncode"),
            );
            $Md5key = env('PAY_APIKEY', 'sdq9jiji9i6n181di8faidoln1eqza6g');
            //$md5key = "t4ig5acnpx4fet4zapshjacjd9o4bhbi";
            ksort($returnArray);
            reset($returnArray);
            $md5str = "";
            foreach ($returnArray as $key => $val) {
                $md5str = $md5str . $key . "=" . $val . "&";
            }
            $sign = strtoupper(md5($md5str . "key=" . $md5key));
            if ($sign == $request->input("sign")) {
                if ($request->input("returncode") == "00") {
                       $str = "交易成功！订单号：".$request->input("orderid");
                       file_put_contents("success.txt",$str."\n", FILE_APPEND);
                       // exit("ok");
                       return "ok - $str";
                }
            }

        } catch (\Exception $e) {
            //log error
            \Log::error($e);
            return $e->getMessage();
        }
        
    }

}

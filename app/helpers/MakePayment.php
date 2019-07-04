<?php
namespace App\Helpers;

use App\payment_transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log; 

class MakePayment
{ 
    public static function Pay_Index(Request $request)
    {
        try {
        	$type = $request->input('type');
            $pay_memberid = empty($request->input('pay_memberid')) ? env('PAY_ID', '10003') : $request->input('pay_memberid');//"10002";   //商户ID
            $pay_orderid = 'E'.Carbon::now()->timestamp.rand(100000,999999);
            //'E'.date("YmdHis").rand(100000,999999);    //订单号
            $pay_amount = $request->input('pay_amount');    //交易金额
            $pay_applydate = urlencode(Carbon::now()->toDateTimeString()); //date("Y-m-d H:i:s");  //订单时间
            $pay_notifyurl = url('/api/pay_notify');
            //"http://www.yourdomain.com/demo/server.php";   //服务端返回地址
            $pay_callbackurl = url('/api/pay_callback');
            //"http://www.yourdomain.com/demo/page.php";  //页面跳转返回地址
            $Md5key = empty($request->input('apikey')) ? env('PAY_APIKEY', 'sdq9jiji9i6n181di8faidoln1eqza6g') : $request->input('apikey');
            //"t4ig5acnpx4fet4zapshjacjd9o4bhbi";   //密钥
            $tjurl = env('PAY_URL', 'http://d.yvcdv.cn/Pay_Index.html');
            //"http://www.yourdomain.com/Pay_Index.html";   //提交地址
            $pay_bankcode = empty($request->input('pay_bankcode')) ? env('PAY_BANKCODE','915') : $request->input('pay_bankcode'); //"903";   //银行编码

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
            $native["pay_productname"] = "挖宝充值";
            
            //log parameter
            \Log::info(json_encode(['Pay_Index URL' => $tjurl, 'native' => $native], true));
            \Log::info(json_encode(['md5str' => $md5str], true));
            //insert send payment
            $res_id = payment_transaction::create(['member_id' => $request->input('member_id'),'pay_orderid' => $pay_orderid, 'pay_amount' => $pay_amount, 'pay_params' => json_encode($native, true), 'type' => $type])->id;

            // return ['payment_transaction_id' => $res_id];
            
            $headers = [ 'Content-Type' => "application/x-www-form-urlencoded"];
            $option = ['connect_timeout' => 60, 'timeout' => 180];
            $client = new \GuzzleHttp\Client(['http_errors' => true, 'verify' => false]);
            $req = $client->post($tjurl, ['headers' => $headers, 'form_params'=>$native]);
            $res = $req->getBody(); 

            //update response
            $response = (is_array($res) ? json_encode($res) : $res);
            payment_transaction::where('id', $res_id)->update(['pay_response' => $response]);
            // \Log::info(json_encode(['pay_response' => json_decode($response)],true));

            if (strpos($response,"<title>正在跳转付款页</title>") >= 0) {
                //2nd lv screen (redirect page)
                $_response = self::Pay_Index_2ndScreen($response, $res_id);

                //3nd lv screen (qrcode)
                if (strpos($_response,"<title>微信付款</title>") >= 0) {
                    $__response = self::Pay_Index_3ndScreen($_response, $res_id);
                    return $__response;

                } else {
                    return $_response;
                }

            } else {
                // \Log::info(json_encode(['pay_response' => json_decode($response)],true));
                return $response;
            }

        } catch (\Exception $e) {
            //log error
            \Log::error($e);
            
            if (!empty($res_id)) {
            	payment_transaction::where('id', $res_id)->update(['remark' => $e->getMessage()]);	
            }
            
            return $e->getMessage();
        }
        
    }

    public static function Pay_Index_2ndScreen($content, $res_id) //正在跳转付款页
    {

        $str  = '<form method="post"';
        $from = 'action="';
        $to   = '" name="pay">';
        $_action = self::pay_filter_value($content, $str, $from, $to);
        
        $str  = '<input type="hidden" name="pay_amount" ';
        $from = 'value="';
        $to   = '">';
        $_pay_amount = self::pay_filter_value($content, $str, $from, $to);

        $str  = '<input type="hidden" name="pay_applydate" ';
        // $from = 'value="';
        // $to   = '">';
        $_pay_applydate = self::pay_filter_value($content, $str, $from, $to);

        $str  = '<input type="hidden" name="pay_bankcode" ';
        $_pay_bankcode = self::pay_filter_value($content, $str, $from, $to);

        $str  = '<input type="hidden" name="pay_callbackurl" ';
        $_pay_callbackurl = self::pay_filter_value($content, $str, $from, $to);
        //$_pay_callbackurl = url('/api/pay_callback');

        $str  = '<input type="hidden" name="pay_memberid" ';
        $_pay_memberid = self::pay_filter_value($content, $str, $from, $to);

        $str  = '<input type="hidden" name="pay_notifyurl" ';
        $_pay_notifyurl = self::pay_filter_value($content, $str, $from, $to);
        //$_pay_notifyurl = url('/api/pay_notify');

        $str  = '<input type="hidden" name="pay_orderid" ';
        $_pay_orderid = self::pay_filter_value($content, $str, $from, $to);

        $str  = '<input type="hidden" name="pay_md5sign" ';
        $_pay_md5sign = self::pay_filter_value($content, $str, $from, $to);
        
        $_native["pay_amount"] = $_pay_amount;
        $_native["pay_applydate"] = $_pay_applydate;
        $_native["pay_bankcode"] = $_pay_bankcode;
        $_native["pay_callbackurl"] = $_pay_callbackurl;
        $_native["pay_memberid"] = $_pay_memberid;
        $_native["pay_notifyurl"] = $_pay_notifyurl;
        $_native["pay_orderid"] = $_pay_orderid;
        $_native["pay_md5sign"] = $_pay_md5sign;

        // ksort($_native);
        // $md5str = "";
        // foreach ($_native as $key => $val) {
        //     $md5str = $md5str . $key . "=" . $val . "&";
        // }
        // $Md5key = env('PAY_APIKEY', 'sdq9jiji9i6n181di8faidoln1eqza6g');
        // $sign = strtoupper(md5($md5str . "key=" . $Md5key));
        // $_native["pay_md5sign"] = $sign;

        payment_transaction::where('id', $res_id)->update(['redirect_response' => json_encode($_native), 'transaction_id' => $_pay_orderid, 'pay_response_amount' => $_pay_amount]);
        
        $headers = [ 'Content-Type' => "application/x-www-form-urlencoded"];
        $option = ['connect_timeout' => 60, 'timeout' => 180];
        $client = new \GuzzleHttp\Client(['http_errors' => true, 'verify' => false]);
        $_req = $client->post($_action, ['headers' => $headers, 'form_params'=>$_native]);
        $_res = $_req->getBody();
        $_response = (is_array($_res) ? json_encode($_res) : $_res);

        //update 2nd screen response
        payment_transaction::where('id', $res_id)->update(['pay_response_2nd' => $_response]);
        // \Log::info(json_encode(['pay_response_2nd' => $_response],true));

        return $_response;
        
    }

    public static function Pay_Index_3ndScreen($content, $res_id) //qrcode
    {
        $str  = '<div class="money">';
        $from = '<span id="money">';
        $to   = '</span>';
        $money = self::pay_filter_value($content, $str, $from, $to);

        $str  = 'var qrcode = new QRCode(document.getElementById("showqr"), {';
        $from = 'text: "';
        $to   = '",';
        $qrcode = self::pay_filter_value($content, $str, $from, $to);
        if (empty($qrcode)) {

            $html = $content;

        } else {

            payment_transaction::where('id', $res_id)->update(['qrcode_response' => $content, 'pay_final_amount' => $money, 'qrcode' => $qrcode]);

            return ['status' => true,'payment_transaction_id' => $res_id, 'pay_final_amount' => $money, 'qrcode' => $qrcode];
        }

        return $html;

    }

    public static function pay_filter_value($content, $str, $from, $to)
    {
        $result = null;
        $arr  = explode($str, $content);
        if (isset($arr[1])) {
            $sub  = substr($arr[1], strpos($arr[1],$from)+strlen($from),strlen($arr[1]));
            $sub  = substr($sub,0,strpos($sub,$to));
            $result = trim($sub);   
        }
        return $result;
    }

    public static function Pay_Trade_query(Request $request)
    {
        try {
            
            $pay_memberid = empty($request->input('pay_memberid')) ? env('PAY_ID', '10003') : $request->input('pay_memberid');;  
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
            \Log::info(json_encode(['Pay_Trade_query URL' => $tjurl, 'param' => $param],true));
                       
            // $headers = [ 'Content-Type' => "text/html; charset=utf-8"];
            $headers = [ 'Content-Type' => "application/x-www-form-urlencoded"];
            $option = ['connect_timeout' => 60, 'timeout' => 180];
            $client = new \GuzzleHttp\Client(['http_errors' => true, 'verify' => false]);
            $req = $client->post($tjurl, ['headers' => $headers, 'form_params'=>$param]);
            $res = json_decode($req->getBody());
            // $req->rewind();
            // $res = $req->getContents();
            
            $transaction_id = $res->data[0]->transaction_id;
            $trade_state = $res->data[0]->trade_state;
            $pay_final_amount = $res->data[0]->amount;

            $response = json_encode($res, true);

             //update response
            payment_transaction::where('pay_orderid', $pay_orderid)->update(['transaction_id' => $transaction_id, 'trade_state' => $trade_state, 'pay_final_amount' => $pay_final_amount, 'query_response' => $response]);

            \Log::info(json_encode(['query_response' => $response],true));

            return $response;

        } catch (\Exception $e) {
            //log error
            \Log::error($e);
            return $e->getMessage();
        }
        
    }

    public static function pay_callback(Request $request)
    {
        try {

            $str = null;

            $returnArray = array( // 返回字段
                "memberid" => $request->input("memberid"), // 商户ID
                "orderid" =>  $request->input("orderid"), // 订单号
                "amount" =>  $request->input("amount"), // 交易金额
                "datetime" =>  urlencode($request->input("datetime")), // 交易时间
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
            // if ($sign == $request->input("sign")) {
                if ($request->input("returncode") == "00") {
                       // $str = "交易成功！订单号：".$request->input("orderid");
                       // exit($str);
                        $str = '<html><body>';
                        $str .= '<div>交易成功！订单号：' .$request->input("orderid") . '</div>';
                        $str .= '<br/>';
                        $str .= '<a href="wabao666.com">OK</a>';
                        $str .= '</body></html>';

                } else {
                    $str = $returnArray;
                }
            // } else {

                // $str = $returnArray;

            // }

            \Log::info(json_encode(['callback_response' => (is_array($str) ? json_encode($str) : $str)],true));

            //update response
            payment_transaction::where('pay_orderid', $orderid)->update(['callback_response' => (is_array($str) ? json_encode($str) : $str)]);

            return $str;

        } catch (\Exception $e) {
            //log error
            \Log::error($e);
            return $e->getMessage();
        }
        
    }

    public static function pay_notify(Request $request)
    {
        try {

            $returnArray = array( // 返回字段
                "memberid" => $request->input("memberid"), // 商户ID
                "orderid" =>  $request->input("orderid"), // 订单号
                "amount" =>  $request->input("amount"), // 交易金额
                "datetime" =>  urlencode($request->input("datetime")), // 交易时间
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
            // if ($sign == $request->input("sign")) {
                if ($request->input("returncode") == "00") {
                       $str = "交易成功！订单号：".$request->input("orderid");
                       // file_put_contents("success.txt",$str."\n", FILE_APPEND);
                       // exit("ok");
                       // return $str";
                } else {

                    $str = $returnArray;

                }
            // } else {
            //     $str = $returnArray;
            // }

            \Log::info(json_encode(['notify_response' => (is_array($str) ? json_encode($str) : $str)],true));

            //update response
            payment_transaction::where('pay_orderid', $orderid)->update(['notify_response' => (is_array($str) ? json_encode($str) : $str)]);

            return $str;

        } catch (\Exception $e) {
            //log error
            \Log::error($e);
            return $e->getMessage();
        }
        
    }


}

?>
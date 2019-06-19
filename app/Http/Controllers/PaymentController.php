<?php

namespace App\Http\Controllers;

use App\Http\Controllers\ProductController as ProductController;
use App\Http\Controllers\Api\ProductController as ApiProductController;
use App\helpers\Sha256Generator;
use App\payment_transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;

class PaymentController extends BaseController
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

    public function membership_buy_vip(Request $request)
    {

        $member_id = Auth::guard('member')->user()->id ;
        $request->merge(['member_id' => $member_id]); 
        $request->merge(['pay_amount' => 120]); 
        // $data = ['payment_transaction_id' => '999', 'pay_final_amount' => '120', 'qrcode' => 'abc'];
        $data = $this->Pay_Index($request);

        if (is_array($data)) {
            if (!empty($data['payment_transaction_id'])) {
                //submit vip upgrade
                $upgrade_vip = $this->submit_vip_upgrade($member_id);
                //store vip upgrade id
                if (empty($upgrade_vip->refid)) {
                    $data = ['payment_transaction_id' => '-1', 'pay_final_amount' => '0', 'qrcode' => null];
                } else {
                    payment_transaction::where('id', $data['payment_transaction_id'])->update(['upgrade_vip_id' => $upgrade_vip->refid]);    
                }                
            }
        } else {
            $data = json_decode($data, true);
        }

        return view('client/membership_buy_vip', $data);
    }

    public function Pay_Index(Request $request)
    {
        try {

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
            \Log::info(['Pay_Index URL' => $tjurl, 'native' => $native]);
            \Log::info(['md5str' => $md5str]);
            //insert send payment
            $res_id = payment_transaction::create(['member_id' => $request->input('member_id'),'pay_orderid' => $pay_orderid, 'pay_amount' => $pay_amount, 'pay_params' => json_encode($native, true)])->id;

            $headers = [ 'Content-Type' => "application/x-www-form-urlencoded"];
            $option = ['connect_timeout' => 60, 'timeout' => 180];
            $client = new \GuzzleHttp\Client(['http_errors' => true, 'verify' => false]);
            $req = $client->post($tjurl, ['headers' => $headers, 'form_params'=>$native]);
            $res = $req->getBody(); 

            //update response
            $response = (is_array($res) ? json_encode($res) : $res);
            payment_transaction::where('id', $res_id)->update(['pay_response' => $response]);
            \Log::info(['pay_response' => $response]);

            if (strpos($response,"<title>正在跳转付款页</title>") >= 0) {
                //2nd lv screen (redirect page)
                $_response = $this->Pay_Index_2ndScreen($response, $res_id);

                //3nd lv screen (qrcode)
                if (strpos($_response,"<title>微信付款</title>") >= 0) {
                    $__response = $this->Pay_Index_3ndScreen($_response, $res_id);
                    return $__response;

                } else {
                    return $_response;
                }

            } else {
                \Log::info(['pay_response' => json_decode($response)]);
                return $response;
            }

        } catch (\Exception $e) {
            //log error
            \Log::error($e);
            return $e->getMessage();
        }
        
    }

    public function Pay_Trade_query(Request $request)
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
            \Log::info(['Pay_Trade_query URL' => $tjurl, 'param' => $param]);
                       
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

            \Log::info(['query_response' => $response]);

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

            \Log::info(['callback_response' => (is_array($str) ? json_encode($str) : $str)]);

            //update response
            payment_transaction::where('pay_orderid', $orderid)->update(['callback_response' => (is_array($str) ? json_encode($str) : $str)]);

            return $str;

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

            \Log::info(['notify_response' => (is_array($str) ? json_encode($str) : $str)]);

            //update response
            payment_transaction::where('pay_orderid', $orderid)->update(['notify_response' => (is_array($str) ? json_encode($str) : $str)]);

            return $str;

        } catch (\Exception $e) {
            //log error
            \Log::error($e);
            return $e->getMessage();
        }
        
    }

    public function pay_filter_value($content, $str, $from, $to)
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

    public function Pay_Index_2ndScreen($content, $res_id) //正在跳转付款页
    {

        $str  = '<form method="post"';
        $from = 'action="';
        $to   = '" name="pay">';
        $_action = $this->pay_filter_value($content, $str, $from, $to);
        
        $str  = '<input type="hidden" name="pay_amount" ';
        $from = 'value="';
        $to   = '">';
        $_pay_amount = $this->pay_filter_value($content, $str, $from, $to);

        $str  = '<input type="hidden" name="pay_applydate" ';
        // $from = 'value="';
        // $to   = '">';
        $_pay_applydate = $this->pay_filter_value($content, $str, $from, $to);

        $str  = '<input type="hidden" name="pay_bankcode" ';
        $_pay_bankcode = $this->pay_filter_value($content, $str, $from, $to);

        $str  = '<input type="hidden" name="pay_callbackurl" ';
        $_pay_callbackurl = $this->pay_filter_value($content, $str, $from, $to);
        //$_pay_callbackurl = url('/api/pay_callback');

        $str  = '<input type="hidden" name="pay_memberid" ';
        $_pay_memberid = $this->pay_filter_value($content, $str, $from, $to);

        $str  = '<input type="hidden" name="pay_notifyurl" ';
        $_pay_notifyurl = $this->pay_filter_value($content, $str, $from, $to);
        //$_pay_notifyurl = url('/api/pay_notify');

        $str  = '<input type="hidden" name="pay_orderid" ';
        $_pay_orderid = $this->pay_filter_value($content, $str, $from, $to);

        $str  = '<input type="hidden" name="pay_md5sign" ';
        $_pay_md5sign = $this->pay_filter_value($content, $str, $from, $to);
        
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
        \Log::info(['pay_response_2nd' => $_response]);

        return $_response;
        
    }

    public function Pay_Index_3ndScreen($content, $res_id) //qrcode
    {
        $str  = '<div class="money">';
        $from = '<span id="money">';
        $to   = '</span>';
        $money = $this->pay_filter_value($content, $str, $from, $to);

        $str  = 'var qrcode = new QRCode(document.getElementById("showqr"), {';
        $from = 'text: "';
        $to   = '",';
        $qrcode = $this->pay_filter_value($content, $str, $from, $to);
        if (empty($qrcode)) {

            $html = $content;

        } else {

            payment_transaction::where('id', $res_id)->update(['qrcode_response' => $content, 'pay_final_amount' => $money, 'qrcode' => $qrcode]);

            return ['status' => true,'payment_transaction_id' => $res_id, 'pay_final_amount' => $money, 'qrcode' => $qrcode];
            
            /*        
            $html = '<html><head>
            <script src="https://api.nx908.com/statics/js/jquery.js"></script>
            <script src="https://api.nx908.com/statics/js/qrcode.min.js"></script>
            <script src="https://api.nx908.com/statics/js/clipboard.min.js"></script>
            <script type="text/javascript" src="https://api.nx908.com/statics/js/toastr.min.js"></script>
            <link rel="stylesheet" href="https://api.nx908.com/statics/css/toastr.min.css">
            <style>
                .money {
                    margin: 30px auto;
                    height: 21px;
                    line-height: 21px;
                    color: #ff0000;
                    font-size: 38px;
                    font-family: HelveticaNeue;
                    text-align: center;
                }

                #showqr {
                    width: 200px;
                    height: 200px;
                    margin: 26px auto;
                    //background: url("images/qr.png") no-repeat;
                    background-size: 100% 100%;
                }
            </style>
            </head><body>';

            $html .= '<div id="money">' . $money . '</div>';
            $html .= '<br/>';
            $html .= '<div id="showqr"></div>';
            $html .= '<div class="time">
                        <div class="minute green">4</div>&nbsp;分&nbsp;<div class="second green">59</div>&nbsp;秒
                    </div>';
            $html .= '</body>
                        <script>
                            var qrcode = new QRCode(document.getElementById("showqr"), {
                                text: "' . $qrcode . '",
                                width: 200,
                                height: 200,
                                colorDark: "#000000",
                                colorLight: "#ffffff",
                                correctLevel: QRCode.CorrectLevel.H
                            });
                        </script>
                        <script>
                            //字体变换
                            var text = document.querySelector(".txt");
                            var txt_arr = ["确认过眼神你是我的菜", "这个二维码很特别特别", "充值未到账请联系客服", "充值未成功请重新生成"];
                            var num = 0;
                            var timer_txt = setInterval(function () {
                                //text.innerText = txt_arr[num];
                                num++;
                                if (num === 4) {
                                    num = 0;
                                }
                            }, 1500)

                            //倒计时
                            var minute = document.querySelector(".minute")
                            var second = document.querySelector(".second")
                            // 准备
                            var countdownMinute = 5 //10分钟倒计时
                            var startTimes = new Date() //开始时间
                            var endTimes = new Date(startTimes.setMinutes(startTimes.getMinutes() + countdownMinute)) //结束时间
                            var curTimes = new Date() //当前时间
                            var surplusTimes = endTimes.getTime() / 1000 - curTimes.getTime() / 1000 //结束毫秒-开始毫秒=剩余倒计时间

                            // 进入倒计时
                            countdowns = window.setInterval(function () {
                                surplusTimes--;
                                var minu = Math.floor(surplusTimes / 60)
                                var secd = Math.round(surplusTimes % 60)
                                // console.log(minu+":"+secd)
                                minu = minu <= 9 ? "0" + minu : minu
                                secd = secd <= 9 ? "0" + secd : secd
                                minute.innerHTML = minu
                                second.innerHTML = secd
                                // checkdata();
                                if (surplusTimes <= 0) {
                                    alert("订单已过期,请勿支付,请重新发起订单！");
                                    window.history.go(-1);
                                    location.reload();
                                    clearInterval(countdowns)
                                }
                            }, 1000)

                            function closeWebPage() {
                                var userAgent = navigator.userAgent;
                                if (userAgent.indexOf("Firefox") != -1 || userAgent.indexOf("Chrome") != -1) {
                                    window.location.href = "about:blank";
                                } else if (userAgent.indexOf("Android") > -1 || userAgent.indexOf("Linux") > -1) {
                                    window.opener = null;
                                    window.open("about:blank", "_self", "").close();
                                } else {
                                    window.pener = null;
                                    window.open("about:blank", "_self");
                                    window.close();
                                }
                            }
                        </script>
            </html>';
            */
        }

        return $html;

    }

    public function submit_vip_upgrade($memberid)
    {
        $request = new Request;
        $request->merge(['memberid' => $memberid]); 
        
        //retrieve package vip id
        $packageid = null;
        $product = new ApiProductController;
        $vip_package = json_decode(json_encode($product->list_package($request),true));
        // $packageid = $vip_package->original->records[0]->id;
        if (!empty($vip_package->original->records)) {
            foreach ($vip_package->original->records as $key => $value) {
                // var_dump($key);
                if (($value->min_point <= 0) && ($value->package_type == 2)) {
                    $packageid = $value->id;
                    // var_dump($packageid);
                    break;    
                }
            }    
        }
        
        //submit
        $request->merge(['packageid' => $packageid]); 
        $res = json_decode(json_encode($product->request_vip($request),true));
        // var_dump(empty($res->original->refid));
        // var_dump($res->original);
        // die('dasdsa');
        // if (empty($res->original->refid)) {
        //     return ['status' => 0, 'output' => $res];
        // } else {
        //     return ['status' => 1, 'refid' => $res->original->refid];
        // }

        return empty($res->original) ? $res : $res->original;
    }

    public function MonTradeQuery()
    {
        $request = new Request;
        $data = payment_transaction::whereNotNull('upgrade_vip_id')
        ->where(function ($query) {
            $query->whereNull('trade_state')
                  ->orWhere(function ($query) {
                    $query->where('trade_state', '<>', 'success')
                    ->Where('trade_state', '<>', 'expired');
                });
              })
        ->get();

        foreach($data as $r) {
            $request->merge(['pay_orderid' => $r->pay_orderid]);
            $res = $this->Pay_Trade_query($request);
            $trade_status = null;
            $vip_package_result = null;
            if (!empty($res)) {
                $_res = json_decode($res);
                $trade_status = empty($_res->data[0]->trade_state) ? null : $_res->data[0]->trade_state;
                if ($trade_status == 'SUCCESS') {
                    //update confirm-vip
                    $product = new ProductController;
                    $request->merge(['id' => $r->upgrade_vip_id]);
                    $vip_package = json_decode(json_encode($product->confirm_vip($request),true));
                    $vip_package_result = ['upgrade_vip_id' => $r->upgrade_vip_id, 'vip_package_result' => $vip_package->original];
                }
            }
            var_dump(['pay_orderid' => $r->pay_orderid, 'trade_status' => $trade_status, 'vip_package_result' => $vip_package_result]);
        }           

        return "completed";
        
    }

    public function MonTradeExpired()
    {
        $request = new Request;
        $data = payment_transaction::whereNotNull('upgrade_vip_id')
        ->where(function ($query) {
            $query->whereNull('trade_state')
                  ->orWhere(function ($query) {
                    $query->where('trade_state', '<>', 'success')
                    ->Where('trade_state', '<>', 'expired');
                });
              })
        ->where('created_at', '<', Carbon::now()->subMinutes(5)->toDateTimeString())
        ->get();

        foreach($data as $r) {
            //update to expired
            payment_transaction::where('id',$r->id)->update(['trade_state' => 'expired']);
            //update vip package - reject vip
            $vip_package_result = null;
            $product = new ProductController;
            $request->merge(['id' => $r->upgrade_vip_id]);
            $request->merge(['note' => "订单已过期"]);
            
            $vip_package = json_decode(json_encode($product->reject_vip($request),true));
            $vip_package_result = ['upgrade_vip_id' => $r->upgrade_vip_id, 'vip_package_result' => $vip_package->original];
            var_dump(['pay_orderid' => $r->pay_orderid, 'vip_package_result' => $vip_package_result]);
        } 

        return "completed";
        
    }

}
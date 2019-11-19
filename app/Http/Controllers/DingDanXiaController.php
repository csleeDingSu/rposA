<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class DingDanXiaController extends BaseController
{

    public function __construct() {

        ini_set('max_execution_time', 10800); //180 minutes
        //
       $this->apiKey = env('DINGDANXIA_APIKEY', 'H1XHdUmBXkNUTBrsHUGXqwFvfDQRKqGX');
       $this->payerShowName = env('DINGDANXIA_PAYERSHOWNAME', '挖宝红包补贴');

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return "ding dan xia api";
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

    /**参数加密

     * @param $data

     * @param $appSecret

     * @return string

     */

    function makeSign($data, $appSecret)
    {
        ksort($data);
        $str = '';
        foreach ($data as $k => $v) {

            $str .= '&' . $k . '=' . $v;
        }
        $str = trim($str, '&');
        $sign = strtoupper(md5($str . '&key=' . $appSecret));
        return $sign;
    }

    function getCurl($url) {

        try {

            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, $url);

            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

            curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,0);

            curl_setopt($ch,CURLOPT_TIMEOUT,0);

            curl_setopt($ch, CURLOPT_HEADER, 0);

            $output = curl_exec($ch);

            if (curl_errno($ch)) {
                $error_msg = curl_error($ch);
            }

            curl_close($ch);

            return empty($error_msg) ? $output : $error_msg;
            // return json_encode($output, true);

        } 
        catch (\Exception $e) 
        { 
            $data='getCurl: ' . (string) $e;
            \Log::error($data);
            return null;
        }
    }

    public function pay(Request $request)
    {
        $url = env('DINGDANXIA_APIURL', 'http://api.tbk.dingdanxia.com') . "/pay/transfer";
        
        $payload["apikey"] = empty($request->apikey) ? $this->apiKey : $request->apikey; //require
        $payload["payee_account"] = $request->payee_account; //require
        $payload["amount"] = $request->amount; //require
        $payload["payer_show_name"] = empty($request->payer_show_name) ? $this->payerShowName : $request->payer_show_name;
        $payload["payee_real_name"] = $request->payee_real_name;
        $payload["remark"] = $request->remark;
        $payload["signature"] = ''; //$this->makeSign($payload,$this->appSecret);
        
        $headers = [ 'Content-Type' => "application/x-www-form-urlencoded"];
        $option = ['connect_timeout' => 60, 'timeout' => 180];
        $client = new \GuzzleHttp\Client(['http_errors' => true, 'verify' => false]);
        $req = $client->post($url, ['headers' => $headers, 'form_params'=>$payload]);
        $res = json_decode($req->getBody(), true);
        
        if (!empty($res['code'])) {
            $status = true;
            
            if ($res['code'] != '200') {
                $status = false;
            }

            return ['success' => $status, 'data' => $res];

        } else {
            return $res;
        }
        
    }
}

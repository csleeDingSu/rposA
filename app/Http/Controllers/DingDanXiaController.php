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
       $this->apiKey = env('DINGDANXIA_APIKEY', '5d6a770f7f9cc');
       $this->payerShowName = env('DINGDANXIA_PAYERSHOWNAME', 'test');
       $this->appId = env('DINGDANXIA_APPID', '5d6a770f7f9cc');
       $this->privateKey = env('DINGDANXIA_PRIVATEKEY', '5d6a770f7f9cc');
       $this->publicKey = env('DINGDANXIA_PUBLICKEY', '5d6a770f7f9cc');

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

    public function test()
    {
        return response()->json(['success' => true, 'data' => 'test']); 

        // //接口地址

        // $host = 'http://api.tbk.dingdanxia.com/pay/biz_transfer';
        
        // //默认必传参数
        // $data = [

        //     'apiKey' => $this->apiKey,

        //     'version' => '1',
        // ];

        // //加密的参数
        // $data['sign'] = $this->makeSign($data,$this->appSecret);

        // //拼接请求地址
        // $url = $host .'?'. http_build_query($data);

        // // var_dump($url);
        
        // //执行请求获取数据
        // return $this->getCurl($url);
        
    }

    public function pay(Request $request)
    {
        return response()->json(['success' => true, 'data' => 'test']); 
        //接口地址

        // $host = 'http://api.tbk.dingdanxia.com/pay/biz_transfer';

        //默认必传参数

        // $data = [

        //     'apiKey' => $this->apiKey,

        //     'version' => 'v1.1.0',
            
        //     'pageSize' => empty($request->input('pageSize')) ? 10 : $request->input('pageSize'),

        //     'pageId' => empty($request->input('pageId')) ? 1 : $request->input('pageId'),

        //     'sort' => 2,

        //     'priceLowerLimit' => empty($request->input('priceLowerLimit')) ? 12 : $request->input('priceLowerLimit'),

        //     'priceUpperLimit' => empty($request->input('priceUpperLimit')) ? 99999 : $request->input('priceUpperLimit'),

        // ];

        // return $data;

        //加密的参数
        // $data['sign'] = $this->makeSign($data,$this->appSecret);

        //拼接请求地址
        // $url = $host .'?'. http_build_query($data);

        // var_dump($url);
        
        //执行请求获取数据

        // return json_decode($this->getCurl($url),true);
        
    }
}

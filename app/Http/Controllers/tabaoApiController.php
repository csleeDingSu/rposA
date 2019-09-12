<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class tabaoApiController extends BaseController
{

    public function __construct() {

        //
       
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return "tabao api";
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

    public function test()
    {
        //接口地址

        $host = 'https://openapi.dataoke.com/api/goods/get-goods-list';

        $appKey = '5d6a770f7f9cc';//应用的key

        $appSecret = 'c7fa184a5c92e9a93dc3b0f54d7088bc';//应用的Secret

        //默认必传参数

        $data = [

            'appKey' => $appKey,

            'version' => '1',
        ];

        //加密的参数
        $data['sign'] = $this->makeSign($data,$appSecret);

        //拼接请求地址
        $url = $host .'?'. http_build_query($data);

        // var_dump($url);
        
        //执行请求获取数据

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        curl_setopt($ch,CURLOPT_TIMEOUT,10);

        curl_setopt($ch, CURLOPT_HEADER, 0);

        $output = curl_exec($ch);

        curl_close($ch);

        return $output;

        // return json_encode($output, true);
        
    }

    public function getGoodsList()
    {
        //接口地址

        $host = 'https://openapi.dataoke.com/api/goods/get-goods-list';

        $appKey = '5d6a770f7f9cc';//应用的key

        $appSecret = 'c7fa184a5c92e9a93dc3b0f54d7088bc';//应用的Secret

        //默认必传参数

        $data = [

            'appKey' => $appKey,

            'version' => '1',
        ];

        //加密的参数
        $data['sign'] = $this->makeSign($data,$appSecret);

        //拼接请求地址
        $url = $host .'?'. http_build_query($data);

        // var_dump($url);
        
        //执行请求获取数据

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        curl_setopt($ch,CURLOPT_TIMEOUT,10);

        curl_setopt($ch, CURLOPT_HEADER, 0);

        $output = curl_exec($ch);

        curl_close($ch);

        return $output;

        // return json_encode($output, true);
        
    }


}

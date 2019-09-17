<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class tabaoApiController extends BaseController
{

    public function __construct() {

        //
       $this->appKey = env('TABAO_APPKEY', '5d6a770f7f9cc');//应用的key
       $this->appSecret = env('TABAO_APPSECRET', 'c7fa184a5c92e9a93dc3b0f54d7088bc');//应用的Secret

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

    function getCurl($url) {

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

    public function test()
    {
        //接口地址

        $host = 'https://openapi.dataoke.com/api/goods/get-goods-list';
        
        //默认必传参数
        $data = [

            'appKey' => $this->appKey,

            'version' => '1',
        ];

        //加密的参数
        $data['sign'] = $this->makeSign($data,$this->appSecret);

        //拼接请求地址
        $url = $host .'?'. http_build_query($data);

        // var_dump($url);
        
        //执行请求获取数据
        return $this->getCurl($url);
        
    }

    public function getGoodsList(Request $request)
    {
        //接口地址

        $host = 'https://openapi.dataoke.com/api/goods/get-goods-list';

        //默认必传参数

        $data = [

            'appKey' => $this->appKey,

            'version' => 'v1.1.0',
            
            'pageSize' => empty($request->input('pageSize')) ? 10 : $request->input('pageSize'),

            'pageId' => empty($request->input('pageId')) ? 1 : $request->input('pageId'),

            'sort' => 'total_sales',
        ];

        // return $data;

        //加密的参数
        $data['sign'] = $this->makeSign($data,$this->appSecret);

        //拼接请求地址
        $url = $host .'?'. http_build_query($data);

        // var_dump($url);
        
        //执行请求获取数据

        return json_decode($this->getCurl($url),true);
        
    }

    public function getListSuperGoods(Request $request)
    {
        $host = "https://openapi.dataoke.com/api/goods/list-super-goods";

        //默认必传参数
        $data = [

            'appKey' => $this->appKey,
            'version' => 'v1.2.0',
            'type' => 0,
            'pageId' => empty($request->input('pageId')) ? 1 : $request->input('pageId'),
            'pageSize' => empty($request->input('pageSize')) ? 10 : $request->input('pageSize'),
            'keyWords' => $request->input('search'),
            // 'tmall' => 0,
            // 'haitao' => 0,
            'sort' => 'total_sales',
        ];

        //加密的参数
        $data['sign'] = $this->makeSign($data,$this->appSecret);

        //拼接请求地址
        $url = $host .'?'. http_build_query($data);
        
        return json_decode($this->getCurl($url),true);
        
    }


}

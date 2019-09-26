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

            'sort' => 2,

            'priceLowerLimit' => empty($request->input('priceLowerLimit')) ? 12 : $request->input('priceLowerLimit'),

            'priceUpperLimit' => empty($request->input('priceUpperLimit')) ? 99999 : $request->input('priceUpperLimit'),

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
            'type' => 2,
            'pageId' => empty($request->input('pageId')) ? 1 : $request->input('pageId'),
            'pageSize' => empty($request->input('pageSize')) ? 10 : $request->input('pageSize'),
            'keyWords' => $request->input('search'),
            // 'tmall' => 0,
            // 'haitao' => 0,
            // 'sort' => '_asc', //'total_sales',
        ];

        //加密的参数
        $data['sign'] = $this->makeSign($data,$this->appSecret);

        //拼接请求地址
        $url = $host .'?'. http_build_query($data);
        
        return json_decode($this->getCurl($url),true);
        
    }

    public function getGoodsDetails(Request $request)
    {
        $host = "https://openapi.dataoke.com/api/goods/get-goods-details";

        //默认必传参数
        $data = [

            'appKey' => $this->appKey,
            'version' => 'v1.1.0',
            'id' => empty($request->input('id')) ? 1 : $request->input('id'),
            'goodsId' => empty($request->input('goodsId')) ? 1 : $request->input('goodsId')
        ];

        // dd($data);

        //加密的参数
        $data['sign'] = $this->makeSign($data,$this->appSecret);

        //拼接请求地址
        $url = $host .'?'. http_build_query($data);
        
        return json_decode($this->getCurl($url),true);
        
    }

    public function getPrivilegeLink(Request $request)
    {
        $host = "https://openapi.dataoke.com/api/tb-service/get-privilege-link";

        //默认必传参数
        $data = [

            'appKey' => $this->appKey,
            'version' => empty($request->input('version')) ? 'v1.0.5' : $request->input('version'),            
            'goodsId' => empty($request->input('goodsId')) ? 1 : $request->input('goodsId'),
            // 'couponId' => empty($request->input('couponId')) ? '' : $request->input('couponId'),                        
            'pid' => empty($request->input('pid')) ? 'mm_52334040_17254600_62936115' : $request->input('pid'),
            // 'channelId' => empty($request->input('channelId')) ? '' : $request->input('channelId'),
        ];

        // dd($data);

        //加密的参数
        $data['sign'] = $this->makeSign($data,$this->appSecret);

        //拼接请求地址
        $url = $host .'?'. http_build_query($data);
        
        // dd($this->getCurl($url));
        return json_decode($this->getCurl($url),true);
        
    }

    public function getDtkSearchGoods(Request $request)
    {
        $host = "https://openapi.dataoke.com/api/goods/get-dtk-search-goods";

        //默认必传参数
        $data = [

            'appKey' => $this->appKey,
            'version' => 'v2.1.0',
            'pageSize' => empty($request->input('pageSize')) ? 10 : $request->input('pageSize'),
            'pageId' => empty($request->input('pageId')) ? 1 : $request->input('pageId'),
            'keyWords' => $request->input('search'),
            // 'tmall' => 0,
            // 'haitao' => 0,
            // 'sort' => '_asc', //'total_sales',
        ];

        // dd($data);

        //加密的参数
        $data['sign'] = $this->makeSign($data,$this->appSecret);

        //拼接请求地址
        $url = $host .'?'. http_build_query($data);
        
        // dd($this->getCurl($url));
        return json_decode($this->getCurl($url),true);
        
    }

    public function getCollectionList(Request $request)
    {
        $host = "https://openapi.dataoke.com/api/goods/get-collection-list";

        //默认必传参数
        $data = [

            'appKey' => $this->appKey,
            'version' => 'v1.0.1',
            'pageSize' => empty($request->input('pageSize')) ? 10 : $request->input('pageSize'),
            'pageId' => empty($request->input('pageId')) ? 1 : $request->input('pageId'),
            'sort' => 2,
        ];

        // dd($data);

        //加密的参数
        $data['sign'] = $this->makeSign($data,$this->appSecret);

        //拼接请求地址
        $url = $host .'?'. http_build_query($data);
        
        // dd($this->getCurl($url));
        return json_decode($this->getCurl($url),true);
        
    }

    public function getCollectionListWithDetail(Request $request)
    {
        $result['list'] = [];

        $list = $this->getCollectionList($request);

        if (!empty($list['data']['list'])) {
            foreach($list['data']['list'] as $p) {

                $request->merge(['id' => $p['id']]);
                $request->merge(['goodsId' => $p['goodsId']]);
                $details = $this->getGoodsDetails($request);
                if (!empty($details['data']['list'])) {
                    array_push($result['list'],$details['data']['list']);    
                }
            }
        }

        if (!empty($result['list'])) {
            array_replace($list['data']['list'],$result['list']);
        }

        return $list;
        
    }

    public function getOwnerGoods(Request $request)
    {
        $host = "https://openapi.dataoke.com/api/goods/get-owner-goods";

        //默认必传参数
        $data = [

            'appKey' => $this->appKey,
            'version' => 'v1.0.1',
            'pageSize' => empty($request->input('pageSize')) ? 10 : $request->input('pageSize'),
            'pageId' => empty($request->input('pageId')) ? 1 : $request->input('pageId'),
            'sort' => 2,
        ];

        // dd($data);

        //加密的参数
        $data['sign'] = $this->makeSign($data,$this->appSecret);

        //拼接请求地址
        $url = $host .'?'. http_build_query($data);
        
        // dd($this->getCurl($url));
        return json_decode($this->getCurl($url),true);
        
    }
}

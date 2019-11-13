<?php

namespace App\Http\Controllers;

use App\taobao_collection_list;
use App\taobao_collection_vouchers;
use App\v_getTaobaoCollectionVouchers;
use App\v_getTaobaoCollectionVouchersGreater12;
use App\v_getTaobaoCollectionVouchersLess12;
use App\v_getTaobaoCollectionVouchers_Greater12Less24;
use App\v_getTaobaoCollectionVouchers_Greater24Less36;
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

        try {

            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, $url);

            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

            curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,0);

            curl_setopt($ch,CURLOPT_TIMEOUT,0);

            curl_setopt($ch, CURLOPT_HEADER, 0);

            $output = curl_exec($ch);

            curl_close($ch);

            return $output;
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
            'pageSize' => empty($request->input('pageSize')) ? 1 : $request->input('pageSize'),
            'pageId' => empty($request->input('pageId')) ? 1 : $request->input('pageId'),
            // 'cid' => "1,2,3,4,5,6,7,8,9,10,11,12,13,14",
            // 'cid' => '6',
            // 'trailerType' => 1,
            'sort' => 2,
            // 'collectionTimeOrder' => '20190926',
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
        $result = array();
        $newList = null;

        $list = $this->getCollectionList($request);
        \Log::info("This a command GetTaobaoCollectionList - getCollectionList");

        if (!empty($list['data']['list'])) {
            foreach($list['data']['list'] as $p) {
                $request->merge(['id' => $p['id']]);
                $request->merge(['goodsId' => $p['goodsId']]);
                $details = $this->getGoodsDetails($request);
                \Log::info("This a command GetTaobaoCollectionList - getGoodsDetails - goodsId - " . $p['goodsId']);
                if (!empty($details['data'])) {
                    array_push($result,$details['data']);                    
                }
            }
        }

        if (!empty($result)) {
            $newList = ['time' => $list['time'], 'code' => $list['code'], 'msg' => $list['msg'], 'data' => ['list' => $result, 'totalNum' => $list['data']['totalNum'], 'pageId' => $list['data']['pageId']]];
        }

        return $newList;
    }

    public function storeAllCollectionList()
    {
        //initial
        $request = new Request;
        $totalNum = 0;
        $totalPg = 0;
        $pageSize = 10;
        $pageId = 1;
        $page_num = 1;
        $request->merge(['pageSize' => $pageSize]);
        $request->merge(['pageId' => $pageId]);
        $list = $this->getCollectionListWithDetail($request);
        if (!empty($list['data']['list'])) {
            //store 1st pg data
            $filter = ['page_num' => $page_num];
            $array = ['page_num' => $page_num, 'content' => json_encode($list, true)];
            taobao_collection_list::updateOrCreate($filter, $array)->id;

            $totalNum = $list['data']['totalNum'];
            $pageId = $list['data']['pageId'];
            $totalPg = ceil($totalNum / 10);
            for ($page_num = 2; $page_num <= $totalPg; $page_num++) { //loop started with 2nd - skip initial
                $request->merge(['pageSize' => $pageSize]);
                $request->merge(['pageId' => $pageId]);
                $_list = $this->getCollectionListWithDetail($request);
                //store data
                if (!empty($_list['data']['list'])) {
                    $filter = ['page_num' => $page_num];
                    $array = ['page_num' => $page_num, 'content' => json_encode($_list, true)];
                    taobao_collection_list::updateOrCreate($filter, $array)->id;
                }
            }

            //remove old records
            taobao_collection_list::where('page_num', '>', $totalPg)->delete(); 
        }

        //store into voucher table
        $this->storeAllCollectionIntoVouchers();

        return ("totalNum: $totalNum, totalPg: $totalPg");
    }

    public function getTaobaoCollection($page_num = null)
    {
        $_content = null;
        $next_pg = 0;
        $res = taobao_collection_list::select('content')->where('page_num',$page_num)->first();        
        if (!empty($res->content)) {
            $next_pg = $page_num + 1;
            $_content = json_decode($res->content,true);
            //replace pageId to get next pg
            $_content['data']['pageId'] = $next_pg;   
        }

        return $_content;

    }

    public function getTaobaoCollectionVouchers($page_num = null)
    {
        $_content = null;
        $next_pg = 0;
        $_pgsize = 10;
        $page_num = empty($page_num) ? 1 : $page_num;
        $_end = $page_num * $_pgsize;
        $_start = $_end - $_pgsize;
        
        $totalNum = v_getTaobaoCollectionVouchers::select('*')->get()->count();
        //$res = taobao_collection_vouchers::select('*')->orderBy('updated_at', 'desc')->orderBy('monthSales', 'desc')->skip($_start)->take($_pgsize)->get();
        $res = v_getTaobaoCollectionVouchers::select('*')->skip($_start)->take($_pgsize)->get();

        if (!empty($res)) {
            $next_pg = $page_num + 1;
            $_content['code'] = 0;
            $_content['data']['list'] = $res;
            $_content['data']['pageId'] = $next_pg;
            $_content['data']['totalNum'] = $totalNum;   
            $_content['msg'] = 'ok';
            $_content['time'] = null;
        }

        return $_content;

    }

    public function getTaobaoCollectionVouchersGreater12($page_num = null)
    {
        $_content = null;
        $next_pg = 0;
        $_pgsize = 10;
        $page_num = empty($page_num) ? 1 : $page_num;
        $_end = $page_num * $_pgsize;
        $_start = $_end - $_pgsize;
        
        $totalNum = v_getTaobaoCollectionVouchersGreater12::select('*')->get()->count();
        //$res = v_getTaobaoCollectionVouchersGreater12::select('*')->orderBy('updated_at', 'desc')->orderBy('monthSales', 'desc')->skip($_start)->take($_end)->get();
        $res = v_getTaobaoCollectionVouchersGreater12::select('*')->skip($_start)->take($_pgsize)->get();

        if (!empty($res)) {
            $next_pg = $page_num + 1;
            $_content['code'] = 0;
            $_content['data']['list'] = $res;
            $_content['data']['pageId'] = $next_pg;
            $_content['data']['totalNum'] = $totalNum;   
            $_content['msg'] = 'ok';
            $_content['time'] = null;
        }

        return $_content;

    }

    public function getTaobaoCollectionVouchersLess12($page_num = null, Request $request)
    {
        $_content = null;
        $next_pg = 0;
        $_pgsize = empty($request->pgsize) ? 10 : $request->pgsize;
        $page_num = empty($page_num) ? 1 : $page_num;
        $_end = $page_num * $_pgsize;
        $_start = $_end - $_pgsize;
        
        $_modal = new v_getTaobaoCollectionVouchersLess12;

        if (!env('THISVIPAPP')) {
            $_modal->setConnection('mysql2');
        }
        
        $totalNum = $_modal->select('*')->get()->count();
        $res = $_modal->select('*')->skip($_start)->take($_pgsize)->get();

        if (!empty($res)) {
            $next_pg = $page_num + 1;
            $_content['code'] = 0;
            $_content['data']['list'] = $res;
            $_content['data']['pageId'] = $next_pg;
            $_content['data']['totalNum'] = $totalNum;   
            $_content['msg'] = 'ok';
            $_content['time'] = null;
        }

        return $_content;

    }

     public function getTaobaoCollectionVouchersGreater12Less24($page_num = null, Request $request)
    {
        $_content = null;
        $next_pg = 0;
        $_pgsize = empty($request->pgsize) ? 10 : $request->pgsize;
        $page_num = empty($page_num) ? 1 : $page_num;
        $_end = $page_num * $_pgsize;
        $_start = $_end - $_pgsize;
        
        $totalNum = v_getTaobaoCollectionVouchers_Greater12Less24::select('*')->get()->count();
        // $res = v_getTaobaoCollectionVouchersLess12::select('*')->orderBy('updated_at', 'desc')->orderBy('monthSales', 'desc')->skip($_start)->take($_end)->get();
        $res = v_getTaobaoCollectionVouchers_Greater12Less24::select('*')->skip($_start)->take($_pgsize)->get();

        if (!empty($res)) {
            $next_pg = $page_num + 1;
            $_content['code'] = 0;
            $_content['data']['list'] = $res;
            $_content['data']['pageId'] = $next_pg;
            $_content['data']['totalNum'] = $totalNum;   
            $_content['msg'] = 'ok';
            $_content['time'] = null;
        }

        return $_content;

    }

    public function getTaobaoCollectionVouchersGreater24Less36($page_num = null, Request $request)
    {
        $_content = null;
        $next_pg = 0;
        $_pgsize = empty($request->pgsize) ? 10 : $request->pgsize;
        $page_num = empty($page_num) ? 1 : $page_num;
        $_end = $page_num * $_pgsize;
        $_start = $_end - $_pgsize;
        
        $totalNum = v_getTaobaoCollectionVouchers_Greater24Less36::select('*')->get()->count();
        // $res = v_getTaobaoCollectionVouchersLess12::select('*')->orderBy('updated_at', 'desc')->orderBy('monthSales', 'desc')->skip($_start)->take($_end)->get();
        $res = v_getTaobaoCollectionVouchers_Greater24Less36::select('*')->skip($_start)->take($_pgsize)->get();

        if (!empty($res)) {
            $next_pg = $page_num + 1;
            $_content['code'] = 0;
            $_content['data']['list'] = $res;
            $_content['data']['pageId'] = $next_pg;
            $_content['data']['totalNum'] = $totalNum;   
            $_content['msg'] = 'ok';
            $_content['time'] = null;
        }

        return $_content;

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

    public function getTbService(Request $request)
    {
        $host = "https://openapi.dataoke.com/api/tb-service/get-tb-service";

        //默认必传参数
        $data = [

            'appKey' => $this->appKey,
            'version' => 'v1.0.1',
            'pageNo' => empty($request->input('pageNo')) ? 1 : $request->input('pageNo'),
            'pageSize' => empty($request->input('pageSize')) ? 10 : $request->input('pageSize'),
            'keyWords' => $request->input('search'),
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

    public function storeAllCollectionIntoVouchers()
    {
        $data = taobao_collection_list::select('*')->orderBy('id','desc')->get();

        $filter = [];
        $array = [];
        $i = 0;

        if (!empty($data)){
            taobao_collection_vouchers::query()->truncate();
            \Log::info("This a command GetTaobaoCollectionList - taobao_collection_vouchers - truncate");    
        }

        foreach ($data as $d) {
            if (!empty(json_decode($d->content)->data->list)) {
                $_data = json_decode($d->content)->data->list;
                foreach ($_data as $k => $v) {
                    foreach ($v as $tv => $cv) {
                        if ($tv == 'id') { //filter pid
                            $filter = array_merge($filter, ['pid' => $cv]);
                            $array = array_merge($array, ['pid' => $cv]);
                        } else {
                            if ($tv == 'goodsId') { //filter goodsId
                                $filter = array_merge($filter, [$tv => $cv]);
                            }

                            if ($tv == 'subcid') { // encode json format
                                $cv = json_encode($cv);      
                            }

                            $array = array_merge($array, [$tv => $cv]);
                            
                        }
                    }

                    $id = taobao_collection_vouchers::updateOrCreate($filter,$array)->id;
                    $render_data = $this->render_product($id);
                    $i++;
                    \Log::info("This a command GetTaobaoCollectionList - taobao_collection_vouchers - updateOrCreate - id - " . $id);    
                    
                }
            }
        }

        return ['success' => true, 'total' => $i];
    }

    public function render_product($id)
    {
      $data = taobao_collection_vouchers::where('id',$id)->get();      
      $data = view('tabao.render_product', ['result' => $data])->render(); 
      event(new \App\Events\EventDynamicChannel('add-tabao-product', '' ,$data ));
      return TRUE; 
    }
}

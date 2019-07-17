<?php

namespace App\Http\Controllers;

use \App\helpers\WeiXin as WX;
use App\Http\Controllers\Auth\MemberRegisterController;
use App\Members;
use App\weixin;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Khsing\WechatAgent\WechatAgent;

class weixinController extends BaseController
{

    public function __construct() {

        //
        $wx = new WX();
       
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

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

    public function weixin_verify(Request $request, $domain = null)
    {        
        $agent = new WechatAgent;
        // $agent->is("Wechat");

        if ($agent->is("Wechat")) {

            $request = new Request;
            $type = 'snsapi_userinfo'; 
            return $wx->index($request,$type,$domain);

        } else {

            return ['success' => false, 'message' => 'Please open it in the WeChat. 请在微信浏览器中打开'];

        }
        
    }

    public static function getUserInfo_snsapi_base(Request $request, $domain = null)
    {
        try {

            $appid = env('weixinid');//"你的AppId";  
            $secret = env('weixinsecret');//"你的AppSecret";  
            $code = $request->input('code');

            //第一步:取全局access_token
            $token = $wx->access_token($appid, $secret);
            // var_dump($token);
            
            //第二步:取得openid
            $oauth2 = $wx->oauth2($appid, $secret, $code);            
            // var_dump($oauth2);
      
            //第三步:根据全局access_token和openid查询用户信息  
            if (empty($token["access_token"])) {

                return $oauth2;

            } else {

                $access_token = $token["access_token"];  
                $openid = empty($oauth2['openid']) ? null : $oauth2['openid']; 
                $userinfo = $wx->getUserInfo_snsapi_base($access_token, $openid); 

            }
            //打印用户信息
            // var_dump($userinfo);

            if (!empty($userinfo['openid'])) {
                //store
                $res_id = $this->storeWeiXin($userinfo);
            }
            
            $result = $this->showWeiXin($userinfo);
            
            // return $userinfo;
            // return $result;

            //auto login / register
            return $this->accessToWabao($result,$domain);
        
        } catch (\Exception $e) {
            //log error
            \Log::error($e);
                        
            return $e->getMessage();
        }

    }

    public static function getUserInfo_snsapi_userinfo(Request $request, $domain = null)
    {
        try {

            $appid = env('weixinid');//"你的AppId";  
            $secret = env('weixinsecret');//"你的AppSecret";  
            $code = $request->input('code');

            //第一步:取得openid
            $oauth2 = $wx->test($appid, $secret, $code);
            var_dump($oauth2);
            die('dadsa');
      
            if (empty($oauth2["access_token"])) {

                return $oauth2;

            } else {

                //第二步:根据全局access_token和openid查询用户信息  
                $access_token = $oauth2["access_token"];  
                $openid = empty($oauth2['openid']) ? null : $oauth2['openid']; 
                $userinfo = $wx->getUserInfo_snsapi_userinfo($access_token, $openid);

            }
            
            //打印用户信息
            // var_dump($userinfo);

            if (!empty($userinfo['openid'])) {
                //store
                $res_id = $this->storeWeiXin($userinfo);
            }

            $result = $this->showWeiXin($userinfo);

            //return $result;

            //auto login / register
            return $this->accessToWabao($result,$domain);
        
        } catch (\Exception $e) {
            //log error
            \Log::error($e);
                        
            return $e->getMessage();
        }
        
    }

    public function storeWeiXin($userinfo)
    {
        $filter = ['openid' => $userinfo['openid'], 'nickname' => empty($userinfo['nickname']) ? null : $userinfo['nickname']];
        $array = ['openid' => $userinfo['openid'], 'nickname' => empty($userinfo['nickname']) ? null : $userinfo['nickname'], 'sex' => empty($userinfo['sex']) ? null : $userinfo['sex'], 'language' => empty($userinfo['language']) ? null : $userinfo['language'], 'city' => empty($userinfo['city']) ? null : $userinfo['city'], 'province' => empty($userinfo['province']) ? null : $userinfo['province'], 'country' => empty($userinfo['country']) ? null : $userinfo['country'], 'headimgurl' => empty($userinfo['headimgurl']) ? null : $userinfo['headimgurl'], 'response' => json_encode($userinfo)];
    
        return weixin::updateOrCreate($filter, $array)->id;
        
    }

    public function showWeiXin($userinfo)
    {
        $sex = empty($userinfo['sex']) ? null : (($userinfo['sex'] == 1) ? "MALE" : "FEMALE");

        if (empty($userinfo['openid']) && empty($userinfo['nickname'])) {
            $result = ['success' => false, 'message' => 'not valid weixin detail'];
        } else {
            $result = ['success' => true, 'openid' => empty($userinfo['openid']) ? null : $userinfo['openid'], 'nickname' => empty($userinfo['nickname']) ? null : $userinfo['nickname'], 'headimgurl' => empty($userinfo['headimgurl']) ? null : $userinfo['headimgurl'], 'sex' => $sex];
        }

        return $result;
    }

    public function accessToWabao($content, $domain = null)
    {
        $domain = empty($domain) ? "dev.boge56.com" : $domain;

        if ($content['success'] == true) {
            //wechat auth api
            // $url = "http://" . $domain . "/api/wechat-auth");
            $url = "http://dev.boge56.com/api/wechat-auth";
            $payload["nickname"] = '100000';
            $payload["openid"] = '8767gbasd67cg';

            $headers = [ 'Content-Type' => "application/x-www-form-urlencoded"];
            $option = ['connect_timeout' => 60, 'timeout' => 180];
            $client = new \GuzzleHttp\Client(['http_errors' => true, 'verify' => false]);
            $req = $client->post($url, ['headers' => $headers, 'form_params'=>$payload]);
            $res = $req->getBody();

            var_dump($res);
            die('dasdsad');

            if (!empty($res->success) && ($res->success == true)) {
                
                $url = "http://" . $domain . $res->url;
                //return $url;
                return redirect()->to($url);
            }

            return $res;

        } else {
            //to login screen
            //return redirect()->route('login');
            return $content;
        }
    }


}

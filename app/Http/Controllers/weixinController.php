<?php

namespace App\Http\Controllers;

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
       
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $type = null, $domain = null)
    {

        $domain = !empty($domain) ? $domain : 'dev.boge56.com';
        $type = !empty($type) ? $type : (empty($request->input('type')) ? 'snsapi_base' : 'snsapi_userinfo');
        $appid=env('weixinid'); //'你的AppId';
        $redirect_uri =  urlencode(env('weixinurl') . "/mp/getUserInfo/" . $type . "/" . $domain);
        $url ="https://open.weixin.qq.com/connect/oauth2/authorize?appid=$appid&redirect_uri=$redirect_uri&response_type=code&scope=$type&state=1#wechat_redirect"; 
        \Log::info(json_encode(['weixin URL' => $url], true));
        // var_dump($url);

        // header("Location:".$url);
        return redirect()->to($url);

        /*
        $result = ['success' => true, 'openid' => '111222333444', 'nickname' => 'testwechatapi', 'headimgurl' => 'http', 'sex' => 0];

        return $this->accessToWabao($result);
        */


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

    public function getUserInfo_snsapi_base(Request $request, $domain = null)
    {

        $appid = env('weixinid');//"你的AppId";  
        $secret = env('weixinsecret');//"你的AppSecret";  
        $code = $request->input('code');
 
        //第一步:取全局access_token
        $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$appid&secret=$secret";

        \Log::info(json_encode(['weixin URL' => $url], true));
        
        $token = $this->getJson($url);
        \Log::info(json_encode(['weixin token' => $token], true));
        // var_dump($token);
        
        //第二步:取得openid
        $oauth2Url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=$appid&secret=$secret&code=$code&grant_type=authorization_code";
        $oauth2 = $this->getJson($oauth2Url);
        \Log::info(json_encode(['weixin oauth2' => $oauth2], true));
        // var_dump($oauth2);
  
        //第三步:根据全局access_token和openid查询用户信息  
        if (empty($token["access_token"])) {

            return $oauth2;

        } else {
            $access_token = $token["access_token"];  
            $openid = empty($oauth2['openid']) ? null : $oauth2['openid'];  
            $get_user_info_url = "https://api.weixin.qq.com/cgi-bin/user/info?access_token=$access_token&openid=$openid&lang=zh_CN";
            // $get_user_info_url = "https://api.weixin.qq.com/sns/userinfo?access_token=$access_token&openid=$openid&lang=zh_CN";
            \Log::info(json_encode(['weixin get_user_info_url' => $get_user_info_url], true));
            $userinfo = $this->getJson($get_user_info_url);
        }
        //打印用户信息
        // var_dump($userinfo);

        if (!empty($userinfo['openid'])) {
            //Create / update 
            $filter = ['openid' => $userinfo['openid'], 'nickname' => empty($userinfo['nickname']) ? null : $userinfo['nickname']];
            $array = ['openid' => $userinfo['openid'], 'nickname' => empty($userinfo['nickname']) ? null : $userinfo['nickname'], 'sex' => empty($userinfo['sex']) ? null : $userinfo['sex'], 'language' => empty($userinfo['language']) ? null : $userinfo['language'], 'city' => empty($userinfo['city']) ? null : $userinfo['city'], 'province' => empty($userinfo['province']) ? null : $userinfo['province'], 'country' => empty($userinfo['country']) ? null : $userinfo['country'], 'headimgurl' => empty($userinfo['headimgurl']) ? null : $userinfo['headimgurl'], 'response' => json_encode($userinfo)];
            $res_id = weixin::updateOrCreate($filter, $array)->id;
        }
        
        if (empty($userinfo['openid']) && empty($userinfo['nickname'])) {
            $result = ['success' => false, 'message' => 'not valid weixin detail'];
        } else {
            $result = ['success' => true, 'openid' => empty($userinfo['openid']) ? null : $userinfo['openid'], 'nickname' => empty($userinfo['nickname']) ? null : $userinfo['nickname'], 'headimgurl' => empty($userinfo['headimgurl']) ? null : $userinfo['headimgurl'], 'sex' => empty($userinfo['sex']) ? null : $userinfo['sex']];
        }
        
        // return $userinfo;
        // return $result;

        //auto login / register
        return $this->accessToWabao($result,$domain);
        
    }

    public function getUserInfo_snsapi_userinfo(Request $request, $domain = null)
    {
        $appid = env('weixinid');//"你的AppId";  
        $secret = env('weixinsecret');//"你的AppSecret";  
        $code = $request->input('code');
 
        //第一步:取得openid
        $oauth2Url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=$appid&secret=$secret&code=$code&grant_type=authorization_code";
        \Log::info(json_encode(['weixin oauth2Url' => $oauth2Url], true));

        $oauth2 = $this->getJson($oauth2Url);
        \Log::info(json_encode(['weixin oauth2' => $oauth2], true));
        // var_dump($oauth2);
  
        if (empty($oauth2["access_token"])) {

            return $oauth2;

        } else {

            //第二步:根据全局access_token和openid查询用户信息  
            $access_token = $oauth2["access_token"];  
            $openid = $oauth2['openid'];  
            // $get_user_info_url = "https://api.weixin.qq.com/cgi-bin/user/info?access_token=$access_token&openid=$openid&lang=zh_CN";
            $get_user_info_url = "https://api.weixin.qq.com/sns/userinfo?access_token=$access_token&openid=$openid&lang=zh_CN";
            \Log::info(json_encode(['weixin get_user_info_url' => $get_user_info_url], true));
            $userinfo = $this->getJson($get_user_info_url);

        }

        
        //打印用户信息
        // var_dump($userinfo);

        if (!empty($userinfo['openid'])) {
            //Create / update 
            $filter = ['openid' => $userinfo['openid'], 'nickname' => empty($userinfo['nickname']) ? null : $userinfo['nickname']];
            $array = ['openid' => $userinfo['openid'], 'nickname' => empty($userinfo['nickname']) ? null : $userinfo['nickname'], 'sex' => empty($userinfo['sex']) ? null : $userinfo['sex'], 'language' => empty($userinfo['language']) ? null : $userinfo['language'], 'city' => empty($userinfo['city']) ? null : $userinfo['city'], 'province' => empty($userinfo['province']) ? null : $userinfo['province'], 'country' => empty($userinfo['country']) ? null : $userinfo['country'], 'headimgurl' => empty($userinfo['headimgurl']) ? null : $userinfo['headimgurl'], 'response' => json_encode($userinfo)];
            $res_id = weixin::updateOrCreate($filter, $array)->id;
        }

        if (empty($userinfo['openid']) && empty($userinfo['nickname'])) {
            $result = ['success' => false, 'message' => 'not valid weixin detail'];
        } else {
            $result = ['success' => true, 'openid' => empty($userinfo['openid']) ? null : $userinfo['openid'], 'nickname' => empty($userinfo['nickname']) ? null : $userinfo['nickname'], 'headimgurl' => empty($userinfo['headimgurl']) ? null : $userinfo['headimgurl'], 'sex' => empty($userinfo['sex']) ? null : $userinfo['sex']];
        }

        //return $result;

        //auto login / register
        return $this->accessToWabao($result,$domain);
        
        
    }

    public function getJson($url){
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); 
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE); 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);

        curl_close($ch);
        return json_decode($output, true);
    }

    public function weixin_verify(Request $request, $domain = null)
    {        
        $agent = new WechatAgent;
        // $agent->is("Wechat");

        if ($agent->is("Wechat")) {

            $request = new Request;
            $type = 'snsapi_userinfo'; 
            return $this->index($request,$type,$domain);

        } else {

            return ['success' => false, 'message' => 'Please open it in the WeChat. 请在微信浏览器中打开'];

        }
        
    }

    public function accessToWabao($content, $domain = null)
    {
        if ($content['success'] == true) {
            //wechat auth api
            $res = $this->getJson("http://dev.boge56.com/api/wechat-auth?nickname=100000&openid=8767gbasd67cg");    

            return $res['success'];      
            //$res = $this->getJson("http://$domain/api/wechat-auth?nickname=$content['nickname']&openid=$content['openid']");

            if (!empty($res->success) && ($res->success == true)) {
                $d = json_decode($res->data);
                return $d;

                $url = "http://$domain" . $d['url'];
                return $url;
                // return redirect()->to($url);
            }

            return $res;

        } else {
            //to login screen
            //return redirect()->route('login');
            return $content;
        }
    }

}

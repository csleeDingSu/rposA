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
        $this->wx = new WX();
       
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
            return $this->wx->index($request,$type,$domain);

        } else {

            return ['success' => false, 'message' => 'Please open it in the WeChat. 请在微信浏览器中打开'];

        }
        
    }

    public function getUserInfo_snsapi_base(Request $request, $domain = null)
    {
        try {

            $appid = env('weixinid');//"你的AppId";  
            $secret = env('weixinsecret');//"你的AppSecret";  
            $code = $request->input('code');

            //第一步:取全局access_token
            $token = $this->wx->access_token($appid, $secret);
            // var_dump($token);
            
            //第二步:取得openid
            $oauth2 = $this->wx->oauth2($appid, $secret, $code);            
            // var_dump($oauth2);
      
            //第三步:根据全局access_token和openid查询用户信息  
            if (empty($token["access_token"])) {

                return $oauth2;

            } else {

                $access_token = $token["access_token"];  
                $openid = empty($oauth2['openid']) ? null : $oauth2['openid']; 
                $userinfo = $this->wx->getUserInfo_snsapi_base($access_token, $openid); 

            }
            //打印用户信息
            // var_dump($userinfo);

            if (!empty($userinfo['openid'])) {
                //store
                $res_id = $this->storeWeiXin($userinfo, $access_token);
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

    public function getUserInfo_snsapi_userinfo(Request $request, $domain = null)
    {
        try {

            $appid = env('weixinid');//"你的AppId";  
            $secret = env('weixinsecret');//"你的AppSecret";  
            $code = $request->input('code');
           
            //第一步:取得openid
            $oauth2 = $this->wx->openid($appid, $secret, $code);
      
            if (empty($oauth2["access_token"])) {

                return $oauth2;

            } else {

                //第二步:根据全局access_token和openid查询用户信息  
                $access_token = $oauth2["access_token"];  
                $openid = empty($oauth2['openid']) ? null : $oauth2['openid']; 
                $userinfo = $this->wx->getUserInfo_snsapi_userinfo($access_token, $openid);

            }
            
            //打印用户信息
            // var_dump($userinfo);

            if (!empty($userinfo['openid'])) {
                //store
                $res_id = $this->storeWeiXin($userinfo, $access_token);
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

    public function storeWeiXin($userinfo, $access_token)
    {
        $filter = ['openid' => $userinfo['openid'], 'nickname' => empty($userinfo['nickname']) ? null : $userinfo['nickname']];
        $array = ['openid' => $userinfo['openid'], 'nickname' => empty($userinfo['nickname']) ? null : $userinfo['nickname'], 'sex' => empty($userinfo['sex']) ? null : $userinfo['sex'], 'language' => empty($userinfo['language']) ? null : $userinfo['language'], 'city' => empty($userinfo['city']) ? null : $userinfo['city'], 'province' => empty($userinfo['province']) ? null : $userinfo['province'], 'country' => empty($userinfo['country']) ? null : $userinfo['country'], 'headimgurl' => empty($userinfo['headimgurl']) ? null : $userinfo['headimgurl'], 'access_token' => $access_token, 'response' => json_encode($userinfo)];
    
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
            $http = ($domain == 'wabao666.com') ? "https://" : "http://";
            $url = $http . $domain . "/api/wechat-auth";
            // $url = "http://dev.boge56.com/api/wechat-auth";
            $payload["nickname"] = $content['nickname']; //'100000';
            $payload["openid"] = $content['openid']; //'8767gbasd67cg';
			$payload["sex"] = $content['sex'];
            $payload["headimgurl"] = $content['headimgurl'];

            //wechat qrcode
            $payload["ticket"] = $this->getQrcodeTicket($payload);
            
            $headers = [ 'Content-Type' => "application/x-www-form-urlencoded"];
            $option = ['connect_timeout' => 60, 'timeout' => 180];
            $client = new \GuzzleHttp\Client(['http_errors' => true, 'verify' => false]);
            $req = $client->post($url, ['headers' => $headers, 'form_params'=>$payload]);
            $res = json_decode($req->getBody());
            \Log::info(json_encode(['accessToWabao' => $res], true));			

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

    public function weixin_qrcode(Request $request, $type, $scene)
    {
        $res = $this->wx->qrcode($request, $type, $scene);
        $res = $this->isJSON($res) ? $res : json_encode($res);

        \Log::info(json_encode(['weixin_qrcode' => $res], true));
        return $res;
    }

    function isJSON($string){
       return is_string($string) && is_array(json_decode($string, true)) ? true : false;
    }

    public function getQrcodeTicket($payload)
    {
        $ticket = null;

        //retrieve weixin records
        $r = weixin::where('openid', $payload['openid'])->select('*')->first();
        //validate openid
        if (!empty($r)) {
            if (empty($r->ticket)) {
                $type="QR_LIMIT_SCENE";
                $scene="scene_str";
                $request = New Request;
                $request->merge(['detail' => json_encode($payload)]); 
                $res = $this->weixin_qrcode($request, $type, $scene);
                $this->updateQRCodeResponse($payload, $res);
                $ticket = $res->ticket;            
            } else {
                $ticket = $r->tiket;
            }
            
        }
        
        return $tiket;
        
    }

    public function updateQRCodeResponse($userinfo, $response)
    {
        \Log::warning(json_decode($response)->ticket);
        return weixin::where('openid', $userinfo['openid'])->where('nickname', $userinfo['nickname'])->update(['response_qrcode'=>$response]);
       
    }

    


}

<?php

namespace App\Http\Controllers;

use App\weixin;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

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
    public function index(Request $request, $type = null)
    {

        $type = !empty($type) ? $type : (empty($request->input('type')) ? 'snsapi_base' : 'snsapi_userinfo');
        $appid=env('weixinid'); //'你的AppId';
        $redirect_uri =  urlencode(env('APP_URL') . "/mp/getUserInfo/" . $type);
        $url ="https://open.weixin.qq.com/connect/oauth2/authorize?appid=$appid&redirect_uri=$redirect_uri&response_type=code&scope=$type&state=1#wechat_redirect"; 

        // var_dump($url);

        // header("Location:".$url);
        return redirect()->to($url);

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

    public function getUserInfo_snsapi_base(Request $request)
    {

        $appid = env('weixinid');//"你的AppId";  
        $secret = env('weixinsecret');//"你的AppSecret";  
        $code = $request->input('code');
 
        //第一步:取全局access_token
        $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$appid&secret=$secret";
        $token = $this->getJson($url);
        // var_dump($token);
        
        //第二步:取得openid
        $oauth2Url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=$appid&secret=$secret&code=$code&grant_type=authorization_code";
        $oauth2 = $this->getJson($oauth2Url);
        // var_dump($oauth2);
  
        //第三步:根据全局access_token和openid查询用户信息  
        $access_token = $token["access_token"];  
        $openid = $oauth2['openid'];  
        $get_user_info_url = "https://api.weixin.qq.com/cgi-bin/user/info?access_token=$access_token&openid=$openid&lang=zh_CN";
        $userinfo = $this->getJson($get_user_info_url);
 
        //打印用户信息
        // var_dump($userinfo);
        //array(16) { ["subscribe"]=> int(1) ["openid"]=> string(28) "oqafz03zBZ4wN8HZ8Q40YdkGX07o" ["nickname"]=> string(8) "Cheechee" ["sex"]=> int(1) ["language"]=> string(5) "zh_CN" ["city"]=> string(6) "杭州" ["province"]=> string(6) "浙江" ["country"]=> string(6) "中国" ["headimgurl"]=> string(126) "http://thirdwx.qlogo.cn/mmopen/PiajxSqBRaEIFcn25kkxQyyRpn2SiaO3Erhk9w9lO5GR59CSBhjdy8KphERdoLriaaRZXthDibI1maALaNiacBIK9vQ/132" ["subscribe_time"]=> int(1561867602) ["remark"]=> string(0) "" ["groupid"]=> int(0) ["tagid_list"]=> array(0) { } ["subscribe_scene"]=> string(16) "ADD_SCENE_SEARCH" ["qr_scene"]=> int(0) ["qr_scene_str"]=> string(0) "" }

        //Create / update 
        $filter = ['openid' => $userinfo['openid']];
        $array = ['openid' => $userinfo['openid'], 'nickname' => $userinfo['nickname'], 'sex' => $userinfo['sex'], 'language' => $userinfo['language'], 'city' => $userinfo['city'], 'province' => $userinfo['province'], 'country' => $userinfo['country'], 'headimgurl' => $userinfo['headimgurl'], 'response' => json_encode($userinfo)];
        $res_id = weixin::updateOrCreate($filter, $array)->id;

        return $userinfo;
        
    }

    public function getUserInfo_snsapi_userinfo(Request $request)
    {
        $appid = env('weixinid');//"你的AppId";  
        $secret = env('weixinsecret');//"你的AppSecret";  
        $code = $request->input('code');
 
        //第一步:取得openid
        $oauth2Url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=$appid&secret=$secret&code=$code&grant_type=authorization_code";
        $oauth2 = $this->getJson($oauth2Url);
        // var_dump($oauth2);
  
        //第二步:根据全局access_token和openid查询用户信息  
        $access_token = $oauth2["access_token"];  
        $openid = $oauth2['openid'];  
        $get_user_info_url = "https://api.weixin.qq.com/cgi-bin/user/info?access_token=$access_token&openid=$openid&lang=zh_CN";
        $userinfo = $this->getJson($get_user_info_url);
 
        //打印用户信息
        var_dump($userinfo);
        
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

}

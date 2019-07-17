<?php
namespace App\Helpers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log; 

class WeiXin
{ 
    public static function index(Request $request, $type = null, $domain = null)
    {
        try {

            $domain = !empty($domain) ? $domain : 'dev.boge56.com';
            $type = !empty($type) ? $type : (empty($request->input('type')) ? 'snsapi_base' : 'snsapi_userinfo');
            $appid=env('weixinid'); //'你的AppId';
            $redirect_uri =  urlencode(env('weixinurl') . "/mp/getUserInfo/" . $type . "/" . $domain);
            $url ="https://open.weixin.qq.com/connect/oauth2/authorize?appid=$appid&redirect_uri=$redirect_uri&response_type=code&scope=$type&state=1#wechat_redirect"; 
            \Log::info(json_encode(['weixin URL' => $url], true));
            
            return redirect()->to($url);
        
        } catch (\Exception $e) {
            //log error
            \Log::error($e);
                        
            return $e->getMessage();
        }
    }

    public static function access_token($appid, $secret)
    {
        try {
        
            //第一步:取全局access_token
            $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$appid&secret=$secret";

            \Log::info(json_encode(['weixin URL' => $url], true));

            $token = self::getJson($url);
            \Log::info(json_encode(['weixin token' => $token], true));

            return $token;
        
        } catch (\Exception $e) {
            //log error
            \Log::error($e);
                        
            return $e->getMessage();
        }
    }

    public static function oauth2($appid, $secret, $code)
    {
        try {

            //第二步:取得openid
            $oauth2Url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=$appid&secret=$secret&code=$code&grant_type=authorization_code";
            $oauth2 = self::getJson($oauth2Url);
            \Log::info(json_encode(['weixin oauth2' => $oauth2], true));

            return $oauth2;
            
        } catch (\Exception $e) {
            //log error
            \Log::error($e);
                        
            return $e->getMessage();
        }
    }

    public static function getUserInfo_snsapi_base($access_token, $openid)
    {
        try {
                $get_user_info_url = "https://api.weixin.qq.com/cgi-bin/user/info?access_token=$access_token&openid=$openid&lang=zh_CN";
                // $get_user_info_url = "https://api.weixin.qq.com/sns/userinfo?access_token=$access_token&openid=$openid&lang=zh_CN";
                // \Log::info(json_encode(['weixin getUserInfo_snsapi_base' => $get_user_info_url], true));
                $userinfo = self::getJson($get_user_info_url);
                \Log::info(json_encode(['weixin getUserInfo_snsapi_base' => $userinfo], true));

                return $userinfo;
            
        } catch (\Exception $e) {
            //log error
            \Log::error($e);
                        
            return $e->getMessage();
        }

    }

    public static function openid($appid, $secret, $code)
    {
        try {

            //第一步:取得openid
            $oauth2Url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=$appid&secret=$secret&code=$code&grant_type=authorization_code";
            \Log::info(json_encode(['weixin oauth2Url' => $oauth2Url], true));

            $oauth2 = self::getJson($oauth2Url);
            \Log::info(json_encode(['weixin oauth2' => $oauth2], true));
            // var_dump($oauth2);
            
            return $oauth2;

        } catch (\Exception $e) {
            //log error
            \Log::error($e);
                        
            return $e->getMessage();
        }

    }

    public static function getUserInfo_snsapi_userinfo($access_token, $openid)
    {
        try {

                // $get_user_info_url = "https://api.weixin.qq.com/cgi-bin/user/info?access_token=$access_token&openid=$openid&lang=zh_CN";
                $get_user_info_url = "https://api.weixin.qq.com/sns/userinfo?access_token=$access_token&openid=$openid&lang=zh_CN";
                // \Log::info(json_encode(['weixin getUserInfo_snsapi_userinfo' => $get_user_info_url], true));
                $userinfo = self::getJson($get_user_info_url);
                \Log::info(json_encode(['weixin getUserInfo_snsapi_userinfo' => $userinfo], true));

                return $userinfo;
        
        } catch (\Exception $e) {
            //log error
            \Log::error($e);
                        
            return $e->getMessage();
        }
        
    }

    public static function getJson($url){
        
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

?>
<?php
namespace App\Helpers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Khsing\WechatAgent\WechatAgent; 

class WeiXin
{ 
    public static function index(Request $request, $type = null, $domain = null)
    {        
		try {

            $domain = !empty($domain) ? $domain : 'dev.boge56.com';
            $type = !empty($type) ? $type : (empty($request->input('type')) ? 'snsapi_base' : 'snsapi_userinfo');
            $appid=env('weixinid'); //'你的AppId';
            $refcode = $request->input('refcode');
            $goto = $request->input('goto');

            if (strpos($domain, 'refcode') !== false) {
                $redirect_uri =  urlencode(env('weixinurl') . "/mp/getUserInfo/" . $type . "/" . $domain . '&goto=' . $goto);
            } else {
                $redirect_uri =  urlencode(env('weixinurl') . "/mp/getUserInfo/" . $type . "/" . $domain . '?refcode=' . $refcode . '&goto=' . $goto);
            }
            
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

    public static function isWeiXin()
    {        
        // $agent = new WechatAgent;

        // if ($agent->is("Wechat")) {
        if (strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') == true) {     
            
            return true;

        } else {

            return false;

        }
        
    }

    public static function qrcode(Request $request, $type = null, $scene = null)
    {
        try {

            if (env('APP_URL') == env('weixinurl')) {

                $appid = env('weixinid');//"你的AppId";  
                $secret = env('weixinsecret');//"你的AppSecret";
                $token = self::access_token($appid, $secret);
                $type = (empty($type) ? 'QR_SCENE' : $type); //QR_SCENE, QR_LIMIT_SCENE
                $scene = (empty($scene) ? 'scene_str' : $scene); //scene_id, scene_str
                $detail = $request->input('detail');
                
                //wechat qrcode
                $url ="https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token=" . $token["access_token"]; 
                
                $code = '{"expire_seconds": 604800, "action_name": "'. $type .'", "action_info": {"scene": {"' . $scene . '": "' . $detail . '"}}}';
                \Log::info(json_encode(['qrcode url' => $url], true));
                \Log::info(json_encode(['qrcode payload' => $code], true));

                $ch1 = curl_init();
                curl_setopt($ch1, CURLOPT_URL,$url);
                curl_setopt($ch1, CURLOPT_SSL_VERIFYPEER,false);
                curl_setopt($ch1, CURLOPT_SSL_VERIFYHOST,false);

                curl_setopt($ch1, CURLOPT_POST,1);
                curl_setopt($ch1, CURLOPT_POSTFIELDS,$code);

                curl_setopt($ch1, CURLOPT_RETURNTRANSFER,1);//禁止调用时就输出获取到的数据
                $result = curl_exec($ch1);
                curl_close($ch1);
                $res = json_decode($result); 

                // Class Object
                // (
                //     [ticket] => gQGA8TwAAAAAAArerreS5odHRwOi8vd2VpeGlytrreLmNvbS9xLzAyci1mSDF0SmtjazAxMDAwMGcwM1cAAgQFovJZAwQAAAAA
                //     [url] => http://weixin.qq.com/q/02r-fgsGtJkck010000g03W
                // )

                // $ticket = $res->ticket;

                \Log::info(json_encode(['qrcode' => $res], true));

                $res = json_encode($res);

            } else {

                $url = env('weixinurl') . "/weixin/qrcode/" . $type . "/" . $scene;
                $payload["detail"] = $request->input('detail');
                \Log::info(json_encode(['qrcode url' => $url], true));
                \Log::info(json_encode(['qrcode payload' => $payload], true));

                $headers = [ 'Content-Type' => "application/x-www-form-urlencoded"];
                $option = ['connect_timeout' => 60, 'timeout' => 180];
                $client = new \GuzzleHttp\Client(['http_errors' => true, 'verify' => false]);
                $req = $client->post($url, ['headers' => $headers, 'form_params'=>$payload]);

                $res = json_decode($req->getBody());

            }
            
            return $res;
           
        } catch (\Exception $e) {
            //log error
            \Log::error($e);
                        
            return $e->getMessage();
        }
    }

    public static function send_curl($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); 
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE); 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);
        curl_close($ch);
        
        return $output; 
                
    }

    public static function showqrcode($ticket)
    {
        $url = "https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=" . $ticket;

        $qrcode = self::send_curl($url);
        
        return $qrcode; 
                
    }

    public function createwxaqrcode($request)
    {
        try {

            if (env('APP_URL') == env('weixinurl')) {

                $appid = env('weixinid');//"你的AppId";  
                $secret = env('weixinsecret');//"你的AppSecret";
                $token = self::access_token($appid, $secret);
                $path = $request->input('path');
                $width = $request->input('width');
                
                //wechat createwxaqrcode
                $url ="https://api.weixin.qq.com/cgi-bin/wxaapp/createwxaqrcode?access_token=" . $token["access_token"]; 
                
                $payload = '{"path": "'.$path.'", "width": '. $width .'}';
                \Log::info(json_encode(['qrcode url' => $url], true));
                \Log::info(json_encode(['qrcode payload' => $payload], true));

                $ch1 = curl_init();
                curl_setopt($ch1, CURLOPT_URL,$url);
                curl_setopt($ch1, CURLOPT_SSL_VERIFYPEER,false);
                curl_setopt($ch1, CURLOPT_SSL_VERIFYHOST,false);

                curl_setopt($ch1, CURLOPT_POST,1);
                curl_setopt($ch1, CURLOPT_POSTFIELDS,$payload);

                curl_setopt($ch1, CURLOPT_RETURNTRANSFER,1);//禁止调用时就输出获取到的数据
                $result = curl_exec($ch1);
                curl_close($ch1);
                $res = json_decode($result); 

                \Log::info(json_encode(['createwxaqrcode' => $res], true));

                $res = json_encode($res);

            } else {

                $url = env('weixinurl') . "/weixin/createwxa/qrcode";
                $payload["path"] = $request->input('path');
                $payload["width"] = $request->input('width');
                \Log::info(json_encode(['createwxaqrcode url' => $url], true));
                \Log::info(json_encode(['createwxaqrcode payload' => $payload], true));

                $headers = [ 'Content-Type' => "application/x-www-form-urlencoded"];
                $option = ['connect_timeout' => 60, 'timeout' => 180];
                $client = new \GuzzleHttp\Client(['http_errors' => true, 'verify' => false]);
                $req = $client->post($url, ['headers' => $headers, 'form_params'=>$payload]);

                $res = json_decode($req->getBody());

            }
            
            return $res;
           
        } catch (\Exception $e) {
            //log error
            \Log::error($e);
                        
            return $e->getMessage();
        }

        
    }

    


}

?>
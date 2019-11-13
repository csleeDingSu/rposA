<?php
namespace App\Helpers;

use App\trace_phone_location;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TracePhoneNumber
{ 
    public static function index(Request $request)
    {        
		try {

            return true;
        
        } catch (\Exception $e) {
            //log error
            \Log::error($e);
                        
            return $e->getMessage();
        }
    }

    public static function getJson($url){
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); 
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE); 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);
        if (curl_errno($ch)) { 
           // var_dump($ch); 
        } 
        curl_close($ch);
        // var_dump($output);
        // dd(json_decode($output, true));
        return json_decode($output, true);
    }

    public static function getLocation($phone)
    {
        try {
        
            $url = "https://tool.bitefu.net/shouji/?mobile=" . $phone;

            \Log::info(json_encode(['TracePhoneNumber URL' => $url], true));

            $res = self::getJson($url);
            \Log::info(json_encode(['TracePhoneNumber getLocation' => $res], true));

            // var_dump($res);

            //save trace_phone_location
            $filter = [];
            $array = [];

            foreach ($res as $k => $v) {
                // var_dump($k);
                // var_dump($v);
                    if ($k == 'mobile') { //filter pid
                        $filter = array_merge($filter, ['mobile' => $v]);
                        $array = array_merge($array, ['mobile' => $v]);
                    } else {
                        $array = array_merge($array, [$k => $v]);
                    }

                $id = trace_phone_location::updateOrCreate($filter,$array)->id;
                
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
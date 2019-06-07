<?php

namespace App\Http\Controllers;

use App\helpers\Sha256Generator;
use App\cron_test;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class TestController extends BaseController
{

    public function __construct() {

        //today
       
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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

    public function Test()
    {
    	//return response()->json(['success' => true, 'message' => ' any .. vue test'], 200);      
        return view('test.test');
    }

    public function cron_test()
    {
        $array = ['name' => Carbon::now(), 'description' => '', 'value' => Carbon::now()->timestamp];
        $filter = ['name' => Carbon::now()]; 
        $result = cron_test::updateOrCreate($filter, $array)->id;
        return $result;
    }

    public function reload_card_validation(Request $request)
    {
        try {

            $memberid = $request->input('memberid');
            $amount = $request->input('amount');
            $cardno = $request->input('cardno');
            $cardpwd = $request->input('cardpwd');
            $ext = empty($request->input('ext')) ? '' : $request->input('ext'); //optional
            $orderno = trim($memberid . Carbon::now()->timestamp);
            $sid = env('RELOAD_CARD_API_SID', '10017565');
            $type = empty($request->input('type')) ? 6 : $request->input('type');; //骏网一卡通
            $url = url('/api/reload-card-callback?output=yes');        
            
            $params = "amount=$amount&cardno=$cardno&cardpwd=$cardpwd&ext=$ext&orderno=$orderno&sid=$sid&type=$type&url=$url";

            $signature = Sha256Generator::generateHash($params); 

            $payload = array (
              'amount' => $amount,
              'cardno' => $cardno,
              'cardpwd' => $cardpwd,
              'ext' => $ext,
              'orderno' => $orderno,
              'sid' => $sid,
              'type' => $type,
              'url' => urlencode($url),
              'sign' => $signature
            );
            //log
            \Log::info($payload);

            $API_URL = env('RELOAD_CARD_API_URL');           
            $headers = [ 'Content-Type' => "application/x-www-form-urlencoded"];
            $option = ['connect_timeout' => 60, 'timeout' => 180];
            $client = new \GuzzleHttp\Client(['http_errors' => true, 'verify' => false]);
            $response = $client->post($API_URL, ['headers' => $headers, 'form params'=>$payload]);
            return $response;

        } catch (\Exception $e) {
            \Log::error($e);
            return $e->getMessage();
        }
    }

    public function reload_card_callback(Request $request)
    {
        $output = empty($request->input('output')) ? ' - ' : $request->input('output');
        $response = "callback success. output: $output";
        return $response;        
    }

}

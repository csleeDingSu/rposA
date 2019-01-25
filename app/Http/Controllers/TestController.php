<?php

namespace App\Http\Controllers;

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
        $filter = []; 
        $result = cron_test::updateOrCreate($filter, $array)->id;
        return $result;
    }

}

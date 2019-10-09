<?php

namespace App\Http\Controllers;

use Auth;
use Carbon\Carbon;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
// use Illuminate\Foundation\Bus\DispatchesJobs;
// use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;

class LogController extends BaseController
{
    // use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    use AuthorizesRequests;

    public function __construct() {

        //
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return "log controller";
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

    public function log($data)
    {
        $_memberid = empty($data['memberid']) ? null : $data['memberid'];
        $_type = empty($data['type']) ? null : $data['type'];
        $_data = empty($data['data']) ? null : $data['data'];
        $_log = json_encode($data, true);
        if (($_type == 'info') || ($_type == null)) {
         \Log::info($_log);
        } else if ($_type == 'warning') {
         \Log::warning($_log);
        } else if ($_type == 'error') {
         \Log::error($_log);
        } else if ($_type == 'debug') {
         \Log::debug($_log);
        } else if ($_type == 'danger') {
         \Log::danger($_log);
        } else {
         \Log::info($_log);
        }

        return $_data;
    }

}

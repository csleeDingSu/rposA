<?php
namespace App\Helpers;

use App\Http\Controllers\LogController;
use Carbon\Carbon;


class Logs
{ 
    public static function log($data, $type = null)
    {
    	$l = app(LogController::class);
        return $l->log($data, $type);
    }
}

?>
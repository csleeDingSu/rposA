<?php
namespace App\Helpers;

use Carbon\Carbon; 

class VIPApp
{ 
    public static function isVIPApp()
    {
        return env('THISVIPAPP', false);
    }

}

?>
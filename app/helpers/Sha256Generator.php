<?php
namespace App\Helpers;

use Carbon\Carbon; 

class Sha256Generator
{ 
    public static function generateHash($content)
    {
        return hash('sha256',$content);
    }

}

?>
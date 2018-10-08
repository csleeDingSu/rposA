<?php
namespace App\Helpers;

use Carbon\Carbon;
use LaravelQRCode\Facades\QRCode; 

class QRCodeGenerator
{

    /**
     * Generates a QRCode
     *
     * @param option String $type
     * * @param option String $content
     * @return image
     */
    public static function generate($type = null, $content = [])
    {
        switch ($type) {

                case "url":

                    $result = QRCode::url($content['url'])
                          ->setSize(8)
                          ->setMargin(2)
                          ->png();

                    break;

                case "text":

                    $result = QRCode::text($content['text'])->png();

                    break;

                case "sms":

                    $result = QRCode::sms($content['phone'], $content['sms'])
                         ->setSize(4)
                         ->setMargin(2)
                         ->png(); 

                    break;

                case "email":

                    $result = QRCode::email($content['to'], $content['body'], $content['subject'])->png();

                default:

                    $result = null; 
                    break;

            }

        return  $result;

    }

}

?>
<?php

namespace App\Http\Controllers\Api\Cron;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Inspiring;

class SendSmsController extends Controller
{
    public function contacts(){
        return [
            '09360459353' => 'Bebe Elmer',
            '09358898117' => 'Bebe Lalaine',
            '09127769888' => 'Bebe Alvin'
        ];
    }

    public function index(){
        $contacts = self::contacts();

        foreach($contacts as $number => $contact){
            $ch      = curl_init();
            $message = 'Hi Good Morning '.$contact.' start your day with a smile :) Labyu muahh muahhh <3';
            $itexmo  = [
                '1'      => $number,
                '2'      => $message,
                '3'      => config('services.itexmo.apicode'),
                'passwd' => config('services.itexmo.password')
            ];
            curl_setopt($ch, CURLOPT_URL,"https://www.itexmo.com/php_api/api.php");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, 
            http_build_query($itexmo));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_exec ($ch);
            curl_close ($ch);
        }
    }
}

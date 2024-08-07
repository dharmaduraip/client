<?php

namespace App\Helpers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Auth;
use App\User;
use App\Allcountry;


class Africastalking
{ 

    public static function sendMessage($message, $recipients)
    {
        if(!empty(Auth::user()->country_id) || Auth::user()->country_id != NULL)
        {
            $getpincode = Allcountry::where('id',Auth::user()->country_id)->first();
            $recipients = "+".$getpincode->phonecode.$recipients;

            $url = 'https://api.africastalking.com/version1/messaging';
            $apiKey = getenv("AFRICAS_TALKING_APIKEY");
            /* Init cURL resource */
            $ch = curl_init($url);
               
            /* Array Parameter Data */
            $data = [
                'username' =>  getenv("AFRICAS_TALKING_USERNAME"),
                'to' => $recipients,
                'message' => $message,
                'enqueue' => 1
            ];
            
            /* pass encoded JSON string to the POST fields */
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
               
            /* set the content type json */
            $headers = [
                'Accept:application/json',
                'apiKey: '.$apiKey
            ];

            //$headers[] = 'apiKey:a98accfe346da2463d3743be62fac2f86d053b0c7ed25e22a7f54c67dea93c77';
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
               
            /* set return type json */
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
               
            /* execute request */
            $result = curl_exec($ch);
                
            /* close cURL resource */
            curl_close($ch);

            
        }
        
    }

}

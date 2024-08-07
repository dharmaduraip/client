<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'sparkpost' => [
        'secret' => env('SPARKPOST_SECRET'),
    ],

    'stripe' => [
        'model' => App\User::class,
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
    ],

    'google' => [
        'client_id' => '',
        'client_id' => '1038196167526-euluve7af4mhfgde9vr79a8s1or4t8it',
        'client_secret' => 'Z_Wq238T-bSWC5Azmyk2jSs6',
        'redirect' => 'http://sximobuilder.com/sximodemo/sximo5/user/google',
    ],

    'twitter' => [
    //    'client_id' => '',
        'client_id' => 'q2NR24fPB2VtayTOMa6NDAG9s',
        'client_secret' => 'deLBI0nVkllV1aAOrohk0X9nDJY1tognRQO2myJsGis9GnmBCY',
        'redirect' => 'http://sximobuilder.com/sximodemo/sximo5/user/twitter',
    ],

    'facebook' => [
        'client_id' => '',
        'client_id' => '725712687473196',
        'client_secret' => '97af69633d9f00e4d3d2e9929574d9e9',
        'redirect' => 'http://sximobuilder.com/sximodemo/sximo5/user/facebook',
    ],  

];

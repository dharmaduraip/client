<?php

Route::get('/login', function () {

    $base_url = \App\Helpers\Helper::getBaseUrl();

    $services = json_decode(\App\Helpers\Helper::getServiceBaseUrl(), true);

    $settings = json_encode(\App\Helpers\Helper::getSettings());

    $base = [];

    foreach ($services as $key => $service) {
        $base[$key] = $service;
    }

    $base = json_encode($base);

    return view('common.provider.auth.login', compact('base', 'base_url', 'settings'));
});
Route::get('/forgot-password', function () {
    $base_url = \App\Helpers\Helper::getBaseUrl();
    $services = json_decode(\App\Helpers\Helper::getServiceBaseUrl(), true);
    $settings = json_encode(\App\Helpers\Helper::getSettings());
    $base = [];
    foreach ($services as $key => $service) {
        $base[$key] = $service;
    }
    $base = json_encode($base); 
    return view('common.provider.auth.forgot', compact('base', 'base_url', 'settings'));
});
Route::get('/reset-password', function () {
    $urlparam = ($_GET);
    $base_url = \App\Helpers\Helper::getBaseUrl();
    $services = json_decode(\App\Helpers\Helper::getServiceBaseUrl(), true);
    $settings = json_encode(\App\Helpers\Helper::getSettings());
    $base = [];
    foreach ($services as $key => $service) {
        $base[$key] = $service;
    }
    $base = json_encode($base); 
    return view('common.provider.auth.reset', compact('base', 'base_url', 'settings','urlparam'));
});
Route::get('/signup', function () {

    $base_url = \App\Helpers\Helper::getBaseUrl();

    $services = json_decode(\App\Helpers\Helper::getServiceBaseUrl(), true);

    $settings = json_encode(\App\Helpers\Helper::getSettings());

    $base = [];

    foreach ($services as $key => $service) {
        $base[$key] = $service;
    }

    $base = json_encode($base);

    return view('common.provider.auth.signup', compact('base', 'base_url', 'settings'));
});



Route::get('/profile/{type}', function ($type) {
   
    return view('common.provider.account.profile',compact('type'));
});

Route::get('/document/{type}', function ($type) {
   
    return view('common.provider.auth.document',compact('type'));
});

Route::view('/wallet', 'common.provider.account.wallet');

Route::redirect('/', '/provider/login');
Route::view('/home', 'common.provider.home');
Route::view('/myservice', 'common.provider.auth.service');


Route::get('/logout', function () {
    return view('common.provider.auth.logout');
});
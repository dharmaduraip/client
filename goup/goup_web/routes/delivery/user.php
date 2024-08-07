<?php

Route::get('/delivery/{id?}/delivery', function ($id = 0) {

    return view('delivery.user.home', compact('id'));
});

Route::get('/delivery/{id?}/delivery/estimate', function ($id = 0) {
	
    return view('delivery.user.delivery-home-p2', compact('id'));
});

Route::view('/delivery/trips', 'delivery.user.trips');

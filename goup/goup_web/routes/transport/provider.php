<?php

Route::view('/home', 'common.provider.home');
Route::view('/trips', 'transport.provider.ride.trips');

Route::view('/ride', 'transport.provider.ride.ride');
// HISTORY FOR TRANSP0RT

Route::get('/trips/transport', ['as'=>'taxihistory', function () {
    return view('transport.provider.ride.trips');
}]);
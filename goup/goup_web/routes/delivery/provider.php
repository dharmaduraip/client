<?php

Route::view('/home', 'common.provider.home');
Route::view('/trips', 'delivery.provider.ride.trips');

Route::view('/delivery', 'delivery.provider.ride.ride');
// HISTORY FOR TRANSP0RT

Route::get('/trips/delivery', ['as'=>'deliveryhistory', function () {
    return view('delivery.provider.ride.trips');
}]);
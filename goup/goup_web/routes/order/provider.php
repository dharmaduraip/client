<?php

Route::view('/order', 'order.provider.order.serve');
// HISTORY FOR ORDER

Route::get('/trips/order', ['as'=>'orderhistory', function () {
    return view('order.provider.order.history');
}]);
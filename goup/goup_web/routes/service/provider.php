<?php

Route::view('/service', 'service.provider.serve.serve');
// SERVICE HISTORY FOR SERVICE

Route::get('/trips/service', ['as'=>'servicehistory', function () {
    return view('service.provider.serve.history');
}]);
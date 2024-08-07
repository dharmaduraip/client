<?php

use Carbon\Carbon;
// vehicle
Route::view('/deliveryvehicle', 'delivery.admin.vehicle.index');
Route::view('/deliveryvehicle/create', 'delivery.admin.vehicle.form');
Route::get('/deliveryvehicle/{id}/edit', function ($id) {
    return view('delivery.admin.vehicle.form', compact('id'));
});

//dispute
Route::view('/delivery-requestdispute', 'delivery.admin.dispute.index');
Route::view('/delivery-requestdispute/create', 'delivery.admin.dispute.form');
Route::get('/delivery-requestdispute/{id}/edit', function ($id) {
    return view('delivery.admin.dispute.editform', compact('id'));
});
// Delivery request History
Route::view('/delivery/requesthistory', 'delivery.admin.history.requesthistory');
Route::view('/delivery/requestschedulehistory', 'delivery.admin.history.requestschedulehistory');

// Request Details
Route::get('/delivery-riderequestdetails/{id}/view', function ($id) {
    return view('delivery.admin.ride.form', compact('id'));
});

//vehicle type
Route::view('/deliverytype', 'delivery.admin.vehicletype.index');
Route::view('/deliverytype/create', 'delivery.admin.vehicletype.form');
Route::get('/deliverytype/{id}/edit', function ($id) {
    return view('delivery.admin.vehicletype.form', compact('id'));
});

//package type
Route::view('/packagetype', 'delivery.admin.packagetype.index');
Route::view('/packagetype/create', 'delivery.admin.packagetype.form');
Route::get('/packagetype/{id}/edit', function ($id) {
    return view('delivery.admin.packagetype.form', compact('id'));
});

Route::get('/statement/delivery', function () {
    $from_date = isset($_REQUEST['from_date'])?$_REQUEST['from_date']:'';
    $to_date = isset($_REQUEST['to_date'])?$_REQUEST['to_date']:'';
    $country_id = isset($_REQUEST['country_id'])?$_REQUEST['country_id']:'';
    $dates['yesterday'] = Carbon::yesterday()->format('Y-m-d');
    $dates['today'] = Carbon::today()->format('Y-m-d');
    $dates['pre_week_start'] = date("Y-m-d", strtotime("last week monday"));
    $dates['pre_week_end'] = date("Y-m-d", strtotime("last week sunday"));
    $dates['cur_week_start'] = Carbon::today()->startOfWeek()->format('Y-m-d');
    $dates['cur_week_end'] = Carbon::today()->endOfWeek()->format('Y-m-d');
    $dates['pre_month_start'] = Carbon::parse('first day of last month')->format('Y-m-d');
    $dates['pre_month_end'] = Carbon::parse('last day of last month')->format('Y-m-d');
    $dates['cur_month_start'] = Carbon::parse('first day of this month')->format('Y-m-d');
    $dates['cur_month_end'] = Carbon::parse('last day of this month')->format('Y-m-d');
    $dates['pre_year_start'] = date("Y-m-d",strtotime("last year January 1st"));
    $dates['pre_year_end'] = date("Y-m-d",strtotime("last year December 31st"));
    $dates['cur_year_start'] = Carbon::parse('first day of January')->format('Y-m-d');
    $dates['cur_year_end'] = Carbon::parse('last day of December')->format('Y-m-d');
    $dates['nextWeek'] = Carbon::today()->addWeek()->format('Y-m-d');
    return view('delivery.admin.statement.overall', compact('dates','from_date','to_date','country_id'));
})->name('delivery.statement.range');
// Route::get('/statement/range', 'AdminController@statement_range')->name('ride.statement.range');
// statement
// Route::view('/statement', 'transport.admin.statement.overall');


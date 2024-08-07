<?php

use Carbon\Carbon;
// vehicle
Route::view('/vehicle', 'transport.admin.vehicle.index');
Route::view('/vehicle/create', 'transport.admin.vehicle.form');
Route::get('/vehicle/{id}/edit', function ($id) {
    return view('transport.admin.vehicle.form', compact('id'));
});
//lostitem
Route::view('/lostitem', 'transport.admin.lostitem.index');
Route::view('/lostitem/create', 'transport.admin.lostitem.form');
Route::get('/lostitem/{id}/edit', function ($id) {
    return view('transport.admin.lostitem.editform', compact('id'));
});
//dispute
Route::view('/requestdispute', 'transport.admin.dispute.index');
Route::view('/requestdispute/create', 'transport.admin.dispute.form');
Route::get('/requestdispute/{id}/edit', function ($id) {
    return view('transport.admin.dispute.editform', compact('id'));
});
// ride request History
Route::view('/requesthistory', 'transport.admin.history.requesthistory');
Route::view('/requestschedulehistory', 'transport.admin.history.requestschedulehistory');
// Request Details
Route::get('/riderequestdetails/{id}/view', function ($id) {
    return view('transport.admin.ride.form', compact('id'));
});

//vehicle type
Route::view('/vehicletype', 'transport.admin.vehicletype.index');
Route::view('/vehicletype/create', 'transport.admin.vehicletype.form');
Route::get('/vehicletype/{id}/edit', function ($id) {
    return view('transport.admin.vehicletype.form', compact('id'));
});

Route::get('/statement', function () {
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
    return view('transport.admin.statement.overall', compact('dates','from_date','to_date','country_id'));
})->name('ride.statement.range');
// Route::get('/statement/range', 'AdminController@statement_range')->name('ride.statement.range');
// statement
// Route::view('/statement', 'transport.admin.statement.overall');


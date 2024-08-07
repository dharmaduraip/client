<?php
use Carbon\Carbon;
// SERVICE MAIN CATEGORIES
Route::view('/service-categories', 'service.admin.categories.index');
Route::view('/service-categories/create', 'service.admin.categories.form');
Route::get('/service-categories/{id}/edit', function ($id) {
    return view('service.admin.categories.form', compact('id'));
});
// SERVICE SUB CATEGORIES
Route::view('/service-subcategories', 'service.admin.subcategories.index');
Route::view('/service-subcategories/create', 'service.admin.subcategories.form');
Route::get('/service-subcategories/{id}/edit', function ($id) {
    return view('service.admin.subcategories.form', compact('id'));
});
// SERVICE
Route::view('/service-list', 'service.admin.services.index');
Route::view('/service-list/create', 'service.admin.services.form');
Route::get('/service-list/{id}/edit', function ($id) {
    return view('service.admin.services.form', compact('id')); 
});
//DISPUTE
Route::view('/service-dispute', 'service.admin.dispute.index');
Route::view('/service-dispute/create', 'service.admin.dispute.form');
Route::get('/service-dispute/{id}/edit', function ($id) {
    return view('service.admin.dispute.editform', compact('id'));
});
// service request History
Route::view('/service-history', 'service.admin.history.requesthistory');
//Service schedule history
Route::view('/serviceschedulehistory', 'service.admin.history.requestschedulehistory');
// Request Details
Route::get('/service-requestdetails/{id}/view', function ($id) {
    return view('service.admin.services.requests', compact('id'));
});


Route::get('/statement/service', function () {
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
    return view('service.admin.statement.overallService', compact('dates','from_date','to_date','country_id'));
})->name('service.statement.range');
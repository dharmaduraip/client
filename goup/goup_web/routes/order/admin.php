<?php
use Carbon\Carbon;

// stores Types
Route::view('/storetypes', 'order.admin.store_type.index');
Route::view('/storetypes/create', 'order.admin.store_type.form');
Route::get('/storetypes/{id}/edit', function ($id) {
    return view('order.admin.store_type.form', compact('id'));
});
Route::get('/priceform/{id}', function ($id) {
    return view('order.admin.store_type.priceform', compact('id'));
});

//Cuisines
Route::view('/cuisines', 'order.admin.cuisine.index');
Route::view('/cuisines/create', 'order.admin.cuisine.form');
Route::get('/cuisines/{id}/edit', function ($id) {
    return view('order.admin.cuisine.form', compact('id'));
});

//Shops

Route::view('/shops', 'order.admin.shops.index');
Route::get('/shops/create', function(){
 $Days = [
        'ALL' => 'Everyday',
        'SUN' => 'Sunday',
        'MON' => 'Monday',
        'TUE' => 'Tuesday',
        'WED' => 'Wednesday',
        'THU' => 'Thursday',
        'FRI' => 'Friday',
        'SAT' => 'Saturday'
    ];

    return view('order.admin.shops.form', compact('Days'));

}); 

Route::get('/shops/{id}/edit', function ($id) {

    $Days = [
        'ALL' => 'Everyday',
        'SUN' => 'Sunday',
        'MON' => 'Monday',
        'TUE' => 'Tuesday',
        'WED' => 'Wednesday',
        'THU' => 'Thursday',
        'FRI' => 'Friday',
        'SAT' => 'Saturday'
    ];
    return view('order.admin.shops.form', compact('id','Days'));
});



Route::get('/storewallet/{id}', function ($id) {
    return view('order.admin.wallet', compact('id'));
});

Route::get('/storelogs/{id}', function ($id) {
    return view('order.admin.shops.logdata', compact('id'));
});


//Shops Add on

Route::get('/shopsaddon/{id}/index', function ($id) {
    return view('order.admin.shop_addon.index', compact('id'));
});

Route::get('/shopsaddon/{store_id}/create', function ($store_id) {
    return view('order.admin.shop_addon.form', compact('store_id'));
});

Route::get('/shopsaddon/{id}/edit', function ($id) {
    return view('order.admin.shop_addon.form', compact('id'));
});

//Shops Category

Route::get('/shopscategory/{id}/index', function ($id) {
    return view('order.admin.shop_category.index', compact('id'));
});

Route::get('/shopscategory/{store_id}/create', function ($store_id) {
    return view('order.admin.shop_category.form', compact('store_id'));
});

Route::get('/shopscategory/{id}/edit', function ($id) {
    return view('order.admin.shop_category.form', compact('id'));
});

// Shops Items
Route::get('/shopsitems/{id}/index', function ($id) {
    return view('order.admin.shop_items.index', compact('id'));
});

Route::get('/shopsitems/{store_id}/create', function ($store_id) {
    return view('order.admin.shop_items.form', compact('store_id'));
});

Route::get('/shopsitems/{id}/{store_id}/edit', function ($id,$store_id) {
    return view('order.admin.shop_items.form', compact('id','store_id'));
});
 
// Order request History
Route::view('/order-history', 'order.admin.history.requesthistory');
// Request Details
Route::get('/order-requestdetails/{id}/view', function ($id) {
    return view('order.admin.history.requests', compact('id'));
});
//DISPUTE
Route::view('/order-dispute', 'order.admin.dispute.index');
Route::view('/order-dispute/create', 'order.admin.dispute.form');
Route::get('/order-dispute/{id}/edit', function ($id) {
    return view('order.admin.dispute.editform', compact('id'));
});

Route::get('/statement/order', function () {
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
    return view('order.admin.statement.overallOrder', compact('dates','from_date','to_date','country_id'));
})->name('order.statement.range');

Route::get('/statement/store', function () {
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
    return view('order.admin.statement.overallStore', compact('dates','from_date','to_date','country_id'));
})->name('store.statement.range');
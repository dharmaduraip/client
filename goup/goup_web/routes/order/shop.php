<?php
use Carbon\Carbon;
Route::redirect('/', '/shop/login');
Route::view('/dashboard', 'order.shop.dashboard');
Route::view('/password', 'order.shop.account.change-password');
Route::view('/wallet', 'order.shop.account.wallet');
Route::view('/statement/order', 'order.shop.statement.order');
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
    return view('order.shop.statement.order', compact('dates','from_date','to_date','country_id'));  
})->name('statement.range');;
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
    return view('order.shop.statement.store', compact('dates','from_date','to_date','country_id'));
})->name('statement.storerange');;

Route::view('/order-history', 'order.shop.history.requesthistory');
Route::get('/order-requestdetails/{id}/view', function ($id) {
    return view('order.shop.history.requests', compact('id'));
});





Route::get('/dashboard/{id}', function ($id) {
     Session::put('shop_id', $id);
    return view('order.shop.dashboard', compact('id'));
});

Route::get('/addonindex/{id}/', function ($id) {
    $id=base64_decode($id);
    return view('order.shop.addon.index', compact('id'));
});

Route::get('/addon/{store_id}/create', function ($store_id) {
    return view('order.shop.addon.form', compact('store_id')); 
});

Route::get('/addon/{id}/edit', function ($id) {
    return view('order.shop.addon.form', compact('id')); 
});

Route::get('/categoryindex/{id}/', function ($id) {
    $id=base64_decode($id);
    return view('order.shop.category.index', compact('id'));
});

Route::get('/category/{store_id}/create', function ($store_id) {
    return view('order.shop.category.form', compact('store_id'));
});

Route::get('/category/{id}/edit', function ($id) {
    return view('order.shop.category.form', compact('id'));
});

Route::get('/itemsindex/{id}/', function ($id) {
    $id=base64_decode($id);
    return view('order.shop.item.index', compact('id'));
});

Route::get('/items/{store_id}/create', function ($store_id) {
    return view('order.shop.item.form', compact('store_id'));
});

Route::get('/items/{id}/{store_id}/edit', function ($id,$store_id) {
    return view('order.shop.item.form', compact('id','store_id'));
});

Route::get('view/{id}', function ($id) {
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
    $id=base64_decode($id);
   return view('order.shop.shop', compact('id','Days'));
});

Route::get('/login', function () {

    $base_url = \App\Helpers\Helper::getBaseUrl();

    $services = json_decode(\App\Helpers\Helper::getServiceBaseUrl(), true);

    $settings = json_encode(\App\Helpers\Helper::getSettings());

    $base = [];

    foreach ($services as $key => $service) {
        $base[$key] = $service;
    }

    $base = json_encode($base); 

    return view('order.shop.auth.login', compact('base', 'base_url', 'settings'));
});

Route::get('/logout', function () {

    return view('order.shop.auth.logout'); 
});

Route::get('/forgotPassword', function () {
    $base_url = \App\Helpers\Helper::getBaseUrl();
    $services = json_decode(\App\Helpers\Helper::getServiceBaseUrl(), true);
    $settings = json_encode(\App\Helpers\Helper::getSettings());
    $base = [];
    foreach ($services as $key => $service) {
        $base[$key] = $service;
    }
    $base = json_encode($base); 
    return view('order.shop.auth.forgot', compact('base', 'base_url', 'settings'));
}); 


Route::get('/resetPassword', function () {
    $base_url = \App\Helpers\Helper::getBaseUrl();
    $services = json_decode(\App\Helpers\Helper::getServiceBaseUrl(), true);
    $settings = json_encode(\App\Helpers\Helper::getSettings());
    $base = [];
    foreach ($services as $key => $service) {
        $base[$key] = $service;
    }
    $base = json_encode($base); 
    return view('order.shop.auth.reset', compact('base', 'base_url', 'settings'));
});


Route::get('/dispatcher-panel/{id}/', function ($id) {
    $id=base64_decode($id);
    return view('order.shop.dispatcherpanel.index', compact('id'));
});


Route::get('/bankdetail', function () {
    return view('order.shop.account.bankdetails'); 
});

Route::get('/language', function () {
    return view('order.shop.account.language'); 
});




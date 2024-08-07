<?php
use Carbon\Carbon;
use Illuminate\Support\Facades\Redis;

Route::redirect('/', '/admin/login');
Route::view('/dashboard', 'common.admin.dashboard');

Route::get('/login', function () {

    $base_url = \App\Helpers\Helper::getBaseUrl();

    $services = json_decode(\App\Helpers\Helper::getServiceBaseUrl(), true);

    $settings = json_encode(\App\Helpers\Helper::getSettings());

    $base = [];

    foreach ($services as $key => $service) {
        $base[$key] = $service;
    }

    $base = json_encode($base); 

    return view('common.admin.auth.login', compact('base', 'base_url', 'settings'));
});

Route::get('/permission_list/{id}/token/{token}', function ($id, $token) {
    $client = new \GuzzleHttp\Client();
    $result = $client->post(env('BASE_URL') . '/api/v1/admin/permission_list', [
        'headers'         => ['Authorization' => 'Bearer ' . $token]
    ]);
    Session::put('user_id', $id);
    $redis = Redis::connection();
    $redis->set($id, json_encode(json_decode($result->getBody()))  );
});

Route::get('/logout', function () {

    $user = Session::get('user_id');

    Redis::del($user);

    return view('common.admin.auth.logout');
});

Route::get('/forgotPassword', function () {
    $urlparam = ($_GET);

    $base_url = \App\Helpers\Helper::getBaseUrl();
    $services = json_decode(\App\Helpers\Helper::getServiceBaseUrl(), true);
    $settings = json_encode(\App\Helpers\Helper::getSettings());
    $base = [];
    foreach ($services as $key => $service) {
        $base[$key] = $service;
    }
    $base = json_encode($base); 
    return view('common.admin.auth.forgot', compact('base', 'base_url', 'settings','urlparam'));
}); 

Route::get('/resetPassword', function () {
    $urlparam = ($_GET);
    $base_url = \App\Helpers\Helper::getBaseUrl();
    $services = json_decode(\App\Helpers\Helper::getServiceBaseUrl(), true);
    $settings = json_encode(\App\Helpers\Helper::getSettings());
    $base = [];
    foreach ($services as $key => $service) {
        $base[$key] = $service;
    }
    $base = json_encode($base); 
    return view('common.admin.auth.reset', compact('base', 'base_url', 'settings','urlparam'));
});

Route::view('/user', 'common.admin.users.index');
Route::view('/user/create', 'common.admin.users.form');
Route::get('/user/{id}/edit', function ($id) {
    return view('common.admin.users.form', compact('id'));
});
Route::get('/logs/{id}/{type}', function ($id,$type) {
    return view('common.admin.logdata', compact('id','type'));
});

Route::get('/wallet/{id}/{type}', function ($id,$type) {
    return view('common.admin.wallet', compact('id','type'));
});


//Dispatcher Panel
Route::view('/dispatcher-panel', 'common.admin.dispatcherpanel.index');


//Fleet
Route::view('/fleet', 'common.admin.fleets.index');
Route::view('/fleet/create', 'common.admin.fleets.form');
Route::get('/fleet/{id}/edit', function ($id) {
    return view('common.admin.fleets.form', compact('id'));
});
Route::view('/card', 'common.admin.fleets.cards');
Route::view('/wallet', 'common.admin.fleets.wallet');

//Dispatcher
Route::view('/dispatchermanager', 'common.admin.dispatchermanager.index');
Route::view('/dispatcher/create', 'common.admin.dispatchermanager.form');
Route::get('/dispatcher/{id}/edit', function ($id) {
    return view('common.admin.dispatcher.form', compact('id'));
});

//Account Manager
Route::view('/accountmanager', 'common.admin.account-manager.index');
Route::view('/accountmanager/create', 'common.admin.account-manager.form');
Route::get('/accountmanager/{id}/edit', function ($id) {
    return view('common.admin.account-manager.form', compact('id'));
});

// Notification
Route::view('/notification', 'common.admin.notification.index');
Route::view('/notification/create', 'common.admin.notification.form');
Route::get('/notification/{id}/edit', function ($id) {
    return view('common.admin.notification.form', compact('id'));
});

//Document
Route::view('/document', 'common.admin.document.index');
Route::view('/document/create', 'common.admin.document.form');
Route::get('/document/{id}/edit', function ($id) {
    return view('common.admin.document.form', compact('id'));
});

//Reason
Route::view('/reason', 'common.admin.reason.index');
Route::view('/reason/create', 'common.admin.reason.form');
Route::get('/reason/{id}/edit', function ($id) {
    return view('common.admin.reason.form', compact('id'));
});
//Dispute
Route::view('/dispute_list', 'common.admin.dispute.index');
Route::view('/dispute/create', 'common.admin.dispute.form');
Route::get('/dispute/{id}/edit', function ($id) {
    return view('common.admin.dispute.form', compact('id'));
});
//promocode
Route::view('/promocode', 'common.admin.promocode.index');
Route::view('/promocode/create', 'common.admin.promocode.form');
Route::get('/promocode/{id}/edit', function ($id) {
    return view('common.admin.promocode.form', compact('id'));
});
//provider 
Route::view('/provider', 'common.admin.provider.index');
Route::view('/provider/create', 'common.admin.provider.form');
Route::get('/provider/{id}/edit', function ($id) {
    return view('common.admin.provider.form', compact('id'));
});
Route::get('/provider/{id}/{cityid}/{zoneid}/document', function ($id,$cityid,$zoneid) {
    return view('common.admin.provider.priceform', compact('id','cityid',"zoneid"));
});
Route::get('/provider/{id}/view_image', function ($id) {
    return view('common.admin.provider.viewdocument', compact('id'));
});
Route::get('/provider/{id}/logs', function ($id) {
    return view('common.admin.provider.logdata', compact('id'));
});

Route::get('/provider/{id}/addamount', function ($id) {
    return view('common.admin.provider.addamount', compact('id'));
});
//settings
Route::get('/settings', function () {
    return view('common.admin.settings.form');
});
//country
Route::view('/country', 'common.admin.country.index');
Route::view('/country/create', 'common.admin.country.form');
Route::get('/country/{id}/{country_id}/edit', function ($id,$country_id) {
    return view('common.admin.country.form', compact('id','country_id'));
});
Route::get('/country/{id}/bankform', function ($id) {
    return view('common.admin.country.bankform', compact('id'));
});

//city
Route::view('/city', 'common.admin.city.index');
Route::view('/city/create', 'common.admin.city.form');
Route::get('/city/{id}/edit', function ($id) {
    return view('common.admin.city.form', compact('id'));
});

//Roles
Route::view('/roles', 'common.admin.roles.index');
Route::view('/roles/create', 'common.admin.roles.form');
Route::get('/roles/{id}/edit', function ($id) {
    return view('common.admin.roles.form', compact('id'));
});

//Subadmin
Route::get('/subadmin', function ($type='admin') {
    $type =ucfirst($type);
    return view('common.admin.subadmin.index', compact('type'));
});
Route::get('/dispute', function ($type='dispute') {
    $type =ucfirst($type);
    return view('common.admin.subadmin.index', compact('type'));
});

Route::get('/dispatcher', function ($type='dispatcher') {
    $type =ucfirst($type);
    return view('common.admin.subadmin.index', compact('type'));
});
Route::get('/account', function ($type='account') {
    $type =ucfirst($type);
    return view('common.admin.subadmin.index', compact('type'));
});
Route::get('/subadmin/create/{type?}', function ($type='admin') {
    $type =ucfirst($type);
    return view('common.admin.subadmin.form', compact('type'));
});

Route::get('/subadmin/{id}/edit/{type?}', function ($id,$type='admin') {
    return view('common.admin.subadmin.form', compact('id','type'));
});
// peakhour
Route::view('/peakhour', 'common.admin.peakhour.index');
Route::view('/peakhour/create', 'common.admin.peakhour.form');
Route::get('/peakhour/{id}/edit', function ($id) {
    return view('common.admin.peakhour.form', compact('id'));
});
//CmsPage
// Route::view('/cmspage', 'common.admin.cmspage.index');
// Route::view('/cmspage/create', 'common.admin.cmspage.form');
// Route::get('/cmspage/{id}/edit', function ($id) {
//     return view('common.admin.cmspage.form', compact('id'));
// });

//CustomPush
Route::view('/custompush', 'common.admin.custompush.index');
Route::view('/custompush/create', 'common.admin.custompush.form');
Route::get('/custompush/{id}/edit', function ($id) {
    return view('common.admin.custompush.form', compact('id'));
});
//menu
Route::view('/menu', 'common.admin.menu.index');
Route::view('/menu/create', 'common.admin.menu.form');
Route::get('/menu/{id}/edit', function ($id) {
    return view('common.admin.menu.form', compact('id'));
});
Route::get('/menucity/{id}/{service}', function ($id,$service) {
    // return view('common.admin.menu.city', compact('id'));
    return view('common.admin.menu.citylistform', compact('id','service'));
});
//Accountsetting
Route::view('/profile', 'common.admin.account.profile');
Route::view('/cmspage', 'common.admin.cmspage.form');
Route::view('/password', 'common.admin.account.change-password');
// review
Route::view('/userreview', 'common.admin.rating.user');
Route::view('/providerreview', 'common.admin.rating.provider');
//Heatmap
Route::view('/heatmap', 'common.admin.heatmap.heatmap');
//Gods View
Route::view('/godsview', 'common.admin.godsview.godsview');
Route::get('/godsview/services/{id}/{sid}',function($id,$sid){

 return view('common.admin.godsview.providerservice',compact('id','sid'));
});
//country
Route::view('/geo-fencing', 'common.admin.geofencing.index');
Route::view('/geo-fencing/create', 'common.admin.geofencing.form');
Route::get('/geo-fencing/{id}/edit', function ($id) {
    return view('common.admin.geofencing.form', compact('id'));
});
//Help
Route::view('/help', 'common.admin.help.help');
//zones
Route::view('/zones', 'common.admin.payroll.zones');
Route::view('/zone/create', 'common.admin.payroll.zone_form');
Route::get('/zone/{id}/edit', function ($id) {
    return view('common.admin.payroll.zone_form', compact('id'));
});

Route::view('/payroll-template', 'common.admin.payroll.payroll-template');
Route::view('/payroll-template/create', 'common.admin.payroll.payroll_template_form');
Route::get('/payroll-template/{id}/edit', function ($id) {
    return view('common.admin.payroll.payroll_template_form', compact('id'));
});

Route::view('/payroll', 'common.admin.payroll.index');
Route::view('/payroll/create', 'common.admin.payroll.form');
Route::view('/payroll/manualcreate', 'common.admin.payroll.manual_form');
Route::get('/payroll/{id}/edit', function ($id) {
    return view('common.admin.payroll.edit_form', compact('id'));
});
Route::view('/payroll/type', 'common.admin.payroll.form_type');
Route::view('/bankdetails', 'common.admin.account.bankdetails');

Route::view('/statement/user', 'common.admin.statement.user');
Route::view('/statement/provider', 'common.admin.statement.provider');
Route::get('/transactions', function () {
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
    return view('common.admin.statement.overall', compact('dates','from_date','to_date','country_id'));
})->name('common.statement.range');


Route::get('/fleettransactions', function () {
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
    return view('common.admin.statement.fleet', compact('dates','from_date','to_date','country_id'));
})->name('common.statement.range');


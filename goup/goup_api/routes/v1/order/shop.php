<?php

$router->post('/login', 'V1\Order\Shop\Auth\AuthController@login');

$router->post('/refresh', 'V1\Order\Shop\Auth\AuthController@refresh');
$router->post('/forgotOtp', 'V1\Order\Shop\Auth\AuthController@forgotPasswordOTP');
$router->post('/resetOtp', 'V1\Order\Shop\Auth\AuthController@resetPasswordOTP');
$router->get('/dispatcher/autosign', 'V1\Order\Shop\Auth\AdminController@StoreAutoAssign');

$router->group(['middleware' => 'auth:shop'], function ($app) {
//Notification
$app->get('/getNotification', 'V1\Common\Admin\Resource\NotificationController@shopNotificationCount');
$app->get('/notification', 'V1\Common\Admin\Resource\NotificationController@shopNotification');
//Shops Add on
$app->get('/addon/{id}', 'V1\Order\Admin\Resource\ShopsaddonController@index'); 
$app->post('/addons', 'V1\Order\Admin\Resource\ShopsaddonController@store');
$app->get('/addons/{id}', 'V1\Order\Admin\Resource\ShopsaddonController@show');
$app->patch('/addons/{id}', 'V1\Order\Admin\Resource\ShopsaddonController@update');
$app->delete('/addons/{id}', 'V1\Order\Admin\Resource\ShopsaddonController@destroy'); 
$app->get('/addonslist/{store_id}', 'V1\Order\Admin\Resource\ShopsaddonController@addonlist');
$app->get('/addonslist/{store_id}/{item_id}', 'V1\Order\Admin\Resource\ShopsaddonController@addonlist');
$app->get('/addon/{id}/updateStatus', 'V1\Order\Admin\Resource\ShopsaddonController@updateStatus'); 

//Shops Category
$app->get('/categoryindex/{id}', 'V1\Order\Admin\Resource\ShopscategoryController@index');
$app->post('/category', 'V1\Order\Admin\Resource\ShopscategoryController@store');
$app->get('/category/{id}', 'V1\Order\Admin\Resource\ShopscategoryController@show');
$app->patch('/category/{id}', 'V1\Order\Admin\Resource\ShopscategoryController@update');
$app->delete('/category/{id}', 'V1\Order\Admin\Resource\ShopscategoryController@destroy');
$app->get('/categorylist/{id}', 'V1\Order\Admin\Resource\ShopscategoryController@categorylist');
$app->get('/category/{id}/updateStatus', 'V1\Order\Admin\Resource\ShopscategoryController@updateStatus');

//Shpos Items
$app->get('/itemsindex/{id}', 'V1\Order\Admin\Resource\ShopsitemsController@index');
$app->post('/items', 'V1\Order\Admin\Resource\ShopsitemsController@store');
$app->get('/items/{id}', 'V1\Order\Admin\Resource\ShopsitemsController@show');
$app->patch('/items/{id}', 'V1\Order\Admin\Resource\ShopsitemsController@update');
$app->delete('/items/{id}', 'V1\Order\Admin\Resource\ShopsitemsController@destroy');
$app->get('/items/{id}/updateStatus', 'V1\Order\Admin\Resource\ShopsitemsController@updateStatus');
$app->get('/units', 'V1\Order\Admin\Resource\ShopsitemsController@unit');


// Store Types	
$app->get('/storetypelist', 'V1\Order\Admin\Resource\StoretypeController@storetypelist'); 	

//zone
$app->get('/zonetype/{id}', 'V1\Common\Admin\Resource\ZoneController@cityzonestype');

//cuisine
$app->get('/cuisinelist/{id}', 'V1\Order\Admin\Resource\CuisinesController@cuisinelist');
//shop
$app->get('/shops/{id}', 'V1\Order\Admin\Resource\ShopsController@show');
$app->patch('/shops/{id}', 'V1\Order\Admin\Resource\ShopsController@update');  
$app->patch('/shopstiming', 'V1\Order\Admin\Resource\ShopsController@updateshoptimings');  
$app->get('/shopstiming', 'V1\Order\Admin\Resource\ShopsController@shoptimings');  

//Account setting details
Route::get('password', 'V1\Order\Shop\Auth\AdminController@password');
Route::post('password', 'V1\Order\Shop\Auth\AdminController@password_update');
Route::get('bankdetails/template', 'V1\Common\Provider\HomeController@template');
$app->post('/addbankdetails', 'V1\Common\Provider\HomeController@addbankdetails'); 
$app->post('/editbankdetails', 'V1\Common\Provider\HomeController@editbankdetails');

//language_update
Route::get('language', 'V1\Order\Shop\Auth\AdminController@language');
Route::post('language', 'V1\Order\Shop\Auth\AdminController@language_update');

//Dispatcher Panel
$app->get('/dispatcher/orders', 'V1\Order\Shop\Auth\AdminController@orders');
$app->get('/dispatcher/products', 'V1\Order\Shop\Auth\AdminController@courierorders');
$app->post('/dispatcher/cancel', 'V1\Order\Shop\Auth\AdminController@cancel_orders');
$app->post('/dispatcher/accept', 'V1\Order\Shop\Auth\AdminController@accept_orders');
$app->post('/dispatcher/return', 'V1\Order\Shop\Auth\AdminController@return_orders');
$app->post('/dispatcher/collected', 'V1\Order\Shop\Auth\AdminController@collectedOrder');
$app->post('/dispatcher/pickedup', 'V1\Order\Shop\Auth\AdminController@picked_up');
$app->post('/dispatcher/qrscanned', 'V1\Order\Shop\Auth\AdminController@qrscanned');

//Wallet
$app->get('/wallet', 'V1\Order\Shop\Auth\AdminController@wallet');

//logout
$app->post('/logout', 'V1\Order\Shop\Auth\AuthController@logout'); 

//Dashboard
$app->get('total/storeorder', 'V1\Order\Shop\Auth\AdminController@total_orders');
$app->get('countries', 'V1\Order\Shop\Auth\AdminController@countries');

$app->get('/transactions', 'V1\Order\Shop\ShopStatementController@statement_shop');

$app->get('/shoprequesthistory', 'V1\Order\User\HomeController@shoprequestHistory');
$app->get('/requesthistory/{id}', 'V1\Order\User\HomeController@requestHistoryDetails');



});


<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\FooditemsController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\DeliveryboyController;
use App\Http\Controllers\CuisineimgController;
use App\Http\Controllers\VariationcolorController;
use App\Http\Controllers\VariationunitController;
use App\Http\Controllers\FoodunitController;
use App\Http\Controllers\DeliverychargesettingsController;
use App\Http\Controllers\OrderdetailsController;
use App\Http\Controllers\RestaurantreportController;
use App\Http\Controllers\MisreportController;
use App\Http\Controllers\DailyreportController;
use App\Http\Controllers\WeeklypaymentforhostController;
use App\Http\Controllers\DeliveryboyreportController;





/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|


Route::get('/', function () {
    return view('welcome');
});
*/
Route::get('deliveryboy/deliveryboyexport/{slug}', [App\Http\Controllers\DeliveryboyController::class, 'deliveryboyexport']);
Route::get('customer/customerexport/{slug}', [App\Http\Controllers\CustomerController::class, 'customerexport']);
Route::get('location/LocationExports/{slug}', [App\Http\Controllers\LocationController::class, 'locationexport']);
Route::get('cuisineimg/CuisineimgExport/{slug}', [App\Http\Controllers\CuisineimgController::class, 'cuisineexport']);
Route::get('variationcolor/variationexports/{slug}', [App\Http\Controllers\VariationcolorController::class, 'variationexport']);
Route::get('variationunit/variationexports/{slug}', [App\Http\Controllers\VariationunitController::class, 'variationexport']);
Route::get('foodunit/foodunitExport/{slug}', [App\Http\Controllers\FoodunitController::class, 'foodexport']);
Route::get('deliverychargesettings/deliveryExports/{slug}', [App\Http\Controllers\DeliverychargesettingsController::class, 'deliveryexport']);
Route::get('orderdetails/orderdetailsexport/{slug}', [App\Http\Controllers\OrderdetailsController::class, 'orderexport']);
Route::get('dailyreport/dailyreportexports/{slug}', [App\Http\Controllers\DailyreportController::class, 'dailyreportexport']);
Route::get('restaurantreport/restaurantreportexport/{slug}', [App\Http\Controllers\RestaurantreportController::class, 'restaurantreportexport']);
Route::get('misreport/misreportexport/{slug}', [App\Http\Controllers\MisreportController::class, 'misreportexport']);
Route::get('weeklypaymentforhost/weeklypaymentexport/{slug}', [App\Http\Controllers\WeeklypaymentforhostController::class, 'weeklypaymentexport']);
Route::get('weeklypaymentfordeliveryboy/weeklypaymentboyexport/{slug}', [App\Http\Controllers\WeeklypaymentfordeliveryboyController::class, 'weeklypaymentboyexport']);
Route::get('deliveryboyreport/deliveryboyreportexport/{slug}', [App\Http\Controllers\DeliveryboyreportController::class, 'deliveryboyreportexport']);
Route::get('blog/BlogExports/{slug}', [App\Http\Controllers\BlogController::class, 'blogexport']);



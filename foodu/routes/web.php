<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\FooditemsController;
use App\Http\Controllers\DeliveryboyController;
use App\Http\Controllers\CuisineimgController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PagesController;

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

//Default Controller
Route::get('/', 'HomeController@index');
Route::post('home/nearrest_place', 'HomeController@Nearrestplace');
Route::get('clearlog', 'HomeController@getClearlog');
Route::post('user/checkphone', 'UserController@postCheckphone');
Route::post('user/checkemail', 'UserController@postCheckemail');
Route::post('user/sendotpreg', 'UserController@postSendotpreg');
Route::post('user/updateotp', 'UserController@updateotp');
Route::post('user/checkuser', 'UserController@postCheckuser');
Route::post('user/checkloginotp', 'UserController@checkloginotp');
Route::post('user/checkphoneuserotp', 'UserController@postCheckphoneuserotp');
Route::post('user/checkuname', 'UserController@postCheckuname');
Route::post('user/usercreate', 'UserController@postUsercreate');
Route::post('user/checksocial', 'UserController@postChecksocial');
Route::get('search', 'Front\SearchController@Search');
Route::get('details/{id}', [App\Http\Controllers\Front\DetailsController::class,'productsPage']
)->where('id','[0-9]+');
Route::post('loadMore','Front\DetailsController@loadmore');
// Route::post('details/fooditems', [App\Http\Controllers\Front\DetailsController::class,'fooditems']);

Route::get('checkcart', [App\Http\Controllers\Front\CheckoutController::class,'getcheckcart']);
Route::post('addtotcart', [App\Http\Controllers\Front\CheckoutController::class,'postaddtotcart']);
//Route::get('removefromcart','Front\DetailsController@getremovefromcart');
Route::post('removefromcart', [App\Http\Controllers\Front\CheckoutController::class,'getremovefromcart']);

Route::get('searchdish','Front\SearchDishController@getsearchdish');
Route::get('searchdishresult','Front\SearchDishController@searchDishResult');
Route::get('checkout','Front\CheckoutController@getCheckout');

Route::post('deletecartitem','Front\CheckoutController@postDeletecartitem');
Route::get('{segment}','Front\ProfileController@getProfile')->where(['segment'=>'profile|changepass|orders|favourites|manage_addresses|payments|offers|offer-wallet']);
Route::post('ajax_image_upload','Front\ProfileController@Imageupload'); 
Route::post('email','Front\ProfileController@postEmail');            
Route::get('refund/checkrefund','RefundController@checkrefund');
Route::post('timevaliditycheck','Front\CheckoutController@getTimevaliditycheck');
Route::post('payment/catpaywithrazor','Front\CheckoutController@postCatpaywithrazor');
Route::post('payment/catrazorhandler','Front\CheckoutController@Catrazorhandler');
Route::post('acceptitem','Front\CheckoutController@postAcceptitem');

Route::post('checkneareraddress', [App\Http\Controllers\Front\DetailsController::class,'postCheckneareraddress']);
Route::post('showavailabletime', [App\Http\Controllers\Front\DetailsController::class,'postShowavailabletime']);
Route::post('addtofavorites','Front\DetailsController@postAddtofavorites');

Route::get('blogs', 'BlogController@blogPage');
Route::get('blogs/{id}', 'BlogController@blogPage')->where('id', '[0-9]+');
Route::post('blog/comment', 'BlogController@postComment');
Route::post('blog/reply', 'BlogController@postReply');
Route::get('blogredirect/{id}', 'BlogController@blogredirect')->where('id', '[0-9]+');

Route::get('invoiceimage/{id}', 'HomeController@invoiceimage')->where('id','[0-9A-Za-z=]+');
Route::get('imageconvert/{id}', 'HomeController@imageconvert')->where('id','[0-9A-Za-z=]+');
Route::post('sendPartnerRequest','PartnersController@sendPartnerRequest');
Route::post('details/fooddetails', [App\Http\Controllers\Front\DetailsController::class,'postFooddetails']);

Route::post('/sendfooditems',  [App\Http\Controllers\Front\DetailsController::class, 'send_fooditems']);
include('basic.php');
include('admin.php');
include('export.php');
include('api.php');
include('pages.php');
include('apiroutes.php');

// Routes for  all generated Module
// Custom routes  
/*$path = base_path().'/routes/custom/';
$lang = scandir($path);
foreach($lang as $value) {
	if($value === '.' || $value === '..') {continue;} 
	include( 'custom/'. $value );	
	
}*/
// End custom routes
Route::group(['middleware' => ['auth','ExtraParamInRequest']], function () {
	Route::resource('dashboard','DashboardController');
	include('module.php');
});
Route::group(['namespace' => 'Sximo','middleware' => 'auth'], function () {
	// This is root for superadmin
	include('sximo.php');
});
Route::group(['namespace' => 'Core','middleware' => 'auth'], function () {
	include('core.php');
});
Route::post('partnerregisteration',[App\Http\Controllers\PartnersController::class, 'partnercreation']);
Route::post('boyregisteration',[App\Http\Controllers\UserController::class, 'boyregisteration']);
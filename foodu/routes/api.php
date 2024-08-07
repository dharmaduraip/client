<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\JwtMiddleware;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    //return $request->user();

});
Route::get('services/info', 'Services\SiteController@info');

Route::get('services/cruds', 'Services\SiteController@cruds');
Route::group(['middleware' => 'sximoauth'], function () {
	Route::get('services/profile', 'Services\SiteController@profile');
	Route::post('services/saveprofile', 'Services\SiteController@Saveprofile');
	Route::get('services/notification', 'Services\SiteController@notification');
	include('services.php');
}); 
// Route::post('reorder','Api\OrderController@postReorder');

// $log = ['URI' => \Request::fullUrl(),'REQUEST_BODY' => \Request::all(),'HEADER' => \Request::header(),];
// \DB::table('tbl_http_logger')->insert(array(/*'created_at'=>$created_at,*/'request'=>'API_CALL','header'=>json_encode($log)));

Route::group(['prefix'=>'api'/*,'middleware'=>'apilog'*/],function() {
	Route::middleware([JwtMiddleware::class])->group(function () {
		Route::group(['prefix' => 'refund'],function() {
			Route::post('check-refund','RefundController@checkrefund');
			Route::post('update-refund','Api\OrderController@giverefund');
		});
	});

	//Suriya
	Route::post('checkphone','Api\RegisterController@checkphone');
	Route::post('transaction_sms','Api\RegisterController@transaction_sms');
	//Route::post('sendotp','Api\RegisterController@sendotp');
	Route::post('checkLoginotp','Api\RegisterController@checkLoginotp');
	Route::post('checkRegisterotp','Api\RegisterController@checkRegisterotp');
	Route::post('checkUser','Api\RegisterController@checkUser');
	Route::post('checksocialLogin','Api\RegisterController@checksocialLogin');
	Route::post('checkUserphone','Api\RegisterController@checkUserphone');
	Route::post('checkUserotp','Api\RegisterController@checkUserotp');
	Route::post('deliveryOtp', 'Api\RegisterController@sendotp');
	Route::get('verifyOtp', 'Api\RegisterController@verifyOtp');

	//General
	Route::post('coreDatas','Api\CommonController@coreDatas');
	Route::post('userDatas','Api\CommonController@userDatas');
	Route::get('keyDatas','Api\CommonController@keyDatas');
	Route::get('cronfun','Api\OrderController@everyminuteCron');

	//Signup & Login 
	//Route::post('register','Api\RegisterController@register');
	Route::put('activeAccount','Api\RegisterController@activeAccount');
	Route::post('signin','Api\RegisterController@signin');
	Route::put('forgetPasswordrequest','Api\RegisterController@forgetPasswordrequest');
	Route::put('resetPassword','Api\RegisterController@resetPassword');
	Route::post('socialLogin','Api\RegisterController@socialLogin');
	//User Profile
	Route::middleware([JwtMiddleware::class])->group(function () {
		Route::group(['prefix' => 'user'], function() {
			Route::post('integrateSocial','Api\UserController@integrateSocial');
			Route::get('profile','Api\UserController@profile');
			Route::post('editprofile','Api\UserController@editprofile');
			Route::put('verifyEmailRequest','Api\UserController@verifyEmailRequest');
			Route::put('verifyEmail','Api\UserController@verifyEmail');
			Route::put('changePassword','Api\UserController@changePassword');
			Route::post('favoriteAction','Api\UserController@favoriteAction');
			Route::get('savedAddress','Api\UserController@savedAddress');
			Route::get('savedFavorites','Api\UserController@savedFavorites');
			Route::post('manageSavedAddress','Api\UserController@manageSavedAddress');
			Route::get('userAvailablePromos','Api\UserController@userAvailablePromos');
			Route::get('userWalletDetail','Api\UserController@userWalletDetail');
			Route::get('userOfferDetail','Api\UserController@userOfferDetail');
			//Route::put('logout','Api\UserController@logout');
			Route::post('updateBoyStatus','Api\UserController@updateBoyStatus');
			// Route::post('updateBoyStatus','Api\AuthController@updateBoyStatus');
			// new apis
			Route::post('userRating', 'Api\UserController@userRating');
			Route::post('addFavouriteFood', 'Api\UserController@addFavouriteFood');
			Route::get('orderSummary', 'Api\UserController@orderSummary');
			Route::get('cartList', 'Api\UserController@cartList');
			Route::post('applyAddress', 'Api\UserController@applyAddress');
			Route::get('userNotifications', 'Api\UserController@userNotifications');
			Route::post('userWalletTopup', 'Api\UserController@userWalletTopup');
			Route::post('accountDelete','Api\UserController@accountDelete');
			Route::get('walletHistory', 'Api\UserController@walletHistory');
			Route::get('availableCoupons', 'Api\UserController@availableCoupons');
			Route::get('deliveryBoywallet', 'Api\UserController@DeliveryBoyWalletHistory');
			Route::get('deliveryBoywalletdetails', 'Api\UserController@BoyWalletHistoryDetails');
			Route::get('deliveryBoyearning', 'Api\UserController@deliveryBoyEarning');
			Route::get('deliveryBoyearningDetails', 'Api\UserController@BoyEarningDetails');

			Route::post('payadmin', 'Api\UserController@payAdmin');
		});
	});
	Route::post('order/orderStatusChangeRapido','Api\OrderController@orderStatusChangeRapido');

	// Order Apis
	Route::middleware([JwtMiddleware::class])->group(function () {
		Route::group(['prefix' => 'order'], function() {
			Route::post('insertOrder','Api\OrderController@insertOrder');
			Route::get('orders','Api\OrderController@orders');
			Route::get('orderDetail','Api\OrderController@orderDetail');
			Route::post('updateRating','Api\OrderController@updateRating');
			Route::get('currentOrderDetail','Api\OrderController@currentOrderDetail');
			Route::post('orderStatusChange','Api\OrderController@orderStatusChange');
			Route::post('PreOrderCallBoy','Api\OrderController@PreOrderCallBoy');
			Route::post('update-refund-order','Api\OrderController@UpdateRefundOrder');
			Route::post('reorder','Api\OrderController@postReorder');
			// new apis
			Route::post('cancel_order', 'Api\OrderController@cancel_order');
			Route::post('partnerChangeStatus', 'Api\OrderController@partnerChangeStatus');
			Route::post('requestrefundorder','Api\OrderController@UserRequestRefundOrder');
		});
	});
	//Partner Apis
	Route::middleware([JwtMiddleware::class])->group(function () {
		Route::group(['prefix' => 'partner'],function() {
			Route::get('masterDatas','Api\PartnerController@masterDatas');
			Route::post('addEditFoodItems','Api\PartnerController@addEditFoodItems');
			Route::get('viewFoodItem','Api\PartnerController@viewFoodItem');
			Route::get('foodCategoryItems','Api\PartnerController@foodCategoryItems');
			Route::get('restaurant','Api\PartnerController@restaurant');
			Route::post('addEditRestaurant','Api\PartnerController@addEditRestaurant');
			Route::post('addItems','Api\PartnerController@addItems');
			Route::post('addFooditem','Api\PartnerController@addFooditem');
			Route::post('viewCategoryItem','Api\PartnerController@viewCategoryItem');
			Route::post('sendrequesttoboy','Api\OrderController@assignordertoboy');
			// new apis
			Route::post('changeResStatus', 'Api\PartnerController@changeResStatus');
			/*Route::post('shopCreateorUpdate', 'Api\PartnerController@shopCreateorUpdate');*/
			Route::get('shopDelete', 'Api\PartnerController@shopDelete');
			Route::get('shopEarning', 'Api\PartnerController@shopEarning');
			Route::get('shopearningDetails', 'Api\PartnerController@shopEarningDetails');
		});
	});
	//Search Restaurant
	Route::get('homepage','Api\RestaurantController@homePage');
	Route::get('restaurantList/{segment}','Api\RestaurantController@restaurantList')->where(['segment' => 'home|search']);
	Route::get('restaurant','Api\RestaurantController@restaurant');
	Route::get('restaurantold','Api\RestaurantController@restaurantold');
	Route::get('searchRestaurantDish','Api\RestaurantController@searchRestaurantDish');
	Route::post('saveSearchKeyword','Api\RestaurantController@saveSearchKeyword');
	Route::get('savedSearchKeywords','Api\RestaurantController@savedSearchKeywords');
	Route::post('cartAction','Api\RestaurantController@cartAction');
	Route::get('viewCart','Api\RestaurantController@viewCart');
	Route::get('mobile/user/rapidocheck','Api\OrderController@postRapidocheck');
	Route::get('razorWebhook','Api\OrderController@razorWebhook');
	Route::get('productsearch','Api\RestaurantController@productsearch');
	Route::post('shopcreate','Api\RestaurantController@shopcreate');
    Route::get('shopcategories','Api\RestaurantController@shopcategories');
    // new apis
    Route::get('categoryFoods', 'Api\RestaurantController@categoryFoods');
    Route::get('foodView', 'Api\RestaurantController@foodView');
    Route::get('foodDetail', 'Api\RestaurantController@foodDetail');
    Route::get('showFoodRating', 'Api\RestaurantController@showFoodRating');
    Route::post('addCart', 'Api\RestaurantController@addCart');
	Route::post('showCart', 'Api\UserController@showCart');
    Route::post('userSearchKeyword', 'Api\RestaurantController@userSearchKeyword');
    Route::post('userSearchResAndDish', 'Api\RestaurantController@userSearchResAndDish');
    Route::get('userRecentSearch', 'Api\RestaurantController@userRecentSearch');
    Route::get('catFilter', 'Api\RestaurantController@catFilter');
    Route::get('helpCenter', 'Api\CommonController@helpCenter');
    Route::get('filter', 'Api\RestaurantController@filter');
    Route::post('deleteCart', 'Api\UserController@deleteCart');
    Route::get('filterOptions', 'Api\RestaurantController@filterOptions');
    Route::get('shopEdit', 'Api\RestaurantController@shopEdit');
    Route::get('shopList', 'Api\RestaurantController@shopList');
    Route::get('resSearch', 'Api\RestaurantController@resSearch');
    // Route::get('resOffers', 'Api\RestaurantController@resOffers');
    // Route::get('shopoffers', 'Api\RestaurantController@shopoffers');
    // Route::get('trainroute', 'Api\UserController@trainroute');
});

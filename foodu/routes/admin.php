<?php
Route::get('restaurant/feature',[App\Http\Controllers\RestaurantController::class, 'restaurant_feature']);
Route::get('restaurant/disnon_feat',[App\Http\Controllers\RestaurantController::class, 'editnon_feat']);
Route::post('restaurant/bulk_change_feature',[App\Http\Controllers\RestaurantController::class, 'bulk_change_feature']);
Route::post('orderdetails/orders',[App\Http\Controllers\OrderdetailsController::class, 'postOrders']);
Route::get('restaurant/change_feature/{id}/{mode}',[App\Http\Controllers\RestaurantController::class, 'change_feature']);
Route::post('user/userdatas',  [App\Http\Controllers\UserController::class, 'userdatas']);
Route::post('deliveryboyreport/phpexcel',[App\Http\Controllers\DeliveryboyreportController::class, 'postPhpexcel']);
Route::post('restaurantreport/phpexcel',[App\Http\Controllers\RestaurantreportController::class, 'postPhpexcel']);
Route::get('customer/deletecustomer',  [App\Http\Controllers\CustomerController::class, 'getDeletecustomer']);
Route::get('customer/blockcustomer',  [App\Http\Controllers\CustomerController::class, 'getBlockcustomer']);
Route::get('fooditems/removeselected',  [App\Http\Controllers\FooditemsController::class, 'getRemoveselected']);
Route::get('customer/deleteloc',  [App\Http\Controllers\LocationController::class, 'deleteloc']);
/*Store  Routes*/
Route::post('banner/store',[App\Http\Controllers\BannerController::class, 'store']);
Route::post('deliverychargesettings/store',[App\Http\Controllers\DeliverychargesettingsController::class, 'store']);
Route::post('admin/store',[App\Http\Controllers\AdminController::class, 'store']);
Route::post('location/store',[App\Http\Controllers\LocationController::class, 'store']);
Route::post('promocode/store',[App\Http\Controllers\PromocodeController::class, 'store']);
Route::post('blog/store',[App\Http\Controllers\BlogController::class, 'store']);
Route::post('addons/store',[App\Http\Controllers\AddonsController::class, 'store']);
Route::post('variations/store',[App\Http\Controllers\VariationsController::class, 'store']);
Route::post('cuisineimg/store',[App\Http\Controllers\CuisineimgController::class, 'store']);
Route::post('foodcategories/store',[App\Http\Controllers\FoodcategoriesController::class, 'store']);
Route::post('masterdata/store',  [App\Http\Controllers\MasterdataController::class, 'store']);
Route::post('deliveryboyrating/store',[App\Http\Controllers\DeliveryboyratingController::class, 'store']);
Route::get('deliveryboy/blockdelboy',  [App\Http\Controllers\DeliveryboyController::class, 'getBlockdelboy']);
Route::get('deliveryboy/deletedelboy',  [App\Http\Controllers\DeliveryboyController::class, 'getDeletedelboy']);
Route::get('partners/deletepartners',  [App\Http\Controllers\PartnersController::class, 'getDeletepartner']);
Route::get('partners/blockpartners',  [App\Http\Controllers\PartnersController::class, 'getBlockpartner']);
Route::post('DefaultImageChange',  [App\Http\Controllers\LocationController::class, 'DefaultImageChange']);
Route::get('fooditems/resdatas/{id}',  [App\Http\Controllers\FooditemsController::class, 'getResdatas']);
Route::get('fooditems/fooddelete/{id}/{res_id}',  [App\Http\Controllers\FooditemsController::class, 'getFooddelete']);
Route::get('fooditems/pickproduct/{id}/',  [App\Http\Controllers\FooditemsController::class, 'getPickproduct']);
Route::post('fooditems/listproducst',  [App\Http\Controllers\FooditemsController::class, 'postListproducst']);
Route::post('/fooditems/resdatas/fooditems/phpexcelproduct',  [App\Http\Controllers\FooditemsController::class, 'postPhpexcelproduct']);
Route::post('fooditems/insertproducts',  [App\Http\Controllers\FooditemsController::class, 'postInsertproducts']);
Route::post('fooditems/remove',  [App\Http\Controllers\FooditemsController::class, 'postRemove']);
Route::post('masterdata/remove',  [App\Http\Controllers\MasterdataController::class, 'postRemove']);
Route::get('fooditems/comboselect',  [App\Http\Controllers\FooditemsController::class, 'getComboselect']);
Route::post('fooditems/importmaster',  [App\Http\Controllers\FooditemsController::class, 'postImportmaster']);
Route::post('restaurantrating/store',[App\Http\Controllers\RestaurantratingController::class, 'store']);
Route::post('restaurant/{id}/restaurant/loadtime',[App\Http\Controllers\RestaurantController::class, 'Loadtime']);

Route::post('restaurant/{id}/restaurant/endtime',[App\Http\Controllers\RestaurantController::class, 'Endtime']);

Route::post('restaurant/{id}/restaurant/filltime',[App\Http\Controllers\RestaurantController::class, 'Filltime']);

Route::post('restaurant/restaurant/loadtime',[App\Http\Controllers\RestaurantController::class, 'Loadtime']);

Route::post('restaurant/restaurant/endtime',[App\Http\Controllers\RestaurantController::class, 'Endtime']);

Route::post('restaurant/restaurant/filltime',[App\Http\Controllers\RestaurantController::class, 'Filltime']);

Route::get('restaurant/category/{id}',  [App\Http\Controllers\RestaurantController::class, 'getCategory']);
Route::get('restaurant/resOffer/{id}',  [App\Http\Controllers\RestaurantController::class, 'getresOffer']);
Route::get('restaurantoffer/create/{id}',  [App\Http\Controllers\RestaurantController::class, 'createresOffer']);
Route::post('restaurantoffer/store',  [App\Http\Controllers\RestaurantController::class, 'poststoreresOffer']);
Route::get('restaurantoffer/edit/{id}',  [App\Http\Controllers\RestaurantController::class, 'editresOffer']);
Route::post('restaurant/savecategory/{id}',  [App\Http\Controllers\RestaurantController::class, 'postSavecategory']);
Route::get('restaurant/resdelete/{id}',  [App\Http\Controllers\RestaurantController::class, 'getResdelete']);
Route::post('user/allorderdetails',[App\Http\Controllers\UserController::class, 'postAllorderdetails']);
Route::post('cancellation_order',[App\Http\Controllers\PaymentordersController::class, 'cancellation_order']);
Route::get('orderdetails/porderaccept',[App\Http\Controllers\OrderdetailsController::class, 'getPorderaccept']);
Route::post('restauranttax','RestaurantController@onlinepaycommision');
Route::get('admin/service/{id}',[App\Http\Controllers\AdminController::class, 'getService']);
Route::post('admin/giveservice',[App\Http\Controllers\AdminController::class, 'postGiveservice']);
Route::post('fooditems/importimage',[App\Http\Controllers\FooditemsController::class, 'postImportimage']);
Route::post('fooditems/importfile',[App\Http\Controllers\FooditemsController::class, 'postImportfile']);
Route::post('offerwallet/cleardata/',[App\Http\Controllers\OfferwalletController::class, 'postCleardata']);
Route::post('misreport/phpexcel',[App\Http\Controllers\MisreportController::class, 'postPhpexcel']);

Route::post('accountdetails/store',[App\Http\Controllers\AccountdetailsController::class, 'store']);
Route::post('fooditems/store',[App\Http\Controllers\FooditemsController::class, 'store']);

Route::get('accountdetails/{id}/edit',[App\Http\Controllers\AccountdetailsController::class, 'edit']);
Route::get('accountdetails',[App\Http\Controllers\PartnersController::class, 'index']);

Route::get('accountdetails/update/{id}',[App\Http\Controllers\AccountdetailsController::class, 'edit']);
Route::get('delboyloghistory',[App\Http\Controllers\DelboyloghistoryController::class, 'index']);
Route::get('delboyloghistory/{id}/edit',[App\Http\Controllers\DelboyloghistoryController::class, 'edit']);

Route::post('updateaddress',[App\Http\Controllers\Front\ProfileController::class, 'postUpdateaddress']);
Route::get('address',[App\Http\Controllers\Front\ProfileController::class, 'getAddress']);
Route::post('saverating',[App\Http\Controllers\Front\OrdersController::class, 'postSaverating']);
Route::post('giverefund',[App\Http\Controllers\Front\OrdersController::class, 'giverefund']);
Route::post('innaugral', ['as' => 'innaugral', 'uses' => 'PromocodeController@innaugral']);

// Route::get('promocode/update',[App\Http\Controllers\PromocodeController::class, 'create']);

 // Route::get('offers/update/{id}',[App\Http\Controllers\OffersController::class, 'edit']);

Route::get('core/users/blastnotification',[App\Http\Controllers\Core\UsersController::class, 'getBlastnotification']);

Route::post('core/users/doblastnotification',[App\Http\Controllers\Core\UsersController::class, 'postDoblastnotification']);

// Route::post('transferamount',['as' => 'transferamount', 'uses' => 'WeeklypaymentforhostController@transferamount']);

//End

Route::get('couponlist',[App\Http\Controllers\Front\CheckoutController::class, 'getCouponlist']);
Route::get('promocheck',[App\Http\Controllers\Front\CheckoutController::class, 'getPromocheck']);
Route::get('removecoupon',[App\Http\Controllers\Front\CheckoutController::class, 'getRemovecoupon']);
Route::post('updatewallet',[App\Http\Controllers\Front\CheckoutController::class, 'postUpdatewallet']);
// Route::get('timevaliditycheck',[App\Http\Controllers\Front\CheckoutController::class, 'getTimevaliditycheck']);
Route::get('trackorder/{orderId}',[App\Http\Controllers\Front\CheckoutController::class, 'Trackorder']);

//Weekly Payment Route

Route::post('weeklypaymentforhost/phpexcel',[App\Http\Controllers\WeeklypaymentforhostController::class, 'postPhpexcel']);

Route::post('transferamountboy',[App\Http\Controllers\WeeklypaymentfordeliveryboyController::class, 'transferamountboy']);

Route::post('transferamount',[App\Http\Controllers\WeeklypaymentforhostController::class, 'transferamount']);

Route::get('misreport/misorder/{id}',[App\Http\Controllers\MisreportController::class, 'getMisorder']);
Route::post('dailyreport/phpexcel',[App\Http\Controllers\DailyreportController::class, 'postPhpexcel']);
Route::post('misreport/download',[App\Http\Controllers\MisreportController::class, 'postDownload']);
Route::get('orderinvoice/{id}',[App\Http\Controllers\Front\OrdersController::class, 'orderinvoice_pdf'])->where('id', '[0-9]+');
Route::get('trigger/{id}',[App\Http\Controllers\Front\CheckoutController::class, 'trigger'])->where('id', '[0-9]+');
Route::post('user/refund-order-details',[App\Http\Controllers\UserController::class, 'postRefundOrderDetails']);
Route::post('refund/refund-amount',[App\Http\Controllers\UserController::class, 'postRefundAmount']);

Route::get('count',[App\Http\Controllers\Api\OrderController::class, 'count']);

Route::get('getpartner',  [App\Http\Controllers\FooditemsController::class, 'partnerdata']);

Route::get('boyneworders/orders',[App\Http\Controllers\BoynewordersController::class, 'postOrders']);
Route::get('boyacceptedorders/orders',[App\Http\Controllers\BoyacceptedordersController::class, 'postOrders']);
Route::post('changeStatus', [App\Http\Controllers\ApprovalController::class, 'changeStatus']);
Route::post('statuschange', [App\Http\Controllers\PartnerrequestController::class, 'statuschange']);
Route::get('admincommission', [App\Http\Controllers\AdminController::class, 'admincommission']);



?>

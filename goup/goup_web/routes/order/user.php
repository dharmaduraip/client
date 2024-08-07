<?php

Route::group(['prefix' => 'store'], function (){



	Route::get('/list/{id?}', function ($id = 0) {
	    return view('order.user.home', compact('id'));
	});
	Route::get('/details/{id?}', function ($id = 0) {
	    return view('order.user.store_details', compact('id'));
	});
	

	Route::get('/cart/list', function () {
	    return view('order.user.cart_list');
	});
	Route::get('/checkout/{id}', function () {
	    return view('order.user.checkout');
	});

	Route::get('/order/{id}', function ($id = 0) {
	    return view('order.user.order_invoice', compact('id'));
	});
});

Route::view('/order/trips', 'order.user.trips');
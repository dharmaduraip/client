<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\JwtMiddleware;
use App\Http\Controllers\Api\AuthController;

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


Route::group(['prefix'=>'api'/*,'middleware'=>'apilog'*/],function() {

Route::post('register',[App\Http\Controllers\Api\AuthController::class, 'register']);
Route::get('showProfile',[App\Http\Controllers\Api\AuthController::class, 'showProfile']);
Route::post('updateProfile',[App\Http\Controllers\Api\AuthController::class, 'updateProfile']);

Route::post('sendotp',[App\Http\Controllers\Api\AuthController::class, 'sendotp']);
Route::post('verifyotp',[App\Http\Controllers\Api\AuthController::class, 'verifyotp']);
Route::post('me',[App\Http\Controllers\Api\AuthController::class, 'me']);
Route::post('logout',[App\Http\Controllers\Api\AuthController::class, 'logout']);
Route::get('refresh',[App\Http\Controllers\Api\AuthController::class, 'refresh']);
// Route::get('userprofile',[App\Http\Controllers\Api\AuthController::class, 'userprofile']);
// Route::patch('userprofile',[App\Http\Controllers\Api\AuthController::class, 'userprofile']);

// $log = ['URI' => \Request::fullUrl(),'REQUEST_BODY' => \Request::all(),'HEADER' => \Request::header(),];
// \DB::table('tbl_http_logger')->insert(array(/*'created_at'=>$created_at,*/'request'=>'API_CALL','header'=>json_encode($log)));
Route::match(['get', 'put' , 'patch'], 'userprofile', [App\Http\Controllers\Api\AuthController::class, 'userprofile']);

});

Route::group(['middleware'=>'api', 'middleware'=>'auth:api','prefix'=>'api'],function() {

Route::match(['get', 'put'], 'shops', [App\Http\Controllers\Api\VendorController::class, 'shop']);

 Route::match(['get', 'put','delete','post'], 'menu', [App\Http\Controllers\Api\VendorController::class, 'menu']);
 
 Route::get('tableDatas',[App\Http\Controllers\Api\CommonController::class, 'TableDatasAll']);
});
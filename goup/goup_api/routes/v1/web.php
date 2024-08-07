<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

use Illuminate\Support\Facades\Mail;
use App\Models\Common\Setting;


$router->get('/', function () use ($router) {
   return view('index');
});

$router->post('verify', 'LicenseController@verify');


$router->post('base', 'V1\Common\CommonController@base');
$router->get('cmspage/{type}', 'V1\Common\CommonController@cmspagetype');

$router->group(['prefix' => 'api/v1'], function ($app) {

	$app->get('/revoult_success', 'V1\Common\PaymentController@revoult_verify_payment');

	$app->post('nowpayment/verify/payment', 'V1\Common\PaymentController@nowpayment_verify_payment');

	$app->post('nowpayment/failure/payment', 'V1\Common\PaymentController@nowpayment_failure_payment');

	$app->post('verify/payment', 'V1\Common\PaymentController@verify_payment');

	$app->post('failure/payment', 'V1\Common\PaymentController@failure_payment');

	$app->post('check/payment/redirect', 'V1\Common\PaymentController@payment_redirect');

	$app->post('user/appsettings', 'V1\Common\CommonController@base');

	$app->post('provider/appsettings', 'V1\Common\CommonController@base');

	$app->get('countries', 'V1\Common\CommonController@countries_list');

	$app->get('states/{id}', 'V1\Common\CommonController@states_list');

	$app->get('cities/{id}', 'V1\Common\CommonController@cities_list');

	$app->post('/{provider}/social/login', 'V1\Common\SocialLoginController@handleSocialLogin');

	$app->post('/chat', 'V1\Common\CommonController@chat');

	$app->post('/provider/update/location', 'V1\Common\Provider\HomeController@update_location');

});

$router->get('/send/{type}/push', 'V1\Common\SocialLoginController@push');

$router->get('v1/docs', ['as' => 'swagger-v1-lume.docs', 'middleware' => config('swagger-lume.routes.middleware.docs', []), 'uses' => 'V1\Common\SwaggerController@docs']);

$router->get('/api/v1/documentation', ['as' => 'swagger-v1-lume.api', 'middleware' => config('swagger-lume.routes.middleware.api', []), 'uses' => 'V1\Common\SwaggerController@api']);

$router->get('/testmail', function () use ($router) {
	$settings = json_decode(json_encode(Setting::where('company_id',1)->first()->settings_data));
	
   $maill= Mail::send('mails.welcome', ['user' => (object)['first_name'=>'test'],'settings'=>$settings], function ($mail) {
			$mail->from('danihirpo@gmail.com', 'GojekFeatureEnhancement');
			$mail->to('mathavan.g@abserve.tech', "testuser")->subject('Welcome');
		});
   dd($maill);
});
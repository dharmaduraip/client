<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\HomeController;
use App\Http\Controllers\Api\RegisterController;
use App\Http\Controllers\Api\CompanyController;
use App\Http\Controllers\Api\EmployerController;
use App\Http\Controllers\Payment\RazorpayController;


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
$log = ['URI' => \Request::fullUrl(),'REQUEST_BODY' => \Request::all(),'HEADER' => \Request::header(),];
\DB::table('tbl_http_logger')->insert(array(/*'created_at'=>$created_at,*/'request'=>'API_CALL','header'=>json_encode($log)));

// Route::group(['middleware' => ['auth:api']], function () {
Route::middleware('auth:api', 'verified')->group(function () {

Route::middleware(['candi_roleapi'])->group(function () {

    Route::get('user/dashboard',[HomeController::class, 'dashboard']);
	Route::get('user/feature_job',[HomeController::class, 'feature_job']);
	Route::post('user/bkmark_job',[HomeController::class, 'bookmark'])->middleware('user_activeapi');
	Route::get('user/resume_list',[HomeController::class, 'resume_list']);
	Route::post('user/resume_add',[HomeController::class, 'resume_add']);
	Route::post('user/resume_delete',[HomeController::class, 'resume_delete']);
	Route::get('user/rt_joblist',[HomeController::class, 'recent_job']);
	Route::post('user/job_apply',[HomeController::class, 'job_apply'])->middleware('user_activeapi');
	Route::get('user/job_detail',[HomeController::class, 'job_det']);
	Route::get('user/feature_job',[HomeController::class, 'feature_job']);
	Route::get('user/comp_detail',[HomeController::class, 'comp_detail']);
	Route::get('user/pop_cate_detail',[HomeController::class, 'pop_cate_detail']);
	Route::get('user/job_del_post',[HomeController::class, 'job_postion']);
   	Route::get('user/notification',[HomeController::class, 'user_noti']);


});
Route::middleware(['employer_roleapi'])->group(function () {

	Route::get('employer/job_list',[EmployerController::class, 'emplo_job_list']);
	Route::get('employer/job_detail',[EmployerController::class, 'emplo_job_det']);
    Route::delete('employer/job_delete',[EmployerController::class, 'emplo_job_delete']);
	Route::get('employer/job_create',[EmployerController::class, 'emplo_job_create'])->name('job_create');
	Route::get('employer/job_show',[EmployerController::class, 'emplo_job_create'])->name('job_show');
	Route::post('employer/job_save',[EmployerController::class, 'emplo_job_save']);
	Route::post('employer/job_update',[EmployerController::class, 'emplo_job_update']);

	Route::post('employer/clone',[EmployerController::class, 'emplo_jobClone']);
	Route::post('employer/feat_job',[EmployerController::class, 'emplo_jobfeat']);
	Route::post('employer/highlight_job',[EmployerController::class, 'emplo_jobhigh']);

   	Route::post('employer/job/{status}',[EmployerController::class, 'emplo_exp_status']);
    Route::get('employer/comp_detail',[EmployerController::class, 'emplo_comp_detail']);
    //Route::get('employer/find_candidate',[EmployerController::class, 'emplo_find_candi']);
	Route::get('employer/candidate_resume',[EmployerController::class, 'emplo_candi_resume']); // detailapi
	Route::get('employer/notification',[EmployerController::class, 'emplo_noti']);
	Route::get('employer/pay_job_save',[EmployerController::class, 'emplo_ppjobsave']);

	Route::post('employer/{type}/add_new',[EmployerController::class, 'add_field']);
    Route::post('employer/saved_candidate',[EmployerController::class, 'saved_candidate']);
	Route::get('employer/book_candidate_list',[EmployerController::class, 'bookmark_list']);
	Route::get('employer/book_category_list',[EmployerController::class, 'book_cate_list']);

	Route::post('employer/book_cate_save',[EmployerController::class, 'bookmark_save']);
	Route::get('employer/book_cate_show',[EmployerController::class, 'bookmark_show']);
	Route::post('employer/book_cate_update',[EmployerController::class, 'bookmark_save'])->name('book_cate_update');	// Book category name for validation
	Route::delete('employer/book_cate_delete',[EmployerController::class, 'bookmark_delete']);
	Route::post('purchasePlan', [RazorpayController::class, 'purchasePlan']); 



/********** *******/
	Route::get('employer/appli_grp_list',[EmployerController::class, 'appli_grp_list']);
	Route::post('employer/appli_grp_save',[EmployerController::class, 'appli_grp_save']);
	Route::get('employer/appli_grp_show',[EmployerController::class, 'appli_grp_show']);
	Route::post('employer/appli_grp_update',[EmployerController::class, 'appli_grp_save'])->name('appli_update');	// application group name for validation
	Route::delete('employer/appli_grp_delete',[EmployerController::class, 'appli_grp_delete']);



    /**********/
    Route::get('employer/job_applicant',[EmployerController::class, 'emplo_applicant']);
    Route::post('employer/job_applicant_save_group',[EmployerController::class, 'emplo_applicant_save_group']);
   	Route::get('employer/job_app_detail',[EmployerController::class, 'emplo_app_detail']);
   	Route::post('employer/purchaseFreePlan',[EmployerController::class, 'emplo_purchaseFreePlan']);

});
Route::get('logout',[HomeController::class, 'logout']);

});


Route::get('employer/find_candidate',[EmployerController::class, 'emplo_find_candi']);



/* Route::middleware('auth:api')->get('/user', function (Request $request) {

	Route::get('dashboard',[HomeController::class, 'dashboard']);

    return $request->user();
}); */
Route::post('signup', 'App\Http\Controllers\Api\RegisterController@signup');
Route::post('login', 'App\Http\Controllers\Api\RegisterController@login');
Route::post('verifyotp', 'App\Http\Controllers\Api\RegisterController@verifyOTP');
Route::post('generateotp', 'App\Http\Controllers\Api\RegisterController@generateOTP');

Route::post('forgetPassword', 'App\Http\Controllers\Api\RegisterController@forgetPasswordrequest');
Route::post('resetPassword', 'App\Http\Controllers\Api\RegisterController@resetPassword');

Route::post('emailVerifyOTP', 'App\Http\Controllers\Api\RegisterController@emailVerifyOTP');



// Route::get('findemployers','App\Http\Controllers\Api\HomeController@findemployes');

Route::post('upgrade','App\Http\Controllers\Api\CompanyController@upgrade');

Route::middleware(['auth:api'])->group(function () {
    Route::get('jobAlerts','App\Http\Controllers\Api\HomeController@jobAlerts');
    Route::get('favorite','App\Http\Controllers\Api\HomeController@favorite_jobs');
    Route::get('getProfile','App\Http\Controllers\Api\CandidateController@Profile');
    Route::post('profile','App\Http\Controllers\Api\CandidateController@Profile');
   // Route::patch('updateProfile','App\Http\Controllers\Api\CandidateController@Profile');
    Route::delete('deleteProfile','App\Http\Controllers\Api\CandidateController@Profile');
    Route::get('details','App\Http\Controllers\Api\CandidateController@getprofile');
   // Route::post('upgrade','App\Http\Controllers\Api\CompanyController@upgrade');
    Route::get('dashboard','App\Http\Controllers\Api\CompanyController@dashboard');
    Route::get('senderlist', 'App\Http\Controllers\Api\CandidateController@SenderMessageList');
    Route::get('messagesend', 'App\Http\Controllers\Api\CandidateController@MessageDetails');
    Route::post('messagesend', 'App\Http\Controllers\Api\CandidateController@MessageDetails');

    Route::get('home','App\Http\Controllers\Api\HomeController@homepage');
    Route::get('country','App\Http\Controllers\Api\HomeController@country');
    Route::get('state','App\Http\Controllers\Api\HomeController@state');
    Route::get('findjob','App\Http\Controllers\Api\HomeController@findjob');
    Route::get('top_comp',[HomeController::class, 'topcomp']);
    Route::delete('delete_account','App\Http\Controllers\Api\CandidateController@deleteAccount');


});



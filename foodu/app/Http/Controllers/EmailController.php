<?php namespace App\Http\Controllers;

use App\Http\Controllers\controller;
use Illuminate\Http\Request;
use Validator, Input, Redirect ; 

class EmailController extends Controller {

	public function __construct() {
	}

	function sendEmail($to,$subject,$view,$data)
	{
		$from = CNF_EMAIL;
		$domain = $_SERVER['HTTP_HOST'];
		if($domain != 'localhost'){
			// \Mail::send($view,$data,function($message) use ($to,$subject,$from) {
			// 	$message->to($to)->subject($subject);
			// 	$message->from($from);
			// });
		}
		return 'success';
	}

	public function postEmailsubscription( Request $request) {
		$type = $request->type;
		if($type){
			if($type == 'emailSubscription'){
				$email = $request->email;
				$inserted = \DB::table('abserve_subscription')->insertGetId(['mail'=>$email,'created'=>time()]);
				if($inserted){
					$response['message'] = 'success';
				} else {
					$response['message'] = 'failure';
				}
			}
			echo json_encode($response);exit();
		}
	}
}
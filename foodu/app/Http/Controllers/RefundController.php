<?php namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\OrderController as ordercon;
use App\Models\RefundDetails;
use App\Models\OrderDetail;
use App\Models\Orderstatustime;
use App\Models\OrderItems;
use App\Models\Wallet;
use App\User;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use Validator, Input, Redirect ; 


class RefundController extends Controller {

	function __construct(Request $request)
	{
		$this->middleware('auth',['only' => ['checkrefund']]);
	}

	public function checkrefund(Request $request)
	{
		$response = array();
		$rules = array();
		$rules['id'] = 'required|exists:abserve_order_details,id';

		$status = 503;
		$message = 'Service is not available at the moment please try later ...';

		$validate = Validator::make($request->all(), $rules);
		if ($validate->passes()) {
			$oId = $request->id;
			$response['oId'] = $oId;
			$user = \Auth::user();
			if (OrderDetail::where('cust_id',$user->id)->where('id',$oId)->where('status','4')->exists()) {	
				$order = OrderDetail::where('cust_id',$user->id)->where('id',$oId)->where('status','4')->first();
				if (RefundDetails::where('parent_order',$oId)->exists()) {
					$refundDetails = RefundDetails::where('parent_order',$oId)->first();
					$response['data'] = $refundDetails;
					$message = 'Your request is processing by our support';
					// $status = 200;
				}else{			
					$message = 'Enter your comment then upload photo of the product our support will response to you.';
					$status = 200;
				}
				$response['order'] = $order;

			}else{
				$message = 'You dont have permission to update this order.';
				$status = 402;
			}
		}else{
			$message = $validate->errors()->first();
		}
		$response['message'] = $message;
		$response['status'] = $status;
		$response['html'] =(string) view('front.profile.refundmodal',$response);
		return $response;
	}
}
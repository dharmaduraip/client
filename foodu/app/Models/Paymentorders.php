<?php namespace App\Models;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\OmniPaymentController;
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use DB;


class paymentorders extends Sximo  {
	
	protected $table = 'abserve_order_details';
	protected $primaryKey = 'id';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		if(\Auth::user()->group_id ==  1 || \Auth::user()->group_id ==  2 || \Auth::user()->group_id ==  6) 
			return "  SELECT abserve_order_details.* FROM abserve_order_details 
						JOIN tb_users ON `tb_users`.id = `abserve_order_details`.cust_id
						JOIN abserve_restaurants ON `abserve_restaurants`.id = `abserve_order_details`.res_id ";
		else 
			return "  SELECT abserve_order_details.* FROM abserve_order_details
						JOIN abserve_restaurants ON `abserve_restaurants`.id = `abserve_order_details`.res_id ";
	}	

	public static function queryWhere(  ){
		if(\Auth::user()->group_id ==  1 || \Auth::user()->group_id ==  2 || \Auth::user()->group_id ==  5 || \Auth::user()->group_id ==  6)
			return "  WHERE abserve_order_details.id IS NOT NULL AND (abserve_order_details.status =  '1' OR abserve_order_details.status =  '2' OR abserve_order_details.status =  '3' OR abserve_order_details.status =  '6' OR abserve_order_details.status =  'boyPicked' OR abserve_order_details.status =  'boyArrived') ";
		else
			return "  WHERE abserve_order_details.id IS NOT NULL AND (abserve_order_details.status =  '1' OR abserve_order_details.status =  '2' OR abserve_order_details.status =  '3' OR abserve_order_details.status =  '6' OR abserve_order_details.status =  'boyPicked' OR abserve_order_details.status =  'boyArrived') AND abserve_order_details.partner_id = ".\Auth::user()->id." ";

	}
	
	public static function queryGroup(){
		return "  ";
	}

	public static function getCancelCategories(){
		$data = \DB::select('SELECT * FROM abserve_cancellation_category where status = 1');
		return $data;
	}
	
	public static function getCancelCategoryDetails($categoryID){
		$data = \DB::select('SELECT * FROM abserve_cancellation_category where id = '.$categoryID);
		return $data[0];
	}
	public static function getOrderDetails($orderID){
		$data = \DB::select('SELECT * FROM abserve_order_details where id = '.$orderID);
		return $data[0];
	}
	public function cancelOrder($orderId,$chef_earnings,$customer_refund,$delivery_earning, $cancel_reason,$cancelCat){
		
		$getPaymentType = \DB::SELECT("select delivery_type from abserve_order_details where id = ".$orderId)[0];

		$flag = 1;
		if($getPaymentType->delivery_type == 'razorpay' && $customer_refund != 0)
		{
				$order_details =\DB::select("select * from abserve_order_payment_detail where order_id=".$orderId)[0];
				$razorpay_payment_id = $order_details->transaction_id;
				$razorpay_order_id = $order_details->transaction_orderid;


		        if(is_null($razorpay_payment_id)){
		        	$response = "Sorry! Razorpay Payment ID Not Found.";
		        	return $response;
		        }
		        //CALL REFUND COMMON METHOD
		        $omniRefund = new OmniPaymentController();
		        $customer_refund = $customer_refund * 100;
		        $refund_id = $omniRefund->razorpayRefund($razorpay_payment_id, $customer_refund);
		        if(!$refund_id)
		        	return $res;
		}
		//COD or razor
		if($flag == 1){

            $last_insert_id='null';
            if(isset($refund_id))
            {
            	$data = \DB::INSERT("INSERT INTO  abserve_refund(order_id,refund_amount,refunded_amount,refund_id,refund_status,refund_currency, created_at,updated_at,payment_order_id,payment_id) VALUES('".$orderId."', '".$customer_refund."', '".$customer_refund."', '".$refund_id."', 'processed','INR',CURRENT_TIMESTAMP,CURRENT_TIMESTAMP, '".$razorpay_order_id."', '".$razorpay_payment_id."'  )");
            		$last_insert_id = DB::getPdo()->lastInsertId();
            	}
				
					 $data = \DB::update("UPDATE abserve_order_details SET cancelled_by = '".$cancelCat."', chef_received_amount=$chef_earnings, cancelled_boy_del_charge=$delivery_earning, refund_id=$last_insert_id, cancel_reason='".$cancel_reason."', status='5', customer_status='cancelled' WHERE id=".$orderId);
					 $Order = paymentorders::getOrderDetails($orderId);
					  \DB::table('delivery_boy_new_orders')->where('order_id',$Order->id)->update(['status'=>'Rejected']);
					 if($Order->boy_id > 0)
					 {
					 	\DB::table('tb_users')->where('id','=',$Order->boy_id)->update(['boy_status'=>'0']);
					 	 \DB::table('delivery_boy_new_orders')->where('boy_id',$Order->boy_id)->where('order_id',$Order->id)->update(['status'=>'Rejected']);
					 }
					 if($data)
					 {
						$message    = " Oh No! Your Order ".$Order->id." has cancelled. Sorry!";
						$OrderController = new OrderController;
						$OrderController->pushNotifyAdminPanel($Order->cust_id,'user',$message);
						//notify user through socket
		                if(SOCKET_ACTION == 'true'){
		                  	require_once SOCKET_PATH;
		                  	$aData = array(
			                    'customer_id' => $Order->cust_id,
			                    'order_id' => $Order->id,
			                    'partner_id' => $Order->partner_id,
			                    'cancelled_by' => $Order->cancelled_by
			                );
		                  	$client->emit('partner rejected', $aData);
		                } 
					 	return "Order cancelled successfully!!!";
					 }else {
						return "Something went wrong. Please try again.";
					 }
				
		}

		

	}

}

<?php namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Models\Front\Offers;
use App\Models\Wallet;
use App\Models\OfferUsers;
use App\Models\Front\Usercart;
use App\Models\Front\Restaurant;
use App\Models\OrderDetail;
use App\Models\Orderstatustime;
use App\Models\OrderItems;
use App\Models\RefundDetails;
use Validator, Input, Redirect ,DB, DateTime, Session , Response; 
use Auth, Crypt ; 


use Dompdf\Dompdf;

class OrdersController extends Controller {

	public function postSaverating (Request $request)
	{
		$rid = $request->rid;
		$rat = $request->rating;
		$oid = $request->oid;
		$comment = $request->comment;
		$boycomment = $request->boycomment;
		$boyid = $request->boyid;
		$boyrating = $request->boyrating;
		$authid = \Auth::user()->id;
		$rating_info = \DB::table('abserve_rating')->where('orderid',$oid)->where('cust_id','=',$authid)->where('res_id','=',$rid)->first();
		if(!empty($rating_info)) {
			$updated = \DB::table('abserve_rating')->where('orderid',$oid)->where('cust_id',$authid)->where('res_id',$rid)->update(array('rating'=>$rat,'comments'=>$comment));
		} else {
			$updated = \DB::table('abserve_rating')->insert(array('cust_id'=>$authid,'res_id'=>$rid,'rating'=>$rat,'orderid'=>$oid,'comments'=>$comment));
		}
		$boyratinginfo = \DB::table('abserve_rating_boy')->where('orderid',$oid)->where('boy_id',$boyid)->where('cust_id','=',$authid)->where('res_id','=',$rid)->first();
		if(!empty($boyratinginfo)) {
			$boyupdated =\DB::table('abserve_rating_boy')->where('orderid',$oid)->where('boy_id',$boyid)->where('cust_id','=',$authid)->where('res_id','=',$rid)->update(array('rating'=>$boyrating,'comments'=>$boycomment));
		} else {
			$boyupdated = \DB::table('abserve_rating_boy')->insert(array('cust_id'=>$authid,'res_id'=>$rid,'orderid'=>$oid,'boy_id'=>$boyid ,'rating'=>$boyrating,'comments'=>$boycomment));
		}
			
		if($updated || $boyupdated){
			$response['message'] = 'success';
		} else {
			$response['message'] = 'fail';
		}
		return Response::json($response);
	}

	/*public function checkrefund(Request $request)
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
		$response['html'] =(string) view('front.modal',$response);
		return $response;
	}*/

	public function giverefund(Request $request)
	{
		$response = array();
		$rules = array();
		$rules['oId']              = 'required|exists:abserve_order_details,id';
		$rules['customer_comment'] = 'required';
		$rules['image']            = 'required';
		$rules['image.*']          = 'mimes:jpeg,jpg,png|max:10240';
		$rules['type']            = 'required';
		$rules['items']            = 'required|array';
		$rules['items.*']          = 'exists:abserve_order_items,id';

		$status = 503;
		$message = 'Service is not available at the moment please try later ...';
		$validate = Validator::make($request->all(), $rules);
		if ($validate->passes()) {
			$oId = $request->oId;

			$itemsCount = !empty($request->items) ? count($request->items) : 0;
			$checkCount = OrderItems::whereIn('id',$request->items)->where('orderid',$oId)->count();
			$message = 'Mismatch with our order items ...';
			if ($checkCount == $itemsCount) {
				$response['oId'] = $oId;
				$user = \Auth::user();
				$submit = $this->giveRefundCommon($request,$user);
				$message = $submit['message'];
				$status = $submit['status'];
			}
		}else{
			$message = $validate->errors()->first();
		}

		$sMessage = 'danger';
		if ($status == 200) {
			$sMessage = 'success';
		}
		$response['message'] = $message;
		$response['alertMessage'] = '<div class="alert alert-'.$sMessage.' alert-dismissible fade in" role="alert">
		<strong>Status : </strong> '.$message.'
		<button type="button" class="close" data-bs-dismiss="alert" aria-label="Close">
		<span aria-hidden="true">&times;</span>
		</button>
		</div>';
		$response['status'] = $status;
		return $response;
	}

	public function giveRefundCommon(Request $request,$user)
	{
		$oId = $request->oId;
		if (!empty($user) && OrderDetail::where('cust_id',$user->id)->where('id',$oId)->where('status','4')->where('order_type','Initial')->exists()) {			
			$orderDetails = OrderDetail::find($oId);
			if (RefundDetails::where('parent_order',$oId)->exists()) {
				$refundDetails = RefundDetails::where('parent_order',$oId)->first();
				$order = OrderDetail::find($refundDetails->child_order);
			}else{			
				$refundDetails = new RefundDetails();
				$order = new OrderDetail();
			}
			$order_type = 'Refund';
			if ($request->type == 'replace') {
				$order_type = 'Replace';
			}
			$order->order_type                 = $order_type;
			$order->refund_id                  = $orderDetails->id;
			$order->refund_status              = 'Customer Requested';

			$order->cust_id                    = $orderDetails->cust_id;
			$order->res_id                     = $orderDetails->res_id;
			$order->partner_id                 = $orderDetails->partner_id;
			$order->orderid                    = $orderDetails->orderid;
			$order->mobile_num                 = $orderDetails->mobile_num;

			$order->host_withcommission        = $orderDetails->host_withcommission;
			$order->host_amount                = $orderDetails->host_amount;
			
			$order->admin_camount              = $orderDetails->admin_camount;

			$order->del_km                     = $orderDetails->del_km;
			$order->del_charge                 = $orderDetails->del_charge;
			$order->del_charge_tax_percent     = $orderDetails->del_charge_tax_percent;
			$order->del_charge_tax_price       = $orderDetails->del_charge_tax_price;
			$order->f_del_charge               = $orderDetails->f_del_charge;
			$order->add_del_charge             = $orderDetails->add_del_charge;
			$order->min_night                  = $orderDetails->min_night;
			$order->boy_del_charge             = $orderDetails->boy_del_charge;
			$order->admin_del_charge           = $orderDetails->admin_del_charge;

			$order->address                    = $orderDetails->address;
			$order->building                   = $orderDetails->building;
			$order->landmark                   = $orderDetails->landmark;
			$order->status                     = '0';
			$order->time                       = time();
			$order->date                       = date('Y-m-d');
			$order->delivery                   = 'unpaid';
			$order->delivery_type              = $orderDetails->delivery_type;
			$order->lat                        = $orderDetails->lat;
			$order->lang                       = $orderDetails->lang;
			$order->order_note                 = $orderDetails->order_note;



			$order->device                     = $orderDetails->device;

			$order->delivery_preference        = $orderDetails->delivery_preference;
			$order->ordertype                  = $orderDetails->ordertype;
			
			$order->grand_total                = $orderDetails->grand_total;

			$order->save();

			$refundDetails->parent_order = $oId;
			$refundDetails->child_order = $order->id;
			$refundDetails->comment	 = $request->customer_comment;

			$dataFile = array();

			if($request->hasfile('image'))
			{
				foreach($request->file('image') as $fKey => $file)
				{
					$document = $file;
					$filename = time().'-'.($fKey+1).'.'.$document->getClientOriginalExtension();
					$destinationPath = base_path('/uploads/refund/'.$oId.'/customer');
					$document->move($destinationPath, $filename);
					$dataFile[] = $filename;
				}
			} 
			$refundDetails->customer_image	 = json_encode($dataFile);  
			$refundDetails->save();


			$orderDetails->refund_id = $refundDetails->id;
			$orderDetails->refund_order = 'Active';
			$orderDetails->save();


			/*Savaing Refund Items*/
				$insertItems = OrderItems::whereIn('id',$request->items)->where('orderid',$oId)->get();
				if (!empty($insertItems)) {	
					OrderItems::where('orderid',$order->id)->delete();
					foreach ($insertItems as $ikey => $ivalue) {
						$newValue                 = array();
						$newValue["orderid"]      = $order->id;
						$newValue["food_id"]      = $ivalue->food_id;
						$newValue["food_item"]    = $ivalue->food_item;
						$newValue["adon_type"]    = $ivalue->adon_type;
						$newValue["adon_id"]      = $ivalue->adon_id;
						$newValue["adon_detail"]  = $ivalue->adon_detail;
						$newValue["quantity"]     = $ivalue->quantity;
						$newValue["price"]        = $ivalue->price;
						$newValue["hiking"]       = $ivalue->hiking;
						$newValue["vendor_price"] = $ivalue->vendor_price;
						$newValue["item_note"]    = $ivalue->item_note;
						$newValue["check_status"] = $ivalue->check_status;
						$newValue['orderid']      = $order->id;
						if (!empty($newValue)) {
							OrderItems::insert($newValue);
						}
					}
				}
			/*Savaing Refund Items End*/



			$orderstat = new Orderstatustime;
			$orderstat->order_id = $order->id;
			$orderstat->status = '0';
			$orderstat->created_at = date('Y-m-d H:i:s');
			$orderstat->updated_at = date('Y-m-d H:i:s');
			$orderstat->save();

			$message = 'All are setted.';
			$status = 200;
		}else{
			$message = 'You dont have permission to update this order.';
			$status = 503;
		}
		$response = ['message'=>$message,'status'=>$status];
		return $response;
	}

	public function orderinvoice_pdf(Request $request,$id)
	{
		$orderid		= $request->id;
		$user_id		= \Auth::user()->id;
		$aOrder			= OrderDetail::find($orderid);

		$order			= \DB::table('abserve_order_details')->where('id',$orderid)->get();
		
		$order_items 	= \DB::table('abserve_order_items')->where('orderid',$orderid)->get();
		$customer		= \DB::table('tb_users')->where('id',$order[0]->cust_id)->first();
		$email			= \DB::table('tb_users')->where('id',$order[0]->cust_id)->first();
		$address		= \DB::table('abserve_user_address')->where('id',$order[0]->cust_id)->first();
		if(isset($order[0]->phone_num)){
			$phone_number	= \DB::table('tb_users')->where('phone_number',$order[0]->phone_num)->first();
		}
		if(isset($order[0]->food_item)){
			$product_items	= \DB::table('abserve_order_items')->where('id',$order[0]->food_item)->first();
		}
		$aOrder->except_grand_total	= $aOrder->s_tax1 + $aOrder->gst + $aOrder->del_charge + $aOrder->del_charge_tax_price + $aOrder->festival_mode_charge + $aOrder->bad_weather_charge - $aOrder->wallet_amount;
		$wallet 		= 0;
		$wallet 		= Wallet::where('order_id',$orderid)->where('type','credit')->sum('amount');
		$cash_back_off	= OfferUsers::where('order_id',$orderid)->first();
		/*if ($cash_back_off['type'] == 'debit') {
			$cash_back  = $cash_back_off['offer_price'];
			$aOrder->grand_total = $aOrder->grand_total - $cash_back;
		}else { 
			$cash_back  = 0;
		}*/
		$cur_symbol		= \AbserveHelpers::getBaseCurrencySymbol();
		$order_detail	= array(
			'order'			=> $order, 
			'order_items'	=> $order_items,
			'cust_name'		=> $customer,
			'type'			=> $request->type,
			'cur_symbol'	=> $cur_symbol,
			'aOrder'		=> $aOrder,
			'wallet'		=> $wallet,
			'cash_back'		=> $cash_back_off
		);


		$dompdf = new Dompdf();
		$html = (string)view('user.orderinvoice',$order_detail);
		// echo $html;
		// exit();		//print_r($order_detail);exit();
		$dompdf->load_html($html);
		$options = $dompdf->getOptions();
		$options->setDefaultFont('helvetica');
		$dompdf->setOptions($options);
		$dompdf->set_paper('A4','portrait');
		$dompdf->render();
		// $output = $dompdf->output();
		return $dompdf->stream();
	}
}
?>
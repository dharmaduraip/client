<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Razorpay\Api\Api;
use Session;
use Exception;
use App\Models\OrderDetail;
use App\Models\OrderRefund;

class RazorpayPaymentController extends Controller
{
    private $Api;
    public function __construct()
    {
        $this->Api = new Api(RAZORPAY_API_KEYID,RAZORPAY_API_KEY_SECRET);
    }
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function index()
    {        
        return view('razorpayView');
    }

    /**
     * Write code on Method
     *
     * @return response()
     */

    public function refund($token, $amount = 0)
    {
        $api        = $this->Api;
        $status     = true;
        $refund     = '';
        $paymentId  = $token->payment_token;

        if(!empty($paymentId) && $token->delivery=='paid' && $token->delivery_type=='razorpay'){
            try {
                if (!empty($amount) && $amount > 0) {
                    $paisa  = $amount * 100;
                    $refund = $api->refund->create(array('payment_id' => $paymentId, 'amount'=>$paisa));
                } else {
                    $refund = $api->refund->create(array('payment_id' => $paymentId));
                }
                
                $message = $refund->status;

                $token->refund_id   = $refund->id;
                $token->refund_order    = 'active';
                $token->save();

                $aOrder = OrderDetail::with('refund_info')->find($token->id);

                if(empty($aOrder->refund_info)){
                    $refundResponse = $api->payment->fetch($paymentId);

                    $refund         = new OrderRefund;
                    $refund->order_id           = $aOrder->id;
                    $refund->payment_order_id   = $aOrder->orderid;
                    $refund->payment_id         = $aOrder->payment_token;
                    $refund->refund_amount      = $amount;
                    $refund->refund_id          = $refundResponse->id;
                    $refund->refunded_amount    = $refundResponse->status == '1' ? ($refundResponse->amount / 100) : 0;
                    $refund->refund_currency    = $refundResponse->currency;
                    $refund->refund_status      = $refundResponse->status;
                    $refund->created_at         = date('Y-m-d H:i:s');
                }
                else{
                    $refund = OrderRefund::find($aOrder->refund_info->id);
                    if($aOrder->delivery_type != 'cashondelivery'){
                        if($aOrder->delivery_type == 'razorpay'){
                            $paymentId  = $refund->payment_id;
                            $refundId   = $refund->refund_id;
                            $api        = new Api($api_key, $api_secret);
                            $Obrefund   = $api->payment->fetch($paymentId)->refunds()->items[0];

                            $refund->refund_status = $Obrefund->status;
                            if($Obrefund->status == '1'){
                                $refund->refunded_amount = $refundResponse->amount / 100;
                                $message    = "Refund process has been completed on order Id #".$aOrder->id;
                               // $this->sendpushnotification($aOrder->cust_id,'user',$message);
                            }
                        }
                    }

                }
                $refund->updated_at = date('Y-m-d H:i:s');
                $refund->save();
            } 
            catch (Exception $e){
                $status  = false;
                $message = $e->getMessage();
            }

        }
        // $data['status'] = $status;
        // $data['refund'] = $refund;
        // $data['amount'] = $amount;
        // $data['message']= $message;
        // return $data;
    }
}
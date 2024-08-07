<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;
use App\User;
use App\Models\Front\Restaurant;
class OrderDetail extends Sximo  {
	
	protected $table = 'abserve_order_details';
	protected $primaryKey = 'id';
	public function __construct() {
		parent::__construct();
	}

	public static function querySelect(  ){
		return "  SELECT abserve_order_details.* FROM abserve_order_details  ";
	}

	public static function queryWhere(  ){
		
		// return "  WHERE abserve_order_details.id IS NOT NULL AND abserve_order_details.order_type = 'Initial'";
		return "  WHERE abserve_order_details.id IS NOT NULL ";
	}

	public static function queryGroup(){
		return "  ";
	}

	function grozooffer(){
		return $this->hasOne('App\Models\OfferUsers','order_id','id')->orderBy('id','Desc');
	}

	function order_items(){
		return $this->hasMany('App\Models\OrderItems','orderid','id');
	}

	function accepted_order_items(){
		return $this->hasMany('App\Models\OrderItems','orderid','id')->where('check_status','yes');
	}
	function outof_stock_items(){
		return $this->hasMany('App\Models\OrderItems','orderid','id')->where('check_status','no');
	}

	function partner_info(){
		return $this->belongsTo('App\User','partner_id','id');
	}

	function boy_info(){
		return $this->belongsTo('App\Models\Deliveryboy','boy_id','id');
	}

	function user_info(){
		return $this->belongsTo('App\User','cust_id','id');
	}

	function refund_info(){
		return $this->belongsTo('App\Models\OrderRefund','id','order_id');
	}

	function restaurant(){
		return $this->belongsTo('App\Models\Front\Restaurant','res_id','id');
	}

	function getStatusTimeAttribute()
	{
		return (float) $this->attributes['lat'];
	}

	function getLatAttribute()
	{
		return (float) $this->attributes['lat'];
	}

	function getLangAttribute()
	{
		return (float) $this->attributes['lang'];
	}

	function getRestaurantInfoAttribute()
	{
		$select = ['id','name','location','logo','partner_id','delivery_time','budget','rating','res_desc','mode','delivery_time','cuisine','city','phone','latitude','longitude'];
		$query = Restaurant::select($select)->where('id',$this->res_id);
		$aRestaurant = $query->first();
		$aRestaurant->append('src'/*,'availability','cuisine_text'*/);
		return $aRestaurant;
	}

	function getInvoiceHtmlAttribute(){
		return asset('uploads/images/bill'.$this->attributes['id'].'.jpg');
	}

	function getRestaurantDetailAttribute()
	{
		$res_id = $this->res_id;
		$res = Restaurant::select('name','location','latitude','longitude','l_id')->where('id',$res_id)->first();
		$res->append('advertise','advertise_type','advertise_ext_url');
		return $res;
	}

	function getStatusTextAttribute()
	{
		$status = $this->attributes['status'];
		return \AbserveHelpers::getStatusTiming($status);
	}

	function getShowBoyButtonAttribute()
	{
		return (int) $this->boy_called;
	}

	function getRefundStatusBooleanAttribute()
	{
		$status = $this->attributes['refund_order'];
		return $status == 'Inactive' ? true : false;
	}

	/*Status Meaning
		0 - Pending					--> Order Placed
		1 - Partner Accepted		--> Order accepted & Started packing
		Packing - Packed			--> Order Packed
		2 - Boy accepted			--> Rider assigned
		3 - Handover to Boy	
		boyPicked - Boy Picked		--> Rider picked your order
		boyArrived - Boy Arrived	--> Rider arrived your location
		4 - Order Delivered			--> Order delivered
		5 - Order Cancelled (cancelled_by - restaurant / customer / system)
		6 - Partner Accepted & No boy found
	*/

	function getApiStatusTextAttribute()
	{
		$status = $this->attributes['status'];
		$text = '';
		if($status == '0' || $status == 'pending'){
			$text = 'Pending';
		} elseif($status == '1'){
			$text = 'Partner Accepted';
		} elseif($status == 'Packing'){
			$text = 'Order Packed';
		} elseif($status == '2'){
			$text = 'Rider accepted';
		} elseif($status == '3'){
			$text = 'Handovered to rider';
		} elseif($status == '4'){
			$text = 'Order Delivered';
		} elseif($status == '5'){
			$text = 'Order Cancelled';
		} elseif($status == '6'){
			$text = 'Searching for boy';
		} elseif($status == 'boyPicked'){
			$text = 'Rider picked your order';
		} elseif($status == 'boyArrived'){
			$text = 'boy on the way';
		} elseif($status == 'Reached'){
			$text = 'Rider reached';
		}
		return $text;
	}

	function getCustomerStatusTextAttribute()
	{
		$status	= $this->attributes['customer_status'];
		$text	= '';
		if($status == 'Placed'){
			$text = 'Order placed';
		} elseif($status == 'Cooking'){
			$text = 'Cooking';
		} elseif($status == 'Packing'){
			$text = 'Order packed';
		} elseif($status == 'Delivering'){
			$text = 'Order delivering';
		} elseif($status == 'Delivered'){
			$text = 'Delivered';
		} elseif($status == 'Cancelled'){
			$text = 'Cancelled';
		}
		return $text;
	}

	function getSocketStatusTextAttribute()
	{
		$status	= $this->attributes['status'];
		$c_status	= $this->attributes['customer_status'];
		$text = '';
		if($status == '0'){
			$text = 'Order Placed';
		}elseif($status == 'pending'){
			$text = 'Pending';
		}elseif($status == '1'){
			$text = 'Order Accepted';
		}elseif($status == '2' && $c_status != 'Packing'){
			$text = 'Rider Assigned';
		}elseif($c_status == 'Packing'){
			$text = 'Order Packing';
		}elseif($status == '3'){
			$text = 'Order Handovered';
		}elseif($status == 'boyPicked'){
			$text = 'Boy Picked';
		}elseif($status == 'boyArrived'){
			$text = 'Boy on the way';
		}elseif($status == 'Reached'){
			$text = 'Rider reached';
		}elseif($status == 'otpSend'){
			$text = 'delivery otp send';
		}elseif($status == 'otpVerify'){
			$text = 'delivery completed';
		}
		return $text;
	}
	public function status_do($status = 0)
	{
		$status	= $status + 1;
		$text	= '';
		if($status == '1'){
			$text = 'accepted & started packing';
		} else if($status == '2'){
			$text = 'accepted by rider';
		} else if($status == '3'){
			$text = 'handovered to rider';
		} else if($status == 'Packed'){
			$text = 'packed';
		} else if($status == 'boyPicked'){
			$text = 'picked by rider';
		} else if($status == 'boyArrived'){
			$text = 'arrived customer location';
		} elseif($status == 'Reached'){
			$text = 'Rider reached';
		} else if($status == '4'){
			$text = 'delivered';
		}
		return $text;
	}

	function getCreatedDateTimeAttribute()
	{
		$date = $this->attributes['created_at'];
		return date('d M Y, g:i a',strtotime($date));
	}

	function getFoodAvailableCountAttribute()
	{
		/*$orderItem = OrderItems::select(\DB::raw('GROUP_CONCAT(food_id) as foodids'))->where('orderid',$this->attributes['id'])->first();
		$aFoodIds = explode(',', $orderItem->foodids);

		$food = Fooditems::select('status','start_time1','end_time1','start_time2','end_time2','item_status','del_status','approveStatus')->whereIn('id',$aFoodIds)->get()->map(function ($result) {
		       	$result->append('availability');
		       	return $result;
		    });
		$totalCount = count($aFoodIds);
		$availableCount = 0;
		if(count($food) > 0){
			foreach ($food as $key => $value) {
				if($value->del_status == '0' || $value->approveStatus == 'Approved' || $food->availability['status'] == '1'){
					$availableCount += 1;
				}
			}
		}
		$unavailableCount = $totalCount - $availableCount;*/

		$totalCount = OrderItems::where('orderid', $this->attributes['id'])->sum('quantity');

		$data['totalCount'] = (int) $totalCount;
		$data['availableCount'] = $availableCount ?? 0;
		$data['unavailableCount'] = $unavailableCount ?? 0;

		return $data;
	}

	function getOngoingStatusAttribute()
	{
		$validStatus = ['0','1','2','3','Packed','boyArrived','boyPicked'];
		if(in_array($this->status, $validStatus)){
			return true;
		}
		return false;
	}

	function getOrderRecieveTextAttribute()
	{
		$validStatus = ['1','2','3','Packed','boyArrived','boyPicked'];
		if(in_array($this->status, $validStatus)){
			return 'We got your order';
		}
		return '';
	}
	function getDriverStatusTextAttribute()
	{
		$validStatus = ['1','2','3','boyArrived','boyPicked'];
		$status = $this->status;
		if(in_array($status, $validStatus)){
			if($status == '1'){
				return 'Waiting for driver acceptance';
			} elseif ($status == '2') {
				return 'Rider is heading to restaurant';
			} elseif ($status == 'boyPicked') {
				return 'Rider picked your order';
			} elseif ($status == 'boyArrived') {
				return 'Rider arrived your location';
			} else {
				return 'Rider is heading to your location';
			}
		}
		return '';
	}

	function getBoyDetailAttribute()
	{
		$boy_id = $this->boy_id;
		if($boy_id > 0){
			$select = ['username','phone_code','phone_number','avatar','latitude','longitude'];
			$delBoy = Deliveryboy::find($boy_id,$select);
			if(empty($delBoy)){
				return null;
			}
			$delBoy->append('src');
			return $delBoy;
		}
		return null;
	}

	function getCustomerDetailAttribute()
	{
		$user_id = $this->cust_id;
		if($user_id > 0){
			$select = ['id','phone_number','username as name','avatar'];
			$delBoy = \DB::table('tb_users')->select($select)->where('id',$user_id)->first();
			$path = (isset($delBoy->avatar) && $delBoy->avatar != '') ? 'uploads/users/'.$delBoy->avatar : \AbserveHelpers::getCommonImageUser();
			$delBoy->src = \URL::to($path);
			$delBoy->address = $this->address;
			return $delBoy;
		}
		return null;
	}

	function getDiscountPriceAttribute()
	{
		return number_format(($this->coupon_price + $this->offer_price),2,'.','');
	}

	function getOrderTimeAttribute()
	{
		$today = date('Y-m-d');
		$created_at = strtotime($this->created_at);
		$orderDate = date('Y-m-d',$created_at);
		if($today == $orderDate){
			$date = 'Today, ';
		} else {
			$date = $orderDate.', ';
		}
		return $date.date('H:i',$created_at);
	}

	function getRatingInfoAttribute()
	{
	    $rating_info = \DB::table('abserve_rating')->select('rating','comments')->where('orderid',$this->id)->first();
	    if($rating_info != null){
	        return $rating_info;
	    }
	    $rating_info = (object)['rating' => 0, 'comments' => ''];
		return $rating_info;
	}

	function getBoyRatingInfoAttribute()
	{
		$boy_rating_info = \DB::table('abserve_rating_boy')->select('rating','comments')->where('orderid',$this->id)->first();
		if ($boy_rating_info != null){
		    return $boy_rating_info;
		}
		$boy_rating_info = (object)['rating' => 0, 'comments' => ''];
		return $boy_rating_info;  
	}

	function getOrderRepayInfoAttribute()
	{
		if($this->grand_total > $this->paid_amount && $this->delivery_type == 'razorpay')
		{
			$amount = $this->grand_total - $this->paid_amount;
			return array(
				"order_id" => $this->orderid,
				"amount"   => $amount,
			);
		}
		return false;
	}

	function getDoPayAttribute()
	{
		if($this->delivery_type != 'cashondelivery' && $this->delivery == 'unpaid' && (time() - strtotime($this->created_at)) < CNF_PAY_WAIT_TIME){
			return true;
		}
		return false;
	}

	function getAdminShareAttribute()
	{
		return number_format(($this->admin_camount + $this->admin_del_charge + $this->del_charge_tax_price),2,'.','');
	}

	function getAdminShareTextAttribute()
	{
		return 'Item Commission + Delivery Charge Commission + Delivery Charge Tax';
	}

	function getHostShareAttribute()
	{
		return $this->host_amount;
	}

	function getHostShareTextAttribute()
	{
		return 'Total Price - Offer Price - Coupon Price - Delivery Charge Tax';
	}

	function getBoyShareAttribute()
	{
		return number_format(($this->boy_del_charge + $this->bad_weather_charge + $this->festival_mode_charge),2,'.','');
	}

	function getBoyShareTextAttribute()
	{
		return 'Delivery Charge + Bad Weather Charge + Festival Mode Charge';
	}

	function getStatusLabelAttribute()
	{
		if ($this->status == 1 ) {
			return "label-success";
		} else if ($this->status == 2) {
			return "label-primary";
		} else if ($this->status == 3) {
			return "label-info";
		} else if ($this->status == 4) {
			return "label-default";
		} else if ($this->status == 5) {
			return "label-danger";
		} else if ($this->status == 6) {
			return "label-danger";
		} else if ($this->status == 'Packing') {
			return "label-success";
		} else if ($this->status == 'boyPicked') {
			return "label-info";
		} else if ($this->status == 'boyArrived') {
			return "label-info";
		} else {
			return "label-primary";
		}
	}
	function getOrderTiming()
	{
		return $this->hasMany('App\Models\Orderstatustime','order_id','id');
	}

	function getRefundDetails()
	{
		if (\Auth::check() && \Auth::user()->group_id == 8) {
			return $this->hasMany('App\Models\RefundDetails','child_order','id');	
		}else{
			return $this->hasMany('App\Models\RefundDetails','parent_order','id');	
		}
	}

	function getBoyRefundDetails()
	{
		return $this->hasMany('App\Models\RefundDetails','child_order','id');
	}

	public function Customerorderdetail()
	{
		return $this->hasMany('App\Models\OrderDetail','cust_id','cust_id');
	}

	public function getInauguralOfferAttribute()
	{
		$isfirst		= false;
		$offer_name		= '';
		$offer_image	= '';
		$offer_content	= '';
		$datac	= $this->Customerorderdetail()->count();
		if ($datac == 1) {
			$tb_settings	= \DB::table('tb_settings')->where('neworder_from','<=',date('Y-m-d'))->where('neworder_to','>=',date('Y-m-d'))->first();
			if (!empty($tb_settings)) {
				$isfirst	= true;
				$orderValu		= $this->grand_total - $this->coupon_price;
				if ($orderValu >= 1001) {
					$offer_name	= '100g GHEE + 1kg SUGAR + 1kg RICE';
					$offer_image   = \URL::to('uploads/images/inagural/1001.png');
				} elseif ($orderValu >= 501) {
					$offer_name	= '100g GHEE + 1kg SUGAR';
					$offer_image   = \URL::to('uploads/images/inagural/501.png');
				} else {
					$offer_name	= '100g GHEE';
					$offer_image   = \URL::to('uploads/images/inagural/500.png');
				}
				$offer_content = 'Inaugural Offer';
			}
		}
		$return['isfirst']		= $isfirst;
		$return['offer_name']	= $offer_name;
		$return['offer_image']	= $offer_image;
		$return['offer_content']= $offer_content;
		return $return;
	}

	public function getCustomerInfo()
	{
		return $this->hasOne(User::class, 'id', 'cust_id');
	}
}

?>
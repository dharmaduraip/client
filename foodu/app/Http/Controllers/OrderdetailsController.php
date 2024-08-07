<?php namespace App\Http\Controllers;

use App\Models\Orderdetails;
use App\Models\OrderDetail;
use App\Models\Paymentorders;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use Validator, Input, Redirect ; 
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\mobile\UserController as usercon;
use App\Exports\OrderdetailsExport;

class OrderdetailsController extends Controller {

	protected $layout = "layouts.main";
	protected $data = array();	
	public $module = 'orderdetails';
	static $per_page	= '10';

	public function __construct()
	{
		parent::__construct();
		$this->model = new Orderdetails();	
		
		$this->info = $this->model->makeInfo( $this->module);	
		$this->data = array(
			'pageTitle'	=> 	$this->info['title'],
			'pageNote'	=>  $this->info['note'],
			'pageModule'=> 'orderdetails',
			'return'	=> self::returnUrl()
			
		);
	}

	public function index( Request $request )
	{
		if(!\Auth::check()) 
			return redirect('user/login')->with('status', 'error')->with('message','You are not login');	
		$this->grab( $request) ;
		$aGroup_id=[1,2];
		if($this->access['is_view'] ==0 || \Auth::user()->p_active != '1' && \Auth::user()->group_id != 1 && \Auth::user()->group_id != 2) 
			return Redirect::to('dashboard')
		->with('messagetext', \Lang::get('core.note_restric'))->with('msgstatus','error');
		$results['rows'] = '';
		$results['total'] = '';
		$sort = (!is_null($request->input('sort')) ? $request->input('sort') : 'id'); 
		$order = (!is_null($request->input('order')) ? $request->input('order') : 'desc');	
		$filter = (!is_null($request->input('search')) ? $this->buildSearch() : '');
		$page = $request->input('page', 1);
		$params = array(
			'page'		=> $page ,
			'limit'		=> (!is_null($request->input('rows')) ? filter_var($request->input('rows'),FILTER_VALIDATE_INT) : static::$per_page ) ,
			'sort'		=> $sort ,
			'order'		=> $order,
			'params'	=> $filter,
			'global'	=> (isset($this->access['is_global']) ? $this->access['is_global'] : 0 )
		);
		if(in_array(\Auth::user()->group_id, $aGroup_id ) || \Auth::user()->p_active == '1' ){
			$results = $this->model->getRows($params,\Auth::user()->id);
			//echo "<pre>"; print_r($this->model);exit();
			$page = $page >= 1 && filter_var($page, FILTER_VALIDATE_INT) !== false ? $page : 1;	
			$pagination = new Paginator($results['rows'], $results['total'], $params['limit']);	
			$pagination->setPath('orderdetails');
			$this->data['pagination']	= $pagination;
		}
		$payorder = new Paymentorders();
		$this->data['cancel_categories'] = $payorder->getCancelCategories();
		$this->data['results']		= $results['rows'];
		$this->data['pager'] 		= $this->injectPaginate();	
		$this->data['i']			= ($page * $params['limit'])- $params['limit']; 
		$this->data['tableGrid'] 	= $this->info['config']['grid'];
		$this->data['tableForm'] 	= $this->info['config']['forms'];
		$this->data['colspan'] 		= \SiteHelpers::viewColSpan($this->info['config']['grid']);		
		$this->data['access']		= $this->access;
		$this->data['subgrid']	= (isset($this->info['config']['subgrid']) ? $this->info['config']['subgrid'] : array());
		$this->data['tableview']= 'orders.table_view';
		return view('orderdetails.index',$this->data)->with('model',new Orderdetails);
	}	

	function create( Request $request , $id =0 ) 
	{
		$this->hook( $request  );
		if($this->access['is_add'] ==0 || \Auth::user()->p_active != '1' && \Auth::user()->group_id != 1 && \Auth::user()->group_id != 2)  
			return redirect('dashboard')->with('message', __('core.note_restric'))->with('status','error');

		$this->data['row'] = $this->model->getColumnTable( $this->info['table']); 
		
		$this->data['id'] = '';
		return view($this->module.'.form',$this->data);
	}

	function edit( Request $request , $id ) 
	{
		$this->hook( $request , $id );
		if(!isset($this->data['row']))
			return redirect($this->module)->with('message','Record Not Found !')->with('status','error');
		if($this->access['is_edit'] ==0 || \Auth::user()->p_active != '1' && \Auth::user()->group_id != 1 && \Auth::user()->group_id != 2)
			return redirect('dashboard')->with('message',__('core.note_restric'))->with('status','error');
		$this->data['row'] = (array) $this->data['row'];
		
		$this->data['id'] = $id;
		return view($this->module.'.form',$this->data);
	}

	function show( Request $request , $id ) 
	{
		/* Handle import , export and view */
		$task =$id ;
		switch( $task)
		{
			case 'search':
			return $this->getSearch();
			break;
			case 'lookup':
			return $this->getLookup($request );
			break;
			case 'comboselect':
			return $this->getComboselect( $request );
			break;
			case 'import':
			return $this->getImport( $request );
			break;
			case 'export':
			return $this->getExport( $request );
			break;
			default:
			$this->hook( $request , $id );
			if(!isset($this->data['row']))
				return redirect($this->module)->with('message','Record Not Found !')->with('status','error');

			if($this->access['is_detail'] ==0 || \Auth::user()->p_active != '1' && \Auth::user()->group_id != 1 && \Auth::user()->group_id != 2) 
				return redirect('dashboard')->with('message', __('core.note_restric'))->with('status','error');

			return view($this->module.'.view',$this->data);	
			break;		
		}
	}

	function store( Request $request)
	{
		$id=$request->input('id');
		$rules = $this->validateForm();
		$validator = Validator::make($request->all(), $rules);	
		if ($validator->passes()) {
			if($request->input('id')!=''){
				$checkOrder=\DB::table('abserve_order_details')->where('id',$request->input('id'))->first();
				// $checkPartnerOrder=\DB::table('abserve_orders_partner')->where('orderid',$request->input('id'))->first();
				if($checkOrder){
						// if($checkOrder->delivery!=$request->input('delivery') && !empty($request->input('delivery'))){
						// 	\DB::table('abserve_order_details')->where('id',$request->input('id'))->update(array('delivery'=>$request->input('delivery')));
						// }

					if($checkOrder->status!=$request->input('status')){
						if($request->input('status')=='2'){
							\DB::table('abserve_order_details')->where('id',$request->input('id'))->update(array('status'=>$request->input('status')));

							\DB::table('abserve_orders_partner')->where('orderid','=',$request->input('id'))->update(['order_status'=>$request->input('status')]);

						}else if($request->input('status')=='3'){
							\DB::table('abserve_order_details')->where('id',$request->input('id'))->update(array('status'=>$request->input('status'),'dispatched_time'=>time()));

							\DB::table('abserve_orders_partner')->where('orderid','=',$request->input('id'))->update(['order_status'=>$request->input('status')]);

						}else if($request->input('status')=='4'){
							\DB::table('abserve_order_details')->where('id',$request->input('id'))->update(array('status'=>$request->input('status'),'completed_time'=>time()));

							\DB::table('abserve_orders_partner')->where('orderid','=',$request->input('id'))->update(['order_status'=>$request->input('status')]);

						}else if($request->input('status')=='5'){
							\DB::table('abserve_order_details')->where('id',$request->input('id'))->update(array('status'=>$request->input('status')));

							\DB::table('abserve_orders_partner')->where('orderid','=',$request->input('id'))->update(['order_status'=>$request->input('status')]);

						}else if($request->input('status')=='6'){
							\DB::table('abserve_order_details')->where('id',$request->input('id'))->update(array('status'=>$request->input('status')));

							\DB::table('abserve_orders_partner')->where('orderid','=',$request->input('id'))->update(['order_status'=>$request->input('status')]);

						}

						// if($checkPartnerOrder){
							if($request->input('boy_id')!=''){
								if($request->input('status')=='2'){
									// \DB::table('abserve_orders_partner')->where('orderid','=',$request->input('id'))->update(['boy_id'=>$request->input('boy_id'),'order_accepted_time'=>time()]);

									\DB::table('delivery_boy_new_orders')->insert(['boy_id'=>$request->input('boy_id'),'order_id'=>$request->input('id'),'status'=>'Accepted','update_at'=>$time]);	

									// \DB::table('abserve_orders_boy')->insertGetId(['boy_id'=>$request->input('boy_id'),'orderid'=>$request->input('id'),'partner_id'=>$checkPartnerOrder->partner_id,'order_value'=>$checkPartnerOrder->order_value,'order_details'=>$checkPartnerOrder->order_details,'order_status'=>1,'current_order'=>1]);
								}
							}
						}
				}
				// $arr['delivery'] = $request->input('delivery');	
				if ($request->input('boy_id') != 0) {
					$arr['boy_id'] = $request->input('boy_id');
					$arr['status'] = '2';	
					$ordercheck = \DB::table('abserve_order_details')->where('id', $request->id)->pluck('boy_id');
					$oldboyid = $ordercheck[0];
					if($request->input('boy_id')!=$oldboyid && $oldboyid != ''){
						\DB::table('abserve_order_details')->where('id', $request->id)->update(['boy_id'=>'']);
						$check = \DB::table('abserve_order_details')->where('boy_id',$oldboyid)->where('status','!=' ,'4')->where('status','!=','5')->where('date','>=',date('Y-m-d'))->get();
						if(count($check) > 0){
							\DB::table('tb_users')->where('id','=',$oldboyid)->update(['boy_status'=>'1']);
						} else {
							\DB::table('tb_users')->where('id','=',$oldboyid)->update(['boy_status'=>'0']);
						}
					}
					\DB::table('delivery_boy_new_orders')->where('order_id','=',$request->input('id'))->update(['status'=>'NotRespond']);
					$insBoy['order_id'] = $request->input('id');
					$insBoy['boy_id'] = $request->input('boy_id');
					$insBoy['status'] = 'Accepted';
					\DB::table('delivery_boy_new_orders')->insert($insBoy);	
					\DB::table('tb_users')->where('id','=',$request->input('boy_id'))->update(['boy_status'=>'1']);

					$boyOrder['boy_id']			= $request->input('boy_id');
					$boyOrder['orderid']		= $checkOrder->id;
					$boyOrder['partner_id']		= $checkOrder->partner_id;
					$boyOrder['order_value']	= $checkOrder->order_value;
					$boyOrder['order_details']	= $checkOrder->order_details;
					$boyOrder['order_status']	= '1';
					$boyOrder['current_order']	= '1';

					$boyOrderId	= \DB::table('abserve_orders_boy')->insertGetId($boyOrder);


					// Notify Start
					$aOrder = OrderDetail::find($request->input('id'));
					
					$message    = "The order (#".$aOrder->id.") was accepted by a delivery boy";
					// $this->sendpushnotification($aOrder->partner_id,'user',$message);
					// $message    = "Your order on the restaurant ".$aOrder->restaurant_info->name." was accepted by the Delivery Boy ".$order->boy_info->username;
					// $this->sendpushnotification($aOrder->cust_id,'user',$message);
						//notify customer and partner through socket
					if(SOCKET_ACTION == 'true'){
						require_once SOCKET_PATH;
						$aData = array(
							'partner_id' => $aOrder->partner_id,
							'customer_id' => $aOrder->cust_id,
							'order_id' => $aOrder->id,
							'Molorder_id' => '',
							'boy_id' => $request->input('boy_id'),
							'amount' => $aOrder->grand_total,
							'partner_name' => $aOrder->partner_info->username
						);
						$client->emit('boy accepted', $aData);
						$client->emit('boy accepted order', $aData);
					}
					// Notify End


				}
				OrderDetail::where('id',$request->input('id'))->update($arr);
				$edit_food=$request->edit_food;
				if($edit_food=='yes'){
					$getCartAID=$request->getCartAID;
					$getCartFID=$request->getCartFID;
					$getCartATY=$request->getCartATY;
					$getCartQTY=$request->getCartQTY;
					$getCartATYPE=$request->getCartATYPE;
					if(count($getCartFID)>0){

						$old_food=\DB::table('abserve_order_items')->where('orderid',$request->id)->get();
						if(count($old_food)>0){
							foreach ($old_food as $Okey => $Ovalue) {
								$data=array(
									'orderid'=>$Ovalue->orderid,
									'food_id'=>$Ovalue->food_id,
									'food_item'=>$Ovalue->food_item,
									'adon_id'=>$Ovalue->adon_id,
									'adon_type'=>$Ovalue->adon_type,
									'adon_detail'=>$Ovalue->adon_detail,
									'quantity'=>$Ovalue->quantity,
									'vendor_price'=>$Ovalue->vendor_price,
									'price'=>$Ovalue->price
								);
								\DB::table('abserve_order_items_copy')->insert($data);
							}
						}


						$totalPrice=0;$totalVprice=0;
						foreach ($getCartFID as $key => $value) {
							$hotel_items=\DB::table('abserve_hotel_items')->where('id',$value)->first();

							$adon_details='';
							if($getCartAID[$key]=='' || $getCartAID[$key]==0){
								$price=($hotel_items->selling_price>0) ? $hotel_items->selling_price : $hotel_items->price;

								$vprice=$hotel_items->price;
							}else{
								if($getCartATYPE[$key]=='unit'){
									$hotel_items1=\DB::table('tb_food_unit')->where('food_id',$value)->where('id',$getCartAID[$key])->first();
									$adon_details=$hotel_items1->unit.":".$hotel_items1->unit_type;
								}else{
									$hotel_items1=\DB::table('tb_food_variation')->where('food_id',$value)->where('id',$getCartAID[$key])->first();
									$adon_details=$hotel_items1->color.":".$hotel_items1->unit;
								}

								$price=($hotel_items1->selling_price>0) ? $hotel_items1->selling_price : $hotel_items1->price;
								$vprice=$hotel_items1->price;
							}

							if($getCartAID[$key]==''  || $getCartAID[$key]==0){
								$order_items=\DB::table('abserve_order_items')->where('orderid',$request->id)->where('food_id',$value)->first();
							}else{
								$order_items=\DB::table('abserve_order_items')->where('orderid',$request->id)->where('food_id',$value)->where('adon_id',$getCartAID[$key])->where('adon_type',$getCartATYPE[$key])->first();
							}
							if($order_items){
								$data=array('quantity'=>$getCartQTY[$key],'price'=>$price,'vendor_price'=>$vprice);
								if($getCartAID[$key]==''  || $getCartAID[$key]==0){
									\DB::table('abserve_order_items')->where('orderid',$request->id)->where('food_id',$value)->update($data);
								}else{
									\DB::table('abserve_order_items')->where('orderid',$request->id)->where('adon_id',$getCartAID[$key])->where('adon_type',$getCartATYPE[$key])->where('food_id',$value)->update($data);
								}
							}else{
								
								$data=array(
									'orderid'=>$request->id,
									'food_id'=>$value,
									'food_item'=>$hotel_items->food_item,
									'adon_type'=>$getCartATYPE[$key],
									'adon_id'=>$getCartAID[$key],
									'adon_detail'=>$adon_details,
									'quantity'=>$getCartQTY[$key],
									'vendor_price'=>$vprice,
									'price'=>$price
								);
								\DB::table('abserve_order_items')->insert($data);
							}
							$totalPrice+=($getCartQTY[$key]*$price);
							$totalVprice+=($getCartQTY[$key]*$vprice);

								// echo $hotel_items->price."*".$getCartQTY[$key];
						}
					}
					echo "Amount - ".$totalPrice;

					$order_details=\DB::table('abserve_order_details')->where('id',$request->id)->first();
					if($order_details){

						if($order_details->comsn_percentage>0){
							$admin_camount=$totalPrice*($order_details->comsn_percentage/100);
						}else{
							$admin_camount=0;
						}

						if($order_details->offer_percentage>0){
							$offer_price=$totalPrice*($order_details->offer_percentage/100);
						}else{
							$offer_price=0;
						}
						$host_amount=$totalVprice-$admin_camount;
							// $host_withcommission=$totalVprice-$admin_camount;




						$couponInfo = \DB::table('abserve_promocode')->select('*')->where('id',$order_details->coupon_id)->first();
						if($order_details->coupon_type == 'amount'){
							if(($totalPrice > $couponInfo->min_order_value) && ($totalPrice > ($offer_price + $couponInfo->promo_amount))){

								if($couponInfo->promo_amount<$couponInfo->max_discount){
									$coupon_price 	= number_format($couponInfo->promo_amount,2,'.','');
								}else{
									$coupon_price = number_format($couponInfo->max_discount,2,'.','');
								}
							}
						} else if($order_details->coupon_type == 'percentage') {
							if(($totalPrice > $couponInfo->min_order_value) && ($totalPrice > ($offer_price + (($couponInfo->promo_amount / 100) * $totalPrice)))) {
								$coupon_price1 	= number_format(($couponInfo->promo_amount / 100) * $totalPrice,2,'.','');
								if($coupon_price1<$couponInfo->max_discount){
									$coupon_price 	= $coupon_price1;
								}else{
									$coupon_price = number_format($couponInfo->max_discount,2,'.','');
								}

							}
						}
						$grand_total=($totalPrice+$order_details->del_charge)-($offer_price+$coupon_price);
						$dataOrder=array(
							'total_price'=>$totalPrice,
							'host_amount'=>$host_amount,
							'host_withcommission'=>$totalVprice,
							'admin_camount'=>$admin_camount,
							'offer_price'=>$offer_price,
							'coupon_price'=>$coupon_price,
							'grand_total'=>$grand_total
						);

						\DB::table('abserve_order_details')->where('id',$request->id)->update($dataOrder);
						$order_details = OrderDetail::where('id',$request->id)->first();
						$message    = "Your order (#".$order_details->id.") menu items has been changed as per your request.";
						if($order_details->delivery_type == 'razorpay')
						{
							if($order_details->grand_total > $order_details->paid_amount)
							{
								$amount = $order_details->grand_total - $order_details->paid_amount;
								$api_key = RAZORPAY_API_KEYID;
								$api_secret = RAZORPAY_API_KEY_SECRET;
								$api = new Api($api_key, $api_secret);
								$rorderidcreation  = $api->order->create([
									'receipt'         => 'receipt_'.$order_details->id,
									'amount'          => round($amount*100),
									'currency'        => 'INR',
									'payment_capture' =>  1
								]);
								$order_details->orderid = $rorderidcreation->id;
								$order_details->save();
								$message    = "Your order (#".$order_details->id.") menu items has been changed as per your request. Amount of Rs.".$amount." remaining must be paid. Thanks for using Fooza.";
							}
						}

						$this->sendpushnotification($order_details->cust_id,'user',$message);
					}
				}
				$v = \DB::table('abserve_order_details')->where('id',$request->id)->get();
			}
				// $id = $this->model->insertRow($data , $request->input('id'));
			if(!is_null($request->input('apply')))
			{
				$return = 'paymentorders/'.$id.'/edit?return='.self::returnUrl();
			} else {
				$return = 'paymentorders?return='.self::returnUrl();
			}

			// Insert logs into database
			if($request->input('id') =='')
			{
				\SiteHelpers::auditTrail( $request , 'New Data with ID '.$id.' Has been Inserted !');
			} else {
				\SiteHelpers::auditTrail($request ,'Data with ID '.$id.' Has been Updated !');
			}
			return Redirect::to($return)->with('messagetext',\Lang::get('core.note_success'))->with('msgstatus','success');
		} else {
			return Redirect::to('paymentorders/'.$id.'/edit')->with('messagetext',\Lang::get('core.note_error'))->with('msgstatus','error')
			->withErrors($validator)->withInput();
		}
	}	

	public function destroy( $request)
	{
		// Make Sure users Logged 
		if(!\Auth::check()) 
			return redirect('user/login')->with('status', 'error')->with('message','You are not login');

		$this->access = $this->model->validAccess($this->info['id'] , session('gid'));
		if($this->access['is_remove'] ==0 || \Auth::user()->p_active != '1' && \Auth::user()->group_id != 1 && \Auth::user()->group_id != 2) 
			return redirect('dashboard')
		->with('message', __('core.note_restric'))->with('status','error');
		// delete multipe rows 
		if(is_array($request->input('ids')))
		{
			$this->model->destroy($request->input('ids'));
			
			\SiteHelpers::auditTrail( $request , "ID : ".implode(",",$request->input('ids'))."  , Has Been Removed Successfull");
			// redirect
			return ['message'=>__('core.note_success_delete'),'status'=>'success'];	

		} else {
			return ['message'=>__('No Item Deleted'),'status'=>'error'];				
		}
	}	
	
	public static function display(  )
	{
		$mode  = isset($_GET['view']) ? 'view' : 'default' ;
		$model  = new Orderdetails();
		$info = $model::makeInfo('orderdetails');
		$data = array(
			'pageTitle'	=> 	$info['title'],
			'pageNote'	=>  $info['note']			
		);	
		if($mode == 'view')
		{
			$id = $_GET['view'];
			$row = $model::getRow($id);
			if($row)
			{
				$data['row'] =  $row;
				$data['fields'] 		=  \SiteHelpers::fieldLang($info['config']['grid']);
				$data['id'] = $id;
				return view('orderdetails.public.view',$data);			
			}			
		} 
		else {

			$page = isset($_GET['page']) ? $_GET['page'] : 1;
			$params = array(
				'page'		=> $page ,
				'limit'		=>  (isset($_GET['rows']) ? filter_var($_GET['rows'],FILTER_VALIDATE_INT) : 10 ) ,
				'sort'		=> $info['key'] ,
				'order'		=> 'asc',
				'params'	=> '',
				'global'	=> 1 
			);

			$result = $model::getRows( $params );
			$data['tableGrid'] 	= $info['config']['grid'];
			$data['rowData'] 	= $result['rows'];	

			$page = $page >= 1 && filter_var($page, FILTER_VALIDATE_INT) !== false ? $page : 1;	
			$pagination = new Paginator($result['rows'], $result['total'], $params['limit']);	
			$pagination->setPath('');
			$data['i']			= ($page * $params['limit'])- $params['limit']; 
			$data['pagination'] = $pagination;
			return view('orderdetails.public.index',$data);	
		}
	}

	function store_public( $request)
	{
		
		$rules = $this->validateForm();
		$validator = Validator::make($request->all(), $rules);	
		if ($validator->passes()) {
			$data = $this->validatePost(  $request );		
			$this->model->insertRow($data , $request->input('id'));
			return  Redirect::back()->with('message',__('core.note_success'))->with('status','success');
		} else {

			return  Redirect::back()->with('message',__('core.note_error'))->with('status','error')
			->withErrors($validator)->withInput();

		}	
	}

	public function orderexport(Request $request,$slug) 
	{
		$request->all();
		$exporter = app()->makeWith(OrderdetailsExport::class, compact('request'));  
		return $exporter->download('OrderdetailsExport_'.date('Y-m-d').'.'.$slug);
	}

	function postOrders( Request $request)
	{
		$user_type = 'user';
		$order_details = OrderDetail::where('id',$request->order_id)->first();
		$request->request->add(['user_id'=>\Auth::id(),'group_id'=>\Auth::user()->group_id,'appcall'=>'orderedit','user_type'=>$user_type,'order_id'=>$request->order_id,'status'=>$request->status,'partner_id'=>$order_details->partner_id]);
		$orderStatus	= json_decode(\App::call('App\Http\Controllers\Api\OrderController@orderStatusChange'));
		$response['id']		= $orderStatus->id;
		$response['status']	= ($orderStatus->status == 'success') ? 'success' : 'error' ;
		$response['message']= $orderStatus->message;
		\Session::put('messagetext',$orderStatus->message);
		\Session::put('msgstatus',$response['status']);
		return \Response::json($response);
	}

}

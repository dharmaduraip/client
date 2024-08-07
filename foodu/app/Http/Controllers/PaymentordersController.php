<?php namespace App\Http\Controllers;

use App\Models\Paymentorders;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use Validator, Input, Redirect ; 
use App\Models\Wallet;
use App\User;
use App\Models\Orderdetails;
use App\Models\Front\Deliveryboy;
use App\Http\Controllers\mobile\UserController as usercon;

class PaymentordersController extends Controller {

	protected $layout = "layouts.main";
	protected $data = array();	
	public $module = 'paymentorders';
	static $per_page	= '10';

	public function __construct()
	{		
		parent::__construct();
		$this->model = new Paymentorders();	
		
		$this->info = $this->model->makeInfo( $this->module);	
		$this->data = array(
			'pageTitle'	=> 	$this->info['title'],
			'pageNote'	=>  $this->info['note'],
			'pageModule'=> 'paymentorders',
			'return'	=> self::returnUrl()
			
		);
		
	}

	public function index( Request $request )
	{
		$this->hook( $request  );
		if($this->access['is_view'] ==0 || \Auth::user()->p_active != '1' && \Auth::user()->group_id != 1 && \Auth::user()->group_id != 2) 
			return Redirect::to('dashboard')
				->with('messagetext', \Lang::get('core.note_restric'))->with('msgstatus','error');

		$sort = (!is_null($request->input('sort')) ? $request->input('sort') : 'id'); 
		$order = (!is_null($request->input('order')) ? $request->input('order') : 'desc');
		$filter = (!is_null($request->input('search')) ? $this->buildSearch() : '');
		// $filter_mk = explode('AND', $filter);
		// $filter = '';
		// foreach ($filter_mk as $key => $value) {
		// 	$trim = trim($value);
		// 	if($trim != ''){
		// 		if(strpos( $trim, 'abserve_order_details.cust_id' ) !== false) {
		// 			$trim = str_replace('abserve_order_details.cust_id', 'tb_users.username', $trim);
		// 		}elseif(strpos( $trim, 'abserve_order_details.res_id' ) !== false) {
		// 			$trim = str_replace('abserve_order_details.res_id', 'abserve_restaurants.name', $trim);
		// 		}
		// 		$filter .= " AND ".$trim;
		// 	}			
		// }

		$page = $request->input('page', 1);
		$params = array(
			'page'		=> $page ,
			'limit'		=> (!is_null($request->input('rows')) ? filter_var($request->input('rows'),FILTER_VALIDATE_INT) : static::$per_page ) ,
			'sort'		=> $sort ,
			'order'		=> $order,
			'params'	=> $filter,
			'global'	=> (isset($this->access['is_global']) ? $this->access['is_global'] : 0 )
		);
		$results = $this->model->getRows( $params ,\Auth::user()->id);

		$page = $page >= 1 && filter_var($page, FILTER_VALIDATE_INT) !== false ? $page : 1;	
		$pagination = new Paginator($results['rows'], $results['total'], $params['limit']);	
		$pagination->setPath('paymentorders');
		$this->data['rowData']		= $results['rows'];
		$this->data['pagination']	= $pagination;
		$this->data['pager'] 		= $this->injectPaginate();
		$this->data['i']			= ($page * $params['limit'])- $params['limit'];
		$this->data['tableGrid'] 	= $this->info['config']['grid'];
		$this->data['tableForm'] 	= $this->info['config']['forms'];
		$this->data['colspan'] 		= \SiteHelpers::viewColSpan($this->info['config']['grid']);
		$this->data['access']		= $this->access;
		$this->data['subgrid']	= (isset($this->info['config']['subgrid']) ? $this->info['config']['subgrid'] : array());
		$this->data['tb_users']=\DB::table('tb_users')->where('group_id','=',4)->get();
		$this->data['cancel_categories'] = $this->model->getCancelCategories();
		return view('paymentorders.index',$this->data);
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
			if($id =='')
		{
			if($this->access['is_add'] ==0 || \Auth::user()->p_active != '1' && \Auth::user()->group_id != 1 && \Auth::user()->group_id != 2)
			return Redirect::to('dashboard')->with('messagetext',\Lang::get('core.note_restric'))->with('msgstatus','error');
		}				
				
		$row = $this->model->find($id);
		if($row)
		{
			// $this->data['row'] =  $row;
		} else {
			// $this->data['row'] = $this->model->getColumnTable('abserve_order_details'); 
		}
		$this->data['fields'] 		=  \SiteHelpers::fieldLang($this->info['config']['forms']);
		$this->data['id']	= $id;
		$this->data['row']	= $orderdetail	= Orderdetails::with('restaurant')->find($id);

		$accepted_boy = \DB::table('delivery_boy_new_orders')->where('order_id',$id)->where('status','Accepted')->orderBy('id','desc')->first();
		$selectedBoyId = '';$boyText = '';
		if(!empty($accepted_boy) && $accepted_boy->boy_id > 0){
			$selectedBoyId = $accepted_boy->boy_id;
			$boyText = 'Accepted';
		} else {
			$pending_boy = \DB::table('delivery_boy_new_orders')->where('order_id',$id)->where('status','Pending')->orderBy('id','desc')->first();
			if(!empty($accepted_boy) && $accepted_boy->boy_id > 0){
				$selectedBoyId = $pending_boy->boy_id;
				$boyText = 'Assigned to boy';
			}
		}
		$this->data['selectedBoyId'] = $selectedBoyId;
		$this->data['boyText'] = $boyText;
		// $this->data['deliveryBoy']=\DB::table('abserve_deliveryboys')->select('id','username','boy_status')->where('active','1')->where('online_sts','1')->get();

		$this->data['deliveryBoy']	= Deliveryboy::select('id','username','boy_status')->nearby($orderdetail->restaurant->latitude,$orderdetail->restaurant->longitude)->where('d_active','1')->where('mode','online')->where('boy_status', '0')->get();

		$this->data['id'] = $id;
		if ($this->data['row']->status != 1 && $this->data['row']->status != 6 && $this->data['row']->status != '2' && $this->data['row']->status != 'Packing')
			return Redirect::to('paymentorders')->with('messagetext','Boy has assigned to this order already!')->with('msgstatus','error');	
		else
			return view('paymentorders.form',$this->data);
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
	function store( Request $request  )
	{
		$task = $request->input('action_task');
		switch ($task)
		{
			default:
				$rules = $this->validateForm();
				$validator = Validator::make($request->all(), $rules);
				if ($validator->passes()) 
				{
					$data = $this->validatePost( $request );
					$id = $this->model->insertRow($data , $request->input( $this->info['key']));
					
					/* Insert logs */
					$this->model->logs($request , $id);
					if($request->has('apply'))
						return redirect( $this->module .'/'.$id.'/edit?'. $this->returnUrl() )->with('message',__('core.note_success'))->with('status','success');

					return redirect( $this->module .'?'. $this->returnUrl() )->with('message',__('core.note_success'))->with('status','success');
				} 
				else {
					if( $request->input(  $this->info['key'] ) =='') {
						$url = $this->module.'/create?'. $this->returnUrl();
					} else {
						$url = $this->module .'/'.$id.'/edit?'. $this->returnUrl();
					}
					return redirect( $url )
							->with('message',__('core.note_error'))->with('status','error')
							->withErrors($validator)->withInput();
								

				}
				break;
			case 'public':
				return $this->store_public( $request );
				break;

			case 'delete':
				$result = $this->destroy( $request );
				return redirect($this->module.'?'.$this->returnUrl())->with($result);
				break;

			case 'import':
				return $this->PostImport( $request );
				break;

			case 'copy':
				$result = $this->copy( $request );
				return redirect($this->module.'?'.$this->returnUrl())->with($result);
				break;		
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
		$model  = new Paymentorders();
		$info = $model::makeInfo('paymentorders');
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
				return view('paymentorders.public.view',$data);			
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
			return view('paymentorders.public.index',$data);	
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
	function cancellation_order(Request $request){
		$oid 	= trim($request->oid);
		$cancel_reason 		= trim($request->reason);
		$cancel_category_id = trim($request->cancel_category_id);
		//Get order details 
		$wallet_details = Wallet::where('order_id',$oid)->where('type','credit')->first();
		$order_details = $this->model->getOrderDetails($oid);
		if (!empty($wallet_details)) {
			if ($order_details->status == 1 || $order_details->status == 2 || $order_details->status == 6) {
				$user_wallet 	= User::find($wallet_details->user_id);
				$update_amt  	= $user_wallet->customer_wallet - $wallet_details->amount;
				$user 	= $user_wallet->update(array('customer_wallet'=>$update_amt));
				$data 	=array(
					'user_id'  	  => $wallet_details->user_id,
					'order_id' 	  => $oid,
					'amount'	  => $wallet_details->amount,
					'reason'	  => "Reject your order",
					'type'		  => "debit",
					'balance'	  => $user_wallet->customer_wallet,
					'added_by'	  => 1,
					'order_status'=> $order_details->status,
					);
				$wallet_details = $wallet_details->insert($data);
			}
		}
		$total_amount 	= $order_details->accept_grand_total - $order_details->cash_offer;
		$boy_del_charge = $order_details->boy_del_charge;

		//Get cancel category details
		$cancel_details				= $this->model->getCancelCategoryDetails($cancel_category_id);
		$chef_receives_percent	 	= $cancel_details->chef_receives;
		$customer_refund_percent 	= $cancel_details->customer_refund;
		$delivery_earning_percent 	= $cancel_details->delivery_earning;

		//Chef Earning:
		$chef_earnings 	= ($chef_receives_percent/100)*$total_amount;	

		//Customer Refund:
		$customer_refund 	= ($customer_refund_percent/100)*$total_amount;	

		//Delivery Earning:
		$delivery_earning 	= ($delivery_earning_percent/100)*$boy_del_charge;

		$cancel = $this->model->cancelOrder($oid,$chef_earnings,$customer_refund,$delivery_earning,$cancel_reason,$cancel_details->category_name);

		echo $cancel;
		
	}

}

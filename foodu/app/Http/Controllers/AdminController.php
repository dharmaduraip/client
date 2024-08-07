<?php namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Sximo\Menu;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use Validator, Input, Redirect ; 
use App\Models\OrderDetail;
use App\Models\OrderItems;
use App\Models\Partnerwallet;
use App\Models\DeliveryBoyWallet;


class AdminController extends Controller {

	protected $layout = "layouts.main";
	protected $data = array();	
	public $module = 'admin';
	static $per_page	= '10';

	public function __construct()
	{
		parent::__construct();
		$this->model = new Admin();	
		
		$this->info = $this->model->makeInfo( $this->module);	
		$this->data = array(
			'pageTitle'	=> 	$this->info['title'],
			'pageNote'	=>  $this->info['note'],
			'pageModule'=> 'admin',
			'return'	=> self::returnUrl()
			
			);
			$this->serviceException = ['offerwallet','wallet'];
	}

	public function index( Request $request )
	{
		// Make Sure users Logged 
		if(!\Auth::check()) 
			return redirect('user/login')->with('status', 'error')->with('message','You are not login');
		$this->grab( $request) ;
		if($this->access['is_view'] ==0) 
			return redirect('dashboard')->with('message', __('core.note_restric'))->with('status','error');				
		// Render into template
		return view( $this->module.'.index',$this->data);
	}

	function create( Request $request , $id =0 ) 
	{
		$this->hook( $request ,$id  );
		if($this->access['is_add'] ==0) 
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
		if($this->access['is_edit'] ==0 )
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

			if($this->access['is_detail'] ==0) 
				return redirect('dashboard')->with('message', __('core.note_restric'))->with('status','error');

			return view($this->module.'.view',$this->data);	
			break;		
		}
	}

	function store( Request $request  )
	{
		$id = $request->id;
		$task = $request->input('action_task');
		switch ($task)
		{
			default:
			$rules = $this->validateForm();
			$rules['phone_number'] = 'required|numeric|digits:10|not_in:0';
			$validator = Validator::make($request->all(), $rules);
			if ($validator->passes()) 
			{
				$data = $this->validatePost( $request );
				$data['group_id'] = 2;
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
				/*return redirect( $url )
				->with('message',__('core.note_error'))->with('status','error')
				->withErrors($validator)->withInput();*/
                return back()->with('message',__('core.note_error'))->with('status','error')->withErrors($validator)->withInput();

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
		if($this->access['is_remove'] ==0) 
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
		$model  = new Admin();
		$info = $model::makeInfo('admin');
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
				return view('admin.public.view',$data);			
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
			return view('admin.public.index',$data);	
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

	public function getService(Request $request,$admin = '')
	{
		if ($admin != '') {
			$adminDeatails = Admin::where('group_id','2')->where('id',$admin)->first();
			if (!empty($adminDeatails)) {
				$menu = \SiteHelpers::menus( 'sidebar' ,'all');
				$data['menus'] = $menu;
				$data['user_id'] = $admin;
				$data['serviceException'] = $this->serviceException;

				$userDetails = User::find($admin);
				$data['service'] = json_decode($userDetails->services);
				return view('admin.service',$data);
			} else {
				return Redirect::back()->with('message','Please Try Again....');
			}		
		} else {
			return Redirect::back()->with('message','Please Try Again....');
		}
	}

	public function postGiveservice(Request $request)
	{
		if (\Auth::check() && \Auth::user()->group_id == 1) {
			$rules = array();
			$rules['user_id'] = 'required|exists:tb_users,id';
			$validator = Validator::make($request->all(), $rules);	
			if ($validator->passes()) {

				$userId = $request->user_id;
				$decodeArray = array();
				if (isset($request->services) && !empty($request->services)) {
					$decodeArray = array_map(function($encodedValue) {
						return base64_decode($encodedValue);
					}, $request->services);
					$decodeArray = array_filter($decodeArray);
				}
				$fine = true;
				$decodeValue = json_encode($decodeArray);
				$updateUser = User::find($userId);
				if (!empty($decodeArray)) {
					foreach ($decodeArray as $key => $value) {
						$menuInfo = Menu::find($value);
						if (!empty($menuInfo)) {
							$checkAccess = json_decode($menuInfo->access_data);
							if ($checkAccess->{$updateUser->group_id} != '1' && $checkAccess->{$updateUser->group_id} != '1') {
								$fine = false;
								$reason = 'This group has no permission to access the menu "'.$menuInfo->menu_name.'".Contact Developers.';
								break;
							}elseif ($menuInfo->active != '1' && !in_array($menuInfo->module, $this->serviceException)) {
								$fine = false;
								$reason = 'This menu is not active "'.$menuInfo->menu_name.'". Contact Developers.';
								break;
							}
						}
					}
				}
				if (!empty($updateUser) && $fine) {
					$updateUser->services = $decodeValue;
					$updateUser->update();
					return Redirect::back()->with('messagetext',\Lang::get('core.note_success'))->with('msgstatus','success');
				}else{
					// echo $reason;
					// exit;
					return Redirect::back()->with('messagetext',$reason)->with('msgstatus','error');
				}
			}else{
				return Redirect::back('admin/service/'.$id)->with('messagetext',\Lang::get('core.note_error'))->with('msgstatus','error')
				->withErrors($validator)->withInput();
			}

		}else{
			return Redirect::back()->with('message','Please Try Again....');
		}
	}

	public function getSetmenu()
	{
		$Menu = Menu::get();
		foreach ($Menu as $key => $value) {
			$access = json_decode($value->access_data);
			if($access->{1} == 1){
				$access->{2} = "1";
			}else{
				$access->{2} = "0";
			}
			$access = json_encode($access);
			$m = Menu::find($value->menu_id);
			$m->access_data = $access;
			$m->save();
		}
	}

	public function admincommission(Request $request)
	{
		$this->data['pager'] = 10;
		$details = OrderDetail::with('restaurant', 'user_info', 'boy_info', 'partner_info')->select('id', 'host_amount', 'del_charge', 'grand_total', 'res_id', 'partner_id', 'cust_id', 'boy_id', 'admin_camount', 'gst', 'coupon_price', 'offer_price', 'coupon_id', 'boy_del_charge', 'delivery_type', 'fixedCommission', 'total_price', 'accept_host_amount', 'date', 'accept_grand_total')->where('status', '4')->where('customer_status', 'Delivered')->paginate($this->data['pager']);
		$this->data['pagination'] = $details;
		$this->data['admincommission'] = $details->sum('fixedCommission');
		$this->data['host_amount'] = $details->sum('host_amount');
		$this->data['delivery_charge'] = $details->sum('del_charge');
		$this->data['total_amount'] = $this->data['admincommission'] + $this->data['delivery_charge'];
		return view( $this->module.'.admincommission',$this->data);
	}
}

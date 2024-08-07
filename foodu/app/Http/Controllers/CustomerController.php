<?php namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use Validator, Input, Redirect ; 
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\CustomerExport;
 

class CustomerController extends Controller {

	protected $layout = "layouts.main";
	protected $data = array();	
	public $module = 'customer';
	static $per_page	= '10';

	public function __construct()
	{
		set_time_limit(300);
        ini_set('memory_limit', '-1');
		parent::__construct();
		$this->model = new Customer();
		$this->info = $this->model->makeInfo( $this->module);
		$this->data = array(
			'pageTitle'	=> 	$this->info['title'],
			'pageNote'	=>  $this->info['note'],
			'pageModule'=> 'customer',
			'return'	=> self::returnUrl()
			
		);	
	}

	public function index( Request $request )
	{
		// Make Sure users Logged 
		if(!\Auth::check()) 
			return redirect('user/login')->with('status', 'error')->with('message','You are not login');
		$request['order'] = (!is_null($request->input('order')) ? $request->input('order') : 'desc');
		$this->grab( $request) ;
		if($this->access['is_view'] ==0) 
			return redirect('dashboard')->with('message', __('core.note_restric'))->with('status','error');
		$this->data['r'] = $this->data['i'];
		// Render into template
		return view( $this->module.'.index',$this->data);
	}	

	function create( Request $request , $id =0 ) 
	{
		$this->hook( $request  );
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
		$this->data['user_address'] = \DB::table('abserve_user_address')->where(['user_id' => $id,'hide' => 0])->get();
			// echo "<pre>"; print_r($this->data);exit();	
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
				$rules['email'] 	   = 'required|email';
				$validator = Validator::make($request->all(), $rules);
				if ($validator->passes()) 
				{
					$data = $this->validatePost( $request );
					$data['group_id'] = '4';
					$id = $this->model->insertRow($data , $request->input( $this->info['key'] ));
					
					/* Insert logs */
					$this->model->logs($request , $id);
					if($request->has('apply'))
						return redirect( $this->module .'/'.$id.'/edit?'.time(). $this->returnUrl() )->with('message',__('core.note_success'))->with('status','success');

					return redirect( $this->module .'?'.time(). $this->returnUrl() )->with('message',__('core.note_success'))->with('status','success');
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
		$model  = new Customer();
		$info = $model::makeInfo('customer');
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
				return view('customer.public.view',$data);			
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
			return view('customer.public.index',$data);	
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

	public function customerexport(Request $request,$slug) 
	{
		$request->all();
		$exporter = app()->makeWith(CustomerExport::class, compact('request'));  
		return $exporter->download('CustomerExport_'.date('Y-m-d').'.'.$slug);
	}

	public function getDeletecustomer(Request $request)
	{
		$explodeid = explode(',', rtrim($request->getid,','));
		foreach ($explodeid as $key => $value) {
			$changestate = \DB::table('tb_users')->where('id',$value)->delete();

			if(SOCKET_ACTION == 'true'){
				require_once SOCKET_PATH;
				$aData = array(
					'customer_id' => $value
				);
				$client->emit('customer delete', $aData);
			}	
		}
		echo '1';
	}

	public function getBlockcustomer(Request $request)
	{
		
		$explodeid = explode(',', rtrim($request->getid,','));
		$update['active'] = '3';
		foreach ($explodeid as $key => $value) {
			$changestate = \DB::table('tb_users')->where('id',$value)->update($update);
		}
		echo '1';
	}	

}

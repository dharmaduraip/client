<?php namespace App\Http\Controllers;

use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use Validator, Input, Redirect ; 
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\UsersImport;
use App\Exports\LocationExports;


class LocationController extends Controller {

	protected $layout = "layouts.main";
	protected $data = array();	
	public $module = 'location';
	static $per_page	= '10';

	public function __construct()
	{		
		parent::__construct();
		$this->model = new Location();	
		
		$this->info = $this->model->makeInfo( $this->module);	
		$this->data = array(
			'pageTitle'	=> 	$this->info['title'],
			'pageNote'	=>  $this->info['note'],
			'pageModule'=> 'location',
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
				$validator = Validator::make($request->all(), $rules);
				if ($validator->passes()) 
				{
					$data = $this->validatePost( $request );
					$id = $this->model->insertRow($data , $request->input( $this->info['key']));
					
					/* Insert logs */
					$this->model->logs($request , $id);
					if($request->has('apply'))
						return redirect( $this->module .'/'.$id.'/edit?'.time(). $this->returnUrl() )->with('message',__('core.note_success'))->with('status','success');

					return redirect( $this->module .'?'.time(). $this->returnUrl() )->with('message',__('core.note_success'))->with('status','success');
				} 
				else {
					if( $request->input(  $this->info['key'] ) =='') {
						$url = $this->module.'/create?'.time(). $this->returnUrl();
					} else {
						$url = $this->module .'/'.$id.'/edit?'.time(). $this->returnUrl();
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
		$model  = new Location();
		$info = $model::makeInfo('location');
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
				return view('location.public.view',$data);			
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
			return view('location.public.index',$data);	
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
	public function deleteloc(Request $request)
	{
		$explodeid = explode(',', rtrim($request->getid,','));
		foreach ($explodeid as $key => $value) {
			$changestate = \DB::table('location')->where('id',$value)->delete();

			// if(SOCKET_ACTION == 'true'){
			// 	require_once SOCKET_PATH;
			// 	$aData = array(
			// 		'customer_id' => $value
			// 	);
			// 	$client->emit('customer delete', $aData);
			// }	
		}
		echo '1';
	}

	public function DefaultImageChange( Request $request)
	{
		$path = 'uploads/location_ad/';
		$img = \AbserveHelpers::getDefaultAdvert(true);
		$loc = base_path('uploads/location_ad/'.$img);
		if(file_exists($loc) && !empty($img)){ unlink($loc); }
		\AbserveHelpers::uploadImage($request->file('image'),$path,'','DefaultAdvertise',"");
		return \Response::json('1',200);
	}

	public function locationexport(Request $request,$slug) 
	{	
		$request->all();
		$exporter = app()->makeWith(LocationExports::class, compact('request'));  
		return $exporter->download('LocationExports_'.date('Y-m-d').'.'.$slug);
	}
}

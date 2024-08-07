<?php namespace App\Http\Controllers;

use App\Models\Audit;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use Validator, Input, Redirect ; 


class AuditController extends Controller {

	protected $layout = "layouts.main";
	protected $data = array();	
	public $module = 'audit';
	static $per_page	= '10';

	public function __construct()
	{
		
		parent::__construct();
		$this->model = new Audit();
		
		$this->info = $this->model->makeInfo( $this->module);
		$this->access = array();
	
		$this->data = array_merge(array(
			'pageTitle'	=> 	$this->info['title'],
			'pageNote'	=>  $this->info['note'],
			'pageModule'=> 'audit',
			'return'	=> self::returnUrl()
			
		),$this->data);

		
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
		$this->data['modules']	= \DB::table('tb_module')->get() ;
		return view( $this->module.'.index',$this->data);
	}

	function show( Request $request , $id ) 
	{
		/* Handle import , export and view */
		$task =$id ;
		switch( $task)
		{
			case 'restore':
				return $this->restore( $request );
				break;		
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

				//dd($this->data['row']);
				$ModuleName = $this->data['row']->ModuleName;
				$ModuleDataID = $this->data['row']->ModuleDataID;
				$this->data['histories'] = \DB::table('tb_audits')->where('ModuleName',$ModuleName)->where('ModuleDataID',$ModuleDataID)->orderBy('Created','DESC')->get();
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
					if(!is_null($request->input('apply')))
						return redirect( $this->module .'/'.$id.'/edit?'. $this->returnUrl() )->with('message',__('core.note_success'))->with('status','success');

					return redirect( $this->module .'?'. $this->returnUrl() )->with('message',__('core.note_success'))->with('status','success');
				} 
				else {
					return redirect($this->module.'/'. $request->input(  $this->info['key'] ).'/edit')
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
		if(count($request->input('ids')) >=1)
		{
			\DB::table('tb_audits')->whereIn('ModuleDataID',$request->input('ids'))->delete();
			
			// redirect
        	return ['message'=>__('core.note_success_delete'),'status'=>'success'];	
	
		} else {
			return ['message'=>__('No Item Deleted'),'status'=>'error'];				
		}

	}			

	public function restore( $request  )
	{
		$id = $request->input('key');
		$res = \DB::table('tb_audits')->where('AuditID',$id)->get();
		if(count($res)>=1)
		{
			$row = $res[0];
			$backup = json_decode($row->ModuleData,true);
			/* Check If Rows exists */
			$check = \DB::table($row->ModuleTable)->where($row->ModuleKey, $row->ModuleDataID)->get();
			if(count($check)>=1)
			{
				$data = $check[0];

				if(isset($backup[ $row->ModuleKey ]))
				unset($backup[ $row->ModuleKey ]);

				\DB::table( $row->ModuleTable)->where(  $row->ModuleKey , $row->ModuleDataID )->update($backup);
				return redirect('audit/'.$id)
        			->with('message', "Data Restored Successfull !")->with('status','success');
			} else {

				\DB::table( $row->ModuleTable)->insert($backup);
				return redirect('audit/'.$id)
        			->with('message', "Data Restored Successfull !")->with('status','success');
			}

		}  else {
		
			return redirect('audit/'.$id)
        			->with('message', "Data Restored Failed !")->with('status','error');	
		}

	} 


}
<?php namespace App\Http\Controllers\core;


use App\Http\Controllers\Controller;
use App\Models\Core\Users;
use App\Models\Core\Groups;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use Validator, Input, Redirect ; 

//use App\Http\Controllers\mobile\UserController as usercon;


class UsersController extends Controller {

	protected $layout = "layouts.main";
	protected $data = array();	
	public $module = 'users';
	static $per_page	= '50';

	public function __construct()
	{		
		parent::__construct();
		$this->model = new Users();	
		$this->info = $this->model->makeInfo( $this->module);	
		$this->data = array(
			'pageTitle'	=> 	$this->info['title'],
			'pageNote'	=>  $this->info['note'],
			'pageModule'=> 'core/users',
			'return'	=> self::returnUrl()
			
		);
		
	}

	public function index( Request $request )
	{
		// Make Sure users Logged 

		if($this->access['is_view'] ==0) 
			return Redirect::to('dashboard')
				->with('messagetext', \Lang::get('core.note_restric'))->with('msgstatus','error');

		if($id !='')
		{
			if($this->access['is_edit'] ==0 )
			return Redirect::to('dashboard')->with('messagetext',\Lang::get('core.note_restric'))->with('msgstatus','error');
		}	


		if(!\Auth::check()) 
			return redirect('user/login')->with('status', 'error')->with('message','You are not login');

		$filter = [
			'params' => " AND tb_groups.level > '".Users::level(session('gid'))."'" 
		];
		$this->grab( $request , $filter ) ;
		if($this->access['is_view'] ==0) 
			return redirect('dashboard')->with('message', __('core.note_restric'))->with('status','error');				
		// Render into template
		return view( 'core.'. $this->module.'.index',$this->data);
	}

	function create( Request $request ) 
	{
		$this->hook( $request  );

		if($this->access['is_add'] ==0) 
			return redirect('dashboard')->with('message', __('core.note_restric'))->with('status','error');

		$this->data['row'] = $this->model->getColumnTable( $this->info['table']); 
		$this->data['id'] = '';
		return view('core.users.form',$this->data);

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
		return view('core.users.form',$this->data);
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
			case 'blast':
				return $this->getBlast( $request);
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

				return view('core.users.view',$this->data);	
				break;		
		}
	}	

	function store( Request $request  )
	{
		$task = $request->input('action_task');
		switch ($task)
		{
			default:
				return $this->postSave( $request );
				break;
			case 'delete':
				$result = $this->destroy( $request );
				return redirect('core/'.$this->module.'?'.$this->returnUrl())->with($result);
				break;

			case 'import':
				return $this->PostImport( $request );
				break;

			case 'copy':
				$result = $this->copy( $request );
				return redirect('core/'.$this->module.'?'.$this->returnUrl())->with($result);
				break;		
		}	
	
	}

	function postSave( $request, $id =0)
	{
		
		$rules = $this->validateForm();
		if($request->input('id') =='')
		{
			$rules['password'] 				= 'required|between:6,12|confirmed';
			$rules['password_confirmation'] = 'required|between:6,12';
			$rules['email'] 				= 'required|email|unique:tb_users';
			$rules['username'] 				= 'required|alpha_num|min:2|unique:tb_users';
			
		} else {
			if($request->input('password') !='')
			{
				$rules['password'] 				='required|between:6,12|confirmed';
				$rules['password_confirmation'] ='required|between:6,12';			
			}
		}
		if(!is_null($request->file('avatar'))) $rules['avatar'] = 'mimes:jpg,jpeg,png,gif,bmp';

		$validator = Validator::make($request->all(), $rules);	
		if ($validator->passes()) {
			$data = $this->validatePost( $request );
			if($request->input('id') =='')
			{
				$data['password'] = \Hash::make($request->input('password'));
			} else {
				if($request->input('password') !='')
				{
					$data['password'] = \Hash::make($request->get('password'));
				} else {
					unset($data['password']);
				}
			}
					
			
			$id = $this->model->insertRow($data , $request->input('id'));

			if(!is_null($request->file('avatar')))
			{
				$updates = array();
				$file = $request->file('avatar'); 
				$destinationPath = './uploads/users/';
				$filename = $file->getClientOriginalName();
				$extension = $file->getClientOriginalExtension(); //if you need extension of the file
				 $newfilename = $id.'.'.$extension;
				$uploadSuccess = $request->file('avatar')->move($destinationPath, $newfilename);				 
				if( $uploadSuccess ) {
				    $updates['avatar'] = $newfilename; 
				} 
				$this->model->insertRow($updates , $id );
			}	

			if(!is_null($request->input('apply')))
			{
				$return = 'core/users/update/'.$id.'?return='.self::returnUrl();
			} else {
				$return = 'core/users?return='.self::returnUrl();
			}
			
			return redirect($return)->with('message',__('core.note_success'))->with('status','success');
			
		} else {

			return redirect()->back()->with('message',__('core.note_error'))->with('status','error')
			->withErrors($validator)->withInput();
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
			$this->model->destroy($request->input('ids'));
			
			\SiteHelpers::auditTrail( $request , "ID : ".implode(",",$request->input('ids'))."  , Has Been Removed Successfull");
			// redirect
        	return ['message'=>__('core.note_success_delete'),'status'=>'success'];	
	
		} else {
			return ['message'=>__('No Item Deleted'),'status'=>'error'];				
		}

	}	

	function getBlast()
	{
		$this->data = array(
			'groups'	=> Groups::all(),
			'pageTitle'	=> 'Blast Email',
			'pageNote'	=> 'Send email to users'
		);	
		return view('core.users.blast',$this->data);		
	}

	function postDoblast( Request $request)
	{

		$rules = array(
			'subject'		=> 'required',
			'message'		=> 'required|min:10',
			'groups'		=> 'required',				
		);	
		$validator = Validator::make($request->all(), $rules);	
		if ($validator->passes()) 
		{	

			if(!is_null($request->input('groups')))
			{
				$count = 0;
				$groups = $request->input('groups');
				for($i=0; $i<count($groups); $i++)
				{
					if($request->input('uStatus') == 'all')
					{

						$users = \DB::table('tb_users')->where('group_id','=',$groups[$i])->get();
					} else {
						$users = \DB::table('tb_users')->where('active','=',$request->input('uStatus'))->where('group_id','=',$groups[$i])->get();
					}
					

					foreach($users as $row)
					{
						$data['note'] 	= $request->input('message');
						$data['row']		= $row;
						$data['to']			= $row->email;
						$data['subject']	= $request->input('subject');
						$data['cnf_appname'] = $this->config['cnf_appname'];
						
						
						if($this->config['cnf_mail'] && $this->config['cnf_mail'] =='swift')
						{ 
							if(!empty($data['to'])){
							\Mail::send('core.users.email', $data, function ($message) use ($data) {
					    		$message->to($data['to'])->subject($data['subject']);
					    	});
							}


					    } else {
					    	$message = view('core.users.email',$data);
							$headers  = 'MIME-Version: 1.0' . "\r\n";
							$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
							$headers .= 'From: '.$this->config['cnf_appname'].' <'.$this->config['cnf_email'].'>' . "\r\n";
								mail($data['to'], $data['subject'], $message, $headers);

					    }							
						
						++$count;					
					} 
					
				}
				return redirect('core/users/blast')->with('message','Total '.$count.' Message has been sent')->with('status','success');

			}
			return redirect('core/users/blast')->with('message','No Message has been sent')->with('status','info');
			

		} else {

			return redirect('core/users/blast')->with('message', 'The following errors occurred')->with('status','error')
			->withErrors($validator)->withInput();

		}	

	}

	public function getSearch( $mode = 'native')
	{

		$this->data['tableForm'] 	= $this->info['config']['forms'];	
		$this->data['tableGrid'] 	= $this->info['config']['grid'];
		$this->data['searchMode'] = 'native';
		$this->data['pageUrl']		= url('core/users');
		return view('sximo.module.utility.search',$this->data);
	
	}

	//Notification Fuctions 

	function getBlastnotification()
	{


		
		$this->data = array(
			'groups'	=> Groups::all(),
			'pageTitle'	=> 'Blast Notification',
			'pageNote'	=> 'Send notification to users'
		);	
		return view('core/users/blastnotification',$this->data);		
	}

	public function appapimethod( $value = '')
    {   
      $appapi = \DB::table('abserve_app_apis')->select('*')/*->where('id','=',$value)*/->get();
      return $appapi[0];
    }

    public function userapimethod($userid = '',$table)
    {

      $userapi = \DB::table($table)->select('mobile_token')->where('id','=',$userid)->get();

      return $userapi[0]->mobile_token;
    }

	function postDoblastnotification( Request $request)
	{


		$rules = array(
			'message'		=> 'required|min:10',
			'groups'		=> 'required',				
		);	
		$validator = Validator::make($request->all(), $rules);
		if ($validator->passes()) 
		{	


			if(!is_null($request->input('groups')))
			{
				$groups = $request->input('groups');
				// $usercontroller = new usercon;


				for($i=0; $i<count($groups); $i++)
				{

					$count = 0;


					if($groups[$i] == 8){
						if($request->input('uStatus') == 'all')
						{
							$users = \DB::table('abserve_deliveryboys')->get();
						} else {
							$users = \DB::table('abserve_deliveryboys')->where('active','=',$request->input('uStatus'))->get();
						}


					} else {
						if($request->input('uStatus') == 'all')
						{
							$users = \DB::table('tb_users')->where('group_id','=',$groups[$i])->get();
						} else {
							$users = \DB::table('tb_users')->where('active','=',$request->input('uStatus'))->where('group_id','=',$groups[$i])->get();
						}
					}
					$tokenBundle = [];
					foreach($users as $row)
					{
						if($groups[$i] == 8) { // Delivery boy 

							$appapi_details	= $this->appapimethod(3);
							$mobile_token 	= $this->userapimethod($row->id,'abserve_deliveryboys');
							$user_det=\DB::table('abserve_deliveryboys')->select('device')->where('id',$row->id)->first();
							// print_r($user_det); exit;
							$device_name=$user_det->device;
							// $note_id = \DB::table('abserve_deliveryboys')->select('device')->where('id',$row->id)->get();
						} else if($row->group_id == 4){ // customer
							$appapi_details	= $this->appapimethod(1);
							$mobile_token 	= $this->userapimethod($row->id,'tb_users');
							$user_det=\DB::table('tb_users')->select('device')->where('id',$row->id)->first();
							$device_name=$user_det->device;
							// $note_id = \DB::table('tb_users')->select('device')->where('id',$row->id)->get();
						} else {
							$appapi_details	= $this->appapimethod(2);
							$mobile_token 	= $this->userapimethod($row->id,'tb_users');
							$user_det=\DB::table('tb_users')->select('device')->where('id',$row->id)->first();
							$device_name=$user_det->device;
							// $note_id = \DB::table('tb_users')->select('device')->where('id',$row->id)->get();
						}




						$message 		= $request->message;
						$subject_title 	= $request->subject_title;
						$app_name		= $appapi_details->app_name;
						$app_api 		= $appapi_details->api;
						if($mobile_token != '')
						{
							array_push($tokenBundle,$mobile_token);
						}
						$count = ++$count;		
					} 
					
						$newArray = array_chunk($tokenBundle, 20);
						foreach ($newArray as $key => $val) {

							$sendnot = $this->Blastnotification($app_api,$val,$message,$app_name,$device_name,$subject_title);	
						}
				} 
				
				return Redirect::to('core/users/blastnotification')->with('messagetext','Total '.$sendnot.' Message has been sent')->with('msgstatus','success');

			}
			
			return Redirect::to('core/users/blastnotification')->with('messagetext','No Message has been sent')->with('msgstatus','info');
			

		} else {
			
        

			return Redirect::to('core/users/blastnotification')->with('messagetext', 'The following errors occurred')->with('msgstatus','error')
			->withErrors($validator)->withInput();

		}	

	}



}

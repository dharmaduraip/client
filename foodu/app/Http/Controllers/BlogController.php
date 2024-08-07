<?php namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use Validator, Input, Redirect ; 
use App\Exports\BlogExports;
use DateTime;


class BlogController extends Controller {

	protected $layout = "layouts.main";
	protected $data = array();	
	public $module = 'blog';
	static $per_page	= '50';

	public function __construct()
	{		
		parent::__construct();
		$this->model = new Blog();	
		
		$this->info = $this->model->makeInfo( $this->module);	
		$this->data = array(
			'pageTitle'	=> 	$this->info['title'],
			'pageNote'	=>  $this->info['note'],
			'pageModule'=> 'blog',
			'return'	=> self::returnUrl()
			
		);
		
	}

	public function index( Request $request )
	{
		// Make Sure users Logged 
		if(!\Auth::check()) 
			return redirect('user/login')->with('status', 'error')->with('message','You are not login');
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
		$model  = new Blog();
		$info = $model::makeInfo('blog');
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
				return view('blog.public.view',$data);			
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
			return view('blog.public.index',$data);	
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

	public function blogPage(Request $request)
	{

		$this->data['pageTitle'] 	= 'Blog';
		$this->data['pageNote'] 	= 'Blog Page';
		$this->data['breadcrumb'] 	= 'inactive';	
		$this->data['pageMetakey'] 	= CNF_METAKEY ;
		$this->data['pageMetadesc'] = CNF_METADESC ;
		$this->data['blog'] 		= $this->model->getBlog();
		$this->data['pages'] 		= 'blog.blogs';	

		$page = 'layouts.'.'default'.'.index';
		return view($page,$this->data)->with('blog_model',new Blog);
	}
	public function blogredirect( Request $request)
	{
		if(\Auth::check())
		{ 
			$id=\Auth::getUser()->id;


		$blog_id = (\Request::segment(2));
		$date = new DateTime();
		$date->format('Y-m-d H:i:s');

		$exist = \DB::table('abserve_blog_comment')
		->where('user_id', '=',$id)
		->exists();
		
		if($exist){

				$comment= \DB::select( "SELECT abserve_blog_comment.* FROM abserve_blog_comment WHERE `parent_id` =0 AND `blog_id` = ".$blog_id );
				foreach ($comment as $key => $value) {
				$com_arr[] = $value->id;
				}

				if($com_arr){


				$row=implode(',', $com_arr);
				$reply= \DB::select( "SELECT abserve_blog_comment.* FROM abserve_blog_comment WHERE `blog_id` = '".$blog_id."' and `parent_id` IN (".$row.") ");
				$blog_comment=\DB::table('abserve_blog_comment')->select(\DB::raw('COUNT(blog_id) as blog_count'))->where('blog_id', ($request->segment(2)))->first();
		          // echo "<pre>";print_r($blog_comment);exit();
	                 $this->data ['blog_comment'] = $blog_comment;



				$this->data['pageTitle'] 	= 'Blog';
				$this->data['blog_id'] 		= $blog_id;
				$this->data['date_time'] 	= $date->format('Y-m-d H:i:s');;
				$this->data['pageNote'] 	= 'Blog Page';
				$this->data['breadcrumb'] 	= 'inactive';	
				$this->data['pageMetakey'] 	= CNF_METAKEY ;
				$this->data['pageMetadesc'] = CNF_METADESC ;
				$this->data['blog'] 		= $this->model->getBlogdetails($blog_id);
				$this->data['blogs'] 		= $comment;
				$this->data['reply'] 		= $reply;


				$this->data['pages'] 		= 'blog.blogsredirect';	

				$page = 'layouts.'.CNF_THEME.'.index';
				return view($page,$this->data);
			    }
			    else{
			    	$blog_id = (\Request::segment(2));
				$date = new DateTime();
				$date->format('Y-m-d H:i:s');

				$this->data['pageTitle'] 	= 'Blog';
				$this->data['blog_id'] 		= $blog_id;
				$this->data['date_time'] 	= $date->format('Y-m-d H:i:s');;
				$this->data['pageNote'] 	= 'Blog Page';
				$this->data['breadcrumb'] 	= 'inactive';	
				$this->data['pageMetakey'] 	= CNF_METAKEY ;
				$this->data['pageMetadesc'] = CNF_METADESC ;
				$this->data['blog'] 		= $this->model->getBlogdetails($blog_id);
				$this->data['blogs'] 		= $this->model->getBlogcomment($blog_id);
				$this->data['reply'] 	= $this->model->getBlogreply($blog_id);

				$this->data['pages'] 		= 'blog.blogsredirect';	

				$page = 'layouts.'.CNF_THEME.'.index';
				return view($page,$this->data);
			    }

				
			}
			else{
				$blog_id = (\Request::segment(2));
				$date = new DateTime();
				$date->format('Y-m-d H:i:s');

				$this->data['pageTitle'] 	= 'Blog';
				$this->data['blog_id'] 		= $blog_id;
				$this->data['date_time'] 	= $date->format('Y-m-d H:i:s');;
				$this->data['pageNote'] 	= 'Blog Page';
				$this->data['breadcrumb'] 	= 'inactive';	
				$this->data['pageMetakey'] 	= CNF_METAKEY ;
				$this->data['pageMetadesc'] = CNF_METADESC ;
				$this->data['blog'] 		= $this->model->getBlogdetails($blog_id);
				$this->data['blogs'] 		= $this->model->getBlogcomment($blog_id);
				$this->data['reply'] 	= $this->model->getBlogreply($blog_id);

				$this->data['pages'] 		= 'blog.blogsredirect';	

				$page = 'layouts.'.'default'.'.index';
				return view($page,$this->data);

			}
	}else{
			\Session::put('redirect', \URL::full());
			return redirect('user/login');
		}
	}
	public function postComment( Request $request)
	{

		if(\Auth::check())
		{ 
			$userid = \Auth::user()->id; 
			$this->data['userid'] = $userid;

			$values = array('user_id' => $userid,'blog_id' =>$_REQUEST['selectedId'],'date' =>$_REQUEST['selectedDate'], 'name' =>$_REQUEST['selectedName'],'email' =>$_REQUEST['selectedEmail'],'message' => $_REQUEST['selectedMessage']);
			\DB::table('abserve_blog_comment')->insert($values);

			
			echo "string";
		} else {
			\Session::put('redirect', \URL::full());
			return redirect('user/login');
		}
	}

	public function postReply( Request $request)
	{

		$userid = \Auth::user()->id; 
		$this->data['userid'] = $userid;


		// $user = Blog::where('selectedName', $selectedName);

		$values = array('user_id' => $userid,'blog_id' =>$_REQUEST['selectedId'],'date' =>$_REQUEST['selectedDate'], 'name' =>$_REQUEST['selectedName'],'email' =>$_REQUEST['selectedEmail'],'message' => $_REQUEST['selectedMessage'],'parent_id' =>$_REQUEST['selectedComment']);
		\DB::table('abserve_blog_comment')->insert($values);
		echo "string";
		// $status = ($user->name == null) ? 'success' : 'failure';
		// return $status ;
		//$var=$_REQUEST['selectedId'];

		// $this->data['end'] 					= $this->model->getBlogcomment($_REQUEST['selectedId']);
		// $this->data['pages'] 				= 'blog.blogsredirect';	

		// $page = 'layouts.'.CNF_THEME.'.index';
		// return view($page,$this->data);
	}
	public function blogexport(Request $request,$slug) 
	{	
		$request->all();
		$exporter = app()->makeWith(BlogExports::class, compact('request'));  
		return $exporter->download('BlogExports_'.date('Y-m-d').'.'.$slug);
	}

}

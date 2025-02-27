<?php namespace App\Http\Controllers\sximo;

use App\Models\Sximo\Menu;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator, Input, Redirect; 



class MenuController extends Controller {

	public function __construct()
	{
		parent::__construct();
        $this->middleware(function ($request, $next) {           
            if(session('gid') !='1')
                return redirect('dashboard')
                ->with('message','You Dont Have Access to Page !')->with('status','error');            
            return $next($request);
        });		
		$this->model = new Menu();
		$this->info = $this->model->makeInfo( 'menu');
		$this->access = $this->model->validAccess($this->info['id'] );


        $this->data = array_merge(array(
            'pageTitle' =>  'Navigation',
            'pageNote'  =>  'Manage All Side/Top Menu',
            
        ),$this->data)  ;		
	}


	public function getIndex( Request $request ,$id = null  )
	{

		$pos = (!is_null($request->input('pos')) ? $request->input('pos') : 'top' );
		$row = \DB::table('tb_menu')->where('menu_id',$id)->get();
		if(count($row)>=1)
		{
			
			$rows = $row[0];
			$this->data['row'] =  (array) $rows;


			$this->data['menu_lang'] = json_decode($rows->menu_lang,true);    
		} else {
			$this->data['row'] = array(
					'menu_id'	=> '',
					'parent_id'	=> '',
					'menu_name'	=> '',
					'menu_type'	=> '',
					'url'	=> '',
					'module'	=> '',
					'position'	=> '',
					'menu_icons'	=> '',
					'active'	=> '',
					'allow_guest'	=> '',
					'access_data'	=> '',

				); 
			$this->data['menu_lang'] = array(); 
		}
		//echo '<pre>';print_r($this->data);echo '</pre>';  exit;
		$this->data['menus']		= \SiteHelpers::menus( $pos ,'all');
		$this->data['modules'] 		= \DB::table('tb_module')->where('module_type','!=','core')->get();
		$this->data['groups'] 		= \DB::select(" SELECT * FROM tb_groups ");
		$this->data['pages'] 		= \DB::select(" SELECT * FROM tb_pages ");
		$this->data['active'] 		= $pos;	
		$this->data['mode']			= ($id == null ? 'list' : 'form' );
		return view('sximo.menu.index',$this->data);	
	}

	function postSaveorder( Request $request, $id =0)
	{

		$rules = array(
			'reorder'	=> 'required'
		);
		$validator = Validator::make($request->all(), $rules);	
		if ($validator->passes()) {
			$menus = json_decode($request->input('reorder'),true);

			
			$child = array();
			$a=0;
			foreach($menus as $m)
			{			
				if(isset($m['children']))
				{
					$b=0;
					foreach($m['children'] as $l)					
					{
						if(isset($l['children']))
						{
							$c=0;
							foreach($l['children'] as $l2)
							{
								$level3[] = $l2['id'];
								\DB::table('tb_menu')->where('menu_id','=',$l2['id'])
									->update(array('parent_id'=> $l['id'],'ordering'=>$c));
								$c++;	
							}		
						}
						\DB::table('tb_menu')->where('menu_id','=', $l['id'])
							->update(array('parent_id'=> $m['id'],'ordering'=>$b));	
						$b++;
					}							
				}
				\DB::table('tb_menu')->where('menu_id','=', $m['id'])
					->update(array('parent_id'=>'0','ordering'=>$a));
				$a++;		
			}
			return redirect('sximo/menu')
				->with('message', 'Data Has Been Save Successfull')->with('status','success');
		} else {
			return redirect('sximo/menu')
				->with('message', 'The following errors occurred')->with('status','error');

		}	

	
	}
	
	function postSave( Request $request, $id =0)
	{
		

		$rules = array(
			'menu_name'	=> 'required',	
			'active'	=> 'required',	
			'menu_type'	=> 'required',
			'position'	=> 'required',	
		);
		$validator = Validator::make($request->all(), $rules);	
		if ($validator->passes()) {
			$pos = $request->input('position');	
			$data = $this->validatePost( $request );

			
			if($this->config['cnf_multilang'] ==1)
			{
				$lang = \SiteHelpers::langOption();
				$language =array();
				foreach($lang as $l)
				{
					if($l['folder'] !='en'){
						$menu_lang = (isset($_POST['language_title'][$l['folder']]) ? $_POST['language_title'][$l['folder']] : '');  
						$language['title'][$l['folder']] = $menu_lang;        
					}    
				}	
					
				$data['menu_lang'] = json_encode($language);  
			}			
			
			$arr = array();
			$groups = \DB::table('tb_groups')->get();
			foreach($groups as $g)
			{
				$arr[$g->group_id] = (isset($_POST['groups'][$g->group_id]) ? "1" : "0" );	
			}
			$data['access_data'] = json_encode($arr);		
			$data['allow_guest'] = $request->input('allow_guest');
			$data['p_active'] = $request->input('p_active');
			$data['d_active'] = $request->input('d_active');
			$this->model->insertRow($data , $request->input('menu_id'));
			
			return redirect('sximo/menu?pos='.$pos)
				->with('message', 'Data Has Been Save Successfull')->with('status','success');

		} else {
			return redirect('sximo/menu?pos='.$pos)
				->with('message', 'The following errors occurred')->with('status','error')->withErrors($validator)->withInput();

			
		}	
	
	}
	
	public function getDestroy(Request $request,$id)
	{
		// delete multipe rows 
		
		$menus = \DB::table('tb_menu')->where('parent_id','=',$id)->get();
		foreach($menus as $row)
		{
			$this->model->destroy($row->menu_id);
		}
		
		$this->model->destroy($id);
		return redirect('sximo/menu?pos='.$request->input('pos'))
				->with('message', 'Successfully deleted row!')->with('status','success');

	}						

	public function getIcons( Request $request ,$id = null  )
	{
		return view('sximo.menu.icons');

	}

}
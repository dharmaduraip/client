<?php namespace App\Http\Controllers\sximo;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator, Input, Redirect; 



class ServerController extends Controller {

    public function __construct()
    {
        parent::__construct();
        $this->middleware(function ($request, $next) {           
            if(session('gid') !='1')
                return redirect('dashboard')
                ->with('messagetext','You Dont Have Access to Page !')->with('msgstatus','error');            
            return $next($request);
        });        
        $driver             = config('database.default');
        $database           = config('database.connections');
       
        $this->db           = $database[$driver]['database'];
        $this->dbuser       = $database[$driver]['username'];
        $this->dbpass       = $database[$driver]['password'];
        $this->dbhost       = $database[$driver]['host'];       
    }

    function index()
    {
        $this->data['version'] = $this->getVersion();
        return view('sximo.server.index', $this->data);
    }
    function show( Request $request , $task )
    {
        switch ($task) {
            case 'repository':
                 return view('sximo.server.repository', $this->data);
                break;
            case 'install':
                $this->data['id'] = $request->input('id');
                $this->data['type'] = $request->input('t');
                 return view('sximo.server.authen', $this->data);
                break;    
             case 'load':
                $page = $request->input('page') ;
                $page = ( $page =='' ? '' : '&page='.$page);
                $getRows = file_get_contents('http://sximo5.net/api?codename=lts'. $page ) or die ('ERROR');
                $rows = json_decode( $getRows );
                $this->data['rows'] =  $rows->rows ;
                $this->data['control'] =  $rows->control ;
                return view('sximo.server.item', $this->data);
                break;           
            default:
                return $this->version( $request );
                break;
        }

    }
    public function store( Request $request ) {

        $do = $request->input('do');
        switch ($do) {
            case 'install':
                return $this->doInstall($request);
                break;
            
            default:
                return $this->doUpdate($request);
                break;
        }
    }

    public function doInstall( $request) 
    {
        $id     = $request->input('ProductID');
        $type     = $request->input('type');
        $email = $request->input('email');
        $password = $request->input('password');
        $uname = $email.'|'.$password ; 
 
        $temp = public_path()."/uploads/zip/". $id.'.zip';
        $message =  '';
      //  return 'http://sximo5.net/api/download?id='.$id.'&uname='.$uname;
        $newInstall = file_get_contents('http://sximo5.net/api/download?id='.$id.'&uname='.$uname) or die ('ERROR');
        $test = json_decode($newInstall,true);
        if(count($test) >=1 ){
            $result = json_decode($newInstall,true);
            return response()->json(['status'=>'error','message'=> $result['message']]);  

        } else { 

            $dlHandler = fopen($temp, 'w');
            if ( !fwrite($dlHandler, $newInstall) ) { echo '<p>Could not save new update. Operation aborted.</p>'; exit(); }
            fclose($dlHandler);

            if($type =='' or $type =='module') {
                $data = \SximoHelpers::cf_unpackage( $temp );
                $msg = '.';
                if( isset($data['sql_error'])){
                    $msg = ", with SQL error ". $data['sql_error'];
                    return response()->json(['status'=>'success','message'=>  $msg ]); 
                }  
                unlink($temp);  
                self::createRouters();              
            } else if( $type ='core') {
                \SximoHelpers::upgrade( $temp);
                unlink($temp);               
            }  
            return response()->json(['status'=>'success','message'=> 'Install successfull !']); 
        }  

    }

    public function doUpdate( $request) {

           $path = base_path()."/resources/views/sximo/server/version.json";
            $version = $request->input('version');
            $email = $request->input('email');
            $password = $request->input('password');
            $uname = $email.'|'.$password ; 
            $temp = public_path()."/uploads/zip/". $version.'.zip';
            if ( !is_file(  $temp )) 
            {
                $message =  '';
                $getVersions = file_get_contents('http://sximo5.net/upgrade?codename=lts') or die ('ERROR');
                $newUpdate = file_get_contents('http://sximo5.net/upgrade/download?codename=lts&uname='.$uname);
                $test = json_decode($newUpdate,true);
                if(count($test) >=1 ){
                    $result = json_decode($newUpdate,true);
                    return response()->json(['status'=>'error','message'=> $result['message']]);    
                } else {                    
                    $dlHandler = fopen($temp, 'w');
                    if ( !fwrite($dlHandler, $newUpdate) ) { echo '<p>Could not save new update. Operation aborted.</p>'; exit(); }
                    fclose($dlHandler);

                    $getVersions =json_decode($getVersions,true) ;
                    if(\SximoHelpers::upgrade( $temp))
                    {
                        $message .= ' Update successfull ! <p> <b> Sximo Updated to version : </b> '. $getVersions['Version'] .'</p>' ;
                        $change_version = 
                        $fp=fopen($path,"w+");              
                        fwrite($fp, json_encode($getVersions)); 
                        fclose($fp);    
                    }               
                    unlink($temp);
                    
                    return response()->json(['status'=>'success','message'=>$message]);
                }   

            } else {
                return response()->json(['status'=>'error','message'=>'Failed to Update(s) !']);
            }    

    }

    public function getVersion() {

        $path = base_path()."/resources/views/sximo/server/version.json";
        $curr_version = file_get_contents($path) or die ('ERROR');
        return json_decode($curr_version,true);

    }
    public function version( Request $request ) {


        $path = base_path()."/resources/views/sximo/server/version.json";
        $curr_version = file_get_contents($path) or die ('ERROR');
        $curr_version = json_decode($curr_version,true);
        $check = (!is_null($request->input('check')) ? true : false );

        if($check){            
            ini_set('max_execution_time',60);
            //Check For An Update
            $getVersions = file_get_contents('http://sximo5.net/upgrade?codename=lts') or die ('ERROR');
            
            if ($getVersions != '')
            {
                $checkVersion =  json_decode($getVersions,true);
            }
            
            if(strtotime($checkVersion['Build']) > strtotime( $curr_version['Build'] ))
            {
                return response()->json(['status'=>'success','message'=>'Updates Available !','version'=>  $curr_version['Version']]);
            } 
            else {
                return response()->json(['status'=>'error','message'=>'No Updates Available']);
            }


        }   

    }
    function createRouters()
    {
        $rows = \DB::table('tb_module')->where('module_type','!=','core')->get();
        $val  =    "<?php
        "; 
       foreach($rows as $row)
        {
            $class = $row->module_name;
            $controller = ucwords($row->module_name).'Controller';

           $mType = ( $row->module_type =='addon' ? 'native' :  $row->module_type);
           include(base_path().'/resources/views/sximo/module/template/'.$row->module_type.'/config/route.php' );
            
  
        }
        $val .=     "?>";
         $filename = base_path().'/routes/module.php';
        $fp=fopen($filename,"w+"); 
        fwrite($fp,$val); 
        fclose($fp);    
        return true;    
        
    } 
}
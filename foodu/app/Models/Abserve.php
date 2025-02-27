<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Abserve extends Model {
	protected $orderBy;
	protected $orderDirection = 'asc';

	public static function getRows( $args )
	{

	   $connection = 'mysql';
	   if (isset(with(new static)->connection)) {
	   	$connection = with(new static)->connection;
	   }

       $table = with(new static)->table;
	   $key = with(new static)->primaryKey;
	   
        extract( array_merge( array(
			'page' 		=> '0' ,
			'limit'  	=> '0' ,
			'sort' 		=> '' ,
			'order' 	=> '' ,
			'params' 	=> '' ,
			'global'	=> 1	  
        ), $args ));
		
		$offset = ($page-1) * $limit ;	
		$limitConditional = ($page !=0 && $limit !=0) ? "LIMIT  $offset , $limit" : '';	
		$orderConditional = ($sort !='' && $order !='') ?  " ORDER BY {$sort} {$order} " : '';

		// Update permission global / own access new ver 1.1
		$table = with(new static)->table;
		if($global == 0 )
				$params .= " AND {$table}.entry_by ='".\Session::get('uid')."'"; 	
		// End Update permission global / own access new ver 1.1

		if(\Auth::check()){
			if (\Auth::user()->group_id == 5) {
				if($table == 'abserve_restaurants' || $table == 'abserve_order_details'){
					$params .= " AND {$table}.partner_id IN (".implode(',', \SiteHelpers::managersPartner(\Auth::user()->id)).")"; 
				}elseif ($table == 'tb_users') {
					$params .= " AND {$table}.id IN (".implode(',', \SiteHelpers::managersPartner(\Auth::user()->id)).")"; 
				}
			}
		}			
		$rows = array();

	    $result = \DB::connection($connection)->select( self::querySelect() . self::queryWhere(). " 
				{$params} ". self::queryGroup() ." {$orderConditional}  {$limitConditional} ");
		if($key =='' ) { $key ='*'; } else { $key = $table.".".$key ; }	
		if($table=='abserve_order_details'){
			$sQuery=str_replace(".*",".id",self::querySelect());
		}else{
			$sQuery=self::querySelect();
		}
		
		$total = \DB::connection($connection)->select( $sQuery . self::queryWhere(). " 
				{$params} ". self::queryGroup() ." {$orderConditional}  ");
        // print_r($orderConditional);die();
		$total = count($total);
//		$total = $res[0]->total;
		return $results = array('rows'=> $result , 'total' => $total);	

	
	}	

	public static function getRow( $id )
	{
	   $connection = 'mysql';
	   if (isset(with(new static)->connection)) {
	   	$connection = with(new static)->connection;
	   }

       $table = with(new static)->table;
	   $key = with(new static)->primaryKey;

		$result = \DB::connection($connection)->select( 
				self::querySelect() . 
				self::queryWhere().
				" AND ".$table.".".$key." = '{$id}' ". 
				self::queryGroup()
			);	
		if(count($result) <= 0){
			$result = array();		
		} else {

			$result = $result[0];
		}
		return $result;		
	}	

	public  function insertRow( $data , $id)
	{
		// var_dump($data);
		// exit;
		$connection = 'mysql';
		if (isset(with(new static)->connection)) {
			$connection = with(new static)->connection;
		}

       $table = with(new static)->table;
	   $key = with(new static)->primaryKey;
	    if($id == NULL )
        {
			
            // Insert Here 
			if(isset($data['createdOn'])) $data['createdOn'] = date("Y-m-d H:i:s");	
			if(isset($data['updatedOn'])) $data['updatedOn'] = date("Y-m-d H:i:s");	
			 $id = \DB::connection($connection)->table( $table)->insertGetId($data);				
            
        } else {
            // Update here 
			// update created field if any
			if(isset($data['createdOn'])) unset($data['createdOn']);	
			if(isset($data['updatedOn'])) $data['updatedOn'] = date("Y-m-d H:i:s");			
			 \DB::connection($connection)->table($table)->where($key,$id)->update($data);    
        }    
        return $id;    
	}			

	static function makeInfo( $id )
	{	
		$row =  \DB::table('tb_module')->where('module_name', $id)->get();
		$data = array();
		foreach($row as $r)
		{
			$data['id']		= $r->module_id; 
			$data['title'] 	= $r->module_title; 
			$data['note'] 	= $r->module_note; 
			$data['table'] 	= $r->module_db; 
			$data['key'] 	= $r->module_db_key;
			$data['config'] = \SiteHelpers::CF_decode_json($r->module_config);
			$field = array();	
			foreach($data['config']['grid'] as $fs)
			{
				foreach($fs as $f)
					$field[] = $fs['field']; 	
									
			}
			$data['field'] = $field;	
					
		}
		return $data;
			
	
	} 

    static function getComboselect( $params , $limit =null, $parent = null)
    {
        $aLimit = explode('|',$limit);
        $parent = explode(':',$parent);
        $table = $params[0];
        if(count($aLimit) > 0 && !empty($aLimit))
        {
            $condition = '';
            foreach ($aLimit as $key => $value) {
            	$aCurLimit = explode(':',$value);
            	if(count($aCurLimit) >= 3){
            		if($condition != ''){
            			$condition .= " AND ";
            			$condition .= " `".$aCurLimit[0]."` ".$aCurLimit[1]." ".$aCurLimit[2]." ";
            		} else {
            			$condition .= $aCurLimit[0]." `".$aCurLimit[1]."` ".$aCurLimit[2]." ".$aCurLimit[3]." ";
            		}
            		
            	}
            }
            $parentCondition = '';
            if(count($parent)>=2 ){
            	$parentCondition = " AND ".$parent[0]." = '".$parent[1]."'";
            }
            $row =  \DB::select( "SELECT * FROM ".$table." ".$condition ." ".$parentCondition);
        }else{
            $table = $params[0];
            if(count($parent)>=2 )
            {
            	$row =  \DB::table($table)->where($parent[0],$parent[1])->get();
            } else  {
	            $row =  \DB::table($table)->get();
            }	          
        }
        return $row;
    }	

	public static function getColoumnInfo( $result )
	{
		$pdo = \DB::getPdo();
		$res = $pdo->query($result);
		$i =0;	$coll=array();	
		while ($i < $res->columnCount()) 
		{
			$info = $res->getColumnMeta($i);			
			$coll[] = $info;
			$i++;
		}
		return $coll;	
	
	}	


	function validAccess( $id)
	{

		if(\Session::has('gid')){
			$gid = \Session::get('gid');
		} else {
			if(\Auth::check() && \Auth::user()->group_id != NULL){
				$gid = \Auth::user()->group_id;
			} else {
				$gid = \Session::get('gid');
			}
		}
		$ke = $gid == 2 ? 1 : $gid;
		$row = \DB::table('tb_groups_access')->where('module_id','=', $id)
				->where('group_id','=', $ke)
				->get();

		if(count($row) >= 1)
		{
			$row = $row[0];
			if (\Auth::check() && $gid == '2') {
				$services = \Auth::user()->services;
				if (!empty($services) && $services != null) {
					$dServices = json_decode($services);
					$moduleId = $row->module_id;
					$module = \DB::table('tb_module')
								->where('module_id','=', $id)
								->first();
					$menu = \DB::table('tb_menu')
								->where('module','=', $module->module_name)
								->first();
					if (!in_array ($menu->menu_id, $dServices)) {
						return false;	
					}
				}else{
					return false;
				}
			}
			if($row->access_data !='')
			{
				$data = json_decode($row->access_data,true);
			} else {
				$data = array();
			}	
			return $data;		
			
		} else {
			return false;
		}			
	
	}	

	static function getColumnTable( $table )
	{	  
        $columns = array();
	    foreach(\DB::select("SHOW COLUMNS FROM $table") as $column)
        {
           //print_r($column);
		    $columns[$column->Field] = '';
        }
	  

        return $columns;
	}	

	static function getTableList( $db ) 
	{
	 	$t = array(); 
		$dbname = 'Tables_in_'.$db ; 
		foreach(\DB::select("SHOW TABLES FROM {$db}") as $table)
        {
		    $t[$table->$dbname] = $table->$dbname;
        }	
		return $t;
	}	
	
	static function getTableField( $table ) 
	{
        $columns = array();
	    foreach(\DB::select("SHOW COLUMNS FROM $table") as $column)
		    $columns[$column->Field] = $column->Field;
        return $columns;
	}	

}

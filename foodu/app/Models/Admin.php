<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class admin extends Sximo  {
	
	protected $table = 'tb_users';
	protected $primaryKey = 'id';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		return " SELECT tb_users.* FROM tb_users ";
	}	

	public static function queryWhere(  ){
		
		return " WHERE tb_users.group_id = 2 AND tb_users.id IS NOT NULL ";
	}
	
	public static function queryGroup(){
		return "  ";
	}

	public function menus()
	{
	    return Menu::whereIn('menu_id', $this->menus_ids);
	}

	/**
	 * Accessor for layer_ids property.
	 *
	 * @return array
	 */
	public function getMenusIdsAttribute($commaSeparatedIds)
	{
	    return explode(',', $commaSeparatedIds);
	}

	/**
	 * Mutator for layer_ids property.
	 *
	 * @param  array|string $ids
	 * @return void
	 */
	public function setLayersIdsAttribute($ids)
	{
	    $this->attributes['menus_ids'] = is_string($ids) ? $ids : implode(',', $ids);
	}
	
	public function getMenusAttribute()
	{
	    if (!$this->relationLoaded('menus')) {
	        $menus = Menu::whereIn('menu_id', $this->menus_ids)->get();

	        $this->setRelation('menus', $menus);
	    }

	    return $this->getRelation('menus');
	}

}

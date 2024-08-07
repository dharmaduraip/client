<?php namespace App\Models\Front;

use Illuminate\Database\Eloquent\Model;
use App\Models\Sximo;

class Banner extends Sximo  {

	protected $table		= 'abserve_banner';
	protected $primaryKey	= 'id';
	protected $appends		= ['src'];

	public function __construct() {
		parent::__construct();
	}
	
	function getSrcAttribute()
	{
		$fileName = $this->attributes['image'];
		$path = 'uploads/banner/';
		if($fileName != '' && file_exists(base_path($path.$fileName))){
			return url($path.$fileName);
		}
		return url('/uploads/images/dummybanner.jpg');
	}
}

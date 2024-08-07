<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Sximo;

class Cuisines extends Sximo  {
	
	protected $table		= 'abserve_food_cuisines';
	protected $primaryKey	= 'id';
	protected $appends		= ['src'];

	public function __construct() {
		parent::__construct();
	}
	
	function getSrcAttribute()
	{
		$fileName = $this->attributes['image'];
		$path = 'uploads/cuisine/';
		if($fileName != '' && file_exists(base_path($path.$fileName))){
			return url($path.$fileName);
		}
		return url('/uploads/images/noImage.jpg');
	}

	/*function getSrcAttribute()
	{
		$image	= $this->attributes['image'];
		$file	= 'uploads/cuisine/'.$image;
		if($image != '' && file_exists(base_path($file))){
			return \URL::to($file);
		}
		return \URL::to('uploads/images/noImage.jpg');
	}*/
}
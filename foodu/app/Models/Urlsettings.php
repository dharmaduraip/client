<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Urlsettings extends Sximo  {
	protected $table	= 'abserve_baseurl_settings';
	public $timestamps	= false;

	protected $fillable = [
		'user_id', 'cookie_id', 'url', 'lat', 'lang', 'keyword'
	];

	protected $hidden = [
		'created_at', 'updated_at'
	];
}
?>
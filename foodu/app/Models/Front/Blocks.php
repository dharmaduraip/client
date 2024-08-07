<?php namespace App\Models\Front;

use Illuminate\Database\Eloquent\Model;
use App\Models\Sximo;

class Blocks extends Sximo  {

	protected $table		= 'abserve_blocks';
	protected $primaryKey	= 'id';

	public function __construct() {
		parent::__construct();
	}
}

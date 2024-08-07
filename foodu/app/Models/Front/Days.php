<?php namespace App\Models\Front;

use Illuminate\Database\Eloquent\Model;
use App\Models\Sximo;

class Days extends Sximo  {
	protected $table = 'abserve_days';
	protected $primaryKey = 'id';
}
<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class UserSearchKeyword extends Abserve  {
	protected $table = 'user_search_keyword';
	protected $primaryKey = 'id';
}
?>
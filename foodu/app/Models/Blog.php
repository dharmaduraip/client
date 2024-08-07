<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class blog extends Sximo  {
	
	protected $table = 'abserve_blog';
	protected $primaryKey = 'id';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		return "  SELECT abserve_blog.* FROM abserve_blog  ";
	}	

	public static function queryWhere(  ){
		
		return "  WHERE abserve_blog.id IS NOT NULL ";
	}
	
	public static function queryGroup(){
		return "  ";
	}
	public static function getBlog()
	{
		return \DB::select( "SELECT abserve_blog.* FROM abserve_blog");
	}
	public static function getBlogdetails( $id = '')
	{
		return \DB::select( "SELECT abserve_blog.* FROM abserve_blog WHERE `id` = ".$id);
	}
	
	public static function getBlogcomment( $blog_id = '')
	{
		return \DB::table('abserve_blog_comment')->select(\DB::raw('count(id) As blog_count'))->where('blog_id',$blog_id)->first();
		// return \DB::select( "SELECT count(id) As blog_count FROM abserve_blog_comment WHERE `blog_id` = ".$blog_id);
	}
	public static function getBlogreply( $blog_id = '')
	{      $user_id=\Auth::check();
		
		return \DB::select( "SELECT abserve_blog_reply.* FROM abserve_blog_reply WHERE `blog_id` = '".$blog_id."' and `user_id`=".$user_id);
	}

	public static function getBlogpost( $id = '')
	{
		return \DB::select( "SELECT tb_users.* FROM tb_users WHERE `id` = ".$id);
	}	

}

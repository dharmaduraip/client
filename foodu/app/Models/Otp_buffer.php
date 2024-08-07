<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class Otp_buffer extends Sximo  {
    
    protected $table = 'tbl_otp_buffer';
    protected $primaryKey = 'id';

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function __construct() {
        parent::__construct();
        
    }

    public static function querySelect(  ){
        
        return "  SELECT tbl_otp_buffer.* FROM tbl_otp_buffer  ";
    }   

    public static function queryWhere(  ){
        
        return "  WHERE tbl_otp_buffer.id IS NOT NULL ";
    }
    
    public static function queryGroup(){
        return "  ";
    }
    

}

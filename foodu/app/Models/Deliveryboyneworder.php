<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class Deliveryboyneworder extends Sximo  {
    
    protected $table = 'delivery_boy_new_orders';
    protected $primaryKey = 'id';
    public $timestamps = false;   
}

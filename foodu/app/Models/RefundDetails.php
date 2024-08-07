<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class RefundDetails extends Abserve  {
	
	protected $table = 'abserve_refund_details';
	protected $primaryKey = 'id';
	protected $appends = ['customer_src'];

	public function __construct() {
		parent::__construct();
		
	}

	public function getCustomerSrcAttribute()
	{
		$images = $this->attributes['customer_image'];
		$pId = $this->attributes['parent_order'];
		$presentImages = [];
		if ($images != '' && $images !=null) {
			$images = json_decode($images);
			if(!empty($images)){
				foreach ($images as $iKey => $iValue) {
					$filePath = base_path('/uploads/refund/'.$pId.'/customer/'.$iValue);
					if (file_exists($filePath)) {
						$presentImages[] = \URL::to('/uploads/refund/'.$pId.'/customer/'.$iValue);	
					}	
				}
			}
		}
		return $presentImages;		
	}
	public function getBoySrcAttribute()
	{
		$images = $this->attributes['boy_image'];
		$pId = $this->attributes['parent_order'];
		$presentImages = [];
		if ($images != '' && $images !=null) {
			$images = json_decode($images);
			if(!empty($images) && isset($images->customer_image) && !empty($images->customer_image)){
				$images = $images->customer_image;
				foreach ($images as $iKey => $iValue) {
					$filePath = base_path('/uploads/refund/'.$pId.'/boy/'.$iValue);
					if (file_exists($filePath)) {
						$presentImages[] = \URL::to('/uploads/refund/'.$pId.'/boy/'.$iValue);	
					}	
				}
			}
		}
		return $presentImages;		
	}

	public function getMainOrder()
	{
		return $this->hasOne(OrderDetail::class, 'id', 'parent_order');
	}

	public function getOrder()
	{
		return $this->hasOne(Refundinfo::class, 'id', 'child_order');
	}

	public function gatCheckWallet()
	{
		return $this->hasOne(Wallet::class, 'order_id', 'child_order');
	}
}

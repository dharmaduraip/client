<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use App\User;

class Restaurantrating extends Sximo  {
	
	protected $table = 'abserve_rating';
	protected $primaryKey = 'id';
	protected $fillable = ['cust_id'];

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		return "  SELECT abserve_rating.* FROM abserve_rating JOIN  abserve_restaurants ON abserve_restaurants.`id` = abserve_rating.`res_id` ";
	}	

	public static function queryWhere(  ){
		
		$id = \Auth::user()->id;
			if(\Auth::user()->group_id == 1)
			{
				return "  WHERE abserve_rating.id IS NOT NULL ";
			}
			else
			{
				return "  WHERE abserve_restaurants.`partner_id` = ".$id." ";

			}
	}
	
	public static function queryGroup(){
		return "  ";
	}

	public function getUserAttribute(){
		$user = User::where('id', $this->cust_id)->first();
		return $user;
	}

	public function getCommentAttribute(){
			$commentCreatedAt = $this->created_at; 
	
	$commentTimestamp = strtotime($commentCreatedAt);
	
	$currentTimestamp = time();
	
	$timeDifference = $currentTimestamp - $commentTimestamp;
	
	// Calculate the time units
	$minute = 60;
	$hour = $minute * 60;
	$day = $hour * 24;
	$month = $day * 30;
	$year = $month * 12;
	
	if ($timeDifference >= $year) {
	    $count = floor($timeDifference / $year);
	    $unit = 'year';
	} elseif ($timeDifference >= $month) {
	    $count = floor($timeDifference / $month);
	    $unit = 'month';
	} elseif ($timeDifference >= $day) {
	    $count = floor($timeDifference / $day);
	    $unit = 'day';
	} elseif ($timeDifference >= $hour) {
	    $count = floor($timeDifference / $hour);
	    $unit = 'hour';
	} elseif ($timeDifference >= $minute) {
	    $count = floor($timeDifference / $minute);
	    $unit = 'minute';
	} else {
	    $count = $timeDifference;
	    $unit = 'second';
	}
	
	// Add "s" to the unit if the count is greater than 1
	if ($count > 1) {
	    $unit .= 's';
	}
	
	// Construct the human-readable time difference string
	$humanReadableTime = $count . ' ' . $unit . ' ago';
	
	return $humanReadableTime;
		}
		
	
	}

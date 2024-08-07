<?php
namespace App\Helpers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller as con;
use Validator, Input, Redirect, Response, Authorizer, Hash, Str, DB, Auth ;

class ProfileValidationHelper {

	public static function candidateprofile($data,$method,$page){
		// print_r($data['status']); exit;
		$rules = [];
		$custom_message = [];
		if($method == 'POST' || $method == 'PATCH' || $method == 'DELETE'){
			$rules['page'] = 'required|in:Profile,cv info,Summary,skills info,language info,location info,profile info,personal info,social info,account info';
		}
		if($method == 'POST' && $page == 'Profile') {
			$rules['role'] 			= 'required|in:candidate';
			$rules['name'] 			= 'required';
			//$rules['title'] 		= 'required';
			$rules['experience_id'] = 'required';
			$rules['education_id'] 	= 'required';
			//$rules['website'] 		= 'required';
			$rules['birth_date'] 	= 'date_format:Y-m-d';
			// $rules['photo'] 		= 'required';
            if(array_key_exists('photo',$data)){
				$rules['photo'] 	= 'required';
			}
			$custom_message = [ 'photo.required' => 'Please select a photo'];
		}
		elseif($method == 'POST' && $page == 'cv info'){
			$rules['role'] 	= 'required|in:candidate';
			$rules['name']	= 'required';
			$rules['file'] 	= 'required|mimes:pdf|max:5120';
		}
		elseif($method == 'POST' && $page == 'Summary'){
			$rules['role'] 	= 'required|in:candidate';
			// $rules['bio'] 	= 'required';

		}
		elseif($method == 'POST' && $page == 'skills info'){
			$rules['role'] 		= 'required|in:candidate';
			$rules['skill_id'] 	= 'required';

		}
		elseif($method == 'POST' && $page == 'language info'){
			$rules['role'] 					= 'required|in:candidate';
			$rules['candidate_language_id'] = 'required';

		}
		elseif($method == 'POST' && $page == 'location info'){
			$rules['role'] 			= 'required|in:candidate';
			$rules['address'] 		= 'required';
			$rules['region'] 		= 'required';
			$rules['country'] 		= 'required';
			$rules['long'] 			= 'required';
			$rules['lat'] 			= 'required';
		}
		elseif($method == 'POST' && $page == 'profile info'){
			$rules['role'] 					= 'required|in:candidate';
			$rules['nationality_id'] 		= 'required';
			$rules['gender'] 				= 'required';
			$rules['marital_status'] 		= 'required';
			$rules['profession_id'] 		= 'required';
			$rules['status'] 				= 'required';
			if(isset($data['status']) && $data['status'] == 'available_in'){
				$rules['available_in'] 	= 'required';
			}
			// $rules['skill_id'] 				= 'required';
			// $rules['candidate_language_id'] = 'required';
			// $rules['bio'] 					= 'required';
		}
		elseif($method == 'POST' && $page == 'social info'){
			$rules['role'] 			= 'required|in:candidate';
			$rules['social_media']	= 'required';
			$rules['url']			= 'required';
		}
		elseif($method == 'POST' && $page == 'account info'){
			$rules['role'] 	= 'required|in:candidate';
			//$rules['address']	= 'required';
			$rules['phone']	= 'required';
			//$rules['secondary_phone']	= 'required';
			$rules['email']	= 'required';
		//	$rules['secondary_email']	= 'required';
			$rules['role_id']	= 'required';
		//	$rules['received_job_alert']	= 'required';
		//	$rules['visibility']	= 'required';
		//	$rules['cv_visibility']	= 'required';
		//	$rules['password']	= 'min:6|required|max:50';
		//	$rules['confirm_password']	= 'required|min:6|max:50|same:password';
        if(array_key_exists('password',$data)){
				$rules['password']	= 'min:6|required|max:50';
                $rules['confirm_password']	= 'required|min:6|max:50|same:password';
			}
		}
		elseif($method == 'PATCH' && $page == 'personal_info'){
			$rules['role'] 				= 'required|in:candidate';
			$rules['name']				= 'required';
			$rules['father_name']		= 'required';
			$rules['gender_id']			= 'required';
			$rules['marital_status_id']	= 'required';
			$rules['date_of_birth']		= 'required|date_format:Y-m-d';
			$rules['mobile_num']		= 'required';
			$rules['email']				= 'required|email';
			$rules['phone']				= 'required|digits:10|numeric';
			$rules['password']			= 'required|min:6';
		}
		elseif($method == 'PATCH' && $page == 'location_info'){
			$rules['role'] 				= 'required|in:candidate';
			$rules['street_address']	= 'required';
			$rules['nationality_id']	= 'required|numeric';
			$rules['country_id']		= 'required|numeric';
			$rules['city_id']			= 'required|numeric';
			$rules['state_id']			= 'required|numeric';
			$rules['zip_code']			= 'required|numeric|digits:6';
		}
		elseif($method == 'PATCH' && $page == 'career_info'){
			$rules['role'] 				= 'required|in:candidate';
			$rules['job_experience_id']	= 'required|numeric';
			$rules['career_level_id']	= 'required|numeric';
			$rules['industry_id']		= 'required|numeric';
			$rules['functional_area_id']= 'required|numeric';
			$rules['current_salary']	= 'required|numeric';
			$rules['expected_salary']	= 'required|numeric';
			$rules['salary_currency']	= 'required';
		}
		elseif($method == 'PATCH' && $page == 'summary_info'){
			$rules['role'] 		 = 'required|in:candidate';
			$rules['id'] 		 = 'required|numeric';
			$rules['summary'] 	 = 'required';
		}
		elseif($method == 'PATCH' && $page == 'cv_info'){
			$rules['role'] 		= 'required|in:candidate';
			$rules['id'] 		= 'required|numeric';
			$rules['title'] 	= 'required';
			$rules['cv_file'] 	= 'file|mimes:doc,docx,pdf';
			$rules['cv_video']  = 'mimes:mp4,mov,ogg | max:200000';
		}
		elseif($method == 'PATCH' && $page == 'project_info'){
			$rules['role'] 			= 'required|in:candidate';
			$rules['id']		 	= 'required';
			$rules['name']			= 'required';
			$rules['description'] 	= 'required';
			$rules['image'] 		= 'file|mimes:jpeg,bmp,png,gif,svg,pdf';
			$rules['date_start'] 	= 'required|date_format:Y-m-d';
			$rules['date_end'] 		= 'required|date_format:Y-m-d';
		}
		elseif($method == 'PATCH' && $page == 'experience_info'){
			$rules['role'] 			= 'required|in:candidate';
			$rules['id']			= 'required';
			$rules['title']			= 'required';
			$rules['company']		= 'required';
			$rules['country_id']	= 'required|numeric';
			$rules['state_id']		= 'required|numeric';
			$rules['city_id']		= 'required|numeric';
			$rules['date_start']	= 'required|date_format:Y-m-d';
			$rules['date_end']		= 'required|date_format:Y-m-d';
			$rules['description']	= 'required';
		}
		elseif($method == 'PATCH' && $page == 'education_info'){
			$rules['role']				= 'required|in:candidate';
			$rules['id']				= 'required|numeric';
			$rules['degree_level_id']	= 'required|numeric';
			$rules['degree_type_id']	= 'required|numeric';
			$rules['degree_title']		= 'required';
			$rules['country_id']		= 'required|numeric';
			$rules['state_id']			= 'required|numeric';
			$rules['city_id']			= 'required|numeric';
			$rules['institution']		= 'required';
			$rules['date_completion']	= 'required';
			$rules['degree_result']		= 'required';
			$rules['result_type_id']	= 'required|numeric';
		}
		elseif($method == 'PATCH' && $page == 'skill_info'){
			$rules['role']				= 'required|in:candidate';
			$rules['id']				= 'required|numeric';
			$rules['job_skill_id'] 		= 'required|numeric';
			$rules['job_experience_id'] = 'required|numeric';
		}
		elseif($method == 'PATCH' && $page == 'language_info'){
			$rules['role'] 				= 'required|in:candidate';
			$rules['id']				= 'required|numeric';
			$rules['language_id'] 		= 'required|numeric';
			$rules['language_level_id'] = 'required|numeric';
		}
		elseif($method == 'DELETE'){
			$rules['role'] 				= 'required|in:candidate';
			$rules['id']				= 'required|numeric';
		}
		$controller = new con;
		return $controller->validateDatas($data,$rules,$custom_message);
	}

	public static function employerprofile($data,$method,$page){
		$rules = [];
		if($method == 'POST' || $method == 'PATCH' || $method == 'DELETE'){
			$rules['page'] = 'required|in:company_profile_info,basic_info,social_links,contact_info';
		}
		if($method == 'POST' && $page == 'basic_info'){
			/*$rules['logo_image'] 	= 'required';
			$rules['banner_image'] 	= 'required';*/
			$rules['image'] 	= 'required|array';
			$rules['biography'] 	= 'required';
			$rules['company_name'] 	= 'required';

		}
		elseif($method == 'POST' && $page == 'company_profile_info'){
			$rules['role'] 		= 'required|in:employer';
			$rules['organization_type']		= 'required';
			$rules['industry_type'] 	= 'required';
			$rules['team_size']  = 'required';
			$rules['establishment_date']  = 'required';
			$rules['vision']  = 'required';
			$rules['website']  = 'required';
		}
		elseif($method == 'POST' && $page == 'social_links'){
			$rules['role'] 			= 'required|in:employer';
			$rules['social_media']	= 'required';
			// $rules['url']			= 'required';
		}
		elseif($method == 'POST' && $page == 'contact_info'){
			$rules['role'] 			= 'required|in:employer';
			$rules['location']		= 'required';
			$rules['latitude']		= 'required';
			$rules['lontitude']		= 'required';
			$rules['phone_number']	= 'required';
			$rules['email']			= 'required';
		}


		elseif($method == 'POST' && $page == 'project_info'){
			$rules['role'] 			= 'required|in:candidate';
			$rules['name']			= 'required';
			$rules['date_start'] 	= 'required|date_format:Y-m-d';
			$rules['date_end'] 	 	= 'required|date_format:Y-m-d';
			$rules['description'] 	= 'required';
		}
		elseif($method == 'POST' && $page == 'experience_info'){
			$rules['title']		= 'required';
			$rules['company']		= 'required';
			$rules['country_id']	= 'required|numeric';
			$rules['state_id']		= 'required|numeric';
			$rules['city_id']		= 'required|numeric';
			$rules['date_start']	= 'required|date_format:Y-m-d';
			$rules['date_end']		= 'required|date_format:Y-m-d';
			$rules['description']	= 'required';

		}
		elseif($method == 'POST' && $page == 'education_info'){
			$rules['role']				= 'required|in:candidate';
			$rules['degree_level_id']	= 'required|numeric';
			$rules['degree_type_id']	= 'required|numeric';
			$rules['degree_title']		= 'required';
			$rules['country_id']		= 'required|numeric';
			$rules['state_id']			= 'required|numeric';
			$rules['city_id']			= 'required|numeric';
			$rules['institution']		= 'required';
			$rules['date_completion']	= 'required';
			$rules['degree_result']		= 'required';
			$rules['result_type_id']	= 'required|numeric';
		}
		elseif($method == 'POST' && $page == 'skill_info'){
			$rules['role']				= 'required|in:candidate';
			$rules['job_skill_id'] 		= 'required|numeric';
			$rules['job_experience_id'] = 'required|numeric';
		}
		elseif($method == 'POST' && $page == 'language_info'){
			$rules['role'] 				= 'required|in:candidate';
			$rules['language_id'] 		= 'required|numeric';
			$rules['language_level_id'] = 'required|numeric';
		}
		elseif($method == 'PATCH' && $page == 'personal_info'){
			$rules['role'] 				= 'required|in:candidate';
			$rules['name']				= 'required';
			$rules['father_name']		= 'required';
			$rules['gender_id']			= 'required';
			$rules['marital_status_id']	= 'required';
			$rules['date_of_birth']		= 'required|date_format:Y-m-d';
			$rules['mobile_num']		= 'required';
			$rules['email']				= 'required|email';
			$rules['phone']				= 'required|digits:10|numeric';
			$rules['password']			= 'required|min:6';
		}
		elseif($method == 'PATCH' && $page == 'location_info'){
			$rules['role'] 				= 'required|in:candidate';
			$rules['street_address']	= 'required';
			$rules['nationality_id']	= 'required|numeric';
			$rules['country_id']		= 'required|numeric';
			$rules['city_id']			= 'required|numeric';
			$rules['state_id']			= 'required|numeric';
			$rules['zip_code']			= 'required|numeric|digits:6';
		}
		elseif($method == 'PATCH' && $page == 'career_info'){
			$rules['role'] 				= 'required|in:candidate';
			$rules['job_experience_id']	= 'required|numeric';
			$rules['career_level_id']	= 'required|numeric';
			$rules['industry_id']		= 'required|numeric';
			$rules['functional_area_id']= 'required|numeric';
			$rules['current_salary']	= 'required|numeric';
			$rules['expected_salary']	= 'required|numeric';
			$rules['salary_currency']	= 'required';
		}
		elseif($method == 'PATCH' && $page == 'summary_info'){
			$rules['role'] 		 = 'required|in:candidate';
			$rules['id'] 		 = 'required|numeric';
			$rules['summary'] 	 = 'required';
		}
		elseif($method == 'PATCH' && $page == 'cv_info'){
			$rules['role'] 		= 'required|in:candidate';
			$rules['id'] 		= 'required|numeric';
			$rules['title'] 	= 'required';
			$rules['cv_file'] 	= 'file|mimes:doc,docx,pdf';
			$rules['cv_video']  = 'mimes:mp4,mov,ogg | max:200000';
		}
		elseif($method == 'PATCH' && $page == 'project_info'){
			$rules['role'] 			= 'required|in:candidate';
			$rules['id']		 	= 'required';
			$rules['name']			= 'required';
			$rules['description'] 	= 'required';
			$rules['image'] 		= 'file|mimes:jpeg,bmp,png,gif,svg,pdf';
			$rules['date_start'] 	= 'required|date_format:Y-m-d';
			$rules['date_end'] 		= 'required|date_format:Y-m-d';
		}
		elseif($method == 'PATCH' && $page == 'experience_info'){
			$rules['role'] 			= 'required|in:candidate';
			$rules['id']			= 'required';
			$rules['title']			= 'required';
			$rules['company']		= 'required';
			$rules['country_id']	= 'required|numeric';
			$rules['state_id']		= 'required|numeric';
			$rules['city_id']		= 'required|numeric';
			$rules['date_start']	= 'required|date_format:Y-m-d';
			$rules['date_end']		= 'required|date_format:Y-m-d';
			$rules['description']	= 'required';
		}
		elseif($method == 'PATCH' && $page == 'education_info'){
			$rules['role']				= 'required|in:candidate';
			$rules['id']				= 'required|numeric';
			$rules['degree_level_id']	= 'required|numeric';
			$rules['degree_type_id']	= 'required|numeric';
			$rules['degree_title']		= 'required';
			$rules['country_id']		= 'required|numeric';
			$rules['state_id']			= 'required|numeric';
			$rules['city_id']			= 'required|numeric';
			$rules['institution']		= 'required';
			$rules['date_completion']	= 'required';
			$rules['degree_result']		= 'required';
			$rules['result_type_id']	= 'required|numeric';
		}
		elseif($method == 'PATCH' && $page == 'skill_info'){
			$rules['role']				= 'required|in:candidate';
			$rules['id']				= 'required|numeric';
			$rules['job_skill_id'] 		= 'required|numeric';
			$rules['job_experience_id'] = 'required|numeric';
		}
		elseif($method == 'PATCH' && $page == 'language_info'){
			$rules['role'] 				= 'required|in:candidate';
			$rules['id']				= 'required|numeric';
			$rules['language_id'] 		= 'required|numeric';
			$rules['language_level_id'] = 'required|numeric';
		}
		elseif($method == 'DELETE'){
			$rules['role'] 				= 'required|in:candidate';
			$rules['id']				= 'required|numeric';
		}
		$controller = new con;
		return $controller->validateDatas($data,$rules);
	}
}

?>

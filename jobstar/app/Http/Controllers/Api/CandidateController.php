<?php namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Validator, Input, Redirect, Response, Authorizer, Hash, Str, DB, Auth ;
use Illuminate\Http\Request;
//use App\User;
use App\Models\User;
use App\Models\Deliveryboy;
use App\Http\Controllers\EmailController as emailcon;
use App\Http\Controllers\UserController;
use App\Models\Restaurant;
use ImgUploader;
use Carbon\Carbon;
use App\Helpers\DataArrayHelper;
use App\Helpers\ImageUploadingHelper;
use App\Helpers\ProfileValidationHelper;
use App\Models\Basic_info;
use App\Models\Candidate;
use App\Models\CandidateResume;
use App\Models\CandidateSkill;
use App\Models\CandidateLanguages;
use App\Models\SocialLink;
use App\Models\ContactInfo;
use App\Models\Company;
use App\Models\Experience;
use App\Models\Education;
use App\Models\Nationality;
use App\Models\Profession;
use App\Models\Skill;
use App\Models\CandidateLanguage;
use App\Models\JobRole;
use App\Models\SkillTranslation;
use App\Models\CompanyMessage;
use App\Models\OrganizationType;
use App\Models\IndustryTypeTranslation;
use App\Models\TeamSize;
use App\Models\Job;
use App\Models\Setting;
use Modules\Location\Entities\Country;
use App\Models\JobCategory;
use App\Models\JobType;
use App\Models\Tag;
class CandidateController extends Controller {


	public function __construct()
	{
		$this->middleware('client.credentials')->only(['']);
	}

	public function Profile(Request $request)
	{
		if (isset($request->role)) {
			if ($request->role == 'candidate') {
				ProfileValidationHelper::candidateprofile($request->all(),$request->method(),$request->page);
			}elseif($request->role == "employer" && $request->method() == 'POST'){
				ProfileValidationHelper::employerprofile($request->all(),$request->method(),$request->page);
			}
			$user = new UserController();
			$auth = $user::getUserID();
			if ($auth) {
				if($request->method() == 'POST') {
					if($request->role == 'candidate') {
						switch($request->page){

							case 'Profile':
							$user_id 	  			  		= $auth->id;
							$basic_info  			  		= User::find($user_id);
							$basic_info->name    	  		= $request->name;
							$save 	= $basic_info->save();
							$candidate_det            		= Candidate::where('user_id',$user_id)->first();
							$candidate_det->title	  		= $request->title;
							$candidate_det->experience_id	= $request->experience_id;
							$candidate_det->education_id	= $request->education_id;
							$candidate_det->website	  		= $request->website;
							$candidate_det->birth_date	  	= $request->birth_date;
							if($request->hasFile('photo')){
								$path = 'images/candidates';
								$image = uploadImage($request->file('photo'), $path);
								$candidate_det->photo    = $image;
							}
                            /******** Basic info *********/
							$candidate_det->profile_complete	= $candidate_det->profile_complete != 0 ? $candidate_det->profile_complete - 25 : 0;

							$save 	= $candidate_det->save();
							break;

							case 'cv info':
							$user_id 	  			  	= $auth->id;
							$candidate_det            	= Candidate::where('user_id',$user_id)->first();
							$inputs['candidate_id']		= $candidate_det->id;
							$inputs['name'] = $request->name;
							if ($request->hasFile('file')) {
								$cv_file = $request->file('file');
								$fileName = ImgUploader::UploadDoc('cvs', $cv_file, $request->input('name'));
								$file = array($fileName);
								foreach($file as $val){
									$inputs['file'] = $val;
								}
							}
							if($request->id !='') {
								$arr = ['name'=> $request->name, 'file'=> $fileName];
								$save = CandidateResume::where('id',$request->id)->update($arr);
								$response['message'] = $request->page.' Updated Successfully!';
								return \Response::json($response);
							}else{
								$save = CandidateResume::create($inputs);
							}

							case 'Summary':
							$user_id 	  			 		= $auth->id;
							$summary_info            		= Candidate::where('user_id',$user_id)->first();
							$summary_info->bio 				= $request->bio;
							$save = $summary_info->save();
							break;

							case 'skills info':
							$user_id 	  			 		= $auth->id;
							$skills_info            		= Candidate::where('user_id',$user_id)->first();
							$inputs['candidate_id'] 		= $skills_info->id;
							$skill_id 						= explode(',',$request->skill_id);
							$candidate_skill = CandidateSkill::where('candidate_id', $skills_info->id)->where('skill_id',$request->skill_id)->first();
							if(!isset($candidate_skill)){
							foreach($skill_id as $val){
							$inputs['skill_id'] 		= $val;
							$save = CandidateSkill::create($inputs);
							}}else{
							$restrict = 'abc';
							}
							break;

							case 'language info':
							$user_id 	  			 		= $auth->id;
							$language_info            		= Candidate::where('user_id',$user_id)->first();
							$inputs['candidate_id'] 		= $language_info->id;
							$candidate_language_id			= explode(',',$request->candidate_language_id);
							$candidate_language = CandidateLanguages::where('candidate_id',$language_info->id)->where('candidate_language_id',$request->candidate_language_id)->first();
							if(!isset($candidate_language)){
							foreach ($candidate_language_id as $val){
							$inputs['candidate_language_id'] = $val;
							$save = CandidateLanguages::create($inputs);
							}}else{
							$restrict = 'abc';
							}
							break;

							case 'location info':
							$user_id 	  			 		= $auth->id;
							$location_info = Candidate::where('user_id',$user_id)->first();
							$location_info->address = $request->address;
							$location_info->region = $request->region;
							$location_info->country = $request->country;
							$location_info->long = $request->long;
							$location_info->lat = $request->lat;
							$save = $location_info->save();
							break;

							case 'profile info':
							$user_id 	  			 		= $auth->id;
							$profile_info            		= Candidate::where('user_id',$user_id)->first();
							$profile_info->nationality_id 	= $request->nationality_id;
							$profile_info->gender 			= $request->gender;
							$profile_info->marital_status 	= $request->marital_status;
							$profile_info->profession_id 	= $request->profession_id;
							$profile_info->status 			= $request->status;
							$profile_info->available_in 	= $request->available_in;
                            /******** Profile info *********/
							$profile_info->profile_complete	= $profile_info->profile_complete != 0 ? $profile_info->profile_complete - 25 : 0;
							$save = $profile_info->save();
							break;

							case 'social info':
							$user_id 	  			= $auth->id;
							$social_info  			= User::find($user_id);
							$inputs['user_id'] 		= $social_info->id;
							$inputs['social_media'] = $request->social_media;
							$inputs['url'] 			= $request->url;
							if($request->id !='') {
								$arr = ['social_media'=> $request->social_media, 'url'=> $request->url];
								$save = SocialLink::where('id',$request->id)->update($arr);
								$response['message'] = $request->page.' Updated Successfully!';
								return \Response::json($response);
							}else{

								$save = SocialLink::create($inputs);
							}
                            /******** Social info *********/
							$social_info = Candidate::where('user_id',$user_id)->first();
							$social_info->profile_complete	= $social_info->profile_complete != 0 ? $social_info->profile_complete - 25 : 0;
							$social_info->save();

							break;

							case 'account info':
							$user_id 	  						= $auth->id;
							$user  			 					= User::find($user_id);
							$user->password 					= Hash::make($request->password);
							$user->confirm_password 			= Hash::make($request->confirm_password);
							$account_det            			= Candidate::where('user_id',$user_id)->first();
							//$account_det->address 				= $request->address;
							$inputs['user_id'] 					= $user->id;
							$inputs['phone'] 					= $request->phone;
							$inputs['secondary_phone'] 			= $request->secondary_phone;
							$inputs['email']				 	= $request->email;
							$inputs['secondary_email'] 			= $request->secondary_email;
							$inputs['location']                 = $request->location;
							$account_det->role_id 			 	= $request->role_id;
							$account_det->received_job_alert 	= $request->received_job_alert;
							$account_det->visibility 			= $request->visibility;
							$account_det->cv_visibility 		= $request->cv_visibility;
                            /******** Account info *********/
							$account_det->profile_complete	= $account_det->profile_complete != 0 ? $account_det->profile_complete - 25 : 0;
							$save = $account_det->save();
							$save = $user->save();
							$check = ContactInfo::where('user_id', $user->id)->first();
							if(isset($check) && $check != null){
								$save = $check->update($inputs);
							}else{
								$save = ContactInfo::create($inputs);
							}
							break;
						}
						if (isset($save)) {
							$status = 200;
							$response['status'] = "success";
							$response['message'] = $request->page.' Created Successfully!';
							if($request->page == 'Profile'){
								$response['userData']['user_details'] = User::find($candidate_det->user_id)->select('id', 'name')->first();
							}
						}elseif($restrict){
							$status = 200;
							$response['status'] = "error";
							$response['message'] = $request->page.' already insert';
						}

						return \Response::json($response,$status);
					} elseif($request->role == "employer"){
						switch($request->page){
							case 'basic_info':
						/*	$inputs = ['logo' => $request->logo_image,'banner' => $request->banner_image,'bio' => $request->biography];
							if($request->hasFile('logo_image') || ($request->hasFile('banner_image'))){
								$path = 'images/company';
								$banner = uploadImage($request->file('banner_image'), $path);
								$logo = uploadImage($request->file('logo_image'), $path);
								$inputs['logo']    = $logo;
								$inputs['banner']    = $banner;
							}*/
							$image = $request->image;
							//print_r($image[0]);exit;
							$inputs = ['logo' => $image[0],'banner' => $image[1],'bio' => $request->biography];
							

							if($request->hasFile('image')){//print_r($request->file('image')[0]); exit;
								$path = 'images/company';
								$banner = uploadImage($request->file('image')[0], $path);
								$logo = uploadImage($request->file('image')[1], $path);
								$inputs['logo']    = $logo;
								$inputs['banner']    = $banner;
							}
							$save = Company::where('user_id',\Auth::user()->id)->update($inputs);
							if(isset($request->company_name)){
								// $company['name'] = $request->company_name;
								// $company['current_page'] = 'company_profile_info';
								$user = User::find(\Auth::user()->id);
								$user->name = $request->company_name;
								if($user->current_page != 'home'){
									$user->current_page = 'company_profile_info';
								}
								$user->save();
							}
							break;

							case 'company_profile_info':
							$inputs = ['organization_type_id' => $request->organization_type,'industry_type_id' => $request->industry_type,'team_size_id' => $request->team_size,"website" => $request->website,"vision" => $request->vision,"establishment_date" => $request->establishment_date];
							$save = Company::where('user_id',\Auth::user()->id)->update($inputs);
							$user = User::find(\Auth::user()->id);
							if($user->current_page != 'home'){
								$user->current_page = 'social_links';
								$user->save();
							}
							break;

							case 'social_links':
							// dd($request->all());
							foreach($request->social_media as $key => $value){
								$social_link = SocialLink::where('user_id', $auth->id)->where('social_media', $key)->first();
								if(!isset($social_link)){
									$social_link    		= new SocialLink;
								}
								$social_link->user_id 	  	= $auth->id;
								// $social_link->social_media  = $request->social_media;
								// $social_link->url   		= $request->url;
								$social_link->social_media  = $key;
								if($value == null){
								    $social_link->url   		= '';
								}else{
								    $social_link->url   		= $value;
								}
								$save 					  	= $social_link->save();
							}
							$user = User::find(\Auth::user()->id);
							if($user->current_page != 'home'){
								$user->current_page = 'contact_info';
								$user->save();
							}
							break;

							case 'contact_info':
							$arr  = ['locality' => $request->location, 'lat' => $request->latitude, 'long' => $request->lontitude];
							$input = ['phone'=>$request->phone_number,'email'=> $request->email];
							$save = ContactInfo::where('user_id',\Auth::user()->id)->update($input);
							$save = Company::where('user_id',\Auth::user()->id)->update($arr);
							$user = User::find(\Auth::user()->id);
							if($user->current_page != 'home'){
								$user->current_page = 'home';
								$user->save();
							}
							break;
						}
						if ($save) {
							$status = 200;
							$response['message'] = $request->page.' Created Successfully!';

						}
						return \Response::json($response,$status);
					}
				} elseif($request->method() == 'GET') {
					$user = User::find(\Auth::user()->id);
					if($request->role == 'candidate') {
						$response["full_name"] 	= $user->name;
						$response['user_id'] = $user->id;
						$candidate_det = Candidate::where('user_id',$user->id)->first();
						$response["professional_title"] 	= $candidate_det->title;
						$experiece = Experience::find($candidate_det->experience_id);
						if(isset($experiece)){
							$response["experience_id"] 			= $candidate_det->experience_id;
							$response['experiece_name'] = $experiece->name;
						}else{
							$response["experience_id"] = '';
							$response['experiece_name']= '';
						}
						$education = Education::find($candidate_det->education_id);
						if(isset($education)){
						$response["education_id"] 			= $candidate_det->education_id;
						$response['education_name'] = $education->name;
						}else{
							$response["education_id"] = '';
							$response['education_name']= '';
						}
						$response["personal_website"] 		= $candidate_det->website;
						$response["date_of_birth"] 			= $candidate_det->birth_date;
						$response["profile_image"] 			= $candidate_det->photo;
						$nationalities = Nationality::find($candidate_det->nationality_id);
						if(isset($nationalities)){
							$response["nationality_id"]			= $candidate_det->nationality_id;
							$response['nationalities_name'] = $nationalities->name;
						}else{
							$response["nationality_id"]	= '';
							$response['nationalities_name'] = '';
						}
						$response["gender"]					= $candidate_det->gender;
						$response["avaliablity"]			= $candidate_det->status;
						$response["available_in"]			= $candidate_det->available_in;
						$response["marital_status"]			= $candidate_det->marital_status;
						$professions = Profession::find($candidate_det->profession_id);
						if (isset($professions)) {
							$response["profession_id"]			= $candidate_det->profession_id;
							$response['professions_name'] = $professions->name;
						}else{
							$response["profession_id"] = '';
							$response['professions_name'] = '';
						}
						$response["bio"]					= $candidate_det->bio;
						$response_1 = [];
						$candidate_resume = CandidateResume::where('candidate_id',$candidate_det->id)->get();
						if(isset($candidate_resume)){
							foreach($candidate_resume as $key =>  $val){
								$response_1[$key]['cv_id'] = $val->id;
								$response_1[$key]['candidate_id'] = $val->candidate_id;
								$response_1[$key]['resume_name']	= $val->name;
								$response_1[$key]['file']	= $val->file;
							}
							$response['cv_info']	= $response_1;
						}else{
							$response['cv_info'] 	= [];
						}
						$response_2 = [];
						$social_links = SocialLink::where('user_id',$user->id)->get();
						if(isset($social_links)){
							foreach($social_links as $key => $val){
								$response_2[$key]['id'] = $val->id;
								$response_2[$key]['user_id'] = $val->user_id;
								$response_2[$key]['social_media'] 		= $val->social_media;
								$response_2[$key]['social_media_url'] 	= $val->url;
							}
							$response['social_links'] = $response_2;
						}else{
							$response['social_media'] 		= '';
							$response['social_media_url'] 	= '';

						}
						$contact_infos = ContactInfo::where('user_id',$user->id)->first();
						if(isset($contact_infos)){
							$response['phone'] 				= $contact_infos->phone;
							$response['secondary_phone'] 	= $contact_infos->secondary_phone;
							$response['email'] 				= $contact_infos->email;
							$response['secondary_email'] 	= $contact_infos->secondary_email;
						}else{
							$response['phone'] 				= '';
							$response['secondary_phone'] 	= '';
							$response['email'] 				= '';
							$response['secondary_email'] 	= '';
						}
						$candidate_skill 		= CandidateSkill::where('candidate_id',$candidate_det->id)->get();
						if($candidate_skill->isNotEmpty()){
							foreach ($candidate_skill as $key => $skill) {
								// $skills = SkillTranslation::find($skill->skill_id);
								$skills = SkillTranslation::where('skill_id', $skill->skill_id)->first();
								$response_skill[$key]['skill_id'] = $skills->skill_id;
								$response_skill[$key]['skill_name'] = $skills->name;
							$response['skill_info'] 	= $response_skill;
							}
						}else{
							$response['skill_info'] 	= [];
						}
						$candidate_language 	= CandidateLanguages::where('candidate_id',$candidate_det->id)->get();

						if($candidate_language && count($candidate_language) > 0){
							foreach ($candidate_language as $key => $lang) {
								$language = CandidateLanguage::find($lang->candidate_language_id);
								$response_lang[$key]['candidate_language_id'] = $lang->candidate_language_id;
								$response_lang[$key]['candidate_language_name'] = $language->name;
							}
							$response['language_info']	= $response_lang;
						}else{
							$response['language_info']= [];
						}
						$roles = JobRole::find($candidate_det->role_id);
							$response["job_role_id"]			= $candidate_det->role_id;
							$response['job_role_name'] 			= isset($roles) ? ($roles->name) : '';
						if(isset($candidate_language)){
							$response["profile_privacy"]		= $candidate_det->visibility;
							$response["resume_privacy"]			= $candidate_det->cv_visibility;
							$response["location"]				= $candidate_det->address;
							$response["region"]					= $candidate_det->region;
							$response["country"]				= $candidate_det->country;
							$response["long"]					= $candidate_det->long;
							$response["lat"]					= $candidate_det->lat;
						}else{

							$response["profile_privacy"]		= '';
							$response["resume_privacy"]			= '';
							$response["location"]				= '';
							$response["region"]					= '';
							$response["country"]				= '';
							$response["long"]					= '';
							$response["lat"]					= '';
						}
						return \Response::json($response);
					}if($request->role == 'employer') {
						$response["company_name"] 	= $user->name;
						$employer_det = Company::where('user_id',$user->id)->first();
						$response["logo_image"] 		= $employer_det->logo;
						$response["banner_image"] 		= $employer_det->banner;
						$response["organization_type"] 	= OrganizationType::select('id','name')->where('id',$employer_det->organization_type_id)->first();
						$response["industry_type"] 		= IndustryTypeTranslation::select('id','industry_type_id','name')->where('industry_type_id',$employer_det->industry_type_id)->where('locale', 'en')->first();
						$response["establishment_date"] = date('Y-m-d',strtotime($employer_det->establishment_date));
						$response["team_size"] 			= TeamSize::select('id','name')->where('id',$employer_det->team_size_id)->first();
						$response["website"]			= $employer_det->website;
						$response["biography"]			= strip_tags($employer_det->bio);
						$response["company_vision"]	    = strip_tags($employer_det->vision);
						$response["locality"]			= $employer_det->locality;
						$response["latitude"]			= $employer_det->lat;
						$response["longitude"]			= $employer_det->long;
						$response["district"]		    = $employer_det->district;
						$response_2 = [];
						$social_links = SocialLink::where('user_id',$user->id)->get();
						if(isset($social_links)){
							foreach($social_links as $key => $val){
								$response_2[$key]['id'] = $val->id;
								$response_2[$key]['user_id'] = $val->user_id;
								$response_2[$key]['social_media'] 		= $val->social_media;
								$response_2[$key]['social_media_url'] 	= $val->url;
							}
							$response['social_links'] = $response_2;
						}else{
							$response['social_links'] = '';

						}
						$contact_infos = ContactInfo::where('user_id',$user->id)->first();
						if(isset($contact_infos)){
							$response['phone'] 				= $contact_infos->phone;
							$response['secondary_phone'] 	= $contact_infos->secondary_phone;
							$response['email'] 				= $contact_infos->email;
							$response['secondary_email'] 	= $contact_infos->secondary_email;
						}else{
							$response['phone'] 				= '';
							$response['secondary_phone'] 	= '';
							$response['email'] 				= '';
							$response['secondary_email'] 	= '';
						}
						// dd($contact_infos);
						$response['active_jobs'] = Job::where('company_id', $employer_det->id)->where('status', 'active')->where('deadline', '>=', date('Y-m-d'))->count();
						$verify = User::where('id', $user->id)->where('email_verified_at', '!=', NULL)->first();
						$response['email_verified'] = (isset($verify) && $verify != null) ? 'Yes' : 'No';
						return \Response::json($response);
					}
				}
				elseif($request->method() == 'DELETE') {
					if($request->role == 'candidate') {
						switch($request->page) {
							case 'cv info':
							$delete  	= CandidateResume::where('id',$request->id)->delete();
							break;

							case 'social info':
							$delete  	= SocialLink::where('id',$request->id)->delete();
							break;

							case 'skills info':
							$user_id 	  			 		= $auth->id;
							$skills_info            		= Candidate::where('user_id',$user_id)->first();
							$inputs['candidate_id'] 		= $skills_info->id;
							$delete  	= CandidateSkill::where('candidate_id',$skills_info->id)->where('skill_id',$request->id)->delete();
							break;

							case 'language info':
							$user_id 	  			 		= $auth->id;
							$language_info            		= Candidate::where('user_id',$user_id)->first();
							$inputs['candidate_id'] 		= $language_info->id;
							$delete  	= CandidateLanguages::where('candidate_id',$language_info->id)->where('candidate_language_id',$request->id)->delete();
							break;

						}
						if($delete){
							$status 			 = 200;
							$response['message'] = $request->page.' Deleted Successfully!';
						}else{
							$status = 500;
							$response['message'] = $request->page.' id missing';
						}
						return \Response::json($response,$status);
					}
				}
			}
		}else{
			$response['message'] = "Role is required";
			return \Response::json($response);
		}
	}

	public function getprofile(Request $request)
	{
		
		$user = new UserController();
		$auth = $user::getUserID();
		if($request->role == 'candidate'){
			$response['Experiences']  	= DataArrayHelper::langExperiencesArray();
			$response['education'] 		= DataArrayHelper::langEducationArray();
			$response['nationalities']  = DataArrayHelper::langNationalityArray();
			$response['professions']  	= DataArrayHelper::langProfessionArray();
			// print_r($response['professions']); exit;
			$response['Skills'] 		= DataArrayHelper::langSkillArray();
			$response['languages']  	= DataArrayHelper::langLanguageArray();
			$response['job_alert']  	= DataArrayHelper::langJobAlertArray();
			return \Response::json($response);
		}
		if($request->role == 'employer'){
			$response['organization_types']  	= DataArrayHelper::langOrganizationtypeArray();
			$response['industry_types'] 		= DataArrayHelper::langIndustrytypeArray();
			$response['teamsize']  = DataArrayHelper::langTeamsizeArray();
			// $response['professions']  	= DataArrayHelper::langProfessionArray();
			// // print_r($response['professions']); exit;
			// $response['Skills'] 		= DataArrayHelper::langSkillArray();
			// $response['languages']  	= DataArrayHelper::langLanguageArray();
			// $response['job_alert']  	= DataArrayHelper::langJobAlertArray();
			return \Response::json($response);
		}
	}


	public function loadMasterDatas(Request $request)
	{
		$rules['role'] = 'required|in:employer,candidate';
		$this->validateDatas($request->all(),$rules);
		$en = $request->language;

		if ($request->role == 'employer') {

			$arr['genders'] = \App\Gender::find(1)->where('lang','=',$en)->where('is_active','=','1')->pluck('gender', 'gender_id');
			$arr['industries'] = \App\Industry::find(1)->where('lang','=',$en)->where('is_active','=','1')->pluck('industry', 'industry_id');
			$arr['ownershipTypes'] = \App\OwnershipType::find(1)->where('lang','=',$en)->where('is_active','=','1')->pluck('ownership_type', 'ownership_type_id');

		} else {

			$arr['maritalStatuses'] = \App\MaritalStatus::find(1)->where('lang','=',$en)->where('is_active','=','1')->pluck('marital_status', 'marital_status_id');
			$arr['jobExperiences'] = \App\JobExperience::find(1)->where('lang','=',$en)->where('is_active','=','1')->pluck('job_experience', 'job_experience_id');
			$arr['functionalArea'] = \App\FunctionalArea::find(1)->where('lang','=',$en)->where('is_active','=','1')->pluck('functional_area', 'functional_area_id');

		}
		$arr['countries'] = \App\Country::find(1)->where('lang','=',$en)->where('is_active','=','1')->pluck('country', 'country_id');
		$arr['nationality'] = \App\Country::find(1)->where('lang','=',$en)->where('is_active','=','1')->pluck('nationality', 'country_id');


		if ($arr) {
			$response['message'] = 'success';
			$status = 200;
			$response['data'] = $arr;
		} else {
			$status = 404;
			$response['message'] =  'No data found!';
		}
		return \Response::json($response,$status);
	}

	public function loadStateDatas(Request $request)
	{
		$rules['country_id'] = 'required|numeric';
		$this->validateDatas($request->all(),$rules);

		$status = 404;
		$response['message'] =  'No data found!';

		$arr = \App\State::find(1)->where('country_id','=',$request->country_id)->pluck('state', 'state_id');
		if (count($arr) > 0 ) {
			$response['message'] = 'success';
			$status = 200;
			$response['states'] = $arr;
		}
		return \Response::json($response,$status);
	}

	public function loadCityDatas(Request $request)
	{
		$rules['state_id'] = 'required|numeric';
		$this->validateDatas($request->all(),$rules);

		$status = 404;
		$response['message'] =  'No data found!';

		$arr = \App\City::find(1)->where('state_id','=',$request->state_id)->pluck('city', 'city_id');
		if (count($arr) > 0 ) {
			$response['message'] = 'success';
			$status = 200;
			$response['cities'] = $arr;
		}
		return \Response::json($response,$status);
	}

	public function getPublicProfile(Request $request)
	{

		$rules['role'] = 'required|in:employer,candidate';
		$this->validateDatas($request->all(),$rules);

		if ($request->role == 'employer') {

			//need to get current jobs count?????
			$profile = \App\Company::where('companies.id', \Auth::id())
			->leftJoin('industries', 'companies.industry_id', '=', 'industries.industry_id')
			->select('companies.id','companies.name','companies.email','companies.created_at','companies.location','companies.phone','companies.email','companies.fax','companies.website','companies.facebook','companies.twitter','companies.linkedin','companies.google_plus','companies.pinterest','companies.verified','companies.no_of_employees','companies.established_in','companies.description','companies.map','companies.established_in','companies.logo as image',  'industries.industry')->first();
			$fold = "company_logos";

		} else {
			$model = '\App\User';
			$profile = \App\User::where('users.id', \Auth::id())
			->leftJoin('cities', 'cities.city_id', '=', 'users.city_id')
			->leftJoin('states', 'states.state_id', '=', 'users.state_id')
			->leftJoin('countries', 'countries.country_id', '=', 'users.country_id')
			->leftJoin('genders', 'genders.gender_id', '=', 'users.gender_id')
			->leftJoin('marital_statuses', 'marital_statuses.marital_status_id', '=', 'users.marital_status_id')
			->leftJoin('job_experiences', 'job_experiences.job_experience_id', '=', 'users.job_experience_id')
			->leftJoin('career_levels', 'career_levels.career_level_id', '=', 'users.career_level_id')

			->select(DB::raw('concat(users.first_name," ",users.last_name) as name'),'users.image','users.created_at','users.phone','users.mobile_num','users.email','users.street_address','users.verified','users.is_immediate_available',
				DB::raw('concat(users.current_salary," ",users.salary_currency) as current_salary'),
				DB::raw('concat(users.expected_salary," ",users.salary_currency) as expected_salary'),'genders.gender','marital_statuses.marital_status',
				'job_experiences.job_experience','career_levels.career_level',
				DB::raw('concat(cities.city,", ",states.state,", ",countries.country) as location'),
				DB::raw('TIMESTAMPDIFF(YEAR, DATE(users.date_of_birth), current_date) AS age'))->first();
			$fold = "user_images";

		}

		$profile['formattedDate'] = 'Member Since, '.Carbon::parse($profile['created_at'])->format('M d, Y');
		unset($profile['created_at']);
		$profile['picture']=url('/').'/'.$fold.'/'.$profile['image'];


		if($profile){
			$response['message'] = 'success';
			$status = 200;
			$response['data'] = $profile;
		} else {
			$status = 404;
			$response['message'] =  'No data found!';
		}
		return \Response::json($response,$status);
	}

	public function SenderMessageList(Request $request)
    {
        $rules  = array();
        $userId = Auth::user()->id;
        $role = $request->get('role'); 
        $rules['role'] = 'required';
        $this->validateDatas($request->all(),$rules,[]);
        if($role=='candidate'){ 
        $messages = CompanyMessage::where('seeker_id', $userId)->get();
        $ids = array();
        foreach ($messages as $key => $value) {
            $ids[] = $value->company_id;
        }
        $data['companies'] = Company::whereIn('user_id', $ids)->get();
        }
        elseif($role=='employer'){
        $messages = CompanyMessage::where('company_id', $userId)->get();
        $ids = array();
        foreach ($messages as $key => $value) {
            $ids[] = $value->seeker_id;
        }
        $data['seekers'] = User::whereIn('id', $ids)->get();
        }

        return \Response::json(['status' => '200','data' => $data]);      
    }

    public function MessageDetails(Request $request)
    {
        $rules  = array();
        if($request->method() == 'POST'){
        $rules['message'] = 'required';
        $rules['role'] = 'required';
        if($request->role=='candidate'){
            $userId = Auth::user()->id;
            $rules['company_id'] = 'required';
            $this->validateDatas($request->all(),$rules,[]);
            $message = new CompanyMessage();
            $message->company_id = $request->company_id; 
            $message->message = $request->message;
            $message->seeker_id = $userId;
            $message->type = 'message';
            $message->save();
            }
        elseif($request->role=='company'){
            //$userId = Auth::guard('provider')->user()->id;
            $company_id=Auth::user()->id;
            $rules['seeker_id'] = 'required';
            $this->validateDatas($request->all(),$rules,[]);
            $message = new CompanyMessage();
            $message->company_id = $company_id; 
            $message->message = $request->message;
            $message->seeker_id = $request->seeker_id;
            $message->type = 'reply';
            $message->save();
            }
            if ($message) {
                $action         = true;
                $is_bookmark   = 1;
                $response        = "Message send";
                $status         = 200;
                }
            else {
                $response = "Refersh your page then do again.";
            }

        }
        elseif ($request->method() == 'GET'){
        $role = $request->get('role');
        $rules['role'] = 'required';
        if($role=='candidate'){
        $userId = Auth::user()->id;  
        $company_id = $request->get('company_id'); 
        $rules['company_id'] = 'required';
        $this->validateDatas($request->all(),$rules,[]);
        $messages = CompanyMessage::where('company_id', $company_id)->where('seeker_id', $userId)->get();
        $response['messages'] = $messages;      
        }
        elseif($role=='employer'){
        $company_id=Auth::/*guard('provider')->*/user()->id;
        // dd($company_id);
        $seeker_id = $request->get('seeker_id');  
        $rules['seeker_id'] = 'required';
        $this->validateDatas($request->all(),$rules);
        $messages = CompanyMessage::where('company_id', $company_id)->where('seeker_id', $seeker_id)->get();
        $response['messages'] = $messages;
        }
        }
        return \Response::json(['status' => '200','data' => $response]);
    }


    public function search(Request $request)
    {
        $response['jobs'] = Job::select("title as value", "id")
            ->where('title', 'LIKE', '%' . $request->get('search') . '%')
            ->active()
            ->withoutEdited()
            ->latest()
            ->get();
            // ->take(15);

        
        return \Response::json(['status' => '200','data' => $response]);
    }

    public function filter(Request $request)
    {
        $response = $this->getJobs($request);
        $response['indeed_jobs'] = $this->getIndeedJobs($request);
        $response['careerjet_jobs'] = $this->getCareerjetJobs($request);

        if (auth('user')->check() && auth('user')->user()->role == 'candidate') {
            $response['resumes'] = auth('user')->user()->candidate->resumes;
        } else {
            $response['resumes'] = [];
        }

        
        return \Response::json(['status' => '200','data' => $response]);
    }

     public function getJobs($request)
    {
        if (auth()->user()) {

            $query = Job::with('company.user', 'category', 'job_type:id,name')
                ->withCount([
                    'bookmarkJobs', 'appliedJobs',
                    'bookmarkJobs as bookmarked' => function ($q) {
                        $q->where('candidate_id',  auth()->user()->candidate ? auth()->user()->candidate->id : '');
                    }, 'appliedJobs as applied' => function ($q) {
                        $q->where('candidate_id',  auth()->user()->candidate ? auth()->user()->candidate->id : '');
                    }
                ])
                ->active()->withoutEdited();
        } else {

            $query = Job::with('company.user', 'category', 'job_type:id,name')
                ->withCount([
                    'bookmarkJobs', 'appliedJobs',
                    'bookmarkJobs as bookmarked' => function ($q) {
                        $q->where('candidate_id', '');
                    }, 'appliedJobs as applied' => function ($q) {
                        $q->where('candidate_id', '');
                    }
                ])
                ->withoutEdited()
                ->active();
        }

        // company search
        if ($request->has('company') && $request->company != null) {
            $company = $request->company;
            $query->whereHas('company.user', function ($q) use ($company) {
                $q->where('username', $company);
            });
        }

        // Keyword search
        if ($request->has('keyword') && $request->keyword != null) {
            $query->where('title', 'LIKE', "%$request->keyword%");
        }

        // Category filter
        if ($request->has('category') && $request->category != null) {
            $query->where('category_id', $request->category);
            // $category = $request->category;

            // $query->whereHas('category', function ($q) use ($category) {
            //     $q->where('name', $category);
            // });
        }

        // job role filter
        if ($request->has('job_role') && $request->job_role != null) {
            $query->where('role_id', $request->job_role);
            // $job_role = $request->job_role;

            // $query->whereHas('role', function ($q) use ($job_role) {
            //     $q->where('name', $job_role);
            // });
        }

        // Salery filter
        if ($request->has('price_min') && $request->price_min != null) {
            $query->where('min_salary', '>=', $request->price_min);
        }
        if ($request->has('price_max') && $request->price_max != null) {
            $query->where('max_salary', '<=', $request->price_max);
        }

         // tags filter
         if ($request->has('tag') && $request->tag != null) {
            $tag = TagTranslation::where('name', $request->tag)->first();

            if($tag){
                $query->whereHas('tags', function($q) use ($tag){
                    $q->where('job_tag.tag_id', $tag->tag_id);
                });
            }
        }

        // location
        $final_address = '';
        if ($request->has('location') && $request->location != null) {
            $adress = $request->location;
            if ($adress) {
                $adress_array = explode(" ", $adress);
                if ($adress_array) {
                    $last_two = array_splice($adress_array, -2);
                }
                $final_address = Str::slug(implode(" ", $last_two));
            }
        }
        // lat Long
        if ($request->has('lat') && $request->has('long') && $request->lat != null && $request->long != null) {
            session()->forget('selected_country');
            $ids = $this->location_filter($request);
            $query->whereIn('id', $ids)
                ->orWhere('address', $final_address ? $final_address : '')
                ->orWhere('country', $request->location ? $request->location : '');
        }

        // country
        $selected_country = session()->get('selected_country');

        if ($selected_country && $selected_country != null) {
            $country = selected_country()->name;
            $query->where('country', 'LIKE', "%$country%");
        } else {

            $setting = Setting::first();
            if ($setting->app_country_type == 'single_base') {
                if ($setting->app_country) {

                    $country = Country::where('id', $setting->app_country)->first();
                    if ($country) {
                        $query->where('country', 'LIKE', "%$country->name%");
                    }
                }
            }
        }

        // Sort by ads
        if ($request->has('sort_by') && $request->sort_by != null) {
            switch ($request->sort_by) {
                case 'latest':
                    $query->latest('id');
                    break;
                case 'featured':
                    $query->where('featured', 1)->latest();
                    break;
            }
        }

        // Experience filter
        if ($request->has('experience') && $request->experience != null) {
            $experience_id = Experience::where('name', $request->experience)->value('id');
            $query->where('experience_id', $experience_id);
        }

        // Education filter
        if ($request->has('education') && $request->education != null) {
            $education_id = Education::where('name', $request->education)->value('id');
            $query->where('education_id', $education_id);
        }

        // Work type filter
        if ($request->has('is_remote') && $request->is_remote != null) {
            $query->where('is_remote', 1);
        }

        // Job type filter
        if ($request->has('job_type') && $request->job_type != null) {
            $job_type_id = JobType::where('name', $request->job_type)->value('id');
            $query->where('job_type_id', $job_type_id);
        }

        $jobs = $query->latest()->paginate(12)->withQueryString();

        return [
            'total_jobs' => $jobs->total(),
            'jobs' => $jobs,
            // 'countries' => Country::all(['id', 'name', 'slug']),
            // 'categories' => JobCategory::all(),
            // 'job_roles' => JobRole::all(),
            'max_salary' => \DB::table('jobs')->max('max_salary'),
            'min_salary' => \DB::table('jobs')->max('min_salary'),
            // 'experiences' => Experience::all(),
            // 'educations' => Education::all(),
            // 'job_types' => JobType::all(),
            'popularTags' => $this->popularTags(),
        ];
    }
     public function popularTags()
    {
        return Tag::popular()->withCount('tags')->latest('tags_count')->get()->take(10);
    }
    public function getIndeedJobs(Request $request, $limit = null)
    {
        if (config('zakirsoft.indeed_active') && config('zakirsoft.indeed_id')) {
            $keyword = $request->keyword ?? '';
            $category = $request->category ? JobCategory::whereId($request->category)->first() : '';
            $role = $request->job_role ? JobRole::whereId($request->category)->first() : '';
            $keywords = $keyword ? $keyword : ($category ? $category->name : ($role ? $role->name : 'job'));
            $location = $request->location;

            $q       = $keywords;
            $l       = $location ?? '';
            $limit   = $limit ?? (config('zakirsoft.indeed_limit') ?? 10);
            $start   = '';
            $end     = '';
            $sort    = 'date';
            $jt      = '';
            $fromage = '';
            $radius  = '';
            $data    = array(
                'publisher' => config('zakirsoft.indeed_id'),
                'v' => 2,
                'format' => 'json',
                'q' => $q,
                'l' => $l,
                'jt' => $jt,
                'fromage' => $fromage,
                'limit' => $limit,
                'start' => $start,
                'end' => $end,
                'radius' => $radius,
                'sort' => $sort,
                'highlight' => 1,
                'filter' => 1,
                // 'latlong' => 1,
                // 'co' => 'uk',
                // 'co' => 'United Kingdom'
            );
            $param   = http_build_query($data) . "\n";
            $url     = 'http://api.indeed.com/ads/apisearch?' . $param;

            header('Content-type: application/json');
            $obj = file_get_contents($url);
            $json_decode = json_decode($obj);
            return $json_decode;
        }
    }

    public function getCareerjetJobs(Request $request, $pagesize = null)
    {
        if (config('zakirsoft.careerjet_active') && config('zakirsoft.careerjet_id')) {
            $keyword = $request->keyword ?? '';
            $category = $request->category ? JobCategory::whereId($request->category)->first() : '';
            $role = $request->job_role ? JobRole::whereId($request->category)->first() : '';
            $keywords = $keyword ? $keyword : ($category ? $category->name : ($role ? $role->name : 'job'));
            $location = $request->location;

            $page = 1;
            $pagesize =  $pagesize ?? (config('zakirsoft.careerjet_limit') ?? 10);
            $result = $this->search(array(
                'keywords' => $keywords ?? '',
                'location' => $location ?? '',
                'page' => $page,
                'sort' => 'date',
                'pagesize' => $pagesize,
                'affid' => config('zakirsoft.careerjet_id'),
            ));

            return $result;
        }
    }
    public function location_filter($request)
    {
        $latitude = $request->lat;
        $longitude = $request->long;

        if ($request->has('radius') && $request->radius != null) {
            $distance = $request->radius;
        } else {
            $distance = 50;
        }

        $haversine = "(
                    6371 * acos(
                        cos(radians(" . $latitude . "))
                        * cos(radians(`lat`))
                        * cos(radians(`long`) - radians(" . $longitude . "))
                        + sin(radians(" . $latitude . ")) * sin(radians(`lat`))
                    )
                )";

        $data = Job::select('id')->selectRaw("$haversine AS distance")
            ->having("distance", "<=", $distance)->get();

        $ids = [];

        foreach ($data as $id) {
            array_push($ids, $id->id);
        }

        return $ids;
    }

    public function deleteAccount(Request $request)
   {

       $user = new UserController();
       $auth = $user::getUserID();
       if($request->role == 'candidate'){
               $delete = User::where('id',$auth->id)->delete();
       }
       if($request->role == 'employer'){
               $delete = User::where('id',$auth->id)->delete();
       }
       if($delete){
       $status                          = 200;
       $response['message'] = 'Account Deleted Successfully!';
       }else{
       $status = 422;
       $response['message'] = 'User id missing';
       }
       return \Response::json($response,$status);
   }


}

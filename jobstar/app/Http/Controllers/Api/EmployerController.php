<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Traits\Jobable;
use App\Models\JobRole;
use App\Models\Candidate;
//use App\Http\Controllers\UserController;
use App\Models\Company;
use App\Models\Setting;
use App\Models\User;
use App\Models\Job;
use App\Models\Education;
use App\Models\Experience;
use App\Models\JobType;
use App\Models\JobCategory;
use App\Models\SalaryType;
use App\Models\Benefit;
use App\Models\Tag;
use App\Models\Admin;

use App\Models\UserPlan;
use App\Models\CandidateResume;
use App\Models\Profession;
use App\Models\Skill;
use App\Models\CandidateLanguage;
use App\Models\CompanyBookmarkCategory;
use App\Models\ApplicationGroup;
use Modules\Location\Entities\Country;
use Modules\Location\Entities\State;
use App\Http\Traits\HasCountryBasedJobs;
use App\Http\Traits\Candidateable;
use App\Traits\ResetCvViewsHistoryTrait;
use App\Http\Traits\CompanyJobTrait;
use App\Services\Website\IndexPageService;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Validator;
use App\Notifications\Website\Candidate\ApplyJobNotification;
use App\Notifications\Website\Candidate\BookmarkJobNotification;
use App\Notifications\Admin\NewJobAvailableNotification;
use App\Notifications\Website\Company\JobCreatedNotification;
use App\Notifications\Website\Company\CandidateBookmarkNotification;

use Modules\Plan\Entities\Plan;

use Modules\Language\Entities\Language;
use App\Models\JobRoleTranslation;
use App\Models\JobCategoryTranslation;

use Carbon\Carbon;
use Auth;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use App\Models\Earning;
use App\Models\AppliedJob;


class EmployerController extends Controller
{
       use Jobable, Candidateable, ResetCvViewsHistoryTrait, HasCountryBasedJobs, CompanyJobTrait;

    /*********** Employer process **********/

	public function emplo_job_list(Request $request){

		$query = auth()
            ->user()
            ->company
            ->jobs()->withCount('appliedJobs')->withoutEdited();
        // status search
        /*if ($request->has('status') && $request->status != null) {
            $query->where('status', $request->status);
        }

        // status search
        if ($request->has('apply_on') && $request->apply_on != null) {
            $query->where('apply_on', $request->apply_on);
        }*/

        $myJobs = $query->with('job_type:id,name')->latest()->paginate(12)->withQueryString();

        foreach ($myJobs as $job) {

        	$job->description = strip_tags($job->description);
            $job->compnay = $job->getCompanyDetailAttribute();
            if ($job->days_remaining < 1) {
                $job->update([
                    'status' => 'expired',
                    'deadline' => null
                ]);
            };
        }

	   if($myJobs->isNotEmpty()){
			$response['message'] = 'success';
			$status = 200;
			$response['data'] = $myJobs;
		} else {
			$status = 404;
			$response['message'] =  'No data found!';
		}
		return \Response::json($response,$status);
	}

	public function emplo_job_det(Request $request){

		$job_detail =  Job::with(['benefits','tags','job_type','education','experience','role',
		'company'])

		->find($request->job_id);
		if($job_detail != ''){
			$job_detail->description = strip_tags($job_detail->description);
			// $job_detail->country = $job_detail->getCountryNewAttribute();
			$job_detail->append(['country_new', 'region_new', 'salary_type', 'job_category']);
		}

		$response['message'] = 'success';
		$status = 200;
		$response['data'] = $job_detail;
		return \Response::json($response,$status);
	}

	public function emplo_job_create(Request $request){
            $userplan = auth()->user()->company->userplan;
        if(!empty($userplan)){
			if(\Route::current()->getName() == 'job_create'){
				if ((int) $userplan->job_limit < 1 ) {
						return response()->json(['message' => __('you_have_reached_your_plan_limit_please_upgrade_your_plan')]);
				}
			}
		}elseif(empty($userplan)){
			return response()->json(['message' => 'Please Purchase Plan'],422);
		}
			// $data['countries'] = Country::all();
			// $data['states'] = State::all();
		    $data['countries'] = array();
			$data['states'] = array();
			$data['companies'] = Company::all();
			$data['job_category'] = JobCategory::all();
			$data['job_roles'] = JobRole::all();
			$data['experiences'] = Experience::all();
			$data['job_types'] = JobType::all();
			$data['salary_types'] = SalaryType::all();
			$data['educations'] = Education::all();
			$data['benefits'] = Benefit::all();
			$data['tags'] = Tag::all();
			$data['jobs'] = '';
			$data['status'] = 'create_page';
			if($request->job_id){
				$data['jobs'] = Job::with(['benefits','tags','job_type:id,name','education:id,name','experience:id,name','role','company.user.contactInfo','company.team_size','company.user.socialInfo'])
				->find($request->job_id);
				$data['status'] = 'edit_page';
			}

		$response['message'] = 'success';
		$status = 200;
		$response['data'] = $data;

		return \Response::json($response,$status);
	}
	public function emplo_job_save(Request $request){

		$validator = Validator::make($request->all(),[
			'title' => 'required',
            'category_id' => 'required',
			'role_id' => 'required',
			'job_type' => 'required',
			'salary_type' => 'required',
            'salary_mode' => 'required',
			'min_salary' => 'numeric|between:0,'.$request->max_salary.',required_if:salary_mode,range',
			'max_salary' => 'numeric|min:'.$request->min_salary.',required_if:salary_mode,range',
			'custom_salary' => 'required_if:salary_mode,custom',
			'education' => 'required',
            'experience' => 'required',
			'vacancies' => 'required',
			'apply_email' => 'required_if:apply_on,email',
			'apply_url' => 'required_if:apply_on,custom_url',
			'deadline' => 'required',
			'description' => 'required',
            'country' => 'required',
			'region' => 'required',
            'lat' => 'required',
			'long' => 'required',

		]);

		/*if($validator->fails())
		{
			return response()->json(['message'=>$validator->messages()],422);
		}*/

		if($validator->fails())
		{
			$response['message'] = $validator->errors()->first();
			$response['status_code'] = 422;
			return \Response::json($response);
		}

		/******* Job store in database ******/

		$message = $this->job_create_detail($request);
		return response()->json(['message' => $message]);
	}

	public function emplo_job_update(Request $request){

		// Highlight & featured
        $highlight = $request->badge == 'highlight' ? 1 : 0;
        $featured = $request->badge == 'featured' ? 1 : 0;

		$validator = Validator::make($request->all(),[
			'title' => 'required',
            'category_id' => 'required',
			'role_id' => 'required',
			'job_type' => 'required',
			'salary_type' => 'required',
            'salary_mode' => 'required',
			'min_salary' => 'numeric|between:0,'.$request->max_salary.',required_if:salary_mode,range',
			'max_salary' => 'numeric|min:'.$request->min_salary.',required_if:salary_mode,range',
			'custom_salary' => 'required_if:salary_mode,custom',
			'education' => 'required',
            'experience' => 'required',
			'vacancies' => 'required',
			'apply_email' => 'required_if:apply_on,email',
			'apply_url' => 'required_if:apply_on,custom_url',
			'deadline' => 'required',
			'description' => 'required',

            'country' => 'required',
			'region' => 'required',
            'lat' => 'required',
			'long' => 'required',

		]);

		/*if($validator->fails())
		{
			return response()->json(['message'=>$validator->messages()],422);
		}*/

		if($validator->fails())
		{
			$response['message'] = $validator->errors()->first();
			$response['status_code'] = 422;
			return \Response::json($response);
		}

		$jobCreated = Job::where('id', $request->id)->update([
			   'title' => $request->title,
				'company_id' => auth()->user()->company->id,
				'category_id' => $request->category_id,
				'role_id' => $request->role_id,
				'salary_mode' => $request->salary_mode,
				'custom_salary' => $request->custom_salary,
				'min_salary' => $request->min_salary,
				'max_salary' => $request->max_salary,
				'salary_type_id' => $request->salary_type,
				// 'deadline' => Carbon::createFromFormat('d/m/Y', $request->deadline)
                //                 ->format('Y-m-d'),
                'deadline' => $request->deadline,
				'education_id' => $request->education,
				'experience_id' => $request->experience,
				'job_type_id' => $request->job_type,
				'vacancies' => $request->vacancies,
				'apply_on' => $request->apply_on,
				'apply_email' => $request->apply_email ?? null,
				'apply_url' => $request->apply_url ?? null,
				'description' => $request->description,

               // 'address' => Str::slug($request->region . '-' . $request->country),
               'address' => $request->address,
				'locality' => $request->locality,
				'place' => $request->place,
				'district' => $request->district,
				'postcode' => $request->postcode,
				'region' => $request->region,
				'country' => $request->country,
				'region' => $request->region,
				'lat' => $request->lat ,
				'long' => $request->long,

			]
		);
		$jobs = Job::where('id',$request->id)->first();
		
		 $job = $this->update_job($request, $jobs);
		
		 if ($request->benefits){
			$this->jobBenefitsSync($request->benefits, $job);
		} else {
			//  When benefits all removed benefit deleted
			$jobCreated->benefits()->detach();
		}


        // Tags
        if ($request->tags) {
            $this->jobTagsSync($request->tags, $job);
        } else {
			//  When benefits all removed tag deleted
			$jobCreated->tags()->detach();
		}

		  // Location
        /* $location = session()->get('location');
        if ($location) {
            updateMap($job);
        } */

			if (setting('edited_job_auto_approved')) {
				$message = __('job_updated_successfully');
			} else {
				if ($job->waiting_for_edit_approval) {
					Notification::send(auth()->user(), new EditApproveNotification($job));

					if (checkMailConfig()) {
						// make notification to admins for approved
						$admins = Admin::all();
						foreach ($admins as $admin) {
							Notification::send($admin, new NewEditedJobAvailableNotification($admin, $job));
						}
					}
					$message = __('your_job_successfully_updated_please_wait_for_approve_changes');
				} else {
					$message = __('job_updated_successfully');
				}
			}

		return response()->json(['message' => $message]);

	}
	public function job_create_detail(Request $request){

		// Highlight & featured
        $highlight = $request->badge == 'highlight' ? 1 : 0;
        $featured = $request->badge == 'featured' ? 1 : 0;

		$jobCreated = Job::Create(
			[
			   'title' => $request->title,
				'company_id' => auth()->user()->company->id,
				'category_id' => $request->category_id,
				'role_id' => $request->role_id,
				'salary_mode' => $request->salary_mode,
				'custom_salary' => $request->custom_salary,
				'min_salary' => $request->min_salary,
				'max_salary' => $request->max_salary,
				'salary_type_id' => $request->salary_type,
				// 'deadline' => Carbon::createFromFormat('d/m/Y', $request->deadline)
                //                 ->format('Y-m-d'),
                'deadline' => $request->deadline,
				'education_id' => $request->education,
				'experience_id' => $request->experience,
				'job_type_id' => $request->job_type,
				'vacancies' => $request->vacancies,
				'apply_on' => $request->apply_on,
				'apply_email' => $request->apply_email ?? null,
				'apply_url' => $request->apply_url ?? null,
				'description' => $request->description,
                // 'address' => Str::slug($request->region . '-' . $request->country),
                'address' => $request->address,
				'locality' => $request->locality,
				'place' => $request->place,
				'district' => $request->district,
				'postcode' => $request->postcode,
				'region' => $request->region,
				'country' => $request->country,
				'region' => $request->region,
				'lat' => $request->lat ,
				'long' => $request->long,

			]
		);

		if ($request->benefits){
			$this->jobBenefitsInsert($request->benefits, $jobCreated);
		}


        // Tags
        if ($request->tags) {
            $this->jobTagsInsert($request->tags, $jobCreated);
        }
		  // Location
       /* $location = session()->get('location');
        if ($location) {
            updateMap($job);
        } */

		 if (session('job_payment_type') != 'per_job') {
			$user_plan = auth()->user()->company->userPlan()->first();
			$user_plan->job_limit = $user_plan->job_limit - 1;
			if ($featured) {
				$user_plan->featured_job_limit = $user_plan->featured_job_limit - 1;
			}
			if ($highlight) {
				$user_plan->highlight_job_limit = $user_plan->highlight_job_limit - 1;
			}
			$user_plan->save();

		}

		// storePlanInformation();
		session(['user_plan' => auth()->user()->company->userPlan]);


		Notification::send(auth()->user(), new JobCreatedNotification($jobCreated));

		if (checkMailConfig()) {
			// make notification to admins for approved
			$admins = Admin::all();
			foreach ($admins as $admin) {
				Notification::send($admin, new NewJobAvailableNotification($admin, $jobCreated));
			}
		}
		$message = $jobCreated->status == 'active' ? __('job_has_been_created_and_published') : __('job_has_been_created_and_waiting_for_admin_approval');
		return $message;
	}
	public function emplo_job_delete(Request $request){
		$job = Job::find($request->job_id);
		if(auth()->user()->company->id != $job->company_id){
			
			return response()->json(['error' => __('Your don`t permission to  access function ')]);
		}
		$job->delete();

		return response()->json(['message' => __('Successfully Job Deleted')]);
	}
    public function emplo_applicant(Request $request){

		// $job = Job::find($request->job_id);
		$status = $request->status ? $request->status:'';
		$application_groups = auth()->user()
            ->company
             ->filter_application($status)
            ->with(['applications' => function ($query) use ($request) {
                $query->where('job_id', $request->job_id)
				->with(['candidate' => function ($query) {
                    return $query->select('id', 'user_id', 'profession_id', 'experience_id', 'education_id')
                        ->with('profession', 'education:id,name', 'experience:id,name', 'user:id,name,username,image');
                } ]);
            }])
            ->get()->map(function($data){
                $data->group_id = (string)$data->id;
                return $data;
            });;

		$data = [
			'app_group' => $application_groups
		];
	   return \Response::json($data);
	}
	public function emplo_applicant_save_group(Request $request){

		$validator = Validator::make($request->all(),[
			'application_group_id' => 'required',
            'applications_id' => 'required',
            'job_id'=> 'required',
			]);

		/*if($validator->fails())
		{
			return response()->json(['message'=>$validator->messages()],422);
		}*/

		if($validator->fails())
		{
			$response['message'] = $validator->errors()->first();
			$response['status_code'] = 422;
			return \Response::json($response);
		}

		$company = auth()->user()->company;

        $applications = AppliedJob::where('id', $request->applications_id)
                        //->where('application_group_id', $request->application_group_id)
                        ->where('job_id', $request->job_id)
                        ->first();
		if ($applications) {
			$applications->update([
			'order' => 1,
			'application_group_id' => $request->application_group_id,
			]);
			$message = 'Saved Successfully!';
		} else {
			$message = 'No data found!';
		}

		$response['message'] = $message;
		$status = 200;
		return \Response::json($response,$status);
	}
    public function emplo_app_detail(Request $request){

		$candidate = User::select('name','id')->where('id', $request->user_id)
            ->with(['contactInfo', 'socialInfo',
					'candidate' => function ($query) {
						$query->with('experiences', 'educations', 'experience', 'education', 'profession','languages:id,name', 'skills');

					}
				])
            ->first();
           // dd($candidate);
        $candidate->candidate->birth_date = !empty($candidate->candidate->birth_date) ? Carbon::parse($candidate->candidate->birth_date)->format('d F, Y') : '';
        /********** Resume view ********/
        $user_plan = auth()->user()->company->userPlan()->first();
		if ($user_plan->candidate_cv_view_limitation == 'limited' && $request->count_view) {
            $company = auth()->user()->company;
            $cv_views = $company->cv_views; // get auth company all cv views
            $cv_view_exist = $cv_views->where('candidate_id', $candidate->candidate->id)->first(); // get specific view

            if (!$cv_view_exist) { // check view isn't exist
                isset($user_plan) ? $user_plan->decrement('candidate_cv_view_limit') : ''; // point reduce
                // and create view count item
                $company->cv_views()->create([
                    'candidate_id' => $candidate->candidate->id,
                    'view_date' => Carbon::parse(Carbon::now()),
                ]);
            }
        }

        $languages = $candidate->candidate->languages()->pluck('name')->toArray();
        $candidate_languages = $languages ? implode(", ", $languages) : '';

        $skills = $candidate->candidate->skills->pluck('name');
        $candidate_skills = $skills ? implode(", ", json_decode(json_encode($skills))) : '';

		return \Response::json($candidate);

	}
     public function emplo_jobClone(Request $request)
    {
		$job = Job::find($request->job_id);

        $user = auth()->user();
        $user_plan = $user->company->userPlan;

        if (!$user_plan->job_limit) {
            return response()->json(['error'=> __('you_have_reached_your_plan_limit_please_upgrade_your_plan')],400);
        }

        $newJob = $job->replicate();
        $newJob->created_at = now();

        if ($job->featured && $user_plan->featured_job_limit) {
            $newJob->featured = 1;
            $user_plan->featured_job_limit = $user_plan->featured_job_limit - 1;
        } else {
            $newJob->featured = 0;
        }

        if ($job->highlight && $user_plan->highlight_job_limit) {
            $newJob->highlight = 1;
            $user_plan->highlight_job_limit = $user_plan->highlight_job_limit - 1;
        } else {
            $newJob->highlight = 0;
        }

        $newJob->save();
        $user_plan->job_limit = $user_plan->job_limit - 1;
        $user_plan->save();
        //storePlanInformation();
		return response()->json(['success' => __('Successfully Job Cloned')]);
    }

	public function emplo_ppjobsave(Request $request){

		$validator = Validator::make($request->all(),[
			'title' => 'required',
            'category_id' => 'required',
			'role_id' => 'required',
			'job_type' => 'required',
			'salary_type' => 'required',
            'salary_mode' => 'required',
			'min_salary' => 'numeric|between:0,'.$request->max_salary.',required_if:salary_mode,range',
			'max_salary' => 'numeric|min:'.$request->min_salary.',required_if:salary_mode,range',
			'custom_salary' => 'required_if:salary_mode,custom',
			'education' => 'required',
            'experience' => 'required',
			'vacancies' => 'required',
			'apply_email' => 'required_if:apply_on,email',
			'apply_url' => 'required_if:apply_on,custom_url',
			'deadline' => 'required',
			'description' => 'required',
            'country' => 'required',
			'region' => 'required',
            'lat' => 'required',
			'long' => 'required',

		]);

		/*if($validator->fails())
		{
			return response()->json(['message'=>$validator->messages()],422);
		}*/

		if($validator->fails())
		{
			$response['message'] = $validator->errors()->first();
			$response['status_code'] = 422;
			return \Response::json($response);
		}

		/******* Job store in database ******/

		$message = $this->job_create_detail($request);
		return response()->json(['success' => $message]);
	}
    public function emplo_jobfeat(Request $request){

		$userplan = auth()->user()->company->userplan;
		$setting = Setting::first();

		$job = Job::find($request->job_id);

		if($job->featured){
		// dd($job);
			return response()->json(['error' => __('job_already_highlighted')]);
		}
		else if ($userplan->featured_job_limit) {
			$userplan = auth()->user()->company->userplan;
			$userplan->featured_job_limit = $userplan->featured_job_limit - 1;
			$userplan->save();

			$featured_days = $setting->featured_job_days > 0 ? now()->addDays($setting->featured_job_days)->format('Y-m-d'):null;

            $job->update([
                'featured' => 1,
                'highlight' => 0,
                'featured_until' => $featured_days,
                'highlight_until' => null,
            ]);
			return response()->json(['success' => __('featured_job_added_successfully')]);
		} else {
			return response()->json(['error' => __('you_have_no_feature_job_limit')]);
		}

	}
	public function emplo_jobhigh(Request $request){

		$userplan = auth()->user()->company->userplan;

		$setting = Setting::first();
		$job = Job::find($request->job_id);

		if($job->highlight){
			return response()->json(['error' => __('job_already_highlighted')]);
		}
		else if ($userplan->highlight_job_limit) {
			$userplan->highlight_job_limit = $userplan->highlight_job_limit - 1;
			$userplan->save();


			$highlight_days = $setting->highlight_job_days > 0 ? now()->addDays($setting->highlight_job_days)->format('Y-m-d'):null;

            $job->update([
                'featured' => 0,
                'highlight' => 1,
                'highlight_until' => $highlight_days,
                'featured_until' => null,
            ]);

			return response()->json(['success' => __('job_highlighted_successfully')]);

		}
		 else {
			return response()->json(['error' => __('you_have_no_highlight_job_limit')]);
		}

	}
    	public function emplo_exp_status(Request $request){

		$job = Job::find($request->job_id);
		if($job->company_id != auth()->user()->company->id){
			return response()->json(['error' => __('Your don`t permission to  access function ')]);
		}


		if($job->status == $request->status){
			return response()->json(['error' => __('job_status_already_'.$request->status)]);
		}

		 $job->update([
			'status' => $request->status,
		]);


		if($job->status == 'expired'){
			$message = __('job_status_now_expire');
		}	else {
			$message = __('job_status_now_active');
		}

		$response['message'] = $message;
		$status = 200;

		return \Response::json($response,$status);

	}
    public function emplo_comp_detail(Request $request)
    {

		$companyDetails =  Company::with(
            'organization:id,name',
            'industry',
            'team_size:id,name',
			'user.contactInfo'
        )->where('id', auth()->user()->company->id)->withCount([
            'jobs as activejobs' => function ($q) {
                $q->where('status', true);
                $q->where('deadline', '>=', Carbon::now()->toDateString());
			}
        ])
		->first();

		if($companyDetails != '' && $companyDetails != null){
			$companyDetails->bio = strip_tags($companyDetails->bio);
			$companyDetails->vision = strip_tags($companyDetails->vision);
		}


		$data = [
			'comp_detail' => $companyDetails,

		];
	   return \Response::json($data);
	}

    public function emplo_find_candi(Request $request)
    {
		$data['professions'] = Profession::all();
        $data['candidates'] = $this->get_candidates($request);
        $data['countries'] = Country::all();
        $data['experiences'] = Experience::all();
        $data['educations'] = Education::all();
        $data['skills'] = Skill::all();
        $data['candidate_languages'] = CandidateLanguage::all(['id', 'name']);

		// reset candidate cv views history
		$this->reset();

		return \Response::json($data);

	}
	public function emplo_candi_resume(Request $request)
    {
        $user = auth()->user();

        if ($user->role != 'company') {
            return response()->json([
                'message' => __('you_are_not_authorized_to_perform_this_action'),
                'success' => false
            ]);
        } else {
            $user_plan = $user->company->userPlan;
        }
        if(!$user_plan){
            return response()->json([
                'message' => __('you_dont_have_a_chosen_plan_please_choose_a_plan_to_continue'),
                'success' => false
            ]);
        }

        if (isset($user_plan) && $user_plan->candidate_cv_view_limitation == 'limited' && $user_plan->candidate_cv_view_limit <= 0) {
            return response()->json([
                'message' => __('you_have_reached_your_limit_for_viewing_candidate_cv_please_upgrade_your_plan'),
                'success' => false,

            ]);
        }

        $candidate = User::where('id', $request->user_id)
            ->with(['contactInfo', 'socialInfo', 'candidate' => function ($query) {
                $query->with('experience', 'education', 'experiences', 'educations', 'profession','languages:id,name', 'skills', 'appliedJobs')
                    ->withCount(['bookmarkCandidates as bookmarked' => function ($q) {
                        $q->where('company_id',  auth()->user()->company->id);
                    }])
                    ->withCount(['already_views as already_view' => function ($q) {
                        $q->where('company_id', auth()->user()->company->id);
                    }]);
            }])
            ->firstOrFail();
            if($candidate->candidate->appliedJobs->isNotEmpty()){
	            $a_job = \DB::table('applied_jobs')->where('job_id', $candidate->candidate->appliedJobs[0]->id)->where('candidate_id', $candidate->candidate->id)->pluck('candidate_resume_id')->first();
	            $resume = CandidateResume::where('id', $a_job)->first();
	            $resume->resume_url = $resume->getResumeUrlAttribute();
	        }
            $category = \DB::table('bookmark_company')->where('candidate_id',$candidate['candidate']->id)->first();
        $candidate->candidate->birth_date = !empty($candidate->candidate->birth_date) ? Carbon::parse($candidate->candidate->birth_date)->format('d F, Y') : '';

        if ($user_plan->candidate_cv_view_limitation == 'limited' && $request->count_view) {

            $company = auth()->user()->company;
            $cv_views = $company->cv_views; // get auth company all cv views
            $cv_view_exist = $cv_views->where('candidate_id', $candidate->candidate->id)->first(); // get specific view

            if (!$cv_view_exist) { // check view isn't exist
                isset($user_plan) ? $user_plan->decrement('candidate_cv_view_limit') : ''; // point reduce
                // and create view count item
                $company->cv_views()->create([
                    'candidate_id' => $candidate->candidate->id,
                    'view_date' => Carbon::parse(Carbon::now()),
                ]);
            }
        }

        $cv_limit_message = $user_plan->candidate_cv_view_limitation == 'limited' ? 'You have ' . $user_plan->candidate_cv_view_limit . ' cv views remaining.' : null;

        $languages = $candidate->candidate->languages()->pluck('name')->toArray();
        $candidate_languages = $languages ? implode(", ", $languages) : '';

        $skills = $candidate->candidate->skills->pluck('name');
        $candidate_skills = $skills ? implode(", ",  json_decode(json_encode($skills), true)) : '';
        $empty_obj = (object) ['id' => 0, 'candidate_id' => 0, 'name' => '', 'file' => '', 'created_at' => '', 'updated_at' => '', 'resume_url' => '', 'file_size' => ''];

        return response()->json([
            'success' => true,
            'data' => $candidate,
            'skills' => $candidate_skills ?? '',
            'languages' => $candidate_languages ?? '',
            'profile_view_limit' => $cv_limit_message,
            'category'=>$category,
            'applied_resume' => $resume ?? $empty_obj
        ]);
    }
    	public function emplo_noti(Request $request)
    {
		$noti = auth()->user()->notifications()->paginate(20);

		  foreach ($noti as $key =>$sinnoti){
		$format = array();

		switch ($sinnoti->type) {

				case 'App\Notifications\Website\Candidate\ApplyJobNotification':

					$format['title'] = $sinnoti->data['title'];
					$format['list'] = Str::remove(url('/company/'), $sinnoti->data['url']);
					$format['create_at'] = $sinnoti->created_at->diffForHumans();
					$format['read_at'] = $sinnoti->read_at ? $sinnoti->read_at->diffForHumans() : '';
					break;
				case 'App\Notifications\Website\Candidate\BookmarkJobNotification':

					$format['title'] = $sinnoti->data['title'];
					$format['list'] = Str::remove(url('/company/'), $sinnoti->data['url']);
					$format['create_at'] = $sinnoti->created_at->diffForHumans();
					$format['read_at'] = $sinnoti->read_at ? $sinnoti->read_at->diffForHumans() : '';
					break;
				case 'App\Notifications\Website\Company\JobCreatedNotification':

					$format['title'] = $sinnoti->data['title'];
					$format['list'] = Str::remove(url('/jobs/'), $sinnoti->data['url']);
					$format['create_at'] = $sinnoti->created_at->diffForHumans();
					$format['read_at'] = $sinnoti->read_at ? $sinnoti->read_at->diffForHumans() : '';
					break;
				case 'App\Notifications\Website\Company\EditApproveNotification':

					$format['title'] = $sinnoti->data['title'];
					$format['list'] = Str::remove(url('/company/'), $sinnoti->data['url']);
					$format['create_at'] = $sinnoti->created_at->diffForHumans();
					$format['read_at'] = $sinnoti->read_at ? $sinnoti->read_at->diffForHumans() : '';

					break;
				case 'App\Notifications\Website\Company\JobDeletedNotification':

					$format['title'] = $sinnoti->data['title'];
					$format['list'] = Str::remove(url('/'), $sinnoti->data['url']);
					$format['create_at'] = $sinnoti->created_at->diffForHumans();
					$format['read_at'] = $sinnoti->read_at ? $sinnoti->read_at->diffForHumans() : '';
					break;
				case 'App\Notifications\JobApprovalNotification':

					$format['title'] = $sinnoti->data['title'];
					$format['list'] = Str::remove(url('/jobs/'), $sinnoti->data['url']);
					$format['create_at'] = $sinnoti->created_at->diffForHumans();
					$format['read_at'] = $sinnoti->read_at ? $sinnoti->read_at->diffForHumans() : '';
					break;
				default:
					unset($sinnoti[$key]);
				}
				$sinnoti->data = $format;
		}
		if($noti->isNotEmpty()){
			$response['message'] = 'success';
			$status = 200;
			$response['data'] = $noti;
		} else {
			$status = 404;
			$response['message'] =  'No data found!';
		}
		return \Response::json($response,$status);

	}
	public function get_candidates($request)
    {
        $query = Candidate::with(array('user' => function ($query) {
                $query->where('role', 'candidate');
            }))
			//->select('status','id','user_id','photo','country','region')
                //->with('user.contactInfo')
                ->latest()
                ->where('visibility', 1);
        // status
        if ($request->has('status') && $request->status != null) {
            $query->where('status', $request->status);
        }else{
            $query->where('status', 'available');
            $request['status'] = 'available';
        }

        // keyword
        if ($request->has('keyword') && $request->keyword != null) {

            $query->whereHas('user', function ($q) use ($request) {
                $q->where('name', 'LIKE', "%$request->keyword%");
            });
        }

        // location
        if ($request->has('lat') && $request->has('long') && $request->lat != null && $request->long != null) {
            $ids = $this->candidate_location_filter($request->lat, $request->long);
            $query->whereIn('id', $ids)->orWhere('country', $request->location ? $request->location : '');
        }

        // profession
        if ($request->has('profession') && $request->profession != null) {
            $query->where('profession_id', $request->profession);
            // $profession_id = Profession::where('name', $request->profession)->value('id');
            // $query->where('profession_id', $profession_id);
        }

        // experience
        if ($request->has('experience') && $request->experience != null && $request->experience != 'all') {
            $experience_id = Experience::whereName($request->experience)->value('id');
            $query->where('experience_id', $experience_id);
        }

        // education
        if ($request->has('education') && $request->education != null && $request->education != 'all') {
            $education_id = Education::whereName($request->education)->value('id');
            $query->where('education_id', $education_id);
        }

        // gender
        if ($request->has('gender') && $request->gender != null) {
            $query->where('gender', request('gender'));
        }

        //  sortBy search
        if ($request->has('sortby') && $request->sortby) {
            if ($request->sortby == 'latest') {
                $query->latest();
            } else {
                $query->oldest();
            }
        }

         // languages filter
         if ($request->has('language') && $request->language != null) {
            $query->whereHas('languages', function($q) use ($request){
                $q->where('candidate_language.candidate_language_id', $request->language);
            });
        }

         // skills filter
         if ($request->has('skills') && $request->skills != null) {
            $skills = $request->skills;

            if($skills){
                $query->whereHas('skills', function($q) use ($skills){
                    $q->whereIn('candidate_skill.skill_id', $skills);
                });
            }
        }
		//return $query;
        // perpage
        $candidates = $query->with(['user:id,name', 'profession:id,name']);

        return $query->paginate(12)->withQueryString();
    }
	public function add_field(Request $request)
    {
        $validator = Validator::make($request->all(),[
			'name' => 'required',
			]);

		/*if($validator->fails())
		{
			return response()->json(['message'=>$validator->messages()],422);
		}*/

		if($validator->fails())
		{
			$response['message'] = $validator->errors()->first();
			$response['status_code'] = 422;
			return \Response::json($response);
		}

		switch ($request->type) {
			case 'role':
				$job_role_request = $request->name;
				$job_role = JobRoleTranslation::Where('name', $request->name)->first();
					if (!$job_role) {
						$new_job_role = JobRole::create(['name' => $job_role_request]);
						$languages = Language::all();
						foreach ($languages as $language) {
							$new_job_role->translateOrNew($language->code)->name = $job_role_request;
						}
						$new_job_role->save();
						$job_role_id = $new_job_role->id;

						$message = __('job_role_added_successfully');
					} else {
						$message = __('job_role_already_there');
					}
			break;
			case 'category':
				$job_category = JobCategoryTranslation::Where('name', $request->name)->first();
					if (!$job_category) {
						$new_job_category = JobCategory::create(['name' => $request->name]);
						$languages = Language::all();
						foreach ($languages as $language) {
							$new_job_category->translateOrNew($language->code)->name = $request->name;
						}
						$new_job_category->save();
						$message = __('job_category_added_successfully');
					}else{
						$message = __('job_category_already_there');
					}
				break;
			case 'education':
				$education = Education::where('name', $request->name)->first();
				if (!$education) {
					$education = Education::create(['name' => $request->name]);

						$message = __('education_added_successfully');
					}else{
						$message = __('education_already_there');
					}
				break;
			case 'experience':
				$experience = Experience::where('name', $request->name)->first();
				if (!$experience) {
					$experience = Experience::create(['name' => $request->name]);

						$message = __('experience_added_successfully');
					}else{
						$message = __('experience_already_there');
					}
				break;

		}

        $response['message'] = $message;
		$status = 200;
		return \Response::json($response,$status);
	}
	public function saved_candidate(Request $request){

		$validator = Validator::make($request->all(),[
			'category_id' => 'required',
            'candidate_id' => 'required',
			]);

		/*if($validator->fails())
		{
			return response()->json(['message'=>$validator->messages()],422);
		}*/

		if($validator->fails())
		{
			$response['message'] = $validator->errors()->first();
			$response['status_code'] = 422;
			return \Response::json($response);
		}

		$company = auth()->user()->company;

        if ($request->category_id) {
            $user_plan = $company->userPlan;
            if (isset($user_plan) && $user_plan->candidate_cv_view_limit <= 0) {
				abort(response()->json(
					[
						'status' => 'error',
						'message' => 'you_have_reached_your_limit_for_viewing_candidate_cv_please_upgrade_your_plan',
					], 401));
            }

            isset($user_plan) ? $user_plan->decrement('candidate_cv_view_limit') : '';
        }

		$candidate = Candidate::find($request->candidate_id);
        $check = $company->bookmarkCandidates()->toggle($candidate->id);
        if ($check['attached'] == [$candidate->id]) {
            \DB::table('bookmark_company')->where('company_id', auth()->user()->company->id)->where('candidate_id', $candidate->id)->update(['category_id' => $request->category_id]);

            // make notification to candidate
            $user = Auth::user('user');
            if ($candidate->user->shortlisted_alert) {
                Notification::send($candidate->user, new CandidateBookmarkNotification($user, $candidate));
            }
            // notify to company
            Notification::send(auth()->user(), new CandidateBookmarkNotification($user, $candidate));

            $message = __('candidate_added_to_bookmark_list');
        } else {
            $message = __('candidate_removed_from_bookmark_list');
        }

		$response['message'] = $message;
		$status = 200;
		return \Response::json($response,$status);
	}
	public function bookmark_list(Request $request){
        $query = auth()->user()->company->bookmarkCandidates()
		->select('candidates.id as candi_id','candidates.status')
		->with(array('user'=>function($query){
				$query->select('id','name');
			}
		));
		if ($request->bookcat_id){
            $query->wherePivot('category_id', $request->bookcat_id);
        }

		$bookmarks = $query->with('profession')->paginate(12)->withQueryString();


		$count = auth()->user()->company->bookmarkCandidates()->count();

		$data['bookmark_list'] = $bookmarks;
		$data['count'] = $count;

		if($bookmarks->isNotEmpty()){
			$response['message'] = 'success';
			$status = 200;
			$response['data'] = $data;
		} else {
			$status = 404;
			$response['message'] =  'No data found!';
		}

		return \Response::json($response,$status);
	}
	public function bookmark_show(Request $request){

		$book_category = CompanyBookmarkCategory::find($request->id);
		$response['message'] = 'success';
		$status = 200;
		$response['data'] = $book_category;

		return \Response::json($response,$status);
	}

	public function book_cate_list(Request $request){

		$categories = CompanyBookmarkCategory::where('company_id', auth()->user()->company->id)->get();

		if($categories->isNotEmpty()){
			$response['message'] = 'success';
			$status = 200;
			$response['data'] = $categories;
		} else {
			$status = 200;
			$response['message'] =  'No data found!';
			$response['data'] = $categories;
		}
		return \Response::json($response,$status);
	}


	public function bookmark_save(Request $request){


		$request->validate([
            'name' => 'required| min:2',
			 'id' => Rule::requiredIf(\Route::current()->getName() == 'book_cate_update'),
        ]);

        CompanyBookmarkCategory::updateOrCreate(
            ['id' => $request->id],
			[
				'company_id' => auth()->user()->company->id,'name' => $request->name
			]
		);

		$response['message'] = (empty($request->id)) ?  __('bookmark_category_added_successfully')  :  __('bookmark_category_updated_successfully');;
		$status = 200;
		return \Response::json($response,$status);
	}
	public function bookmark_delete(Request $request){

		$comp_book =	CompanyBookmarkCategory::find($request->id);
		$comp_book->delete();

		$response['message'] =  __('bookmark_category_deleted_successfully');
		$status = 200;
		return \Response::json($response,$status);
	}
    	public function appli_grp_show(Request $request){

		$app_group = ApplicationGroup::find($request->id);
		$response['message'] = 'success';
		$status = 200;
		$response['data'] = $app_group;

		return \Response::json($response,$status);
	}
	public function appli_grp_save(Request $request){


		$request->validate([
            'name' => 'required| min:2',
			 'id' => Rule::requiredIf(\Route::current()->getName() == 'appli_update'),
        ]);

        ApplicationGroup::updateOrCreate(
			['id' => $request->id],
			[
				'company_id' => auth()->user()->company->id,
				'name' => $request->name
			]
		);

		$response['message'] = (empty($request->id)) ?  __('application_group_added_successfully')  :  __('application_group_updated_successfully');;
		$status = 200;
		return \Response::json($response,$status);
	}
	public function appli_grp_delete(Request $request){

		$app_group =	ApplicationGroup::find($request->id);
		if ($app_group->is_deleteable) {
            $new_group = ApplicationGroup::where('company_id', auth()->user()->company->id)
                ->where('id', '!=', $app_group->id)
                ->where('is_deleteable', false)
                ->first();
			/***** candidate resume move to not deletable id *********/
            if ($new_group) {
                $app_group->applications()->update([
                    'application_group_id' => $new_group->id
                ]);
            }
            $app_group->delete();
			$message = __('application_group_deleted_successfully');
		} else {
			$message = __('group_is_not_deletable');
		}
		$response['message'] =  $message;
		$status = 200;
		return \Response::json($response,$status);
	}
	public function appli_grp_list(Request $request){

		$appli_group = ApplicationGroup::where('company_id', auth()->user()->company->id)
						->select('id','name','is_deleteable as editable')->get();

		if($appli_group->isNotEmpty()){
			$response['message'] = 'success';
			$status = 200;
			$response['data'] = $appli_group;
		} else {
			$status = 404;
			$response['message'] =  'No data found!';
		}
		return \Response::json($response,$status);
	}

	public function emplo_purchaseFreePlan(Request $request)
	{
		$rules['plan_id'] = 'required';
		$validator = Validator::make($request->all(),$rules);

		if($validator->fails())
		{
			$response['message'] = $validator->errors()->first();
			return \Response::json($response, 422);
		}

		$plan = Plan::find($request->plan_id);
		$user = auth()->user();
        $company = $user->company;
		$order = Earning::where('company_id', $company->id)->where('plan_id', $plan->id)->where('amount', 0)->first();
        if ($order) {
            $response['message'] = "You have already purchased this free plan. Can't purchase it again";
            return \Response::json($response, 422);
        }

        $user_plan = UserPlan::where('company_id', $company->id)->first();

        $today=date('Y-m-d');
        $days_count = '+'.$plan['days'].' days';
        $expire_date=Date('Y-m-d', strtotime($days_count));

        if ($user_plan) {
            $user_plan->update([
                'plan_id' => $plan->id,
                'job_limit' =>  $plan->job_limit,
                'featured_job_limit' => $plan->featured_job_limit,
                'highlight_job_limit' =>  $plan->highlight_job_limit,
                'candidate_cv_view_limit' =>  $plan->candidate_cv_view_limit,
                'candidate_cv_view_limitation' => $plan->candidate_cv_view_limitation,
                'buy_date' => $today,
                'expire_date' => $expire_date,
            ]);
        } else {
            $company->userPlan()->create([
                'plan_id'  =>  $plan->id,
                'job_limit'  =>  $plan->job_limit,
                'featured_job_limit'  =>  $plan->featured_job_limit,
                'highlight_job_limit'  =>  $plan->highlight_job_limit,
                'candidate_cv_view_limit'  =>  $plan->candidate_cv_view_limit,
                'candidate_cv_view_limitation'  =>  $plan->candidate_cv_view_limitation,
                'buy_date' => $today,
                'expire_date' => $expire_date,
            ]);
        }

        Earning::create([
            'order_id' => uniqid(),
            'transaction_id' => uniqid('tr_'),
            'payment_provider' => 'offline',
            'plan_id' => $plan->id ?? null,
            'company_id' => $company->id,
            'amount' => $plan->price,
            'currency_symbol' => config('jobpilot.currency_symbol'),
            'usd_amount' => $plan->price,
            'payment_type' => 'subscription_based',
            'payment_status' => 'paid',
        ]);

        $response['message'] = 'Plan Purchased Successfully';
        return \Response::json($response,200);

	}
    }

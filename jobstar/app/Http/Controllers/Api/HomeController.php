<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\DataArrayHelper;
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

use Modules\Location\Entities\Country;
use App\Http\Traits\HasCountryBasedJobs;
use App\Http\Traits\Candidateable;
use App\Traits\ResetCvViewsHistoryTrait;

use App\Services\Website\IndexPageService;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Validator;
use App\Notifications\Website\Candidate\ApplyJobNotification;
use App\Notifications\Website\Candidate\BookmarkJobNotification;
use App\Notifications\Admin\NewJobAvailableNotification;
use App\Notifications\Website\Company\JobCreatedNotification;
use Modules\Plan\Entities\Plan;
use Modules\Location\Entities\State;



use Carbon\Carbon;
use Auth;
use Illuminate\Support\Str;

class HomeController extends Controller{

        use Jobable, Candidateable, ResetCvViewsHistoryTrait, HasCountryBasedJobs;

    public function homepage(Request $request)
    {
        $data = (new IndexPageService())->execute();
		$data['popular_categories'] =
			JobCategory::withCount('jobs')->latest('jobs_count')->get()->take(8)
			->sortBy('open_position_count');

        foreach ($data['top_companies'] as $data_top){
			$data_top->setVisible(['id','logo_url', 'full_address','user']);
			$data_top['user']->setVisible(['id','name']);
		}
		foreach ($data['featured_jobs'] as $data_top){
			$data_top->setVisible(['id','title','salary','job_type','full_address','days_remaining','company']);
			$data_top['company']->setVisible(['id','logo_url','user']);
			$data_top['company']['user']->setVisible(['id','name']);
            $data_top['job_type']->setVisible(['name']);
		}
		foreach ($data['popular_categories'] as $data_top){
			$data_top->setVisible(['id','name','image_url','translations']);
			foreach($data_top->translations as $sin_trans){
				$sin_trans->setVisible(['id','job_category_id','name','locale']);
			}
		}
		foreach ($data['popular_roles'] as $data_top){
			$data_top->setVisible(['id','name','translations']);
			foreach($data_top->translations as $sin_trans){
				$sin_trans->setVisible(['id','job_role_id','name','locale']);
			}
		}
		foreach ($data['top_categories'] as $data_top){
			$data_top->setVisible(['id','name','image_url','translations']);
			foreach($data_top->translations as $sin_trans){
				$sin_trans->setVisible(['id','job_category_id','name','locale']);
			}
		}
		foreach ($data['top_categories'] as $data_top){
			$data_top->setVisible(['id','name','image_url','translations']);
			foreach($data_top->translations as $sin_trans){
				$sin_trans->setVisible(['id','job_category_id','name','locale']);
			}
		}
		$data['user_details'] = User::where('id', \Auth::user()->id)->select('id', 'name', 'mobile_num')->first()->append('photo');
        return \Response::json($data);
    }

    public function findjob(Request $request)
    {
        $data = $this->getJobs($request);
        return \Response::json($data);
    }

    // public function findemployes(Request $request)
    // {
    //     $data = $this->getJobs($request);
    //     return \Response::json($data);
    // }

    public function favorite_jobs(Request $request)
    {
        $candidate = Candidate::where('user_id', auth()->id())->first();
        $response["favorite_jobs"] = $candidate->bookmarkJobs()->withCount(['appliedJobs as applied' => function ($q) use ($candidate) {
            $q->where('candidate_id',  $candidate->id);
        }])->paginate(12);

        return \Response::json($response);
    }

    public function jobAlerts(Request $request)
    {
        $response['jobAlerts'] = $notifications = auth()->user()->notifications()->paginate(12);
        return \Response::json($response);
    }
	public function topcomp(Request $request)
    {

        $query = Company::select('id','user_id','logo','country','region')->with(['user' => function ($query) {
						$query->select('id', 'name as username');
					}])
				->withCount([
					'jobs as activejobs' => function ($q) {
						$q->where('status', 'active');
						$q = $this->filterCountryBasedJobs($q);
						}
					])
					->latest('activejobs')
					->take(9)
					->get();

   	   if($query->isNotEmpty()){

            foreach($query as $sinquery){
				$sinquery->makeHidden(['logo','country','region','banner_url','founded_date']);
				$sinquery['user']->setVisible(['username']);

			}
			$response['message'] = 'success';
			$status = 200;
			$response['data'] = $query;
		} else {
			$status = 404;
			$response['message'] =  'No data found!';
		}
		return \Response::json($response,$status);
    }
	public function dashboard(Request $request)
    {
		$candidate = Candidate::where('user_id', auth()->id())->first();

        if (empty($candidate)) {

            $candidate = new Candidate();
            $candidate->user_id = auth()->id();
            $candidate->save();
        }

        $appliedJobs = $candidate->appliedJobs->count();
        $favoriteJobs = $candidate->bookmarkJobs->count();


		$notifications = auth()->user()->notifications()->count();

		 $jobs = $candidate->appliedJobs()->withCount(['bookmarkJobs as bookmarked' => function ($q) use ($candidate) {
            $q->where('candidate_id',  $candidate->id);
        }])
        ->paginate(12);
        if(!empty($jobs)){
			foreach($jobs as $job){
				$job->setVisible(['id','title','salary','bookmarked','days_remaining','full_address','company','job_type']);
				$job['company']->setVisible(['id','logo_url','user']);
				$job['company']['user']->setVisible(['id','name']);
				$job['job_type']->setVisible(['name']);
			}
		}
	   $data = [
			'appliedJobs' => $appliedJobs,
			'favoriteJobs' => $favoriteJobs,
			'notifications' => $notifications,
			'recent_jobs' => $jobs,
		];

	   return \Response::json($data);

    }
	public function feature_job(Request $request)
    {

        $featured_jobs_query = Job::select('id','company_id','title','role_id','min_salary','max_salary','deadline','created_at','country','region','job_type_id')->with('company:id,user_id', 'job_type:id,name')->withCount([
            'bookmarkJobs', 'appliedJobs',
            'bookmarkJobs as bookmarked' => function ($q) {
                $q->where('candidate_id',  auth()->check() && auth()->user()->candidate ? auth()->user()->candidate->id : '');
            }, 'appliedJobs as applied' => function ($q) {
                $q->where('candidate_id',  auth()->check() && auth()->user()->candidate ? auth()->user()->candidate->id : '');
            }
        ]);
        $feat_data = $this->filterCountryBasedJobs($featured_jobs_query)->where('featured', 1)->active()->get();
        if($feat_data->isNotEmpty()){
			foreach($feat_data as $sinfeat) {
				$sinfeat->makeHidden(['company_id','role_id','min_salary','max_salary','deadline','created_at','country','region','bookmark_jobs_count','applied_jobs_count','job_type_id']);

				$sinfeat['company']->makeHidden(['user_id','banner_url','full_address','founded_date']);
				$sinfeat['company']['user']->setVisible(['name', 'email']);
				$sinfeat['job_type']->setVisible(['name']);
			}
		}
	   if($feat_data->isNotEmpty()){
			$response['message'] = 'success';
			$status = 200;
			$response['data'] = $feat_data;
		} else {
			$status = 404;
			$response['message'] =  'No data found!';
		}
		return \Response::json($response,$status);
	}
	public function comp_detail(Request $request)
    {
		$comp_user_id = $request->comp_id;


		$companyDetails =  Company::with(
            'organization:id,name',
            'industry',
            'team_size:id,name',
			'user.contactInfo'
        )->where('id', $request->comp_id)->withCount([
            'jobs as activejobs' => function ($q) {
                $q->where('status', true);
                $q->where('deadline', '>=', Carbon::now()->toDateString());
			}
        ])
		 ->withCount([
                'bookmarkCandidateCompany as candidatemarked' => function ($q)use ($comp_user_id) {
                    $q->where('user_id', auth()->id());
                }
            ])
            ->withCasts(['candidatemarked' => 'boolean'])
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
    public function bookmark(Request $request)
    {

		$job = Job::find($request->job_id);
		$check = $job->bookmarkJobs()->toggle(auth()->user()->candidate);

        if (!empty($check['attached'])) {

            $user = auth()->user();
            // make notification to company candidate bookmark job
            Notification::send($job->company->user, new BookmarkJobNotification($user, $job));
            // make notification to candidate for notify
            if (auth()->user()->recent_activities_alert) {
                Notification::send(auth()->user(), new BookmarkJobNotification($user, $job));
            }
        }
		(!empty($check['attached'])) ? $message = __('job_added_to_favorite_list')  : $message = __('job_removed_from_favorite_list');

		$response['message'] = $message;
		$status = 200;

		return \Response::json($response,$status);

	}
	public function resume_list(Request $request)
    {
		$data['resumes'] = auth()->user()->candidate->resumes;
		$response['message'] = !empty(array_filter((array)$data['resumes'])) ? $message = __('success')  : $message = __('No resume found');;
		$status = 200;
		$response['data'] = $data;

		return \Response::json($response,$status);
	}
	public function job_apply(Request $request)
    {
		$validator = Validator::make($request->all(),[
			'resume_id' => 'required',
            'cover_letter' => 'required',
		]);

		/*if($validator->fails())
		{
			return response()->json(['message'=>$validator->messages()],400);
		}*/

		if($validator->fails())
		{
			$response['message'] = $validator->errors()->first();
			$response['status_code'] = 422;
			return \Response::json($response);
		}

		if (auth()->user()->candidate->profile_complete != 0) {

			abort(response()->json(
					[
						'status' => 'error',
						'message' => 'Complete your profile before applying to jobs, Add your information, resume, and profile picture for a better chance of getting hired.',
					], 401));

		}
		$candidate = auth()->user()->candidate;
        $job = Job::find($request->job_id);
//dd($job->company);
        \DB::table('applied_jobs')->insert([
            'candidate_id' => $candidate->id,
            'job_id' => $job->id,
            'cover_letter' => $request->cover_letter,
            'candidate_resume_id' => $request->resume_id,
            'application_group_id' => $job->company->applicationGroups->where('is_deleteable', false)->first()->id ?? 6,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // make notification to candidate and company for notify
        $job->company->user->notify(new ApplyJobNotification(auth()->user(), $job->company->user));

        if (auth()->user()->recent_activities_alert) {
            auth()->user()->notify(new ApplyJobNotification(auth()->user(), $job->company->user));
        }
      //  return response()->json(['success' => __('job_applied_successfully')]);
      $response['message'] = 'job_applied_successfully';
		$status = 200;

		return \Response::json($response,$status);

	}
	public function resume_add(Request $request)
    {

        $request->validate([
            'name' => 'required',
            'file' => 'required|mimes:pdf|max:5120',
        ]);

        $candidate = auth()->user()->candidate;
        $data['name'] = $request->name;
        $data['candidate_id'] = $candidate->id;

        // cv
        if ($request->file) {
            $pdfPath = "file/candidates/";
            $file = uploadFileToPublic($request->file, $pdfPath);
            $data['file'] = $file;
        }

        $res_ins_id = CandidateResume::insertGetId($data);

		$response['message'] = 'success';
		$status = 200;
		$response['data'] = $res_ins_id;

		return \Response::json($response,$status);
    }
	public function resume_delete(Request $request)
    {
		$resume = CandidateResume::where('id', $request->resume_id)->first();
		deleteFile($resume->file);
		//unlink($resume->file);
        $resume->delete();
        return response()->json(['message' => __('resume_deleted_successfully')]);

	}
	public function recent_job(Request $request)
    {
		$candidate = Candidate::where('user_id', auth()->id())->first();

		 $jobs = $candidate->appliedJobs()->withCount(['bookmarkJobs as bookmarked' => function ($q) use ($candidate) {
            $q->where('candidate_id',  $candidate->id);
        }])
        ->paginate(12);

   	   if($jobs->isNotEmpty()){

 foreach($jobs as $sinjob) {
				$sinjob->makeHidden(['company_id','category_id','role_id','experience_id','education_id','job_type_id','salary_type_id','slug','vacancies','min_salary','max_salary','deadline','description','status','apply_on','apply_email','apply_url','featured_until','highlight_until','is_remote','total_views','created_at','updated_at','address','neighborhood','locality','place','district','postcode','region','country','long','lat','parent_job_id','waiting_for_edit_approval','salary_mode','custom_salary'
				]);
				$sinjob['company']->makeHidden(['id','industry_type_id','organization_type_id','team_size_id','logo','banner','establishment_date','website','visibility','profile_completion','bio','vision','total_views','created_at','updated_at','address','neighborhood','locality','place','district','postcode','region','country','long','lat','banner_url','founded_date'
				]);
				$sinjob['company']['user']->setVisible(['name', 'email']);
				$sinjob['job_type']->setVisible(['name']);

			}


			$response['message'] = 'success';
			$status = 200;
			$response['data'] = $jobs;
		} else {
			$status = 404;
			$response['message'] =  'No data found!';
		}
		return \Response::json($response,$status);
	}
	public function job_det(Request $request)
    {
		$job_detail =  Job::select('id','category_id','role_id','experience_id','education_id','salary_type_id','company_id','title','description','lat','long','deadline','job_type_id','country','region','min_salary','max_salary','total_views')
		->with(['benefits','tags','job_type:id,name','education:id,name','experience:id,name','role','company:id,website,user_id,team_size_id,establishment_date,country,region,lat,long','company.user:id,name','company.user.contactInfo:id,user_id,phone','company.team_size:id,name','company.user.socialInfo'])
		->withCount(['bookmarkJobs as bookmarked' => function ($q) {
			$q->where('candidate_id',  auth()->user()->candidate ? auth()->user()->candidate->id : '');
        }])
		->withCount(['appliedJobs as applied' => function ($q) {
			$q->where('candidate_id',  auth()->user()->candidate ? auth()->user()->candidate->id : '');
		}])

		->find($request->job_id);

		$views = $job_detail->total_views;
        $update = $job_detail->update(['total_views' => $views + 1]);

        $job_detail->makeHidden(['category_id','role_id','experience_id','education_id','salary_type_id','company_id','region','country','long','lat','banner_url','founded_date','min_salary','max_salary','can_apply','total_views']);

		$job_detail['company']->makeHidden(['user_id','team_size_id','establishment_date','region','country','banner_url','job_type_id']);
		$job_detail['company']['user']->makeHidden('image_url');
		$job_detail['company']['team_size']->makeHidden('id');
		$job_detail['job_type']->setVisible(['name']);
		$job_detail['education']->setVisible(['name']);
		$job_detail['experience']->setVisible(['name']);
		$job_detail['description'] = strip_tags($job_detail->description);

		$job_detail['role']->makeHidden(['id','created_at','updated_at','slug','name']);

		 foreach($job_detail['role']->translations as $sin_trans){
			$sin_trans->setVisible(['id','job_role_id','name','locale']);
		}

		foreach($job_detail['tags'] as $sin_trans){
			$sin_trans->makeHidden(['id','created_at','updated_at','show_popular_list','name']);
			$sintrans = $sin_trans->translations;
			foreach($sintrans as $sindet){
				$sindet->setVisible(['id','tag_id','name','locale']);
			}
		}

		$response['message'] = 'success';
		$status = 200;
		$response['data'] = $job_detail;
		return \Response::json($response,$status);

        //return response()->json(['success' => __('Successfully logout')]);
	}
	public function employersDetails (Request $request){
		$companyDetails =  Company::with(
            'organization:id,name',
            'industry',
            'team_size:id,name',
        )->where('user_id', $user->id)->withCount([
            'jobs as activejobs' => function ($q) {
                $q->where('status', true);
                $q->where('deadline', '>=', Carbon::now()->toDateString());
                $selected_country = session()->get('selected_country');
                if ($selected_country && $selected_country != null && $selected_country != 'all') {
                    $country = selected_country()->name;
                    $q->where('country', 'LIKE', "%$country%");
                } else {

                    $setting = Setting::first();
                    if ($setting->app_country_type == 'single_base') {
                        if ($setting->app_country) {

                            $country = Country::where('id', $setting->app_country)->first();
                            if ($country) {
                                $q->where('country', 'LIKE', "%$country->name%");
                            }
                        }
                    }
                }
            }
        ])
            ->withCount([
                'bookmarkCandidateCompany as candidatemarked' => function ($q) {
                    $q->where('user_id', auth()->id());
                }
            ])
            ->withCasts(['candidatemarked' => 'boolean'])
            ->first();

        // open_jobs Jobs With Single && Multiple Country Base
        $open_jobs_query = Job::withoutEdited()->with('company');

        $setting = Setting::first();
        if ($setting->app_country_type == 'single_base') {
            if ($setting->app_country) {

                $country = Country::where('id', $setting->app_country)->first();
                if ($country) {
                    $open_jobs_query->where('country', 'LIKE', "%$country->name%");
                }
            }
        } else {
            $selected_country = session()->get('selected_country');

            if ($selected_country && $selected_country != null) {
                $country = selected_country()->name;
                $open_jobs_query->where('country', 'LIKE', "%$country%");
            }
        }
        $open_jobs = $open_jobs_query->companyJobs($companyDetails->id)->openPosition()->latest()->get();

	}
	public function pop_cate_detail(Request $request)
    {
		$det_id = '';
		if(auth()->user()){
			$det_id = auth()->user()->candidate ? auth()->user()->candidate->id : '';
		}

		$query =  Job::select('id','company_id','title','role_id','min_salary','max_salary','deadline','created_at','country','region','category_id','job_type_id')->with('company:id,user_id,logo','company.user', 'category:id', 'job_type:id,name')
				->where('category_id', $request->cat_id)
                ->withCount([
                    'bookmarkJobs', 'appliedJobs',
                    'bookmarkJobs as bookmarked' => function ($q) use ($det_id) {
                        $q->where('candidate_id',  $det_id);
                    }, 'appliedJobs as applied' => function ($q) use ($det_id) {
                        $q->where('candidate_id', $det_id);
                    }
                ])
                ->active()->withoutEdited();

        $jobs = $query->latest()->paginate(12)->withQueryString();

    foreach($jobs as $sinfeat) {
				$sinfeat->makeHidden(['company_id','role_id','min_salary','max_salary','deadline','created_at','country','region','bookmark_jobs_count','applied_jobs_count','can_apply','job_type_id']);

				$sinfeat['company']->makeHidden(['user_id','banner_url','full_address','founded_date']);
				$sinfeat['company']['user']->setVisible(['name', 'email']);
				$sinfeat['job_type']->setVisible(['name']);
			}

		$data = [
			'job_list' => $jobs
		];
	   return \Response::json($data);
	}
	public function job_postion(Request $request){

		$open_jobs = Job::select('id','company_id','title','role_id','min_salary','max_salary','deadline','created_at','country','region','job_type_id')->with('company:id,user_id,logo,country,region','job_type:id,name')
					->companyJobs($request->comp_id)
					->openPosition()->latest()->get();

		foreach ($open_jobs as $open_job){
			$open_job->makeHidden(['company_id','role_id','min_salary','max_salary','deadline','created_at','country','region','bookmark_jobs_count','applied_jobs_count','job_type_id']);
			$open_job['company']->makeHidden(['user_id','banner_url','full_address','founded_date','country','region','logo']);
			$open_job['company']['user']->setVisible(['name', 'email']);
			$open_job['job_type']->setVisible(['name']);
		}
		$data = [
			'open_jobs' => $open_jobs
		];
	   return \Response::json($data);
	}

    public function user_noti(Request $request){

		$noti = auth()->user()->notifications()->paginate(12);
		foreach ($noti as $key =>$sinnoti){
 		$format = array();

		switch ($sinnoti->type) {

				case 'App\Notifications\Website\Candidate\ApplyJobNotification':

					$format['title'] = $sinnoti->data['title2'];
					$format['list'] = Str::remove(url('/company/'), $sinnoti->data['url2']);
					$format['create_at'] = $sinnoti->created_at->diffForHumans();
					$format['read_at'] = $sinnoti->read_at ? $sinnoti->read_at->diffForHumans() : '';
					break;
				case 'App\Notifications\Website\Candidate\BookmarkJobNotification':

					$format['title'] = $sinnoti->data['title2'];
					$format['list'] = Str::remove(url('/company/'), $sinnoti->data['url2']);
					$format['create_at'] = $sinnoti->created_at->diffForHumans();
					$format['read_at'] = $sinnoti->read_at ? $sinnoti->read_at->diffForHumans() : '';
					break;
				case 'App\Notifications\Website\Candidate\RelatedJobNotification':

					$format['title'] = $sinnoti->data['title'];
					$format['list'] = Str::remove(url('/jobs/'), $sinnoti->data['url']);
					$format['create_at'] = $sinnoti->created_at->diffForHumans();
					$format['read_at'] = $sinnoti->read_at ? $sinnoti->read_at->diffForHumans() : '';
					break;
				case 'App\Notifications\Website\Company\CandidateBookmarkNotification':

					$format['title'] = $sinnoti->data['title'];
					$format['list'] = Str::remove(url('/company/'), $sinnoti->data['url']);
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
	public function country(Request $request)
    {
        $data['countries'] = Country::all();
        return \Response::json($data);
    }
	public function state(Request $request)
    {
    	if($request->country_id == ''){
        	$data['states'] = State::all();
    	}else{
    		$data['states'] = State::where('country_id',$request->country_id)->get();
    	}
        return \Response::json($data);
    }
	public function logout(Request $request)
    {
		$user = User::find(\Auth::user()->id);
		$user->api_token = NULL;
		$user->save();

        return response()->json(['success' => __('Successfully logout')]);
	}
}

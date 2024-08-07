<?php

namespace App\Services\Website;

use App\Models\Job;
use App\Models\Company;
use App\Models\JobRole;
use App\Models\Setting;
use App\Models\Candidate;
use App\Models\JobCategory;
use Modules\Location\Entities\Country;
use App\Http\Traits\HasCountryBasedJobs;
use Modules\Testimonial\Entities\Testimonial;

class IndexPageService
{
    use HasCountryBasedJobs;

    public function execute(){
        $data['newjobs'] = $this->filterCountryBasedJobs(Job::withoutEdited()->newJobs())->count();

        $data['companies'] = Company::count();
        $data['candidates'] = Candidate::count();
        $data['testimonials'] = Testimonial::all();
        $data['testimonials'] = Testimonial::whereCode(currentLangCode())->get();
        $data['top_companies'] = Company::with('user.contactInfo')
            ->withCount([
                'jobs as jobs_count' => function ($q) {
                    $q->where('status', 'active');
                    $q = $this->filterCountryBasedJobs($q);
                }
            ])
            ->latest('jobs_count')
            ->get()
            ->take(9);

        // Featured Jobs With Single && Multiple Country Base
        $featured_jobs_query = Job::query()->withoutEdited()->with('company', 'job_type:id,name')->withCount([
            'bookmarkJobs', 'appliedJobs',
            'bookmarkJobs as bookmarked' => function ($q) {
                $q->where('candidate_id',  auth('user')->check() && auth('user')->user()->candidate ? auth('user')->user()->candidate->id : '');
            }, 'appliedJobs as applied' => function ($q) {
                $q->where('candidate_id',  auth('user')->check() && auth('user')->user()->candidate ? auth('user')->user()->candidate->id : '');
            }
        ]);
        $data['featured_jobs'] = $this->filterCountryBasedJobs($featured_jobs_query)->where('featured', 1)->active()->get()->take(6);

        $setting = Setting::first();
        $is_single_base_country_type = $setting->app_country_type == 'single_base' ? true : false;
        $popular_categories_list = JobCategory::withCount('jobs')->latest('jobs_count')->get()->take(8)->map(function($category) use ($setting, $is_single_base_country_type) {
            if ($is_single_base_country_type) {
                if ($setting->app_country) {

                    $country = Country::where('id', $setting->app_country)->first();
                    if ($country) {
                        $category->open_position_count = $category->jobs()->where('country', 'LIKE', "%$country->name%")->openPosition()->count();
                    }
                }
            } else {
                $selected_country = session()->get('selected_country');

                if ($selected_country && $selected_country != null) {
                    $country = selected_country()->name;
                    $category->open_position_count = $category->jobs()->where('country', 'LIKE', "%$country%")->openPosition()->count();
                }else{
                    $category->open_position_count = $category->jobs()->openPosition()->count();
                }
            }

            return $category;
        })->sortBy('open_position_count');
        $data['popular_categories'] = $popular_categories_list->sortBy('open_position_count');

        $popular_roles_list = JobRole::withCount('jobs')->latest('jobs_count')->take(8)->get()->map(function ($role) use ($setting, $is_single_base_country_type) {
            if ($is_single_base_country_type) {
                if ($setting->app_country) {

                    $country = Country::where('id', $setting->app_country)->first();
                    if ($country) {
                        $role->open_position_count = $role->jobs()->where('country', 'LIKE', "%$country->name%")->openPosition()->count();
                    }
                }
            } else {
                $selected_country = session()->get('selected_country');

                if ($selected_country && $selected_country != null) {
                    $country = selected_country()->name;
                    $role->open_position_count = $role->jobs()->where('country', 'LIKE', "%$country%")->openPosition()->count();
                }else{
                    $role->open_position_count = $role->jobs()->openPosition()->count();
                }
            }

            return $role;
        });
        $data['popular_roles'] = $popular_roles_list->sortBy('open_position_count');
        $data['top_categories'] = JobCategory::withCount('jobs')->latest('jobs_count')->get()->take(4);

        if (auth('user')->check() && auth('user')->user()->role == 'candidate') {
            $data['resumes'] = auth('user')->user()->candidate->resumes;
        } else {
            $data['resumes'] = [];
        }

        return $data;
    }
}

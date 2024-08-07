<?php

namespace App\Http\Traits;

use App\Models\Job;
use App\Models\JobRole;
use App\Models\Education;
use App\Models\Experience;
use App\Models\JobCategory;
use Illuminate\Support\Carbon;
use App\Models\JobRoleTranslation;
use App\Models\JobCategoryTranslation;
use Modules\Language\Entities\Language;

trait CompanyJobTrait
{

    function update_job($request, $job)
    {
        // dd($job);
        // Job Category
        $job_category_request = $request->category_id;

        $job_category = JobCategoryTranslation::where('job_category_id', $job_category_request)->orWhere('name', $job_category_request)->first();
        if (!$job_category) {
            $new_job_category = JobCategory::create(['name' => $job_category_request]);

            $languages = Language::all();
            foreach ($languages as $language) {
                $new_job_category->translateOrNew($language->code)->name = $job_category_request;
            }
            $new_job_category->save();


            $job_category_id = $new_job_category->id;
        }else{
            $job_category_id = $job_category->job_category_id;
        }

        // Job Role
        $job_role_request = $request->role_id;

        $job_category = JobRoleTranslation::where('job_role_id', $job_role_request)->orWhere('name', $job_role_request)->first();

        if (!$job_category) {
            $new_job_role = JobRole::create(['name' => $job_role_request]);

            $languages = Language::all();
            foreach ($languages as $language) {
                $new_job_role->translateOrNew($language->code)->name = $job_role_request;
            }
            $new_job_role->save();


            $job_role_id = $new_job_role->id;
        }else{
            $job_role_id = $job_category->job_role_id;
        }

        // Experience
        $education_request = $request->education;
        $education = Education::where('id', $education_request)->orWhere('name', $education_request)->first();
        if (!$education) {
            $education = Education::where('name', $education_request)->first();

            if (!$education) {
                $education = Education::create(['name' => $education_request]);
            }
        }

        // Education
        $experience_request = $request->experience;
        $experience = Experience::where('id', $experience_request)->orWhere('name', $experience_request)->first();
        if (!$experience) {
            $experience = Experience::where('name', $experience_request)->first();

            if (!$experience) {
                $experience = Experience::create(['name' => $experience_request]);
            }
        }

        $main_job = '';
        if (setting('edited_job_auto_approved') || @$job->status == 'pending') {
            // dd('sdsd');
            $job->update([
                'title' => $request->title,
                'category_id' => $job_category_id,
                'role_id' => $job_role_id,
                'education_id' => $education->id,
                'experience_id' => $experience->id,
                'salary_mode' => $request->salary_mode,
                'custom_salary' => $request->custom_salary,
                'min_salary' => $request->min_salary,
                'max_salary' => $request->max_salary,
                'salary_type_id' => $request->salary_type,
                // 'deadline' => Carbon::createFromFormat('d/m/Y', $request->deadline)
                //                 ->format('Y-m-d'),
                /*'deadline' => Carbon::createFromFormat('d-m-Y', $request->deadline)
                                ->format('Y-m-d'),*/
                'deadline' => $request->deadline,
                'job_type_id' => $request->job_type,
                'vacancies' => $request->vacancies,
                'apply_on' => $request->apply_on,
                'apply_email' => $request->apply_email ?? null,
                'apply_url' => $request->apply_url ?? null,
                'description' => $request->description,
                'is_remote' => $request->is_remote ?? 0,
            ]);
            $main_job = $job;
        } else {

            $edited_exist = Job::where('parent_job_id', $job->id)->where('company_id',  auth()->user()->company->id)->first();
            // dd($edited_exist);
            if ($edited_exist) {

                $edited_exist->update([
                    'title' => $request->title,
                    'category_id' => $job_category_id,
                    'role_id' => $job_role_id,
                    'education_id' => $education->id,
                    'experience_id' => $experience->id,
                    'salary_mode' => $request->salary_mode,
                    'custom_salary' => $request->custom_salary,
                    'min_salary' => $request->min_salary,
                    'max_salary' => $request->max_salary,
                    'salary_type_id' => $request->salary_type,
                    /*'deadline' => Carbon::createFromFormat('d/m/Y', $request->deadline)
                                ->format('Y-m-d'),*/
                    /*'deadline' => Carbon::createFromFormat('d-m-Y', $request->deadline)
                    ->format('Y-m-d'),*/
                    'deadline' => $request->deadline,
                    'job_type_id' => $request->job_type,
                    'vacancies' => $request->vacancies,
                    'apply_on' => $request->apply_on,
                    'apply_email' => $request->apply_email ?? null,
                    'apply_url' => $request->apply_url ?? null,
                    'description' => $request->description,
                    'is_remote' => $request->is_remote ?? 0,
                    'waiting_for_edit_approval' => 1,
                    'status' => 'pending'
                ]);
                $main_job = $edited_exist;
            } else {
                $main_job = Job::create([
                    'title' => $request->title,
                    'category_id' => $job_category_id,
                    'role_id' => $job_role_id,
                    'education_id' => $education->id,
                    'experience_id' => $experience->id,
                    'salary_mode' => 'required',
                    'custom_salary' => 'required_if:salary_mode,==,custom',
                    'salary_mode' => $request->salary_mode,
                    'custom_salary' => $request->custom_salary,
                    'min_salary' => $request->min_salary,
                    'max_salary' => $request->max_salary,
                    'salary_type_id' => $request->salary_type,
                    /*'deadline' => Carbon::createFromFormat('d/m/Y', $request->deadline)
                                ->format('Y-m-d'),*/
                    /*'deadline' => Carbon::createFromFormat('d-m-Y', $request->deadline)
                                ->format('Y-m-d'),*/
                    'deadline' => $request->deadline,
                    'job_type_id' => $request->job_type,
                    'vacancies' => $request->vacancies,
                    'apply_on' => $request->apply_on,
                    'apply_email' => $request->apply_email ?? null,
                    'apply_url' => $request->apply_url ?? null,
                    'description' => $request->description,
                    'is_remote' => $request->is_remote ?? 0,
                    'company_id' => auth('user')->user()->company->id,
                    'parent_job_id' => $job->id,
                    'waiting_for_edit_approval' => 1,
                    'status' => 'pending',
                    // map deatils
                    'address' => $job->address,
                    'neighborhood' => $job->neighborhood,
                    'locality' => $job->locality,
                    'place' => $job->place,
                    'district' => $job->district,
                    'postcode' => $job->postcode,
                    'region' => $job->region,
                    'country' => $job->country,
                    'long' => $job->long,
                    'lat' => $job->lat,
                ]);
            }
        }

        return  $main_job;
    }
}

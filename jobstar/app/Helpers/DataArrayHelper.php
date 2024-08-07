<?php

namespace App\Helpers;

use Request;

use App\Models\Experience;
use App\Models\Education;
use App\Models\Nationality;
use App\Models\Profession;
use App\Models\Skill;
use App\Models\CandidateLanguage;
use App\Models\JobRole;
use App\Models\JobCategory;
use App\Models\Job;
use App\Models\Company;
use App\Models\OrganizationType;
use App\Models\IndustryTypeTranslation;
use App\Models\TeamSize;



class DataArrayHelper
{
    public static function langExperiencesArray()
    {
        $array = Experience::select('experiences.id', 'experiences.name')->get();
        return $array;
    }

    public static function langEducationArray()
    {
        $array = Education::select('education.id','education.name')->get();
        return $array;
    }

    public static function langNationalityArray()
    {
        // $array = Nationality::select('nationalities.id','nationalities.name')->get();
        $array = \DB::table('countries')->select('id', 'name', 'image')->get();
        return $array;
    }

    public static function langProfessionArray()
    {
        $array = Profession::select('professions.id','professions.name')->get();
        return $array;
    }

    public static function langSkillArray(){
        $array = Skill::select('skills.id','skills.name')->get();
        return $array;
    }

    public static function langLanguageArray(){
        $array = CandidateLanguage::select('candidate_languages.id','candidate_languages.name')->get();
        return $array;
    }

    public static function langJobAlertArray(){
        $array = JobRole::select('job_roles.id','job_roles.name')->get();
        return $array;
    }

    public static function populerCatagory(){
        $array = JobCategory::select('job_categories.id','job_categories.name')->get();
        return $array;
    }

    public static function mostPopularVacancies(){
        $array = JobRole::select('job_roles.id','job_roles.name')->get();
        return $array;

    }

    public static function featuredJobs(){
        $array = Job::select('jobs.id','jobs.title','jobs.min_salary','jobs.max_salary','jobs.country')->get();
        return $array;
    }

    public static function topCompanies(){
        
        $array = Company::query()->with(['user'=> function($query){
            $query->select('id','name');
         }])->get(['id','logo','.banner','establishment_date','country','user_id']);
        return $array;
    }

    public static function langOrganizationtypeArray(){
        $array = OrganizationType::select('organization_types.id','organization_types.name')->get();
        // dd($array);
        return $array;
    }

    public static function langIndustrytypeArray(){
        $array = IndustryTypeTranslation::select('industry_type_translations.id', 'industry_type_translations.industry_type_id', 'industry_type_translations.name')->where('locale', 'en')->get();
        return $array;
    }
    
    public static function langTeamsizeArray(){
        $array = TeamSize::select('team_sizes.id','team_sizes.name')->get();
        return $array;
    }
}


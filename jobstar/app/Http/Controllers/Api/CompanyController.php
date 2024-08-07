<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UserPlan;
use Modules\Plan\Entities\Plan;


class CompanyController extends Controller
{
    public function dashboard(Request $request){
        // $response['userplan'] = UserPlan::with('plan')->companyData()->firstOrFail();
        $response['userplan'] = UserPlan::with('plan')->companyData()->first();
        $response['openJobCount'] = auth()->user()->company->jobs()->active()->count();
        $response['pendingJobCount'] = auth()->user()->company->jobs()->pending()->count();

        // Recent 4 Jobs
        $response['recentJobs'] = auth()->user()->company->jobs()->latest()->take(4)->with('company.user', 'job_type')->withCount('appliedJobs')->get()->map(function($query){
            $query->description = strip_tags($query->description);
            $query->company->bio = strip_tags($query->company->bio);
            $query->company->vision = strip_tags($query->company->vision);
            return $query;
        });
        $response['savedCandidates']  = auth()->user()->company->bookmarkCandidates()->count();
        return \Response::json($response);


        }

        public function upgrade(Request $request){
        // abort_if(auth('user')->check() && auth('user')->user()->role == 'candidate', 404);
        $plans = Plan::active()->get();
        foreach($plans as $plan){
            if($plan->label == 'Trial'){
                $response['Trial'] = $plan;
            }elseif($plan->label == 'Standard'){
                $response['Standard'] = $plan;
            }elseif ($plan->label == 'Premium') {
                $response['Premium'] = $plan;
            }
        }
        return \Response::json($response);
    }
}

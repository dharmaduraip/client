<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use Faker\Factory;
use App\Models\User;
use App\Models\Company;
use App\Models\TeamSize;
use Illuminate\Support\Str;
use App\Models\IndustryType;
use Illuminate\Http\Request;
use App\Models\OrganizationType;
use Modules\Location\Entities\City;
use App\Http\Controllers\Controller;
use Modules\Location\Entities\State;
use Modules\Location\Entities\Country;
use Illuminate\Support\Facades\Notification;
use App\Http\Requests\CompanyCreateFormRequest;
use App\Http\Requests\CompanyUpdateFormRequest;
use App\Models\Job;
use App\Models\Setting;
use App\Notifications\CompanyCreateApprovalPendingNotification;
use App\Notifications\CompanyCreatedNotification;
use App\Notifications\UpdateCompanyPassNotification;

class CompanyController extends Controller
{
    public function index(Request $request)
    {
        abort_if(!userCan('company.view'), 403);

        $query = Company::query();

        // sortby
        if ($request->sort_by == 'latest' || $request->sort_by == null) {
            $query->latest();
        } else {
            $query->oldest();
        }

        // verified status
        if ($request->has('ev_status') && $request->ev_status != null) {
            $ev_status = null;
            if ($request->ev_status == 'true') {
                $query->whereHas('user', function ($q) use ($ev_status) {
                    $q->whereNotNull('email_verified_at');
                });
            } else {
                $query->whereHas('user', function ($q) use ($ev_status) {
                    $q->whereNull('email_verified_at');
                });
            }
        }

        if ($request->keyword && $request->keyword != null) {
            $query->whereHas('user', function ($q) use ($request) {

                $q->where('name', 'LIKE', "%$request->keyword%")
                    ->orWhere('email', 'LIKE', "%$request->keyword%");
            });
        }

        // organization_type
        if ($request->organization_type && $request->organization_type != null) {
            $query->whereHas('organization', function ($q) use ($request) {
                $q->where('slug', $request->organization_type);
            });
        }

        // organization_type
        if ($request->industry_type && $request->industry_type != null) {
            $query->where('industry_type_id', $request->industry_type);
        }

        $companies = $query->with('organization:id,name', 'user')->paginate(10)->through(function($company){
            $company->active_jobs = Job::where('company_id', $company->id)->openPosition()->count();
            return $company;
        });

        $industry_types = IndustryType::all();
        $organization_types = OrganizationType::all();

        return view('admin.company.index', compact('companies', 'industry_types', 'organization_types'));
    }

    public function create()
    {
        abort_if(!userCan('company.create'), 403);

        $data['countries'] = Country::all();
        $data['industry_types'] = IndustryType::all();
        $data['organization_types'] = OrganizationType::all();
        $data['team_sizes'] = TeamSize::all();

        return view('admin.company.create', $data);
    }

    public function store(CompanyCreateFormRequest $request)
    {
        abort_if(!userCan('company.create'), 403);
        $faker = Factory::create();
        $location = session()->get('location');
        if (!$location) {

            $request->validate([
                'location' => 'required',
                'logo' => 'required|mimes:jpeg,jpg,svg,png',
            ]);
        }
        // dd($request->all());

        try {

            $name = $request->name ?? $faker->name();
            $username = $request->username ?? Str::slug($name).'_'.time();

            $company = User::create([
                'name' =>  $name,
                'username' => $username,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'role' => 'company',
            ]);

            if ($request->logo) {
                $logo_url = uploadImage($request->logo, 'company');
            }else{
                $logo_url = createAvatar($name, 'uploads/images/company');
            }

            if ($request->image) {
                $banner_url = uploadImage($request->image, 'company');
            }else{
                $banner_url = createAvatar($name, 'uploads/images/company');
            }

            $dateTime = Carbon::parse($request->establishment_date);
            $date = $request['establishment_date'] = $dateTime->format('Y-m-d H:i:s') ?? null;

            $company->company()->update([
                'industry_type_id' => $request->industry_type_id,
                'organization_type_id' => $request->organization_type_id,
                'team_size_id' => $request->team_size_id,
                'establishment_date' => $date,
                'logo' => $logo_url ?? '',
                'banner' => $banner_url ?? '',
                'website' => $request->website,
                'bio' => $request->bio,
                'vision' => $request->vision,
            ]);

            $company->contactInfo()->update([
                'phone' => $request->contact_phone,
                'email' => $request->contact_email,
            ]);

            // Social media insert
            $social_medias = $request->social_media;
            $urls = $request->url;

            foreach ($social_medias as $key => $value) {
                if ($value && $urls[$key]) {
                    $company->socialInfo()->create([
                        'social_media' => $value ?? '',
                        'url' => $urls[$key] ?? '',
                    ]);
                }
            }

            // Location
            updateMap($company->company());

            // make Notification /
            $data[] = $company;
            $data[] = $request->password;

            // if mail is configured
            if (checkMailConfig()) {
                $employer_auto_activation_enabled = Setting::where("employer_auto_activation", 1)->count();

                // if employer activation enabled, send account created mail
                // else, send will be activated mail.
                if ($employer_auto_activation_enabled) {
                    Notification::route('mail', $company->email)->notify(new CompanyCreatedNotification($company, $request->password));
                } else {
                    Notification::route("mail", $company->email)->notify(new CompanyCreateApprovalPendingNotification($company, $request->password));
                }
            }

            flashSuccess(__('company_created_successfully'));
            return redirect()->route('company.index');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', config('app.debug') ? $th->getMessage() : 'Something went wrong');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        abort_if(!userCan('company.view'), 403);

        $company = Company::with([ 'jobs.appliedJobs', 'user.socialInfo','user.contactInfo', 'jobs' => function($job){
            return $job->latest()->with('category', 'role','job_type','salary_type');
        }])->findOrFail($id);

        return view('admin.company.show', compact('company'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        abort_if(!userCan('company.update'), 403);

        $data['company'] = Company::findOrFail($id);
        $data['user'] = $data['company']->user->load('socialInfo');
        $data['industry_types'] = IndustryType::all();
        $data['organization_types'] = OrganizationType::all();
        $data['team_sizes'] = TeamSize::all();
        $data['socials'] = $data['company']->user->socialInfo;

        return view('admin.company.edit', $data);
    }

    public function update(CompanyUpdateFormRequest $request, Company $company)
    {
        abort_if(!userCan('company.update'), 403);
        $faker = Factory::create();

        $company = $company->user;

        try {
            $data['name'] = $request->name ?? $faker->name();
            $data['email'] = $request->email;
            $data['username'] = $request->username ?? Str::slug($data['name']).'_'.time();

            if ($request->password) {
                $data['password'] = bcrypt($request->password);
            }

            $company->update($data);

            $company->company()->update([
                'industry_type_id' => $request->industry_type_id,
                'organization_type_id' => $request->organization_type_id,
                'team_size_id' => $request->team_size_id,
                'establishment_date' => Carbon::parse($request->establishment_date)->format('Y-m-d') ?? null,
                'website' => $request->website,
                'bio' => $request->bio,
                'vision' => $request->vision,
            ]);

            if ($request->logo) {
                $logo_url = uploadFileToPublic($request->logo, 'company');
                $company->company()->update(['logo' => $logo_url]);
            }

            if ($request->image) {
                $banner_url = uploadFileToPublic($request->image, 'company');
                $company->company()->update(['banner' => $banner_url]);
            }

            $company->contactInfo()->update([
                'phone' => $request->contact_phone,
                'email' => $request->contact_email,
            ]);

            // Social media
            $company->socialInfo()->delete();

            $social_medias = $request->social_media;
            $urls = $request->url;

            foreach ($social_medias as $key => $value) {
                if ($value && $urls[$key]) {
                    $company->socialInfo()->create([
                        'social_media' => $value ?? '',
                        'url' => $urls[$key] ?? '',
                    ]);
                }
            }

            // Location
            updateMap($company->company());

            if ($request->password) {
                // make Notification /
                $data[] = $company;
                $data[] = $request->password;
                $data[] = 'Company';

                checkMailConfig() ? Notification::route('mail', $company->email)->notify(new UpdateCompanyPassNotification($data)) : '';
            }

            flashSuccess(__('company_updated_successfully'));
            return redirect()->route('company.index');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', config('app.debug') ? $th->getMessage() : 'Something went wrong');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        abort_if(!userCan('company.delete'), 403);

        $company = Company::findOrFail($id);

        deleteFile($company->logo);
        deleteFile($company->banner);
        deleteFile($company->user->image);

        $company->user->delete();
        $company->delete();

        flashSuccess(__('company_deleted_successfully'));
        return back();
    }

    public function getStateList(Request $request)
    {
        $data['states'] = State::where("country_id", $request->country_id)
            ->get(["name", "id"]);
        return response()->json($data);
    }

    public function getCityList(Request $request)
    {
        $data['cities'] = City::where("state_id", $request->state_id)
            ->get(["name", "id"]);
        return response()->json($data);
    }

    public function statusChange(Request $request)
    {
        $user = User::findOrFail($request->id);

        $user->update(['status' => $request->status]);

        if ($request->status == 1) {
            return responseSuccess(__('company_activated_successfully'));
        } else {
            return responseSuccess(__('company_deactivated_successfully'));
        }
    }

    public function verificationChange(Request $request)
    {
        $user = User::findOrFail($request->id);

        if ($request->status) {
            $user->update(['email_verified_at' => now()]);
            $message = __('email_verified_successfully');
        } else {
            $user->update(['email_verified_at' => null]);
            $message = __('email_unverified_successfully');
        }

        return responseSuccess($message);
    }
}

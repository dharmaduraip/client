<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Skill;
use App\Models\JobRole;
use App\Models\Candidate;
use App\Models\Education;
use App\Models\Experience;
use App\Models\Profession;
use App\Models\ContactInfo;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\SkillTranslation;
use App\Models\CandidateLanguage;
use Illuminate\Support\Facades\DB;
use Modules\Location\Entities\City;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Modules\Location\Entities\State;
use Modules\Location\Entities\Country;
use App\Http\Requests\CandidateRequest;
use Modules\Language\Entities\Language;
use App\Models\Setting;
use App\Notifications\CandidateCreateApprovalPendingNotification;
use Illuminate\Support\Facades\Notification;
use App\Notifications\CandidateCreateNotification;
use App\Notifications\UpdateCompanyPassNotification;

class CandidateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        abort_if(!userCan('candidate.view'), 403);
        $query = Candidate::withCount('appliedJobs')->with('user','jobRole');

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

        // sortby
        if ($request->sort_by == 'latest' || $request->sort_by == null) {
            $query->latest();
        } else {
            $query->oldest();
        }

        $candidates = $query->paginate(10)->withQueryString();

        return view('admin.candidate.index', compact('candidates'));
    }

    public function state(Request $request)
    {
        $states = State::where('country_id', $request->country_id)->get();
        return response()->json($states);
    }

    public function city(Request $request)
    {
        $cities = City::where('state_id', $request->state_id)->get();
        return response()->json($cities);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort_if(!userCan('candidate.create'), 403);

        $data['countries'] = Country::all();
        $data['job_roles'] = JobRole::all();
        $data['professions'] = Profession::all();
        $data['experiences'] = Experience::all();
        $data['educations'] = Education::all();
        $data['skills'] = Skill::all();
        $data['candidate_languages'] = CandidateLanguage::all(['id', 'name']);

        return view('admin.candidate.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function userCreate($request)
    {
        $request->validate([
            'username' => 'unique:users,username',
            'email' => 'unique:users,email'
        ]);

        $password = $request->password ?? Str::random(8);

        $data = User::create([
            'role' => 'candidate',
            'name' => $request->name,
            'username' => Str::slug('K' . $request->name . '122'),
            'email' => $request->email,
            'email_verified_at' => now(),
            'password' => Hash::make($password),
            'remember_token' => Str::random(10),
        ]);

        return [$password, $data];
    }
    public function candidateCreate($request, $data)
    {
        $dateTime = Carbon::parse($request->birth_date);
        $date = $request['birth_date'] = $dateTime->format('Y-m-d H:i:s');

        $candidate = Candidate::where('user_id', $data[1]->id)->first();

        $candidate->update([
            "role_id" => $request->role_id,
            "profession_id" => $request->profession_id,
            "experience_id" => $request->experience,
            "education_id" => $request->education,
            "gender" => $request->gender,
            "website" => $request->website,
            "bio" => $request->bio,
            "marital_status" => $request->marital_status,
            "birth_date" => $date,
        ]);

        // cv
        if ($request->cv) {
            $pdfPath = "/file/candidates/";
            $pdf = pdfUpload($request->cv, $pdfPath);

            $candidate->update([
                "cv" => $pdf,
            ]);
        }

        // image
        if ($request->image) {
            $path = 'images/candidates';
            $image = uploadImage($request->image, $path);
        }else{
            // $image = createAvatar($data['name'], 'uploads/images/candidate');
            $image = createAvatar($data[1]->name, 'uploads/images/candidate');
        }

        $candidate->update(["photo" => $image]);

        // skills
        $skills = $request->skills;
        if ($skills) {
            $skillsArray = [];

            foreach ($skills as $skill) {
                $skill_exists = Skill::where('id', $skill)->orWhere('name', $skill)->first();

                if (!$skill_exists) {
                    $select_tag = Skill::create(['name' => $skill]);
                    array_push($skillsArray, $select_tag->id);
                }else{
                    array_push($skillsArray, $skill);
                }
            }

            $candidate->skills()->attach($skillsArray);
        }

        // languages
        $candidate->languages()->attach($request->languages);

        return $candidate;
    }

    public function store(CandidateRequest $request)
    {
        abort_if(!userCan('candidate.create'), 403);

        $location = session()->get('location');
        if (!$location) {

            $request->validate([
                'location' => 'required',
            ]);
        }

        try {

            if ($request->image) {
                $request->validate([
                    'image' =>  'image|mimes:jpeg,png,jpg,gif'
                ]);
            }
            if ($request->cv) {
                $request->validate([
                    "cv" => "mimetypes:application/pdf",
                ]);
            }

            $data = $this->userCreate($request);
            $candidate = $this->candidateCreate($request, $data);
            $user = $data[1];
            $password = $data[0];

            // Location
            updateMap($candidate);

            // if mail is configured
            if (checkMailConfig()) {
                $candidate_account_auto_activation_enabled = Setting::where("candidate_account_auto_activation", 1)->count();

                // if candidate activation enabled, send account created mail
                // else, send will be activated mail.
                if ($candidate_account_auto_activation_enabled) {
                    Notification::route('mail', $user->email)->notify(new CandidateCreateNotification($user, $password));
                } else {
                    Notification::route('mail', $user->email)->notify(new CandidateCreateApprovalPendingNotification($user, $password));
                }
            }

            flashSuccess(__('candidate_created_successfully'));
            return redirect()->route('candidate.index');
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
    public function show($candidate)
    {
        abort_if(!userCan('candidate.view'), 403);

        $candidate = Candidate::with('skills','languages:id,name','profession')->findOrFail($candidate);
        $user = User::with('socialInfo','contactInfo')->findOrFail($candidate->user_id);
        $appliedJobs = $candidate->appliedJobs()->with('company.user','category','role')->get();
        $bookmarkJobs = $candidate->bookmarkJobs()->with('company.user', 'category','role')->get();

        return view('admin.candidate.show', compact('candidate', 'user', 'appliedJobs', 'bookmarkJobs'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Candidate $candidate)
    {
        abort_if(!userCan('candidate.update'), 403);

        $user = User::with('contactInfo')->findOrFail($candidate->user_id);
        $contactInfo = ContactInfo::where('user_id', $user->id)->first();
        $job_roles = JobRole::all();
        $professions = Profession::all();
        $experiences = Experience::all();
        $educations = Education::all();
        $skills = Skill::all();
        $candidate_languages = CandidateLanguage::all(['id', 'name']);
        $candidate->load('skills','languages:id,name');

        return view('admin.candidate.edit', compact('contactInfo', 'candidate', 'user', 'job_roles', 'professions', 'experiences', 'educations','skills',
        'candidate_languages'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Candidate $candidate)
    {
        abort_if(!userCan('candidate.update'), 403);

        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $candidate->user_id,
        ]);

        $user = User::FindOrFail($candidate->user_id);
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);
        $profession = intval($request->profession_id);
        $candidate->update([
            "role_id" => $request->role_id,
            'profession_id' => $profession,
            'experience_id' => $request->experience,
            'education_id' => $request->education,
            'gender' => $request->gender,
            'website' => $request->website,
            'bio' => $request->bio,
            "marital_status" => $request->marital_status,
            "birth_date" => date('Y-m-d', strtotime($request->birth_date)),
        ]);

        // password change
        if ($request->password) {
            $request->validate([
                'password' => 'required',
            ]);
            $user->update([
                'password' => Hash::make($request->password),
            ]);
        }

        // image
        if ($request->image) {
            $request->validate([
                'image' =>  'image|mimes:jpeg,png,jpg,gif'
            ]);

            $old_photo = $candidate->photo;
            if (file_exists($old_photo)) {
                if ($old_photo != 'backend/image/default.png') {
                    unlink($old_photo);
                }
            }
            $path = 'images/candidates';
            $image = uploadImage($request->image, $path);

            $candidate->update([
                "photo" => $image,
            ]);
        }
        // cv
        if ($request->cv) {
            $request->validate([
                "cv" => "mimetypes:application/pdf",
            ]);
            $pdfPath = "/file/candidates/";
            $pdf = pdfUpload($request->cv, $pdfPath);

            $candidate->update([
                "cv" => $pdf,
            ]);
        }

        // Location
        updateMap($candidate);

        // skills
        $skills = $request->skills;
        DB::table('candidate_skill')->where('candidate_id', $candidate->id)->delete();

        if ($skills) {
            $skillsArray = [];

            foreach ($skills as $skill) {
                $skill_exists = SkillTranslation::where('skill_id', $skill)->orWhere('name', $skill)->first();

                if (!$skill_exists) {
                    $select_tag = Skill::create(['name' => $skill]);

                    $languages = Language::all();
                    foreach ($languages as $language) {
                        $select_tag->translateOrNew($language->code)->name = $skill;
                    }
                    $select_tag->save();

                    array_push($skillsArray, $select_tag->id);
                }else{
                    array_push($skillsArray, $skill_exists->id);
                }
            }

            $candidate->skills()->attach($skillsArray);
        }

        // languages
        $candidate->languages()->sync($request->languages);

        if ($request->password) {
            // make Notification /
            $data[] = $user;
            $data[] = $request->password;
            $data[] = 'Candidate';

            checkMailConfig() ? Notification::route('mail', $user->email)->notify(new UpdateCompanyPassNotification($data)) : '';
        }
        flashSuccess(__('candidate_updated_successfully'));
        return back();
        // return redirect()->route('candidate.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Candidate $candidate)
    {
        abort_if(!userCan('candidate.delete'), 403);

        $user = User::FindOrFail($candidate->user_id);
        $user->delete();

        if (file_exists($candidate->cv)) {
            unlink($candidate->cv);
        }

        if (file_exists($candidate->photo)) {
            if ($candidate->photo != 'backend/image/default.png') {
                unlink($candidate->photo);
            }
        }
        $candidate->delete();

        flashSuccess(__('candidate_deleted_successfully'));
        return redirect()->back();
    }

    public function statusChange(Request $request)
    {
        $user = User::findOrFail($request->id);
        $user->status = $request->status;
        $user->save();


        if ($request->status == 1) {
            return responseSuccess(__('candidate_activated_successfully'));
        } else {
            return responseSuccess(__('candidate_deactivated_successfully'));
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

<?php

namespace App\Http\Controllers\Website;

use Carbon\Carbon;
use App\Models\Job;
use App\Models\User;
use App\Models\Skill;
use App\Models\Company;
use App\Models\JobRole;
use App\Models\Candidate;
use App\Models\Education;
use App\Models\Experience;
use App\Models\Profession;
use App\Models\ContactInfo;
use Illuminate\Http\Request;
use App\Models\CandidateResume;
use App\Models\CandidateLanguage;
use App\Http\Traits\Candidateable;
use Illuminate\Support\Facades\DB;
use Modules\Location\Entities\City;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Modules\Location\Entities\State;
use App\Models\ProfessionTranslation;
use App\Http\Traits\CandidateSkillAble;
use App\Models\SkillTranslation;
use Modules\Language\Entities\Language;
use App\Models\Resumetemplate;
use App\Models\CandidateExperience;
use App\Models\CandidateEducation;
use App\Models\CandidateSkill;
use App\Models\CandidateLanguages;
use Illuminate\Support\Facades\File;
use App\Models\Responsibility;
use PDF;


class CandidateController extends Controller
{
    use Candidateable, CandidateSkillAble;

    public function dashboard()
    {
        $candidate = Candidate::where('user_id', auth()->id())->first();

        if (empty($candidate)) {

            $candidate = new Candidate();
            $candidate->user_id = auth()->id();
            $candidate->save();
        }

        $appliedJobs = $candidate->appliedJobs->count();
        $favoriteJobs = $candidate->bookmarkJobs->count();
        $jobs = $candidate->appliedJobs()->withCount(['bookmarkJobs as bookmarked' => function ($q) use ($candidate) {
            $q->where('candidate_id',  $candidate->id);
        }])
            ->latest()->limit(4)->get();
        // $notifications = auth('user')->user()->notifications()->count();
        $notifications = auth('user')->user()->notifications()->where('type', 'App\Notifications\Website\Candidate\RelatedJobNotification')->count();

        return view('website.pages.candidate.dashboard', compact('candidate', 'appliedJobs', 'jobs', 'favoriteJobs', 'notifications'));
    }

    public function allNotification()
    {

        $notifications = auth()->user()->notifications()->paginate(12);

        return view('website.pages.candidate.all-notification', compact('notifications'));
    }

    public function jobAlerts()
    {

        $notifications = auth()->user()->notifications()->where('type', 'App\Notifications\Website\Candidate\RelatedJobNotification')->paginate(12);

        return view('website.pages.candidate.job-alerts', compact('notifications'));
    }

    public function appliedjobs(Request $request)
    {

        $candidate = Candidate::where('user_id', auth()->id())->first();
        if (empty($candidate)) {

            $candidate = new Candidate();
            $candidate->user_id = auth()->id();
            $candidate->save();
        }

        $appliedJobs = $candidate->appliedJobs()->paginate(8);

        return view('website.pages.candidate.applied-jobs', compact('appliedJobs'));
    }

    public function bookmarks(Request $request)
    {
        $candidate = Candidate::where('user_id', auth()->id())->first();
        if (empty($candidate)) {

            $candidate = new Candidate();
            $candidate->user_id = auth()->id();
            $candidate->save();
        }

        $jobs = $candidate->bookmarkJobs()->withCount(['appliedJobs as applied' => function ($q) use ($candidate) {
            $q->where('candidate_id',  $candidate->id);
        }])->paginate(12);

        if (auth('user')->check() && auth('user')->user()->role == 'candidate') {
            $resumes = auth('user')->user()->candidate->resumes;
        } else {
            $resumes = [];
        }

        return view('website.pages.candidate.bookmark', compact('jobs', 'resumes'));
    }

    public function bookmarkCompany(Company $company)
    {

        $company->bookmarkCandidateCompany()->toggle(auth('user')->user()->candidate);
        return back();
    }

    public function setting()
    {
        $candidate = auth()->user()->candidate;

        if (empty($candidate)) {
            Candidate::create([
                'user_id' => auth()->id()
            ]);
        }

        // for contact
        $contactInfo = ContactInfo::where('user_id', auth()->id())->first();
        $contact = [];
        if ($contactInfo) {
            $contact = $contactInfo;
        } else {
            $contact = '';
        }

        // for social link
        $socials = auth()->user()->socialInfo;

        // for candidate resume/cv
        $resumes = $candidate->resumes;

        $job_roles = JobRole::all();
        $experiences = Experience::all();
        $educations = Education::all();
        $professions = Profession::all();
        $skills = Skill::all();
        $languages = CandidateLanguage::all(['id', 'name']);
        $candidate->load('skills', 'languages', 'experiences', 'educations');


        return view('website.pages.candidate.setting', [
            'candidate' => $candidate->load('skills', 'languages'),
            'contact' => $contact,
            'socials' => $socials,
            'job_roles' => $job_roles,
            'experiences' => $experiences,
            'educations' => $educations,
            'professions' => $professions,
            'resumes' => $resumes,
            'skills' => $skills,
            'candidate_languages' => $languages,
        ]);
    }

    public function getState(Request $request)
    {

        $states = State::where('country_id', $request->country_id)->get();
        return response()->json($states);
    }

    public function getCity(Request $request)
    {

        $cities = City::where('state_id', $request->state_id)->get();
        return response()->json($cities);
    }

    public function settingUpdate(Request $request)
    {
        $user = User::FindOrFail(auth()->id());
        $candidate = Candidate::where('user_id', $user->id)->first();
        $contactInfo = ContactInfo::where('user_id', auth()->id())->first();
        $request->session()->put('type', $request->type);

        if ($request->type == 'basic') {
            $this->candidateBasicInfoUpdate($request, $user, $candidate);
            $candidate->update(['profile_complete' => $candidate->profile_complete != 0 ? $candidate->profile_complete - 25 : 0]);
            flashSuccess(__('profile_updated'));
            return back();
        }

        if ($request->type == 'profile') {
            // return  $request->skills;
            $this->candidateProfileInfoUpdate($request, $user, $candidate, $contactInfo);
            $candidate->update(['profile_complete' => $candidate->profile_complete != 0 ? $candidate->profile_complete - 25 : 0]);
            flashSuccess(__('profile_updated'));
            return back();
        }

        if ($request->type == 'social') {
            $this->socialUpdate($request);
            $candidate->update(['profile_complete' => $candidate->profile_complete != 0 ? $candidate->profile_complete - 25 : 0]);
            flashSuccess(__('profile_updated'));
            return back();
        }

        if ($request->type == 'contact') {
            $this->contactUpdate($request, $candidate);
            $candidate->update(['profile_complete' => $candidate->profile_complete != 0 ? $candidate->profile_complete - 25 : 0]);
            flashSuccess(__('profile_updated'));
            return back();
        }

        if ($request->type == 'alert') {
            $this->alertUpdate($request, $user, $candidate);
            flashSuccess(__('profile_updated'));
            return back();
        }

        if ($request->type == 'visibility') {
            $this->visibilityUpdate($request, $candidate);
            flashSuccess(__('profile_updated'));
            return back();
        }

        if ($request->type == 'password') {
            $this->passwordUpdate($request, $user, $candidate);
            flashSuccess(__('profile_updated'));
            return back();
        }

        if ($request->type == 'account-delete') {
            $this->accountDelete($user);
        }

        return back();
    }

    public function candidateBasicInfoUpdate($request, $user, $candidate)
    {
        $request->validate([
            'name' => 'required',
            'birth_date' => 'date',
            'birth_date' =>  'required',
            'education' =>  'required',
            'experience' =>  'required',
        ]);
        $user->update(['name' => $request->name]);

        // Experience
        $experience_request = $request->experience;
        $experience = Experience::where('id', $experience_request)->first();

        if (!$experience) {
            $experience = Experience::create(['name' => $experience_request]);
        }

        // Education
        $education_request = $request->education;
        $education = Education::where('id', $education_request)->first();

        if (!$education) {
            $education = Education::create(['name' => $education_request]);
        }

        $dateTime = Carbon::parse($request->birth_date);
        $date = $request['birth_date'] = $dateTime->format('Y-m-d H:i:s');

        $candidate->update([
            'title' => $request->title,
            'experience_id' => $experience->id,
            'education_id' => $education->id,
            'website' => $request->website,
            'birth_date' => $date,
        ]);

        // image
        if ($request->image) {
            $request->validate([
                'image' =>  'image|mimes:jpeg,png,jpg,|max:2048'
            ]);

            deleteImage($candidate->photo);
            $path = 'images/candidates';
            $image = uploadImage($request->image, $path);

            $candidate->update([
                "photo" => $image,
            ]);
        }
        // cv
        if ($request->cv) {
            $request->validate([
                "cv" => "mimetypes:application/pdf,jpeg,docs|max:5048",
            ]);
            $pdfPath = "/file/candidates/";
            $pdf = pdfUpload($request->cv, $pdfPath);

            $candidate->update([
                "cv" => $pdf,
            ]);
        }
        return true;
    }

    public function candidateProfileInfoUpdate($request, $User, $candidate, $contactInfo)
    {
        $request->validate([
            'gender' => 'required',
            'marital_status' => 'required',
            'profession' => 'required',
            'status' =>  'required',
        ]);

        if ($request->status == 'available_in') {
            $request->validate([
                'available_in' =>  'required'
            ]);
        }

        // Profession
        $profession_request = $request->profession;
        $profession = ProfessionTranslation::where('profession_id', $profession_request)->orWhere('name', $profession_request)->first();

        if (!$profession) {
            $new_profession = Profession::create(['name' => $profession_request]);

            $languages = Language::all();
            foreach ($languages as $language) {
                $new_profession->translateOrNew($language->code)->name = $profession_request;
            }
            $new_profession->save();


            $profession_id = $new_profession->id;
        }else{
            $profession_id = $profession->profession_id;
        }

        $candidate->update([
            'gender' => $request->gender,
            'marital_status' => $request->marital_status,
            'bio' => $request->bio,
            'profession_id' => $profession_id,
            'status' => $request->status,
            'available_in' => $request->available_in ? Carbon::parse($request->available_in)->format('Y-m-d') : null,
        ]);

        // skill & language
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
                } else {
                    array_push($skillsArray, $skill_exists->skill_id);
                }
            }

            $candidate->skills()->attach($skillsArray);
        }

        $candidate->languages()->sync($request->languages);

        return true;
    }

    public function contactUpdate($request)
    {
        $contact = ContactInfo::where('user_id', auth()->id())->first();

        if (empty($contact)) {
            ContactInfo::create([
                'user_id' => auth()->id(),
                'phone' => $request->phone,
                'secondary_phone' => $request->secondary_phone,
                'email' => $request->email,
                'secondary_email' => $request->secondary_email,
            ]);
        } else {
            $contact->update([
                'phone' => $request->phone,
                'secondary_phone' => $request->secondary_phone,
                'email' => $request->email,
                'secondary_email' => $request->secondary_email,
            ]);
        }

        // Location
        updateMap(auth()->user()->candidate);

        return true;
    }

    public function socialUpdate($request)
    {
        $user = User::find(auth()->id());

        $user->socialInfo()->delete();
        $social_medias = $request->social_media;
        $urls = $request->url;

        if ($social_medias && $urls) {
            foreach ($social_medias as $key => $value) {
                if ($value && $urls[$key]) {
                    $user->socialInfo()->create([
                        'social_media' => $value,
                        'url' => $urls[$key],
                    ]);
                }
            }
        }

        return true;
    }

    public function visibilityUpdate($request, $candidate)
    {
        $candidate->update([
            'visibility' => $request->profile_visibility ? 1 : 0,
            'cv_visibility' => $request->cv_visibility ? 1 : 0
        ]);

        return true;
    }

    public function passwordUpdate($request, $user, $candidate)
    {
        $request->validate([
            'password' => 'required|confirmed|min:6',
            'password_confirmation' => 'required'
        ]);

        $user->update([
            'password' => Hash::make($request->password),
        ]);
        auth()->logout();

        return true;
    }

    public function accountDelete($user)
    {
        $user->delete();
        return true;
    }

    public function alertUpdate($request, $user, $candidate)
    {
        $user->update([
            'recent_activities_alert' => $request->recent_activity ? 1 : 0,
            'job_expired_alert' => $request->job_expired ? 1 : 0,
            'new_job_alert' => $request->new_job ? 1 : 0,
            'shortlisted_alert' => $request->shortlisted ? 1 : 0
        ]);

        // Jobrole
        $candidate->update([
            'role_id' => $request->role_id,
            'received_job_alert' => $request->received_job_alert ? 1 : 0,
        ]);

        return true;
    }

    /**
     *  Candidate resume upload with normal form
     * @param $request
     */
    public function resumeStore(Request $request)
    {
        $request->validate([
            'resume_name' => 'required',
            'resume_file' => 'required|mimes:pdf|max:5120',
        ]);

        $candidate = auth()->user()->candidate;
        $data['name'] = $request->resume_name;
        $data['candidate_id'] = $candidate->id;

        // cv
        if ($request->resume_file) {
            $pdfPath = "file/candidates/";
            $file = uploadFileToPublic($request->resume_file, $pdfPath);
            $data['file'] = $file;
        }

        CandidateResume::create($data);

        return back()->with('success', 'Resume added successfully');
    }

    /**
     *  Candidate resume upload with normal form
     * @param $request
     */
    public function resumeStoreAjax(Request $request)
    {

        $request->validate([
            'resume_name' => 'required',
            'resume_file' => 'required|mimes:pdf|max:5120',
        ]);

        $candidate = auth()->user()->candidate;
        $data['name'] = $request->resume_name;
        $data['candidate_id'] = $candidate->id;

        // cv
        if ($request->resume_file) {
            $pdfPath = "file/candidates/";
            $file = uploadFileToPublic($request->resume_file, $pdfPath);
            $data['file'] = $file;
        }

        CandidateResume::create($data);

        return response()->json(['success' => __('resume_added_successfully')]);
    }

    /**
     * Candidate all resume
     */
    public function getResumeAjax()
    {
        if (auth('user')->check() && auth('user')->user()->role == 'candidate') {
            $resumes = auth('user')->user()->candidate->resumes()->latest()->get();
        } else {
            $resumes = [];
        }

        return response()->json($resumes);
    }

    public function resumeUpdate(Request $request)
    {
        $request->validate([
            'resume_name' => 'required',
        ]);

        $resume = CandidateResume::where('id', $request->resume_id)->first();
        $candidate = auth()->user()->candidate;
        $data['name'] = $request->resume_name;
        $data['candidate_id'] = $candidate->id;

        // cv
        if ($request->resume_file) {
            $request->validate([
                'resume_file' => 'required|mimes:pdf|max:5120',
            ]);
            deleteFile($resume->file);
            $pdfPath = "file/candidates/";
            $file = uploadFileToPublic($request->resume_file, $pdfPath);
            $data['file'] = $file;
        }

        $resume->update($data);

        return back()->with('success', 'Resume updated successfully');
    }

    public function resumeDelete(CandidateResume $resume)
    {
        deleteFile($resume->file);
        $resume->delete();

        return back()->with('success', 'Resume deleted successfully');
    }

    public function buildResume(Request $request)
    {
        $templates = Resumetemplate::where('status','1')->get();
        return view('website.resume.templates',compact('templates'));
    }

    public function candidateTemplate(Request $request)
    {
        $user = User::where('id',auth()->id())->first();
        $user->template_id = $request->template_id;
        $user->save();
        return response()->json([
            'result' => true
        ]);
    }

    public function sectionHeader()
    {
        $user = User::where('id',auth()->id())->first();
        $template = Resumetemplate::where('id',$user->template_id)->where('status','1')->first();
        $candidate = Candidate::where('user_id',auth()->id())->first();
        return view('website.resume.sec_header',compact('template','user','candidate'));
    }

    public function headerPost(Request $request)
    {
        $user = User::where('id',auth()->id())->first();
        $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users,email,'.$user->id,
            'mobile_num' => 'required|unique:users,mobile_num,'.$user->id,
            'photo' => 'image|mimes:jpg,png,jpeg',
            'city' => 'required',
            'country' => 'required',
            'pin_code' => 'required',
        ]);
        // if($user->template_id == "5" )
        // {
        //     $check = Candidate::where('user_id',auth()->id())->first();
        //     if($check->photo == "" ||  $check->photo == NULL)
        //     {
        //         $request->validate([
        //             'photo' => 'required|image|mimes:jpg,png,jpeg',
        //         ]);
        //     }
        // }
        $user->name = $request->name;
        $user->email = $request->email;
        $user->mobile_num = $request->mobile_num;
        $user->city = $request->city;
        $user->country = $request->country;
        $user->pin_code = $request->pin_code;
        $user->save();
        if($request->photo != null || $request->photo != "")
        {
            $candidate = Candidate::where('user_id',auth()->id())->first();
            $imagePath = public_path($candidate->photo);
            if(File::exists($imagePath)){
                unlink($imagePath);
            }
            $imageName = 'uploads/images/candidates/'.time().'.'.$request->photo->extension();  
            $request->photo->move(public_path('uploads/images/candidates'), $imageName);
            $candidate->photo = $imageName;
            $candidate->save();
        }

        return redirect()->route('candidate.section.experience');

    }

    public function previewHeader()
    {
        $user = User::where('id',auth()->id())->first();
        $candidate = Candidate::where('user_id',auth()->id())->first();
        $section = "header";

        if($user->template_id == "1")
        {
            return view('website.resume.preview.template1',compact('user','candidate','section'));
        }
        elseif($user->template_id == "2")
        {
            return view('website.resume.preview.template2',compact('user','candidate','section'));
        }
        elseif($user->template_id == "3")
        {
            return view('website.resume.preview.template3',compact('user','candidate','section'));
        }
        elseif($user->template_id == "4")
        {
            return view('website.resume.preview.template4',compact('user','candidate','section'));
        }
        elseif($user->template_id == "5")
        {
            return view('website.resume.preview.template5',compact('user','candidate','section'));
        }
        elseif($user->template_id == "6")
        {
            return view('website.resume.preview.template6',compact('user','candidate','section'));
        }
        else
        {
            return redirect()->route('candidate.build.resume');
        }
    }

    public function addExperience()
    {
        $add = "new";
        return view('website.resume.create_experience',compact('add'));
    }

    public function sectionExperience()
    {
        $user = User::where('id',auth()->id())->first();
        $template = Resumetemplate::where('id',$user->template_id)->where('status','1')->first();
        $candidate = Candidate::where('user_id',auth()->id())->first();
        $experiences = CandidateExperience::with('responsible')->where('candidate_id',$candidate->id)->get();
        if(count($experiences) > 0)
        {
            return view('website.resume.sec_experience',compact('template','user','candidate','experiences'));
        }
        else
        {
            return view('website.resume.create_experience');
        }
    }

    public function experiencePost(Request $request)
    {
        $request->validate([
            'company' => 'required',
            'company_location' => 'required',
            'department' => 'required',
            'designation' => 'required',
            'start' =>  'required',
        ]);

        $start_date = $request->start ? formatTime($request->start, 'Y-m-d'): null;
        $end_date = $request->end ? formatTime($request->end, 'Y-m-d'): null;

        $experience = CandidateExperience::create([
            'candidate_id' => currentCandidate()->id,
            'company' => $request->company,
            'company_location' => $request->company_location,
            'department' => $request->department,
            'designation' => $request->designation,
            'start' => $start_date,
            'end' => $end_date,
            'currently_working' => $request->currently_working ?? 0,
        ]);

        if(count($request->responsibility) > 0)
        {   
            $responsibilities = $request->responsibility;
            foreach($responsibilities as $responsibility)
            {
                $response = new Responsibility();
                $response->candidate_experiences_id = $experience->id;
                $response->responsibility = $responsibility;
                $response->save();
            }
        }

        return redirect()->route('candidate.section.experience');
    }

    public function noExperience()
    {
        $user = User::where('id',auth()->id())->first();
        $user->fresher = "1";
        $user->save();
        return redirect()->route('candidate.section.education');
    }

    public function editExperience(Request $request)
    {
        $user = User::where('id',auth()->id())->first();
        $candidate = Candidate::where('user_id',auth()->id())->first();
        $experience = CandidateExperience::with('responsible')->where('id',$request->id)->where('candidate_id',$candidate->id)->first();
        // echo "<pre>";print_r($experiences->toArray());exit();
        return view('website.resume.edit_experience',compact('experience'));
    }

    public function experienceUpdate(Request $request)
    {
        $request->validate([
            'company' => 'required',
            'company_location' => 'required',
            'department' => 'required',
            'designation' => 'required',
            'start' =>  'required',
            'end' => 'sometimes',
        ]);

        $start_date = $request->start ? formatTime($request->start, 'Y-m-d'): null;
        $end_date = $request->end ? formatTime($request->end, 'Y-m-d'): null;

        $user = User::where('id',auth()->id())->first();
        $candidate = Candidate::where('user_id',auth()->id())->first();
        $experience = CandidateExperience::where('id',$request->id)->first();
        $experience->company = $request->company;
        $experience->company_location = $request->company_location;
        $experience->department = $request->department;
        $experience->designation = $request->designation;
        $experience->start = $start_date;
        $experience->end = $end_date;
        $experience->currently_working = $request->currently_working ?? 0;
        $experience->save();
        Responsibility::where('candidate_experiences_id',$request->id)->delete();

        if(count($request->responsibility) > 0)
        {   
            $responsibilities = $request->responsibility;
            foreach($responsibilities as $responsibility)
            {
                $response = new Responsibility();
                $response->candidate_experiences_id = $request->id;
                $response->responsibility = $responsibility;
                $response->save();
            }
        }

        return redirect()->route('candidate.section.experience');
    }

    public function previewExperience()
    {
        $user = User::where('id',auth()->id())->first();
        $candidate = Candidate::where('user_id',auth()->id())->first();
        $experiences = CandidateExperience::with('responsible')->where('candidate_id',$candidate->id)->get();
        $section = "experiences";

        if($user->template_id == "1")
        {
            return view('website.resume.preview.template1',compact('user','candidate','experiences','section'));
        }
        elseif($user->template_id == "2")
        {
            return view('website.resume.preview.template2',compact('user','candidate','experiences','section'));
        }
        elseif($user->template_id == "3")
        {
            return view('website.resume.preview.template3',compact('user','candidate','experiences','section'));
        }
        elseif($user->template_id == "4")
        {
            return view('website.resume.preview.template4',compact('user','candidate','experiences','section'));
        }
        elseif($user->template_id == "5")
        {
            return view('website.resume.preview.template5',compact('user','candidate','experiences','section'));
        }
        elseif($user->template_id == "6")
        {
            return view('website.resume.preview.template6',compact('user','candidate','experiences','section'));
        }
        else
        {
            return redirect()->route('candidate.build.resume');
        }
    } 

    public function deleteExperience(Request $request)
    {
        CandidateExperience::where('id',$request->id)->delete();
        Responsibility::where('candidate_experiences_id',$request->id)->delete();
        return redirect()->route('candidate.section.experience');
    }

    public function sectionEducation()
    {
        $user = User::where('id',auth()->id())->first();
        $template = Resumetemplate::where('id',$user->template_id)->where('status','1')->first();
        $candidate = Candidate::where('user_id',auth()->id())->first();
        $educations = CandidateEducation::where('candidate_id',$candidate->id)->get();
        $experiences = CandidateExperience::with('responsible')->where('candidate_id',$candidate->id)->get();
        if(count($educations) > 0)
        {
            return view('website.resume.sec_education',compact('educations','user'));
        }
        else
        {
            $add = "new";
            return view('website.resume.create_education',compact('user','experiences','add'));
        }
    }

    public function addEducation()
    {
        $user = User::where('id',auth()->id())->first();
        $candidate = Candidate::where('user_id',auth()->id())->first();
        $experiences = CandidateExperience::with('responsible')->where('candidate_id',$candidate->id)->get();
        return view('website.resume.create_education',compact('user','experiences'));
    }

    public function educationPost(Request $request)
    {
        $request->validate([
            'university' => 'required',
            'location' => 'required',
            'qualification' => 'required',
            'year' => 'required',
        ]);

        $user = User::where('id',auth()->id())->first();
        $candidate = Candidate::where('user_id',auth()->id())->first();
        $education = new CandidateEducation();
        $education->candidate_id = $candidate->id;
        $education->university = $request->university;
        $education->location = $request->location;
        $education->qualification = $request->qualification;
        $education->year = $request->year;
        $education->save();

        return redirect()->route('candidate.section.education');
    }

    public function editEducation(Request $request)
    {
        $edu = CandidateEducation::where('id',$request->id)->first();
        return view('website.resume.edit_education',compact('edu'));
    }

    public function updateEducation(Request $request)
    {
        $request->validate([
            'university' => 'required',
            'location' => 'required',
            'qualification' => 'required',
            'year' => 'required',
        ]);

        $education = CandidateEducation::where('id',$request->id)->first();
        $education->university = $request->university;
        $education->location = $request->location;
        $education->qualification = $request->qualification;
        $education->year = $request->year;
        $education->save();

        return redirect()->route('candidate.section.education');
    }

    public function previewEducation()
    {
        $user = User::where('id',auth()->id())->first();
        $candidate = Candidate::where('user_id',auth()->id())->first();
        $experiences = CandidateExperience::with('responsible')->where('candidate_id',$candidate->id)->get();
        $educations = CandidateEducation::where('candidate_id',$candidate->id)->get();
        $section = "education";

        if($user->template_id == "1")
        {
            return view('website.resume.preview.template1',compact('user','candidate','experiences','section','educations'));
        }
        elseif($user->template_id == "2")
        {
            return view('website.resume.preview.template2',compact('user','candidate','experiences','section','educations'));
        }
        elseif($user->template_id == "3")
        {
            return view('website.resume.preview.template3',compact('user','candidate','experiences','section','educations'));
        }
        elseif($user->template_id == "4")
        {
            return view('website.resume.preview.template4',compact('user','candidate','experiences','section','educations'));
        }
        elseif($user->template_id == "5")
        {
            return view('website.resume.preview.template5',compact('user','candidate','experiences','section','educations'));
        }
        elseif($user->template_id == "6")
        {
            return view('website.resume.preview.template6',compact('user','candidate','experiences','section','educations'));
        }
        else
        {
            return redirect()->route('candidate.build.resume');
        }
    } 


    public function deleteEducation(Request $request)
    {
        CandidateEducation::where('id',$request->id)->delete();
        return redirect()->route('candidate.section.education');
    }

    public function sectionSkills()
    {
        $user = User::where('id',auth()->id())->first();
        $template = Resumetemplate::where('id',$user->template_id)->where('status','1')->first();
        $candidate = Candidate::where('user_id',auth()->id())->first();
        $skills_id = CandidateSkill::where('candidate_id',$candidate->id)->get()->pluck('skill_id');
        $candidate_skills = Skill::whereIn('id',$skills_id)->get();
        $skills = Skill::all();
        if(count($candidate_skills) > 0)
        {
            return view('website.resume.sec_skills',compact('user','candidate_skills'));
        }
        else
        {
            $add = "new";
            return view('website.resume.create_skills',compact('skills','candidate','add'));
        }

    }

    public function addSkill()
    {
        $skills = Skill::all();
        $user = User::where('id',auth()->id())->first();
        $candidate = Candidate::where('user_id',auth()->id())->first();
        // $skills_id = CandidateSkill::where('candidate_id',$candidate->id)->get();
        //echo "<pre>";print_r($skills->toArray());exit();    
        return view('website.resume.create_skills',compact('skills','candidate'));
    }

    public function skillsPost(Request $request)
    {

        if(!isset($request->skills))
        {
            return redirect()->back()->with('message','The Skill Field is Required!');
        }
        $skills = $request->skills;
        $user = User::where('id',auth()->id())->first();
        $candidate = Candidate::where('user_id',auth()->id())->first();
        DB::table('candidate_skill')->where('candidate_id', $candidate->id)->delete();

        if ($skills) {
            $skillsArray = [];
            $skilldata = [];
            foreach ($skills as $skill) {
                if(is_numeric($skill))
                {
                    $skill_exists = SkillTranslation::where('skill_id', $skill)->orWhere('name', $skill)->first();

                    if (!$skill_exists) {
                        $select_tag = Skill::create(['name' => $skill]);

                        $languages = Language::all();
                        foreach ($languages as $language) {
                            $select_tag->translateOrNew($language->code)->name = $skill;
                        }
                        $select_tag->save();

                        array_push($skillsArray, $select_tag->id);
                    } else {
                        array_push($skillsArray, $skill_exists->skill_id);
                    }
                }
                else
                {
                    array_push($skilldata,$skill);
                }
            }

            $candidate->skills()->attach($skillsArray);
        }
        if(count($skilldata) > 0)
        {
            foreach($skilldata as $key => $value)
            {
                $skill = new Skill();
                $skill->name = $value;
                $skill->save();

                $skill_trans = new SkillTranslation();
                $skill_trans->skill_id = $skill->id;
                $skill_trans->name = $value;
                $skill_trans->locale = "fr";
                $skill_trans->save();

                $candidate_skill = new CandidateSkill();
                $candidate_skill->candidate_id = $candidate->id;
                $candidate_skill->skill_id = $skill->id;
                $candidate_skill->save();
            }
        }
        return redirect()->route('candidate.section.skills');
    }

    public function previewSkills()
    {
        $user = User::where('id',auth()->id())->first();
        $candidate = Candidate::where('user_id',auth()->id())->first();
        $experiences = CandidateExperience::with('responsible')->where('candidate_id',$candidate->id)->get();
        $educations = CandidateEducation::where('candidate_id',$candidate->id)->get();
        $skills_id = CandidateSkill::where('candidate_id',$candidate->id)->get()->pluck('skill_id');
        $candidate_skills = Skill::whereIn('id',$skills_id)->get();
        $section = "skills";

        if($user->template_id == "1")
        {
            return view('website.resume.preview.template1',compact('user','candidate','experiences','section','educations','candidate_skills'));
        }
        elseif($user->template_id == "2")
        {
            return view('website.resume.preview.template2',compact('user','candidate','experiences','section','educations','candidate_skills'));
        }
        elseif($user->template_id == "3")
        {
            return view('website.resume.preview.template3',compact('user','candidate','experiences','section','educations','candidate_skills'));
        }
        elseif($user->template_id == "4")
        {
            return view('website.resume.preview.template4',compact('user','candidate','experiences','section','educations','candidate_skills'));
        }
        elseif($user->template_id == "5")
        {
            return view('website.resume.preview.template5',compact('user','candidate','experiences','section','educations','candidate_skills'));
        }
        elseif($user->template_id == "6")
        {
            return view('website.resume.preview.template6',compact('user','candidate','experiences','section','educations','candidate_skills'));
        }
        else
        {
            return redirect()->route('candidate.build.resume');
        }
    } 

    public function sectionSummary()
    {
        $user = User::where('id',auth()->id())->first();
        $candidate = Candidate::with('languages')->where('user_id',auth()->id())->first();
        $lang = CandidateLanguage::all();
        if($user->summary != "" && $user->summary != NULL )
        {
            if(count($candidate->languages) > 0)
            {
                return view('website.resume.summary',compact('user','candidate','lang'));
            }
            else
            {
                $add = "new";
                $candidate_languages = CandidateLanguage::all();
                return view('website.resume.create_languages',compact('candidate_languages','candidate','add'));
            }
        }
        else
        {
            $add = "new";
            return view('website.resume.create_summary',compact('user','add'));
        }
    }

    public function addSummary()
    {
        return view('website.resume.create_summary');
    }
    public function editSummary()
    {
        $user = User::where('id',auth()->id())->first();
        return view('website.resume.edit_summary',compact('user'));
    }



    public function summaryPost(Request $request)
    {
        $request->validate([
            'summary' => 'required',
        ]);
        $user = User::where('id',auth()->id())->first();
        $user->summary = $request->summary;
        $user->save();
        return redirect()->route('candidate.section.summary');
    }

    public function addLanguages()
    {
        $candidate = Candidate::with('languages')->where('user_id',auth()->id())->first();
        $candidate_languages = CandidateLanguage::all();
        return view('website.resume.create_languages',compact('candidate_languages','candidate'));
    }

    public function languagesPost(Request $request)
    {
        $user = User::where('id',auth()->id())->first();
        $candidate = Candidate::where('user_id',auth()->id())->first();
        if(!isset($request->languages))
        {
            return redirect()->back()->with('message','Please Choose your Languages!');
        }
        $languages = $request->languages;
        if(count($languages)>0)
        {
            CandidateLanguages::where('candidate_id',$candidate->id)->delete();
            foreach($languages as $user_lang)
            {
                $lang = new CandidateLanguages();
                $lang->candidate_id = $candidate->id;
                $lang->candidate_language_id = $user_lang;
                $lang->save();
            }
        }
        
        return redirect()->route('candidate.section.summary');
    }

    public function sectionFinalize()
    {
        $user = User::where('id',auth()->id())->first();
        $candidate = Candidate::with('languages')->where('user_id',auth()->id())->first();
        $educations = CandidateEducation::where('candidate_id',$candidate->id)->get();
        $skills_id = CandidateSkill::where('candidate_id',$candidate->id)->get()->pluck('skill_id');
        $candidate_skills = Skill::whereIn('id',$skills_id)->get();
        $experiences = CandidateExperience::with('responsible')->where('candidate_id',$candidate->id)->get();

        if($user->template_id == "1")
        {
            return view('website.resume.template.template1',compact('user','educations','candidate_skills','experiences','candidate'));
        }
        elseif($user->template_id == "2")
        {
            return view('website.resume.template.template2',compact('user','educations','candidate_skills','experiences','candidate'));
        }
        elseif($user->template_id == "3")
        {
            return view('website.resume.template.template3',compact('user','educations','candidate_skills','experiences','candidate'));
        }
        elseif($user->template_id == "4")
        {
            return view('website.resume.template.template4',compact('user','educations','candidate_skills','experiences','candidate'));
        }
        elseif($user->template_id == "5")
        {
            return view('website.resume.template.template5',compact('user','educations','candidate_skills','experiences','candidate'));
        }
        elseif($user->template_id == "6")
        {
            return view('website.resume.template.template6',compact('user','educations','candidate_skills','experiences','candidate'));
        }
        else
        {
            return redirect()->route('candidate.build.resume');
        }
    }

    public function downloadResume(Request $request)
    {   
        $user = User::where('id',auth()->id())->first();
        $candidate = Candidate::with('languages')->where('user_id',auth()->id())->first();
        $educations = CandidateEducation::where('candidate_id',$candidate->id)->get();
        $skills_id = CandidateSkill::where('candidate_id',$candidate->id)->get()->pluck('skill_id');
        $candidate_skills = Skill::whereIn('id',$skills_id)->get();
        $experiences = CandidateExperience::with('responsible')->where('candidate_id',$candidate->id)->get();
        if($user->template_id == "1")
        {
            $pdf = PDF::loadView('website.resume.pdf.template1',compact('user','educations','candidate_skills','experiences','candidate'));
            return $pdf->download($user->name.time().'.pdf');
        }
        elseif($user->template_id == "2")
        {
            $pdf = PDF::loadView('website.resume.pdf.template2',compact('user','educations','candidate_skills','experiences','candidate'));
            return $pdf->download($user->name.time().'.pdf');
        }
        elseif($user->template_id == "3")
        {
            $pdf = PDF::loadView('website.resume.pdf.template3',compact('user','educations','candidate_skills','experiences','candidate'));
            return $pdf->download($user->name.time().'.pdf');
        }
        elseif($user->template_id == "4")
        {
            $pdf = PDF::loadView('website.resume.pdf.template4',compact('user','educations','candidate_skills','experiences','candidate'));
            return $pdf->download($user->name.time().'.pdf');
        }
        elseif($user->template_id == "5")
        {
            $pdf = PDF::loadView('website.resume.pdf.template5',compact('user','educations','candidate_skills','experiences','candidate'));
            return $pdf->download($user->name.time().'.pdf');
        }
        elseif($user->template_id == "6")
        {
            $pdf = PDF::loadView('website.resume.pdf.template6',compact('user','educations','candidate_skills','experiences','candidate'));
            return $pdf->download($user->name.time().'.pdf');
            // return view('website.resume.pdf.template6',compact('user','educations','candidate_skills','experiences','candidate'));
        }
        else
        {
            return redirect()->route('candidate.build.resume');
        }
    }
}

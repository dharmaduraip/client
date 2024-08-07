<?php

namespace App\Http\Controllers\Auth;

use App\Models\Job;
use App\Models\User;
use App\Models\Admin;
use App\Models\Company;
use App\Models\Setting;
use App\Models\Candidate;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Providers\RouteServiceProvider;
use App\Http\Traits\HasCountryBasedJobs;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Notification;
use Illuminate\Foundation\Auth\RegistersUsers;
use App\Notifications\CompanyCreatedNotification;
use App\Notifications\CandidateCreateNotification;
use App\Notifications\Admin\NewUserRegisteredNotification;
use App\Notifications\CompanyCreateApprovalPendingNotification;
use App\Notifications\CandidateCreateApprovalPendingNotification;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers, HasCountryBasedJobs;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\View\View
     */
    public function showRegistrationForm(Request $request)
    {
        $data['newjobs'] = $this->filterCountryBasedJobs(Job::withoutEdited()->newJobs())->count();
        $data['role'] = $request->user;

        return view('auth.register', $data);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'g-recaptcha-response' => config('captcha.active') ? 'required|captcha' : ''
        ], [
            'g-recaptcha-response.required' => 'Please verify that you are not a robot.',
            'g-recaptcha-response.captcha' => 'Captcha error! try again later or contact site admin.',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        $newUsername = Str::slug($data['name']);
        $oldUserName = User::where('username', $newUsername)->first();

        if ($oldUserName) {
            $username = Str::slug($newUsername) . '_' . Str::random(5);
        } else {
            $username = Str::slug($newUsername);
        }

        $user = User::create([
            'role' => $data['role'] == 'candidate' ? 'candidate' : 'company',
            'name' => $data['name'],
            'username' => $username,
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        try {
            $admins = Admin::all();
            foreach ($admins as $admin) {
                Notification::send($admin, new NewUserRegisteredNotification($admin, $user));
            }
        } catch (\Throwable $th) {}

        // if mail configured, send notification to candidate and company
        if (checkMailConfig()) {
            if ($user->role == "candidate") {
                $candidate_account_auto_activation_enabled = Setting::where("candidate_account_auto_activation", 1)->count();

                if ($candidate_account_auto_activation_enabled) {
                    Notification::route('mail', $user->email)->notify(new CandidateCreateNotification($user, $data['password']));
                } else {
                    Notification::route('mail', $user->email)->notify(new CandidateCreateApprovalPendingNotification($user, $data['password']));
                }
            } elseif ($user->role == "company") {
                $employer_auto_activation_enabled = Setting::where("employer_auto_activation", 1)->count();

                if ($employer_auto_activation_enabled) {
                    Notification::route('mail', $user->email)->notify(new CompanyCreatedNotification($user, $data['password']));
                } else {
                    Notification::route("mail", $user->email)->notify(new CompanyCreateApprovalPendingNotification($user, $data['password']));
                }
            }
        }
        
        return $user;
    }
}

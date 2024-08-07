<?php

namespace App\Http\Controllers\Auth;

use App\Models\Job;
use App\Http\Controllers\Controller;
use App\Http\Traits\HasCountryBasedJobs;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails, HasCountryBasedJobs;

    /**
     * Display the form to request a password reset link.
     *
     * @return \Illuminate\View\View
     */
    public function showLinkRequestForm()
    {
        if (!checkMailConfig()) {
                flashError(__('mail_not_sent_for_the_reason_of_incomplete_mail_configuration'));
        }

        $data['newjobs'] = $this->filterCountryBasedJobs(Job::withoutEdited()->newJobs())->count();

        return view('auth.passwords.email', $data);
    }
}

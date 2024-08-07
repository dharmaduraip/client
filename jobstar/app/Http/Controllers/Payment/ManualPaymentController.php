<?php

namespace App\Http\Controllers\Payment;

use App\Models\Admin;
use AmrShawky\Currency;
use App\Models\Earning;
use App\Models\UserPlan;
use Illuminate\Http\Request;
use App\Models\ManualPayment;
use Modules\Plan\Entities\Plan;
use App\Http\Traits\PaymentTrait;
use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\Support\Facades\Notification;
use App\Notifications\Admin\NewPlanPurchaseNotification;
use App\Notifications\Website\Company\PaymentMarkPaidNotification;

class ManualPaymentController extends Controller
{
    use PaymentTrait;

    public function paymentPlace(Request $request)
    {
        $job_payment_type = session('job_payment_type') ?? 'package_job';

        if ($job_payment_type == 'per_job') {
            $price = session('job_total_amount') ?? '100';
        }else{
            $plan = Plan::findOrFail($request->plan_id);
            $price = $plan->price;
        }

        $payment = ManualPayment::findOrFail($request->payment_id);
        $usd_amount = currencyConversion($price, null, 'USD');
        // $usd_amount = currencyConversion($price);

        Earning::create([
            'order_id' => uniqid(),
            'transaction_id' => uniqid('tr_'),
            'payment_provider' => 'offline',
            'plan_id' => $plan->id ?? null,
            'company_id' => auth('user')->user()->company->id,
            'amount' => $price,
            'currency_symbol' => config('jobpilot.currency_symbol'),
            'usd_amount' => $usd_amount,
            'manual_payment_id' => $payment->id,
            'payment_type' => $job_payment_type == 'per_job' ? 'per_job_based' : 'subscription_based',
        ]);

        if ($job_payment_type == 'per_job') {
            return $this->storeJobData();
        }

        // Session forget
        $this->forgetSessions();

        session()->flash('success', __('payment_is_placed_waiting_for_approval'));
        return redirect()->route('company.plan');
    }

    public function markPaid(Earning $order)
    {
        $order->update([
            'payment_status' => 'paid',
        ]);
        $plan = Plan::findOrFail($order->plan_id);
        $user_plan = UserPlan::where('company_id', $order->company_id)->first();
        //Days calculation
        $today=date('Y-m-d');
        $days_count = '+'.$plan['days'].' days';
        $expire_date=Date('Y-m-d', strtotime($days_count));
        //end
        $company = Company::where('id', $order->company_id)->first();

        if ($user_plan) {
            /*$user_plan->update([
                'plan_id' => $plan->id,
                'job_limit' => $user_plan->job_limit + $plan->job_limit,
                'featured_job_limit' => $user_plan->featured_job_limit + $plan->featured_job_limit,
                'highlight_job_limit' => $user_plan->highlight_job_limit + $plan->highlight_job_limit,
                'candidate_cv_view_limit' => $user_plan->candidate_cv_view_limit + $plan->candidate_cv_view_limit,
                'candidate_cv_view_limitation' => $plan->candidate_cv_view_limitation,
                'buy_date' => $today,
                'expire_date' => $expire_date,
            ]);*/
            $user_plan->update([
                'plan_id' => $plan->id,
                'job_limit' =>  $plan->job_limit,
                'featured_job_limit' => $plan->featured_job_limit,
                'highlight_job_limit' =>  $plan->highlight_job_limit,
                'candidate_cv_view_limit' =>  $plan->candidate_cv_view_limit,
                'candidate_cv_view_limitation' => $plan->candidate_cv_view_limitation,
                'buy_date' => $today,
                'expire_date' => $expire_date,
            ]);
        } else {
            $company->userPlan()->create([
                'plan_id'  =>  $plan->id,
                'job_limit'  =>  $plan->job_limit,
                'featured_job_limit'  =>  $plan->featured_job_limit,
                'highlight_job_limit'  =>  $plan->highlight_job_limit,
                'candidate_cv_view_limit'  =>  $plan->candidate_cv_view_limit,
                'candidate_cv_view_limitation'  =>  $plan->candidate_cv_view_limitation,
                'buy_date' => $today,
                'expire_date' => $expire_date,
            ]);
        }

        $user = $order->company->user;

        if (checkMailConfig()) {
            // make notification to admins for approved
            $admins = Admin::all();
            foreach ($admins as $admin) {
                Notification::send($admin, new NewPlanPurchaseNotification($admin, $order, $plan, $user));
            }
        }

        $order->company->user->notify(new PaymentMarkPaidNotification());

        session()->flash('success', __('payment_is_mark_as_paid'));
        return back();
    }
}

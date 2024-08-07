<?php

namespace App\Http\Controllers\Payment;

use Razorpay\Api\Api;
use Illuminate\Http\Request;
use App\Models\Earning;
use App\Models\UserPlan;
use Modules\Plan\Entities\Plan;
use App\Http\Traits\PaymentTrait;
use App\Http\Controllers\Controller;
use App\Notifications\MembershipUpgradeNotification;

class RazorpayController extends Controller
{
    use PaymentTrait;

    public function payment(Request $request)
    {
        $job_payment_type = session('job_payment_type') ?? 'package_job';
        if ($job_payment_type == 'per_job') {
            $price = session('job_total_amount') ?? '100';
        }else{
            $plan = session('plan');
            $price = $plan->price;
        }

        $amount = currencyConversion($price, null, 'INR', 1);
        $converted_amount = currencyConversion($price, null, 'USD');
        // $converted_amount = currencyConversion($price);

        session(['order_payment' => [
            'payment_provider' => 'razorpay',
            'amount' =>  $amount,
            'currency_symbol' => '₹',
            'usd_amount' =>  $converted_amount,
        ]]);

        $input = $request->all();
        $api = new Api(config('zakirsoft.razorpay_key'), config('zakirsoft.razorpay_secret'));

        $payment = $api->payment->fetch($input['razorpay_payment_id']);

        if (count($input)  && !empty($input['razorpay_payment_id'])) {
            try {
                $payment->capture(array('amount' => $payment['amount']));

                session(['transaction_id' => $input['razorpay_payment_id'] ?? null]);
                $this->orderPlacing();
            } catch (\Exception $e) {
                return $e->getMessage();
                session()->put('error', $e->getMessage());
                return redirect()->back();
            }
        }
    }
    
    public function purchasePlan(Request $request)
    {
        $plan = Plan::findOrFail($request->plan);
        $user = auth()->user();
        $company = $user->company;

        $today=date('Y-m-d');
        $days_count = '+'.$plan->days.' days';
        $expire_date=Date('Y-m-d', strtotime($days_count));

        $order = UserPlan::where('company_id', $company->id)->where('plan_id', $plan->id)->where('expire_date', '<', $today )->first();
        if($order){
            $response['message'] = 'You have already purchase this plan';
            $status = 200;
            return \Response::json($response,$status);
        }

        $user_plan = UserPlan::where('company_id', $company->id)->first();

        if ($user_plan) {

            $user_plan->update([
                'plan_id' => $plan->id,
                'job_limit' => /*$user_plan->job_limit + */$plan->job_limit,
                'featured_job_limit' => /*$user_plan->featured_job_limit + */$plan->featured_job_limit,
                'highlight_job_limit' => /*$user_plan->highlight_job_limit + */$plan->highlight_job_limit,
                'candidate_cv_view_limit' => /*$user_plan->candidate_cv_view_limit + */$plan->candidate_cv_view_limit,
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

        Earning::create([
            'order_id' => rand(1000, 999999999),
            'transaction_id' => $request->payment_id,
            'payment_provider' => 'razorpay',
            'plan_id' => $plan->id ?? null,
            'company_id' =>  auth()->user()->company->id,
            'amount' => $plan->price,
            'currency_symbol' => config('jobpilot.currency_symbol'),
            'usd_amount' => $plan->price,
            'payment_type' => 'subscription_based',
            'payment_status' => 'paid',
        ]);


        $response['message'] = 'plan successfully purchased';
        $status = 200;
        return \Response::json($response,$status);
    }
}

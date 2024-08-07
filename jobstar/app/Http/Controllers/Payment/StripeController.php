<?php

namespace App\Http\Controllers\Payment;

use Stripe\Charge;
use Stripe\Stripe;
use Stripe\Customer;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Modules\Plan\Entities\Plan;
use App\Http\Traits\PaymentTrait;
use App\Http\Controllers\Controller;
use App\Notifications\MembershipUpgradeNotification;

class StripeController extends Controller
{
    use PaymentTrait;

    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
  /*  public function stripePost(Request $request)
    {
        $job_payment_type = session('job_payment_type') ?? 'package_job';

        if ($job_payment_type == 'per_job') {
            $price = session('job_total_amount') ?? '100';
        }else{
            $plan = session('plan');
            $price = $plan->price;
        }

        $converted_amount = currencyConversion($price);

        session(['order_payment' => [
            'payment_provider' => 'stripe',
            'amount' =>  $converted_amount,
            'currency_symbol' => '$',
            'usd_amount' =>  $converted_amount,
        ]]);

        try {
            Stripe::setApiKey(config('zakirsoft.stripe_secret'));

            if ($job_payment_type == 'per_job') {
                $description = "Payment for job post in " . config('app.name');
            }else{
                $description = "Payment for " . $plan->name. " plan purchase" . " in " . config('app.name');
            }

            $charge = Charge::create([
                "amount" => session('stripe_amount'),
                "currency" => 'USD',
                "source" => $request->stripeToken,
                "description" => $description,
            ]);

            session(['transaction_id' => $charge->id ?? null]);
            $this->orderPlacing();
        } catch (\Exception $ex) {
            return $ex->getMessage();
        }
    } */
    public function stripePost(Request $request)
    {

        $job_payment_type = session('job_payment_type') ?? 'package_job';

        if ($job_payment_type == 'per_job') {
            $price = session('job_total_amount') ?? '100';
        }else{
            $plan = session('plan');
            $price = $plan->price;
        }
        $converted_amount = currencyConversion($price, null, 'INR');
        $usd_amount = currencyConversion($price, null, 'USD');
        // $usd_amount = currencyConversion($price);

        session(['order_payment' => [
            'payment_provider' => 'stripe',
            // 'amount' =>  $price,
            'amount' =>  $converted_amount,
            // 'currency_symbol' => '$',
            'currency_symbol' => '₹',
            'usd_amount' =>  $usd_amount,
        ]]);

        try {

            Stripe::setApiKey(config('zakirsoft.stripe_secret'));

            if ($job_payment_type == 'per_job') {
                $description = "Payment for job post in " . config('app.name');
            }else{
                $description = "Payment for " . $plan->name. " plan purchase" . " in " . config('app.name');
            }

			$checkout_session = \Stripe\Checkout\Session::create([
			'line_items' => [[
				'price_data' => [
				 // 'currency' => 'usd',
                 'currency' => 'INR',
				  'product_data' => [
					'name' => $description,
				  ],
				  'unit_amount' => session('stripe_amount'),
				],
				'quantity' => 1,
			  ]],
			  'mode' => 'payment',
			  'success_url' => url("stripe/success").'?session_id={CHECKOUT_SESSION_ID}',
			  'cancel_url' => url("stripe/cancel"),
			]);

		return redirect($checkout_session->url);

        } catch (\Exception $ex) {
            return $ex->getMessage();
        }
    }
	public function stripetype(Request $request)
    {
			if($request->type == 'success'){
			$stripe = new \Stripe\StripeClient(config('zakirsoft.stripe_secret'));
				$det_session = $stripe->checkout->sessions->retrieve(
				  $request->session_id,
				  []
				);


            session(['transaction_id' => $charge->id ?? null]);
            $this->orderPlacing();
		} else {
			session()->flash('error', __('payment_was_failed'));
			return back();

		}
	}
}

<?php

namespace App\Http\Controllers\Admin;

use PDF;
use Carbon\Carbon;
use App\Models\Job;
use App\Models\User;
use App\Models\Company;
use App\Models\Earning;
use App\Models\Setting;
use App\Models\Candidate;
use App\Models\WebsiteSetting;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Modules\Location\Entities\Country;

class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('admin.home');
    }


    public function dashboard()
    {
        session(['layout_mode' => 'left_nav']);
        $jobs = Job::withoutEdited()->get();

        $data['all_jobs'] = $jobs->count();
        $data['active_jobs'] = $jobs->where('status', 'active')->count();
        $data['expire_jobs'] = $jobs->where('status', 'expired')->count();
        $data['pending_jobs'] = $jobs->where('status', 'pending')->count();

        // $data['verified_users'] = User::whereNotNull('email_verified_at')->count();
        $candi = Candidate::withCount('appliedJobs')->with('user','jobRole')->whereHas('user', function($can) {
            $can->whereNotNull('email_verified_at');
        })->count();
        $comp = Company::whereHas('user', function($comp){
            $comp->whereNotNull('email_verified_at');
        })->count();
        $data['verified_users'] = $candi + $comp;
        $data['candidates'] = Candidate::all()->count();
        $data['companies'] = Company::all()->count();

        /*$data['earnings'] = Earning::where('payment_status', 'paid')->get()->sum(function ($earning) {
            $currency = $earning->currency_symbol;
            $amount = 0;
            if($currency == '₹'){
                $amount = $earning->amount;
            }elseif($currency == '$'){
                $amount = $earning->amount * 83.25;
            }
            return $amount;
        });*/
        
        /*$data['earnings'] = currencyConversion(Earning::where('payment_status', 'paid')->sum('usd_amount'), 'USD', config('jobpilot.currency'));*/
        $data['earnings'] = Earning::where('payment_status', 'paid')->sum('amount');
        $data['email_verification'] = setting('email_verification');

        $months = Earning::select(
            \DB::raw('MIN(created_at) AS created_at'),
            \DB::raw('sum(usd_amount) as `amount`'),
            \DB::raw("DATE_FORMAT(created_at,'%M') as month")
        )
            ->where("created_at", ">", \Carbon\Carbon::now()->startOfYear())
            ->orderBy('created_at')
            ->groupBy('month')
            ->get();


        $earnings = $this->formatEarnings($months);
        $latest_jobs = Job::withoutEdited()->with(['company', 'job_type', 'experience'])->latest()->get()->take(10);

        $popular_countries = DB::table('jobs')
            ->select('country', DB::raw('count(*) as total'))
            ->orderBy('total', 'desc')
            ->groupBy('country')
            ->limit(10)
            ->get();

            $popular_countries;

        $latest_earnings = Earning::with('plan', 'manualPayment:id,name')->latest()->take(10)->get();

        $users = User::select(['id', 'name', 'email', 'role', 'status', 'email_verified_at', 'created_at', 'image', 'username'])->latest()->take(10)->get();

        return view('admin.index', compact('data', 'earnings', 'popular_countries', 'latest_jobs', 'latest_earnings', 'users'));
    }

    public function notificationRead()
    {

        foreach (auth()->user()->unreadNotifications as $notification) {
            $notification->markAsRead();
        }

        return response()->json(true);
    }

    public function allNotifications()
    {

        $notifications = auth()->user()->notifications()->paginate(20);

        return view('admin.notifications', compact('notifications'));
    }

    private function formatEarnings(object $data)
    {
        $amountArray = [];
        $monthArray = [];

        foreach ($data as $value) {
            array_push($amountArray, $value->amount);
            array_push($monthArray, $value->month);
        }

        return ['amount' => $amountArray, 'months' => $monthArray];
    }

    public function downloadTransactionInvoice(Earning $transaction)
    {
        $data['transaction'] = $transaction->load('plan', 'company.user.contactInfo');
        $data['logo'] = setting()->dark_logo_url ?? asset('frontend/assets/images/logo/logo.png');

        $pdf = PDF::loadView('website.pages.company.invoice', $data)->setOptions(['defaultFont' => 'sans-serif']);

        return $pdf->download("invoice_" . $transaction->order_id . ".pdf");
    }
}

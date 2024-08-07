<?php

namespace App\Exports;

use App\Http\Controllers\Excel;
use App\Models\Dailyreport;
use Request;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;



class DailyreportExport implements FromView,WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    use Exportable;

    public function __construct($request)
    {
        $this->request = $request->all();
    }
    public function headings(): array
    {
        return [
            'username',
            'phone_number',
            'email',
            'active',
            'address',
            'customer_wallet',
        ];
    }
    public function view(): View
    {
       $search     = $this->request->search ?? '';
        $location_id    = $this->request->location_id ?? '';
        $date       = $this->request->date ?? '';
        $status     = $this->request->status ?? '';
        // \DB::enableQueryLog();
        $customers      =  Dailyreport::query()->select('id','cust_id','date','res_id','grand_total','host_amount','fixedCommission','hiking','del_charge','admin_camount','delivery_type');
          return view('dailyreport.dailyreportexport', [
            'resultData' => $customers->get() 
        ]);
        print_r($customers);exit();
    }


}

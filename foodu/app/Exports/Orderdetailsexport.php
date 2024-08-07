<?php

namespace App\Exports;

use App\Http\Controllers\Excel;
use App\Models\Orderdetails;
use Request;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;



class Orderdetailsexport implements FromView,WithHeadings
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
        $customers      =  Orderdetails::query()->select('id','date','cust_id','mobile_num','address','res_id','accept_host_amount','gst','boy_id','accepted_time','dispatched_time','completed_time');
          return view('orderdetails.orderdetailsexport', [
            'resultData' => $customers->get() 
        ]);
        print_r($customers);exit();
    }


}

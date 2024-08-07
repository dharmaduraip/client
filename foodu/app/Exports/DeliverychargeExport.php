<?php

namespace App\Exports;

use App\Http\Controllers\Excel;
use App\Models\Deliverychargesettings;
use Request;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;



class DeliverychargeExport implements FromView,WithHeadings
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
        $customers      =  Deliverychargesettings::query()->select('charge_type','charge_value','order_value_min','order_value_max','distance_min','distance_max','tax','status');
          return view('deliverychargesettings.deliverychargeexport', [
            'resultData' => $customers->get() 
        ]);
         print_r($customers);exit();
    }


}

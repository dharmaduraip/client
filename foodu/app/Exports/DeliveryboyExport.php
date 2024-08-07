<?php

namespace App\Exports;

use App\Models\Deliveryboy;
use App\Http\Controllers\Excel;
use App\Models\Location;
use Request;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class DeliveryboyExport implements FromView,WithHeadings
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
            'S.No',
            'Username',
            'Email',
            'Phone Number',
            'Address',
            'Active',
            'Status',
        ];
    }
   
    public function view(): View
    {
        $search     = $this->request->search ?? '';
        $location_id    = $this->request->location_id ?? '';
        $date       = $this->request->date ?? '';
        $status     = $this->request->status ?? '';
        $deliveryboy      =  Deliveryboy::query()->select('username','email','phone_number','address','active','online_sts')->where('group_id','5');
    //     $partners = $partners->wherehas('locations',function ($result) use ($search,$date,$location_id,$status){
    //     if(!empty($search)){
    //      $result->Where('name', 'like', '%'.$search.'%')->orWhere('email', 'like', '%'.$search.'%')->orWhere('mobile', 'like', '%'.$search.'%');
    //     }
    //     if(!empty($location_id)){
    //         $result->Where('locations.id', $location_id);
    //     }
    //     if(!empty($status)){
    //        $result->Where('users.status', $status);
    //     }
    //     if (!empty($date)) {
    //         $sDate  = explode(" - ",$date);
    //         $result->whereBetween(\DB::raw('substr(users.created_at, 1, 10)'),[date('Y-m-d',strtotime($sDate[0])),date('Y-m-d',strtotime($sDate[1]))]);
    //     } 
    // });
         // $chefs = $chefs->get();
         //    echo "<pre>";print_r(\DB::getQueryLog());exit();
        // echo "<pre>";print_r($orders->get()->toArray());exit();
        return view('deliveryboy.deliveryboyexport', [
            'resultData' => $deliveryboy->get() 
        ]);
    }
}

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



class OrderdetailsExport implements FromView,WithHeadings
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
        
    }
    public function view(): View
    {
        $customers      =  Orderdetails::query('desc')->select('*')->where('status','0');
          return view('orderdetails.orderdetailsexport', [
            'resultData' => $customers->get()
        ]);
    }


}

<!DOCTYPE html>
<html>
<head>
  <title></title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body>
  <table>
    <thead>
      <tr>
        <th align="center">S.NO</th>
        <th align="center">Order Id</th>
        <th align="center">Date</th>
        <th align="center">Ordered Time</th>
        <th align="center">Cust Name</th>
        <th align="center">Cust Mobile</th>
        <th align="center">Shop Name</th>
        <th align="center">Grand Total</th>
        <th align="center">Status</th>
        <th align="center">Time</th>
        <th align="center">Payment Status</th>
        <th align="center">Payment Type</th>
        <th align="center">Order Type</th>
      </tr>
    </thead>
    <tbody>
      {{$i=0}}
      @if(count($resultData)>0)
      @foreach($resultData as $key=>$val)
      <tr>
        <th align="center">{{++$i}}</th>
        <td align="center">{{ $val->id }}</td>
        <td align="center">{{ $val->date }}</td>
        <td align="center">{{date('g:i a',$val->time)}}</td>
        <td align="center">{{ \AbserveHelpers::getuname($val->cust_id) }}</td>
        @if(\Auth::user()->group_id!='3') 
        <td align="center">{{ $val->mobile_num }}</td>
        @endif
        <td align="center">{{ \AbserveHelpers::restsurent_name($val->res_id) }}</td>
        @if(\Auth::user()->group_id=='1')
        <td align="center" >{{\AbserveHelpers::CurrencyValueBackend($val->grand_total)}}</td>
        @else
        <td align="center" >{{\AbserveHelpers::CurrencyValueBackend($val->grand_total)}}</td>
        @endif
        <td align="center" ><span class="label status  {{  \AbserveHelpers::getStatusLabel($val->status) }}">{{ \AbserveHelpers::getStatusTiming($val->status) }}</span>
        </td>
        <td align="center" >{{\AbserveHelpers::getOrderStatusTime($val->id,$val->status)}}</td>
        <td align="center">{!! ($val->delivery =='paid' ? '<span class="label label-success">Paid</span>' : '<span class="label label-danger">Unpaid</span>')  !!}</td>
        <td align="center" >{{ $val->delivery_type }}</td> 
        @if(PICKDEL_OPTION == 'enable')
        <td align="center" >{{ strtoupper($val->delivery_preference) }}</td>
        @endif
        <td align="center" >{{ strtoupper($val->order_type) }}</td>
      </tr> 
      @endforeach
      @endif
    </tbody>
  </table>
</body>
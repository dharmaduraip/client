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
        <th align="center">Order ID</th>
        <th align="center">Date</th>
        <th align="center">Shop</th>
        <th align="center">Order Value Of Vendor</th>
        <th align="center">Commission Percentage</th>
        <th align="center">Admin Commission</th>
        <th align="center">Net Payable</th>
      </tr>
    </thead>
    <tbody>
      {{$i=0}}
      @if(count($resultData)>0)
      @foreach($resultData as $key=>$val)
      <?php
      $order_items = \DB::table('abserve_order_items')->select(\DB::Raw('sum(selling_price * quantity) as sellingPrice'))->where('orderid',$row->id)->where('check_status','yes')->first();
      ?>
      <tr>
       <th align="center">{{++$i}}</th>
       <td align="center">{{ $val->id }}</td>
       <td align="center">{{ $val->date }}</td>
       <td> {{ AbserveHelpers::restsurent_name($val->res_id) }}</td>
       <td> @if($order_items->sellingPrice > 0) {!! number_format(abs($order_items->sellingPrice),2) !!} @else {!! number_format(abs($row->total_price),2) !!} @endif </td>
       <td align="center">{{ $val->comsn_percentage }}</td>
       <td> @if($row->accept_host_amount > 0) {!! number_format(abs($order_items->sellingPrice - $row->accept_host_amount),2) !!} @else {!! number_format(abs($row->total_price - $row->host_amount),2) !!} @endif </td>
       <td> @if($row->accept_host_amount > 0){{ number_format($row->accept_host_amount,2) }} @else {!! number_format($row->host_amount,2) !!} @endif </td>
     </tr> 
     @endforeach
     @endif
   </tbody>
 </table>
</body>
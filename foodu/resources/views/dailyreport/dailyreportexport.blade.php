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
        <th align="center">Customer</th>
        <th align="center">Shop</th>
        <th align="center">Grand Total</th>
        <th align="center">Vendor Price</th>
        <th align="center">Fixed Commission</th>
        <th align="center">Hiking Price</th>
        <th align="center">Delivery Charge</th>
        <th align="center">Convinience Fee</th>
        <th align="center">Vendor Share</th>
        <th align="center">Total Profit</th>
        <th align="center">Mode Of Payment</th>
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
        <td align="center">{{ AbserveHelpers::getuname($val->cust_id) }}</td>
        <td align="center">{{ AbserveHelpers::restsurent_name($val->res_id) }}</td>
        <td align="center">{{ $val->grand_total }}</td>
        <td align="center">{{ $val->host_amount }}</td>
        <td align="center">{{ $val->comsn_percentage }}</td>
        <td align="center">{{ $val->hiking }}</td>
        <td align="center">{{ $val->del_charge }}</td>
        <td align="center">{{ 0 }}</td>
        <td align="center">{{ $val->host_amount }}</td>
        <td align="center">{{ $val->admin_camount }}</td>
        <td align="center">{{ $val->delivery_type }}</td>

      </tr> 
      @endforeach
      @endif
    </tbody>
  </table>
</body>
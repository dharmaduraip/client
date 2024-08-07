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
        <th align="center">Delivery Boy</th>
        <th align="center">Order ID</th>
        <th align="center">Date</th>
        <th align="center">Shop</th>
        <th align="center">Order Value</th>
        <th align="center">Pickup Distance</th>
        <th align="center">Delivery Distance</th>
        {{-- <th align="center">Total Distance & Charge</th>
        <th align="center">Payment Type</th>
        <th align="center">Total Delivery Charge</th> --}}
      </tr>
    </thead>
    <tbody>
     <?php  $i=0; ?>
      @if(count($resultData)>0)
      @foreach($resultData as $key=>$val)

      <tr>
        <td align="center">{{++$i}}</td>
        <td align="center">{{ \AbserveHelpers::getboyname($val->id) }}</td>
        <td align="center">{{ $val->id }}</td>
        <td align="center">{{ $val->date }}</td>
        <td align="center">{{ $val->res_id }}</td>
        <td align="center">{{ $val->del_charge }}</td>
        <td align="center">{{ $val->date }}</td>
        <td align="center">{{ $val->date }}</td>
        {{-- <td align="center">{{ $val->date }}</td>
        <td align="center">{{ $val->delivery_type }}</td>
        <td align="center">{{ $val->date }}</td> --}}
      </tr> 
      @endforeach
      @endif
    </tbody>
  </table>
</body>
</html>
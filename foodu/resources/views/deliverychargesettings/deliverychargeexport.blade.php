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
        <th align="center">Charge Type</th>
        <th align="center">Charge Value</th>
        <th align="center">Order Value</th>
        <th align="center">Distance</th>
        <th align="center">Tax</th>
        <th align="center">Status</th>


      </tr>
    </thead>
    <tbody>
      {{$i=0}}
      @if(count($resultData)>0)
      @foreach($resultData as $key=>$val)

      <tr>
        <th align="center">{{++$i}}</th>
        <td align="center">{{ $val->charge_type }}</td>
        <td align="center">{{ $val->charge_value }}</td>
        <td align="center">{{ $val->order_value_min }}-{{$val->order_value_max}}</td>
        <td align="center">{{ $val->distance_min }}-{{$val->distance_max}}</td>
        <td align="center">{{ $val->tax }}</td>
        <td align="center">{{ $val->status }}</td>
      </tr> 
      @endforeach
      @endif
    </tbody>
  </table>
</body>
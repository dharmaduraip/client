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
        <th align="center">Id</th>
        <th align="center">Username</th>
        <th align="center">Email</th>
        <th align="center">Shop(s)</th>
        <th align="center">Payable Amount</th>
        <th align="center">Status</th>


      </tr>
    </thead>
    <tbody>
      {{$i=0}}
      @if(count($resultData)>0)
      @foreach($resultData as $key=>$val)

      <tr>
        <th align="center">{{++$i}}</th>
        <td align="center">{{ $val->id }}</td>
        <td align="center">{{ $val->username }}</td>
        <td align="center">{{ $val->email }}</td>
        <td align="center">{{ $val->id }}</td>
        <td align="center">{{ $val->id }}</td>
        <td align="center">{{ $val->id }}</td>


    </tr> 
      @endforeach
      @endif
    </tbody>
  </table>
</body>
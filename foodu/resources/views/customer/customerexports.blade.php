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
        <th>S.NO</th>
        <th>Customer Id</th>
        <th>User Name</th>
        <th>Phone Number</th>  
        <th>Active</th>
        <th>Address</th>
        <th>Date</th>
      </tr>
    </thead>
    <tbody>
      {{$i=0}}
      @if(count($resultData)>0)
      @foreach($resultData as $key=>$val)

      <tr>
        <th>{{++$i}}</th>
        <td >{{ $val->id }}</td>
        <td>{{ $val->username }}</td>
        <td>{{ $val->phone_number }}</td>
         <td>@if($val->active == 1)
              Active
              @elseif($val->active == 0)
              InActive
              @else
              Block
              @endif</td>
        <td>{{ $val->address }}</td>
        <td>{{ $val->created_at }}</td>
      </tr> 
      @endforeach
      @endif
    </tbody>
  </table>
</body>
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
        <th>S.No</th>
        <th>Username</th>
        <th>Email</th>
        <th>Phone Number</th>
        <th>Address</th>
        <th>Active</th>
        <th>Status</th>
    </tr>
    </thead>
    <tbody>
  @if(count($resultData)>0)
  @php $i=1;@endphp
        @foreach($resultData as $key=>$val)
        <tr>
         <td>{{ $i++ }}</td>
          <td >{{ $val->username }}</td>
          <td >{{ $val->email }}</td>
          <td>{{ $val->phone_number }}</td>
          <td>{{ $val->address }}</td>
          <td>
            @if($val->active == 1)
            Active
            @elseif($val->active == 0)
            InActive
            @else
            Block
            @endif
        </td>
        <td>
            @if($val->online_sts=='0') Offline @else Online @endif
       </td>
        </tr>
    @endforeach
    @endif
    </tbody>
   </table>
 </body>
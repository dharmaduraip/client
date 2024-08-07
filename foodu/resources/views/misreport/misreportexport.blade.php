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
        <th align="center">Order Date</th>
        <th align="center">Order Id</th>
        <th align="center">Customer ID</th>
        <th align="center">Customer Name</th>
        <th align="center">Customer Mobile</th>
        <th align="center">Customer Mail</th>
        <th align="center">Delivery Address</th>
        <th align="center">Store ID</th>
        <th align="center">Store Name</th>
        <th align="center">Store Address</th>
        <th align="center">Store Price</th>
        <th align="center">Total Base Price</th>
        <th align="center">Gst Amount(of the item)</th>
        <th align="center">Total Amount Hiked</th>
        <th align="center">GST on Hiked Amount</th>
        <th align="center">Final Product Price</th>
        <th align="center">Delivery Fees</th>
        <th align="center">Delivery Tax</th>
        <th align="center">Conv. Fee</th>
        <th align="center">Conv. Tax</th>
        <th align="center">Total Cost</th>
        <th align="center">Promo Code Discount</th>
        <th align="center">Promo Amount</th>
        <th align="center">Order Value</th>
        <th align="center">Commission Percentage</th>
        <th align="center">Commission Value</th>
        <th align="center">Net Payable to Shop</th>
        <th align="center">Total Earning</th>
        <th align="center">Payment Mode</th>
        <th align="center">Delivery Boy Name</th>
        <th align="center">Pickup Travel in KM</th>
        <th align="center">Delivery Travel In KM</th>
        <th align="center">Total Travel</th>
        <th align="center">Rate Per KM</th>
        <th align="center">TA Earned</th>
        <th align="center">Order Placed time</th>
        <th align="center">Accepted Time</th>
        <th align="center">Dispatched time</th>
        <th align="center">Completed time</th>
      </tr>

    </thead>
    <tbody>
      {{$i=0}}
      @if(count($resultData)>0)
      @foreach($resultData as $key=>$val)

      <tr>
        <th align="center">{{++$i}}</th>
        <td align="center">{{ $val->date }}</td>
        <td align="center">{{ $val->id }}</td>
        <td align="center">{{ $val->cust_id }}</td>
        <td align="center">{{ $val->cust_id }}</td>
        <td align="center">{{ $val->mobile_num }}</td>
        <td align="center">{{ $val->date }}</td>
        <td align="center">{{ $val->address }}</td>
        <td align="center">{{ $val->res_id }}</td>
        <td align="center">{{ $val->res_id }}</td>
        <td align="center">{{ $val->date }}</td> store address
        <td align="center">{{ $val->accept_host_amount }}</td>
        <td align="center">{{ $val->id }}</td>total base price
        <td align="center">{{ $val->gst }}</td>
        <td align="center">{{ $val->id }}</td>Total Amount Hiked
        <td align="center">{{ $val->id }}</td>GST on Hiked Amount
        <td align="center">{{ $val->id }}</td>Final Product Price
        <td align="center">{{ $val->id }}</td>Delivery Fees
        <td align="center">{{ $val->id }}</td>Delivery Tax
        <td align="center">{{ $val->id }}</td>Conv. Fee
        <td align="center">{{ $val->id }}</td>Conv. Tax
        <td align="center">{{ $val->id }}</td>Promo Code Discount
        <td align="center">{{ $val->id }}</td>Promo Amount
        <td align="center">{{ $val->id }}</td>Order Value
        <td align="center">{{ $val->id }}</td>Commission Percentage
        <td align="center">{{ $val->id }}</td>Commission Value
        <td align="center">{{ $val->id }}</td>Net Payable to Shop
        <td align="center">{{ $val->id }}</td>Total Earning
        <td align="center">{{ $val->id }}</td>Payment Mode
        <td align="center">{{ $val->boy_id }}</td>
        <td align="center">{{ $val->id }}</td>Pickup Travel in KM
        <td align="center">{{ $val->id }}</td>Delivery Travel In KM
        <td align="center">{{ $val->id }}</td>Total Travel
        <td align="center">{{ $val->id }}</td>Rate Per KM
        <td align="center">{{ $val->id }}</td>TA Earned
        <td align="center">{{ $val->id }}</td>Order Placed time
        <td align="center">{{ $val->accepted_time }}</td>
        <td align="center">{{ $val->dispatched_time }}</td>
        <td align="center">{{ $val->completed_time }}</td>



      </tr> 
      @endforeach
      @endif
    </tbody>
  </table>
</body>
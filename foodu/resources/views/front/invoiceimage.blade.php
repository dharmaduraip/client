<!DOCTYPE html>
<html style="width: 400px; background: white;">
<head>
	<title>Tastyeats</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<style type="text/css">
		table{
			width: 100%;overflow: hidden;
		}
		th{
			font-size: 22px;
		}
		td{
			font-size: 14px;
		}
	</style>
</head>

<body style="margin: auto;">
	<table>
		<tr>
			<th  colspan="3">Tastyeats.COM</th>
		</tr>
		<tr>
			<td colspan="2" style="border-top: 1px dashed black;">ORDER ID :</td>
			<td  style="border-top: 1px dashed black;">{{$orderDetail->id}}</td>
		</tr>
		<tr>
			<td colspan="2">ORDER DATE :</td>
			<td>{{$orderDetail->date}}</td>
		</tr>
		<tr>
			<td colspan="2">ORDER TIME :</td>
			<td>{{$orderDetail->time}}</td>
		</tr>
		<tr>
			<td colspan="3" style="border-top: 1px dashed black;">CUSTOMER DETAILS </td>
		</tr>
		<tr>
			<td colspan="2">NAME:</td>
			<td>{{$orderDetail->user_info->username}}</td>
		</tr>
		<tr>
			<td colspan="2">NUMBER: </td>
			<td>{{$orderDetail->user_info->phone_number}}</td>
		</tr>
		<tr>
			<td colspan="2">ADDRESS:</td>
			<td style="
			width: 50%;
			">{{$orderDetail->address}} </td>
		</tr>
	</table>
	<table>
		<tr>
			<td style="border-top: 1px dashed black;" style="border-top: 1px dashed black;" style="border-top: 1px dashed black;" style="border-top: 1px dashed black;">SR.</td>
			<td colspan="4" style="border-top: 1px dashed black;" style="border-top: 1px dashed black;" style="border-top: 1px dashed black;">Item Name</td>
			<td style="border-top: 1px dashed black;">Qnty</td>
		</tr>
		@foreach($orderDetail->accepted_order_items as $key => $item )
		<tr>
			<td>{!! $key+1 !!}.</td>
			<td colspan="4">{!! $item->food_item !!}</td>
			<td>{!! sprintf('%02d',$item->quantity) !!}</td>
		</tr>
		@endforeach
	</table>
	<table>
		<tr>
			<td style="border-top: 1px dashed black;border-bottom: 1px dashed black;" colspan="4">NO OF ITEMS</td>
			<td style="border-top: 1px dashed black;border-bottom: 1px dashed black;">{!! sprintf('%02d',count($orderDetail->accepted_order_items)) !!}</td>
		</tr>
	</table>
	<table>
		<tr>
			<td colspan="4" style="border-bottom: 1px dashed black;">PAYMENT MODE</td>
			<td style="border-bottom: 1px dashed black;">@if($orderDetail->delivery_type == 'cashondelivery'){!! 'COD' !!}@else {!! 'ONLINE' !!}@endif</td>
		</tr>
		<tr>
			<td colspan="5" align="center">THANK YOU FOR SHOPPING WITH MYGROZO</td>
		</tr>
	</table>
</body>
</html>
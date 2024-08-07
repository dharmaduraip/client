@extends('layouts.app')

@section('content')
<div class="page-header"><h2> {{ $pageTitle }} <small> {{ $pageNote }} </small> </h2></div>
<div class="toolbar-nav" >   
	<div class="sbox-title"> 
		<h5> <i class="fa fa-table"></i> </h5>
		{{--<div class="sbox-tools">
			<a href="{{ URL::to('weeklypaymentfordeliveryboy') }}" style="display: block ! important;" class="btn btn-xs btn-white tips" title="Clear Search" >
				 {!! " Back " !!} 
			</a>
		</div>--}}
	</div>
	<div class="row d-none">
		{{--<div class="col-md-8"> 	
			 <div class="btn-group ">
		        <ul class="dropdown-menu ">
					<div class="dropdown-divider"></div>
			        @if($access['is_excel'] ==1)
						<li class="nav-item"><a href="{{ url( $pageModule .'/export?do=excel&return='.$return) }}" class="nav-link "> Export Excel </a></li>	
					@endif
					@if($access['is_csv'] ==1)
						<li class="nav-item"><a href="{{ url( $pageModule .'/export?do=csv&return='.$return) }}" class="nav-link "> Export CSV </a></li>	
					@endif
					@if($access['is_pdf'] ==1)
						<li class="nav-item"><a href="{{ url( $pageModule .'/export?do=pdf&return='.$return) }}" class="nav-link "> Export PDF </a></li>	
					@endif
					@if($access['is_print'] ==1)
						<li class="nav-item"><a href="{{ url( $pageModule .'/export?do=print&return='.$return) }}" class="nav-link "> Print Document </a></li>	
					@endif
					<div class="dropdown-divider"></div>
						<li class="nav-item"><a href="{{ url($pageModule) }}"  class="nav-link "> Clear Search </a></li>
		        </ul>
		    </div>     
		</div>--}}
		<div class="col-md-4 text-right">
			<div class="input-group ">
			      <div class="input-group-prepend">
			        <button type="button" class="btn btn-default btn-sm " 
			        onclick="SximoModal('{{ url($pageModule."/search") }}','Advance Search'); " ><i class="fa fa-filter"></i> Filter </button>
			      </div><!-- /btn-group -->
			      <input type="text" class="form-control form-control-sm onsearch" data-target="{{ url($pageModule) }}" aria-label="..." placeholder=" Type And Hit Enter ">
			    </div>
		</div>    
	</div>	
</div>	
<div class="p-3">  
    <div class="col-md-6">
        <label>Admin Commission Amount : {!!$admincommission!!}</label><br>
        <label>Delivery Charge Amount  : {!!$delivery_charge!!}</label><br>
        <label>Total AminCommission Amount  : {!!$total_amount!!}</label>
    </div>
    <div class="table-container for-icon m-0">
        <!-- Table Grid -->
        <table class="table table-hover" id="{{ $pageModule }}Table">
            <thead>
                <tr>
                    <th style="width: 3% !important;" class="number"> No </th>
                    <th>Order Id</th>
                    <th>Date</th>
                    <th>Product TotalPrice</th>
                    <th>Admin Commission</th>
                    <th>Host Amount</th>
                    <th>Accepted Host Amount</th>
                    <th>Delivery Charge</th>
                    <th>GST & Service</th>
                    <th>Grand Total</th>
                    <th>Accepted Grand Total</th>
                    <th>Payment Type</th>
                    <th>Shop Name</th>
                    <th>Customer Name</th>
                    <th>Partner Name</th>
                    <th>DeliveryBoy Name</th>
                    <th>DeliveryBoy CashIn Hand</th>
                </tr>
            </thead>
            <tbody>
                <?php $i = 0; ?>
                @foreach ($pagination as $row)
                    <tr>
                        <td class="thead"> {{ ++$i }} </td>
                        <td> {{ '# '}}{{ $row->id }} </td>
                        <td> {{ $row->date }} </td>
                        <td> {{ $row->total_price }} </td>
                        <td> {{ $row->fixedCommission }} </td>
                        <td> {{ $row->host_amount }} </td>
                        <td> {{ $row->accept_host_amount }} </td>
                        <td> {{ $row->del_charge }}</td>
                        <td> {{ $row->gst }} </td>
                        <td> {{ $row->grand_total }} </td>
                        <td> {{ $row->accept_grand_total }} </td>
                        <td> {{ $row->delivery_type }} </td>
                        <td> {{ $row->restaurant->name }} </td>
                        <td> {{ $row->user_info->username }} </td>
                        <td> {{ $row->partner_info->username }} </td>
                        <td> {{ $row->boy_info->username }} </td>
                        <td> {{ $row->boy_info->boy_cashIn_hand }} </td>
                    </tr>
                @endforeach    
            </tbody>
        </table>
    </div>
</div>
@include('footer')
@stop

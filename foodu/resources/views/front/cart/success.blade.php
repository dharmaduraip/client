@extends('layouts.default.index')

@section('content')
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/jquery-1.12.4.js"></script>
<script src="//code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/5.4.0/bootbox.min.js" integrity="sha512-8vfyGnaOX2EeMypNMptU+MwwK206Jk1I/tMQV4NkhOz+W8glENoMhGyU6n/6VgQUhQcJH8NqQgHhMtZjJJBv3A==" crossorigin="anonymous"></script>

<script src="{{ asset('sximo5/js/front/checkout.js')}}"></script>
<script src="{{ asset('sximo5/js/front/jquery.countdown360.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.3.0/socket.io.js"></script>
<script type="text/javascript">
    var base_url = '{!! URL::to('')."/" !!}';
    var access_token = '{{$access_token}}';
</script>
<body class="abserve FoodStar">
	<section class="redirect_timer">
		<div class="container">
<!--             <div class="">
                <img src="{!! url('public/main/images/backend-logo.png') !!}" style="width:80px;">
            </div> -->

            <div class="mt-30">
            	<a class="btn btn-danger" href="{!! url('orders') !!}">Back to orders</a>
            </div>  
            <div class="row my-2">              
                <div class="col-md-4 mt-30">
                	<div class="right-sec">
                		<div class="restaurent-det box">
                			<p class="text-muted">Order ID:{!! $id !!} <span class="pull-right">Help</span></p>
                			<p class="font-weight-bold"><b>{!! $restaurant_detail['name'] !!}</b></p>
                			<p class="text-muted"><span>{!! $order_time !!}</span>| <span>{!! count($order_items) !!} items</span>| <span>₹ {!! $grand_total !!}</span> </p>
                			@if($delivery_preference == 'later')
                			<div class="datetime"><span class="side-title">Delivery Date :</span> &nbsp;{!! $later_deliver_date !!}&nbsp;{!! $later_deliver_time !!} </div>
                			@endif
                		</div>
                        <input type="hidden" name="partner_id" id="partner_id" value="{!! $partner_id !!}">
                        <!-- <div class="box">
                            <div class="order-status">
                                <div class="text-muted"> <a href="#" class="btn btn-sm btn-outline-info">Done</a> <span class="">Order Received</span> </div>
                            </div>
                        </div> -->
                        <div class="box">
                        	<div class="food-status">
                        		<div class="" style="display: inline;"> 
                        			<div class="right-food-status">
                        				<i class="fa fa-check" style="background-color: green;color: white;padding: 9px;border-radius: 30px;display: inline;"></i><h6 class="font-weight-bold" style="display: inline;margin-left: 13px;font-size: 15px;">Order is placed</h6>
                        			</div> 
                        		</div>
                        	</div>
                        </div>
                        <div class="box">
                        	<div class="food-status">
                        		<div class="" style="display: inline;"> 
                        			<div class="right-food-status">
                        				<i class="fa fa-check" id="partnerAccept" style="background-color: red;color: white;padding: 9px;border-radius: 30px;display: inline;"></i><h6 class="font-weight-bold" style="display: inline;margin-left: 13px;font-size: 15px;">Partner accepted</h6>
                        			</div> 
                        		</div>
                        	</div>
                        </div>
                        <div class="box">
                        	<div class="food-status">
                        		<div class="" style="display: inline;"> 
                        			<div class="right-food-status">
                        				<i class="fa fa-check" id="boyAccept" style="background-color: red;color: white;padding: 9px;border-radius: 30px;display: inline;"></i><h6 class="font-weight-bold" style="display: inline;margin-left: 13px;font-size: 15px;">Boy Accepted Your Order</h6>
                        			</div> 
                        		</div>
                        	</div>
                        </div>
                        <div class="box">
                        	<div class="food-status">
                        		<div class="" style="display: inline;"> 
                        			<div class="right-food-status">
                        				<i class="fa fa-check" id="order_packing" style="background-color: red;color: white;padding: 9px;border-radius: 30px;display: inline;"></i><h6 class="font-weight-bold" style="display: inline;margin-left: 13px;font-size: 15px;">Order Packed</h6>
                        			</div> 
                        		</div>
                        	</div>
                        </div>
                        <div class="box">
                        	<div class="food-status">
                        		<div class="" style="display: inline;"> 
                        			<div class="right-food-status">
                        				<i class="fa fa-check" id="rider_picked" style="background-color: red;color: white;padding: 9px;border-radius: 30px;display: inline;"></i><h6 class="font-weight-bold" style="display: inline;margin-left: 13px;font-size: 15px;">Rider Picked Your Order</h6>
                        			</div> 
                        		</div>
                        	</div>
                        </div>
                        <div class="box">
                        	<div class="food-status">
                        		<div class="" style="display: inline;"> 
                        			<div class="right-food-status">
                        				<i class="fa fa-check" id="on_the_way" style="background-color: red;color: white;padding: 9px;border-radius: 30px;display: inline;"></i><h6 class="font-weight-bold" style="display: inline;margin-left: 13px;font-size: 15px;">Rider On the way to Your Location</h6>
                        			</div> 
                        		</div>
                        	</div>
                        </div>
                        <div class="box">
                        	<div class="food-status">
                        		<div class="" style="display: inline;"> 
                        			<div class="right-food-status">
                        				<i class="fa fa-check" id="rider_arrived" style="background-color: red;color: white;padding: 9px;border-radius: 30px;display: inline;"></i><h6 class="font-weight-bold" style="display: inline;margin-left: 13px;font-size: 15px;">Rider Arrived Your Location</h6>
                        			</div> 
                        		</div>
                        	</div>
                        </div>
                        <div class="box">
                        	<div class="food-status">
                        		<div class="" style="display: inline;"> 
                        			<div class="right-food-status">
                        				<i class="fa fa-check" id="order_delivered" style="background-color: red;color: white;padding: 9px;border-radius: 30px;display: inline;"></i><h6 class="font-weight-bold" style="display: inline;margin-left: 13px;font-size: 15px;">Order Delivered</h6>
                        			</div> 
                        		</div>
                        	</div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="timer">
                            <div id="countdown"></div>
                            <div class="">
                                <input type="hidden" name="orderid_key" id="orderid_key" value="{!! $id !!}">
                                 <input type="hidden" name="access_token" id="access_token" value="{!! $access_token !!}">
                                <?php  $id = base64_decode($orderidenc);
                                    $check = \App\Models\Front\OrderDetails::find($id);
                                 ?>
                                 @if($check->status == 'pending')
                                <p>Order can be cancelled in the next 10 seconds.</p>
                                <button class="cancel" id="timer-cancellation-btn">Cancel Order</button>
                                <input type="hidden"  class="tracking" id="tracking" value="{{ $orderidenc}}">
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-8 mt-30">
                	@if(!empty($restaurant_detail['advertise_ext_url'][0]))
                	<a target="_BLANK" href="<?php echo $restaurant_detail['advertise_ext_url'][0]; ?>"></a>
                	@else
                	<a href="javascript:void(0);">
                		@endif
                		@if($restaurant_detail['advertise_type'] == 'video')
                		<div class="backk" style="background-image: unset; height: 100%;"> <video src="{!! $restaurant_detail['advertise'] !!}" autoplay="" muted="" loop="" style="width: 100%;"></video> </div>
                		@else
                		<div class="backk" style="background-image: url( {!! $restaurant_detail['advertise'] !!} );"></div>
                		@endif
                	</a>
                	<div class="col-md-12 order-det py-2">
                		<h3 style="padding-left: 15px;">Order Details</h3>
                		<div class="row m-0">
                            <div class="col-md-6">
                                <p class="text-muted">From</p>
                                <p class="font-weight-bold"><b>{!! $restaurant_detail['name'] !!}</b></p>
                                @if(isset($restaurant_detail['city']))
                                <p class="text-muted">{!! $restaurant_detail['city'] !!}</p>
                                @endif
                                <p class="font-weight-bold">Address Delivered</p>
                                <p class="text-muted">{!! $customer_detail->address !!}</p>
                            </div>
                            <div class="col-md-6">
                                <p class="text-muted">{!! count($order_items) !!} items</p>
                                <ul class="food-list">
                                    @foreach($order_items as $item)
                                    <li>
                                        <div class="square"></div>
                                        <span>{!! $item['food_item'] !!}</span>

                                        <span class="pull-right"> x {{$item['quantity']}} ₹ {!! number_format(($item['selling_price']* $item['quantity']),2,'.','') !!}</span>
                                    </li>
                                    @endforeach
                                    @if(!empty($inaugural_offer) && $inaugural_offer['isfirst'])
                                    <li style="background: #defffd;padding: 8px;font-weight: 600;">
                                        <span>{!! $inaugural_offer->offer_name !!}</span>
                                        <span style="color: green;" class="pull-right">FREE</span>
                                    </li>
                                    @endif
                                </ul>
                                <hr class="dashed-border">
                                @if($total_price > 0 || $accept_total_price > 0)
                                <div class="mb-1"><span><b>Items total</b></span><span class="pull-right">₹ {!! ($accept_total_price > 0) ? number_format($accept_total_price,2,'.','') : number_format($total_price,2,'.','') !!}</span></div>
                                @endif
                                @if($gst > 0)
                                <div class="mb-1"><span><b>GST</b></span><span class="pull-right">₹ {!! number_format($gst,2,'.','') !!}</span></div>
                                @endif
                                @if($discount_price > 0)
                                <div class="mb-1" style="color:#60b246;"><span><b>Coupon Discount</b></span><span class="pull-right">- ₹ {!! number_format($discount_price,2,'.','') !!}</span></div>
                                @endif
                                @if($del_charge > 0)
                                <div class="mb-1"><span><b>Delivery Charge</b></span><span class="pull-right">₹ {!! number_format($del_charge,2,'.','') !!}</span></div>
                                @endif
                                @if($check->s_tax1 > 0)
                                <div class="mb-1"><span><b>Service Tax</b></span><span class="pull-right">₹ {!! number_format($check->s_tax1,2,'.','') !!}</span></div>
                                @endif
                                @if($del_charge_tax_price > 0)
                                <div class="mb-1"><span><b>Delivery Charge Tax</b></span><span class="pull-right">₹ {!! number_format($del_charge_tax_price,2,'.','') !!}</span></div>
                                @endif
                                @if(isset($package_charge))
                                <div class="mb-1"><span><b>Packaging Charge (Incl. GST)</b></span><span class="pull-right">₹ {!! number_format($package_charge,2,'.','') !!}</span></div>
                                @endif
                                @if($bad_weather_charge > 0)
                                <div class="mb-1"><span><b> Bad Weather Charge (Incl. GST)</b></span><span class="pull-right">₹ {!! number_format(($bad_weather_charge),2,'.','') !!}</span></div>
                                @endif
                                @if($festival_mode_charge > 0)
                                <div class="mb-1"><span><b> Bad Weather Charge (Incl. GST)</b></span><span class="pull-right">₹ {!! number_format(($festival_mode_charge),2,'.','') !!}</span></div>
                                @endif
                                @if($add_del_charge > 0)
                                <div class="mb-1"><span><b>Packaging Charge (Incl. GST)</b></span><span class="pull-right">₹ {!! number_format($add_del_charge,2,'.','') !!}</span></div>
                                @endif
                                @if(isset($festival))
                                <div class="mb-1"><span><b>Delivery Charge Tax</b></span><span class="pull-right">₹ {!! number_format(($festival + $festivalTax),2,'.','') !!}</span></div>
                                @endif
                                @if($cash_offer > 0)
                                <div class="mb-1" style="color:#60b246;"><span><b>Cash back offer amount :</b></span><span class="pull-right">- ₹ {!! number_format($cash_offer,2,'.','') !!}</span></div>
                                @endif
                                @if($wallet_amount > 0)
                                <div class="mb-1" style="color:#60b246;"><span><b>Used Wallet</b></span><span class="pull-right">- ₹ {!! number_format($wallet_amount,2,'.','') !!}</span></div>
                                @endif
                                <div class="mb-1"><span><b>Bill Total</b></span><span class="pull-right">₹ {!! ($accept_grand_total > 0) ? number_format($accept_grand_total,2,'.','') : number_format($grand_total,2,'.','') !!}</span></div>
                            </div>      
                        </div>
                	</div>
                </div>
            </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="myModal" role="dialog">
    	<div class="modal-dialog">
    		<div class="modal-body accept_item">
    		</div>
    	</div>
    </div>

    {{-- <script type="text/javascript">
    	$('#myModal').modal('show');
    </script> --}}

    <script>

    	<?php if(\Request::segment(4) == '') { ?>
    			//var base_url = '{!! URL::to('')."/" !!}';
    			//var url = base_url+'trackorder/'+$("#tracking").val();
    			//window.history.pushState("", "", url);
                var current_time = new Date();
                var time = new Date('{{$aOrder->created_at}}');
                time.setSeconds(time.getSeconds() + 20);
                var seconds = (time.getTime() - current_time.getTime()) / 1000;
                var seconds = Math.abs(parseInt(seconds));
                if(current_time < time){
    			start_timer();
            }            
        <?php } ?>
    </script>
          <script type="text/javascript">
             var status = '<?php echo $aOrder->status; ?>';
             var customer_status = '<?php echo $aOrder->customer_status; ?>';
             if(status != '5' ){
                 if(status == '6' || status >='1' && status <='4' || customer_status == 'Cooking'){
                     $('#partnerAccept').css('background-color','green');
                 } 
                 if(status >= '2' && status <= '4'){
                     $('#boyAccept').css('background-color','green');
                 }
                 if( status >= '2'  && status <= '4' && customer_status == 'Packing' || status >='3' && status <='4' ){
                     $('#order_packed').css('background-color','green');
                 }
                 if(status >= '3' && status <='4' || customer_status == 'boyPicked' || customer_status =='boyArrived' || status == '4' ){
                     $('#rider_picked').css('background-color','green');
                     setTimeout(function(){$('#on_the_way').css('background-color','green');},3000);
                 }
                 if(status >= '3' && status <='4' || customer_status == 'boyArrived' || status == '4'){
                    $('#rider_arrived').css('background-color','green');
                }
                if(status == '4' || customer_status == 'Delivered' ){
                    $('#order_delivered').css('background-color','green');
                }
            }
</script>
    <script type="text/javascript">
            var socket;
            const user_id   = '{!! Auth::user()->id !!}';
            const order_id  = '{!! $id !!}';
            socket = io.connect('https://dev.abserve.tech:4007');
            socket.on('connect', () => {
                var userDetails         = 'cust_'+user_id;
                    // $('#socketDiv').html('Socket Id : '+socket.id);
                    socket.emit('create connection',userDetails,function(res){
                        console.log(userDetails);
                    });
                    socket.emit('testing from php client','testing',function(res){
                    });
                });
            socket.on('partner accepted',(data) => {
                console.log('partner accepted',data);
                if(data.customer_id == user_id || data.order_id == order_id){
                    $('#partnerAccept').css('background-color','green');
                    if(data.stockStatus == 'yes') {
                        $.ajax({
                            type : 'POST',
                            url : base_url+'acceptitem',
                            data : {id:order_id},
                            success:function(data){
                                $('.accept_item').html(data);
                                $('#myModal').modal('show');
                            }
                        });
                    }
                }
            });
            $('.modal-button').click(function(){
                var id=order_id;

                  $.ajax({
                        type : 'POST',
                        url : base_url+'acceptitem',
                        data : {id:order_id},
                    success:function(data){
                        $('.accept_item').html(data);
                        $('#myModal').modal('show');
                    }
                });
            });
            socket.on('boy accepted',(data) => {
                console.log('boy accepted',data);
                if(data.boy_id != '' || data.order_id == order_id){
                    $('#boyAccept').css('background-color','green');
                }
            });
            socket.on('order packing',(data) => {
                console.log('order packing',data);
                if(data.boy_id != '' || data.order_id == order_id){
                    $('#order_packing').css('background-color','green');
                }
            });
            socket.on('boy picked',(data) => {
                console.log('boy picked',data);
                if(data.boy_id != '' || data.order_id == order_id){
                    $('#rider_picked').css('background-color','green');
                    setTimeout(function(){$('#on_the_way').css('background-color','green');},3000);
                }
            });
            socket.on('boy arrived',(data) => {
                console.log('boy arrived',data);
                if(data.boy_id != '' || data.order_id == order_id){
                    $('#rider_arrived').css('background-color','green');
                }
            });
            socket.on('delivered to customer',(data) => {
                console.log('delivered to customer',data);
                if(data.customer_id == user_id || data.boy_id != '' || data.order_id == order_id){
                    $('#order_delivered').css('background-color','green');
                }
            });


        </script>
    </section>

    @endsection


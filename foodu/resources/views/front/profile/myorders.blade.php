<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css">
<style type="text/css">
    @media screen and (max-width: 900px) {
        .res_table td:nth-of-type(1):before { content: "{!! Lang::get('core.orderno') !!}"; }
        .res_table td:nth-of-type(2):before { content: "{!! Lang::get('core.datetime') !!}" ; }
        .res_table td:nth-of-type(3):before { content: "{!! Lang::get('core.items') !!} "; }
        .res_table td:nth-of-type(4):before { content: "{!! Lang::get('core.service_tax') !!}"; }
        .res_table td:nth-of-type(5):before { content: "{!! Lang::get('core.total') !!}" ; }
        .res_table td:nth-of-type(6):before { content: "{!! Lang::get('core.delivery_type') !!} "; }
        .res_table td:nth-of-type(7):before { content: "{!! Lang::get('core.payment') !!} "; }
        .res_table td:nth-of-type(8):before { content: "{!! Lang::get('core.status') !!}"; }
    }
   @media (min-width: 768px){.modal-sm-ex { width: 600px;}}
   .flx-pr{display: -webkit-box;display: -ms-flexbox; display: flex;} 
</style>
 
    @if(count($orders) != 0)
<div class="account_details col-xs-12 nopadding">
    <div class="mol_overlay" style="display: none;"><span class="theme_loader load_process_text">Processing...</span></div>
    <div class="smallHeading mainthemeGray">My Orders</div>
    <input type="hidden" name="token" value="{{ csrf_token() }}" id="csrf">
    <div class="table-responsive">

        <table class="display nowrap res_table" id="example2" cellspacing="0" width="100%">
            <thead> 
                <th>{!! Lang::get('core.orderno') !!}</th>
                <th>Name Of Shop</th>
                <th>Order Details</th>
                <!-- <th>{!! Lang::get('core.datetime') !!}</th> -->
                <!-- <th>{!! Lang::get('core.items') !!}</th> -->
                <?php $cursymbol = \AbserveHelpers::getCurrencySymbol(); ?>
                <!-- <th>{!! Lang::get('core.service_tax') !!} (in {!! $cursymbol !!} ) </th> -->
                <!-- <th>{!! Lang::get('core.total') !!} (in {!! $cursymbol !!} )</span> </th> -->
                <!-- <th>{!! Lang::get('core.delivery_type') !!}</th> -->
                <!-- <th>{!! Lang::get('core.payment') !!} </th> -->             
                <th>{!! Lang::get('core.status') !!}</th>
                <!-- <th>Order Cancellation</th> -->
                <!-- <th>Delivery Boy Details</th> -->
                <!-- <th>Order Details</th> -->
                <!-- <th>Action</th> -->
            </thead>
            <tbody>
                @foreach($orders as $order)
                <?php $old_rating = AbserveHelpers::getOrderRating($order->res_id); 
                 // $boy_id = $order->boy_id;
                 // print_r($boy_id);exit();
                 $oldcomment = \DB::table('abserve_rating')->where('orderid',$order->id)->first();
                 if(isset($order->boy_id)){

                    $boy = \DB::table('abserve_deliveryboys')->where('id',$order->boy_id)->first();
                    $oldratingboy = \DB::table('abserve_rating_boy')->where('orderid',$order->id)->where('boy_id',$order->boy_id)->first();
                }
                $boy_image = \URL::to('uploads/images/avatar_dummy.png');
                if(!empty($boy) && $boy->avatar != '' && file_exists(base_path('uploads/delivery_boy/'.$boy->avatar))){
                    $boy_image = \URL::to('uploads/delivery_boy/'.$boy->avatar);
                }
                // $selectpart = \DB::table('abserve_orders_partner')->where('orderid',$order->id)->first();
                $resname=\DB::table('abserve_restaurants')->select('id','name','logo')->where('id','=',$order->res_id)->first();
                $res_image = \URL::to('uploads/images/Default_food.jpg');
                if($resname->logo != '' && file_exists(base_path('uploads/restaurants/'.$resname->logo))){
                    $res_image = \URL::to('uploads/restaurants/'.$resname->logo);
                }
              ?>
                <tr>
                     <?php $ser_tax = \AbserveHelpers::CurrencyValue($order->s_tax);
                    $gtotal = ($order->accept_grand_total != 0) ? number_format($order->accept_grand_total,2) : number_format($order->grand_total,2) ; ?>
                    <td> {{ $order->id }} </td>
                    <td class="order_res_name"> {{$resname->name}}</td>
                     <input type="hidden" name="res_image" class="res_image" value="{!! $res_image !!}">
                     <input type="hidden" name="boy_image" class="boy_image" value="{!! $boy_image !!}">
                     <td>Date: {{ $order->date }}<br> Payment Method: {{ $order->delivery_type == 'cashondelivery' ? 'COD' : 'Online' }}<br>Order Total: {{ $gtotal }}<br> Order Details: <a href="javascript:void(0);" class="btn order-details" data-id="{!!$order->id!!}"><i class="fa fa-info-circle"></i></a></td>
                    <!-- <td> {{ $order->order_details }} </td> -->
                    <!-- <td> {{ $ser_tax }}</td> -->
                    <!-- <td> {{ $gtotal }}</td> -->
                    <!-- <td> {{ $order->delivery_type}}</td> -->
                   <!-- <td> {{ $order->delivery_type }}</td> -->
                    <td>    
                    <input type="hidden" id="oldratingboy_{{ $order->id }}" value="{{ isset($oldratingboy->rating) ? $oldratingboy->rating : ''}}">
                        <input type="hidden" value="{{$old_rating}}" id="old_rating_{{$order->id}}">
                        @if($order->status != '5' && $order->status != '4')
                        <?php $order_Id1=base64_encode($order->id);?>
                        <a href="{!! url('trackorder/'.$order_Id1) !!}">Track your order</a>
                        @endif
                        @if($order->status == '0' || $order->status == 'pending')
                        <label class="label {!! $order->status_label !!}">{!! Lang::get('core.pending') !!}</label>
                        <?php if(in_array($order->status, $allowed_status)){ ?>
                        {{--<button class="btn btn-danger timer-cancellation-dashboard btn-sm" data-id="{!!$order->id!!}"  partner-id ="{!!$order->partner_id !!}">Cancel</button>--}}
                         <?php } ?>
                        @elseif ($order->status == '1')<label class="label {!! $order->status_label !!}">                        {!! Lang::get('core.order_cust_sta_one') !!}</label>
                         <?php //if(in_array($order->status, $allowed_status)){ ?>
                        <!-- <button class="btn btn-danger timer-cancellation-dashboard btn-sm" data-id="{!!$order->id!!}">Cancel</button> -->
                         <?php //} ?>
                        @elseif($order->status == '2')<label class="label {!! $order->status_label !!}">                        {!! Lang::get('core.order_cust_sta_two') !!}</label>
                         <?php //if(in_array($order->status, $allowed_status)){ ?>
                        <!-- <button class="btn btn-danger timer-cancellation-dashboard btn-sm" data-id="{!!$order->id!!}">Cancel</button> -->
                         <?php //} ?>
                        @elseif($order->status == '3')
                    <label class="label {!! $order->status_label !!}">{!! Lang::get('core.dispatch') !!}</label>
                         <?php //if(in_array($order->status, $allowed_status)){ ?>
                        <!-- <button class="btn btn-danger timer-cancellation-dashboard btn-sm" data-id="{!!$order->id!!}">Cancel</button> -->
                         <?php //} ?>
                        @elseif($order->status == '4')
                        <label class="label {!! $order->status_label !!}">{!! Lang::get('core.delivered') !!}</label>
                        @if(isset($order->boy_id))
                        <a href="javascript:void(0);" data-orderid="{{$order->id}}" data-boyid="{{$order->boy_id}}" data-boycomment="{{ isset($oldratingboy->comments) ? $oldratingboy->comments : '' }}" data-comments="{{ isset($oldcomment->comments) ? $oldcomment->comments : ''}}" data-oldratingboy="{{isset($oldratingboy->rating) ? $oldratingboy->rating : ''}}" data-oldrating="{{isset($old_rating) ? $old_rating : ''}}" data-resid="{{$order->res_id}}" class="give_rating"><font @if(isset($oldratingboy->rating) && ($oldratingboy->rating>'0' || $oldratingboy->rating != '') && ($old_rating > '0' || $old_rating != '')) color="green" @else color="red" @endif > <button class="btn"> Rate Your order</button></font></a>

                         <a href="javascript:void(0);" data-orderid="{{$order->id}}" data-boyid="{{$order->boy_id}}" class="refund_request"> <button class="btn">Claim Order</button></font></a>
                        @endif

                        @elseif ($order->status == '5')
                    <label class="label {!! $order->status_label !!}">{!! Lang::get('core.cancelled') !!}</label>
                        @endif
                        @if($order->order_repay_info != false)
                        <button data-id="{!! $order->id !!}" id="rzp-button1">Pay Amount</button>
                        @endif

                        @if($order->status == '4' && $order->refund_order == 'Active' )
                          {{--<button class="btn btn-success cliamStatus  btn-sm" data-id="{!!$order->id!!}">Cancel Status</button>
                          <button class="btn btn-primary  cliamOrder btn-sm" data-id="{!!$order->id!!}">Cancel Order</button>--}}
                        @elseif($order->status == '4')
                        <!-- <button class="btn btn-primary  reOrder btn-sm" data-id="{!!$order->id!!}" data-check="confirmation" data-toggle="confirmation" data-btn-ok-label="Yes" data-btn-ok-icon="fa fa-remove" data-btn-ok-class="btn btn-sm btn-danger" data-btn-cancel-label="No" data-btn-cancel-icon="fa fa-chevron-circle-left" data-btn-cancel-class="btn btn-sm btn-default" data-title="Do you remove your cart res_name, food_item ?" data-placement="left" data-singleton="true">ReOrder</button> -->
                        @endif
                    </td>
                    <!-- <td><a href="javascript:void(0);" class="btn order-details" data-id="{!!$order->id!!}"><i class="fa fa-info-circle"></i></a></td> -->
                   <!-- <td>
                    <?php if(in_array($order->status, $allowed_status)){ ?>
                        <button class="btn btn-danger timer-cancellation-dashboard btn-sm" data-id="{!!$order->id!!}">Cancel</button>
                         <?php } ?>
                    </td> -->
                </tr>
                @endforeach

            </tbody> 
        </table>
    </div>
    <div class="pagination-bar col-md-12" id="pagination" style="text-align: center;"> </div>            
    <?php         
    if(count($_REQUEST) == 0){
      $_REQUEST['page'] = '1';
    }    
    echo $orders->appends(array_except(\Request::query(), 'page'))->render(); ?>        
  </div>
</div>
@else
<div class="noOrders">
    <h5 class="strong text-center"> {!! Lang::get('core.made_order') !!}</h5>
    <div class="text-center">
        <img src="{{ URL::to(CNF_THEME.'/themes/maintheme/images/cartempty.png')}}">
        <div class="explore">
            <a class="btn btnUpdate" href="{!! $explore_url !!}" target="_blank">{!! Lang::get('core.explore') !!}</a>
        </div>
    </div>
</div>
@endif
@include('front/modal')
 <script src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/5.4.0/bootbox.min.js" integrity="sha512-8vfyGnaOX2EeMypNMptU+MwwK206Jk1I/tMQV4NkhOz+W8glENoMhGyU6n/6VgQUhQcJH8NqQgHhMtZjJJBv3A==" crossorigin="anonymous"></script>
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script type="text/javascript">
    var base_url = '<?php echo URL::to(''); ?>';
    $(document).on("click",'#rzp-button1',function(){
        var order_id = $(this).attr('data-id');
        $('.loader_event').show();
        $.ajax({
          url : base_url+"payment/catpaywithrazor",
          type : 'post',
          data : { "repay" : order_id},
          dataType : 'json',
          success : function(res){ 
                $('.loader_event').hide();             
                var options = {
                  "key": res.key,
                  "amount": res.amount, 
                  "name": res.name,
                  "description": res.description,
                  "image": res.image,
                  "order_id":res.orderid,
                  "handler": function (response){                        
                    PlaceOrder(response.razorpay_payment_id,response.razorpay_order_id);
                  },
                  "prefill": {
                    "name": res.prefill_name,
                    "email": res.email,
                    'contact' : res.phone_number

                  },
                  "notes": {
                    "address": res.address
                  },
                  "theme": {
                    "color": res.color
                  }
                };
                var rzp1 = new Razorpay(options);
                rzp1.open();
                e.preventDefault();                
              }

            })
      });

  function PlaceOrder(payment_id,orderid){
        $(".mol_overlay").show();
        $.ajax({
            url : base_url+"payment/catrazorhandler",
            data : {'razorpay_payment_id' : payment_id,Rorderid:orderid, repay : 1 },
            type : 'post',
            dataType : 'json',
            success : function(result) {                                
                if(result.msg == 'success') {
                    location.reload();
                } else if(result.msg == 'fail'){
                    alert(result.error_msg);
                } else{
                    location.reload();
                }
            }
        });
    }
    $(document).on('click','.cliamOrder',function(){
      var id = $(this).attr('data-id');
      if (id != '' && id != undefined) {
        $.ajax({
            url : base_url+"refund/checkrefund",
            data : {'id':id},
            type : 'get',
            success : function(result) { 
              $('#refundModal').find('.modal-body').html(result.html);
              $('#refundModal').modal('show');
            }
        });
      }else{
        $('#refundModal').find('.modal-body').html('Please Reload your page then try again...');
        $('#refundModal').modal('show');
      }
    });
    $(document).on('click','.cliamStatus',function(){
      var id = $(this).attr('data-id');
      if (id != '' && id != undefined) {
        $.ajax({
            url : base_url+"refund/checkrefund",
            data : {'id':id},
            type : 'get',
            success : function(result) { 
              $('#refundModal').find('.modal-body').html(result.html);
              $('#refundModal').modal('show');
            }
        });
      }else{
        $('#refundModal').find('.modal-body').html('Please Reload your page then try again...');
        $('#refundModal').modal('show');
      }
    });
    $(document).on('submit','#giveRefund',function(e){
      e.preventDefault();
      var items = $('input[type="checkbox"].order_items').filter(':checked').length;
      if (items > 0) {      
        var formData = new FormData($(this)[0]);
        // var formData = $(this).serializeArray();
        $.ajax({
            url : base_url+"giverefund",
            data : formData,
            type : 'post',
            cache: false,
            processData: false,
            contentType: false,
            success : function(result) { 
              $('#refundModal').find('.modal-body').prepend(result.alertMessage);
            }
        });
      }else{
        $('.errorNoItems').html('Please Select atleast on item ...');
        $('.errorNoItems').addClass('in');
        setTimeout(function() {
          $('.errorNoItems').removeClass('in');
          $('.errorNoItems').html('');
        }, 3000);
      }

    })
    $(document).on('click','.reOrder',function(){
      var id = $(this).attr('data-id');
      var status = $(this).attr('data-check'); 
      var access_token = $('#csrf').val();
      bootbox.confirm({
        message: "Are you sure? Want to reorder this item?",
        buttons: {
            confirm: {
                label: '<i class="fa fa-check"></i> Yes',
            },
            cancel: {
                label: '<i class="fa fa-times"></i> No',
                className: 'btn-danger'
            }
        },
        callback: function (result) {
            if(result) { 
                reorder(id,status,access_token);
            }
        }
    });
  });

    function reorder(id,status,access_token){
      toastr.options={
          "closeButton":true,
          "positionClass":"toast-top-right",
          "showMethod": "fadeIn",
          "hideMethod": "fadeOut"};
        $.ajax({
            url : base_url+"api/order/reorder",
            data : {'id':id,'status':status, 'access_token':access_token},
            type : 'POST',
            beforeSend: function(xhr){xhr.setRequestHeader('Authorization', 'Bearer {!! \Session::get('access_token')!!}');},
            success : function(data) { 
                if(data.res_status == 'differ'){
                    $('#order_id').val(id);
                    $('#switch_cart').modal('show');
                } else if(data.res_status == 'failure no items'){
                  toastr.success('Few items not available now!!');
                } else {
                   window.location.href = base_url+'checkout';
                }
            }
        });
    }
    $(document).on('click','.add_new_cart_item',function(){
        var order_id = $('#order_id').val();
        var status   = $(this).attr('data-check');
        reorder(order_id,status);
    });
</script>
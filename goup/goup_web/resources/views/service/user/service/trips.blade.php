@extends('common.user.layout.base')
{{ App::setLocale(  isset($_COOKIE['user_language']) ? $_COOKIE['user_language'] : 'en'  ) }}
@section('styles')
@parent
<link rel='stylesheet' type='text/css' href="{{ asset('assets/plugins/data-tables/css/dataTables.bootstrap.min.css')}}"/>
<link rel='stylesheet' type='text/css' href="{{ asset('assets/layout/css/service-bootstrap.css')}}"/>

@stop
@section('content')   
      <!-- View Modal for trip start -->
      <div class="modal " id="modal1">
         <div class="modal-dialog min-70vw">
            <div class="modal-content">
               <!-- Schedule Header -->
               <div class="modal-header">
                  <h4 class="modal-title m-0">@lang('service.user.my_service')</h4>
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
               </div>
               <!-- Schedule body -->
               <div class="modal-body ">
                  <div class="row">
                  <div class="col-lg-6 col-md-6 col-sm-12">
                     <div class="my-trip-left">
                        <h4 class="text-center">
                           <strong>
                           <span class = "service_category"></span></strong>
                        </h4>
                        <div class="from-to row m-0">
                           <div class="from">
                              <h5>@lang('service.user.service_location') :<span class ="from_address"></h5>
                              <h5>@lang('service.user.service_type') : <span class ="service_type"></h5>
                              <h5>@lang('service.user.payment_mode'): <span class ="payment_mode"></h5>
                              <!-- <h5>Schedule Date :<span class ="pickup_date"></h5>
                              <h5>Schedule Time :<span class ="pickup_time"></h5> -->
                           </div>
                        </div>
                     </div>
                     <div class="mytrip-right my_trips">
                        <ul class="invoice">
                           <li>
                              <span class="fare">@lang('service.user.booking_id')</span>
                              <span class="txt"><span class ="booking_id"></span></span>
                           </li>
                           <li>
                              <span class="fare">@lang('service.user.base_fare')</span>
                              <span class =" txt base_fare"></span><span class="pricing">$</span> 
                           </li>
                           <li>
                              <span class="fare">@lang('service.user.tax_fare')</span>
                               <span class ="txt tax_fare"></span><span class="pricing">$</span>
                           </li>
                           <li>
                              <span class="fare">@lang('service.user.hourly_fare')</span>
                               <span class ="txt hourly_fare"></span><span class="pricing">$</span>
                           </li>
                           <li>
                              <span class="fare">@lang('service.user.wallet_detection')</span>
                               <span class ="txt wallet_detection"></span><span class="pricing">$</span>
                           </li>
                           <li class="promo_code">
                              <span class="fare">@lang('service.user.promocode_discount')</span>
                              <span class ="txt discount_fare"></span> 
                              <span class="txt-green pricing">
                                    @lang('service.user.get')     
                              </span>
                           </li>
                           <li class="extra_charge">
                              <span class="fare">@lang('service.user.extra_charge')</span>
                              <span class ="txt extra_charges"></span>
                              <span class="pricing">
                              <span class ="currency"></span> 
                              </span>        
                              
                           </li>
                           <li>
                              <hr>
                              <span class="fare" >@lang('service.user.total')</span>
                              <span class="txt-blue pull-right">
                                    <span class ="txt total_fare"></span>
                                    <span class ="pricing"></span>          
                              </span>
                              <hr>
                           </li>
                        </ul>
                     </div>
                     <div class="mytrip-right txt-white b-0 bg-red my_trips_cancelled">
                      <strong>@lang('service.user.cancelled')</strong>
                    </div>
                     <div>
                    </div>   
                  </div>
                  <div class="col-md-6">
                     <div class="header-section image_description">
                        <div class="c-pointer dis-column" style="width:200px">
                           <h5 class="text-left">@lang('service.user.before')</h5>
                           <div class="dis-center">
                              <img class="w-100 p-2 before-img" alt="add_document" height ="200px;" width ="100px;">
                           </div>
                        </div>
                        <div class="c-pointer dis-column" style="width:200px">
                           <h5 class="text-left">@lang('service.user.after')</h5>
                           <div class="dis-center">
                              <img src="" class="w-100 p-2 after-img" alt="add_document" height ="200px;" width ="100px;">
                           </div>
                        </div>
                     </div>
                     <div class="trip-user">
                        <div class="user-img"></div>
                        <div class="user-right">
                           <h5><span class ="provider_name"></span></h5>
                           <div class="rating-outer star">
                               <input type="hidden" class="rating" value="1" disabled="disabled">
                           </div>
                           <h5><span class ="commont"></h5>
                              <div class="rating-outer">
                                    <div id="provider_comment" style="cursor: default;"></div>                               
                              </div>
                           <p></p>
                        </div>
                     </div>
                  </div>
               </div>
               </div>
            </div>
         </div>
      </div>
      <!-- View Modal for trip Ends -->
      <!-- View Modal for upcoming details-->
      <div class="modal" id="modal2">
         <div class="modal-dialog min-70vw">
            <div class="modal-content">
               <!-- Schedule Header -->
               <div class="modal-header">
                  <h4 class="modal-title m-0">@lang('service.user.service_details')</h4>
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
               </div>
               <!-- Schedule body -->
               <div class="modal-body ">
                  <div class="col-lg-6 col-md-6 col-sm-12 float-left">
                     <div class="my-trip-left">
                        <h4 class="text-center">
                           <strong><span class = "service_category"></span></strong>
                        </h4>
                        <div class="from-to row m-0">
                           <div class="from">
                              <h5>@lang('service.user.service_location') :<span class ="from_address"></h5>
                              <h5>@lang('service.user.service_type') : <span class ="service_type"></h5>
                              <h5>@lang('service.user.payment_mode'): <span class ="payment_mode"></h5>
                              <h5>@lang('service.user.schedule_date') :<span class ="pickup_date"></h5>
                             
                              <button type="button" id="cancel_req" data-id="" class="btn btn-primary btn-block">@lang('service.user.cancel') <i class="fa fa-check" aria-hidden="true"></i></button>

                     
                              
                              
                           </div>
                        </div>
                     </div>

                     <!-- <div class="mytrip-right  my_trips">
                        <div class="fare-break">
                        <ul class="invoice">
                           <li>
                              <span class="fare">Base Fare</span>
                                <span class="pricing">
                                    <span class ="currency"></span> <span class ="base_fare"></span> 
                                 </span>
                           </li>
                           <li>
                              <span class="fare">Tax Fare</span>
                              <span class="pricing">
                                  <span class ="currency"></span> <span class ="minute_fare"></span>
                              </span>
                           </li>
                           <li>
                              <span class="fare">Hourly Fare</span>
                              <span class="pricing">
                                 <span class ="currency"></span> <span class ="hourly_fare"></span>
                              </span>
                           </li>
                           <li>
                              <span class="fare">Wallet Detection</span>
                              <span class="pricing">
                                 <span class ="currency"></span> <span class ="wallet_fare"></span>         
                              </span>
                           </li>
                           <li class="promo_code">
                              <span class="fare">Promocode Discount</span>
                              <span class="txt-green pricing">
                                    GET <span class ="discount_fare"></span>         
                              </span>
                           </li>
                           <li class="extra_charge">
                              <span class="fare">Extra Charge</span>
                              <span class="pricing">
                              <span class ="currency"></span><span class ="extra_charges"></span>
                              </span>         
                              
                           </li>
                           <li>
                              <hr>
                              <span class="fare" >Total</span>
                              <span class="txt-blue pull-right">
                                    <span class ="currency"></span> <span class ="total_fare"></span>         
                              </span>
                              <hr>
                           </li>
                        </ul>
                        </div>
                     </div>
                     -->
                  </div>
                  <div class="col-md-6 float-right my_trips">
                     <div class="header-section image_description">
                        <div class="c-pointer dis-column">
                           <h5 class="text-left">@lang('service.user.before')</h5>
                           <div class="dis-center">
                              <img class="w-100 p-2 before-img" alt="add_document" height ="200px;" width ="100px;">
                           </div>
                        </div>
                        <div class="c-pointer dis-column">
                           <h5 class="text-left">@lang('service.user.after')</h5>
                           <div class="dis-center">
                              <img src="" class="w-100 p-2 after-img" alt="add_document" height ="200px;" width ="100px;">
                           </div>
                        </div>
                     </div>
                     <div class="trip-user">
                        <div class="user-img"></div>
                        <div class="user-right">
                           <h5><span class ="provider_name"></span></h5>
                           <div class="rating-outer star">
                              
                              <input type="hidden" class="rating" value="1" disabled="disabled">
                           </div>
                           <p></p>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!-- View Modal for Upcoming Ends -->
      <!-- Dispute Modal -->
      <div class="modal" id="disputeModal">
         <div class="modal-dialog">
            <div class="modal-content">
               <!-- Dispute Header -->
               <input type="hidden" name="id" value="id">
               <div class="modal-header">
                  <h4 class="modal-title">@lang('service.user.dispute_details')</h4>
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
               </div>
               <div class="from-to row m-0 getdisputedetails">
                     <div class="from">
                        <h5 class="text-left">@lang('service.admin.dispute.dispute_name') :  <span class ="dispute_name txt-blue ml-2"></span></h5>
                        <h5 class="text-left">@lang('service.user.date') :<span class ="created_at txt-blue ml-2"></span></h5>
                        <h5 class="text-left">@lang('service.user.status') :<span class ="status txt-blue ml-2"></span></h5>
                        <h5 class="text-left">@lang('service.user.commented_by') :<span class ="comments_by txt-blue ml-2"></span></h5>
                        <h5 class="text-left">@lang('service.user.comments') :<span class ="comments txt-blue ml-2"></span></h5>
                     </div>
                     
               </div>
               <!-- Dispute body -->
               <form class="validateForm getdispute"  style="color:red;">
                  <input type ="hidden" name="dispute_type" value ="user"/>
                  <div class="col-md-12 col-sm-12">
                     <h5 class=" no-padding"><strong>@lang('service.admin.dispute.dispute_name')</strong></h5>
                     <select name="dispute_name" id="dispute_name" class="form-control" autocomplete="off">
                        <option value="">@lang('service.user.select')</option>
                     </select>
                  </div>
                  <div class="comments-section field-box mt-3 col-12 dispute_comments">
                     <textarea class="form-control" rows="4" cols="50" id="comments" name ="comments"  placeholder="Leave Your Comments..."></textarea>
                  </div>
                  <div class="modal-footer">
                     <!-- <a  class="btn btn-primary btn-block" data-toggle="modal" data-target="#disputeModal" >Submit <i class="fa fa-check" aria-hidden="true"></i></a> -->
                     <button type="submit"  class="btn btn-primary btn-block">@lang('service.submit') <i class="fa fa-check" aria-hidden="true"></i></button>

                  </div>
               </form>
            </div>
         </div>
      </div>
      <!-- Dispute Modal -->
      <section class="ride-grid content-box-2">
         <div class="history-nav xs-visible"> 
            @foreach(Helper::getServiceList() as $service)
               <div class="menu-item menu-one ">
                  @if($service =='TRANSPORT')
                     <div id ="transport-detail">
                        <a  class="dis-column" href="{{ url('/transport/trips') }}">
                           <div class="dis-center"><i class="material-icons">local_taxi</i></div>
                           <span class ="transport-detail">{{ __('TRANSPORT') }}</span>
                        </a>
                     </div>
                  @elseif($service =='ORDER')
                     <a  class="dis-column" href="{{ url('/order/trips') }}">
                        <div class="dis-center"><i class="material-icons">fastfood</i></div>
                        <span class ="order-detail">{{ __('ORDER') }}</span>
                     </a>
                   @elseif($service =='DELIVERY')
                     <a  class="dis-column" href="{{ url('/delivery/trips') }}">
                        <div class="dis-center"><i class="material-icons">fastfood</i></div>
                        <span class ="order-detail">{{ __('DELIVERY') }}</span>
                     </a>
                  @else
                     <a  class="dis-column" href="{{ url('/services/trips') }}">
                     <div class="dis-center"><i class="material-icons">local_laundry_service</i></div>
                        <span class ="service-detail">{{ __('SERVICE') }}</span>
                     </a>
                  @endif
               </div>
            @endforeach
            <!-- <div class="menu-item menu-one ">
               <a  class="dis-column" href="../taxi-booking/my-trips.php">
                  <div class="dis-center"><i class="material-icons">local_taxi</i></div>
                  <span>Taxi</span>
               </a>
            </div>
            <div class="menu-item menu-two menu-active ">
               <a   class="dis-column" href="./my-orders.php">
                  <div class="dis-center"><i class="material-icons">fastfood</i></div>
                  <span>Food</span>
               </a>
            </div>
            <div class="menu-item menu-three ">
               <a   class="dis-column" href="../services/my-services.php">
                  <div class="dis-center"><i class="material-icons">local_laundry_service</i></div>
                  <span>Book Services</span>
               </a>
            </div> -->
         </div>
         <div class="">
            <div class="clearfix ">
               <div class="dis-center col-md-12 p-0 dis-center">
                  <ul class="nav nav-tabs">
                     <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#my_trips">@lang('service.user.my_service')</a>
                     </li>
                     <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#upcoming_trips">@lang('service.user.upcoming_service')</a>
                     </li>
                  </ul>
               </div>
               <div id="toaster" class="toaster"></div>
               <div class="tab-content">
                  <div id="my_trips" class="tab-pane active col-sm-12 col-md-12 col-lg-12">
                     <div class="row ride-details">
                        
                        <div class="col-md-12 col-lg-12 col-sm-12 p-0 table-responsive-sm mt-4">
                           <table  id="my_services" class="table  table-striped table-bordered w-100">
                              <thead>
                                 <tr>
                                    <th>&nbsp;@lang('user.s.no')</th>
                                    <th>@lang('user.booking_id')</th>
                                    <th>@lang('user.date')</th>
                                    <th>@lang('user.profile.name')</th>
                                    <th>@lang('user.amount')</th>
                                    <th>@lang('user.service_type')</th>
                                    <th>@lang('user.payment')</th>
                                    <th>@lang('user.status')</th>
                                    <th>@lang('user.action')</th>
                                 </tr>
                              </thead>
                           </table>
                        </div>
                     </div>
                  </div>
                  <div id="upcoming_trips" class="tab-pane col-sm-12 col-md-12 col-lg-12">
                     <h4>@lang('service.user.upcoming_service')</h4>
                     <div class="row ride-details">
                        
                        <div class="col-md-12 col-lg-12 col-sm-12 p-0 table-responsive-sm mt-4">
                           <table  id="upcoming_services" class="table table-striped table-bordered w-100">
                              <thead>
                                 <tr>
                                    <th>&nbsp;@lang('user.s.no')</th>
                                    <th>@lang('user.booking_id')</th>
                                    <th>@lang('user.date')</th>
                                    <th>@lang('user.profile.name')</th>
                                    <th>@lang('user.service_type')</th>
                                    <th>@lang('user.action')</th>
                                 </tr>
                              </thead>
                           </table>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </section>
<!-- Bootstrap core JavaScript
================================================== -->
@stop
@section('scripts')
@parent
<script src="{{ asset('assets/plugins/data-tables/js/jquery.dataTables.min.js')}}"></script>
<script src="{{ asset('assets/plugins/data-tables/js/dataTables.bootstrap.min.js')}}"></script>
   <script>
      var trips_table = $('#my_services');
      var upcoming_table = $('#upcoming_services');
      $(document).ready(function() {
       $( trips_table.table().container() ).removeClass( 'form-inline' );
       $( upcoming_table.table().container() ).removeClass( 'form-inline' );
       $('.dataTables_length select').addClass('custom-select');
       $('.dataTables_paginate li').addClass('page-item');
       $('.dataTables_paginate li a').addClass('page-link');
   });
   //For get the dispute name
   //for get dispute id
   var dispute_id = '';
   var currency_symbol="";
   $('body').on('click', '.dispute', function(e) {
        e.preventDefault();
        $('#dispute_name,#comments').val('');
        $('.dispute_comments').hide();
        dispute_id = $(this).data('id');
        user_id = $(this).data('user_id');
        provider_id = $(this).data('provider_id');
         $.ajax({
            type: "GET",
            url: getBaseUrl() + "/user/service/disputestatus/"+dispute_id,
            beforeSend: function (request) {
               showLoader();
            },
            headers: {
            Authorization: "Bearer " + getToken("user")
            },
            success: function(data) {
               var result = data.responseData;
               if(result !='')
               {
                 $('.getdispute').hide();
                 $('.getdisputedetails').show();
                 $('.dispute_name').text(result.dispute_name)
                 $('.created_at').text(result.created_time)
                 $('.status').text(result.status) 
                 $('.comments_by').text(result.comments_by)  
                 $('.comments').text(result.comments)   
               }else{
                  $('.getdisputedetails').hide();
                  $('.getdispute').show();
               }
               hideLoader();
            }
         });
    });

    $('#dispute_name').change(function(){
       var dispute_name=$(this).val();
      //  alert(dispute_name);
       if(dispute_name=="Others"){
         //  alert()
          $('.dispute_comments').show();
       }else{
         $('.dispute_comments').hide();
       }
    });
     


   //  setTimeout(function(){
        
   //      $('.subnav').show(); 
   //      $('.subnav > .menu-two').addClass('menu-active');
   //      $('.content-box').addClass('content-box-2');
       
   //    }, 1000);
   $.ajax({
      url:  getBaseUrl() + "/user/services/dispute",
      type: "GET",
      beforeSend: function (request) {
               showLoader();
            },
      headers: {
      Authorization: "Bearer " + getToken("user")
         },
      success: function(data) {
         $("#dispute_name").empty()
            .append('<option value="">Select</option>');
         $.each(data.responseData, function(key, item) {
            $("#dispute_name").append('<option value="' + item.dispute_name + '">' + item.dispute_name + '</option>');
         });
         $("#dispute_name").append('<option value="Others">Others</option>');
         hideLoader();

      }
   });

  




   //Submit dispute details
   $('.validateForm').validate({
		errorElement: 'span', //default input error message container
		errorClass: 'help-block', // default input error message class
		focusInvalid: false, // do not focus the last invalid input
		rules: {
         dispute_name: { required: true },
		},

		messages: {
			dispute_name: { required: "Dispute Name is required." },

		},
		highlight: function(element)
		{
			$(element).closest('.form-group').addClass('has-error');
		},
		success: function(label) {
			label.closest('.form-group').removeClass('has-error');
			label.remove();
		},

		submitHandler: function(form,e) {
            e.preventDefault();
            var formGroup = $(".validateForm").serialize().split("&");
            var data = new FormData();
            for(var i in formGroup) {
                var params = formGroup[i].split("=");
                data.append( params[0], decodeURIComponent(params[1]) );
            }
            data.append('id', dispute_id );
            data.append('user_id', user_id );
            data.append('provider_id', provider_id );
            var url = getBaseUrl() + "/user/service/dispute";
            saveRow( url, null, data, "user");
            $('#disputeModal').modal('hide');
		}
    });
   //For Trip details
   $('body').on('click', '.tripdetails', function(){
      var id = $(this).data('id');
      $.ajax({
         type:"GET",
         url: getBaseUrl() + "/user/trips-history/service/"+id,
         headers: {
               Authorization: "Bearer " + getToken("user")
         },
         beforeSend: function (request) {
               showLoader();
            },
         success:function(data){
            var result = data.responseData;
            var item=result.service;
           
            var  starvalue=`<span class ="star" style="cursor: default;">`;
            if(item.rating !==null && item.rating.user_rating !== 0)
            {
               var proviterate = Math.round(item.rating.user_rating);
            }
            else
            {
               var proviterate = Math.round(item.provider.rating);
            }
               for (var i = 0; i < proviterate; i++) { 
                     starvalue += `<div class="rating-symbol" style="display: inline-block; position: relative;">
                        <div class="fa fa-star-o" style="visibility: visible;"></div>
                        <div class="rating-symbol-foreground" style="display: inline-block; position: absolute; overflow: hidden; left: 0px; right: 0px;top: 0; width: auto;"><span class="fa fa-star" aria-hidden="true"></span></div>
                     </div>
                     `;
               }
               starvalue +=`</span>`;
               if(item.rating !== null && item.rating.user_comment !== null)
               {
                  $('.commont').text("Comment");
                  $('#provider_comment').text(item.rating.user_comment);
               }
               else{
                  $('.commont').text("");
                  $('#provider_comment').text("");
               }    
               $('.booking_id').text(item.booking_id);
               $('.service_category').text(item.service.servicesub_category ? item.service.servicesub_category.service_subcategory_name : "NA"); 
               $('.pricing').text(currency_symbol); 
               $('.payment_mode').text(item.payment_mode);
               if(item.before_image == null && item.after_image == null){
                     $('.image_description').hide();
               }else if( item.before_image == null  ) {
               $('.before-img').attr('src',"{{ asset('assets/layout/images/admin/no_image.png') }}"); 
               $('.after-img').attr('src',item.after_image); 
               } else if(item.after_image == null){
                  $('.before-img').attr('src',item.before_image); 
                  $('.after-img').attr('src',"{{ asset('assets/layout/images/admin/no_image.png') }}"); 
               } else {
                  $('.before-img').attr('src',item.before_image);
                  $('.after-img').attr('src',item.after_image); 
               }
               
               $('.user-img').css('background-image', 'url('+item.provider.picture+')');
               $('.provider_name').text(item.provider.last_name);

               $('.from_address').text(item.s_address);  
               $('.service_type').text(item.service.service_name);  
               $('.pickup_date').text(item.schedule_time);  
               if(item.status=='SCHEDULED'){
                  $('#cancel_req').attr('data-id',item.id);
                  $('#cancel_req').show();
               }else{
                  $('#cancel_req').attr('data-id',item.id);
                  $('#cancel_req').hide();
               }
               
               
               $('.star').html(starvalue);
                
               if(item.status !="CANCELLED"){
                  $('.my_trips_cancelled').hide(); 
                  $('.my_trips').show(); 
                  $('.base_fare').text(item.payment.fixed);
                  $('.tax_fare').text(item.payment.tax?item.payment.tax:'0');
                  $('.minute_fare').text(item.payment.minute?item.payment.minute:'0');
                  $('.hourly_fare').text(item.payment.hour?item.payment.hour:'0');
                  $('.wallet_fare').text(item.payment.wallet?item.payment.wallet:'0');
                  $('.wallet_detection').text(item.payment.wallet?item.payment.wallet:'0');
                  
                  if(item.promocode_id != 0){
                     $('.discount_fare').text(item.payment.discount);
                  }else{
                     $('.promo_code').hide(); 
                  }
                  if(item.payment.extra_charges != 0){
                     $('.extra_charges').text(item.payment.extra_charges);
                  }else {
                     $('.extra_charge').hide();
                  }
               $('.total_fare').text(item.payment.total);
               
               }else{
                  $('.my_trips').hide();
                  $('.my_trips_cancelled').show(); 
               } 
               hideLoader();
         }
      });
   });
    //For upcoming details
    $('body').on('click', '.upcomingdetails', function(){
      var id = $(this).data('id');
      $.ajax({
         type:"GET",
         url: getBaseUrl() + "/user/trips-history/service/"+id,
         headers: {
               Authorization: "Bearer " + getToken("user")
         },
         beforeSend: function (request) {
               showLoader();
            },
         success:function(data){
            var result = data.responseData.service;
            var item=result;
            
            var  starvalue=`<span class ="star" style="cursor: default;">`;
            if(result.rating !== null && result.rating.user_rating !== 0)
            {
               var userrate = Math.round(result.rating.user_rating);
            }
            else
            {
               var userrate = Math.round(result.provider.rating);
            }
            for (var i = 0; i < item.provider.rating; i++) {
                   starvalue += `<div class="rating-symbol" style="display: inline-block; position: relative;">
                      <div class="fa fa-star-o" style="visibility: visible;"></div>
                      <div class="rating-symbol-foreground" style="display: inline-block; position: absolute; overflow: hidden; left: 0px; right: 0px;top: 0; width: auto;"><span class="fa fa-star" aria-hidden="true"></span></div>
                   </div>
                   `;
            }
             starvalue +=`</span>`;
               $('.booking_id').text(item.booking_id);
               $('.service_category').text(item.service.servicesub_category ? item.service.servicesub_category.service_subcategory_name : "NA"); 
               $('.currency').text(currency_symbol); 
               $('.payment_mode').text(item.payment_mode); 
               $('.before-img').attr('src',item.before_image); 
               $('.after-img').attr('src',item.after_image); 
               $('.user-img').css('background-image', 'url('+item.provider.picture+')');
               $('.provider_name').text(item.provider.last_name);

               $('.from_address').text(item.s_address);  
               $('.service_type').text(item.service.service_name);  
               $('.pickup_date').text(item.schedule_time);  
               if(item.status=='SCHEDULED'){
                  $('#cancel_req').attr('data-id',item.id);
                  $('#cancel_req').show();
               }else{
                  $('#cancel_req').attr('data-id',item.id);
                  $('#cancel_req').hide();
               }
               if(item.before_image == null && item.after_image == null){
               $('.image_description').hide();
               }else if( item.before_image == null  ) {
               $('.before-img').attr('src',"{{ asset('assets/layout/images/admin/no_image.png') }}"); 
               $('.after-img').attr('src',item.after_image); 
               } else if(item.after_image == null){
                  $('.before-img').attr('src',item.before_image); 
                  $('.after-img').attr('src',"{{ asset('assets/layout/images/admin/no_image.png') }}"); 
               } else {
                  $('.before-img').attr('src',item.before_image);
                  $('.after-img').attr('src',item.after_image); 
               }
               // $('.base_fare').text(item.payment.fixed);
               // $('.minute_fare').text(item.payment.minute);
               // $('.hourly_fare').text(item.payment.hour);
               // $('.wallet_fare').text(item.payment.wallet);
               // if(item.promocode_id != 0){
               //       $('.discount_fare').text(item.payment.discount);
               //    }else{
               //       $('.promo_code').hide(); 
               //    }
               //    if(item.payment.extra_charges != 0){
               //       $('.extra_charges').text(item.payment.extra_charges);
               //    }else {
               //       $('.extra_charge').hide();
               //    }
               // $('.total_fare').text(item.payment.total);
               $('.star').html(starvalue); 
               hideLoader();
           
         }
      });
   });

   $(document).on('click', '#cancel_req', function(e){
      e.preventDefault();
      var id = $(this).data('id');
      var result = confirm("Are You sure Want to delete?");
      $.ajax({
         url: getBaseUrl() + "/user/service/cancel/request",
         type: "Post",
         data: {
                id: id
         },
         headers: {
            Authorization: "Bearer " + getToken("user")
         },
         //processData: false,
         //contentType: false,
         success: function(response, textStatus, jqXHR) {
            location.reload();
         },
         error: function(jqXHR, textStatus, errorThrown) {
            alertMessage(textStatus, jqXHR.responseJSON.message, "danger");
         }
      });
   });


         //Set the datatable for my trip details
      trips_table = trips_table.DataTable( {
        "processing": true,
        "serverSide": true,
        "ordering": false,
        "lengthChange": false,
        "ajax": {
            "url": getBaseUrl() + "/user/trips-history/service",
            "type": "GET",
            "beforeSend": function (request) {
               showLoader();
            },
            "headers": {
                "Authorization": "Bearer " + getToken("user")
            },data: function(data){
                 
                var info = $('#my_services').DataTable().page.info();
                delete data.columns;

                data.page = info.page + 1;
                data.search_text = data.search['value'];
               
            },
            dataFilter: function(data){               
               var json = parseData( data );
               if(json.responseData.service.total > 0){
               currency_symbol=json.responseData.service.data[0].user.currency_symbol;
               }
               json.recordsTotal = json.responseData.service.total;
               json.recordsFiltered = json.responseData.service.total;
               json.data = json.responseData.service.data;
               hideLoader();
               return JSON.stringify( json ); // return JSON string
            }
        },
        "columns": [
         { "data": "id" ,render: function (data, type, row, meta) {
               return meta.row + meta.settings._iDisplayStart + 1;
              }
            },
            { "data": "booking_id" },
            { "data": "created_time"},
            /* ,render: function (data, type, row) {
               return new Date( data ).toLocaleDateString("en-Us") + ' ' + new Date(data).toLocaleTimeString([], { hour: "2-digit", minute: "2-digit" });
            }
            },*/
            { "data": "provider_id" ,render: function (data, type, row) {
               return row.provider!=null ?row.provider.first_name+' '+row.provider.last_name:'NA';
            }
            },
            { "data": "provider_id" ,render: function (data, type, row) {
               return row.payment != null ?row.user.currency_symbol+' '+row.payment.total:'NA';
            }
            },
            { "data": "service_id" ,render: function (data, type, row) {
               return row.service.service_name;
            }
            },
            { "data": "provider_id" ,render: function (data, type, row) {
               return row.payment != null ? row.payment.payment_mode:'NA';
            }
            },
            { "data": "status" ,render: function (data, type, row) {
               return row.status;
            }
            },
            { "width": "130px","data": "id", render: function (data, type, row) { 

               var html = ``;

               if(row.user_rated == 0 && row.status == 'COMPLETED') {
                  html += `<a href="{{ url('/service') }}/`+row.service_id+`/service?id=`+row.id+`"><span class="view-icon tripdetails" data-toggle="modal" data-target="#modal1" data-id = `+data+` data-toggle="tooltip" title="View"> <i class="fa fa-eye"></i></span></a>`;
               } else {
                  html += `<span class="view-icon tripdetails" data-toggle="modal" data-target="#modal1" data-id = `+data+` data-toggle="tooltip" title="View"> <i class="fa fa-eye"></i></span>`;
               }
               html += ` <span class="view-icon dispute mt-1" data-toggle="modal" data-target="#disputeModal" data-id = `+data+` data-user_id = `+row.user_id+` data-provider_id = `+row.provider_id+` data-toggle="tooltip" title="Create Dispute"><i class="fa fa-commenting-o" data-toggle="tooltip" title="Create Dispute"></i></span>`; 
               return html;

            }}
        ],"drawCallback": function () {
            $('.dataTables_length select').addClass('custom-select');
            $('.dataTables_paginate li').addClass('page-item');
            $('.dataTables_paginate li a').addClass('page-link');
            var info = $('#my_services').DataTable().page.info(); 
            if (info.pages<=1) { 
               $('#my_services_paginate').hide();
               $('#my_services .dataTables_paginate').hide();
               $('#my_services .dataTables_info').hide();
            }else{
               $('.dataTables_paginate').show();
               $('.dataTables_info').show();
            }
        }
      });

      //Set the datatable for my upcoming trip details
      upcoming_table = upcoming_table.DataTable( {
        "processing": true,
        "serverSide": true,
        "ordering": false,
        "lengthChange": false,
        "ajax": {
            "url": getBaseUrl() + "/user/trips-history/service?type=upcoming",
            "type": "GET",
            "beforeSend": function (request) {
               showLoader();
            },
            "headers": {
                "Authorization": "Bearer " + getToken("user")
            },data: function(data){
               
                var info = $('#upcoming_services').DataTable().page.info();
                delete data.columns;

                data.page = info.page + 1;
                data.search_text = data.search['value'];
                
            },
            dataFilter: function(data){               
               var json = parseData( data );
               json.recordsTotal = json.responseData.service.total;
               json.recordsFiltered = json.responseData.service.total;
               json.data = json.responseData.service.data;
               hideLoader();
               return JSON.stringify( json ); // return JSON string
            }
        },
        "columns": [
         { "data": "id" ,render: function (data, type, row, meta) {
               return meta.row + meta.settings._iDisplayStart + 1;
              }
            },
            { "data": "booking_id" },
            {"data":"schedule_time"},
            { "data": "provider_id" ,render: function (data, type, row) {
               return row.provider!=null ?row.provider.last_name:'NA';
            }
            },
            
            { "data": "service_id" ,render: function (data, type, row) {
               return row.service.service_name;
            }
            },
            { "data": "id", render: function (data, type, row) {
                 return `<span class="view-icon upcomingdetails" data-toggle="modal" data-target="#modal2" data-id = `+data+`> <i class="fa fa-eye"></i></span><span class="view-icon dispute m-1" data-toggle="modal" data-target="#disputeModal" data-id = `+data+` data-user_id = `+row.user_id+`><i class="fa fa-commenting-o"></i></span>`;
            }}
        ],"drawCallback": function () {
            $('.dataTables_length select').addClass('custom-select');
            $('.dataTables_paginate li').addClass('page-item');
            $('.dataTables_paginate li a').addClass('page-link');
            var info = $('#upcoming_services').DataTable().page.info(); 
            if (info.pages<=1) { 
               $('#upcoming_services_paginate').hide();
               $('#upcoming_services .dataTables_paginate').hide();
               $('#upcoming_services .dataTables_info').hide();
            }else{
                 $('.dataTables_paginate').show();
                 $('.dataTables_info').show();
             }
        }
      });
      
         function openNav() {
            document.getElementById("mySidenav").style.width = "100%";
          }
          
          function closeNav() {
            document.getElementById("mySidenav").style.width = "0";
          }
         
          $(document).ready(function() {
            $('#my_services').DataTable();
            $('#upcoming_services').DataTable();
          });
         
          // Input Checked
          $(document).ready(function(){
            $('input:checkbox').click(function() {
               $('input:checkbox').not(this).prop('checked', false);
            });
          });
         
           // Booking-Section
         $("#request_service").click(function() {
               $("#service-status").removeClass("d-none");
               $(".ride-section").addClass("d-none");
            });
         
            $("#book-now").click(function() {
               $("#service-status").removeClass("d-none");
               $("#booking-ride").addClass("d-none");
            });
            $("#cancel_req").click(function() {
               $(".ride-section").removeClass("d-none");
               $("#service-status").addClass("d-none");
            });
         
            $(".status").click(function() {
               $("#accepted-status").removeClass("d-none");
               $("#service-status").addClass("d-none");
            });
            $("#cancel_req_2").click(function() {
               $(".ride-section").removeClass("d-none");
               $("#accepted-status").addClass("d-none");
            });
            $(".trip-user").click(function() {
               $("#invoice-section").removeClass("d-none");
               $("#accepted-status").addClass("d-none");
            });

      </script>
@stop
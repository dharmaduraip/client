@extends('common.user.layout.base')
{{ App::setLocale(  isset($_COOKIE['user_language']) ? $_COOKIE['user_language'] : 'en'  ) }}
@section('styles')
@parent
<style>
</style>

   <link rel='stylesheet' type='text/css' href="{{ asset('assets/plugins/data-tables/css/dataTables.bootstrap.min.css')}}"/>
@stop
@section('content')

<!-- View Modal 1 Starts -->
<div class="modal " id="modal1">
   <div class="modal-dialog min-70vw">
      <div class="modal-content">
         <!-- Schedule Header -->
         <div class="modal-header">
            <h4 class="modal-title m-0">@lang('transport.user.ride_details')</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
         </div>
         <!-- Schedule body -->
         <div class="modal-body ">
            <div class="col-lg-6 col-md-6 col-sm-12 float-left">
               <div class="my-trip-left">
                  <h4 class="text-center">
                     <strong>
                     <span class ="vehicle_name"></span>
                     - @lang('transport.user.fire_breakdown')</strong>
                  </h4>
                  <div class="from-to row m-0">
                     <div class="from">
                        <h5>@lang('transport.user.from') :  <span class ="from_address"></span></h5>
                        <h5> @lang('transport.user.to')<span class ="to_address"></span></h5>
                        <div class='my_trips'>
                        <h5>@lang('transport.user.pickup_date') : <span class ="pickup_date"></span></h5>
                        <h5>@lang('transport.user.pickup_time') : <span class ="pickup_time"></span></h5>
                        <h5>@lang('transport.user.drop_date') : <span class ="drop_date"></span></h5>
                        <h5>@lang('transport.user.drop_time') : <span class ="drop_time"></span></h5>
                        <h5>@lang('transport.user.payment'): <span class ="payment_mode"></span></h5>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="mytrip-right my_trips">
                  <div class="fare-break ">
                     <div id="delivery_trips">
                           
                     </div>
                     <!-- <h5>@lang('transport.user.base_fare') <span>
                            <span class ="base_fare"></span> <span class ="currency"></span> 
                        </span>
                     </h5>
                     <h5>@lang('transport.user.minutes_fare') <span>
                         <span class ="minute_fare"></span>  <span class ="currency"></span>
                        </span>
                     </h5>
                     <h5>@lang('transport.user.distance_fare') <span>
                        <span class ="distance_fare"></span>  <span class ="currency"></span>
                        </span>
                     </h5>
                     <h5><strong>@lang('transport.user.toll_charges')</strong><span><strong>
                         </span>  <span class ="toll_charges"></span>  <span class ="currency"></span>
                        </strong></span>
                     </h5>
                     <h5><strong>@lang('transport.user.round_off')</strong><span><strong>
                         </span>  <span class ="round_off"></span>  <span class ="currency"></span>
                        </strong></span>
                     </h5>
                     <h5><strong>@lang('transport.user.tax_fare')</strong><span><strong>
                         </span>  <span class ="tax_fare"></span>  <span class ="currency"></span>
                        </strong></span>
                     </h5> -->
                     <h5 class="big"><strong>@lang('transport.user.charged') - <strong class ="payment_mode"></strong><span><strong>
                         <span class ="charged_fare"></span> <span class ="currency"></span> 
                        </strong></span>
                     </h5>
                  </div>
                  </div>
                  <div class="mytrip-right txt-white b-0 bg-red my_trips_cancelled">
                  <strong>@lang('transport.user.cancelled')</strong>
                  </div>
               
            </div>
            <div class="col-md-6 float-right">
               <div class="map-static" style="height: 400px; position: relative; overflow: hidden;">
                   <img class = "map_key_img" />
               </div>
               <div class="trip-user">
                  <!-- For image listing -->
                   <div class="user-img"> </div>
                  <div class="user-right">
                     <h5> <span class ="provider_name"></span></h5>
                     <div class="rating-outer">
                        <span class ="star" style="cursor: default;">
                        </span>
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
<!-- View Modal 1 Ends -->
<!-- View Modal 2 Starts -->
<div class="modal" id="modal2">
   <div class="modal-dialog min-70vw">
      <div class="modal-content">
         <!-- Schedule Header -->
         <div class="modal-header">
            <h4 class="modal-title m-0">@lang('transport.user.ride_details')</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
         </div>
         <!-- Schedule body -->
         <div class="modal-body ">
            <div class="col-lg-6 col-md-6 col-sm-12 float-left">
               <div class="my-trip-left">
                  <h4 class="text-center">
                     <strong>
                     <span class ="vehicle_name"></span>
                     - @lang('transport.user.fire_breakdown')</strong>
                  </h4>
                  <div class="from-to row m-0">
                     <div class="from">
                        <h5>@lang('transport.user.from') :  <span class ="from_address"></span></h5>
                        <h5>@lang('transport.user.to') :   <span class ="to_address"></span></h5>
                        <h5>@lang('transport.user.schedule_date') : <span class ="schedule_date"></span></h5></h5>
                        <h5>@lang('transport.user.payment'): <span class ="payment_mode"></span></h5>
                     </div>
                  </div>
               </div>
            </div>
            <div class="col-md-6 float-right">
               <div class="map-static" style=" position: relative; overflow: hidden;">
                   <img class = "map_key_img" />
               </div>
               
                     <p></p>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<!-- Dispute Modal -->
<div class="modal" id="disputeModal">
         <div class="modal-dialog">
            <div class="modal-content">
               <!-- Dispute Header -->
               <input type="hidden" name="id" value="id">
               <div class="modal-header">
                  <h4 class="modal-title">@lang('transport.user.dispute_details')</h4>
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
               </div>
               <div class="from-to row m-0 getdisputedetails">
                     <div class="from">
                        <h5 class="text-left">@lang('transport.admin.dispute.dispute_name') :  <span class ="dispute_name txt-yellow ml-2"></span></h5>
                        <h5 class="text-left">@lang('transport.user.date') :<span class ="created_at txt-yellow ml-2"></span></h5>
                        <h5 class="text-left">@lang('transport.user.status') :<span class ="status txt-yellow ml-2"></span></h5>
                        <h5 class="text-left">@lang('transport.user.commented_by') :<span class ="comments_by txt-yellow ml-2"></span></h5>
                        <h5 class="text-left">@lang('transport.user.comments') :<span class ="comments txt-yellow ml-2"></span></h5>
                     </div>
                     
               </div>
               <!-- Dispute body -->
               <form class="validateForm getdispute" style= "color:red;">
                  <input type ="hidden" name="dispute_type" value ="user"/>
                  <div class="col-md-12 col-sm-12">
                     <h5 class=" no-padding"><strong>@lang('transport.admin.dispute.dispute_name')</strong></h5>
                     <select name="dispute_name" id="dispute_name" class="form-control" autocomplete="off">
                        <option value="">@lang('transport.user.select')</option>
                     </select>
                  </div>
                  <div class="comments-section field-box mt-3 col-12" id ="dispute_comments">
                     <h5 class=" no-padding"><strong>@lang('transport.admin.dispute.dispute_comments')</strong></h5>
                     <textarea class="form-control" rows="4" cols="50" id="comments"  name ="comments" placeholder="Dispute Comments..."></textarea>
                  </div>
                  <!-- Dispute footer -->
                  <div class="modal-footer">
                     <!-- <a  class="btn btn-primary btn-block" data-toggle="modal" data-target="#disputeModal" >Submit <i class="fa fa-check" aria-hidden="true"></i></a> -->
                      <button type="submit"  class="btn btn-primary btn-block">@lang('transport.submit') <i class="fa fa-check" aria-hidden="true"></i></button>
                  </div>
               </form>
            </div>
         </div>
      </div>
<!-- Dispute Modal ends -->
<!--LostItems Modal -->
<div class="modal" id="lostItemsModal">
         <div class="modal-dialog">
            <div class="modal-content">
               <!-- Dispute Header -->
               <div class="modal-header">
                  <h4 class="modal-title">@lang('transport.user.lost_item_details') </h4>
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
               </div>
               <div class="from-to row m-0 getlostItemstails">
                  <div class="from">
                     <h5 class="text-left">@lang('transport.admin.lostitem.lost_item') :  <span class ="lost_item_name txt-yellow ml-2"></span></h5>
                     <h5 class="text-left">@lang('transport.user.date') :<span class ="created_at txt-yellow ml-2"></span></h5>
                     <h5 class="text-left">@lang('transport.user.status') :<span class ="status txt-yellow ml-2"></span></h5>
                     <h5 class="text-left">@lang('transport.user.commented_by') :<span class ="comments_by txt-yellow ml-2"></span></h5>
                     <h5 class="text-left">@lang('transport.user.comments') :<span class ="comments txt-yellow ml-2"></span></h5>
                  </div>
               </div>
               <form class="validatelostitemForm getlostItems"  style= "color:red;">
                  <!-- Dispute body -->
                  <input type ="hidden" name="dispute_type" value ="user"/>
                  <div class="comments-section field-box mt-3 col-12">
                     <textarea class="form-control lostitem" rows="4" cols="50" name ="lost_item_name" placeholder="Leave Your Comments..."></textarea>
                  </div>
                  <!-- Dispute footer -->
                  <div class="modal-footer">
                     <button type="submit"  class="btn btn-primary btn-block">@lang('transport.submit') <i class="fa fa-check" aria-hidden="true"></i></button>
                  </div>
               </form>
            </div>
         </div>
      </div>
<!-- LostItems Modal ends -->
<!-- View Modal 2 Ends -->
<section class="ride-grid content-box">
   <div class="">
      <div class="clearfix ">
         <div class="dis-center col-md-12 p-0 dis-center">
            <ul class="nav nav-tabs">
               <li class="nav-item">
                  <a class="nav-link active" data-toggle="tab" href="#my_trips">@lang('transport.user.my_trips')</a>
               </li>
               <li class="nav-item">
                  <a class="nav-link" data-toggle="tab" href="#upcoming_trips">@lang('transport.user.upcoming_trips')</a>
               </li>
            </ul>
         </div>
         <div id="toaster" class="toaster"></div>
         <!-- For Trips Datatable -->
         <div class="tab-content">
            <div id="my_trips" class="tab-pane active col-sm-12 col-md-12 col-lg-12" >
               <div class="row ride-details">
                 
                  <div class="col-md-12 col-lg-12 col-sm-12 p-0 table-responsive-sm mt-4">
                     <table  id="my_trips_grid" class="table  table-striped table-bordered w-100">
                        <thead>
                           <tr>
                               <th>&nbsp;@lang('user.s.no')</th>
                               <th>@lang('user.booking_id')</th>
                               <th>@lang('user.date')</th>
                               <th>@lang('user.profile.name')</th>
                               <th>@lang('user.amount')</th>
                               <th>@lang('user.type')</th>
                               <th>@lang('user.payment')</th>
                               <th>@lang('user.status')</th>
                               <th>@lang('user.action')</th>
                           </tr>
                        </thead>
                     </table> 
                  </div>
               </div>
            </div>
             <!-- For Upcoming Trips Datatable -->
            <div id="upcoming_trips" class="tab-pane col-sm-12 col-md-12 col-lg-12" style ="margin-left:20px;">
               <div class="row ride-details">
                  
                  <div class="col-md-12 col-lg-12 col-sm-12 p-0 table-responsive-sm mt-4">
                     <table  id="upcoming_trips_grid" class="table table-striped table-bordered w-100">
                        <thead>
                           <tr>
                              <th>&nbsp;@lang('user.s.no')</th>
                              <th>@lang('user.booking_id')</th>
                              <th>@lang('user.date')</th>
                              <th>@lang('user.amount')</th>
                              <th>@lang('user.type')</th>
                              <th>@lang('user.payment')</th>
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
<!--Header Banner Content End-->
@stop
@section('scripts') 
@parent
<script src="{{ asset('assets/plugins/data-tables/js/jquery.dataTables.min.js')}}"></script>
<script src="{{ asset('assets/plugins/data-tables/js/dataTables.bootstrap.min.js')}}"></script>
<script>
 


    var trips_table = $('#my_trips_grid');
    var upcoming_table = $('#upcoming_trips_grid');
   $(document).ready(function() {
       $( trips_table.table().container() ).removeClass( 'form-inline' );
       $( upcoming_table.table().container() ).removeClass( 'form-inline' );
       $('.dataTables_length select').addClass('custom-select');
       $('.dataTables_paginate li').addClass('page-item');
       $('.dataTables_paginate li a').addClass('page-link');
   } );

   function myFunction() {
      var x = document.getElementById("myTopnav");
      if (x.className === "topnav") {
         x.className += " responsive";
      } else {
         x.className = "topnav";
      }
   }

   $(document).ready(function(){
         $('subnav link-nav a').click(function(){
               $('link-nav a').removeClass("nav-active");
               $(this).addClass("nav-active");
         });
   });

   // Profile-Section
   $(".edit-profile").click(function() {
      $(".profile-edit").removeClass("d-none");
      $(".profile-view").addClass("d-none");
   });
   $(".view-profile").click(function() {
      $(".profile-view").removeClass("d-none");
      $(".profile-edit").addClass("d-none");
   });

   function openNav() {
     document.getElementById("mySidenav").style.width = "50%";
   }
   function closeNav() {
     document.getElementById("mySidenav").style.width = "0";
   }
   //For Dispute Details
   $.ajax({
      url:  getBaseUrl() + "/user/delivery/dispute",
      type: "GET",
      beforeSend: function (request) {
         showInlineLoader();
      },
      headers: {
      Authorization: "Bearer " + getToken("user")
         },
      success: function(data) {
         $("#dispute_name").empty().append('<option value="">Select</option>');
         $.each(data.responseData, function(key, item) {
            $("#dispute_name").append('<option value="' + item.dispute_name + '">' + item.dispute_name + '</option>');
         });
         $("#dispute_name").append('<option value="Others">Others</option>');
            
         hideInlineLoader();   
      }
   });

   //Get the comments text box
   $('#dispute_name').change(function(){
      var result = $("#dispute_name").val();
      showInlineLoader();
     
      if(result == 'Others')
      {
         $('#dispute_comments').show();
      }else{
         $('#dispute_comments').hide();
      }
      hideInlineLoader();
   });
  //For get the dispute name
   //for get dispute id
   var dispute_id = '';
   $('body').on('click', '.dispute', function(e) {
        e.preventDefault();
        $('#dispute_name,#comments').val('');
        $('#dispute_comments').hide();
        dispute_id = $(this).data('id');
        user_id = $(this).data('user_id');
        provider_id = $(this).data('provider_id');
         $.ajax({
            type: "GET",
            url: getBaseUrl() + "/user/delivery/disputestatus/"+dispute_id,
            
            headers: {
            Authorization: "Bearer " + getToken("user")
            },
            beforeSend: function (request) {
               showInlineLoader();
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
               hideInlineLoader();
            }
         });
    });
    //for get lostItems id
   var lostitem_id = '';
   $('body').on('click', '.lostItems', function(e) {
        e.preventDefault();
        lostitem_id = $(this).data('id');
        user_id = $(this).data('user_id');
        $('.lostitem').val('');
        $.ajax({
            type: "GET",
            url: getBaseUrl() + "/user/ride/lostitem/"+lostitem_id,
            
            headers: {
            Authorization: "Bearer " + getToken("user")
            },
            beforeSend: function (request) {
               showInlineLoader();
            },
            success: function(data) {
               var result = data.responseData;
               if(result !='')
               {
                  $('.getlostItems').hide();
                  $('.getlostItemstails').show();
                  $('.lost_item_name').text(result.lost_item_name)
                  $('.created_at').text(result.created_time)
                  $('.status').text(result.status) 
                  $('.comments_by').text(result.comments_by)  
                  $('.comments').text(result.comments)  
               }else{
                  $('.getlostItemstails').hide();
                  $('.getlostItems').show();
               }
               hideInlineLoader();
            }
         });
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
            var url = getBaseUrl() + "/user/delivery/dispute";
            saveRow( url, null, data, "user");
            $('#disputeModal').modal('hide');
		}
    });
    //Submit lost items details
   $('.validatelostitemForm').validate({
		errorElement: 'span', //default input error message container
		errorClass: 'help-block', // default input error message class
		focusInvalid: false, // do not focus the last invalid input
		rules: {
         lost_item_name: { required: true },
		},

		messages: {
         lost_item_name: { required: "Comments is required." },

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
            var formGroup = $(".validatelostitemForm").serialize().split("&");
            var data = new FormData();
            for(var i in formGroup) {
                var params = formGroup[i].split("=");
                data.append( params[0], decodeURIComponent(params[1]) );
            }
            data.append('id', lostitem_id );
            data.append('user_id', user_id );
            var url = getBaseUrl() + "/user/ride/lostitem";
            saveRow( url, null, data, "user");
            $('#lostItemsModal').modal('hide');
		}
    });
    

   //For Trip details
   $('body').on('click', '.tripdetails', function(){
      var id = $(this).data('id');
      $.ajax({
         type:"GET",
         url: getBaseUrl() + "/user/trips-history/delivery/"+id,
         headers: {
               Authorization: "Bearer " + getToken("user")
         },
         beforeSend: function (request) {
               showLoader();
            },
         success:function(data){
            var result = data.responseData.delivery;
            $.each(result,function(key,item){
               starvalue=``;
               if(result.provider){
                 for (i = 0; i < result.provider.rating; i++) { 
                       starvalue = starvalue + `<div class="rating-symbol" style="display: inline-block; position: relative;">
                          <div class="fa fa-star-o" style="visibility: visible;"></div>
                          <div class="rating-symbol-foreground" style="display: inline-block; position: absolute; overflow: hidden; left: 0px; right: 0px;top: 0; width: auto;"><span class="fa fa-star" aria-hidden="true"></span></div>
                       </div>
                       `;
                 }
                $('.user-img').css('background-image', 'url('+result.provider.picture+')');
               $('.provider_name').text(result.provider.last_name);
               }
               var vehicle = result.service.vehicle_name != null ?result.service.vehicle_name:'';
               $('.vehicle_name').text(vehicle); 
               $('.currency').text(result.currency); 
               $('.payment_mode').text(result.payment_mode); 
               $('.map_key_img').attr('src', "https://maps.googleapis.com/maps/api/staticmap?autoscale=1&size=420x380&maptype=terrian&format=png&visual_refresh=true&markers=icon:"+window.url+"/assets/layout/images/common/marker-start.png%7C"+result.s_latitude+","+result.s_longitude+"&markers=icon:"+window.url+"/assets/layout/images/common/marker-end.png%7C"+result.d_latitude+","+result.d_longitude+"&path=color:0x191919|weight:3|enc:" + result.route_key + "&key=" + "{{Helper::getSettings()->site->browser_key}}");
               
               var d_address = '';
               $.each(result.deliveries,function(key,value){
                  d_address += 'To : '+value.d_address+'</br>';
                  d_address += 'Name : '+value.name+'</br>';
                  d_address += 'Instruction : '+value.instruction+'</br>';
                  d_address += 'KGS : '+value.weight+'</br>';
                  var fragile = value.is_fragile == 1 ? 'Yes' : 'No';
                  d_address += 'Fragile : '+ fragile +'</br>';
                  d_address += 'Packae Type : '+(value.package_type != null ? value.package_type.package_name: '') +'</br>';
               });
               
               $('.from_address').text(result.s_address);  
               $('.to_address').html(d_address);  
               if(result.status !="CANCELLED"){

                
                $('.my_trips_cancelled').hide(); 
                $('.my_trips').show();
                $('.pickup_date').text(result.started_time.substr(0, 10));  
               $('.pickup_time').text(result.started_time.substr(11));  
               $('.drop_date').text(result.finished_time.substr(0, 10));    
               $('.drop_time').text(result.finished_time.substr(11));  
               var delivery_details = "";
               $('#delivery_trips').html('');
                $.each(result.deliveries,function(key,value){
                  payment = value.payment;
                  if(payment != null){
                     delivery_details += '<h5>'+value.d_address+'</h5>'
                   delivery_details += '<h5>Base Fare: <span>'+result.currency+''+payment.fixed+'</span></h5>';
                   // delivery_details += '<h5>Minute Fare: <span>'+result.currency+''+payment.minute+'</span></h5>';
                   delivery_details += '<h5>Distance Fare: <span>'+result.currency+''+payment.distance+'</span></h5>';
                   delivery_details += '<h5>Tax Fare: <span>'+result.currency+''+payment.tax+'</span></h5>';
                   // delivery_details += '<h5>Toll Charges: <span>'+result.currency+''+payment.toll_charge+'</span></h5>';
                   delivery_details += '<h5>Round Off: <span>'+result.currency+''+payment.round_of+'</span></h5>';
                   delivery_details += '<h5>Charged Fare: <span>'+result.currency+''+payment.total+'</span></h5>';

                   
                   }
                });
                $('#delivery_trips').html(delivery_details);
                $('.charged_fare').text(result.total_amount);
               // var paymentNode = result.payment;
               // if(paymentNode != null){
               // $('.base_fare').text(result.payment.fixed);
               // $('.minute_fare').text(result.payment.minute);
               // $('.distance_fare').text(result.payment.distance);
               // $('.tax_fare').text(result.payment.tax);
               // $('.toll_charges').text(result.payment.toll_charge);
               // $('.round_off').text(result.payment.round_of);
               // $('.charged_fare').text(result.payment.total);
               // $('.star').html(starvalue); 
               // }
               }else{
                  $('.my_trips').hide();
                  $('.my_trips_cancelled').show(); 
               }
            });
            hideLoader();

         }
      });
   });
   //For upcoming details
   $('body').on('click', '.upcomingdetails', function(){
      var id = $(this).data('id');
      $.ajax({
         type:"GET",
         url: getBaseUrl() + "/user/trips-history/delivery/"+id,
         headers: {
               Authorization: "Bearer " + getToken("user")
         },
         beforeSend: function (request) {
               showLoader();
            },
         success:function(data){
            var result = data.responseData.delivery;
            $.each(result,function(key,item){
               var vehicle = result.service.vehicle_name != null ?result.service.vehicle_name:'';
               $('.vehicle_name').text(vehicle); 
               $('.currency').text(result.currency); 
               $('.payment_mode').text(result.payment_mode); 
               $('.map_key_img').attr('src', "https://maps.googleapis.com/maps/api/staticmap?autoscale=1&size=420x380&maptype=terrian&format=png&visual_refresh=true&markers=icon:"+window.url+"/assets/layout/images/common/marker-start.png%7C"+result.s_latitude+","+result.s_longitude+"&markers=icon:"+window.url+"/assets/layout/images/common/marker-end.png%7C"+result.d_latitude+","+result.d_longitude+"&path=color:0x191919|weight:3|enc:" + result.route_key + "&key=" + "{{Helper::getSettings()->site->browser_key}}");
               if(result.provider){
                  $('.user-img').css('background-image', 'url('+result.provider.picture+')');
                  $('.provider_name').text(result.provider.last_name);
                  $('.payment').text(result.provider.payment_mode);
                  $('.email').text(result.provider.email);
                  $('.status').text(result.provider.status);
               }
               $('.from_address').text(result.s_address);  
               var d_address = '';
               $.each(result.deliveries,function(key,value){
                  d_address += value.d_address+'</br>';
               });
               $('.to_address').html(d_address);  
               $('.schedule_date').text(result.schedule_time);  
               hideLoader(); 
               
            });
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
            "url": getBaseUrl() + "/user/trips-history/delivery",
            "type": "GET",
            "beforeSend": function (request) {
               showLoader();
            },
            "headers": {
                "Authorization": "Bearer " + getToken("user")
            },data: function(data){
                
                var info = $('#my_trips_grid').DataTable().page.info();
                delete data.columns;
                data.page = info.page + 1;
                data.search_text = data.search['value'];
             },
            dataFilter: function(data){               
               var json = parseData( data );
               json.recordsTotal = json.responseData.total;
               json.recordsFiltered  = json.responseData.delivery.total;
               json.data = json.responseData.delivery.data;
               hideLoader();
               return JSON.stringify( json ); // return JSON string
            }
        },
        "columns": [
         { "data": "id" ,render: function (data, type, row, meta) {
               return meta.row + meta.settings._iDisplayStart + 1;
              },
            },
            { "data": "booking_id" },
            { "data": "created_time" },
            { "data": "provider_id" ,render: function (data, type, row) {
               return row.provider!= null ?row.provider.first_name+' '+row.provider.last_name:'NA';
            }
            },
            { "data": "provider_id" ,render: function (data, type, row) {
               var paymentmode = true;
              $.each(row.deliveries,function(key,value){
                  if(value.payment == null)
                  {
                     paymentmode = false;
                  }
               });
               return paymentmode == true ? row.user.currency_symbol+' '+row.total_amount:'NA';
               }
            },
            { "data": "ride_delivery_id" ,render: function (data, type, row) {
               return row.service.vehicle_name;
            }
            },
            { "data": "provider_id" ,render: function (data, type, row) {
               return row.payment_mode!= null ? row.payment_mode:'NA';;
               }
            },
            { "data": "status" },
            { "width": "124px","data": "id", render: function (data, type, row) {
               var html = ``;

               if(row.user_rated == 0 && row.status == 'COMPLETED') {
                  html += `<a href="{{ url('/delivery') }}/`+row.payment+`/delivery?id=`+row.id+`"><i class="fa fa-eye view-icon tripdetails" data-id = `+data+` data-toggle="tooltip" title="View"></i></a>`;
               } else {
                  html += `<i class="fa fa-eye view-icon tripdetails" data-toggle="modal" data-target="#modal1" data-id = `+data+` data-toggle="tooltip" title="View"></i>`;
               }
               html += ` <i class="fa fa-commenting-o view-icon dispute mt-1"  data-toggle="modal" data-target="#disputeModal" data-id = `+data+` data-user_id = `+row.user_id+` data-provider_id = `+row.provider_id+` data-toggle="tooltip" title="Create Dispute"> </i>`; 
               // if( row.status != 'CANCELLED') {
               // html +=`<i class="fa fa-sitemap view-icon lostItems mt-1"  data-toggle="modal" data-target="#lostItemsModal" data-id = `+data+` data-user_id = `+row.user_id+` data-toggle="tooltip" title="Lost Item"></i>`; 
               // }
               return html;

            }
            },
        ],
        bInfo:true,
        "language": {                
            "infoFiltered": ""
        },
         "drawCallback": function () {
            $('.dataTables_length select').addClass('custom-select');
            $('.dataTables_paginate li').addClass('page-item');
            $('.dataTables_paginate li a').addClass('page-link');
            var info = $('#my_trips_grid').DataTable().page.info();
            if (info.pages<=1) {
               $('#my_trips_grid_paginate').hide();
               $('#my_trips_grid .dataTables_paginate').hide();
               $('#my_trips_grid .dataTables_info').hide();
            }else{
               $('.dataTables_paginate').show();
               $('.dataTables_info').show();
           }
        }
    });
   //  setTimeout(function(){
        
   //    $('.subnav').show(); 
   //    $('.subnav menu-one').addClass('menu-active');
   //    $('.content-box').addClass('content-box-2');
     
   //  }, 1000);
    

    //Set the datatable for my upcoming trip details
    upcoming_table = upcoming_table.DataTable( {
        "processing": true,
        "serverSide": true,
        "ordering": false,
        "lengthChange": false,
        "ajax": {
            "url": getBaseUrl() + "/user/trips-history/delivery?type=upcoming",
            "type": "GET",
            "headers": {
                "Authorization": "Bearer " + getToken("user")
            },data: function(data){
                
                var info = $('#upcoming_trips_grid').DataTable().page.info();
                delete data.columns;

                data.page = info.page + 1;
                data.search_text = data.search['value'];
                
            },
            dataFilter: function(data){               
               var json = parseData( data );
               json.recordsTotal = json.responseData.delivery.total;
               json.recordsFiltered = json.responseData.delivery.total;
               json.data = json.responseData.delivery.data;
               return JSON.stringify( json ); // return JSON string
            }
        },
        "columns": [
         { "data": "id" ,render: function (data, type, row, meta) {
               return meta.row + meta.settings._iDisplayStart + 1;
              }
            },
            { "data": "booking_id" },
            { "data": "schedule_time"},
            { "data": "provider_id" ,render: function (data, type, row) {
               return row.payment!= null ?row.payment.total:'0.00';
            }
            },
            { "data": "ride_delivery_id" ,render: function (data, type, row) {
               return row.service.vehicle_name;
            }
            },
            { "data": "ride_delivery_id" ,render: function (data, type, row) {
               var paymentmode = true;
              $.each(row.deliveries,function(key,value){
                  if(value.payment == null)
                  {
                     paymentmode = false;
                  }
               });
               return paymentmode == true ? row.user.currency_symbol+' '+row.total_amount:'NA';
            }
            },
            { "data": "id", render: function (data, type, row) {
                return `<span class="view-icon upcomingdetails " data-toggle="modal" data-target="#modal2" data-id = `+data+` data-toggle="tooltip" title="View"><i class="fa fa-eye" data-toggle="tooltip" title="View"></i></span>`;
            }}
        ],
        bInfo:true,
        "language": {                
            "infoFiltered": ""
        },
        "drawCallback": function () {
            $('.dataTables_length select').addClass('custom-select');
            $('.dataTables_paginate li').addClass('page-item');
            $('.dataTables_paginate li a').addClass('page-link');
            var info = $('#upcoming_trips_grid').DataTable().page.info();
            if (info.pages<=1) {
               $('#upcoming_trips_grid_paginate').hide();
               $('#upcoming_trips_grid .dataTables_paginate').hide();
               $('#upcoming_trips_grid .dataTables_info').hide();
            }else{
                 $('#upcoming_trips_grid .dataTables_paginate').show();
                 $('#upcoming_trips_grid .dataTables_info').show();
             }
        }

        
    });
</script>
@stop

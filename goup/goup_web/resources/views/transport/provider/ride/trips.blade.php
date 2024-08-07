@extends('common.provider.layout.base')
{{ App::setLocale(   isset($_COOKIE['provider_language']) ? $_COOKIE['provider_language'] : 'en'  ) }}
@section('styles')
@parent
   <link rel='stylesheet' type='text/css' href="{{ asset('assets/plugins/data-tables/css/dataTables.bootstrap.min.css')}}"/>
@stop
@section('content')
      <section class="taxi-banner z-1 content-box" id="booking-form">
      <div id="toaster" class="toaster"></div>
         <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-2">
               @include('common.provider.includes.history-nav')
            </div>
            <div class="col-xs-12 col-sm-12 col-md-10 wrapper">
               <div class="col-md-12 col-lg-12 col-sm-12 p-0 table-responsive-sm transport-history">
                  <table id="transport_grid" class="table  table-striped table-bordered w-100">
                     <thead>
                        <tr>
                           <th>@lang('provider.s.no')</th>
                           <th>@lang('provider.booking_id')</th>
                           <th>@lang('provider.date')</th>
                           <th>@lang('provider.pickup_location')</th>
                           <th>@lang('provider.drop_location')</th>
                           <th>@lang('provider.amount')</th>
                           <th>@lang('provider.status')</th>
                           <th>@lang('provider.action')</th>
                        </tr>
                     </thead>
                     <tbody>
                     </tbody>
                  </table>
               </div>
            </div>
            <!-- View Modal 1 Starts -->
            <div class="modal " id="transport_modal">
            <div class="modal-dialog min-70vw">
                  <div class="modal-content">
                     <!-- Schedule Header -->
                     <div class="modal-header">
                        <h4 class="modal-title m-0">@lang('transport.user.ride_details')</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                     </div>
                     <!-- Schedule body -->
                     <div class="modal-body ">
                      <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-12">
                           <div class="my-trip-left">
                              <h4 class="text-center">
                                 <strong>
                                 <span class ="vehicle_name"></span>
                                 - @lang('transport.user.fire_breakdown')</strong>
                              </h4>
                              <div class="from-to row m-0">
                                 <div class="from">
                                 <h5>@lang('transport.user.from')          : <span class ="from_address"></span></h5>
                                 <h5>@lang('transport.user.to')            : <span class ="to_address"></span></h5>
                                 <h5>@lang('transport.user.pickup_date')  : <span class ="pickup_date"></span></h5>
                                 <h5>@lang('transport.user.pickup_time')  : <span class ="pickup_time"></span></h5>
                                 <h5>@lang('transport.user.drop_date')    : <span class ="drop_date"></span></h5>
                                 <h5>@lang('transport.user.drop_time')     : <span class ="drop_time"></span></h5>
                                 <h5>@lang('transport.user.payment')       : <span class ="payment_mode"></span></h5>
                                 </div>
                              </div>
                           </div>
                           <div class="mytrip-right">
                              <div class="fare-break">
                                 <h5>@lang('user.booking_id')<span>
                                    <span class ="booking_id"></span>
                                    </span>
                                 </h5>
                                 <h5>@lang('user.total_distance')<span>
                                    <span class ="total_distance"></span>
                                    </span>
                                 </h5>
                                 <h5 class="big"><strong>@lang('user.charged') - <strong class ="payment_mode"></strong> </strong><span><strong>
                                    <span class ="charged_fare"></span> <span class ="currency"></span> 
                                    </strong></span>
                                 </h5>
                              </div>
                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="map-static">
                              <img class = "map_key_img img-fluid" />
                           </div>
                           <div class="trip-user">
                              <!-- For image listing -->
                              <div class="user-img"> </div>
                              <div class="user-right">
                                 <h5><span class ="customer_name"></h5>
                                 <div class="rating-outer">
                                 <span class ="star" style="cursor: default;">
                                 </span>
                                 </div>
                                 <p></p>
                              </div>
                              <div class="user-right">
                                 <h5><span class ="customer_commont"></h5>
                                 <div class="rating-outer">
                                 <span class ="provider_comment" style="cursor: default;">
                                 </span>
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
                        <h5 class="text-left">@lang('transport.admin.dispute.dispute_name'):  <span class ="dispute_name txt-yellow ml-2"></span></h5>
                        <h5 class="text-left">@lang('transport.user.date') :<span class ="created_at txt-yellow ml-2"></span></h5>
                        <h5 class="text-left">@lang('transport.user.status') :<span class ="status txt-yellow ml-2"></span></h5>
                        <h5 class="text-left">@lang('transport.user.commented_by'):<span class ="comments_by txt-yellow ml-2"></span></h5>
                        <h5 class="text-left">@lang('transport.user.comments') :<span class ="comments txt-yellow ml-2"></span></h5>
                     </div>
                     
               </div>
               <!-- Dispute body -->
               <form class="validateForm getdispute"  style= "color:red;">
                  <input type ="hidden" name="dispute_type" value ="provider"/>
                  <div class="col-md-12 col-sm-12">
                     <h5 class=" no-padding"><strong>@lang('transport.admin.dispute.dispute_name')</strong></h5>
                     <select name="dispute_name" id="dispute_name" class="form-control" autocomplete="off">
                        <option value="">@lang('transport.user.select')</option>
                     </select>
                  </div>
                  <div class="comments-section field-box mt-3 col-12" id ="dispute_comments">
                     <h5 class=" no-padding"><strong>@lang('transport.admin.dispute.dispute_comments')</strong></h5>
                     <textarea class="form-control" rows="4" cols="50"  name ="comments" placeholder="Dispute Comments..."></textarea>
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
      </div>
      </section>
@stop
@section('scripts')
@parent
   <script src="{{ asset('assets/plugins/data-tables/js/jquery.dataTables.min.js')}}"></script>
   <script src="{{ asset('assets/plugins/data-tables/js/dataTables.bootstrap.min.js')}}"></script>  
   <script>
       var trips_table =$('#transport_grid');
      // Header-Section
      function openNav() {
         document.getElementById("mySidenav").style.width = "50%";
      }
      
      function closeNav() {
         document.getElementById("mySidenav").style.width = "0";
      }
      $(document).ready(function() {
         $('#transport_grid').DataTable();
         
      });
      
      $('#TRANSPORT').attr('checked',true);
      $(document).ready(function(){
         $('input:checkbox').click(function() {
            $('input:checkbox').not(this).prop('checked', false);
         });
      });
      
      $('#TRANSPORT').change(function(){
         if($(this).is(":checked")) {
            window.location.replace('/goup_web/public/provider/trips/transport');
         } 
      });
      
      $('#ORDER').change(function(){
         if($(this).is(":checked")) {
            window.location.replace('/goup_web/public/provider/trips/order');  
         } 
      });

       $('#DELIVERY').change(function(){
         if($(this).is(":checked")) {
            window.location.replace('/goup_web/public/provider/trips/delivery');
         } 
      });
      
      $('#SERVICE').change(function(){
         if($(this).is(":checked")) {
            window.location.replace('/goup_web/public/provider/trips/service');
         } 
      });
   //For Dispute Details
   $.ajax({
      url:  getBaseUrl() + "/provider/ride/dispute",
      type: "GET",
      beforeSend: function (request) {
         showLoader();
      },
      headers: {
      Authorization: "Bearer " + getToken("provider")
         },
      success: function(data) {
         $("#dispute_name").empty()
            .append('<option value="">Select</option>');
         $.each(data.responseData, function(key, item) {
            $("#dispute_name").append('<option value="' + item.dispute_name + '">' + item.dispute_name + '</option>');
         });
         hideLoader();
      }
   });
      //Get the comments text box
   $('#dispute_name').change(function(){
      var result = $("#dispute_name").val();
      if(result == 'others')
      {
         $('#dispute_comments').show();
      }else{
         $('#dispute_comments').hide();
      }
   });
  //For get the dispute name
   //for get dispute id
   var dispute_id = '';
   $('body').on('click', '.dispute', function(e) {
        e.preventDefault();
        $('#dispute_name').val('');
        $('#dispute_comments').hide();
        dispute_id = $(this).data('id');
        user_id = $(this).data('user_id');
        provider_id = $(this).data('provider_id');
         $.ajax({
            type: "GET",
            url: getBaseUrl() + "/provider/ride/disputestatus/"+dispute_id,
            
            headers: {
            Authorization: "Bearer " + getToken("provider")
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
                 $('.comments_by').text(result.dispute_type)  
                 $('.comments').text(result.comments)   
               }else{
                  $('.getdisputedetails').hide();
                  $('.getdispute').show();
               }
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
            var url = getBaseUrl() + "/provider/history-dispute/transport";
            saveRow( url, null, data, "provider");
            $('#disputeModal').modal('hide');
		}
    });
       //Set the datatable for my trip details
      trips_table = trips_table.DataTable( {
        "processing": true,
        "serverSide": true,
        "ordering": false,
        "lengthChange": false,
        "ajax": {
            "url": getBaseUrl() + "/provider/history/transport",
            "type": "GET",
            "beforeSend": function (request) {
               showLoader();
            },
            "headers": {
                "Authorization": "Bearer " + getToken("provider")
            },
            data: function(data){
                
                var info = $('#transport_grid').DataTable().page.info();
                delete data.columns;
                data.page = info.page + 1;
                data.search_text = data.search['value'];
                
            },
            dataFilter: function(data){               
               var json = parseData( data );
               json.recordsTotal = json.responseData.transport.total;
               json.recordsFiltered = json.responseData.transport.total;
               json.data = json.responseData.transport.data;
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
         { "data": "assigned_time"},
         /* ,render: function (data, type, row) {
               return new Date( data ).toLocaleDateString("en-Us") + ' ' + new Date(data).toLocaleTimeString([], { hour: "2-digit", minute: "2-digit" });
            }
         },*/
         { "data": "s_address" },
         { "data": "d_address" },
         { "data": "provider_id" ,render: function (data, type, row) {
               return row.payment != null ? row.user.currency_symbol+row.payment.total:'NA';
            }
         },
         { "data": "status" },
         { "data": "id", render: function (data, type, row) {
               return `<span class="view-icon providertripdetails" data-toggle="modal" data-target="#transport_modal" data-id = `+data+` data-toggle="tooltip" title="View"> <i class="fa fa-eye"></i></span><span class="view-icon dispute mt-1" data-toggle="modal" data-target="#disputeModal" data-id = `+data+` data-user_id = `+row.user_id+` data-provider_id = `+row.provider_id+` data-toggle="tooltip" title="Create Dispute"><i class="fa fa-commenting-o" data-toggle="tooltip" title="Create Dispute"></i></span>`;
         }}
        ],
        "drawCallback": function () {
            $('.pagination').css('margin-left','440px');
            $('.dataTables_paginate li').addClass('page-item');
            $('.dataTables_paginate li a').addClass('page-link');
            var info = $(this).DataTable().page.info();
            if (info.pages<=1) {
               $('.dataTables_paginate').hide();
               $('.dataTables_info').hide();
            }else{
                $('.dataTables_paginate').show();
                $('.dataTables_info').show();
            }
        }
    });
    //For Trip details
   $('body').on('click', '.providertripdetails', function(){
      var id = $(this).data('id');
      $.ajax({
         type:"GET",
         url: getBaseUrl() + "/provider/history/transport/"+id,
         headers: {
               Authorization: "Bearer " + getToken("provider")
         },
         success:function(data){
            var result = data.responseData.transport;
            
            
               
               var vehicle = result.ride.vehicle_name != null ?result.ride.vehicle_name:'';
               $('.vehicle_name').text(vehicle); 
               $('.currency').text(result.currency); 
               $('.payment_mode').text(result.payment_mode);
               var starvalue =``;
              if(result.rating !== null && result.rating.provider_rating!==0)
              {
                var userrate = Math.round(result.rating.provider_rating);
              }
              else
              {
                var userrate = Math.round(result.user.rating);
              }
              for (i = 0; i < userrate; i++) {
                     starvalue = starvalue + `<div class="rating-symbol" style="display: inline-block; position: relative;">
                        <div class="fa fa-star-o" style="visibility: visible;"></div>
                        <div class="rating-symbol-foreground" style="display: inline-block; position: absolute; overflow: hidden; left: 0px; right: 0px;top: 0; width: auto;"><span class="fa fa-star" aria-hidden="true"></span></div>
                     </div>
                     `;
               }
              if(result.rating !==null  && result.rating.provider_comment !==null)
              {
                  $('.customer_commont').text("Comment");
                  $('.provider_comment').text(result.rating.provider_comment);
              }
               $('.star').html(starvalue); 
               
               $('.map_key_img').attr('src', "https://maps.googleapis.com/maps/api/staticmap?autoscale=1&size=420x380&maptype=terrian&format=png&visual_refresh=true&markers=icon:"+window.url+"/assets/layout/images/common/marker-start.png%7C"+result.s_latitude+","+result.s_longitude+"&markers=icon:"+window.url+"/assets/layout/images/common/marker-end.png%7C"+result.d_latitude+","+result.d_longitude+"&path=color:0x191919|weight:3|enc:" + result.route_key + "&key=" + "{{Helper::getSettings()->site->browser_key}}");
               $('.user-img').css('background-image', 'url('+result.user.picture+')');
               $('.customer_name').text(result.user.last_name);
               $('.booking_id').text(result.booking_id); 
               $('.total_distance').text(result.total_distance+" "+result.unit);
               $('.from_address').text(result.s_address); 
               $('.to_address').text(result.d_address); 
              
               $('.pickup_date').text(result.started_time.substr(0, 10));  
               $('.pickup_time').text(result.started_time.substr(11));  
               $('.drop_date').text(result.finished_time.substr(0, 10));    
               $('.drop_time').text(result.finished_time.substr(11));    
                  var paytotal = result.payment != null ?result.payment.total:'NA';
                  if(result.payment)
                  $('.currency').text(result.user.currency_symbol);
                  else
                  $('.currency').text(" ");
               $('.charged_fare').text(paytotal);
            
         }
      });
   }); 
   </script>
@stop
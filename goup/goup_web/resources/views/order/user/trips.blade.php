@extends('common.user.layout.base')
{{ App::setLocale(  isset($_COOKIE['user_language']) ? $_COOKIE['user_language'] : 'en'  ) }}
@section('styles')
@parent
<link rel='stylesheet' type='text/css' href="{{ asset('assets/plugins/data-tables/css/dataTables.bootstrap.min.css')}}"/>
<link rel='stylesheet' type='text/css' href="{{ asset('assets/layout/css/service-bootstrap.css')}}"/>
<link rel='stylesheet' type='text/css' href="{{ asset('assets/layout/css/service-bootstrap.css')}}"/>
@stop
@section('content')   
      <!-- View Modal for trip start -->
      
      <!-- View Modal for trip Ends -->
      <!-- View Modal for upcoming details-->
      
      <!-- View Modal for Upcoming Ends -->
      <!-- Dispute Modal -->
      <div class="modal" id="disputeModal">
         <div class="modal-dialog">
            <div class="modal-content">
               <!-- Dispute Header -->
               <input type="hidden" name="id" value="id">
               <div class="modal-header">
                  <h4 class="modal-title">@lang('store.user.dispute_details')</h4>
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
               </div>
               <div class="from-to row m-0 getdisputedetails">
                     <div class="from">
                        <h5 class="text-left">@lang('store.user.dispute_name') :  <span class ="dispute_name txt-blue ml-2"></span></h5>
                        <h5 class="text-left">@lang('store.user.date') :<span class ="created_at txt-blue ml-2"></span></h5>
                        <h5 class="text-left">@lang('store.user.status') :<span class ="status txt-blue ml-2"></span></h5>
                        <h5 class="text-left">@lang('store.user.commented_by') :<span class ="comments_by txt-blue ml-2"></span></h5>
                        <h5 class="text-left">@lang('store.user.comments') :<span class ="comments txt-blue ml-2"></span></h5>
                     </div>
                     
               </div>
               <!-- Dispute body -->
               <form class="validateForm getdispute"  style="color:red;">
                  <input type ="hidden" name="dispute_type" value ="user"/>
                  <div class="col-md-12 col-sm-12">
                     <h5 class=" no-padding"><strong>@lang('store.user.dispute_name')</strong></h5>
                     <select name="dispute_name" id="dispute_name" class="form-control" autocomplete="off">
                        <option value="">@lang('store.user.select')</option>
                     </select>
                  </div>
                  <div class="comments-section field-box mt-3 col-12" id="dispute_comments">
                     <textarea class="form-control" rows="4" cols="50" id="comments" name ="comments"  placeholder="Leave Your Comments..."></textarea>
                  </div>
                  <div class="modal-footer">
                     <!-- <a  class="btn btn-primary btn-block" data-toggle="modal" data-target="#disputeModal" >Submit <i class="fa fa-check" aria-hidden="true"></i></a> -->
                     <button type="submit"  class="btn btn-primary btn-block">@lang('store.submit') <i class="fa fa-check" aria-hidden="true"></i></button>

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
                        <a  class="dis-column" href="{{ url('transport/trips') }}">
                           <div class="dis-center"><i class="material-icons">local_taxi</i></div>
                           <span class ="transport-detail">{{ __('TRANSPORT') }}</span>
                        </a>
                     </div>
                  @elseif($service =='ORDER')
                     <a  class="dis-column" href="{{ url('user/order/trips') }}">
                        <div class="dis-center"><i class="material-icons">fastfood</i></div>
                        <span class ="order-detail">{{ __('ORDER') }}</span>
                     </a>
                  @elseif($service =='DELIVERY')
                     <a  class="dis-column" href="{{ url('delivery/trips') }}">
                        <div class="dis-center"><i class="material-icons">fastfood</i></div>
                        <span class ="order-detail">{{ __('DELIVERY') }}</span>
                     </a>
                  @else
                     <a  class="dis-column" href="{{ url('user/services/trips') }}">
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
                        <a class="nav-link active" data-toggle="tab" href="#my_trips">@lang('store.user.my_order')</a>
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
                                    <th>@lang('user.shop')</th>
                                    <th>@lang('user.date')</th>
                                    <th>@lang('user.provider_name')</th>
                                    <th>@lang('user.amount')</th>
                                    <th>@lang('user.payment')</th>
                                    <th>@lang('user.status')</th>
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
 <!-- View Modal 1 Starts -->
            <div class="modal" id="service_modal">
            <div class="modal-dialog min-70vw">
                  <div class="modal-content">
                     <!-- Schedule Header -->
                     <div class="modal-header">
                        <h4 class="modal-title m-0">@lang('store.user.order_details')</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                     </div>
                     <!-- Schedule body -->
                     <div class="modal-body ">
                        <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-12">
                           <div class="my-trip-left">
                              <h4 class="text-center">
                              <strong class="food_service"></strong>
                              </h4>
                              <div class="from-to row m-0">
                                 <div class="from">
                                    <h5>@lang('store.user.order_location') : <span class ="orderLocation"></span></h5>
                                    <h5>@lang('store.user.order_items')   : <span class ="orderItems"></span></h5>
                                    <h5>@lang('store.user.order_date')  : <span class="orderDate"></span></h5>
                                 </div>
                              </div>
                           </div>
                           <div class="mytrip-right my_trips">
                              <ul class="invoice">
                                 <li>
                                    <span class="fare">@lang('store.user.cart_subtotal')</span>
                                    <span class="pricing"><span class ="cartSubtotal"></span></span>
                                 </li>
                                 <li>
                                    <span class="others d-none fare" >@lang('store.user.shipping_handling')</span>
                                    <span class="food d-none fare">@lang('store.user.delivery_charge')</span>
                                    <span class="pricing"> <span class ="shippingHandling"></span></span>
                                 </li>
                                 <li>
                                    <span class="fare">@lang('store.user.wallet_detection')</span>
                                    <span class="pricing"> <span class ="walletDetection"></span></span>
                                 </li>
                                 <li>
                                    <span class="fare">@lang('store.user.promocode_discount')</span>
                                    <span class="pricing"><span class ="promocodeDiscount"></span></span>
                                 </li>
                                 <li>
                                    <span class="fare">@lang('store.user.tax_amount')</span>
                                    <span class="pricing"><span class ="taxamount"></span></span>
                                 </li>
                                 <!-- <li>
                                    <span class="fare">@lang('store.user.basefare_commision')</span>
                                    <span class="pricing"><span class ="basefare"></span></span>
                                 </li> -->
                                 <li>
                                    <span class="fare">@lang('store.user.shop_discount')</span>
                                    <span class="pricing"><span class ="discount"></span></span>
                                 </li>
                                 <li>
                                    <span class="fare">@lang('store.user.packing_charges')</span>
                                    <span class="pricing"><span class ="packing_charges"></span></span>
                                 </li>
                                 <li>
                                 <div class="widget-body green">
                                 <div class="price-wrap text-center">
                                    <p class="txt-white">@lang('store.user.grand_total')</p>
                                    <h3 class="value txt-white"><strong class="totalAmount"> 25,49</strong></h3>
                                 </div>
                              </div>
                                    <!-- <hr>
                                    <span class="fare" >Total</span>
                                    <span class="txt-blue pull-right"> <span class ="totalAmount"></span></span>
                                    <hr> -->
                                 </li>
                              </ul>
                           </div>
                           <div class="mytrip-right txt-white b-0 bg-red my_trips_cancelled">
                              <strong>@lang('store.user.cancelled')</strong>
                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="map-static b-none" id="my_map" style="height:500px;">
                           </div>
                           <div class="trip-user">
                              <!-- For image listing -->
                              <h4 class="modal-title m-0">@lang('store.user.user_details')</h4><hr />
                              <div class="user-img"> </div>
                              <div class="user-right">
                                 <h5><span class ="customer_name"></h5>
                                 <div class="rating-outer"><span><div id="user_rating"></div><span> </div>                               

                              </div>
                           </div>
                        </div>
                     </div>
                     </div>
                  </div>
               </div>
            </div>
            <!-- Dispute Modal -->
     
<!-- Dispute Modal ends -->


@stop
@section('scripts')
@parent
<script src="{{ asset('assets/plugins/data-tables/js/jquery.dataTables.min.js')}}"></script>
<script src="{{ asset('assets/plugins/data-tables/js/dataTables.bootstrap.min.js')}}"></script>
   <script>
      var currency = getUserDetails().currency_symbol;
      var trips_table = $('#my_services');
      $(document).ready(function() {
       $( trips_table.table().container() ).removeClass( 'form-inline' );
       $('.dataTables_length select').addClass('custom-select');
       $('.dataTables_paginate li').addClass('page-item');
       $('.dataTables_paginate li a').addClass('page-link');
   });

   $('#dispute_name').change(function(){
      var result = $("#dispute_name").val();
     showInlineLoader();
      if(result == 'others')
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
   var store_id='';
   $('body').on('click', '.dispute', function(e) {
        e.preventDefault();
        $('#dispute_name,#comments').val('');
        $('#dispute_comments').hide();
        dispute_id = $(this).data('id');
        user_id = $(this).data('user_id');
        provider_id = $(this).data('provider_id');
        store_id=$(this).data('store_id');
         $.ajax({
            type: "GET",
            url: getBaseUrl() + "/user/order/disputestatus/"+dispute_id,
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
   $.ajax({
      url:  getBaseUrl() + "/user/order/dispute",
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
         $("#dispute_name").append('<option value="others">Others</option>');
         hideLoader();

      }
   });

      //  setTimeout(function(){
        
      //   $('.subnav').show(); 
      //   $('.subnav > .menu-two').addClass('menu-active');
      //   $('.content-box').addClass('content-box-2');
       
      // }, 1000);
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
            data.append('store_id', store_id );
            var url = getBaseUrl() + "/user/order/dispute";
            saveRow( url, null, data, "user");
            $('#disputeModal').modal('hide');
		}
    });
   //For Trip details
   $('body').on('click', '.upcomingdetails', function(){
      var id = $(this).data('id');
      $('#service_modal').modal('show');
      $.ajax({
         type:"GET",
         url: getBaseUrl() + "/user/trips-history/order/"+id,
         beforeSend: function (request) {
               showLoader();
            },
         headers: {
               Authorization: "Bearer " + getToken("user")
         },
         success:function(data){
            var result = data.responseData.order;
            if(result.delivery) {
               var customerAddress = result.delivery.flat_no + ',' +result.delivery.map_address;
               $('.orderLocation').text(customerAddress);
            }
            
            ongoingInitialize(result);
               var items = result.order_invoice.items;
               var food ='';
               for(var j=0;j<items.length;j++){
                   food = food + items[j].product.item_name + ' - ' + items[j].item_quantity + ' ' + items[j].unit   + '<br />';
               }
               $('.orderItems').html(food); 
               $('.orderDate').text(result.created_time); 
               if(result.store.storetype.category == 'FOOD') {
                  $('.food_service').text("@lang('store.user.food_service')");
               } else {
                  $('.food_service').text("@lang('store.user.shop_service')");
               }
              /* $('.map_key_img').attr('src', "https://maps.googleapis.com/maps/api/staticmap?autoscale=1&size=420x380&maptype=terrian&format=png&visual_refresh=true&markers=icon:"+window.url+"/assets/layout/images/common/marker-start.png%7C"+result.s_latitude+","+result.s_longitude+"&markers=icon:"+window.url+"/assets/layout/images/common/marker-end.png%7C"+result.d_latitude+","+result.d_longitude+"&path=color:0x191919|weight:3|enc:" + result.route_key + "&key=" + "{{Helper::getSettings()->site->browser_key}}")*/
               if(result.user.picture){
                  $('.user-img').css('background-image', 'url('+result.user.picture+')');
               }
               var username = result.user.first_name + ' ' +result.user.last_name;
               $('.customer_name').text(username);
               $('.booking_id').text(result.store_order_invoice_id);
               
               // $('.orderDate').text(new Date( result.schedule_time ).toLocaleDateString("en-Us") );  
               // $('.orderTime').text(new Date( result.started_time).toLocaleTimeString([], { hour: "2-digit", minute: "2-digit" }));  
               if(result.store.storetype.category=='FOOD'){
                  $('.food').removeClass('d-none');
                  $('.others').addClass('d-none');
               }else{
                  $('.food').addClass('d-none');
                  $('.others').removeClass('d-none');
               }
               
               if(result.status !="CANCELLED"){
                 
               $('.my_trips_cancelled').hide(); 
               $('.my_trips').show();
               $('.cartSubtotal').text(result.user.currency_symbol+result.order_invoice.item_price);
               $('.totalAmount').text(result.user.currency_symbol+result.order_invoice.total_amount);
               $('.shippingHandling').text(result.user.currency_symbol+result.order_invoice.delivery_amount);
               $('.walletDetection').text(result.user.currency_symbol+result.order_invoice.wallet_amount);
               $('.promocodeDiscount').text(result.user.currency_symbol+result.order_invoice.promocode_amount);
               $('.taxamount').text(result.user.currency_symbol+result.order_invoice.tax_amount);
               //$('.basefare').text(result.user.currency_symbol+result.order_invoice.commision_amount);
               $('.discount').text(result.user.currency_symbol+result.order_invoice.discount);
               $('.packing_charges').text(result.user.currency_symbol+result.order_invoice.store_package_amount);
               }else{
                  $('.my_trips').hide();
                  $('.my_trips_cancelled').show(); 
               } 

               if(result.rating !== null && result.rating.user_rating !==0)
               {
                  if(result.order_type == 'TAKEAWAY')
                     var userrate = Math.round(result.rating.store_rating);
                  else
                     var userrate = Math.round(result.rating.user_rating);     
               }
               else
               {
                 var userrate = Math.round(result.user.rating);
               }
               var str ='';
               for(var i=0;i<userrate;i++){
                 var str = str + "<div class='rating-symbol' style='display:inline-block;position:relative;'><div class='fa fa-star-o' style='visibility:hidden'></div><div class='rating-symbol-foreground' style='display:inline-block;position:absolute;overflow:hidden;left:0px;right:0px;top:0px;width:auto'><span class='fa fa-star' aria-hidden='true'></span></div></div>";
               }
               $("#user_rating").html(str);
               hideLoader();
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
            "url": getBaseUrl() + "/user/trips-history/order",
            "type": "GET",
            "beforeSend": function (request) {
               // showLoader();
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
               json.recordsTotal = json.responseData.order.total;
               json.recordsFiltered = json.responseData.order.total;
               json.data = json.responseData.order.data;
               hideLoader();
               return JSON.stringify( json ); // return JSON string
            }
        },
        "columns": [
         { "data": "id" ,render: function (data, type, row, meta) {
               return meta.row + meta.settings._iDisplayStart + 1;
              }
            },
            { "data": "store_order_invoice_id" },
            { "data": "shop" ,render: function (data, type, row) {
               return row.invoice!= null ? row.invoice.items[0].store.store_name :'N/A';
            }},
            { "data": "created_time"},
            /* ,render: function (data, type, row) {
               return new Date( data ).toLocaleDateString("en-Us") + ' ' + new Date(data).toLocaleTimeString([], { hour: "2-digit", minute: "2-digit" });
            }
            },*/
            { "data": "provider_id" ,render: function (data, type, row) {
               return row.provider!= null ? row.provider.first_name + ' ' + row.provider.last_name:'N/A';
            }
            },
            { "data": "id" ,render: function (data, type, row) {
               
               return row.invoice != null ? row.user.currency_symbol +''+row.invoice.total_amount:0;
               }
            },
            { "data": "id" ,render: function (data, type, row) {
              
               return row.invoice != null ?row.invoice.payment_mode:0;
              }
            },
            { "data": "status" ,render: function (data, type, row) {

               if(row.cancelled_by != "NONE"){
                  var cancelled_by = row.cancelled_by;
               }else{
                  var cancelled_by = "ADMIN";
               }
              
               return row.status == 'CANCELLED' ? row.status +" By " +cancelled_by + (row.reason != null ? " - " + row.reason.reason : " - " +row.cancel_reason) : row.status;
              }
            },
            { "width": "124px","data": "id", render: function (data, type, row) {

               var html = ``;

               if(row.user_rated == 0 && row.status == 'COMPLETED') {
                  html += `<a href="{{ url('/store/order')}}/`+row.id+`"><span class="view-icon upcomingdetails" data-toggle="modal" data-target="#service_modal" data-id = `+data+` data-toggle="tooltip" title="View"> <i class="fa fa-eye"></i></span></a>`;
               } else {
                  html += `<span class="view-icon upcomingdetails" data-toggle="modal" data-target="#modal1" data-id = `+data+` data-toggle="tooltip" title="View"> <i class="fa fa-eye"></i></span>`;
               }
               html += ` <span class="view-icon dispute m-2" data-toggle="modal" data-target="#disputeModal" data-id = `+data+` data-user_id = `+row.user_id+` data-store_id=`+row.store_id+` data-provider_id = `+row.provider_id+` data-toggle="tooltip" title="Create Dispute"><i class="fa fa-commenting-o" data-toggle="tooltip" title="Create Dispute"></i></span>`; 
               return html;

            }}
        ],
        "drawCallback": function () {
            $('.dataTables_length select').addClass('custom-select');
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

      //Set the datatable for my upcoming trip details
     
      
         function openNav() {
            document.getElementById("mySidenav").style.width = "100%";
          }
          
          function closeNav() {
            document.getElementById("mySidenav").style.width = "0";
          }
         
          $(document).ready(function() {
            $('#my_services').DataTable();
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

<script type="text/javascript">



        var map;
    var input = document.getElementById('pac-input');
    var latitude = document.getElementById('latitude');
    var longitude = document.getElementById('longitude');
    function initMap() {

        var fenway = { lat: 42.345573, lng: -71.098326 };
        var map = new google.maps.Map(document.getElementById('my_map'), {
            center: fenway,
            zoom: 14
        });
        var panorama = new google.maps.StreetViewPanorama(
            document.getElementById('map'), {
                position: fenway,
                pov: {
                    heading: 34,
                    pitch: 10
                }
            });
        map.setStreetView(panorama);

    }
     function ongoingInitialize(trip) {
        map = new google.maps.Map(document.getElementById('my_map'), {
            center: {lat: 0, lng: 0},
            zoom: 2,
        });

        var bounds = new google.maps.LatLngBounds();

        var marker = new google.maps.Marker({
            map: map,
            anchorPoint: new google.maps.Point(0, -29),
            icon: '/assets/img/foody/marker-start.png'
        });

        var markerSecond = new google.maps.Marker({
            map: map,
            anchorPoint: new google.maps.Point(0, -29),
            icon: '/assets/img/foody/marker-end.png'
        });
        source = new google.maps.LatLng(trip.store.latitude, trip.store.longitude);
        if(trip.delivery) {
         destination = new google.maps.LatLng(trip.delivery.latitude, trip.delivery.longitude);
         } else {
            destination = new google.maps.LatLng(trip.store.latitude, trip.store.longitude);
         }
        

        marker.setPosition(source);
        markerSecond.setPosition(destination);

        var directionsService = new google.maps.DirectionsService;
        var directionsDisplay = new google.maps.DirectionsRenderer({suppressMarkers: true, preserveViewport: true});
        directionsDisplay.setMap(map);

        directionsService.route({
            origin: source,
            destination: destination,
            travelMode: google.maps.TravelMode.DRIVING
        }, function(result, status) {
            if (status == google.maps.DirectionsStatus.OK) {
                directionsDisplay.setDirections(result);

                marker.setPosition(result.routes[0].legs[0].start_location);
                markerSecond.setPosition(result.routes[0].legs[0].end_location);
            }
        });

        if(trip.transporter) {
            var markerProvider = new google.maps.Marker({
                map: map,
                icon: "/assets/img/marker-car.png",
                anchorPoint: new google.maps.Point(0, -29)
            });

            provider = new google.maps.LatLng(trip.transporter.latitude, trip.transporter.longitude);
            markerProvider.setVisible(true);
            markerProvider.setPosition(provider);
            console.log('Provider Bounds', markerProvider.getPosition());
            bounds.extend(markerProvider.getPosition());
        }
        
        bounds.extend(marker.getPosition());
        bounds.extend(markerSecond.getPosition());
        map.fitBounds(bounds);
    }


        </script>
      <script src="https://maps.googleapis.com/maps/api/js?key={{Helper::getSettings()->site->browser_key}}&libraries=places&callback=initMap" async defer></script>
@stop
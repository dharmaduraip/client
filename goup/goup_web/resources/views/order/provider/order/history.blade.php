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
               <div class="col-md-12 col-lg-12 col-sm-12 p-0 table-responsive-sm service_history">
                  <table id="service_grid" class="table  table-striped table-bordered w-100">
                     <thead>
                        <tr>
                           <th>@lang('provider.s.no')</th>
                           <th>@lang('provider.booking_id')</th>
                           <th>@lang('provider.date')</th>
                           <th>@lang('provider.pickup')</th>
                           <th>@lang('provider.delivery')</th>
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
            <div class="modal " id="service_modal">
            <div class="modal-dialog min-70vw">
                  <div class="modal-content">
                     <!-- Schedule Header -->
                     <div class="modal-header">
                        <h4 class="modal-title m-0">@lang('provider.Order_Details')</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                     </div>
                     <!-- Schedule body -->
                     <div class="modal-body ">
                      <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-12">
                           <div class="my-trip-left">
                              <h4 class="text-center">
                              <strong>@lang('provider.Food_Service')</strong>
                              </h4>
                              <div class="from-to row m-0">
                                 <div class="from">
                                    <h5>@lang('provider.Order_Location') : <span class ="orderLocation"></span></h5>
                                    <h5>@lang('provider.Order_Items')    : <span class ="orderItems"></span></h5>
                                    <h5>@lang('provider.Order_Date')     : <span class="orderDate"></span></h5>
                                 </div>
                              </div>
                           </div>
                           <div class="mytrip-right">
                              <ul class="invoice">
                                 <li>
                                    <span class="fare">@lang('provider.Cart_Subtotal')</span>
                                    <span class="pricing" id="cartSubtotal"></span>
                                 </li>
                                 <li>
                                    <span class="fare">@lang('provider.Shipping & Handling')</span>
                                    <span class="pricing" id="shippingHandling"></span>
                                 </li>
                                 <li>
                                    <span class="fare">@lang('provider.Wallet_Detection')</span>
                                    <span class="pricing" id="walletDetection"></span>
                                 </li>
                                 <li>
                                    <span class="fare">@lang('provider.Promocode_Discount')</span>
                                    <span class="pricing" id="promocodeDiscount"></span>
                                 </li>
                                 <li>
                                    <span class="fare">@lang('provider.Packing')</span>
                                    <span class="pricing" id="packingAmount"></span>
                                 </li>
                                 <li>
                                    <span class="fare">@lang('provider.Tax_Amount')</span>
                                    <span class="pricing" id="taxAmount"></span>
                                 </li>
                                 <li>
                                    <hr>
                                    <span class="fare" >@lang('provider.Total')</span>
                                    <span class="txt-blue pull-right"><span class ="totalAmount"></span></span>
                                    <hr>
                                 </li>
                              </ul>
                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="map-static b-none">
                              <!-- <img class="map_key_img" src="" /> -->
                              <div id="my_map"  style="height:400px;width:100%;"></div>
                           </div>
                           <div class="trip-user">
                              <!-- For image listing -->
                              <h4 class="modal-title m-0">@lang('provider.User_Details')</h4><hr />
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
      <div class="modal" id="disputeModal">
         <div class="modal-dialog">
            <div class="modal-content">
               <!-- Dispute Header -->
               <div class="modal-header">
                  <h4 class="modal-title">@lang('provider.Dispute_Details')</h4>
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
               </div>
               <div class="from-to row m-0 getdisputedetails">
                     <div class="from">
                        <h5 class="text-left">@lang('provider.Dispute_Name') :  <span class ="dispute_name txt-yellow ml-2"></span></h5>
                        <h5 class="text-left">@lang('provider.Date') :<span class ="created_at txt-yellow ml-2"></span></h5>
                        <h5 class="text-left">@lang('provider.Status') :<span class ="status txt-yellow ml-2"></span></h5>
                        <h5 class="text-left">@lang('provider.Comments_By') :<span class ="comments_by txt-yellow ml-2"></span></h5>
                        <h5 class="text-left">@lang('provider.Comments') :<span class ="comments txt-yellow ml-2"></span></h5>
                     </div>
                     
               </div>
               <!-- Dispute body -->
               <form class="validateForm getdispute"  style= "color:red;">
                  <input type="hidden" name="dispute_order" id="DisputeOrder" value="id">
                  <input type ="hidden" name="dispute_type" value ="provider"/>
                  <div class="col-md-12 col-sm-12">
                     <h5 class=" no-padding"><strong>@lang('provider.Dispute_Name')</strong></h5>
                     <select name="dispute_name" id="dispute_name" class="form-control" autocomplete="off">
                        <option value="">Select</option>
                     </select>
                  </div>
                  <div class="comments-section field-box mt-3 col-12" id ="dispute_comments">
                     <h5 class=" no-padding"><strong>@lang('provider.Dispute_Comments')</strong></h5>
                     <textarea class="form-control" rows="4" cols="50" id="comments"  name="comments" placeholder="Dispute Comments..."></textarea>
                  </div>
                  <!-- Dispute footer -->
                  <div class="modal-footer">
                     <!-- <a  class="btn btn-primary btn-block" data-toggle="modal" data-target="#disputeModal" >Submit <i class="fa fa-check" aria-hidden="true"></i></a> -->
                      <button type="submit"  class="btn btn-primary btn-block">{{ __('Submit') }} <i class="fa fa-check" aria-hidden="true"></i></button>
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
       var trips_table =$('#service_grid');
       $('#ORDER').attr('checked',true);

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
      // Header-Section
      function openNav() {
         document.getElementById("mySidenav").style.width = "50%";
      }
      
      function closeNav() {
         document.getElementById("mySidenav").style.width = "0";
      }
      $(document).ready(function() {
         $('#service_grid').DataTable();
      });
      
      
      $(document).ready(function(){
         $('input:checkbox').click(function() {
            $('input:checkbox').not(this).prop('checked', false);
         });
      });  
   //For Dispute Details
   $.ajax({
      url:  getBaseUrl() + "/provider/order/dispute",
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
         $("#dispute_name").append('<option value="others">Others</option>');
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
        $('#dispute_name,#comments').val('');
        $('#dispute_comments').hide();
        dispute_id = $(this).data('id');
        user_id = $(this).data('user_id');
        store_id = $(this).data('store_id');
        provider_id = $(this).data('provider_id');
        $("#DisputeOrder").val(dispute_id);
         $.ajax({
            type: "GET",
            url: getBaseUrl() + "/provider/order/disputestatus/"+dispute_id,
            beforeSend: function (request) {
               showLoader();
            },
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
                 $('.comments').text(result.dispute_type_comments)   
               }else{
                  $('.getdisputedetails').hide();
                  $('.getdispute').show();
               }
               hideLoader();
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
            data.append('store_id',store_id);
            var url = getBaseUrl() + "/provider/history-dispute/order";
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
            "url": getBaseUrl() + "/provider/history/order",
            "type": "GET",
            "beforeSend": function (request) {
               showLoader();
            },
            "headers": {
                "Authorization": "Bearer " + getToken("provider")
            },data: function(data){
                
                var info = $('#service_grid').DataTable().page.info();
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
         { "data": "assigned_time"},
         { "data": "provider_id" ,render: function (data, type, row) {
               return row.pickup.store_name +', '+ row.pickup.store_location;
            }
         },
         { "data": "provider_id" ,render: function (data, type, row) {
               return row.delivery.map_address;
            }
         },
         { "data": "provider_id" ,render: function (data, type, row) {
               return row.total != null ? row.user.currency_symbol+row.total:row.user.currency_symbol+"0"   ;
            }
         },
         { "data": "status" },
         { "data": "id", render: function (data, type, row) {
               return `<span class="view-icon providertripdetails" data-toggle="modal" data-target="#service_modal" data-id = `+data+` data-toggle="tooltip" title="View"> <i class="fa fa-eye"></i></span><span class="view-icon dispute mt-1" data-toggle="modal" data-target="#disputeModal" data-id = `+data+` data-user_id = `+row.user_id+` data-provider_id = `+row.provider_id+` data-store_id = `+row.store_id+` data-toggle="tooltip" title="Create Dispute"><i class="fa fa-commenting-o" data-toggle="tooltip" title="Create Dispute"></i></span>`;
         }}
        ],
        "drawCallback": function () {
            $('.pagination').css('float','right');
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
         url: getBaseUrl() + "/provider/history/order/"+id,
         beforeSend: function (request) {
               showLoader();
            },
         headers: {
               Authorization: "Bearer " + getToken("provider")
         },
         success:function(data){
            var result = data.responseData.order;
            ongoingInitialize(result);
               var customerAddress = result.delivery.flat_no + ',' +result.delivery.map_address;
               $('.orderLocation').text(customerAddress);
               var items = result.order_invoice.items;
               var food ='';
               for(var j=0;j<items.length;j++){
                  food = food + items[j].product.item_name + ' - ' + items[j].item_quantity + ' ' + items[j].unit   + '<br />';
               }
               $('.orderItems').html(food); 
               $('.orderDate').text(result.created_time); 
               // $('.map_key_img').attr('src', "https://maps.googleapis.com/maps/api/staticmap?autoscale=1&size=420x380&maptype=terrian&format=png&visual_refresh=true&markers=icon:"+window.url+"/assets/layout/images/common/marker-start.png%7C"+result.pickup.latitude+","+result.pickup.longitude+"&markers=icon:"+window.url+"/assets/layout/images/common/marker-end.png%7C"+result.delivery.latitude+","+result.delivery.longitude+"&path=color:0x191919|weight:3|enc:" + result.route_key + "&key=" + "{{Helper::getSettings()->site->browser_key}}");
               $('.user-img').css('background-image', 'url('+result.user.picture+')');
               var username = result.user.first_name + ' ' +result.user.last_name;
               $('.customer_name').text(username);
               $('.booking_id').text(result.store_order_invoice_id);
               
               // $('.orderDate').text(new Date( result.schedule_time ).toLocaleDateString("en-Us") );  
               // $('.orderTime').text(new Date( result.started_time).toLocaleTimeString([], { hour: "2-digit", minute: "2-digit" }));  
               
               var currencyofUser = result.user.currency_symbol;
               var grossAmount = result.order_invoice.item_price.toFixed(2);
               var packAmount = result.order_invoice.store_package_amount.toFixed(2);
               $('#cartSubtotal').html(currencyofUser + ' ' + grossAmount);
               $('.totalAmount').text(currencyofUser + ' ' + result.order_invoice.total_amount);
               $('#shippingHandling').html(currencyofUser + ' ' + result.order_invoice.delivery_amount);
               $('#walletDetection').html(currencyofUser + ' ' + result.order_invoice.wallet_amount);
               $('#promocodeDiscount').html(currencyofUser + ' ' + result.order_invoice.promocode_amount);
               $('#taxAmount').html(currencyofUser + ' ' + result.order_invoice.tax_amount);
               $('#packingAmount').html(currencyofUser + ' ' + packAmount);
               // $('.pricing').text(result.user.currency_symbol);
              if(result.rating !== null && result.rating.provider_rating!==0)
              {
                var userrate = Math.round(result.rating.provider_rating);
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
        source = new google.maps.LatLng(trip.pickup.latitude, trip.pickup.longitude);
        destination = new google.maps.LatLng(trip.delivery.latitude, trip.delivery.longitude);

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
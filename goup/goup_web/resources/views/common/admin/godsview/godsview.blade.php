@extends('common.admin.layout.base')
{{ App::setLocale(  isset($_COOKIE['admin_language']) ? $_COOKIE['admin_language'] : 'en'  ) }}

@section('title') {{ __('God\'s View') }} @stop

@section('styles')
@parent
    <link rel="stylesheet" href="{{ asset('assets/plugins/data-tables/css/responsive.bootstrap.min.css')}}">
    <style type="text/css">
    .provider_list {
      
      height: 500px;

      overflow-y: scroll;
    }
    </style>
@stop

@section('content')
<?php $diff = ['-success','-info','-warning','-danger']; ?>

<div class="content-area mt-20">
<div class="container-fluid">
		<div class="box box-block bg-white">
				<div class="clearfix mb-1 card-header border-bottom">
					  <h6 class="float-xs-left">@lang('admin.heatmap.godseye')</h6>
            <div class="col-md-12">
                    <div class="note_txt">
                        @if(Helper::getDemomode() == 1)
                        <p>** Demo Mode : {{ __('admin.demomode') }}</p>
                        <span class="pull-left">(*personal information hidden in demo)</span>
                        @endif
                        
                    </div>
                </div>
					  <div class="float-xs-right">
					  </div>
        </div>

        <div class="col-md-12">
            <div class="tabs">
               <div class="tab-button-outer">
                <ul class="nav nav-tabs " role="tablist" id="tab-button">
                <ul id="tab-button">
                    @foreach(Helper::getServiceList() as $service)
                    <li class="nav-item">
                      <a class="services" data-type="{{strtolower($service)}}" data-toggle="tab" href="#{{strtolower($service)}}Tab" role="tab" aria-selected="true">{{$service}}</a>
                    </li>
                     @endforeach
                </ul>
                  <!-- <ul id="tab-button">
                     <li class="services" data-type="transport"><a href="javascript:;"> Transport</a></li>
                     <li class="services" data-type="service"><a href="javascript:;"> Service</a></li>
                     <li class="services" data-type="order"><a href="javascript:;"> Order</a></li>
                  </ul> -->
               </div>
            </div>
         </div>
         
         <div class="tab-content">
              <div id="transportTab" class="tab-pane active col-sm-12 col-md-12 col-lg-12 p-0" role="tabpanel">
                    <div class="row p-2">
                      <div class="col-md-12">
                        <div id="floating-panel">
                          <button class="btn  godseye_menu" data-value="STARTED">{{ __('Enroute to Pickup') }}</button>
                          <button class="btn godseye_menu" data-value="ARRIVED">{{ __('Reached Pickup') }}</button>
                          <button class="btn godseye_menu" data-value="PICKEDUP">{{ __('Journey Started') }}</button>
                          <button class="btn godseye_menu" data-value="ACTIVE">{{ __('Available') }}</button>
                          <button class="btn godseye_menu btn-info" data-value="ALL">{{ __('All') }}</button>
                        </div> 
                        
                        <br>

                        <div class="row">
                        <div class="col-md-4">
                          <label class="provider_title ">{{ __('All') }}</label>
                          <ul class="provider_list"></ul>
                        </div>
                        <div class="col-md-8">
                          <div id="transportmap" style="width:100%;height:500px;background:#ccc"></div>
                        </div>
                      </div>
                      </div>
                    </div>
              </div>
              <div id="serviceTab" class="tab-pane col-sm-12 col-md-12 col-lg-12 p-0" role="tabpanel">
                  <div class="row p-2">
                        <div class="col-md-12">
                          <div id="floating-panel">
                            <button class="btn  godseye_menu" data-value="ARRIVED">{{ __('Reached Location') }}</button>
                            <button class="btn godseye_menu" data-value="PICKEDUP">{{ __('Started Service') }}</button>
                            <button class="btn godseye_menu" data-value="DROPPED">{{ __('End Service') }}</button>
                            <button class="btn godseye_menu" data-value="ACTIVE">{{ __('Available') }}</button>
                            <button class="btn godseye_menu btn-info" data-value="ALL">{{ __('All') }}</button>
                          </div>                           
                          <br>
                          <div class="row">
                          <div class="col-md-4">
                            <label class="provider_title ">{{ __('All') }}</label>
                            <ul class="provider_list"></ul>
                          </div>
                          <div class="col-md-8">
                            <div id="servicemap" style="width:100%;height:500px;background:#ccc"></div>
                          </div>
                        </div>
                      </div>
                  </div>
              </div>
              <div id="orderTab" class="tab-pane col-sm-12 col-md-12 col-lg-12 p-0" role="tabpanel">
                  <div class="row p-2">
                      <div class="col-md-12">
                        <div id="floating-panel">
                          <button class="btn  godseye_menu" data-value="STARTED">{{ __('Enroute to Restaurant') }}</button>
                          <button class="btn godseye_menu" data-value="REACHED">{{ __('Reached Restaurant') }}</button>
                          <button class="btn godseye_menu" data-value="PICKEDUP">{{ __('Picked up Food') }}</button>
                          <button class="btn godseye_menu" data-value="ARRIVED">{{ __('Reached to Delivery Location') }}</button>
                          <button class="btn godseye_menu" data-value="ACTIVE">{{ __('Available') }}</button>
                          <button class="btn godseye_menu btn-info" data-value="ALL">{{ __('All') }}</button>
                        </div>                           
                        <br>
                        <div class="row">
                        <div class="col-md-4">
                          <label class="provider_title ">{{ __('All') }}</label>
                          <ul class="provider_list"></ul>
                        </div>
                        <div class="col-md-8">
                          <div id="ordermap" style="width:100%;height:500px;background:#ccc"></div>
                        </div>
                        </div>
                      </div>
                  </div>
              </div>
              
        </div>
			</div>
	</div>
</div>



@stop
@section('scripts')
@parent
	<script src="https://maps.googleapis.com/maps/api/js?key={{Helper::getSettings()->site->browser_key}}&libraries=visualization"></script>
	<script type="text/javascript" src="{{asset('assets/plugins/heatmap/heatmap.min.js')}}"></script>
	<script type="text/javascript" src="{{asset('assets/plugins/heatmap/gmaps-heatmap.js')}}"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.3.0/socket.io.js"></script>
  <script>

    var map, info, type;
    var markers = [];
    var status = "ALL";
    var socket = io.connect('{{Helper::getSocketUrl()}}');
    var current_latitude=0;
    var current_longitude=0;

    type = $('.services').first().data('type');
    $('.services').first().parent().addClass('is-active').siblings().removeClass('is-active');

    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(success, fail);
    } else {
        console.log('Sorry, your browser does not support geolocation services');
        initialize(type);
    }

    function success(position) {
     

        if (position.coords.longitude != "" && position.coords.latitude != "") {
            current_longitude = position.coords.longitude;
            current_latitude = position.coords.latitude;
        }
       

        initialize(type, current_latitude, current_longitude);
    }

    function fail() {
        initialize(type);
    }

    function initialize(type, latitude = 0, longitude = 0) { 

    var mapInterval = setInterval(getProviders, 300000);

    var mapOptions = {
        zoom: 12,
        mapTypeId: google.maps.MapTypeId.ROADMAP,
        center: new google.maps.LatLng(latitude, longitude)
    };
    if (type == 'transport') {
        map = new google.maps.Map(document.getElementById('transportmap'), mapOptions);
    } else if (type == 'service') {
        map = new google.maps.Map(document.getElementById('servicemap'), mapOptions);
    } else if (type == 'order') {
        map = new google.maps.Map(document.getElementById('ordermap'), mapOptions);
    } else {

    }

    

    $('.services').on('click', function() {
        type = $(this).data('type');
         initialize(type, current_latitude, current_longitude);
        $(this).parent().addClass('is-active').siblings().removeClass('is-active');
        clearInterval(mapInterval);
        getProviders();
        mapInterval = setInterval(getProviders, 30000);
    });

    $('.godseye_menu').on('click', function() {
    
        $('.provider_title').text($(this).text());
        status = $(this).data('value');
        $(this).addClass('btn-info').siblings().removeClass('btn-info');
        clearInterval(mapInterval);
        getProviders();
        mapInterval = setInterval(getProviders, 30000);
    });


    function getProviders() {
     
        $.ajax({
            url: getBaseUrl() + "/admin/godsview?status=" + status + "&type=" + type,
            type: 'get',
            'beforeSend': function (request) {
                showLoader();
            },
            headers: {
                Authorization: "Bearer " + getToken("admin")
            },
            data: {},
            success: function(response, textStatus, jqXHR) {
                $('.provider_list').html('');
                
                var data = (parseData(response)).responseData;
                var locations = data.locations;
                var providers = data.providers;
                if(providers.length >0){
                    removeMarkers();

                    $('.provider_list').empty();

                    if(locations.length >0){
                        for (i = 0; i < locations.length; i++) {
                            marker = null;
                            var item = locations[i];
                            var mainservices = '';
                            var urlvalue = '{{ url("/assets/layout/images/common/marker-start.png") }}';
                      
                            if (type == 'transport') {
                            if(providers[i].current_vehicle){
                              if (providers[i].current_vehicle.ride_vehicle != null) {
                                  urlvalue = providers[i].current_vehicle.ride_vehicle.vehicle_marker;
                              }
                            }
                            } else if (type == 'service') {

                            }

                            var marker = new google.maps.Marker({
                                icon: {
                                    scaledSize: new google.maps.Size(30, 35),
                                    url: urlvalue
                                },
                                map: map,
                                position: new google.maps.LatLng(locations[i].lat, locations[i].lng)
                            });

                            marker.provider = providers[i];

                            marker.addListener('click', function(e) {
                                selectProvider(this);
                                scrollList(this);
                            });
                            var onClick = function(marker) {
                                return function() {
                                    selectProvider(marker);
                                }
                            }


                            var image = "{{ asset('/assets/layout/images/common/grey.png') }}";

                            if (providers[i].is_assigned == '0' && providers[i].is_online == '1') {
                                image = "{{ asset('/assets/layout/images/common/green.png') }}";
                            } else{
                                if(providers[i].request){
                                    if (providers[i].request.status == 'ARRIVED') {
                                        image = "{{ asset('/assets/layout/images/common/red.png') }}";
                                    } else if (providers[i].request.status == 'PICKEDUP') {
                                        image = "{{ asset('/assets/layout/images/common/yellow.png') }}";
                                    } else if (providers[i].request.status == 'DROPPED') {
                                        image = "{{ asset('/assets/layout/images/common/blue.png') }}";
                                    } else {
                                        image = "{{ asset('/assets/layout/images/common/grey.png') }}";
                                    }
                                }
                            }

                            var picture = (providers[i].picture == null || providers[i].picture == "") ? "{{asset('assets/layout/images/admin/avatar.jpg')}}" : providers[i].picture;
                            if (providers[i].is_assigned == '0') {
                               $.each(providers[i].providerservice,function(index,item){
                                  if (type == 'transport') {
                                  mainservices +=`<span class="font-weight-bold">`+item.maintransport.ride_name+'></span><span>'+item.ride_vehicle.vehicle_name+`</span>,`;
                                  }
                                  if (type == 'service') {
                                    var str = mainservices.indexOf(item.mainservice.service_category_name);
                                    if(str == -1){
                                        mainservices +=`<span class="font-weight-bold">`+item.mainservice.service_category_name+`</span>,`;
                                    }
                                  }
                                  if (type == 'order') {
                                  mainservices +=`<span class="font-weight-bold">`+item.mainshop.name+`</span>,`;
                                  }
                                });      
                            }else{
                              if(status=='ALL' || status=='ACTIVE'){
                                  if (providers[i].is_assigned == '0') {
                                      $.each(providers[i].providerservice,function(index,item){
                                      if (type == 'transport') {
                                      mainservices +=`<span class="font-weight-bold">`+item.maintransport.ride_name+'></span><span>'+item.ride_vehicle.vehicle_name+`</span>,`;
                                      }
                                      if (type == 'service') {
                                        var str = mainservices.indexOf(item.mainservice.service_category_name);
                                        if(str == -1){
                                            mainservices +=`<span class="font-weight-bold">`+item.mainservice.service_category_name+`</span>,`;
                                        }
                                      }
                                      if (type == 'order') {
                                      mainservices +=`<span class="font-weight-bold">`+item.mainshop.name+`</span>,`;
                                      }
                                    });     
                                }


                              }
                                else if (providers[i].request.status == 'STARTED' ||  providers[i].request.status == 'ARRIVED' || providers[i].request.status == 'PICKEDUP'  || providers[i].request.status == 'REACHED' || providers[i].request.status == 'DROPPED') {

                                    if (type == 'transport') {
                                      mainservices +=`<span class="font-weight-bold">`+providers[i].current_vehicle.ride_vehicle.ride_type.ride_name+'></span><span>'+providers[i].current_vehicle.ride_vehicle.vehicle_name+`</span>,`;
                                    }
                                    if (type == 'service') {
                                      mainservices +=`<span class="font-weight-bold">`+(providers[i].request.request.service.service_category?providers[i].request.request.service.service_category.service_category_name:'')+`</span>,`;
                                    }
                                    if (type == 'order') {
                                      mainservices +=`<span class="font-weight-bold">`+providers[i].current_store_detail.storetype.name+`</span>,`;
                                    }
                                     

                                }
                            }
                            if(status=='ALL' || status=='ACTIVE'){
                              if (providers[i].is_assigned == '0') {
                                  var li = $(`<li style='margin-bottom: 19px;' id="` + providers[i].id + `">
                                  <div class="image">
                                  <div>
                                  <img class="clr"  src="` + image + `">
                                  </div>
                                  <div>
                                  <img class="avt img-circle" height="50px" height="50px" style="border-radius: 50%" src="` + picture + `">
                                  </div>
                                  <p>` + providers[i].first_name + ` ` + providers[i].last_name + ` 
                                  </p><p>`+mainservices.replace(/,\s*$/, "")+`</p><p>` + protect_number(providers[i].mobile) + `</p>
                                  </li>`).on('click', onClick(marker));
                              }
                            }else{

                            var li = $(`<li style='margin-bottom: 19px;' id="` + providers[i].id + `">
                                <div class="image">
                                <div>
                                <img class="clr"  src="` + image + `">
                                </div>
                                <div>
                                <img class="avt img-circle"  style="border-radius: 50%" height="50px" height="50px" src="` + picture + `">
                                </div>
                                <p>` + providers[i].first_name + ` ` + providers[i].last_name + ` 
                                </p><p>`+mainservices.replace(/,\s*$/, "")+`</p><p>` + protect_number(providers[i].mobile) + `</p>
                              </li>`).on('click', onClick(marker));

                            }

                            $('.provider_list').append(li);

                            markers.push(marker);

                        }
                        // end forloop  
                    }
                }
              hideLoader();
            }
        });
    }

    function selectProvider(marker) {
     
        return showinfoWindow(marker);
    }

    function scrollList(marker) {
        var item = $('.provider_list').find('li[id=' + marker.provider.id + ']');

        if (item) {
            var position = $(".provider_list").scrollTop() - $(".provider_list").offset().top + item.offset().top;
            $(".provider_list").animate({
                scrollTop: position
            }, 500);
        }
    }

    function removeMarkers() {
        for (var i in markers) {
            if (typeof markers[i] !== 'undefined') markers[i].setMap(null);
        }
    }

    function showinfoWindow(marker) {
      

          var provider = marker.provider;
          var mainservices = '';
        
          if(status=='ALL' || status=='ACTIVE'){
              mainservices+=`<a href="javascript:void(0)" data-sid="`+type+`"   data-id="`+provider.id+`" class=" vservice" ><i class="material-icons">remove_red_eye</i></a>`;


          }
            else if (provider.request.status == 'STARTED' ||  provider.request.status == 'ARRIVED' || provider.request.status == 'PICKEDUP'  || provider.request.status == 'REACHED' || provider.request.status == 'DROPPED') {

                if (type == 'transport') {
                  mainservices +=`<span class="font-weight-bold">`+provider.current_vehicle.ride_vehicle.ride_type.ride_name+'></span><span>'+provider.current_vehicle.ride_vehicle.vehicle_name+`</span>,`;
                }
                if (type == 'service') {
                  mainservices +=`<span class="font-weight-bold">`+(provider.request.request.service.service_category?provider.request.request.service.service_category.service_category_name:'')+`</span>,`;
                }
                if (type == 'order') {
                  mainservices +=`<span class="font-weight-bold">`+provider.current_store_detail.storetype.name+`</span>,`;
                }
                 

            }
        
        hideinfoWindow();
        if (marker.provider.request != null) {

            var live_track = (Object.keys(marker.provider.request).length > 0) ? (marker.provider.request.status == 'PICKEDUP') ?
                `<tr><td></td><td><a href="{{url('/track')}}/` + marker.provider.request.request_id + `" target="_blank"><b>Live tracking</b></a></td></tr>` : `` : ``;

            var picture = (marker.provider.picture == null || marker.provider.picture == "") ? "{{asset('assets/layout/images/admin/avatar.jpg')}}" : marker.provider.picture;

            var html = `<table>
          <tbody>
            <tr><td rowspan="5"><img src="` + picture + `" width="50px" style="border-radius: 50%" class="img-circle" height="50px"></td></tr>
            <tr><td>&nbsp;&nbsp;Name: </td><td><b>` + marker.provider.first_name + ` ` + marker.provider.last_name + `</b></td></tr>
            <tr><td>&nbsp;&nbsp;Email: </td><td><b>` + marker.provider.email + `</b></td></tr>
            <tr><td>&nbsp;&nbsp;Mobile: </td><td><b>` + marker.provider.mobile + `</b></td></tr>
            <tr><td>&nbsp;&nbsp;Services: </td><td>` + mainservices.replace(/,\s*$/, "") + `</td></tr>` + live_track +
                `</tbody>
        </table>`;

            info = new google.maps.InfoWindow({
                content: html,
                maxWidth: 350
            });

            info.open(map, marker);

        }else{ 

             var live_track = ``;

            var picture = (marker.provider.picture == null || marker.provider.picture == "") ? "{{asset('assets/layout/images/admin/avatar.jpg')}}" : marker.provider.picture;

            var html = `<table>
          <tbody>
            <tr><td rowspan="5"><img src="` + picture + `" width="50px" style="border-radius: 50%"  class="img-circle"  height="50px"></td></tr>
            <tr><td>&nbsp;&nbsp;Name: </td><td><b>` + marker.provider.first_name + ` ` + marker.provider.last_name + `</b></td></tr>
            <tr><td>&nbsp;&nbsp;Email: </td><td><b>` + marker.provider.email + `</b></td></tr>
            <tr><td>&nbsp;&nbsp;Mobile: </td><td><b>` + marker.provider.mobile + `</b></td></tr>`
            ;
            if(status=='ALL' || status=='ACTIVE'){ 
              html += `<tr><td>&nbsp;&nbsp; </td><td>` + mainservices + `</td></tr>` + live_track +
                `</tbody>`;
            }else{
              html += `<tr><td>&nbsp;&nbsp;Services: </td><td>` + mainservices.replace(/,\s*$/, "") + `</td></tr>` + live_track +
                `</tbody>`;
              }
        html += `</table>`;

            info = new google.maps.InfoWindow({
                content: html,
                maxWidth: 350
            });

            info.open(map, marker);

        }

    }

    getProviders();
    }

    function hideinfoWindow() {
      if (typeof info != 'undefined' && info != null) {
            info.close();
        }
      
    }


  $(document).on('click','.vservice',function(e){ 
        
        e.preventDefault();
        var id = $(this).data('id');
        var sid = $(this).data('sid');
        $.get("{{ url('admin/godsview/services') }}/"+id+'/'+sid, function(data) {
            $('.crud-modal .modal-container').html("");
            $('.crud-modal .modal-container').html(data);
        });
        $('.crud-modal').modal('show');
 
    });

	</script>

@stop
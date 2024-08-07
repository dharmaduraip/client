@extends('common.admin.layout.base')
{{ App::setLocale(  isset($_COOKIE['admin_language']) ? $_COOKIE['admin_language'] : 'en'  ) }}
@section('title') {{ __('Heat Map') }} @stop
@section('styles')
@parent
<link rel="stylesheet" href="{{ asset('assets/plugins/data-tables/css/responsive.bootstrap.min.css')}}">
@stop
@section('content')
<?php $diff = ['-success','-info','-warning','-danger']; ?>
<div class="content-area mt-20">
   <div class="container-fluid">
      <div class="box box-block bg-white">
         <div class="clearfix mb-1 card-header border-bottom">
            <h6 class="float-xs-left">@lang('admin.heatmap.Ride_Heatmap')</h6>
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
                  <ul id="tab-button">
                    @foreach(Helper::getServiceList() as $service)
                     <li class="services" data-type="{{strtolower($service)}}"><a href="javascript:;">{{$service}}</a></li>
                     @endforeach
                  </ul>
               </div>
            </div>
         </div>
         <div id="tab01" class="tab-contents row p-2" >
            <div class="col-md-12">
               <div id="floating-panel">
                  <button class="btn btn-info" onclick="toggleHeatmap(event)">{{ __('Toggle Heatmap') }}</button>
                  <button class="btn btn-info" onclick="changeGradient(event)">{{ __('Change gradient') }}</button>
                  <button class="btn btn-info" onclick="changeRadius(event)">{{ __('Change radius') }}</button>
                  <button class="btn btn-info" onclick="changeOpacity(event)">{{ __('Change opacity') }}</button>
               </div>
               <br>
               <div id="map" style="width:100%;height:530px;background:#ccc"></div>
            </div>
         </div>
         <div class="content-box dis-center d-none">
         <div class="col-md-12 col-sm-12 col-lg-12 p-0 mt-5 dis-center">
			<h5 class="txt-primary"><strong>{{ __('No Services Available') }}</strong></h5>
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
<script type="text/javascript">

      var map, heatmap, type;
   
      if( navigator.geolocation ) {
         navigator.geolocation.getCurrentPosition( success, fail );
      } else {
          console.log('Sorry, your browser does not support geolocation services');
          initMap();
      }
   
      function success(position)
      {
   
        if(position.coords.longitude != "" && position.coords.latitude != ""){
            current_longitude = position.coords.longitude;
            current_latitude = position.coords.latitude;
        }
   
        initMap(current_latitude, current_longitude);
      }
   
      function fail()
      {
        initMap();
      }
   
      function initMap(latitude = 13.066239, longitude = 80.274816) {
        map = new google.maps.Map(document.getElementById('map'), {
          zoom: 13,
          center: {lat: latitude, lng: longitude},
          mapTypeId: 'roadmap'
        });
   
        heatmap = new google.maps.visualization.HeatmapLayer({
          map: map,
          radius: 30
        });

        $('.services').first().trigger('click');
   
        getData();
   
        var socket = io.connect(window.socket_url);
   
        socket.emit('joinCommonRoom', `room_${window.room}`);
   
        socket.on('socketStatus', function (data) {
            console.log(data);
        });
   
        socket.on('newRequest', function (data) {
          getData();
        });
   
   
   
      }
   
      //setInterval(getData, 8000);
   
      function toggleHeatmap(event) {
        heatmap.setMap(heatmap.getMap() ? null : map);
        toggleClasses(event);
      }
   
      function changeGradient(event) {
        var gradient = [
          'rgba(0, 255, 255, 0)',
          'rgba(0, 255, 255, 1)',
          'rgba(0, 191, 255, 1)',
          'rgba(0, 127, 255, 1)',
          'rgba(0, 63, 255, 1)',
          'rgba(0, 0, 255, 1)',
          'rgba(0, 0, 223, 1)',
          'rgba(0, 0, 191, 1)',
          'rgba(0, 0, 159, 1)',
          'rgba(0, 0, 127, 1)',
          'rgba(63, 0, 91, 1)',
          'rgba(127, 0, 63, 1)',
          'rgba(191, 0, 31, 1)',
          'rgba(255, 0, 0, 1)'
        ]
        heatmap.set('gradient', heatmap.get('gradient') ? null : gradient);
        toggleClasses(event);
      }
   
      function changeRadius(event) {
        heatmap.set('radius', heatmap.get('radius') ? null : 30);
        toggleClasses(event);
      }
   
      function changeOpacity(event) {
        heatmap.set('opacity', heatmap.get('opacity') ? null : 0.2);
        toggleClasses(event);
      }
   
      function toggleClasses(event) {
        if($(event.target).hasClass('btn-primary')) {
        	$(event.target).removeClass('btn-primary');
        } else {
        	$(event.target).addClass('btn-primary');
        }
      }

      $('.services').on('click', function() {
          type = $(this).data('type');
          $(this).addClass('is-active').siblings().removeClass('is-active');
          getData();
      });
   
      function getData() {
          $.ajax({
            url: getBaseUrl() + "/admin/heatmap?type="+type,
            type: 'get',
            headers: {
                Authorization: "Bearer " + getToken("admin")
            },
            data: {
            },
          success:function(response, textStatus, jqXHR) {
            var data = (parseData(response)).responseData;
            var points = [];
   
            for(var datum of data) {
              points.push(new google.maps.LatLng(datum.lat, datum.lng));
            }
            heatmap.setData(points);
          }
        });
      }
   
</script>
@stop
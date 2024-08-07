@extends('common.user.layout.base')
{{ App::setLocale(  isset($_COOKIE['user_language']) ? $_COOKIE['user_language'] : 'en'  ) }}
@section('styles')
@parent
<style type="text/css">
  .pac-container{
    z-index: 999999999!important;
  }
</style>

@stop
@section('content')
<div class="site-wrapper animsition">
         <div class="page-wrapper z-1 content-box">
            <!-- start: Inner page hero -->
            <div class="result-show">
               <div class="container">
                  <div class="row">
                     <div class="col-sm-12 col-md-6 col-xl-4" >
                         <input type="hidden" id="latitude" name="latitude" value="{{ old('latitude') }}" readonly >
                        <input type="hidden" id="longitude" name="longitude" value="{{ old('longitude') }}" readonly >
                    
                        <div class="location-section m-0"  data-toggle="modal" data-target="#addressModal">
                           <span class="location-title">
                           <span class="landmark">@lang('store.user.Select_Address')</span>
                           </span><span class="city"> </span>
                           <span class="fa fa-angle-down arrow-icon"></span>
                        </div>
                     </div>
                     </p>
                     <div class="col-sm-9 dis-ver-center c-pointer">
                        <!-- <p><span class="primary-color"><strong>124</strong></span> Results so far  -->
                     </div>
                  </div>
               </div>
            </div>
            <!-- //results show -->
            <section class="restaurants-page pt-5 pb-5">
               <div class="row bg-white p-3">
                  <div class="col-md-12 col-sm-12 col-xl-2 filtsrc p-0">
                     <div class="sidebar left">
                        <div class="widget style2 Search_filters d-none">
                           <h4 class="widget-title2 sudo-bg-red" itemprop="headline">@lang('store.user.Search_Filters')</h4>
                           <div class="widget-data">
                              <ul class="d-block" id="cuisine_list">
                                 <!-- <li><a href="#" title="" itemprop="url">Pizza</a> <span>6</span></li>
                                 <li><a href="#" title="" itemprop="url">Ice Cream</a> <span>6</span></li>
                                 <li><a href="#" title="" itemprop="url">Rolls</a> <span>6</span></li> -->
                              </ul>
                           </div>
                        </div>
                        <div class="widget style2 quick_filters d-none">
                           <h4 class="widget-title2 sudo-bg-red" itemprop="headline">@lang('store.user.Quick_Filters')</h4>
                           <div class="widget-data">
                              <ul class="d-block">
                                 <li class="text-center"><a href="javascript:void(0)" class="reset_radio_btn">{{ __('Reset') }}</a></li>
                                 <li><span class="radio-box"><input type="radio" name="qfilter" class="search" value="non-veg" id="qfilt1-2"><label for="qfilt1-2" >@lang('store.user.Non_Veg')</label></span></li>
                                 <li><span class="radio-box"><input type="radio" name="qfilter" class="search" id="qfilt1-3" value="pure-veg" ><label for="qfilt1-3">@lang('store.user.Pure_veg')</label></span></li>
                                 <li><span class="radio-box"><input type="radio" name="qfilter" class="search" id="qfilt1-4" value="freedelivery"><label for="qfilt1-4">@lang('store.user.Free_Delivery')</label></span></li>
                                <!--  <li><span class="radio-box"><input type="radio" name="qfilter" class="search" id="qfilt1-5" value="onlinepayment" ><label for="qfilt1-5">Online Payments</label></span></li> -->
                              </ul>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="col-xl-10 col-sm-12 col-lg-12 contsrc">
                     <div class="row" id="store_list">
                        
                     </div>
                     <!--end:row -->
                     <!-- end:Restaurant entry -->
                  </div>
               </div>
            </section>
         </div>
      </div>


  <!-- Address Modal -->
         <div class="modal" id="addressModal">
            <div class="modal-dialog">
               <div class="modal-content">
                  <!-- Address Header -->
                  <div class="modal-header">
                     <h4 class="modal-title">@lang('store.user.Choose_Location')</h4>
                     <button type="button" class="close" data-dismiss="modal">&times;</button>
                  </div>
                  <!-- Address body -->
                  <div class="modal-body">
                     <div class="col-sm-12 col-lg-12">
                       <!--  <span class="fa fa-location-arrow" style=" position: absolute; left: 5%; top: 25%;color: #495057;font-size: 18px;"></span> -->
                        <input class="form-control search-loc-form" type="text" id="pac-input" name="search_loc" placeholder="Search for area, street name.." required>
                         
                         <input type="hidden" id="latitude" name="latitude" value="{{ old('latitude') }}" readonly >
                         <input type="hidden" id="longitude" name="longitude" value="{{ old('longitude') }}" readonly >
                         <div id="my_map"   style="height:500px;width:500px;display: none" ></div>
                        <span class="my_map_form_current"><i class="material-icons" style=" position: absolute; right: 5%; top: 25%;color: #495057;font-size: 18px;cursor: pointer;">my_location</i> </span>
                     </div>
                     <div class="address-block " id="address_saved">
                        
                     </div>
                  </div>
                  <!-- Address footer -->
                  <!-- <div class="modal-footer">
                     <a  class="btn btn-primary btn-block" data-toggle="modal" data-target="#myModal">Schedule later</a>
                     </div> -->
               </div>
            </div>
         </div>
         <!-- Address Modal -->
@stop

@section('scripts')
@parent

<script>
    function openNav() {
      document.getElementById("mySidenav").style.width = "100%";
    }
      
    function closeNav() {
      document.getElementById("mySidenav").style.width = "0";
    }
     
       // Input Checked
    $(document).ready(function(){
      $('input:checkbox').click(function() {
        $('input:checkbox').not(this).prop('checked', false);
      });
    });
      $.ajax({
         url: getBaseUrl() + "/user/store/cusines/{{$id}}",
         type:"GET",
         processData: false,
         contentType: false,
         secure: false,
         headers: {
             Authorization: "Bearer " + getToken("user")
         },
         success: (data, textStatus, jqXHR) => {
            if((data.responseData).length != 0) { 
               var cusine_list = data.responseData;
               $.each(cusine_list, function(i,val){
                  var cuisine ='<li><span class="check-box"><input type="checkbox" class="search" name="filter" id="filt1-'+val.id+'" value="'+val.id+'"  ><label for="filt1-'+val.id+'">'+val.name+'</label></span></li>';
                   $('#cuisine_list').append(cuisine);
               });
            }

         }
       });

      $.ajax({
         url: getBaseUrl() + "/user/store/check/request",
         type:"GET",
         processData: false,
         contentType: false,
         secure: false,
         headers: {
             Authorization: "Bearer " + getToken("user")
         },
         success: (data, textStatus, jqXHR) => {
            if((data.responseData).length != 0) { 
               if((data.responseData.data).length>0){
                var order = data.responseData.data ;
                //window.location.href=  "{{url('/store/order/')}}/"+order[0].id;
               }
            }

         }
       });




      $.ajax({
         url: getBaseUrl() + "/user/store/useraddress",
         type:"GET",
         processData: false,
         contentType: false,
         secure: false,
         headers: {
             Authorization: "Bearer " + getToken("user")
         },
         success: (data, textStatus, jqXHR) => {
            if((data.responseData).length != 0) { 
               var address_list = data.responseData;
                var address_saved ='<h5 >SAVED ADDRESSES</h5>';
               $.each(address_list, function(i,val){
                  if(val.map_address != null && val.map_address != ''){
                     mapAddress =  val.map_address;
                  }else{
                     mapAddress =  val.street;
                  }
                  address_saved +='<div class="address-set green  setaddr" data-lat="'+val.latitude+'" data-lng="'+val.longitude+'" data-loc="'+val.map_address+'">';
                     if(val.address_type=='Home'){
                           address_saved +='<i class="material-icons address-category">home</i>';
                     }
                     if(val.address_type=='Work'){
                           address_saved +='<i class="material-icons address-category">work</i>';
                     }
                     if(val.address_type=='Other'){
                        address_saved +='<i class="material-icons address-category">location_on</i>';
                     }
                     address_saved +='<div class="">\
                        <h5 class="">'+val.address_type+'</h5>\
                        <p >'+ mapAddress +'</p>\
                     </div>\
                  </div>';
               });
               $('#address_saved').html(address_saved);
            }

         }
       });
      shoplist('');
      function shoplist(){
         var filter =[];
        var qfilter = '';;
        var userSettings = getUserDetails();
        //var filter =[];
         $.each($("input[name='filter']:checked"), function(){            
                filter.push($(this).val());
            });
         var search = '?city_id='+userSettings.city_id+'&filter='+filter.join(",");
         $.each($("input[name='qfilter']:checked"), function(){            
                qfilter = '&qfilter='+$(this).val();
            });
         search +=qfilter;
         if(typeof localStorage.latitude !== 'undefined') {
            search +='&latitude='+window.localStorage.getItem('latitude');
         }
         if(typeof localStorage.longitude !== 'undefined') {
            search +='&longitude='+window.localStorage.getItem('longitude');
         }

        $.ajax({
        url: getBaseUrl() + "/user/store/list/{{$id}}"+search,
        type:"GET",
        processData: false,
        contentType: false,
        secure: false,
        headers: {
              Authorization: "Bearer " + getToken("user")
        },
        success: (data, textStatus, jqXHR) => {
            if((data.responseData).length != 0) { 
                var store_list = data.responseData;
                  $('#store_list').html('');
                  var url = "{{ url('/store/details') }}";
                  if(store_list[0].storetype.category=='FOOD'){
                    $('.Search_filters').removeClass('d-none');
                    $('.quick_filters').removeClass('d-none');
                  }else{
                    //$('.Search_filters').addClass('d-none');
                    //$('.quick_filters').addClass('d-none');
                    $('.contsrc').removeClass('col-xl-9').addClass('col-xl-12');
                    $('.filtsrc').remove();
                  }
                $.each(store_list, function(i,val){
                  if(store_list[0].storetype.category=='FOOD'){
                  var store ='<div class="col-sm-12 col-lg-4 col-md-6 col-xl-4 text-xs-center text-sm-left restaurant-list">';
                  }else{
                    var store ='<div class="col-sm-12 col-lg-4 col-md-6 col-xl-3 text-xs-center text-sm-left restaurant-list">';
                  }
                    store +='<div class=" bg-gray restaurant-entry food-item-wrap">\
                    <div class="entry-logo figure-wrap">\
                    <a class="img-fluid" href="'+url+'/'+val.id+'"><img src="'+val.picture+'" alt="Food logo">';
                    if(val.rating){
                    store +='<span class="post-rate"><i class="fa fa-star-o"></i> '+val.rating+'</span>';
                    }else{
                      store +='<span class="post-rate"><i class="fa fa-star-o"></i>0</span>';
                    }
                    store +='</a>\
                    </div>\
                    <div class="entry-dscr"><div>\
                    <a href="#">'+val.store_name+'</a>';

                    store+='</div><span>';
                        var count =0;
                        var mycat = '';
                    $.each(val.categories,function(key,item){ count++;
                           if(count <= 10){
                      mycat+=item.store_category_name+', ';
                           }
                    });
                    mycat = mycat.replace(/,\s*$/, "");
                    store+=mycat+'</span>\
                    <ul class="list-inline">\
                    <li class="list-inline-item"><i class="fa fa-check"></i> Min '+val.offer_min_amount+'</li>';
                    if(store_list[0].storetype.category=='FOOD'){
                    store+='<li class="list-inline-item"><i class="fa fa-motorcycle"></i> '+val.estimated_delivery_time+' min</li>';
                    }
                    store+='</ul>';
                    if(val.shopstatus=='CLOSED'){
                      store+='<a href="'+url+'/'+val.id+'" class="btn btn-danger" > '+val.shopstatus +'</a>';
                    }else{
                      if(store_list[0].storetype.category=='FOOD'){
                        store+='<a href="'+url+'/'+val.id+'" class="btn btn-primary">View Menu</a>';
                      }
                      else
                      {
                        store+='<a href="'+url+'/'+val.id+'" class="btn btn-primary">View Items</a>';
                      }
                    }
                    store+='</div></div></div>';
                   
                    $('#store_list').append(store);
                });
            }else{
                  $('#store_list').html('<h5>No Shop Available</h5>');
               }
        }
      });
   }

    $('body').on('click', '.search', function(e) { 
         shoplist();
     });
    $('body').on('click','.setaddr',function (e){
    var lat = $(this).data('lat');
    var lng = $(this).data('lng');
    var addr = $(this).data('loc');
    updateForm(lat, lng, addr);
    shoplist();
  });
    $('body').on('click','.reset_radio_btn',function(e){ 
      $('input[name="qfilter"]').prop('checked', false);
      shoplist();
    });
</script>

<script>
   if(typeof localStorage.landmark !== 'undefined') {
      $('.landmark').html(window.localStorage.getItem('landmark'));
   }
   if(typeof localStorage.city !== 'undefined') {
      $('.city').html(window.localStorage.getItem('city'));
   }
   if(typeof localStorage.latitude !== 'undefined') {
      $('#latitude').val(window.localStorage.getItem('latitude'));
   }
   if(typeof localStorage.longitude !== 'undefined') {
      $('#longitude').val(window.localStorage.getItem('longitude'));
   }
   
   
    var map;
    var input = document.getElementById('pac-input');
    var latitude = document.getElementById('latitude');
    var longitude = document.getElementById('longitude');

    function initMap() { 

        var userLocation = new google.maps.LatLng(
                13.066239,
                80.274816
            );        
        map = new google.maps.Map(document.getElementById('my_map'), {
            center: userLocation,
            zoom: 15
        });

        var service = new google.maps.places.PlacesService(map);
        var autocomplete = new google.maps.places.Autocomplete(input);
        var infowindow = new google.maps.InfoWindow();

        autocomplete.bindTo('bounds', map);

        var infowindow = new google.maps.InfoWindow({
            content: "Shop Location",
        });

        var marker = new google.maps.Marker({
            map: map,
            draggable: true,
            anchorPoint: new google.maps.Point(0, -29)
        });

        marker.setVisible(true);
        marker.setPosition(userLocation);
        infowindow.open(map, marker);

        if (navigator.geolocation) { 
            navigator.geolocation.getCurrentPosition(function(location) { 
                var userLocation = new google.maps.LatLng(
                    location.coords.latitude,
                    location.coords.longitude
                );
            });
        } else {
          // Browser doesn't support Geolocation
          handleLocationError(false, infoWindow, map.getCenter());
        }

        google.maps.event.addListener(map, 'click', updateMarker);
        google.maps.event.addListener(marker, 'dragend', updateMarker);
       

        function updateMarker(event) {
            var geocoder = new google.maps.Geocoder();
            geocoder.geocode({'latLng': event.latLng}, function (results, status) {
                if (status == google.maps.GeocoderStatus.OK) {
                    if (results[0]) {
                        input.value = results[0].formatted_address;
                        updateForm(event.latLng.lat(), event.latLng.lng(), results[0].formatted_address);
                    } else {
                        alert('No Address Found');
                    }
                } else {
                    alert('Geocoder failed due to: ' + status);
                }
            });

            marker.setPosition(event.latLng);
            map.setCenter(event.latLng);
        }

        autocomplete.addListener('place_changed', function(event) {
            marker.setVisible(false);
            var place = autocomplete.getPlace();

            if (place.hasOwnProperty('place_id')) {
                if (!place.geometry) {
                    window.alert("Autocomplete's returned place contains no geometry");
                    return;
                }
                updateLocation(place.geometry.location);
            } else {
                service.textSearch({
                    query: place.name
                }, function(results, status) {
                    if (status == google.maps.places.PlacesServiceStatus.OK) {
                        updateLocation(results[0].geometry.location, results[0].formatted_address);
                        input.value = results[0].formatted_address;

                    }
                });
            }
        });

        function updateLocation(location) {
            map.setCenter(location);
            marker.setPosition(location);
            marker.setVisible(true);
            infowindow.open(map, marker);
            updateForm(location.lat(), location.lng(), input.value);
        }
    }

      function getcustomaddress(latLngvar){
            var geocoder = new google.maps.Geocoder();
            geocoder.geocode({'latLng': latLngvar}, function (results, status) {
                if (status == google.maps.GeocoderStatus.OK) {
                    //console.log(results[0]);
                    if (results[0]) {
                        //input_cur.value = results[0].formatted_address;
                         
                        updateForm(latLngvar.lat, latLngvar.lng, results[0].formatted_address);
                    } else {
                        alert('No Address Found');
                    }
                } else {
                    alert('Geocoder failed due to: ' + status);
                }
            });
      }

        function updateForm(lat, lng, addr) {
            showLoader(); 
            //console.log(lat,lng, addr);
            latitude.value = lat;
            longitude.value = lng;
            var address = addr;
            var landmark = address.split(',')[0];
            var city = address.replace(address.split(',')[0]+',',' ');
            window.localStorage.setItem('landmark', landmark);
            window.localStorage.setItem('city', city);
            window.localStorage.setItem('latitude', lat);
            window.localStorage.setItem('longitude', lng);
            if(landmark ==''){
               $('.landmark').html('Select Address');
            }else{
               $('.landmark').html(landmark);
            }
            if(city ==''){
               $('.city').html('Select Address');
            }else{
               $('.city').html(city);
            }
            shoplist();
            $("#addressModal").modal('hide');
            hideLoader();
        }
    $('.my_map_form_current').on('click',function(){
        //$('#my_map_form_current').submit();
        var current_latitude = 13.0574400;
       var current_longitude = 80.2482605;

       if( navigator.geolocation ) {
          navigator.geolocation.getCurrentPosition( success, fail );
       } else {
           console.log('Sorry, your browser does not support geolocation services');
           
       }
       function success(position)
       {
           document.getElementById('longitude').value = position.coords.longitude;
           document.getElementById('latitude').value = position.coords.latitude

           if(position.coords.longitude != "" && position.coords.latitude != ""){
               longitude = position.coords.longitude;
               latitude = position.coords.latitude;
                var latlng = {lat: parseFloat(position.coords.latitude), lng: parseFloat(position.coords.longitude)};
                getcustomaddress(latlng);

           }
       }
       function fail()
       {
           // Could not obtain location
           console.log('unable to get your location');
       }
       initMap();

    });

</script>
<script src="https://maps.googleapis.com/maps/api/js?key={{Helper::getSettings()->site->browser_key}}&libraries=places&callback=initMap" async defer></script>
@stop
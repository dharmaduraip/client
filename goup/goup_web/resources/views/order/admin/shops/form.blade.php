{{ App::setLocale(  isset($_COOKIE['admin_language']) ? $_COOKIE['admin_language'] : 'en'  ) }}
<div class="row mb-4 mt-20">
    <div class="col-md-12">
        <div class="card-header border-bottom">
            @if(empty($id))
                @php($action_text=__('admin.add'))
            @else
                @php($action_text=__('admin.edit'))
            @endif
            <h6 class="m-0"style="margin:10!important;">{{$action_text}} {{ __('Shop') }}</h6>
        </div>
        <div class="form_pad">
        <form class="validateForm" files="true">
                @if(!empty($id))
                <input type="hidden" name="_method" value="PATCH">
                <input type="hidden" name="id" value="{{$id}}">
                @endif
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="store_type_id">@lang('store.admin.shops.type')</label>
                        <select name="store_type_id" id="store_type_id" class="form-control" autocomplete="off">
                            <option value="">Select</option>
                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="name">{{ __('store.admin.shops.name') }}</label>
                        <input type="text" class="form-control" id="store_name" name="store_name" placeholder="{{ __('store.admin.shops.name') }}" value="" autocomplete="off">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="name">{{ __('store.admin.shops.email') }}</label>
                        <input type="text" class="form-control" id="email" name="email" placeholder="{{ __('store.admin.shops.email') }}" value="" autocomplete="off">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="offer_min_amount">{{ __('store.admin.shops.minamount') }}</label>
                        <input type="text" class="form-control decimal" id="offer_min_amount" name="offer_min_amount" placeholder="{{ __('store.admin.shops.minamount') }}" autocomplete="off">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6" id="estdeltime">
                        <label for="estimated_delivery_time">{{ __('store.admin.shops.estdeltime') }}</label>
                        <input type="number" class="form-control" id="estimated_delivery_time" name="estimated_delivery_time" placeholder="{{ __('store.admin.shops.estdeltime') }}" autocomplete="off">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="offer_percent">{{ __('store.admin.shops.offper') }}</label>
                        <input type="number" class="form-control decimal" id="offer_percent" name="offer_percent" placeholder="{{ __('store.admin.shops.offper') }}" autocomplete="off">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6" id="isVeg">
                      <label class="mr-2"><input type="radio"  class="is_veg" value = "Pure Veg" name="is_veg"> {{ __('store.admin.shops.veg') }}</label>
                      <label><input type="radio" class="is_veg"value = "Non Veg" name="is_veg"> {{ __('store.admin.shops.nonveg') }}</label>
                      <label><input type="radio" class="is_veg"value = "Mixed" name="is_veg"> {{ __('store.admin.shops.mixed') }}</label>
                    </div>
                    <div class="form-group col-md-6" id="cuisine">
                        <label for="cuisine_id">@lang('store.admin.shops.cuisname')</label>
                        <select name="cuisine_id[]" id="cuisine_id" class="form-control" multiple="multiple" autocomplete="off">
						</select>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="store_gst">{{ __('store.admin.shops.gst') }}</label>
                        <input type="number" class="form-control" id="store_gst" name="store_gst" placeholder="{{ __('store.admin.shops.gst') }}" value="0" autocomplete="off">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="commission">{{ __('store.admin.shops.commission') }}</label>
                        <input type="number" class="form-control decimal" id="commission" name="commission" placeholder="{{ __('store.admin.shops.commission') }}" value="0" autocomplete="off">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="country_id">{{ __('admin.country.country_name') }}</label>
                        <select name="country_id" id="country_id" class="form-control" autocomplete="off">
                        <option value="">Select</option>
                        @foreach(Helper::getCountryList() as $key => $country)
                            <option value={{$key}} data-currency={{Helper::getCountryCurrency($key)}}>{{$country}}</option>
                        @endforeach
						</select>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="city_id">{{ __('admin.country.city_name') }}</label>
                        <select name="city_id" id="city_id" class="form-control">
						</select>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="contact_person">@lang('store.admin.shops.contactper')</label>
                        <input type="text" class="form-control" id="contact_person"  name="contact_person" placeholder="{{ __('store.admin.shops.contactper') }}" >
                    </div>
                    <div class="form-group col-md-6">
                        <label for="description">{{ __('store.admin.shops.description') }}</label>
                        <textarea class="form-control" placeholder="Enter Description" id="description" name="description"></textarea>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="contact_number">@lang('store.admin.shops.contactno')</label>
                        <input type="number" class="form-control phone" id="contact_number" minlength="10" name="contact_number" placeholder="{{ __('store.admin.shops.contactno') }}" >
                    </div>
                    <div class="form-group col-md-6">
                        <label for="store_location">{{ __('store.admin.shops.location') }}</label>
                        <input type="text" class="form-control" id="store_location" name="store_location" placeholder="{{ __('store.admin.shops.location') }}" >
                        <input type="hidden" name="latitude" id="latitude" />
                        <input type="hidden" name="longitude" id="longitude" />
                        <span id="map" style="display:none"></span>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="password">@lang('store.admin.shops.password')</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="{{ __('store.admin.shops.password') }}" >
                    </div>
                    <div class="form-group col-md-6">
                        <label for="store_zipcode">{{ __('store.admin.shops.pincode') }}</label>
                        <input type="number" class="form-control" id="store_zipcode" name="store_zipcode" placeholder="{{ __('store.admin.shops.pincode') }}" >
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="confirmpassword">@lang('store.admin.shops.confirmpassword')</label>
                        <input type="password" class="form-control" name="confirmpassword" id="confirmpassword"  placeholder="{{ __('store.admin.shops.confirmpassword') }}" >
                    </div>
                    <div class="form-group col-md-6">
                        <label for="store_packing_charges" id="packing_charges">{{ __('store.admin.shops.packing_charges') }} (<span id="currency_country">$</span>)</label>
                        <input type="text" class="form-control decimal" id="store_packing_charges" name="store_packing_charges" placeholder="{{ __('store.admin.shops.packing_charges') }}" >
                    </div>
                </div>
                <div class="form-row">
                <div class="form-group col-md-6">
					<label for="status" class="col-xs-2 col-form-label">@lang('store.admin.shops.status')</label>
						<select name="status" class="form-control">
                            <option value="1">Active</option>
							<option value="0">Onboarding</option>
							<option value="2">Banned</option>

						</select>
					</div>
                    <div class="form-group col-md-6">
                    <label for="status" class="col-xs-2 col-form-label">@lang('store.admin.shops.zone')</label>
                    <select name="zone_id" id="zone_id" class="form-control">
                        </select>
                    </div>
                </div>
             <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="picture">{{ __('admin.picture') }}</label>
                        <div class="image-placeholder w-100">
                            <img width="100" height="100" />
                            <input type="file" name="picture" class="upload-btn picture_upload">
                        </div>
                        <span style="color:red;font-size:15px;display:none" id="img_error" >Select Image less thaan 10MB Size</span>
                    </div>
				</div>
                <div class="form-row" id="time">
                    <div class="form-group col-md-5" >
                        <label for="store_response_time">@lang('admin.setting.resturant_response_time') (Secs)</label>
                        <input type="text" class="form-control number" id="store_response_time" name="store_response_time" placeholder="@lang('admin.setting.resturant_response_time')" >
                    </div>
                    <div class="form-group col-md-3">
                        <label for="bestseller">@lang('admin.setting.bestseller')</label>
                        <input type="number" min="1" class="form-control number" id="bestseller" name="bestseller" placeholder="@lang('admin.setting.bestseller')" >
                    </div>
                    <div class="form-group col-md-4">
                        <label for="bestseller_month">@lang('admin.setting.bestseller_month') (In Month)</label>
                        <input type="number" class="form-control number" id="bestseller_month" name="bestseller_month" min="1" max="12" placeholder="@lang('admin.setting.bestseller_month')" >
                    </div>
                </div>
                <div class="form-group" id="everyday_courier">
                    <label id="everyday_courier_opentime" for="password-confirm">@lang('store.admin.shops.shop_open_time')</label>
                    <input id="everyday" type="checkbox" checked class="form-control" name="everyday" value="1" >
                </div>
                <div id="hours_opening_courier">
                    @foreach($Days as $dky=>$day)
                        <div class="form-row @if($dky=='ALL') everyday "  @else  singleday " style="display:none" @endif " >
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="hours_opening">{{$day}}</label>
                                    <input type="checkbox" class="chk form-control {{$dky}}" @if($dky=='ALL') checked @endif  name="day[{{$dky}}]" value="{{$dky}}" data-placement="top" data-autoclose="true" >
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="hours_opening" class="required">@lang('store.admin.shops.open_time')</label>

                                    <div class="input-group">
                                        <input type="text" class="form-control time-picker open_{{$dky}}" name="hours_opening[{{$dky}}]" value="00:00" data-placement="top" data-autoclose="true" required>
                                        <span class="input-group-addon">
                                            <i class="fa fa-clock-o"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="hours_closing" class="required">@lang('store.admin.shops.close_time')</label>

                                    <div class="input-group">
                                        <input type="text" class="form-control time-picker close_{{$dky}}" name="hours_closing[{{$dky}}]" value="00:00" data-placement="top" data-autoclose="true" required>
                                        <span class="input-group-addon">
                                            <i class="fa fa-clock-o"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <button type="submit" class="btn btn-accent">{{$action_text}} {{ __('Shops') }}</button>
                <button type="reset" class="btn btn-danger cancel">{{ __('Cancel') }}</button>


            </form>
        </div>
    </div>
</div>

<link rel="stylesheet" href="{{ asset('assets/plugins/clockpicker/dist/bootstrap-clockpicker.min.css') }}">

<script type="text/javascript" src="{{ asset('assets/plugins/clockpicker/dist/bootstrap-clockpicker.min.js') }}"></script>
@include('common.admin.includes.redirect')
<script>
var blobImage = '';
var blobName = '';
$(document).ready(function()
{

    $(".phone").intlTelInput({
     /* initialCountry: "<?php echo isset(Helper::getSettings()->site->country_code)?Helper::getSettings()->site->country_code :'in'; ?>",*/
    });

    $('.picture_upload').on('change', function(e) {
      var files = e.target.files;
      console.log(files);
      var obj = $(this);
      var size = (files[0].size / 1024000);
      if(size > 10.0)
      {
        $('#img_error').css('display','block');
      }
      else if (files && files.length > 0) {
        $('#img_error').css('display','none');
        blobName = files[0].name;
         cropImage(obj, files[0], obj.closest('.image-placeholder').find('img'), function(data) {
            blobImage = data;
         });
      }
   });

     basicFunctions();
     var id = "";

     $.ajax({
        type:"GET",
        url: getBaseUrl() + "/admin/store/storetypelist",
        headers: {
            Authorization: "Bearer " + getToken("admin")
        },
        'beforeSend': function (request) {
                showInlineLoader();
            },
        success:function(data){
                $("#store_type_id").empty();
                $("#store_type_id").append('<option value="">Select</option>');
                var data = parseData(data);
                $.each(data.responseData,function(key,item){
                  if(item.length !=0){
                    $("#store_type_id").append('<option value="'+item.id+'" data-name="'+item.name_en+'" data-category="'+item.category+'">'+item.name+'</option>');
                  }
                });
                hideInlineLoader();
             }

    });

    $('#city_id').on('change', function(){
        var city_id =$("#city_id").val();
        $.ajax({
            type:"GET",
            url: getBaseUrl() + "/admin/zonetype/"+city_id+"?type=SHOP",
            headers: {
                Authorization: "Bearer " + getToken("admin")
            },
            'beforeSend': function (request) {
                showInlineLoader();
            },
            success:function(response){
                var data = parseData(response);
                $("#zone_id").empty();
                $("#zone_id").append('<option value="">Select</option>');
                $.each(data.responseData,function(key,item){
                 $("#zone_id").append('<option value="'+item.id+'">'+item.name+'</option>');
                });

                hideInlineLoader();
            }
        });
      });

    $('.clockpicker').clockpicker({
        donetext: "Done"
    });

    $('#country_id').on('change', function(){
        var currency = $(this).find(':selected').data('currency');
        $('#currency_country').html(currency);
        var country_id =$("#country_id").val();
        $.ajax({
            type:"GET",
            url: getBaseUrl() + "/admin/countrycities/"+country_id,
            headers: {
                Authorization: "Bearer " + getToken("admin")
            },
            'beforeSend': function (request) {
                showInlineLoader();
            },
            success:function(response){
                var data = parseData(response);
                $("#city_id").empty();
                $("#city_id").append('<option>Select</option>');
                $.each(data.responseData,function(key,item){
                    $("#city_id").append('<option value="'+item.city.id+'">'+item.city.city_name+'</option>');
                });

                hideInlineLoader();
            }
        });
    });



   $('#store_type_id').change(function(){

    var cuisine_id=$(this).val();
    var store_type = $('#store_type_id').find(':selected').data('category');
        // alert(store_type);
    if(store_type == 'OTHERS'){
        $("#isVeg").css("display", "none");
    }else{
        $("#isVeg").css("display", "block");
    }

    $.ajax({
        type:"GET",
        url: getBaseUrl() + "/admin/store/cuisinelist/"+cuisine_id,
        headers: {
            Authorization: "Bearer " + getToken("admin")
        },
        'beforeSend': function (request) {
                showInlineLoader();
            },
        success:function(data){
                $("#cuisine_id").empty();
                $.each(data.responseData,function(key,item){
                  if(item.length !=0){
                    $("#cuisine_id").append('<option value="'+item.id+'">'+item.name+'</option>');
                  }
                });
                loadstorecategory();
                hideInlineLoader();
             }
    });


   })

   /*$('.clockpicker').clockpicker({
        donetext: "Done"
    });*/

    $('#everyday').change(function() {
        if($(this).is(":checked")) {
            $('.everyday').show();
            $('.singleday').hide();
            $('.singleday .chk').prop('checked',false);
            $('.everyday .chk').prop('checked',true);
        }else{
            $('.everyday').hide();
            $('.singleday').show();
            $('.everyday .chk').prop('checked',false);
            $('.singleday .chk').prop('checked',true);
        }
    });



     if($("input[name=id]").length){
        // alert('Agilan');
        $('#country_id').attr('readonly',true);
        $('#country_id').css('pointer-events','none');
        id = "/"+ $("input[name=id]").val();
        var url = getBaseUrl() + "/admin/store/shops"+id;

        $.ajax({
        type:"GET",
        url: url,
        headers: {
            Authorization: "Bearer " + getToken("admin")
        },
        'beforeSend': function (request) {
                showInlineLoader();
            },
        success:function(response){
            var data = parseData(response).responseData;
            for (var i in Object.keys(data)) {
            $('#'+Object.keys(data)[i]).val( Object.values(data)[i]);
             }
            var countryData = window.intlTelInputGlobals.getCountryData();
            var result = $.grep(countryData, function(e){ return e.dialCode == data.country_code; });
            $(".phone").intlTelInput("setCountry", result[0].iso2);

            $("select[name=store_type_id] option[value='" + data.store_type_id+ "']" ).prop("selected",true);
            //$("select[name=store_type_id]").trigger('change');

             //alert(data.country_id);
             $('#country_id option[value="'+data.country_id+'"]').prop('selected', true);
             loadcity(data.city_data,data.city_id);
             loadzone(data.zone_data,data.zone_id);
              loadcuisines(data.cuisine_data,data.cui_selectdata);
             $("input[name='is_veg'][value='"+data.is_veg +"']").prop('checked', true);
             $("input[name='free_delivery'][value='"+data.free_delivery +"']").prop('checked', true);
            //  $('.is_veg').val(data.is_veg).attr("checked", true);
             $('#password').val("");
             $("#password").rules('remove', 'required');
            $("#confirmpassword").rules('remove', 'required');
            // alert(data);
            if(data.picture){
                $('.image-placeholder img').attr('src', data.picture);
            }

            if(data.time_data[0].store_day=='ALL'){
                $('#everyday').val(1).attr('checked',true);
                $('.open_ALL').val(data.time_data[0].store_start_time);
                $('.close_ALL').val(data.time_data[0].store_end_time);
            }else{
                $('#everyday').trigger('click');
                $('.chk').prop('checked',false);
                $.each(data.time_data,function(key,day){
                $('.open_'+day.store_day).val(day.store_start_time);
                $('.close_'+day.store_day).val(day.store_end_time);
                $('.'+day.store_day).prop('checked',true);
                });
            }
            loadstorecategory();
            hideInlineLoader();
            var currency = $("#country_id").find(':selected').data('currency');
            $('#currency_country').html(currency);
        }
    });

     }

     function loadcity(city_data,city_id){
        $.each(city_data,function(key,item){
            var selected="";
           if(city_id==item.city.id){
               selected="selected";

            }
            $("#city_id").append('<option value="'+item.city.id+'" '+selected+ ' >'+item.city.city_name+'</option>');
        });
     }

     function loadcuisines(cuisines_data,cuisines_id){
         $.each(cuisines_data,function(key,item){
            $("#cuisine_id").append('<option value="'+item.id+'">'+item.name+'</option>');
         });
         $('#cuisine_id').val(cuisines_id);
    }

    function loadzone(zone_data,zone_id){
        $.each(zone_data,function(key,item){
            var selected="";
            if(zone_id==item.id){
               selected="selected";
            }
            $("#zone_id").append('<option value="'+item.id+'" '+selected+ ' >'+item.name+'</option>');
        });
    }

    function loadstorecategory(){
        var store_type = $('#store_type_id').find(':selected').data('category');
        var store_type_name = $('#store_type_id').find(':selected').data('name');
        if(store_type == "OTHERS"){
            if(store_type_name == "courier"){
                $("#estimated_delivery_time").val('');
                $('.is_veg input').prop('checked', false);
                $("#estimated_delivery_time").rules('remove', 'required');
                $("#is_veg").rules('remove', 'required');
                $("#estdeltime").css("display", "none");
                $("#cuisine").css("display", "none");
                $("#isVeg").css("display", "none");
                $("#time").css("display", "none");
                $("#everyday").css("display", "none");
                $("#hours_opening_courier").css("display", "none");
                $("#everyday_courier_opentime").css("display", "none");
                $("#packing_charges").html("Shipping Charges (<span id='currency_country'>$</span>)");
            }
            else{
                $("#estimated_delivery_time").val('');
                $('.is_veg input').prop('checked', false);
                $("#estimated_delivery_time").rules('remove', 'required');
                $("#is_veg").rules('remove', 'required');
                $("#estdeltime").css("display", "none");
                $("#cuisine").css("display", "none");
                $("#isVeg").css("display", "none");
                $("#packing_charges").html("Shipping Charges (<span id='currency_country'>$</span>)");
            }
        } else{
            // $("#estimated_delivery_time").val('');
            $('.is_veg input').prop('checked', true);
            $("#estimated_delivery_time").rules('add', 'required');
            $("#is_veg").rules('add', 'required');
            $("#estdeltime").css("display", "block");
            $("#cuisine").css("display", "block");
            $("#isVeg").css("display", "block");
            $("#packing_charges").html("Packing Charges (<span id='currency_country'>$</span>)");
        }
    }



     $('.validateForm').validate({
		errorElement: 'span', //default input error message container
		errorClass: 'help-block', // default input error message class
		focusInvalid: false, // do not focus the last invalid input
		rules: {
            store_name: { required: true },
            store_type_id: { required: true },
            is_veg: { required: true },
            email: { required: true },
            country_id: { required: true },
            city_id: { required: true },
            estimated_delivery_time: { required: true },
            contact_number: { required: true },
            store_location: { required: true },
            password: { required: true },
            confirmpassword: { equalTo: "#password" },
            zone_id: { required: true },

		},

		messages: {
			store_name: { required: "Shop Name is required." },
			store_type_id: { required: "Store Type is required." },
            is_veg: { required: "Veg Type is required." },
            email: { required: " Email is required." },
            country_id: { required: "country is required." },
            city_id: { required: "city is required." },
            estimated_delivery_time: { required:"Delivery Time is required."},
            contact_number: { required: "Contact Number is required." },
            store_location: { required: "Location is required." },
            password: { required: "Password is required." },
            zone_id: { required: "Zone is required." },


		},
		highlight: function(element)
		{
			$(element).closest('.form-group').addClass('has-error');
		},

		success: function(label) {
			label.closest('.form-group').removeClass('has-error');
			label.remove();
		},

		submitHandler: function(form) {
            var data = new FormData();
            var formGroup = $(".validateForm").serialize().split("&");
            for(var i in formGroup) {
                var params = formGroup[i].split("=");
                data.append(decodeURIComponent(params[0]), decodeURIComponent(params[1]) );
            }
            if(blobImage != "") data.append('picture', blobImage, blobName);
            data.append( 'country_code', $('.phone').intlTelInput('getSelectedCountryData').dialCode );
            var url = getBaseUrl() + "/admin/store/shops"+id;
            saveRow( url, table, data);
		}
    });

    $('.cancel').on('click', function(){
        $(".crud-modal").modal("hide");
    });


});
</script>
<script>
    var map;
    var input = document.getElementById('store_location');
    var latitude = document.getElementById('latitude');
    var longitude = document.getElementById('longitude');
    var address = document.getElementById('store_location');

    function initMap() {

        var userLocation = new google.maps.LatLng(
                13.0796758,
                80.2696968
            );

        map = new google.maps.Map(document.getElementById('map'), {
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
                marker.setPosition(userLocation);
                map.setCenter(userLocation);
                map.setZoom(13);
            });
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

        function updateForm(lat, lng, addr) {

            latitude.value = lat;
            longitude.value = lng;
            address.value = addr;
        }
    }
</script>
<script src="https://maps.googleapis.com/maps/api/js?key={{Helper::getSettings()->site->browser_key}}&libraries=places&callback=initMap" async defer></script>

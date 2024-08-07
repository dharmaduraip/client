<div class="user_dashboard">
	<div class="container no_pad">
		<div class="user_detl col-xs-12">
			<div class="name-edit-prof">Delivery With Tastyeats</div>
			<div class="number-email-prof">Be a part of the product tech industry. Be a part of the future.</div>
		</div>
	</div>
</div>


<section>
    <div class="container partner">
        <div class="row">
            <div class="col-md-12">

                @if (session('message') && session('message') == 'success')   
                <div class="alert alert-success">
                 <h3 class="text-center"> {{ session('message') }} </h3>
             </div>
             <a href="{{ \URL::to('/') }}" class="btn btn-primary" style="margin-left: 40%;">Go To Main Page</a>
             <br><br><br>
             @endif
             @if (session('flag') && session('flag') == 'error')   
             <div class="alert alert-danger">
                {{ session('msg') }}
            </div>
            @endif
            @if(\Auth::check())
            <input type="hidden" class="d_active" id ="d_active" name="d_active" value="{{\Auth::user()->d_active}}">
            @if(\Auth::user()->d_active != '0' && \Auth::user()->d_active != '3')
            <div class="col-md-6 form-group">You are already a Delivery boy</div>
            @endif
            @if(\Auth::user()->d_active == '3')
            <div class="col-md-6 form-group">Waiting for approval</div>
            @endif
            @endif
            <div class="panel panel-default">
                <div class="panel-body"><form action="{{ \URL::to('/boyregisteration') }}" enctype="multipart/form-data" method="post"><input name="_token" type="hidden" value="{{csrf_token()}}" data-parsley-validate="" />

                   <!--  <div class="col-md-6 form-group yournumber"  align="center">Enter your number<input class="form-control allownumericwithoutdecimal yournumber" name="restaurant_name"  type="text" maxlength="10" id="phone_number" value="{!! old('restaurant_name') !!}"  />
                   <input type="button" class="submit" id ="submit" name="submit" value="submit">
                    </div> -->
                      <input class="form-control" name ="segment" id ="segment"  required="" type="hidden" value="{{Request::segment(1)}}"  />
                    <div class="row">
                        <div class="col-md-6 form-group"><label for="">User Name</label> <br /> <input class="form-control inputdisabled" name="username" required="" type="text" @if(\Auth::check()) value="{{\Auth::user()->username}}" @else value="" @endif  /></div>
                        <div class="col-md-6 form-group"><label for="">Choose Id</label> <br /> 
                           <select name='id_type' id='id_type' class="form-control inputdisabled" rows='5' id='id_type' class='select2 ' required   >
                           	<option value="">Select</option>
                           	<option value="NRIC">NRIC</option>
                           	<option value="Old IC">Old IC</option>
                           	<option value="Passport">Passport</option>
                           	<option value="BRN">BRN</option>
                           	<option value="Police Id">Police Id</option>
                           	<option value="Army Id">Army Id</option>
                           </select> 
                    </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 form-group"><label for="">Id Number</label> <br /> <input class="form-control inputdisabled" name="id_num" required="" type="text" value=""  /></div>
                        <div class="col-md-6 form-group"><label for="">Do You have your own motorbike?</label> <br /> 
                         <select name='Bank_Name' id='Bank_Name' class="form-control inputdisabled" rows='5' id='Bank_Name' class='select2 '   >
                           	<option value="">Select</option>
                           	<option value='yes'>Yes</option>
                           	<option value='no'>No</option>
                           </select> </div>
                    </div>
                    <div class="row" >
							<div class="col-md-6 form-group"><label for="">Address</label> <br /> 
								{!! Form::text('location', '',array('class'=>'form-control yourlocation', 'placeholder'=>'', 'required'=>'true' ,'id'=>'txtPlaces' )) !!} 
								<div id="fn_map" style="display: none;"><a href="javascript:" class="fn_map_modal">Click Here to view Exact location</a></div>
								<div class="loc_error"></div>
							</div> 
							<div class=""></div>
						</div> 	
                    <br>        

                    <input type="hidden" class="validate" name="latitude" id="lat" value="">
                    <input type="hidden" class="validate" name="longitude" id="lang" value="">
                    <input type="hidden" name="flatno" id="flatno" value="">
                    <input type="hidden" name="adrs_line1" id="adrs_line1" value="">
                    <input type="hidden" name="adrs_line2" id="adrs_line2" value="">
                    <input type="hidden" name="sub_loc_level" id="sub_loc_level" value="">
                    <input type="hidden" name="city" id="city" value="">
                    <input type="hidden" name="state" id="state" value="">
                    <input type="hidden" name="country" id="country" value="">
                    <input type="hidden" name="zipcode" id="zipcode" value="">   
                    <div class="form-group text-center"><button class="btn btn-primary submit1" style="background: #051e3b;">Submit</button></div>
                </form></div>
                <div class="panel-footer">

                </div>
            </div>
        </div>
    </div>
<div id="map_modal" class="modal fade" role="dialog" >
	<div class="modal-dialog">
		<style>#myMap {max-width:100%;height: 350px;width: 520px;z-index:999999;}</style>
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">×</button>
				<h4 class="modal-title">Map</h4>
			</div>
			<div class="modal-body">
				<div id="myMap"></div><br/>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>

</section>

<?php 
$keys = \AbserveHelpers::site_setting('googlemap_key');
?>

<script src="https://maps.google.com/maps/api/js?libraries=places&region=uk&language=en&sensor=true&key={{$keys->googlemap_key}}">
</script>
<script>

	$("document").ready(function() {
		setTimeout(function() {
			$(".signup-show").trigger('click');
		},1000);
	});
	$('.overlay').addClass('pointer-event');
	$('.closeicon2').click(function(){
		window.location.href="{{URL::to('/')}}";
	});
//     $("#submit").click(function () {
//      var phone = $('#phone_number').val();
//      if(phone.length<10){
//          alert("please enter 10 numbers");
//      } else{   
//         $.ajax({
//             type : 'POST',
//             url:base_url+"user/checkphone",
//             data : {'phone':phone},
//             success: function (data) {
//                 if(data == 1){
//                    $('.loginhomeslide').trigger('click');
//                    $('#mobile').val(phone);
//                    $('.login_otp_check').prop('enabled','true');
//                    $('#newdeliveryboy').val('1');                                         
//                    $('.login_otp_check').trigger('click');  
//                } else
//                {
//                 $('.signup-show').trigger('click');
//                 $('.phone').val(phone);
//                 $('.reg_otp_check').prop('enabled','true');
//                 $('#newdeliveryboy').val('1');
//                 $('.reg_otp_check').trigger('click');   
//               }
//         } 
//     });    
//     }
// });

    $(".allownumericwithoutdecimal").on("keypress keyup blur",function (event) {    
        $(this).val($(this).val().replace(/[^\d].+/, ""));
        if(event.which == 8){

        } else if((event.which < 48 || event.which > 57 )) {
            event.preventDefault();
        }
    });
    var loggedIn = {{ auth()->check() ? '1' : '0' }};
    if(loggedIn == '1'){
        var d_active = $('#d_active').val();
        var deliverylog = (d_active == '0') ? '0' : '1';
        if(deliverylog == '1'){
            $(".inputdisabled").prop('disabled', true);
            $("#Bank_Name").prop('disabled',true);
            $(".yournumber").hide();
            $(".yourlocation").prop('disabled',true);
            $(".submit1").prop('disabled',true);
        } else {
           $(".yournumber").hide();
       }
   }
    var loggedIn1 = {{ auth()->check() ? '1' : '0' }};
   if(loggedIn1 == '0'){
    $(".inputdisabled").prop('disabled', true);
    $("#Bank_Name").prop('disabled',true);
    $(".yournumber").prop('disabled',false);
    $(".submit").prop('disabled',false);
    $(".yourlocation").prop('disabled',true);
    $(".submit1").prop('disabled',true);

}


	
</script>
<script type="text/javascript">
	var IsplaceChange = true;
	$(document).ready(function () {

		if($('#lat').val() != '' || $('#lang').val() != '' ){
			$('#fn_map').show();
		} else {
			$('#fn_map').hide();
		}
		var input = document.getElementById('txtPlaces');
		var autocomplete = new google.maps.places.Autocomplete(document.getElementById('txtPlaces'));
		google.maps.event.addListener(autocomplete, 'place_changed', function () {
			var place		= autocomplete.getPlace();
			var latitude	= place.geometry.location.lat();
			var longitude	= place.geometry.location.lng();
			var components = place.address_components;
			$("#flatno").val('');
			$("#adrs_line1").val('');
			$("#adrs_line2").val('');
			$("#sub_loc_level").val('');
			$("#city").val('');
			$("#state").val('');
			$("#country").val('');
			$("#zipcode").val('');
			for(var i = 0,component; component = components[i]; i++) {
				if(component.types[0] == 'street_number'){
					$("#flatno").val(component['long_name']);
				}
				if(component.types[0] == 'route'){
					$("#adrs_line1").val(component['long_name']);
				}
				if(component.types[0] == 'neighborhood'){
					$("#adrs_line2").val(component['long_name']);
				}
				if(component.types[0] == 'sublocality_level_1'){
					$("#sub_loc_level").val(component['long_name']);
				}
				if(component.types[0] == 'locality'){
					$("#city").val(component['long_name']);
				}
				if(component.types[0] == 'administrative_area_level_1'){
					$("#state").val(component['long_name']);
				}
				if(component.types[0] == 'country'){
					$("#country").val(component['long_name']);
				}
				if(component.types[0] == 'postal_code'){
					$("#zipcode").val(component['long_name']);
				}
			}
			$('#lat').val(latitude);
			$('#lang').val(longitude);
			IsplaceChange	= true;
			if($('#lat').val() != '' || $('#lang').val() != '' ){
				$('#fn_map').show();
			} else {
				$('#fn_map').hide();
			}
		});

		$("#txtPlaces").keydown(function () {
			IsplaceChange	= false;
		});
		$("#txtPlaces").focusout(function () {	    
			if (IsplaceChange) {
				$('#fn_map').show();
			} else {
				$('#lat').val('');
				$('#lang').val('');
				$('#fn_map').hide();
			}

		});
			
	});
</script>
<script>

	$(".fn_map_modal").click(function(){
		initialize();
		$("#map_modal").modal("show");
	});

	var map;
	var marker;
	var myLatlng = new google.maps.LatLng($('#lat').val(),$('#lang').val());
	var geocoder = new google.maps.Geocoder();
	var infowindow = new google.maps.InfoWindow();
	function initialize(){

		var mapOptions = {
			zoom: 15,
			center: new google.maps.LatLng($('#lat').val(),$('#lang').val()),
			mapTypeId: google.maps.MapTypeId.ROADMAP
		};
		map = new google.maps.Map(document.getElementById("myMap"), mapOptions);

		marker = new google.maps.Marker({
			map: map,
			position: new google.maps.LatLng($('#lat').val(),$('#lang').val()),
			draggable: true 
		});     

		geocoder.geocode({'latLng': myLatlng }, function(results, status) {
			if (status == google.maps.GeocoderStatus.OK) {
				if (results[0]) {
					$('#lat').val(marker.getPosition().lat());
					$('#lang').val(marker.getPosition().lng());
					var components = results[0].address_components;
					$("#flatno").val('');
					$("#adrs_line1").val('');
					$("#adrs_line2").val('');
					$("#sub_loc_level").val('');
					$("#city").val('');
					$("#state").val('');
					$("#country").val('');
					$("#zipcode").val('');
					for(var i = 0,component; component = components[i]; i++) {
						if(component.types[0] == 'street_number'){
							$("#flatno").val(component['long_name']);
						}
						if(component.types[0] == 'route'){
							$("#adrs_line1").val(component['long_name']);
						}
						if(component.types[0] == 'neighborhood'){
							$("#adrs_line2").val(component['long_name']);
						}
						if(component.types[0] == 'sublocality_level_1'){
							$("#sub_loc_level").val(component['long_name']);
						}
						if(component.types[0] == 'locality'){
							$("#city").val(component['long_name']);
						}
						if(component.types[0] == 'administrative_area_level_1'){
							$("#state").val(component['long_name']);
						}
						if(component.types[0] == 'country'){
							$("#country").val(component['long_name']);
						}
						if(component.types[0] == 'postal_code'){
							$("#zipcode").val(component['long_name']);
						}
					}
				}
			}
		});


		google.maps.event.addListener(marker, 'dragend', function() {

			geocoder.geocode({'latLng': marker.getPosition()}, function(results, status) {
				if (status == google.maps.GeocoderStatus.OK) {
					if (results[0]) {
						$('#txtPlaces').val(results[0].formatted_address);
						$('#lat').val(marker.getPosition().lat());
						$('#lang').val(marker.getPosition().lng());
						var components = results[0].address_components;
						$("#flatno").val('');
						$("#adrs_line1").val('');
						$("#adrs_line2").val('');
						$("#sub_loc_level").val('');
						$("#city").val('');
						$("#state").val('');
						$("#country").val('');
						$("#zipcode").val('');
						for(var i = 0,component; component = components[i]; i++) {
							if(component.types[0] == 'street_number'){
								$("#flatno").val(component['long_name']);
							}
							if(component.types[0] == 'route'){
								$("#adrs_line1").val(component['long_name']);
							}
							if(component.types[0] == 'neighborhood'){
								$("#adrs_line2").val(component['long_name']);
							}
							if(component.types[0] == 'sublocality_level_1'){
								$("#sub_loc_level").val(component['long_name']);
							}
							if(component.types[0] == 'locality'){
								$("#city").val(component['long_name']);
							}
							if(component.types[0] == 'administrative_area_level_1'){
								$("#state").val(component['long_name']);
							}
							if(component.types[0] == 'country'){
								$("#country").val(component['long_name']);
							}
							if(component.types[0] == 'postal_code'){
								$("#zipcode").val(component['long_name']);
							}
						}
					}
				}
			});
		});
		google.maps.event.addListener(map, 'click', function (event) {
			$('#mlatitude').val(event.latLng.lat());
			$('#mlongitude').val(event.latLng.lng());
			placeMarker(event.latLng);
			geocoder.geocode({'latLng': marker.getPosition()}, function(results, status) {
				if (status == google.maps.GeocoderStatus.OK) {
					if (results[0]) {
						$('#txtPlaces').val(results[0].formatted_address);
						$('#lat').val(marker.getPosition().lat());
						$('#lang').val(marker.getPosition().lng());
						var components = results[0].address_components;
						$("#flatno").val('');
						$("#adrs_line1").val('');
						$("#adrs_line2").val('');
						$("#sub_loc_level").val('');
						$("#city").val('');
						$("#state").val('');
						$("#country").val('');
						$("#zipcode").val('');
						for(var i = 0,component; component = components[i]; i++) {
							if(component.types[0] == 'street_number'){
								$("#flatno").val(component['long_name']);
							}
							if(component.types[0] == 'route'){
								$("#adrs_line1").val(component['long_name']);
							}
							if(component.types[0] == 'neighborhood'){
								$("#adrs_line2").val(component['long_name']);
							}
							if(component.types[0] == 'sublocality_level_1'){
								$("#sub_loc_level").val(component['long_name']);
							}
							if(component.types[0] == 'locality'){
								$("#city").val(component['long_name']);
							}
							if(component.types[0] == 'administrative_area_level_1'){
								$("#state").val(component['long_name']);
							}
							if(component.types[0] == 'country'){
								$("#country").val(component['long_name']);
							}
							if(component.types[0] == 'postal_code'){
								$("#zipcode").val(component['long_name']);
							}
						}
					}
				}
			});
		});

	}
	google.maps.event.addDomListener(window, "resize", resizingMap());

	$('#map_modal').on('show.bs.modal', function() {
		resizeMap();
	})

	function resizeMap() {
		if(typeof map =="undefined") return;
		setTimeout( function(){resizingMap();} , 400);
	}

	function resizingMap() {
		if(typeof map =="undefined") return;
		var center = new google.maps.LatLng($('#lat').val(),$('#lang').val());
		google.maps.event.trigger(map, "resize");
		map.setCenter(center); 
	}
	google.maps.event.addDomListener(window, 'load', initialize);
	function placeMarker(location) {
		if (marker == undefined){
			marker = new google.maps.Marker({
				position: location,
				map: map, 
				animation: google.maps.Animation.DROP,
			});
		} else {
			marker.setPosition(location);
		}
		map.setCenter(location);
	}
</script>
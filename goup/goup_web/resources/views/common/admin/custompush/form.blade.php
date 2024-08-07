{{ App::setLocale(  isset($_COOKIE['admin_language']) ? $_COOKIE['admin_language'] : 'en'  ) }}
<div class="row mb-4">
    <div class="col-md-12">
        <div class="card-header border-bottom">
			@if(empty($id))
                @php($action_text=__('admin.add'))
            @else
                @php($action_text=__('admin.edit'))
                    
            @endif
            <h6 class="m-0"style="margin:10!important;">{{$action_text}} {{ __('Custom Push') }}</h6>
        </div>
        <div class="form_pad">
            <form class="validateForm" method="POST" role="form" id="create_push">
                @csrf()
                @if(!empty($id))
                    <input type="hidden" name="_method" value="PATCH">
                    <input type="hidden" name="id" value="{{$id}}">
                @endif
               
                <div class="form-row">
                    <div class="form-group col-md-12">
                        <label class="col-xs-2 col-form-label">@lang('admin.push.Sent_to')</label>
						<div class="col-xs-10">
							<select class="form-control" name="send_to" onchange="switch_send(this.value)">
								<option value="ALL">All Users and Drivers</option>
								<option value="USERS">All Users</option>
								<option value="PROVIDERS">All Drivers</option>
							</select>
						</div>
                    </div>
                </div>
                <div class="form-row">
                     <div class="form-group row" id="for_users" style="display: none;">
						<label class="form-group col-md-12 col-form-label">{{ __('User Conditions') }}</label>
						<div class="form-group col-md-6">
							<select class="form-control" name="user_condition" onchange="switch_user_condition(this.value);">
								<option value="">NONE</option>
								<option value="ACTIVE">who were active for </option>
								<option value="LOCATION"> who are in </option>
								<option value="RIDES">who most used our service more than </option>
								<!-- <option value="AMOUNT"> who spent more than </option> -->
							</select>
						</div>
						<div class="form-group col-md-4" id="user_active" style="display: none;">
							<select class="form-control" name="user_active">
								<option value="HOUR">Last one hour</option>
								<option value="WEEK">Last Week </option>
								<option value="MONTH">Last Month </option>
							</select>
						</div>

						<div class="form-group col-md-4" id="user_rides"  style="display: none;">
							<input type="number" class="form-control" name="user_rides" placeholder="Number of Rides">
						</div>

						<div class="form-group col-md-4" id="user_amount" style="display: none;">
							<input type="number" class="form-control" name="user_amount" placeholder="Amount Spent">
						</div>

						<div class="form-group col-md-4" id="user_location" style="display: none;">
							<input type="text" class="form-control"  name="user_location" id="search_location" placeholder="Enter Location">
							<input type="hidden" name="user_location" id="user_point">
						</div>

					</div>
                </div>
                <div class="form-row">
                    <div class="form-group row" id="for_providers" style="display: none;">
						<label class="form-group col-md-12 col-form-label">{{ __('Driver Conditions') }}</label>
						<div class="col-md-6">
							<select class="form-control" name="provider_condition" onchange="switch_provider_condition(this.value);">
								<option value="">NONE</option>
								<option value="ACTIVE">who were active for </option>
								<option value="LOCATION"> who are in </option>
								<option value="RIDES">who most serviced more than </option>
								<!-- <option value="AMOUNT">  who earned more than </option> -->
							</select>
						</div>
						<div class="form-group col-md-4" id="provider_active" style="display: none;">
							<select class="form-control" name="provider_active">
								<option value="HOUR">Last one hour</option>
								<option value="WEEK">Last Week </option>
								<option value="MONTH">Last Month </option>
							</select>
						</div>

						<div class="form-group col-md-4" id="provider_rides"  style="display: none;">
							<input type="number" class="form-control" name="provider_rides" placeholder="Number of Rides">
						</div>

						<div class="form-group col-md-4" id="provider_amount" style="display: none;">
							<input type="number" class="form-control" name="provider_amount" placeholder="Amount Spent">
						</div>

						<div class="form-group col-md-4" id="provider_location" style="display: none;">
							<input type="text" class="form-control" name="provider_location" id="search_provider_location" placeholder="Enter Location">
							 <input type="hidden" name="provider_location" id="provider_point">
						</div>

					</div>
				</div>
                <div class="form-row">
                    <div class="form-group col-md-12">  
                        <label for="message" class="col-xs-2 col-form-label">@lang('admin.push.message')</label>
						<div class="col-xs-10">
							<textarea maxlength="200" class="form-control" rows="3" name="message" required id="message" placeholder="Enter Message" ></textarea>
							<div id="characterLeftDesc"></div>
						</div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-12">
                        <!-- <label for="zipcode" class="col-xs-2 col-form-label"></label> -->
						<div class="col-xs-12">	
						   						
							<button type="submit" class="btn btn-primary">{{$action_text}} @lang('admin.push.Push_Now')</button>
							&nbsp;
							<button data-toggle="modal" data-target="#schedule_modal" type="button" class="btn btn-success">@lang('admin.push.Schedule_Push')</button>
						   <button type="reset" class="btn btn-danger cancel pull-right">Cancel</button>
						</div>  
                    </div> 
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">  
                    </div>
                </div>
                <br>
                <!-- <button type="reset" class="btn btn-danger cancel">Cancel</button>
                <button type="submit" class="btn btn-accent float-right">Add CustomPush</button> -->
     <!-- Schedule Modal -->
		<div id="schedule_modal" class="modal fade schedule-modal" role="dialog">
		<div class="modal-dialog">

			<!-- Modal content-->
			<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close schedule_close">&times;</button>
				<h4 class="modal-title">{{ __('Schedule Push Notification') }}</h4>
			</div>
			<form>
				<div class="modal-body">
					
					<label>Date</label>
					<input value="" class="form-control" type="text" id="datepicker" placeholder="Date" name="schedule_date">
					<label>Time</label>
					<input value="" class="form-control" type="text" id="timepicker" placeholder="Time" name="schedule_time">

				</div>
				<div class="modal-footer">
					<button type="reset" class="btn btn-danger schedule_close">{{ __('Cancel') }}</button>	
					<button type="button" id="schedule_button" class="btn btn-default">{{ __('Schedule Push') }}</button>
				</div>
			</form>
			</div>

		</div>
		</div>
  </div>
</div>
<style type="text/css">
	.pac-container{
		z-index: 99999999999!important;
	}
</style>
@include('common.admin.includes.redirect')
<script>
		function switch_send(send_value){
			if(send_value == 'USERS'){
				$('#for_users').show();
				$('#for_providers').hide();
			}else if(send_value == 'PROVIDERS'){
				$('#for_users').hide();
				$('#for_providers').show();
			}else{
				$('#for_users').hide();
				$('#for_providers').hide();    
			}
		}
		function switch_user_condition(condition_value){
			if(condition_value == 'ACTIVE'){
				$('#user_active').show();
				$('#user_location').hide();
				$('#user_amount').hide();
				$('#user_rides').hide();
			}else if(condition_value == 'LOCATION'){
				$('#user_active').hide();
				$('#user_location').show();
				$('#user_amount').hide();
				$('#user_rides').hide();
			}else if(condition_value == 'AMOUNT'){
				$('#user_active').hide();
				$('#user_location').hide();
				$('#user_amount').show();
				$('#user_rides').hide();
			}else if(condition_value == 'RIDES'){
				$('#user_active').hide();
				$('#user_location').hide();
				$('#user_amount').hide();
				$('#user_rides').show();
			}else{
				$('#user_active').hide();
				$('#user_location').hide();
				$('#user_amount').hide();
				$('#user_rides').hide();
			}
		}
		function switch_provider_condition(condition_value){
			if(condition_value == 'ACTIVE'){
				$('#provider_active').show();
				$('#provider_location').hide();
				$('#provider_amount').hide();
				$('#provider_rides').hide();
			}else if(condition_value == 'LOCATION'){
				$('#provider_active').hide();
				$('#provider_location').show();
				$('#provider_amount').hide();
				$('#provider_rides').hide();
			}else if(condition_value == 'AMOUNT'){
				$('#provider_active').hide();
				$('#provider_location').hide();
				$('#provider_amount').show();
				$('#provider_rides').hide();
			}else if(condition_value == 'RIDES'){
				$('#provider_active').hide();
				$('#provider_location').hide();
				$('#provider_amount').hide();
				$('#provider_rides').show();
			}else{
				$('#provider_active').hide();
				$('#provider_location').hide();
				$('#provider_amount').hide();
				$('#provider_rides').hide();
			}
		}
		$('#schedule_button').click(function(){
			$("#schedule_modal").modal("hide");
                $("#datepicker").clone().attr('type','hidden').appendTo($('#create_push'));
                $("#timepicker").clone().attr('type','hidden').appendTo($('#create_push'));
                //document.getElementById('create_push').submit();
					var formGroup = $(".validateForm").serialize().split("&");
					var data = new FormData();
					for(var i in formGroup) {
						var params = formGroup[i].split("=");
						data.append( params[0], decodeURIComponent(params[1]) );
					}
					var url = getBaseUrl() + "/admin/custompush";
					saveRow( url, table, data);
        });
		var date = new Date();
        date.setDate(date.getDate()-1);
        $('#datepicker').datepicker({  
            startDate: date
        });
        $('#timepicker').timepicker({showMeridian : false});
	

$(document).ready(function()
{
	
	basicFunctions();
	
	

    $('#characterLeftDesc').text('100 characters left');

	$('#message').keyup(function () {
	    var max = 100;
	    var len = $(this).val().length;
	    if (len >= max) {
	        $('#characterLeftDesc').text(' You have reached the limit');
	    } else {
	        var ch = max - len;
	        $('#characterLeftDesc').text(ch + ' characters left');
	    }
	});
	 var id = "";
	
     if($("input[name=id]").length){
        id = "/"+ $("input[name=id]").val();
        var url = "{{env('BASE_URL')}}/admin/custompush"+id;
        setData( url );
     }
     $('.validateForm').validate({
		errorElement: 'span', //default input error message container
		errorClass: 'help-block', // default input error message class
		focusInvalid: false, // do not focus the last invalid input
		rules: {
            user_condition: { required: true },
			provider_condition: { required: true },
            message: { required: true },
		},

		messages: {
			user_condition: { required: "User Condition is required." },
			provider_condition: { required: "Provider Condition is required." },
			content: { required: "Message is required." },
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

            var formGroup = $(".validateForm").serialize().split("&");
            var data = new FormData();
            for(var i in formGroup) {
                var params = formGroup[i].split("=");
                data.append( params[0], decodeURIComponent(params[1]) );
            }
            var url = getBaseUrl() + "/admin/custompush"+id;
            saveRow( url, table, data);

        }
    });

    $('.cancel').on('click', function(){
        $(".crud-modal").modal("hide");
		location.reload();
	});
	
	$('.schedule_close').on('click', function(){
        $("#schedule_modal").modal("hide");
		
    });

});


var autocomplete, autocompleteprovider;

    function initAutocomplete() {

        autocomplete = new google.maps.places.Autocomplete(document.getElementById('search_location'));
        autocompleteprovider = new google.maps.places.Autocomplete(document.getElementById('search_provider_location'));

        autocomplete.addListener('place_changed', function(){
            var place = autocomplete.getPlace().geometry.location;
            set_location(place.lat(),place.lng());
        });

        autocompleteprovider.addListener('place_changed', function(){
            var providerplace = autocompleteprovider.getPlace().geometry.location;
            set_provider_location(providerplace.lat(),providerplace.lng());
        });

    }

    function set_location(lat,lng){
        document.getElementById('user_point').value = lat+','+lng;
    }

    function set_provider_location(lat,lng){
        document.getElementById('provider_point').value = lat+','+lng;
    }
</script>
<script src="https://maps.googleapis.com/maps/api/js?key={{Helper::getSettings()->site->browser_key}}&libraries=places&callback=initAutocomplete" async defer></script>
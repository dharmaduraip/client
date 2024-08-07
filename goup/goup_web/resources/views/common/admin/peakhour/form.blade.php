{{ App::setLocale(  isset($_COOKIE['admin_language']) ? $_COOKIE['admin_language'] : 'en'  ) }}
<div class="row mb-4">
    <div class="col-md-12">
        <div class="card-header border-bottom">
            @if(empty($id))
                @php($action_text=__('admin.add'))
            @else
                @php($action_text=__('admin.edit'))
                    
            @endif
            <h6 class="m-0"style="margin:10!important;">{{$action_text}} {{ __('PeakHour') }}</h6>
        </div>
        <div class="form_pad">
            <form class="validateForm">
                @csrf()
                @if(!empty($id))
                     <input type="hidden" name="_method" value="PATCH">
                     <input type="hidden" name="id" value="{{$id}}">
                @endif
               
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="country_id">{{ __('admin.country.country_name') }}</label>
                        <select name="country_id" id="country_id" class="form-control">
                        <option value="">Select</option>
                         @foreach(Helper::getCountryList() as $key => $country)
                            <option value={{$key}}>{{$country}}</option>
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
					<label for="start_time" class="col-xs-2 col-form-label">@lang('admin.peakhour.start_time')</label>
                    <input class="form-control clockpicker" autocomplete="off"  type="text"  name="start_time"  id="start_time" placeholder="@lang('admin.peakhour.start_time')">
                    </div>
                    <div class="form-group col-md-6">
					<label for="end_time" class="col-xs-2 col-form-label">@lang('admin.peakhour.end_time')</label>
                    <input class="form-control clockpicker" autocomplete="off"  type="text"  name="end_time"  id="end_time" placeholder="@lang('admin.peakhour.end_time')">
					</div>
				</div>

                <div class="form-row">
                 <div class="form-group col-md-6">
					<label for="status" class="col-xs-2 col-form-label">@lang('admin.notification.notify_status')</label>
						<select name="status" class="form-control">
							<option value="active">Active</option>
							<option value="inactive">Inactive</option>
						</select>
					</div>
				</div>

                <button type="submit" class="btn btn-accent">{{$action_text}} {{ __('PeakHour') }}</button>
                <button type="reset" class="btn btn-danger cancel">{{ __('Cancel') }}</button>

            </form>
        </div>
    </div>
</div>
@include('common.admin.includes.redirect')
<script>

$(document).ready(function()
{
     basicFunctions();
     $(".clockpicker").clockpicker({
        autoclose: true,
        'default': 'now'
    });
     var id = "";
     if($("input[name=id]").length){

        id = "/"+ $("input[name=id]").val();
        var url = getBaseUrl() + "/admin/peakhour"+id;
        setData( url );
     }

     $('#country_id').on('change', function(){
        
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
                $("#city_id").append('<option value="">Select</option>');
                $.each(data.responseData,function(key,item){
                    $("#city_id").append('<option value="'+item.city.id+'">'+item.city.city_name+'</option>');
                });

                hideInlineLoader();
            }
        });
    });

    $('.validateForm').validate({
		errorElement: 'span', //default input error message container
		errorClass: 'help-block', // default input error message class
		focusInvalid: false, // do not focus the last invalid input
		rules: {
            start_time: { required: true },
            end_time: { required: true },
            status: { required: true },
		},
		messages: {
			start_time: { required: "Start time is required." },
			end_time: { required: "End time is required." },
			status: { required: "Status is required." },

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
            var url = getBaseUrl() + "/admin/peakhour"+id;

            saveRow( url, table, data);

		}
    });

    $('.cancel').on('click', function(){
        $(".crud-modal").modal("hide");
    });



});
</script>

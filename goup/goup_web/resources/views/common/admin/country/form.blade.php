{{ App::setLocale(  isset($_COOKIE['admin_language']) ? $_COOKIE['admin_language'] : 'en'  ) }}
<div class="row mb-4">
    <div class="col-md-12">
        <div class="card-header border-bottom">
            @if(empty($id))
                @php($action_text=__('admin.add'))
            @else
                @php($action_text=__('admin.edit'))
                    
            @endif
            <h6 class="m-0"style="margin:10!important;">{{$action_text}} {{ __('Country') }}</h6>
        </div>
        <div class="form_pad">
            <form class="validateForm">
                @csrf()
                @if(!empty($id))
                    <input type="hidden" name="_method" value="PATCH">
                    <input type="hidden" name="id" value="{{$id}}">
                    <input type="hidden" name="country" class="country" value="{{$country_id}}">
                @endif
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="country_id" class="col-xs-2 col-form-label">{{ __('admin.country.country_name') }}</label>
                        <select name="country_id" id="country_id" class="form-control">
                         <option value="">select</option>
						</select>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="currency" class="col-xs-2 col-form-label">{{ __('admin.country.currency') }}</label>
                        <input type="text" class="form-control" id="currency" name="currency" placeholder="{{ __('admin.country.currency') }}" value="" autocomplete="off">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="currency_code" class="col-xs-2 col-form-label">{{ __('admin.country.currency_code') }}</label>
                        <input type="text" class="form-control" id="currency_code" name="currency_code" placeholder="{{ __('admin.country.currency_code') }}" value="" autocomplete="off">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="distance_unit" class="col-xs-2 col-form-label">@lang('admin.setting.distance')</label>
                        <select name="distance_unit" class="form-control" id="distance_unit">
                            <option value="Miles">Miles</option>
                            <option value="Kms">Kms</option>
                        </select>
                    </div>
                    <!-- <div class="form-group col-md-6">
					<label for="notify_status" class="col-xs-2 col-form-label">@lang('admin.status')</label>
						<select name="status" class="form-control">
                        <option value="">select</option>
							<option value="1">Active</option>
							<option value="0">Inactive</option>
						</select>
					</div> -->
                </div>
                <button type="submit" class="btn btn-accent">{{$action_text}} {{ __('Country') }}</button>
                <button type="reset" class="btn btn-danger cancel">{{ __('Cancel') }}</button>

            </form>
        </div>
    </div>
</div>


@include('common.admin.includes.redirect')
<script>
$(document).ready(function()
{
    var id = "";
    $.ajax({
        url:  getBaseUrl() + "/admin/countries?id="+$("input[name=id]").val(),
        type: "GET",
        headers: {
          Authorization: "Bearer " + getToken("admin")
           },
        success: function(data) {
            // console.log(data);
            $("#country_id").empty()
                .append('<option value="">select</option>');
            $.each(data.responseData, function(key, item) {
                $("#country_id").append('<option value="' + item.id + '">' + item.country_name + '</option>');
            });
            var country=$('.country').val();
            $('#country_id').val(country);

        }
    });


    basicFunctions();

    if($("input[name=id]").length){
        id = "/"+ $("input[name=id]").val();
        var url = getBaseUrl() + "/admin/companycountries"+id;
        setData( url );
        $('#country_id').attr("readonly", false); 
        $('#country_id').css('pointer-events','');
    }

    $('.validateForm').validate({
		errorElement: 'span', //default input error message container
		errorClass: 'help-block', // default input error message class
		focusInvalid: false, // do not focus the last invalid input
		rules: {
            country_id: { required: true },
            currency: { required: true, maxlength: 5 },
            currency_code: { required: true, lettersonly: true, maxlength: 3},
            status: { required: true },
		},

		messages: {
			country_id: { required: "Country Name is required." },
			currency: { required: "Currency is required.", maxlength: "Currency should not exceed 5 digits." },
            currency_code: { required: "Currency Code is required.", maxlength: "Currency Code should not exceed 3 digits." },
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
            var url = getBaseUrl() + "/admin/companycountries"+id;
            saveRow( url, table, data);
		}
    });

    $('.cancel').on('click', function(){
        $(".crud-modal").modal("hide");
    });


    $('#currency_code').keyup(function(event){
        this.value=this.value.toUpperCase();
        // var key = event.keyCode;
        var charCode = event.keyCode;

        if ((charCode >= 48 && charCode <= 57) || (charCode > 35 && charCode < 39)){
            return false;
           
        }
                
    });
  
});
</script>

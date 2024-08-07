{{ App::setLocale(  isset($_COOKIE['admin_language']) ? $_COOKIE['admin_language'] : 'en'  ) }}
<div class="row mb-4">
    <div class="col-md-12">
        <div class="card-header border-bottom">
            @if(empty($id))
                @php($action_text=__('admin.add'))
            @else
                @php($action_text=__('admin.edit'))

            @endif
            <h6 class="m-0" style="margin:10!important;"> {{$action_text}} {{ __('User') }}</h6>
        </div>
        <div class="form_pad">
            <form class="validateForm" files="true">
                @csrf()
                @if(!empty($id))
                <input type="hidden" name="_method" value="PATCH">
                <input type="hidden" name="id" value="{{$id}}">
                @endif

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="first_name">{{ __('admin.first_name') }}</label>
                        <input type="text" class="form-control" id="first_name" name="first_name" placeholder="First Name" value="">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="last_name">{{ __('admin.last_name') }}</label>
                        <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Last Name" value="">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="email">{{ __('admin.email') }}</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Email" value="" autocomplete="off">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="password">{{ __('admin.password') }}</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Password" value="" autocomplete="off">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="password_confirmation">{{ __('admin.password_confirmation') }}</label>
                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Re-Type-Password" value="" autocomplete="off">
                    </div>
                    <div class="form-group col-md-2">
                        <label for="country_code">{{ __('admin.country_code') }}</label>
                        <input type="text" class="form-control phone" id="country_code" name="country_code" placeholder="Country Code" value="">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="mobile">{{ __('admin.mobile') }}</label>
                        <input type="text" class="form-control phone" id="mobile" name="mobile" placeholder="Mobile" value="">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="male">{{ __('admin.male') }}
                            <input type="radio" class="form-control" id="male" name="gender" value="MALE">
                        </label>
                        <label for="female">{{ __('admin.female') }}
                            <input type="radio" class="form-control" id="female" name="gender" value="FEMALE">
                        </label>
                    </div>
                </div>
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
                    <div class="form-group col-md-3">
                        <label for="picture">{{ __('admin.picture') }}</label>
                        <div class="imgUploadbx">
                            <div class="picture-container">
                                <div class="picture productPic">
                                    <img src="#" class="input_img picture-src" title="" class="img-responsive" style="display:none" />
                                    <input type="file" name="picture" onchange="readURL(this);" >
                                    <h6 class="addPoto">
                                    <img src="{{ asset('assets/layout/images/admin/camera.svg')}}"> <br>{{ __('Add Your image') }}
                                    </h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <br>
                <button type="submit" class="btn btn-accent">{{$action_text}} {{ __('User') }}</button>
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

    var id = "";

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
                $("#city_id").append('<option>Select</option>');
                $.each(data.responseData,function(key,item){
                    $("#city_id").append('<option value="'+item.city.id+'">'+item.city.city_name+'</option>');
                });

                hideInlineLoader();
            }
        });
    });

    if($("input[name=id]").length){

        id = "/" +$("input[name=id]").val();
        var url = getBaseUrl() + "/admin/users"+id;
        setData( url );
    }


    $('.validateForm').validate({
		errorElement: 'span', //default input error message container
		errorClass: 'help-block', // default input error message class
		focusInvalid: false, // do not focus the last invalid input
		rules: {
            first_name: { required: true },
            last_name: { required: true },
            email: { required: true, email: true },
            mobile: { required: true },
            country_code: { required: true },
            country_id: { required: true },
            city_id: { required: true },
            password: { required: true },
            password_confirmation: { equalTo: "#password" },
		},

		messages: {
			first_name: { required: "First name is required." },
			last_name: { required: "Last name is required." },
			email: { required: "Email is required." },
			mobile: { required: "Mobile number is required." },
			country_code: { required: "Code required." },
            password: { required: "Password is required." },
            country_id: { required: "Country is required." },
            city_id: { required: "City is required." },
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

            data.append( 'picture', $( 'input[name=picture]' )[0].files[0] );

            var url = getBaseUrl() + "/admin/users"+id;

            saveRow( url, table, data);

		}
    });

    $('.cancel').on('click', function(){
        $(".crud-modal").modal("hide");
    });

});
</script>

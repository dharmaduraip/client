{{ App::setLocale(  isset($_COOKIE['admin_language']) ? $_COOKIE['admin_language'] : 'en'  ) }}
<div class="row mb-4">
    <div class="col-md-12">
        <div class="card-header border-bottom">
            @if(empty($id))
                @php($action_text=__('admin.add'))
            @else
                @php($action_text=__('admin.edit'))

            @endif
            <h6 class="m-0"style="margin:10!important;">{{$action_text}} {{ __('Provider') }}</h6>
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
                        <label for="first_name" class="col-xs-2 col-form-label">{{ __('admin.first_name') }}</label>
                        <input type="text" class="form-control" id="first_name" name="first_name" placeholder="First Name" value="" autocomplete="off">
                    </div>
                    <div class="form-group col-md-6">
                            <label for="last_name" class="col-xs-2 col-form-label">{{ __('admin.last_name') }}</label>
                            <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Last Name" value="" autocomplete="off">
                    </div>
                </div>

                <div class="form-row email">
                    <div class="form-group col-md-6">
                        <label for="email" class="col-xs-2 col-form-label">{{ __('admin.email') }}</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Email" value="" autocomplete="off">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="password" class="col-xs-2 col-form-label">{{ __('admin.password') }}</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Password" value="" autocomplete="off">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="password_confirmation" class="col-xs-2 col-form-label">{{ __('admin.password_confirmation') }}</label>
                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Re-Type-Password" value="" autocomplete="off">
                    </div>
                </div>
                <div class="form-row">
                    <!-- <div class="form-group col-md-2">
                        <label for="country_code">{{ __('admin.country_code') }}</label>
                        <input type="text" class="form-control phone" id="country_code" name="country_code" placeholder="Country Code" value="">
                        <input id="country_code" name="country_code" class="intl-tel phone form-control mb-4" placeholder="Phone Number"  type="text" >
                    </div> -->

                    <div class="form-group col-md-6 mobile">
                        <label for="mobile" class="col-xs-2 col-form-label">{{ __('admin.mobile') }}</label>
                        <input type="text" class="form-control phone" id="mobile" name="mobile" placeholder="Mobile" value="">
                    </div>

                    <div class="form-group col-md-6">
                        <label for="country_id" class="col-xs-2 col-form-label">{{ __('admin.country.country_name') }}</label>
                        <select name="country_id" id="country_id" class="form-control">
                        <option value="">Select</option>
                        @foreach(Helper::getCountryList() as $key => $country)
                            <option value={{$key}}>{{$country}}</option>
                        @endforeach
						</select>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="city_id" class="col-xs-2 col-form-label">{{ __('admin.country.city_name') }}</label>
                        <select name="city_id" id="city_id" class="form-control">
						</select>
                    </div>
                </div>

                <div class="form-row">

                    <div class="form-group col-md-6">
                        <label for="picture" class="col-xs-2 col-form-label">{{ __('admin.picture') }}</label>
                        <div class="image-placeholder w-100">
                            <img width="100" height="100" />
                            <input type="file" name="picture" class="upload-btn picture_upload">
                        </div>
                        <span style="color:red;font-size:15px;display:none" id="img_error" >Select Image less thaan 10MB Size</span>
                    </div>
                    @if(!empty($id))
                    <div class="form-group col-md-6">
                            <label for="rating" class="col-xs-2 col-form-label">{{ __('admin.users.Rating') }}</label>
                            <input type="number" class="form-control" id="rating" name="rating" placeholder="Rating" value="" autocomplete="off">
                    </div>
                    @endif
                </div>


                <button type="submit" class="btn btn-accent">{{$action_text}} {{ __('Provider') }}</button>
                <button type="reset" class="btn btn-danger cancel">{{ __('Cancel') }}</button>

            </form>
        </div>
    </div>
</div>
@include('common.admin.includes.redirect')
<script>
<?php $demoMode = 0; ?>
var blobImage = '';
var blobName = '';

$(document).ready(function()
{
    $(".phone").intlTelInput({
     /* initialCountry: "<?php echo isset(Helper::getSettings()->site->country_code)?Helper::getSettings()->site->country_code :'in'; ?>",*/
    });

    $('.picture_upload').on('change', function(e) {
      var files = e.target.files;
      var obj = $(this);
      var size = (files[0].size / 1024000);
      console.log(size);
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
        $('#country_id').on('change', function(){
            var country_id =$("#country_id").val();
            $.ajax({
                type:"GET",
                url: getBaseUrl() + "/admin/countrycities/"+country_id,
                headers: {
                    Authorization: "Bearer " + getToken("admin")
                },
                success:function(data){
                    $("#city_id").empty();
                    $("#city_id").append('<option>Select</option>');
                    $.each(data.responseData,function(key,item){
                        $("#city_id").append('<option value="'+item.city.id+'">'+item.city.city_name+'</option>');
                    });
                }
            });
        });
    $('.cancel').on('click', function(){
            $(".crud-modal").modal("hide");
    });
     if($("input[name=id]").length){
        id = "/"+ $("input[name=id]").val();
        var url = getBaseUrl() + "/admin/provider"+id;
        var resdata =setData( url );
      

     }
     $('.validateForm').validate({
		errorElement: 'span', //default input error message container
		errorClass: 'help-block', // default input error message class
		focusInvalid: false, // do not focus the last invalid input
		rules: {
            first_name: { required: true },
            last_name: { required: true },
            email: { required: true, email: true },
            mobile: { required: true, maxlength: 15 },
            password: { required: true },
            password_confirmation: { equalTo: "#password" },
            country_id: { required: true },
            city_id: { required: true },
		},

		messages: {
			first_name: { required: "First name is required." },
			last_name: { required: "Last name is required." },
			email: { required: "Email is required." },
			mobile: { required: "Mobile number is required.", maxlength: "Mobile no should not exceed 15 digits." },
            password: { required: "Password is required." },
            country_id: { required: "Country is required." },
            city_id: { required: "City is required." },

		},
		highlight: function(element)
		{
			$(element).closest('.form-group').addClass('has-error');
            if($(element).attr('id')=='mobile'){
                $('.selected-flag').css('height','60%');
            }
		},

		success: function(label) {
			label.closest('.form-group').removeClass('has-error');
			label.remove();
            $('.selected-flag').css('height','100%');

		},

		submitHandler: function(form) {

            var data = new FormData();

            var formGroup = $(".validateForm").serialize().split("&");

            for(var i in formGroup) {
                var params = formGroup[i].split("=");
                data.append( params[0], decodeURIComponent(params[1]) );
            }

            if(blobImage != "") data.append('picture', blobImage, blobName);

            var url = getBaseUrl() + "/admin/provider"+id;

            data.append( 'country_code', $('.phone').intlTelInput('getSelectedCountryData').dialCode );

            saveRow( url, table, data);

		}
    });
});
</script>

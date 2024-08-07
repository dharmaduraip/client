{{ App::setLocale(  isset($_COOKIE['admin_language']) ? $_COOKIE['admin_language'] : 'en'  ) }}
<div class="row mb-4">
    <div class="col-md-12">
        <div class="card-header border-bottom">
            @if(empty($id))
                @php($action_text=__('admin.add'))
            @else
                @php($action_text=__('admin.edit'))

            @endif
            <h6 class="m-0" style="margin:10!important;">{{$action_text}} {{ __('Fleet Owner') }}</h6>
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
                        <label for="name">{{ __('admin.name') }}</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Fleet Name" value="" autocomplete="off">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="company_name">{{ __('admin.fleet.company_name') }}</label>
                        <input type="text" class="form-control" id="company" name="company_name" placeholder="Company Name" value="" autocomplete="off">
                    </div>
                </div>
                <div class="form-row">

                    <div class="form-group col-md-6 email">
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


                    <!-- <div class="form-group col-md-2">
                        <label for="country_code">{{ __('admin.country_code') }}</label>
                        <input type="text" class="form-control phone" id="country_code" name="country_code" placeholder="Country Code" value="">
                    </div> -->

                    <div class="form-group col-md-6 mobile">
                        <label style="width: 100%" for="mobile">{{ __('admin.mobile') }}</label>
                        <input type="text" class="form-control phone" id="mobile" name="mobile" placeholder="Mobile" value="">
                    </div>


                    <div class="form-group col-md-6">
                        <label for="email">{{ __('admin.fleet.fleet_commission') }}
                        <span style="color:red; font-size: 12px;">(It will work if admin commission &gt; 0%) </span>
                        </label>
                            <input type="text" class="form-control decimal" id="commission" name="commision" placeholder="Commission" value="">
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
                      <div class="form-group col-md-6">
                        <label for="zone_id">{{ __('admin.country.zone') }}</label>
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


                <button type="submit" class="btn btn-accent">{{$action_text}} {{ __('Fleet Owner') }}</button>
                <button type="reset" class="btn btn-danger cancel">{{ __('Cancel') }}</button>

            </form>
        </div>
    </div>
</div>

@include('common.admin.includes.redirect')
<script>

var blobImage = '';
var blobName = '';
<?php $demoMode = 0; ?>
$(document).ready(function()
{
    $(".phone").intlTelInput({
      /*initialCountry: "<?php echo isset(Helper::getSettings()->site->country_code)?Helper::getSettings()->site->country_code :'in'; ?>",*/
    });

    $('.picture_upload').on('change', function(e) {
      var files = e.target.files;
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
     $('#city_id').on('change', function(){

        var city_id =$("#city_id").val();
        $.ajax({
            type:"GET",
            url: getBaseUrl() + "/admin/zonetype/"+city_id+"?type=FLEET",
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
     if($("input[name=id]").length){
        id = "/"+ $("input[name=id]").val();
        var url = getBaseUrl() + "/admin/fleet"+id;
        setData( url );
        
     }

     $('.validateForm').validate({
		errorElement: 'span', //default input error message container
		errorClass: 'help-block', // default input error message class
		focusInvalid: false, // do not focus the last invalid input
		rules: {
            name: { required: true },
            company_name: { required: true },
            email: { required: true, email: true },
            mobile: { required: true, maxlength: 15 },
            password: { required: true },
            password_confirmation: { equalTo: "#password" },
            country_id: { required: true },
            city_id: { required: true },
            zone_id: { required: true },
		},

		messages: {
			name: { required: "Name is required." },
			company_name: { required: "Company is required." },
			email: { required: "Email is required." },
			mobile: { required: "Mobile number is required.",maxlength: "Mobile no should not exceed 15 digits." },
            password: { required: "Password is required." },
            country_id: { required: "Country is required." },
            city_id: { required: "City is required." },
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

            var formGroup = $(".validateForm").serialize().split("&");

            var data = new FormData();

            for(var i in formGroup) {
                var params = formGroup[i].split("=");
                data.append( params[0], decodeURIComponent(params[1]) );
            }

            if(blobImage != "") data.append('picture', blobImage, blobName);

            var url = getBaseUrl() + "/admin/fleet"+id;
            data.append( 'country_code', $('.phone').intlTelInput('getSelectedCountryData').dialCode );

            saveRow( url, table, data);

		}
    });

    $('.cancel').on('click', function(){
        $(".crud-modal").modal("hide");
    });

});
</script>

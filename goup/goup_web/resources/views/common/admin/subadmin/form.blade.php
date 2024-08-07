{{ App::setLocale(  isset($_COOKIE['admin_language']) ? $_COOKIE['admin_language'] : 'en'  ) }}
<div class="row mb-4">
    <div class="col-md-12">
        <div class="card-header border-bottom">
            @if(empty($id))
                @php($action_text=__('admin.add'))
            @else
                @php($action_text=__('admin.edit'))

            @endif
            <h6 class="m-0"style="margin:10!important;">{{$action_text}} {{ __($type) }}</h6>
        </div>
        <div class="form_pad">
            <form class="validateForm"  >

                @csrf()
                @if(!empty($id))
                    <input type="hidden" name="_method" value="PATCH">
                    <input type="hidden" name="id" value="{{$id}}">
                @endif
                @if($type=='Dispute')
                    <input type="hidden" name="role" value="3">
                    <input type="hidden" name="type" value="DISPUTE">
                @elseif($type=='Dispatcher')
                     <input type="hidden" name="role" value="2">
                     <input type="hidden" name="type" value="DISPATCHER">
                @elseif($type=='Account')
                    <input type="hidden" name="role" value="4">
                    <input type="hidden" name="type" value="ACCOUNT">
                @elseif($type=='Admin')
                    <input type="hidden" name="type" value="ADMIN">
                @endif


                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="name" class="col-xs-2 col-form-label">{{ __($type) }} {{ __('admin.full_name') }}</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Full Name" value="" autocomplete="off">

                    </div>

                    <div class="form-group col-md-6 email">
                        <label for="email" class="col-xs-2 col-form-label">{{ __($type) }} {{ __('admin.email') }}</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Email" value="" autocomplete="off">
                    </div>

                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="password" class="col-xs-2 col-form-label">{{ __($type) }} {{ __('admin.password') }}</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Password" value="" autocomplete="off">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="password_confirmation">{{ __($type) }} {{ __('admin.password_confirmation') }}</label>
                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Re-Type-Password" value="" autocomplete="off">
                    </div>
                </div>


                <div class="form-row">
                     <div class="form-group col-md-6 mobile">
                        <label for="mobile" class="col-xs-2 col-form-label">{{ __('admin.mobile') }}</label>
                        <input type="text" class="form-control phone" id="mobile" name="mobile" placeholder="Mobile" value="">
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
                </div>
                @if($type=='Admin')
                    <div class="form-row">
                        <p class="role_avl"></p>
                        <div class="form-group role_display has-error">

                        </div>
                        <!-- <span id="role-error" class="help-block"></span> -->
                    </div>

                @endif
                <button type="submit" class="btn btn-accent">{{$action_text}}  {{ __($type) }}</button>
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
     //select vehicle type in drop down
    $.ajax({
        type:"GET",
        url:getBaseUrl() + "/admin/role_list",
        headers: {
            Authorization: "Bearer " + getToken("admin")
        },
        success:function(data){
            var html="";
            if(data.responseData.length !=0){

                $.each(data.responseData,function(key,item){
                html+=('<div class="radio"><label><input type="radio" name="role" id="role_id" value="'+item.id+'">'+item.name+'</label></div>');
                });

                $(".role_display").html(html);
                $('.role_avl').html('');
            }else{
                $('.role_avl').html('No Custom Role Available. Please add new Role');
                $(".role_display").html(html);
            }


        }
    });

     if($("input[name=id]").length){

        id = "/"+ $("input[name=id]").val();
        var url = getBaseUrl() + "/admin/subadmin"+id;
        setData( url );
       @if(Helper::getEncrypt() == 1 || Helper::getDemomode() == 1)
            $('#mobile').remove();
            $('#email').remove();
            $('.mobile,.email').hide();
            <?php $demoMode = 1; ?>
        @endif
     }

     $('.validateForm').validate({
		errorElement: 'span', //default input error message container
		errorClass: 'help-block', // default input error message class
        errorLabelContainer: '.errorTxt',
        errorPlacement: function(error, element) {
           error.insertBefore(element);
        },
		focusInvalid: false, // do not focus the last invalid input
		rules: {
            name: { required: true, maxlength: 20 },
            @if($demoMode == 1)
            email: { required: true, email: true },
            mobile: { required: true, maxlength: 15 },
            @endif
            role:{ required: true},
            password: { required: true, maxlength: 15 },
            password_confirmation: { equalTo: "#password" },
		},

		messages: {
			name: { required: "Name is required." },
			email: { required: "Email is required." },
            mobile: { required: "Mobile number is required.", maxlength: "Mobile number should not exceed 15 digits." },
            role:{required: "Please choose the role."},
            password: { required: "Password is required." },
            password_confirmation: { equalTo: "The confirm password must be same as password." },
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
		},
        submitHandler: function(form) {
            var data = new FormData();
            var formGroup = $(".validateForm").serialize().split("&");

            for(var i in formGroup) {
                var params = formGroup[i].split("=");
                data.append( params[0], decodeURIComponent(params[1]) );
            }

            if(blobImage != "") data.append('picture', blobImage, blobName);

            var url = getBaseUrl() + "/admin/subadmin"+id;
            data.append( 'country_code', $('.phone').intlTelInput('getSelectedCountryData').dialCode );
            saveRow( url, table, data);

        }
    });

    $('.cancel').on('click', function(){
        $(".crud-modal").modal("hide");
    });

});
</script>

  <meta name="google-signin-client_id" content="{!! CNF_GOOGLE_Client_ID !!}">

  <div class="col-md-8 account_details col-sm-8 col-xs-12 nopadding">
    <div class="smallHeading mainthemeGray">{!! Lang::get('core.your_account') !!}</div>
    <div class="largeHeading mainthemeOrange" ng-bind="::vm.user.name" id="first_name_val" value="{{Auth::user()->username}}" style="display: none;">{{Auth::user()->username}}</div>

    <div class="image_error_type"></div>
    <div class="editProfile">
         <?php 
            $seg    = 'foodstar';
            $seg1   = 'products';
            $uri_path   = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
            $uri_segments   = explode('/', $uri_path);
        ?>

        @if($seg == $uri_segments[2] and $seg1==$uri_segments[1])
        @if(Auth::user()->email=='customer@abservetech.com' or Auth::user()->email=='admin@abservetech.com')
        <font color="red">  you can't edit this. Kindly register one account.</font>
        @endif
        @endif
        @if($seg == $uri_segments[2] and $seg1==$uri_segments[1])

        @if($authemail=='customer@abservetech.com'  or Auth::user()->email=='admin@abservetech.com')
        <font color="red">  you can't edit this. you have to signup.</font> 
        @else
        <a  href="javascript:openModal();" class="editLink">{!! Lang::get('core.btn_edit') !!}</a>
        @endif
        @else
        <a  href="javascript:openModal();" class="editLink">{!! Lang::get('core.btn_edit') !!}</a>
        @endif 

        <div class="new-editprofile">
            <dl class="profileField">
                <dt class="mainthemeGray">{!! Lang::get('core.user_mail') !!}</dt>
                <dd>
                    <?php $authname = Auth::user()->username;
                    $authemail = Auth::user()->email; ?>
                    <span class="fieldValue fn_email" id="fn_email_val">{{Auth::user()->email}}</span>
                    <input type="hidden" value="{{$authname}}" id="authusername">
                    <input type="hidden" value="{{$authemail}}" id="authuseremail">

                </dd>
                <div class="success_message" style="display:none;">{!! Lang::get('core.email_change') !!}</div>
            </dl>
            <dl class="profileField">
                <dt class="mainthemeGray">Home Address</dt>
                <dd>
                    <?php $authname = Auth::user()->username;
                    $authaddress = Auth::user()->address; ?>
                    <span class="fieldValue fn_address" id="fn_address_val">{{Auth::user()->address}}</span>
                    <span style="display: none" class="fieldValue fn_mobile" id="fn_mobile_val">{{Auth::user()->phone_number}}</span>
                    <input type="hidden" value="{{$authname}}" id="authusername">
                    <input type="hidden" value="{{$authaddress}}" id="authuseraddress">
                </dd>
                <div class="success_message" style="display:none;">{!! Lang::get('core.email_change') !!}</div>
            </dl>
            <dl class="profileField">
                <dt class="mainthemeGray">{!! Lang::get('core.photo') !!}</dt>
                <dd class="text-center">
                    <span class="fieldValue fn_email1" ><img src="@if($userImg != ''){{URL::to('uploads/users/'.$userImg)}}@else{{URL::to('uploads/images/avatar_dummy.png')}}@endif" alt="" id="profile-pic" border="0" width="50" class="img-circle profile_img"></span>
                    <form accept-charset="UTF-8" action="{{URL::to('ajax_image_upload')}}" enctype="multipart/form-data" id="ajax_upload_form" method="post" name="ajax_upload_form" target="upload_frame">
                        <div class="fileinput fileinput-new col-xs-12 text-center" data-provides="fileinput">
                            <label style="color: #fff;font-weight: 600;" class=" btn btn-primary upload_pro_pic" for="user_profile_pic" role="button">{!! Lang::get('core.upload_photo') !!}... <input style="cursor: pointer;" tabindex="0" type="file" name="avatar"  capture="camera" id="user_profileChange" ></label>
                            <!-- <input tabindex="0" type="file" name="avatar" accept="image/*" capture="camera" id="user_profileChange" > -->
                        </div>
                    </form>
                </dd>
                <!-- <span class="success_message" ></span> -->
            </dl>
            <dl class="profileField">
                <dt class="mainthemeGray">{!! Lang::get('core.google') !!}</dt>
                <dd class="text-center">
                    <?php if(Auth::user()->social_id != null && Auth::user()->social_id != ''){ ?>
                    <a class="bootstrap-link"> <i class="fa fa-check" ></i> Done</a>
                    <?php }else{ ?>
                    <div class="fileinput fileinput-new text-center">
                        <div id="my-signin4">Google Signin</div>
                    </div>
                    <?php } ?>
                </dd>
                <!-- <span class="success_message" ></span> -->
            </dl>
            <dl class="profileField">
                <dt class="mainthemeGray">{!! Lang::get('core.fb') !!}</dt>
                <dd class="text-center">
                    <?php if(Auth::user()->fb_id != null && Auth::user()->fb_id != ''){ ?>
                    <a class="bootstrap-link"> <i class="fa fa-check" ></i> Done</a>
                    <?php }else{ ?>
                    <div class="fileinput fileinput-new text-center">
                        <fb:login-button data-size="large" data-button-type="login_with" data-layout="default" data-auto-logout-link="false" data-use-continue-as="false" data-width="" scope="public_profile,email" onlogin="checkLoginState();"></fb:login-button>
                    </div>
                    <?php } ?>
                </dd>
                <!-- <span class="success_message" ></span> -->
            </dl>
        </div>
    </div>
</div>
<div id="editEmailModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <form role="form" action="" method="post" id="email_form">
            <div class="modal-content">
                <div class="modal-header">
                    <div>
                        <h5 class="modal-title strong">{!! Lang::get('core.edit_profile') !!}</h5>
                        <div class="mainthemeGray">Update your profile</div>
                    </div>
                    <button type="button" class="btn close" data-bs-dismiss="modal" aria-label="Close">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="alert_fn name_space_error"></div>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fa fa-user" aria-hidden="true"></i></span>
                        <input type="text"  id="username" name="username" class="form-control"  value="{!! Auth::user()->username !!}" placeholder="{!! Lang::get('core.name') !!}">
                    </div>
                </div>
                <div class="modal-body">
                    <div class="alert_fn"></div>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fa fa-mobile" aria-hidden="true"></i></span>
                        <input type="text"  id="umobile" name="mobile" class="form-control"  value="{{Auth::user()->phone_number}}" placeholder="Edit your mobile number" readonly>
                    </div>

                </div>
                <div class="modal-body">
                    <div class="alert_fn"></div>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fa fa-envelope" aria-hidden="true"></i></span>
                        <input type="email"  id="uemail" name="email" class="form-control"  value="{{Auth::user()->email}}" placeholder="{!! Lang::get('core.email') !!}">
                    </div>

                </div>
                <div class="modal-body">
                    <div class="alert_fn"></div>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fa fa-home" aria-hidden="true"></i></span>
                        <input type="address"  id="uaddress" name="address" class="form-control"  value="{{Auth::user()->address}}" placeholder="Edit your address">
                    </div>

                </div>

                <div class="error_message"></div>
                <div class="modal-footer">
                    <a href="javascript:void(0)" class="linkCancel" data-bs-dismiss="modal">{!! Lang::get('core.sb_cancel') !!}</a>
                    <button type="button" class="btn btn-primary save_address btnUpdate edit_profile_submit"  >{!! Lang::get('core.sb_update') !!}</button>
                    <div id="mail_same_error"></div>
                </div>
            </div>
        </form>
    </div>
</div>
<script type="text/javascript" src="{{ url('sximo5/js/front/custom.js') }}"></script>
<style type="text/css">.modal-backdrop{opacity:0!important;position:relative!important;}</style>
<script type="text/javascript">
    function openModal(){
        var mailid = $("#fn_email_val").text();
        var nameval = $("#first_name_val").text();
        var address = $("#fn_address_val").text();
        var mobile = $("#fn_mobile_val").text();
        $("#username").val(nameval); 
        $("#uemail").val(mailid);
        $("#uaddress").val(address);
        $('.error_message').html('');
        $("#editEmailModal").modal("show");
    }
    $(document).on('click',".edit_profile_submit",function(e){
        e.preventDefault();
        var formStatus = $('#email_form').validate().form();
        if(true == formStatus){
            var suc_msg = '';
            var orginal_email = $("#fn_email_val").text();
            var original_name = $("#first_name_val").text();
            var new_mail = $("#uemail").val();
            var new_name = $("#username").val();
            var orginal_address = $("#fn_address_val").text();
            var orginal_mobile = $("#fn_mobile_val").text();
            var new_address = $("#uaddress").val();
            var new_mobile = $("#umobile").val();
            $.ajax({
                url: base_url+'email',
                type: 'post',
                data:  $('#email_form').serialize(),
                success: function(data) {
                    if(data == 6){
                        $('.error_message').html('<font color="red">{!! Lang::get("core.email_exist_error") !!}</font>');
                        setTimeout(function(){ $('.error_message').html(''); }, 3000);
                        return false;
                    } else if(data ==1 || data ==2 || data ==3){
                        if(data==2){
                            location.reload();
                        }
                        $(".fn_email").text($("#email_form").find('#uemail').val());
                        $("#username").val(new_name); 
                        $("#uemail").val(new_mail);
                        $("#fn_email_val").text(new_mail);
                        $("#first_name_val").text(new_name);
                        $("#editEmailModal").modal("hide");
                        $(".success_message").text(suc_msg);
                        setTimeout(function(){ $('.success_message').text(''); }, 3000);
                    } else if(data ==4 || data ==5 ) {
                        if(data ==4 ) {
                            $('.error_message').html('<font color="red">{!! Lang::get("core.email_name_change_not") !!}</font>');
                            setTimeout(function(){ $('.error_message').html(''); }, 3000);
                        } else if(data ==5 ) {
                            $('.error_message').html('<font color="red">{!! Lang::get("core.email_exist_error") !!}</font>');
                            setTimeout(function(){ $('.error_message').html(''); }, 3000);
                        }
                        return false;
                    }
                }            
            });
        } else {
            alert('else');
            return false;
        }

    })

    $("#email_form").validate({
        // Rules for form validation
        rules:
        {
            email:
            {
                required: true,
                email: true
            },
            username:
            {
                required: true,
                minlength: 2,
            }
        },
        // Messages for form validation
        messages:
        {
            email:
            {
                required: '{!! Lang::get("core.email_error") !!}',
                email: '{!! Lang::get("core.valid_email") !!}',
            },
            username:
            {
                required: '{!! Lang::get("core.name_error") !!}',
                alphanumeric: '{!! Lang::get("core.name_format_error") !!}',
            }
        }, 
    });
    function AvoidSpace(event) {
        var k = event ? event.which : window.event.keyCode;
        if (k == 32) {
            $(".name_space_error").html('<font color="red">{!! Lang::get("core.name_alpha") !!}</font');
            setTimeout(function(){ $('.name_space_error').html(''); }, 2000);
            return false;
        }
    }
    var userData = {};



    function onSuccess(googleUser)
    {
        var profile = googleUser.getBasicProfile();
        userData['name'] = profile.getName();
        userData['imageURL'] = profile.getImageUrl();
        userData['email'] = profile.getEmail();            
        userData['id'] = profile.getId();            
        userData['from'] = 'gmail';
        check_exists();
        // socialMediaLog(userData);            
        var auth2 = gapi.auth2.getAuthInstance();      
        auth2.signOut().then(function () {
        });
    }
    function onFailure(error) {      
    }
    function renderButton() {
        gapi.signin2.render('my-signin4', {
            'scope': 'profile email',
            'width': 240,
            'height': 50,
            'longtitle': true,
            'theme': 'dark',
            'onsuccess': onSuccess,
            'onfailure': onFailure
        });
    }

    window.fbAsyncInit = function() {
        FB.init({
            appId      : '{!! F_APP_KEY !!}',
            cookie     : true,
            xfbml      : true,
            version    : 'v2.8'
        });

        FB.AppEvents.logPageView();   

    };

    (function(d, s, id){
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) {return;}
        js = d.createElement(s); js.id = id;
        js.src = "https://connect.facebook.net/en_US/sdk.js";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));


    function checkLoginState() {
        FB.getLoginStatus(function(response) {
            statusChangeCallback(response);
        });
    }

    function statusChangeCallback(response) {
        if (response.status === 'connected') {
            FB.api('/me?fields=email,name', function (response) {

                userData['id'] = response.id;
                userData['name'] = response.name;
                userData['email'] = response.email;
                userData['from'] = 'fb';
                check_exists();
                //   socialMediaLog(userData);
            });
        } else {

        }
    }
    function check_exists()
    {
        $.ajax({
            type : 'POST',
            dataType : 'json',
            url:base_url+"/user/checksocial",
            data : {'social_id':userData['id'],'from':userData['from'],'integrate':'<?php echo Auth::user()->id; ?>'},
            success: function (data) {
                if(data.msg == 'success')
                {
                    location.reload();
                }else {
                    alert('This Account has already been used by another User. Kindly try a different Account');
                }
            }

        }); 
    }
</script>
<script src="https://apis.google.com/js/platform.js?onload=renderButton" async defer></script></script>
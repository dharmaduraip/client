@extends('admin.layouts.master')
@section('title', 'Site Settings')
@section('maincontent')
@component('components.breadcumb',['fourthactive' => 'active'])
@slot('heading')
   {{ __('Site Settings') }}
@endslot
@slot('menu1')
{{ __('Site Settings') }}
@endslot
@endcomponent
<div class="contentbar">
    <div class="row">

  
    <!-- row started -->
    <div class="col-lg-12">

      @if ($errors->any())  
      <div class="alert alert-danger" role="alert">
      @foreach($errors->all() as $error)     
      <p>{{ $error}}<button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span></button></p>
          @endforeach  
      </div>
      @endif
    
        <div class="card m-b-30">
                <!-- Card header will display you the heading -->
                <div class="card-header">
                    <h5 class="card-box">{{ __('Site Settings') }}</h5>
                </div> 
               
                <!-- card body started -->
                <div class="card-body">
                <ul class="nav nav-tabs mb-3" id="defaultTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="home-tab" data-toggle="tab" href="#facebook" role="tab" aria-controls="home" aria-selected="true"><i class="fa fa-cog pr-2" aria-hidden="true"></i>{{ __('GeneralSetting') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="profile-tab" data-toggle="tab" href="#google" role="tab" aria-controls="profile" aria-selected="false"><i class="fa fa-bandcamp pr-2" aria-hidden="true"></i>{{ __('SeoSetting') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="profile-tab" data-toggle="tab" href="#twitter" role="tab" aria-controls="profile" aria-selected="false"><i class="fa fa-envelope-o pr-2" aria-hidden="true"></i>{{ __('MailSetting') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="profile-tab" data-toggle="tab" href="#linkedin" role="tab" aria-controls="profile" aria-selected="false"><i class="fa fa-stumbleupon pr-2" aria-hidden="true"></i>{{ __('CustomStyleandJS') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="profile-tab" data-toggle="tab" href="#amazon" role="tab" aria-controls="profile" aria-selected="false">&nbsp;&nbsp;<i class="fa fa-google-plus pr-2" aria-hidden="true"></i>{{ __('SocialLoginSetting') }}</a>
                        </li>
                      <li class="nav-item">
                        <a class="nav-link" id="profile-tab" data-toggle="tab" href="#whatsapp" role="tab" aria-controls="profile" aria-selected="false">&nbsp;&nbsp;<i class="fa fa-whatsapp pr-2" aria-hidden="true"></i>{{ __('Whatsapp Chat') }}</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" id="profile-tab" data-toggle="tab" href="#faceboo" role="tab" aria-controls="profile" aria-selected="false">&nbsp;&nbsp;<i class="fa fa-facebook-official pr-2" aria-hidden="true"></i>{{ __('Facebook Chat') }}</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="profile-tab" data-toggle="tab" href="#admin" role="tab" aria-controls="profile" aria-selected="false">&nbsp;&nbsp;<i class="fa fa-lock pr-2"  aria-hidden="true"></i>{{ __('Admin Setting') }}</a>
                </li>
                    </ul>
                    <div class="tab-content" id="defaultTabContent">

                        <!-- === genral start ======== -->
                        <div class="tab-pane fade show active" id="facebook" role="tabpanel" aria-labelledby="home-tab">
                            <!-- === genral form start ======== -->
                            @include('admin.setting.genral')
                            <!-- === genral form end ===========-->    
                        </div>
                          <!-- === genral end ======== -->

                          <!-- === seo start ======== -->
                        <div class="tab-pane fade" id="google" role="tabpanel" aria-labelledby="profile-tab">
                            <!-- === seo form start ======== -->
                            @include('admin.setting.seo')
                            <!-- === seo form end ===========-->
                        </div>
                        <!-- === seo end ======== -->

                        <!-- === mailsetting start ======== -->
                        <div class="tab-pane fade" id="twitter" role="tabpanel" aria-labelledby="profile-tab">
                            <!-- === mailsetting form start ======== -->
                            @include('admin.setting.mailsetting')
                            <!-- === mailsetting form end ===========-->
                        </div>
                        <!-- === mailsetting end ======== -->

                        <!-- === customstyle start ======== -->
                        <div class="tab-pane fade" id="linkedin" role="tabpanel" aria-labelledby="profile-tab">
                            <!-- === customstyle form start ======== -->
                            @include('admin.setting.customstyle')
                            <!-- === customstyle form end ===========-->
                        </div>
                        <!-- === customstyle end ======== -->

                                                                   <!-- === amazon start ======== -->
                        <div class="tab-pane fade" id="amazon" role="tabpanel" aria-labelledby="profile-tab">
                          <!-- === amazon form start ======== -->
                          @include('admin.setting.sociallogin')
                          <!-- === amazon form end ===========-->
                      </div>
                      <!-- === amazon end ======== -->

<!-- === whatsapp chat end ======== -->
  <!-- === whatsapp chat start ======== -->
  <div class="tab-pane fade" id="whatsapp" role="tabpanel" aria-labelledby="profile-tab">
    <!-- === whatsapp chat form start ======== -->
    @include('admin.setting.whatsapp')
    <!-- === whatsapp chat form end ===========-->
</div>
 <!-- === facebook chat start ======== -->
 <div class="tab-pane fade" id="faceboo" role="tabpanel" aria-labelledby="profile-tab">
  <!-- === facebook chat form start ======== -->
  @include('admin.setting.facebook')
  <!-- === facebook chat form end ===========-->
</div>
<div class="tab-pane fade" id="admin" role="tabpanel" aria-labelledby="profile-tab">
  <!-- === facebook chat form start ======== -->
  @include('admin.setting.admin')
  <!-- === facebook chat form end ===========-->
</div>
<!-- === login end ======== -->
                    </div>
                </div><!-- card body end -->
            
        </div><!-- col end -->
    </div>
</div>
</div><!-- row end -->
    <br><br>
@endsection
<!-- main content section ended -->
<!-- This section will contain javacsript start -->
@section('script')
<!--  for password eye start -->

<script>
    $(".midia-toggle").midia({
        base_url: '{{ url('') }}',
        title : 'Choose Logo',
        dropzone : {
          acceptedFiles: '.jpg,.png,.jpeg,.webp,.bmp,.gif'
        },
        directory_name: 'logo'
    });
</script>

<script>
    $(".midia-toggle2").midia({
        base_url: '{{ url('') }}',
        title : 'Choose Favicon',
        dropzone : {
          acceptedFiles: '.jpg,.png,.jpeg,.webp,.bmp,.gif'
        },
        directory_name: 'favicon'
    });
</script>

<style>
.field_icon {
  float: right;
  margin-left: -25px;
  margin-top: -25px;
  position: relative;
  z-index: 2;
}
</style>

<script>
$(document).on('click', '.toggle-password1', function() {
$(this).toggleClass("fa-eye fa-eye-slash");
var input = $("#pass_log_id1");
input.attr('type') === 'password' ? input.attr('type','text') : input.attr('type','password')
});
</script>
<script>
$(document).on('click', '.toggle-password2', function() {
$(this).toggleClass("fa-eye fa-eye-slash");
var input = $("#pass_log_id2");
input.attr('type') === 'password' ? input.attr('type','text') : input.attr('type','password')
});
</script>
<script>
$(document).on('click', '.toggle-password3', function() {
$(this).toggleClass("fa-eye fa-eye-slash");
var input = $("#pass_log_id3");
input.attr('type') === 'password' ? input.attr('type','text') : input.attr('type','password')
});
</script>
<script>
$(document).on('click', '.toggle-password4', function() {
$(this).toggleClass("fa-eye fa-eye-slash");
var input = $("#pass_log_id4");
input.attr('type') === 'password' ? input.attr('type','text') : input.attr('type','password')
});
</script>
<script>
$(document).on('click', '.toggle-password5', function() {
$(this).toggleClass("fa-eye fa-eye-slash");
var input = $("#pass_log_id5");
input.attr('type') === 'password' ? input.attr('type','text') : input.attr('type','password')
});
</script>
<script>
$(document).on('click', '.toggle-password6', function() {
$(this).toggleClass("fa-eye fa-eye-slash");
var input = $("#pass_log_id6");
input.attr('type') === 'password' ? input.attr('type','text') : input.attr('type','password')
});
</script>
<script>
$(document).on('click', '.toggle-password', function() {
$(this).toggleClass("fa-eye fa-eye-slash");
var input = $("#pass_log_id7");
input.attr('type') === 'password' ? input.attr('type','text') : input.attr('type','password')
});
</script>
<!--  for password eye end -->
<!-- script to upload Logo start -->
<script>
        $('.profilechoose1').click(function(){ $('#imgupload1').trigger('click'); });

        $("#imgupload1").on('change',function() {
          readURL1(this);
        });

        function readURL1(input) {
          
          if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
              $('.profilechoose1').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
          }
        }
    </script>
<!-- script to upload Logo end -->
<!-- script to upload footer logo start -->
<script>
        $('.profilechoose2').click(function(){ $('#imgupload2').trigger('click'); });

        $("#imgupload2").on('change',function() {
          readURL2(this);
        });

        function readURL2(input) {
          
          if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
              $('.profilechoose2').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
          }
        }
    </script>
<!-- script to upload footer logo end -->
<!-- script to upload Favicon start -->
<script>
        $('.profilechoose3').click(function(){ $('#imgupload3').trigger('click'); });

        $("#imgupload3").on('change',function() {
          readURL3(this);
        });

        function readURL3(input) {
          
          if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
              $('.profilechoose3').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
          }
        }
    </script>
<!-- script to upload Favicon end -->
<!-- script to upload Preloader logo start -->
<script>
        $('.profilechoose4').click(function(){ $('#imgupload4').trigger('click'); });

        $("#imgupload4").on('change',function() {
          readURL4(this);
        });

        function readURL4(input) {
          
          if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
              $('.profilechoose4').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
          }
        }
    </script>
<!-- script to upload Preloader logo end -->
<!-- script to upload Contact Page Image start -->
<script>
        $('.profilechoose5').click(function(){ $('#imgupload5').trigger('click'); });

        $("#imgupload5").on('change',function() {
          readURL5(this);
        });

        function readURL5(input) {
          
          if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
              $('.profilechoose5').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
          }
        }
    </script>
<!-- script to upload Contact Page Image end -->
<!-- script to hide and show contact start -->
<script>
  (function($) {
    "use strict";

    $(function(){

          $('#customSwitch2').change(function(){
          if($('#customSwitch2').is(':checked')){
            $('#sec1_one').show('fast');
          }else{
            $('#sec1_one').hide('fast');
          }

        });

          $('#customSwitch2').change(function(){
          if($('#customSwitch2').is(':checked')){
            $('#sec_one').hide('fast');
          }else{
            $('#sec_one').show('fast');
          }

        });
     
    });
  })(jQuery);
</script>
<!-- script to hide and show contact end -->
<!-- script to hide and show PromoText start -->
<script>
  (function($) {
    "use strict";

    $(function(){

          $('#customSwitch3').change(function(){
          if($('#customSwitch3').is(':checked')){
            $('#sec2_one').show('fast');
          }else{
            $('#sec2_one').hide('fast');
          }

        });
     
    });
  })(jQuery);
</script>
<!-- script to hide and show PromoText end -->

<!-- script to hide and show password eye start -->
<script>
$(document).on('click', '.toggle-password', function() {

$(this).toggleClass("fa-eye fa-eye-slash");

var input = $("#pass_log_id");
input.attr('type') === 'password' ? input.attr('type','text') : input.attr('type','password')
});
</script>
<!-- script to hide and show password eye end -->
@endsection
<!-- This section will contain javacsript end -->
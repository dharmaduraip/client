@extends('common.admin.layout.auth')

@section('content')

<section class="login">
   <div class="container">
      <div class="row">
         <div class="col-md-12 col-lg-12">
            <div class="basic_form login_form">
            <!-- <h1 id = "login_status">Login</h1> -->
            <h1 id ="login_status">Reset your password</h1>
            
            <div class="form_cnt"> 
               <div class="form_bdy admin active_form">
                  <form class="validateForm" >
                     <div class="col-md-12 p-0 ">
                        <div id="toaster" class="toaster"></div>
                       
                           <input id="email" name="username" type="hidden" aria-required="true" value="{{$urlparam['email']}}">
                           <input id="enterOtp" name="otp" class="form-control mb-4" placeholder="Enter OTP Received" type="text" aria-required="true" >
                           <input id="newPass" name="password" class="form-control mb-4" placeholder="New Password" type="password" aria-required="true" >
                           <input id="confirmPass" name="password_confirmation" class="form-control mb-4" placeholder="Confirm Password" type="password" aria-required="true" >
                          
                           <button type="submit" class="btn btn-block btn-secondary btn-md mb-2 signup">Continue<i class="fa fa-arrow-circle-right ml-2" aria-hidden="true"></i></button>
                     </div>
                  </form>
                  <div class="mt-4">
                     <a href="{{url('admin/login')}}" id="sign" class="txt-secondary sign-up-link"><i class="fa fa-arrow-circle-left mr-2" aria-hidden="true"></i>Back To Login</a>
                  </div>

               </div>
            
            </div>
            
         </div>

      </div>
      </div>
   </div>
</section>

@stop
@section('scripts')
@parent

<script>

   $(document).ready(function() {
  
   $('.validateForm').validate({
      errorElement: 'span', //default input error message container
      errorClass: 'help-block', // default input error message class
      focusInvalid: false, // do not focus the last invalid input
      rules: {
         username: { required: true, email: true },
         otp:{required: true},
         password:{required: true}
      },
      messages: {
         username: { required: "Email is required." },
         otp: { required: "OTP is required." },
         password: { required: "Password is required." }
   },
      highlight: function(element)
      {
         $(element).closest('.errMail').addClass('has-error');
      },

      success: function(label) {
         label.closest('.errMail').removeClass('has-error');
         label.remove();
      },
      submitHandler: function(form) {
            var formGroup = $(".validateForm").serialize().split("&");
            var data = new FormData();
            for(var i in formGroup) {
               var params = formGroup[i].split("=");
               data.append( params[0], decodeURIComponent(params[1]) );
            }
            data.append( 'salt_key', '{{Helper::getSaltKey()}}'); 
            
            $.ajax({
               url: getBaseUrl() + "/admin/resetOtp",
               type: "post",
               data: data,
               processData: false,
               contentType: false,
               beforeSend: function() {
                  showLoader();
               },
               success: function(response, textStatus, jqXHR) {
                  console.log(response);
                  window.location.replace("{{ url('/admin/login') }}");
                  hideLoader();
               },
               error: function(jqXHR, textStatus, errorThrown) {
                  console.log(jqXHR);
                  alertMessage(textStatus, jqXHR.responseJSON.message, "danger");
                  hideLoader();
               }
            });
      }
   });

});

</script>

@stop

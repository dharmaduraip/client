@extends('order.shop.layout.auth')

@section('content')

<section class="login">
   <div class="container">
      <div class="row">
         <div class="col-md-12 col-lg-12">
            <div class="basic_form login_form">
            <!-- <h1 id = "login_status">Login</h1> -->
            <h4 id ="login_status">Forgotten your password?</h4>
          
            <div class="tab-content">
               <div id="emailtab" class="tab-pane active col-sm-12 col-md-12 col-lg-12">
                  <div class="dis-reverse">               
                     <div class="offset-md-7 d-lg-block d-md-none d-sm-none"></div>
                    <form class=" login-section validateForm" >
                        <div class="col-md-12 p-0 ">
                        <div id="toaster" class="toaster"></div>
                           <input id="email" name="email" class="form-control mb-4" placeholder="E-mail Address" type="email" aria-required="true" required>
                           <span class="errMail"></span>
                           <button type="submit" class="btn btn-block btn-secondary btn-md mb-2 signup">Continue<i class="fa fa-arrow-circle-right ml-2" aria-hidden="true"></i></button>
                           <a href="{{url('shop/login')}}" id="sign" class="txt-secondary sign-up-link"><i class="fa fa-arrow-circle-left mr-2" aria-hidden="true"></i>Back To Login</a>
                      </div>
                     </form> 
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
            email: { required: true, email: true },
      },
      messages: {
            email: { required: "Email is required." },
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
               url: getBaseUrl() + "/shop/forgotOtp",
               type: "post",
               data: data,
               processData: false,
               contentType: false,
               beforeSend: function() {
                  showLoader();
               },
               success: function(response, textStatus, jqXHR) {
                 
                  para = '?email='+response.responseData.username;
                  localStorage.setItem('email', response.responseData.username);
                  hideLoader();
                  window.location.replace("{{ url('/shop/resetPassword') }}");
                  
               },
               error: function(jqXHR, textStatus, errorThrown) {

                  if (jqXHR.responseJSON) {
                     alertMessage(textStatus, jqXHR.responseJSON.message, "danger");
                  }
                  hideLoader();
               }
            });
      }
   });

});
</script>

@stop

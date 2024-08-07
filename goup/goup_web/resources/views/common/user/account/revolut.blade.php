{{ App::setLocale(  isset($_COOKIE['user_language']) ? $_COOKIE['user_language'] : 'en'  ) }}
<!DOCTYPE html>
<html>
   <head>
      <title>
      {{ __(Helper::getSettings()->site->site_title) }}
      </title>
      <meta charset='utf-8'>
      <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
      <meta content='website' property='og:type'>
      <link rel="shortcut icon" type="image/png" href="{{ Helper::getFavIcon() }}"/>
      @section('styles')
      <link rel='stylesheet' type='text/css' href="{{ asset('assets/plugins/bootstrap/css/bootstrap.min.css')}}"/>
      <link rel='stylesheet' type='text/css' href="{{ asset('assets/plugins/font-awesome-4.7.0/css/font-awesome.min.css')}}">
      <link rel='stylesheet' type='text/css' href="{{ asset('assets/plugins/icons/css/ionicons.min.css')}}"/>
      <link rel='stylesheet' type='text/css' href="{{ asset('assets/plugins/icons/css/linearicons.css')}}"/>
      <link rel='stylesheet' href="https://fonts.googleapis.com/icon?family=Material+Icons" />
      <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" rel="stylesheet">
      <link rel='stylesheet' type='text/css' href="{{ asset('assets/layout/css/media-mobile.css')}}"/>
      <link rel='stylesheet' type='text/css' href="{{ asset('assets/layout/css/media-tab.css')}}"/>
      <link rel='stylesheet' type='text/css' href="{{ asset('assets/layout/css/media-lap.css')}}"/>
      <link rel='stylesheet' type='text/css' href="{{ asset('assets/layout/css/animate.css')}}"/>
      <link rel='stylesheet' type='text/css' href="{{ asset('assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}" />
      <link rel='stylesheet' type='text/css' href="{{ asset('assets/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css') }}" />
      <link rel='stylesheet' type='text/css' href="{{ asset('assets/plugins/clockpicker-wearout/css/jquery-clockpicker.min.css')}}"/>
      @show
     
      <link rel='stylesheet' type='text/css' href="{{ asset('assets/layout/css/stylesheet.css')}}"/>
      
     
      @if(@Request::segment(1)=='store' && @Request::segment(2) !='order' )
       <link rel='stylesheet' type='text/css' href="{{ asset('assets/foody/foody.css')}}"/>
      @elseif(@Request::segment(1)=='store' && @Request::segment(2)=='order')

      
      <link rel='stylesheet' type='text/css' href="{{ asset('assets/foody/foody.css')}}"/>
      <link rel='stylesheet' type='text/css' href="{{ asset('assets/layout/css/provider.css')}}"/>
      <link rel='stylesheet' type='text/css' href="{{ asset('assets/layout/css/user.css')}}"/>
        <!-- <link rel='stylesheet' type='text/css' href="{{ asset('assets/layout/css/user.css')}}"/> -->
      @else
      <link rel='stylesheet' type='text/css' href="{{ asset('assets/layout/css/provider.css')}}"/>
      <link rel='stylesheet' type='text/css' href="{{ asset('assets/layout/css/user.css')}}"/>
      @endif
   </head>
   <body>
      @include('common.user.includes.header')
      @include('common.user.includes.nav')
      @yield('content')
    <div class="container">
        <div class="card text-center" style="margin-top:300px;">
            <div class="card-header">
                Easyjek
            </div>
            <div class="card-body">
                <h5 class="card-title"></h5>
                <p class="card-text"></p>
                <input type="text" id ="amount" readonly class="form-control" name="amount" value="{{ Request::get('amount') }}">

                <button id="pay-button" class="btn btn-secondary mt-3" >@lang('Click_Revolut_Pay')</button>
            </div>
            <div class="card-footer text-muted">
                
            </div>
        </div>
        </div>
      @include('common.user.includes.footer')
      <script>
         window.room = '{{base64_decode(Helper::getSaltKey())}}';
         window.socket_url = '{{Helper::getSocketUrl()}}';
         window.base_url = '{{ env('BASE_URL') }}';
         window.country_id = '{{ json_encode(Helper::getAccessKey()) }}';
      </script>
      @section('scripts')
      <script>!function(e,o,t){e[t]=function(n,r){var c={sandbox:"https://sandbox-merchant.revolut.com/embed.js",prod:"https://merchant.revolut.com/embed.js",dev:"https://merchant.revolut.codes/embed.js"},d=o.createElement("script");d.id="revolut-checkout",d.src=c[r]||c.prod,d.async=!0,o.head.appendChild(d);var s={then:function(r,c){d.onload=function(){r(e[t](n))},d.onerror=function(){o.head.removeChild(d),c&&c(new Error(t+" is failed to load"))}}};return"function"==typeof Promise?Promise.resolve(s):s}}(window,document,"RevolutCheckout");</script>

      <script type="text/javascript" src="{{ asset('assets/plugins/jquery-3.3.1.min.js')}}"></script>
      <script type="text/javascript" src="{{ asset('assets/plugins/popper.min.js')}}"></script>
      <script type="text/javascript" src="{{ asset('assets/plugins/bootstrap/js/bootstrap.min.js')}}"></script>

      <script src="{{ asset('assets/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
      <script src="{{ asset('assets/plugins/jquery-validation/additional-methods.min.js') }}" ></script>

      <script type="text/javascript" src="{{ asset('assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
      <script type="text/javascript" src="{{ asset('assets/plugins/bootstrap-timepicker/js/bootstrap-timepicker.js') }}"></script>
      <script type="text/javascript" src="{{ asset('assets/plugins/clockpicker-wearout/js/jquery-clockpicker.min.js') }}"></script>
      
      <script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.3.0/socket.io.js"></script>
      
      <script src="{{ asset('assets/layout/js/script.js')}}"></script>
      <script src="{{ asset('assets/layout/js/api.js')}}"></script>
      @show
      <script>

         if(getToken("user") == null) {
            //window.location.replace("{{ url('/login') }}");
         }

         window.url = '{{url("")}}';
         window.env = "{{(env('APP_ENV'))}}";

         checkAuthentication("user");



   </script>
   <script>
   let public_id ="{{ Request::get('public_id') }}";
   let payment_id ="{{ Request::get('id') }}";
   let order_id ="{{ Request::get('merchant_order_ext_ref') }}";

    RevolutCheckout( public_id,'sandbox').then(function (RC) {
                            var payButton = document.getElementById("pay-button");
                            // On click open payment pop-up
                            payButton.addEventListener("click", function () {
                              RC.payWithPopup({
                                // (mandatory!) name of the cardholder
                               // name: "First Last",
                               
                                // Callback called when payment finished successfully
                                onSuccess() {
                                    revoult_success(payment_id, order_id);
                                 // window.alert("Thank you!");

                                },
                                // Callback in case some error happened
                                onError(message) {
                                  window.alert("Oh no :(");
                                },
                                // (optional) Callback in case user cancelled a transaction
                                onCancel() {
                                  window.alert("Payment cancelled!");
                                },
                              });
                            });
                          });
    function revoult_success(id,merchant_order_ext_ref){
       
       $.ajax({
              type:'GET',
              // url: getBaseUrl() + "/user/wallet/revoult_success/"+id+"/"+merchant_order_ext_ref,
              url:  "https://api.easyjek.com/api/v1/revoult_success?id="+id+"&merchant_order_ext_ref="+merchant_order_ext_ref,

              processData: false,
              contentType: false,
            //   headers: {
            //      Authorization: "Bearer " + getToken("user")
            //   },
              success:function(data){
                  var data = parseData(data);
                  console.log(data);
                  var admin_service = data.responseData.admin_service;
                  var user_type = data.responseData.user_type;
                  var type_id = data.responseData.id;
                  var transaction_id = data.responseData.transaction_id;

                  alertMessage("Success", data.message, "success");
                  location.href="https://easyjek.com/revolut/success?admin_service="+admin_service+"&user_type="+user_type+"&transaction_id="+transaction_id+"&type_id="+type_id;

//                  location.reload();
              }, 
              error: function(jqXHR, textStatus, errorThrown) {
                      
                    //   if (jqXHR.status == 401 && getToken(guard) != null) {
                    //      refreshToken(guard);
                    //   } else if (jqXHR.status == 401) {
                    //      window.location.replace("/login");
                    //   }

                      if (jqXHR.responseJSON) {
                         
                         alertMessage(textStatus, jqXHR.responseJSON.message, "danger");
                      }
                      hideInlineLoader();
                } 
          });
  }
   </script>
   @if(Helper::getChatmode() == 1)
      <!-- Start of LiveChat (www.livechatinc.com) code -->
      <script type="text/javascript"  src="{{ asset('assets/layout/js/common-chat.js') }}"></script>
      <!-- End of LiveChat code -->
   @endif
   </body>
</html>

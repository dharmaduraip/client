<!doctype html>
{{ App::setLocale(   isset($_COOKIE['shop_language']) ? $_COOKIE['shop_language'] : 'en'  ) }}
<html class="no-js h-100" lang="en">
   <head>
      <meta charset="utf-8">
      <meta http-equiv="x-ua-compatible" content="ie=edge">
      <title>@section('title') @show</title>
      <meta name="description" content="Xjek App">
       <link rel="shortcut icon" type="image/png" href="{{ Helper::getFavIcon() }}"/>
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      @section('styles')
      <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
      <link rel="stylesheet" href="{{ asset('assets/plugins/bootstrap/css/bootstrap.min.css')}}">
      <link rel="stylesheet" type="text/css" href="{{ asset('assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}"/>
      <link rel="stylesheet" type="text/css" href="{{ asset('assets/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css') }}"/>
      <link rel="stylesheet" type="text/css" href="{{ asset('assets/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css') }}"/>
      <link rel='stylesheet' type='text/css' href="{{ asset('assets/plugins/clockpicker-wearout/css/jquery-clockpicker.min.css')}}"/>
      <link rel="stylesheet" href="{{ asset('assets/plugins/font-awesome-4.7.0/css/font-awesome.min.css')}}">
      <link rel="stylesheet" href="{{ asset('assets/plugins/chart/css/export.css')}}"/>
      <link rel="stylesheet" href="{{ asset('assets/plugins/extras/css/extras.min.css')}}">
      <link rel="stylesheet"  type='text/css' href="{{ asset('assets/plugins/intl-tel-input/css/intlTelInput.min.css')}}" />
      <link rel="stylesheet" href="{{ asset('assets/layout/css/admin-style.css')}}">
      <link rel="stylesheet" href="{{ asset('assets/layout/css/dashboards.min.css')}}">
     @show
      <!-- <link rel="stylesheet" href="{{ asset('assets/layout/css/arabic_style.css')}}"> -->
      <script> window.Laravel = {csrfToken : '{{ csrf_token() }}'}; </script>
      <script src="{{ asset('assets/plugins/jquery-3.3.1.min.js')}}"></script>
    
      <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/3.1.2/rollups/aes.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/3.1.2/rollups/pbkdf2.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/3.1.2/rollups/sha1.js"></script>
      <script src="https://momentjs.com/downloads/moment.min.js"></script>
      <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/3.1.2/rollups/sha512.js"></script> -->
      <style type="text/css">
         .dz-preview .dz-image img{
            width: 100% !important;
            height: 100% !important;
            object-fit: cover;
         }
         .intl-tel-input{
            width: 100%;
            display: block !important;
         }
         .notifications a i {
            font-size: 28px;
            color: #313030;
         }
         .notifications span.count {
            position: absolute;
             background: #e73d39;
             color: #fff;
             border-radius: 50%;
             width: 20px;
             height: 20px;
             text-align: center;
             padding: 0px;
             left: 20px;
             top: 2px;
         }
         .notification-block {
             border-bottom: 1px solid #e5e5e5;
             padding: 15px 0;
         }
         .notification-block img {
            float: right;
            width: 30%;
            padding: 15px;
         }
         .notify-time {
            font-size: 14px;
            display: flex;
            justify-content: flex-end;
         }
         .date i {
            padding-right: 5px;
         }
         .notification-modal .modal-body {
            max-height: 400px;
            overflow: auto;
         }
         .notification-modal {
            margin-top: 5%;

         }
         .notification-modal .modal-footer {
            border-top: 1px solid transparent;
         }
</style>
   </head>
   <body class="h-100">
       <audio id="beep-one" controls preload="auto" style="display:none">
                        <source src="{{ asset('assets/audio/beep.mp3')}}" controls></source>
                        <source src="{{ asset('assets/audio/beep.ogg')}}" controls></source>
                        Your browser isn't invited for super fun audio time.
          </audio>
   <!-- <div class="loader-container">
      <div class="lds-ripple"><div></div><div></div></div>
   </div> -->
      <!-- Color Change Setting Start -->
      <div class="container-fluid">
         <div class="row">
            <!-- Main Sidebar -->
            <aside class="main-sidebar col-12 col-md-3 col-lg-2 px-0">
               <div class="main-navbar">
                  <nav class="navbar align-items-stretch navbar-light flex-md-nowrap border-bottom p-0">
                     <a class="navbar-brand w-100 mr-0" href="{{ url('/shop/dashboard') }}">
                        <div class="d-table" style="margin-left: 24px;">
                           @if(isset(Helper::getSettings()->site->site_logo) && (Helper::getSettings()->site->site_logo !=""))
                              <img id="main-logo" class="d-inline-block align-top mr-1" src="{{Helper::getSettings()->site->site_logo}}" alt="Logo" style="max-width: 100px;height:50px;">
                           @else
                              <img id="main-logo" class="d-inline-block align-top mr-1" src="{{ asset('assets/layout/images/go-x logo.png')}}" alt="Logo" style="max-width: 100px;height:50px;">
                         
                           @endif
                       
                        </div>
                     </a>
                     <a class="toggle-sidebar d-sm-inline d-md-none d-lg-none">
                     <i class="material-icons">&#xE5C4;</i>
                     </a>
                  </nav>
               </div>
               <form action="#" class="main-sidebar__search w-100 border-right d-sm-flex d-md-none d-lg-none">
                  <div class="input-group input-group-seamless ml-3">
                     <div class="input-group-prepend">
                        <div class="input-group-text">
                           <i class="fas fa-search"></i>
                        </div>
                     </div>
                     <input class="navbar-search form-control" type="text" placeholder="Search for something..." aria-label="Search">
                  </div>
               </form>
               @include('order.shop.includes.nav')
            </aside>
            <!-- End Main Sidebar -->
            <main class="main-content col-lg-10 col-md-9 col-sm-12 p-0 offset-lg-2 offset-md-3">
               <div class="main-navbar sticky-top bg-white">
                  <nav class="navbar align-items-stretch navbar-light flex-md-nowrap p-0">
                     <form action="#" class="main-navbar__search w-100 d-none d-md-flex d-lg-flex">
                     <div class="alert alert-danger alert-dismissible is_bankdetails  fade in">
                           <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                           <strong>Please Fill Bank Details</strong><a href="{{URL::to('shop/bankdetail')}}">click here</a>.
                        </div>
                     </form>
                     <ul class="navbar-nav border-left flex-row ">
                        <!-- <li class="nav-item dropdown notifications"> -->
                           <!-- <a class="nav-link nav-link-icon text-center" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                              <div class="nav-link-icon__wrapper">
                                 <i class="material-icons">&#xE7F4;</i>
                                 <span class="badge badge-pill badge-danger">2</span>
                              </div>
                           </a> -->
                          <!--  <div class="dropdown-menu dropdown-menu-small" aria-labelledby="dropdownMenuLink">
                              <a class="dropdown-item" href="#">
                                 <div class="notification__icon-wrapper">
                                    <div class="notification__icon">
                                       <i class="material-icons">&#xE6E1;</i>
                                    </div>
                                 </div>
                                 <div class="notification__content">
                                    <span class="notification__category">Analytics</span>
                                    <p>Your website’s active users count increased by
                                       <span class="text-success text-semibold">28%</span> in the last week. Great job!
                                    </p>
                                 </div>
                              </a>
                              <a class="dropdown-item" href="#">
                                 <div class="notification__icon-wrapper">
                                    <div class="notification__icon">
                                       <i class="material-icons">&#xE8D1;</i>
                                    </div>
                                 </div>
                                 <div class="notification__content">
                                    <span class="notification__category">Sales</span>
                                    <p>Last week your store’s sales count decreased by
                                       <span class="text-danger text-semibold">5.52%</span>. It could have been worse!
                                    </p>
                                 </div>
                              </a>
                              <a class="dropdown-item notification__all text-center" href="#"> View all Notifications </a>
                           </div> -->
                        <!-- </li> -->
                        <li class="nav-item notifications" >
                           <a href="#" id="notification" class="nav-link" data-toggle="modal" data-target="#exampleModal">
                              <!-- <i class="material-icons">&#xE7F4;</i> -->
                              <i class="fa fa-bell"></i>
                              <span class="count notification_count" ></span>
                           </a>
                        </li>
                        <li class="nav-item dropdown" style="text-align: right;margin-right: 25px;">
                           <a class="nav-link dropdown-toggle text-nowrap px-3" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                           <img class="user_picture rounded-circle mr-2 img-fluid" src="" alt="Profile" style="width: 50px; height: 50px;">
                           <span class="d-none d-md-inline-block user_name"></span>
                           </a>
                           <div class="dropdown-menu dropdown-menu-small">
                               
                               @permission('change-password')
                                 <a class="dropdown-item" href="{{ url('shop/password')}}">
                                    <i class="material-icons">&#xE7FD;</i> Change Password
                                 </a>
                               @endpermission
                                <a class="dropdown-item" href="{{ url('shop/language')}}">
                                    <i class="material-icons">&#xE7FD;</i> Change Language
                                 </a>
                              <!-- <a class="dropdown-item" href="{{url('admin/profile')}}">
                              <i class="material-icons">vertical_split</i> Blog Posts</a>
                              <a class="dropdown-item" href="add-new-post.html">
                              <i class="material-icons">note_add</i> Add New Post</a> -->
                              <div class="dropdown-divider"></div>
                              <a class="dropdown-item text-danger" href="{{url('/shop/logout') }}">
                                 <i class="material-icons text-danger">&#xE879;</i> Logout 
                              </a>
                           </div>
                        </li>
                       <!--  <li class="nav-item dropdown">
                           <div class="form-group">
                              <select class="lang_group custom-select" name="formal" onchange="javascript:inputSelect(this)">
                                 <option value="#" selected>Engilsh</option>
                                 <option value="arabic">Arabic</option>
                              </select>
                           </div>
                        </li> -->
                     </ul>
                     <nav class="nav">
                        <a href="#" class="nav-link nav-link-icon toggle-sidebar d-md-inline d-lg-none text-center border-left" data-toggle="collapse" data-target=".header-navbar" aria-expanded="false" aria-controls="header-navbar">
                        <i class="material-icons">&#xE5D2;</i>
                        </a>
                     </nav>
                  </nav>
               </div>


               <!-- Modal -->
               <div class="modal fade notification-modal" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                 <div class="modal-dialog modal-lg" role="document">
                   <div class="modal-content">
                     <div class="modal-header">
                       <h5 class="modal-title" id="exampleModalLabel">Notifications</h5>
                       <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                         <span aria-hidden="true">&times;</span>
                       </button>
                     </div>
                     <div class="modal-body" id="notification_detail">
                           
                     </div>
                     <div class="modal-footer">  
                        <a className=" m-2 c-pointer btn btn-red "  data-dismiss="modal">Close</a>

                     </div>
                   </div>
                 </div>
               </div>

               @component('common.admin.components.delete-modal')
               @endcomponent
               @component('common.admin.components.crud-modal')
               @endcomponent

               <div id="toaster" class="toaster">
               @include('common.admin.components.toast')
               </div>

               @yield('content')
               <footer class="main-footer d-flex p-2 px-3 bg-white border-top">
                  <span class="copyright mr-auto my-auto mr-2">
                     @if(isset(Helper::getSettings()->site->site_copyright))
                     {!! Helper::getSettings()->site->site_copyright !!}
                     @endif
                  </span>
               </footer>
            </main>
         </div>
      </div>
      @section('scripts')
     
      <script src="{{ asset('assets/plugins/popper.min.js')}}"></script>
      <script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.min.js')}}"></script>
      <script src="{{ asset('assets/plugins/shards/js/shards.min.js')}}"></script>
      <script src="{{ asset('assets/plugins//jquery.sharrre.min.js')}}"></script>
      <script src="{{ asset('assets/plugins/extras/js/extras.min.js')}}"></script>

      <script src="{{ asset('assets/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
      <script src="{{ asset('assets/plugins/jquery-validation/additional-methods.min.js') }}" ></script>

      <script type="text/javascript" src="{{ asset('assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
      <script type="text/javascript" src="{{ asset('assets/plugins/bootstrap-timepicker/js/bootstrap-timepicker.js') }}"></script>
      <script type="text/javascript" src="{{ asset('assets/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js') }}"></script>
      <script type="text/javascript" src="{{ asset('assets/plugins/clockpicker-wearout/js/jquery-clockpicker.min.js') }}"></script>
      <!-- <script src="{{ asset('assets/plugins/dashboard/js/dashboards.min.js')}}"></script> -->
      <script src="{{ asset('assets/layout/js/script.js')}}"></script>
      <script src="{{ asset('assets/layout/js/api.js')}}"></script>
      <script type="text/javascript" src="{{ asset('assets/plugins/intl-tel-input/js/intlTelInput-jquery.min.js') }}"></script> 
      <script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.3.0/socket.io.js"></script>
      @show     

      <script type="text/javascript">
         $(document).ready(function(){           
            $("a.toggle-sidebar").click(function(){
            $('.main-sidebar').toggleClass('open');
         });
         });
      </script>
      <script>    

         window.room = '{{base64_decode(Helper::getSaltKey())}}'; 
         window.socket_url = '{{Helper::getSocketUrl()}}';
         window.shop_id='{{Session::get("shop_id")}}';

         if(getToken("shop") != null && window.shop_id == "") {
            window.location.replace("{{ url('/shop/login') }}");
         }

         checkAuthentication("shop");
         var shopSettings = getShopDetails();
         //console.log(shopSettings);

          if(shopSettings.store_type == "OTHERS") {
                $('.addon_menu').hide();
            }

          if( shopSettings.is_bankdetail==0){
            $('.is_bankdetails').addClass('show');
         }else{
            $('.is_bankdetails').removeClass('show');
         }
         
         $(document).ready(function() {
            $(".user_name").text(shopSettings.store_name != null ? shopSettings.store_name : "GoX" );
            
            if(shopSettings.picture){

               $(".user_name").text(shopSettings.store_name);
               $(".user_picture").attr('src', shopSettings.picture);

            }else{
               $(".user_picture").attr('src', "http://127.0.0.1:8000/assets/layout/images/admin/shards-dashboards-logo.svg");
            }

            @if(Request::segment(2)!='view')
            var dtable = $('#data-table').dataTable().api();

            $(".dataTables_filter input")
            .unbind() // Unbind previous default bindings
            .bind("input", function(e) { // Bind our desired behavior
               // If the length is 3 or more characters, or the user pressed ENTER, search
               if(this.value.length >= 3 || e.keyCode == 13) {
                     // Call the API search function
                     dtable.search(this.value).draw();
               }
               // Ensure we clear the search if they backspace far enough
               if(this.value == "") {
                     dtable.search("").draw();
               }
               return;
            });
            
            @endif

         });
         var current_title=$(document).find("title").text();
        var site_name="{{Helper::getSettings()->site->site_title}}";        
        $(document).find("title").text(site_name+' '+current_title);

   $(document).ready(function() {
      var socketshop = io.connect(window.socket_url);
        socketshop.emit('joinShopRoom', `room_${window.room}_shop_${window.shop_id}`);
        socketshop.on('newRequest', function (data) {
            getNotice();
        });
        socketshop.on('socketStatus', function (data) {
             console.log(data);
        });

         function getNotice() {            
              $.ajax({
                  url: getBaseUrl() + "/shop/dispatcher/orders?type=ORDERED",
                  type: "get",
                  processData: false,
                  contentType: false,
                  headers: {
                      Authorization: "Bearer " + getToken("shop")
                  },
                  success: (response, textStatus, jqXHR) => {
                      var data = parseData(response);

                      if(data.responseData.length > 0) {
                          if(data.responseData[0].status == 'ORDERED') {
                              var medium = document.getElementById("beep-one");
                              const playAudio = medium.play();
                              if (playAudio !== null){
                                  playAudio.catch(() => { medium.play(); })
                              }
                              
                          }
                      }
                  }, error: (jqXHR, textStatus, errorThrown) => {}
              });
          }
       $(document).ready(function() {
 
              $.ajax({
                  url: getBaseUrl() + "/shop/getNotification",
                  type: "get",
                  processData: false,
                  contentType: false,
                  headers: {
                      Authorization: "Bearer " + getToken("shop")
                  },
                  success: (response, textStatus, jqXHR) => {
                     var data = parseData(response);
                   
                     $('.notification_count').text(data.responseData.total_count);
                  
                     
                  }, error: (jqXHR, textStatus, errorThrown) => {}
              });
         });

        });


      //For notification details
      jQuery('[id^=notification]').on('click', function(){
         $.ajax({
            url: getBaseUrl() + "/shop/notification",
            type: "GET",
            headers: {
               Authorization: "Bearer " + getToken("shop")
            },
            beforeSend: function (request) {
               showInlineLoader();
            },
            success:function(data){
               var html = ``;
               var result = data.responseData.notification.data;
               if(result.length>0){
                     //$('#notification_count').text(result.length);
                     $.each(result,function(key,item){

                       html += ` <div class="row">
                              <div class="col-md-12">     
                                                       
                                 <div class="notification-block"> `;
                                 if(item.image)
                                 {
                                    html += `<img class="img-fluid" src=`+item.image+`>`;
                                 }
                                 html += `<h6 class="notify-title">`+item.title+`</h6>
                                    <p class="notify-cnt"> `+item.descriptions+`</p> 
                                    <div class="notify-time">
                                       <span class="date"><i class="fa fa-clock"></i>`+item.time_at+`</span>
                                    </div>   
                                 </div>
                                 
                                
                              </div>
                           </div>`; 

                     });
                  }
                  $('#notification_detail').html(html);
                  hideInlineLoader();
            } 
         }); 
      });


      </script>
     @if(Helper::getChatmode() == 1)
      <!-- Start of LiveChat (www.livechatinc.com) code -->
      <script type="text/javascript"  src="{{ asset('assets/layout/js/common-chat.js') }}"></script>
      <!-- End of LiveChat code -->
      @endif



   </body>
</html>

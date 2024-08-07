<!doctype html>
<html class="no-js h-100" lang="en">
   <head>
      <meta charset="utf-8">
      <meta http-equiv="x-ua-compatible" content="ie=edge">
      <title>@section('title') @show</title>
      <meta name="description" content="Xjek App">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <link rel="shortcut icon" type="image/png" href="{{ Helper::getFavIcon() }}"/>
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
      </style>
   </head>
   <body class="h-100">
      <!-- Color Change Setting Start -->
      <div class="container-fluid">
         <div class="row">
            <!-- End Main Sidebar -->
            <main class="main-content col-sm-12 p-0">
               <div class="main-navbar sticky-top bg-white">
                  <nav class="navbar align-items-stretch navbar-light flex-md-nowrap p-0">
                     <form action="#" class="main-navbar__search w-100 d-none d-md-flex d-lg-flex">
                       
                        <div class="alert alert-danger alert-dismissible is_bankdetails  fade in">
                           <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                           <strong>Please Fill Bank Details</strong><a href="{{URL::to('admin/bankdetails')}}">click here</a>.
                        </div>
                     </form>
                     <ul class="navbar-nav border-left flex-row ">
                        <li class="nav-item dropdown notifications">
                           <div class="dropdown-menu dropdown-menu-small" aria-labelledby="dropdownMenuLink">
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
                           </div>
                        </li>
                     </ul>
                     <nav class="nav">
                        <a href="#" class="nav-link nav-link-icon toggle-sidebar d-md-inline d-lg-none text-center border-left"  data-toggle="collapse" data-target=".header-navbar" aria-expanded="false" aria-controls="header-navbar">
                        <i class="material-icons">&#xE5D2;</i>
                        </a>
                     </nav>
                  </nav>
               </div>

               <div class="main-content-container container-fluid px-4">
    <div class="row mb-4 mt-20">
        <div class="col-md-12">
            <div class="card card-small" style="padding:20px; text-align: center;">
                

                <h2 style="color: red;">{{ __('Your installation limit has been exceeded') }}</h2>
                <h5 style="color: red;">{{ __('Please contact appdupe.com') }}</h5>

                
            </div>
        </div>
    </div>
</div>
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

      @show     
   </body>
</html>

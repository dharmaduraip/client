<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>{{config('sximo.cnf_appname') }}</title>
<link rel="shortcut icon" href="{{ asset('favicon.ico')}}" type="image/x-icon">
    <link href='https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Material+Icons' rel="stylesheet">


<link href="{{ asset('sximo5/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
<link href="{{ asset('sximo5/css/core.css')}}" rel="stylesheet">
    <link href="{{ asset('sximo5/js/plugins/iCheck/skins/square/green.css')}}" rel="stylesheet">
    <link href="{{ asset('sximo5/js/plugins/toast/css/jquery.toast.css')}}" rel="stylesheet">


    <link href="{{ asset('sximo5/fonts/awesome/css/font-awesome.min.css')}}" rel="stylesheet">

    <!-- Sximo 5 Main CSS -->



<!--<link href="{{ asset('sximo5/css/sximo.css')}}" rel="stylesheet"> -->

    <script type="text/javascript" src="{{ asset('sximo5/sximo.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('sximo5/js/sximo.js') }}"></script>
    <script type="text/javascript" src="{{ asset('sximo5/js/plugins/toast/js/jquery.toast.js') }}"></script>

    <script src='https://www.google.com/recaptcha/api.js'></script>

    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->  

    
  
    </head>
<body style="background-color: #fff" >
    <div class="auth-wrapper">
        <div class="container-fluid h-100">
            <div class="row flex-row h-100 bg-white">
                <div class="col-xl-8 col-lg-6 col-md-5 p-0 d-md-block d-lg-block d-sm-none d-none">
                    <div class="lavalite-bg" style="background-image: url('<?php echo asset('sximo5/images/register-bg.jpg') ;?>')">
                        <div class="lavalite-overlay"></div>
                    </div>
                </div>

                <div class="col-xl-4 col-lg-6 col-md-7 my-auto p-0">

                    <div class="login-box">
                    
                            <div class="text-center">
                            @if(file_exists(public_path().'/uploads/images/'.config('sximo')['cnf_logo']) && config('sximo')['cnf_logo'] !='')
                            <img src="{{ asset('uploads/images/'.config('sximo')['cnf_logo'])}}" alt="{{ config('sximo')['cnf_appname'] }}" width="90" />
                            @else
                            <img src="{{ asset('uploads/logo.png')}}" alt="{{ config('sximo')['cnf_appname'] }}" width="100" />
                            @endif
                                </div>
                            <div class="p-2"><b style="text-transform:uppercase " class="mt-2"  > {{ config('sximo.cnf_appdesc') }}  </b></div>    

                        @yield('content') 
                    
                </div>

                </div>

            </div>
        </div>
    </div>    
<!--
    <div class="login-page">
        <div class="wrapper">
             <div class="login-box">
                
                        <div >
                        @if(file_exists(public_path().'/uploads/images/'.config('sximo')['cnf_logo']) && config('sximo')['cnf_logo'] !='')
                        <img src="{{ asset('uploads/images/'.config('sximo')['cnf_logo'])}}" alt="{{ config('sximo')['cnf_appname'] }}" width="90" />
                        @else
                        <img src="{{ asset('uploads/logo.png')}}" alt="{{ config('sximo')['cnf_appname'] }}" width="100" />
                        @endif
                            </div>
                        <div class="p-2"><b style="text-transform:uppercase " class="mt-2"  > {{ config('sximo.cnf_appdesc') }}  </b></div>    

                    @yield('content') 
                
            </div>
        </div>    
    </div>
-->

</body> 
</html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title> {{ config('sximo.cnf_appname')}} </title>

    <link rel="shortcut icon" href="{{ asset('favicon.ico')}}" type="image/x-icon">

    <link href="{{ asset('sximo5/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{ asset('sximo5/sximo.min.css')}}" rel="stylesheet">
    <link href="{{ asset('sximo5/css/core.css')}}" rel="stylesheet">
    <link href="{{ asset('sximo5/css/theme.css')}}" rel="stylesheet">
    
    <link href="{{ asset('sximo5/js/plugins/summernote/dist/summernote-bs4.min.css') }}" rel="stylesheet">
    <!-- FONT -->
    <link href="{{ asset('sximo5/css/icons.min.css')}}" rel="stylesheet" >
    <link href="{{ asset('sximo5/fonts/awesome/fonts/font-awesome.min.css')}}" rel="stylesheet">
    <link href="{{ asset('sximo5/fonts/icomoon.css')}}" rel="stylesheet">
    <link href="{{ asset('sximo5/fonts/lineIcons/LineIcons.min.css')}}" rel="stylesheet">
    <link href="{{ asset('sximo5/fonts/awesome/css/font-awesome.min.css')}}" rel="stylesheet">
    <link href="{{ asset('sximo5/js/plugins/iCheck/skins/flat/blue.css')}}" rel="stylesheet">
    <link href="{{ asset('sximo5/js/plugins/sweetalert2/dist/sweetalert2.min.css')}}" rel="stylesheet">
    <link href="{{ asset('sximo5/js/plugins/toast/css/jquery.toast.css')}}" rel="stylesheet">
    <link href="{{ asset('sximo5/js/plugins/datatable/extensions/Responsive/css/responsive.dataTables.min.css')}}" rel="stylesheet">
    <link href="{{ asset('sximo5/js/admin/datatable/jquery.dataTables.min.css')}}" rel="stylesheet">

    {{-- dec --}}
    <link href="{{ asset('sximo5/css/admin/mystyle.css')}}" rel="stylesheet"> 
    {{-- dec --}}



    <script type="text/javascript" src="{{ asset('sximo5/sximo.min.js') }}"></script>
    <script type="text/javascript" language="javascript" src="{{ asset('sximo5/js/plugins/datatable/jquery.dataTables.min.js')}}"></script>
    <script type="text/javascript" src="{{ asset('sximo5/js/plugins/datatable/extensions/Responsive/js/dataTables.responsive.min.js')}}"></script> 
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script type="text/javascript" src="{{ asset('sximo5/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('sximo5/js/plugins/summernote')}}/dist/summernote.min.js"></script>
    <script src="{{ asset('sximo5/js/plugins/summernote/plugin')}}/summernote-ext-highlight.min.js"></script>




    <script type="text/javascript" src="{{ asset('sximo5/js/plugins/sweetalert2/dist/sweetalert2.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('sximo5/js/plugins/node-waves/waves.js') }}"></script>
    <script type="text/javascript" src="{{ asset('sximo5/js/sximo.js') }}"></script>
    <script type="text/javascript" src="{{ asset('sximo5/js/plugins/prettify.js') }}"></script>
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->         


</head>
<body class="">
    <div id="preloader">
    </div>
    <div id="app" class="page-wrapper">
       @include('layouts.topnavigation')
        
        <div class="d-flex">
            @include('layouts.navigation')
            {{-- @include('layouts.header') --}}
            <main class="page-content" > 
                <div class="overlay"></div>
                <a href="javascript:;" class="toggleMenu flying-button d-md-inline-block d-none">
                    <i class="lni-menu"></i>
                </a>
                <div class="page-inner">
                    <div class="ajaxLoading"></div>   
                    @yield('content')
                </div>  
            </main>
        </div>
    </div>
    <div class="modal " id="sximo-modal" role="dialog" aria-hidden="true" tabindex="-1"  >
        <div class="modal-dialog modal-dialog-centered modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title">Modal title</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body"  id="sximo-modal-content">
                </div>
            </div>
        </div>
    </div>

<div class="modal" id="confirm-delete1" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{!! trans('core.abs_confirm_delete') !!}</h4>
                 <button type="button" class="close cls_popup" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
            </div>
            <div class="modal-body" id="sximo-modal-content">
                <p>Do you want to delete?</p>
            </div>
            <div class="modal-footer">
                <a class="btn btn-danger btn-ok" href="">{!! trans('core.btn_delete') !!}</a>
                <button type="button" class="btn btn-default cls_popup" data-dismiss="modal">{!! trans('core.close') !!}</button>
            </div>
        </div>
        </div>
    </div>



@if(\Auth::user()->group_id == 1)
        <script language="javascript">
        jQuery(document).ready(function($)  {
           // $('.markItUp').markItUp(mySettings );
        });
        </script>
@endif
{{ Sitehelpers::showNotification() }} 

</body>
</html>

@extends('common.admin.layout.base')
{{ App::setLocale(  isset($_COOKIE['admin_language']) ? $_COOKIE['admin_language'] : 'en'  ) }}

@section('title') {{ __('Help') }} @stop

@section('styles')
@parent
    <link rel="stylesheet" href="{{ asset('assets/plugins/data-tables/css/dataTables.bootstrap.min.css')}}"/>
    <link rel="stylesheet" href="{{ asset('assets/plugins/data-tables/css/responsive.bootstrap.min.css')}}">
@stop

@section('content')
                    <div class="main-content-container container-fluid px-4">
                        <!-- Page Header -->
                        <div class="page-header row no-gutters py-4">
                            <div class="col-12 col-sm-4 text-center text-sm-left mb-0">
                                <span class="text-uppercase page-subtitle">{{ __('Dashboard') }}</span>
                                <h3 class="page-title">{{ __('Help') }}</h3>
                            </div>
                        </div>
                        <div class="row mb-4 mt-20">
                            <div class="col-md-12">
                                <div class="card card-small">
                                    <div class="card-header border-bottom">
                                        <h6 class="m-0 pull-left">Help</h6>
                                    </div>
                                    <div class="col-md-12">
                                        <p>{{ __('We\'d like to thank you for deciding to use our script. We enjoyed creating it and hope you enjoy using it to achieve your goals :) If you want something changed to suit your venture\'s needs better, drop us a line') }}: <a href="mailto:info@easyjek.com">info@easyjek.com</a></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
@stop

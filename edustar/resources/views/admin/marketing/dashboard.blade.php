@extends('admin.layouts.master')
@section('title',__('Marketing Dashboard'))
@section('breadcum')
<div class="breadcrumbbar">
    <div class="row align-items-center">
        <div class="col-md-8 col-lg-8">
            <h4 class="page-title">{{ __('Home') }}</h4>
            <div class="breadcrumb-list">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">{{ __('Home') }}</a></li>
                    <li class="breadcrumb-item active">{{ __('Marketing Dashboard') }}</li>

                </ol>
            </div>
        </div>

    </div>
</div>
@endsection
@section('maincontent')
<div class="contentbar">
    <!-- Start row -->
    
        <div class="row">
            <!-- Start col -->
            <div class="col-xl-3 col-lg-4 col-sm-6 col-12">
                <div class="card m-b-30 bg-success-rgba shadow-sm">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h4>{{ filter_var($users) }}</h4>
                                <p class="font-14 mb-0">{{__('Users')}} <br> {{__('Purchase')}}
                                </p>
                            </div>
                            <div class="col-md-4 col-4">
                            <i class="text-success iconsize fa fa-user-plus" aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-4 col-sm-6 col-12 d-none">
                <div class="card m-b-30 bg-warning-rgba shadow-sm">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h4>{{ filter_var($total) }}  {{ filter_var($currencies) }}</h4>
                                <p class="font-14 mb-0">{{ __("Wallet") }}<br>{{ __('Amount') }}
                                </p>
                            
                            </div>
                            <div class="col-md-4 col-4">
                            <i class="text-warning iconsize fa fa-credit-card" aria-hidden="true"></i>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-4 col-sm-6 col-12">
                <div class="card m-b-30 bg-info-rgba shadow-sm">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h4>{{ filter_var($featured) }}</h4>
                                <p class="font-14 mb-0">{{ __('Featured') }}  <br> {{ __('Courses') }}
                                </p>
                            
                            </div>
                            <div class="col-md-4 col-4">
                            <i class="text-info iconsize fa fa-graduation-cap" aria-hidden="true"></i>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-4 col-sm-6 col-12">
                <div class="card m-b-30 bg-danger-rgba shadow-sm">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h4>{{ filter_var($coupan) }}</h4>
                                <p class="font-14 mb-0">{{ __('Active') }} <br>
                                    {{ __('Coupons') }}
                                </p>
                            
                            </div>
                            <div class="col-md-4 col-4">
                            <i class="text-danger iconsize fa fa-check-square-o" aria-hidden="true"></i>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-4 col-sm-6 col-12">
                <div class="card m-b-30 bg-secondary-rgba shadow-sm">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h4>{{ filter_var($total_order) }}  {{ filter_var($currencies) }}</h4>
                                <p class="font-14 mb-0">{{ __('Total') }} <br>
                                    {{ __('Revenue') }}
                                </p>
                            
                            </div>
                            <div class="col-md-4 col-4">
                            <i class="text-secondary iconsize fa fa-line-chart" aria-hidden="true"></i>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-4 col-sm-6 col-12">
                <div class="card m-b-30 bg-info-rgba shadow-sm">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h4>{{ filter_var($admin_total) }}  {{ filter_var($currencies) }}</h4>
                                <p class="font-14 mb-0">{{ __('Admin') }} <br>
                                    {{ __('Revenue') }}
                                </p>
                            
                            </div>
                            <div class="col-md-4 col-4">
                            <i class="text-info iconsize fa fa-usd" aria-hidden="true"></i>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-4 col-sm-6 col-12">
                <div class="card m-b-30 bg-primary-rgba shadow-sm">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h4>{{ filter_var($ins_payment) }}  {{ filter_var($currencies) }}</h4>
                                <p class="font-14 mb-0">{{ __('Instructors') }} <br>
                                    {{ __('Revenue') }}
                                </p>
                            
                            </div>
                            <div class="col-md-4 col-4">
                               <i class="text-primary iconsize fa fa-usd" aria-hidden="true"></i>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-12">
                <div class="card m-b-30">
                    <div class="card-header bg-border-red">
                        <h5 class="card-title">{{ __('Total Revenue') }}</h5>
                    </div>
                    <div class="card-body">
                        <div id="apex-line-chart"></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 mb-2">
                <div class="card m-b-30">
                    <div class="card-header bg-border-darkpurple">
                        <h5 class="card-title">{{__('Class Types')}}</h5>
                    </div>
                    <div class="card-body">
                        <div id="apex-pie-chart"></div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 mb-2">
                <div class="card m-b-30">
                    <div class="card-header bg-border-power">
                        <div class="row align-items-center">
                            <div class="col-9">
                                <h5 class="card-title mb-0">{{ __('Most Purchased  Courses') }}</h5>
                            </div>
                            <div class="col-3">
                                <div class="dropdown">
                                    <button class="btn btn-link p-0 font-18 float-right" type="button"
                                        id="upcomingTask" data-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false"><i class="feather icon-more-horizontal-"></i></button>
                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="upcomingTask">
                                        <a href="{{url('order')}}"
                                            class="dropdown-item font-13">{{ __('View All') }}</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                           
                            <table class="table table-borderless">
                                <thead>
                                    <tr>
                                        <th>{{ __('User Name') }}</th>
                                        <th>{{ __('Order Count') }}</th>
                                        <th>{{ __('Total Amount') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($user_order_count as $value)
                                    <tr>
                                        <td>
                                           {{ filter_var($value->fname) }}
                                        </td>
                                        <td>
                                           {{ filter_var($value->order_count) }}
                                        </td>
                                        <td>
                                          {{ filter_var($value->total_amount) }} {{ filter_var($currencies) }}
                                        </td>
                                        
                                       
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            
                        </div>
                    </div>
                </div>
            </div>
        
    </div>
</div>

               

@endsection
@section('scripts')
<script>
        var order_total = @json($order_total);
        var graph = @json($graph);
    "use strict";
$(document).ready(function() {
    /* -----  Apex Line Chart ----- */
    var options = {
        chart: {
            height: 300,
            type: 'line',
            toolbar: {
                show: false
            },
            zoom: {
                enabled: false
            }
        },
        colors: ['#506fe4'],
        series: [{
            name: "Total Amount",
            data: order_total
        }],
        dataLabels: {
            enabled: false
        },
        stroke: {
            curve: 'straight'
        },
        grid: {
            row: {
                colors: ['transparent', 'transparent'], opacity: .2
            },
            borderColor: 'rgba(0,0,0,0.05)'
        },
        
        xaxis: {
            categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep','Oct','Nov','Dec'],
            axisBorder: {
                show: true, 
                color: 'rgba(0,0,0,0.05)',
                
            },
            axisTicks: {
                show: true, 
                color: 'rgba(0,0,0,0.05)',
                
            }
        }
    }
    var chart = new ApexCharts(
        document.querySelector("#apex-line-chart"),
        options
    );
    chart.render();
});

var options = {
        chart: {
            type: 'donut',
            width: 300,
        },
        plotOptions: {
            pie: {
                donut: {
                    size: "85%"
                }
            }
        },
        dataLabels: {
            enabled: false
        },
        colors: ['#00e6e6','#43d187','#1a1aff'],
        series: graph,
        labels: ['Courses', 'Bundle Courses', 'Live Meetings'],
        legend: {
            show: true,
            position: 'bottom'
        },
    }
    var chart = new ApexCharts(
        document.querySelector("#apex-pie-chart"),
        options
    );        
    chart.render();

</script>
@endsection
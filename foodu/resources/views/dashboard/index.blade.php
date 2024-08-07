@extends('layouts.app')
@section('content')
<script type="text/javascript" src="{{ asset('sximo5/js/admin/icon.js') }}"></script>
<script type="text/javascript" src="{{ asset('sximo5/js/plugins/highcharts/highcharts.js') }}"></script>
<script type="text/javascript">
    
jQuery(document).ready(function() {
    jQuery('.number, .squarebox h4').each(function () {
        $(this).prop('Counter',0).animate({
            Counter: $(this).text()
        }, {
            duration: 4000,
            easing: 'swing',
            step: function (now) {
                $(this).text(Math.ceil(now));
            }
        });
    });
})
</script>
<div class="page-header"><h2>  Dashboard <small class="small-title">  Summary info site </small> </h2></div>
<div class="pt-5 px-4 pb-4">
    <div class="row">
        <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12 animated fadeInUpBig my-2">
            <div class=" info-box" >
                <div class="icon bg-orange">
                    <i class="icon-users2"></i>
                </div>
                <div class="content">
                    <h4> {{$today_register}} </h4>
                    {!! trans('core.abs_registered_users') !!}
                    <div class="info">
                        <p class="pull-left">Last Week : {{$week_register}}</p>
                        <p class="pull-right">Last Month : {{$month_register}}</p>
                    </div>
                </div>
            </div>
        </div>


        <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12 animated fadeInLeftBig my-2">
            <div class=" info-box" >
                <div class="icon bg-cyan">
                    <i class="icon-users"></i>
                </div>
                <div class="content">
                    <h4> {{$today_register_partner}} </h4>
                    {!! trans('core.abs_registered_partners') !!}
                    <div class="info">
                        <p class="pull-left">Last Week : {{$week_register_partner}}</p>
                        <p class="pull-right">Last Month : {{$month_register_partner}}</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12 animated fadeInRightBig my-2">
            <div class=" info-box" >
                <div class="icon bg-red">
                    <i class="fa fa-rupee"></i>
                </div>
                <div class="content">
                    <h4> {{$admin_today_earnings}} </h4>
                    Today's Earnings
                    <div class="info">
                        <p class="pull-left">Last Week : {{$admin_weekly_earnings}}</p>
                        <p class="pull-right">Last Month : {{$admin_monthly_earnings}}</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12 animated fadeInDownBig my-2">
            <div class=" info-box" >
                <div class="icon bg-green">
                    <i class="icon-office"></i>
                </div>
                <div class="content">
                    <h4> {{$today_register_pending_partner}} </h4>
                    {!! trans('core.abs_pending_partners') !!}
                    <div class="info">
                        <p class="pull-left">Last Week : {{$week_register_pending_partner}}</p>
                        <p class="pull-right">Last Month : {{$month_register_pending_partner}}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- <div class="row">
        <div class="col-md-6">
            <div class="mt-4" id="chartjs"></div>
        </div>
        <div class="col-md-6">
            <div class="mt-4" id="chartjs2"></div>
        </div>
    </div> --}}
</div>
{{-- <div class="toolbar-nav">
    <div class="container-fluid px-0 py-3">
        <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-6 margin_10 animated fadeInUpBig my-2">
                <!-- Trans label pie charts strats here-->
                <div class="palebluecolorbg no-radius w-100 h-100 p-1">
                    <div class="panel-body squarebox square_boxs">
                        <div class="d-flex justify-content-between flex-column">
                            <div class="row justify-content-between m-0">
                                <div class="square_box col-sm-6 col-3 p-0">
                                    <span class="text-white">Registered Users</span>

                                    <div class="number text-white" id="myTargetElement4">540</div>
                                </div>
                                <div class="col-sm-6 col-3 p-0 text-right">
                                    <i class="livicon" data-name="users" data-l="true" data-c="#fff" data-hc="#fff" data-s="70" id="livicon-52" style="width: 70px; height: 70px;"></i>
                                </div>
                            </div>
                            <div class="row justify-content-between m-0">
                                <div class="col-sm-6 col-3 p-0">
                                    <small class="stat-label text-white">Last Week</small>
                                    <h4 id="myTargetElement4.1" class="text-white">1</h4>
                                </div>
                                <div class="col-sm-6 col-3 p-0 text-right">
                                    <small class="stat-label text-white">Last Month</small>
                                    <h4 id="myTargetElement4.2" class="text-white">73</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 margin_10 animated fadeInLeftBig my-2">
                <!-- Trans label pie charts strats here-->
                <div class="palegreencolorbg no-radius w-100 h-100 p-1">
                    <div class="panel-body squarebox square_boxs">
                        <div class="d-flex justify-content-between flex-column">
                            <div class="row justify-content-between m-0">
                                <div class="square_box col-sm-6 col-3 p-0">
                                    <span class="text-white">Registered Partners</span>

                                    <div class="number text-white" id="myTargetElement4">540</div>
                                </div>
                                <div class="col-sm-6 col-3 p-0 text-right">
                                    <i class="livicon" data-name="users" data-l="true" data-c="#fff" data-hc="#fff" data-s="70" id="livicon-51" style="width: 70px; height: 70px;"></i>
                                </div>
                            </div>
                            <div class="row justify-content-between m-0">
                                <div class="col-sm-6 col-3 p-0">
                                    <small class="stat-label text-white">Last Week</small>
                                    <h4 id="myTargetElement4.1" class="text-white">5</h4>
                                </div>
                                <div class="col-sm-6 col-3 p-0 text-right">
                                    <small class="stat-label text-white">Last Month</small>
                                    <h4 id="myTargetElement4.2" class="text-white">47</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 margin_10 animated fadeInRightBig my-2">
                <!-- Trans label pie charts strats here-->
                <div class="redbg no-radius w-100 h-100 p-1">
                    <div class="panel-body squarebox square_boxs">
                        <div class="d-flex justify-content-between flex-column">
                            <div class="row justify-content-between m-0">
                                <div class="square_box col-sm-6 col-3 p-0">
                                    <span class="text-white">Today's Sales</span>

                                    <div class="number text-white" id="myTargetElement2">540</div>
                                </div>
                                <div class="col-sm-6 col-3 p-0 text-right">
                                    <i class="livicon" data-name="piggybank" data-l="true" data-c="#fff" data-hc="#fff" data-s="70" id="livicon-49" style="width: 70px; height: 70px;"></i>
                                </div>
                            </div>
                            <div class="row justify-content-between m-0">
                                <div class="col-sm-6 col-3 p-0">
                                    <small class="stat-label text-white">Last Week</small>
                                    <h4 id="myTargetElement2.1" class="text-white">6</h4>
                                </div>
                                <div class="col-sm-6 col-3 p-0 text-right">
                                    <small class="stat-label text-white">Last Month</small>
                                    <h4 id="myTargetElement2.2" class="text-white">99</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6 col-md-6 margin_10 animated fadeInDownBig my-2">
                <!-- Trans label pie charts strats here-->
                <div class="goldbg no-radius w-100 h-100 p-1">
                    <div class="panel-body squarebox square_boxs">
                        <div class="d-flex justify-content-between flex-column">
                            <div class="row justify-content-between m-0">
                                <div class="square_box col-sm-6 col-3 p-0">
                                    <span class="text-white">Pending request of partners</span>

                                    <div class="number text-white" id="myTargetElement3">540</div>
                                </div>
                                <div class="col-sm-6 col-3 p-0 text-right">
                                    <i class="livicon" data-name="archive-add" data-l="true" data-c="#fff" data-hc="#fff" data-s="70" id="livicon-50" style="width: 70px; height: 70px;"></i>
                                </div>
                            </div>
                            <div class="row justify-content-between m-0">
                                <div class="col-sm-6 col-3 p-0">
                                    <small class="stat-label text-white">Last Week</small>
                                    <h4 id="myTargetElement3.1" class="text-white">13</h4>
                                </div>
                                <div class="col-sm-6 col-3 p-0 text-right">
                                    <small class="stat-label text-white">Last Month</small>
                                    <h4 id="myTargetElement3.2" class="text-white">55</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> --}}
<div class="p-3">
    <div class="table-container m-0">
        <div class="m-t">
            <div class="col-md-12 p-0">
              <div class="sbox border-custom">
                <div class="sbox-title"> 
                  <h3 class="m-0"> Recent Order Details <small class="small-title"> ( Last Activity ) </small> </h3> 
                </div>
                <div class="sbox-content">
                  <div class="m-3 bg-light">
                    <div class="table-responsive border-custom" >      
                        <table class="table table-striped" id="example1" cellspacing="0" width="100%">
                            <thead>
                                <tr>                                
                                    <th> Order Id </th>
                                    <th> Date </th>                                                     
                                    <th> Ordered Time </th> 
                                    <th>Cust Name</th>
                                    @if(\Auth::user()->group_id!='3')
                                    <th>Cust Mobile</th>
                                    @endif
                                    <th> Shop Name </th>
                                    <th> Grand Total </th>
                                    <th> Status </th>
                                    <th> {!! trans('core.time') !!} </th>   
                                    <th> Payment Status </th>
                                    <th> {!! trans('core.abs_payment_type') !!}</th>
                                    @if(PICKDEL_OPTION == 'enable')
                                    <th> Customer Preference </th>
                                    @endif
                                    @if(PREORDER_OPTION == 'enable')
                                    <th> Order Type </th>
                                    @endif
                                    <th width="70" >View</th>
                                </tr>
                            </thead>
                            <tbody class="table_Content"> 
                                @foreach ($results as $key => $row)
                                <?php $res_call = \AbserveHelpers::getRestaurantDetails($row->res_id); 
                                        date_default_timezone_set("Asia/Kolkata"); ?>
                                        
                                        <tr @if($row->delivery_type=='razorpay' && $row->delivery =='unpaid') style="background-color: #FBD9D9" @endif>                         
                                            <td>{{$row->id}}</td>   
                                            <td>{{\AbserveHelpers::getdateformat($row->date)}}</td> 
                                            <td>{{date('g:i a',$row->time)}}</td>
                                            <td>{{isset($row->user_info->username) ? $row->user_info->username : ''}}</td>  
                                            @if(\Auth::user()->group_id!='3')                       
                                            <td>{{$row->mobile_num}}</td>
                                            @endif
                                            <td>{{$row->restaurant->name}}</td>
                                            @if(\Auth::user()->group_id=='1')
                                            <td>{{\AbserveHelpers::CurrencyValueBackend($row->grand_total)}}</td>
                                            @else
                                            <td>{{\AbserveHelpers::CurrencyValueBackend($row->grand_total)}}</td>
                                            @endif
                                            <td><span class="label status {!! $row->status_label !!}">{!! $row->status_text !!}</span>
                                            </td>
                                            @if($row->status == 6)
                                            <?php $row->status=1; ?>
                                            @endif
                                            <td>{{\AbserveHelpers::getOrderStatusTime($row->id,$row->status)}}</td>
                                            <td>{!! ($row->delivery =='paid' ? '<span class="label label-success">Paid</span>' : '<span class="label label-danger">Unpaid</span>')  !!}</td>
                                            <td>{{ $row->delivery_type }}</td> 
                                            @if(PICKDEL_OPTION == 'enable')
                                            <td>{{ strtoupper($row->delivery_preference) }}</td>
                                            @endif
                                            <td>{{ strtoupper($row->order_type) }}</td>
                                            <td>
                                            <a href="javascript:void(0);" class="btn order-details" data-id="{!!$row->id!!}"><i class="fa fa-info-circle"></i></a>
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
            <div class="modal fade" id="orderModal" role="dialog">
                <div class="modal-dialog modal-lg">
                     <div class="modal-content order-content">
            
                    </div>
                </div>
            </div>      
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).on('click','.order-details',function(){
        var base_url = '<?php echo URL::to(''); ?>';
        var id = $(this).attr('data-id');
        $.ajax({
            type : 'POST',
            url : base_url+'/user/allorderdetails',
            data : {id:id},
            success:function(data){
                $('#orderModal').modal('show');
                $('.order-content').html(data);
            }
        })
    });
    setTimeout(function(){window.location.reload();},120000);
</script>

<!-- <script type="text/javascript">
    Highcharts.chart('chartjs', {
        chart: {
            type: 'area'
        },
        title: {
            text: 'Area chart with negative values'
        },
        xAxis: {
            categories: ['Apples', 'Oranges', 'Pears', 'Grapes', 'Bananas']
        },
        credits: {
            enabled: false
        },
        series: [{
            name: 'John',
            data: [5, 3, 4, 7, 2]
        }, {
            name: 'Jane',
            data: [2, -2, -3, 2, 1]
        }, {
            name: 'Joe',
            data: [3, 4, 4, -2, 5]
        }]
    });

    Highcharts.chart('chartjs2', {
        chart: {
            type: 'spline',
            scrollablePlotArea: {
                minWidth: 600,
                scrollPositionX: 1
            }
        },
        title: {
            text: 'Wind speed during two days',
            align: 'left'
        },
        subtitle: {
            text: '13th & 14th of February, 2018 at two locations in Vik i Sogn, Norway',
            align: 'left'
        },
        xAxis: {
            type: 'datetime',
            labels: {
                overflow: 'justify'
            }
        },
        yAxis: {
            title: {
                text: 'Wind speed (m/s)'
            },
            minorGridLineWidth: 0,
            gridLineWidth: 0,
            alternateGridColor: null,
            plotBands: [{ 
                // Light air
                from: 0.3,
                to: 1.5,
                color: 'rgba(68, 170, 213, 0.1)',
                label: {
                    text: 'Light air',
                    style: {
                        color: '#606060'
                    }
                }
            }, {
                // Light breeze
                from: 1.5,
                to: 3.3,
                color: 'rgba(0, 0, 0, 0)',
                label: {
                    text: 'Light breeze',
                    style: {
                        color: '#606060'
                    }
                }
            }, {
                // Gentle breeze
                from: 3.3,
                to: 5.5,
                color: 'rgba(68, 170, 213, 0.1)',
                label: {
                    text: 'Gentle breeze',
                    style: {
                        color: '#606060'
                    }
                }
            }, {
                // Moderate breeze
                from: 5.5,
                to: 8,
                color: 'rgba(0, 0, 0, 0)',
                label: {
                    text: 'Moderate breeze',
                    style: {
                        color: '#606060'
                    }
                }
            }, {
                // Fresh breeze
                from: 8,
                to: 11,
                color: 'rgba(68, 170, 213, 0.1)',
                label: {
                    text: 'Fresh breeze',
                    style: {
                        color: '#606060'
                    }
                }
            }, {
                // Strong breeze
                from: 11,
                to: 14,
                color: 'rgba(0, 0, 0, 0)',
                label: {
                    text: 'Strong breeze',
                    style: {
                        color: '#606060'
                    }
                }
            }, {
                // High wind
                from: 14,
                to: 15,
                color: 'rgba(68, 170, 213, 0.1)',
                label: {
                    text: 'High wind',
                    style: {
                        color: '#606060'
                    }
                }
            }]
        },
        tooltip: {
            valueSuffix: ' m/s'
        },
        plotOptions: {
            spline: {
                lineWidth: 4,
                states: {
                    hover: {
                        lineWidth: 5
                    }
                },
                marker: {
                    enabled: false
                },
                pointInterval: 3600000, // one hour
                pointStart: Date.UTC(2018, 1, 13, 0, 0, 0)
            }
        },
        series: [{
            name: 'Hestavollane',
            data: [
            3.7, 3.3, 3.9, 5.1, 3.5, 3.8, 4.0, 5.0, 6.1, 3.7, 3.3, 6.4,
            6.9, 6.0, 6.8, 4.4, 4.0, 3.8, 5.0, 4.9, 9.2, 9.6, 9.5, 6.3,
            9.5, 10.8, 14.0, 11.5, 10.0, 10.2, 10.3, 9.4, 8.9, 10.6, 10.5, 11.1,
            10.4, 10.7, 11.3, 10.2, 9.6, 10.2, 11.1, 10.8, 13.0, 12.5, 12.5, 11.3,
            10.1
            ]

        }, {
            name: 'Vik',
            data: [
            0.2, 0.1, 0.1, 0.1, 0.3, 0.2, 0.3, 0.1, 0.7, 0.3, 0.2, 0.2,
            0.3, 0.1, 0.3, 0.4, 0.3, 0.2, 0.3, 0.2, 0.4, 0.0, 0.9, 0.3,
            0.7, 1.1, 1.8, 1.2, 1.4, 1.2, 0.9, 0.8, 0.9, 0.2, 0.4, 1.2,
            0.3, 2.3, 1.0, 0.7, 1.0, 0.8, 2.0, 1.2, 1.4, 3.7, 2.1, 2.0,
            1.5
            ]
        }],
        navigation: {
            menuItemStyle: {
                fontSize: '10px'
            }
        }
    });
</script> -->
<style type="text/css">
    .info-box {
        position: relative;
        background: #fff;
        box-shadow: 1px 0px 3px rgba(0, 0, 0, 0.1);
        border-radius: 5px !important;
    }
    .info-box .icon{
        padding:20px;
        display: inline-block;
        text-align: center;
        background: #42b549;border-radius: 5px !important;  
        box-shadow: 1px 0px 3px rgba(0, 0, 0, 0.1);
        position: absolute;   
        margin-top:-20px;
        margin-left: 20px;
    }
    .info-box .icon i {
        font-size: 30px;

        color:#fff;
    }
    .info-box .content{

        padding: 15px 10px 0 10px;     
        font-size: 12px;
        text-align: right;
    }
    .info-box .content .info{
        padding: 15px 15px;
        border-top: solid 1px #ddd;
        margin-top: 10px;
        text-align: left;
        font-size: 11px;
        color: #999;
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
    }
    .info-box .content h4{
        font-size: 16px;
        font-weight: 500;
        margin-bottom: 5px;
    }

    .bg-orange {
        background: #ff9900 !important;
        color: #fff;
    }
    .bg-cyan {
        background: #00BCD4 !important;
        color: #fff;
    }
    .bg-green {
        background: #8BC34A  !important;
        color: #fff;
    }
    .bg-red {
        background: #E91E63  !important;
        color: #fff;
    } 
    @media screen and (max-width: 1500px)  and (min-width: 1201px)  {
         .info-box .icon {
            padding:14px;
         }
         .info-box .icon i {
            font-size:20px;
         }
         .info-box .content {
            padding-top:20px;
         }
    }
    @media screen and (max-width: 1200px)  and (min-width: 991px)  {
        .info-box .content {
            padding-top:20px;
        }
        .info-box .icon {
           padding:10px;
       }
       .info-box .icon i {
            font-size:20px;
        }
    }
    @media screen and (max-width: 991px){
        .info-box .icon{
            margin-top: -12px;
            
        }
        
    
    }  
    @media only screen and (max-width: 991px) and (min-width: 768px)  {
       .info-box .icon {
           padding:15px;
       }
       .info-box .icon i {
            font-size:20px;
        }
        .info-box .content {
            padding-top:17px;
        }
    }    
</style> 
@stop
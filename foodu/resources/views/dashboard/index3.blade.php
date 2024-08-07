@extends('layouts.app')
@section('content')
<script type="text/javascript" src="{{ asset('sximo5/js/admin/icon.js') }}"></script>
<script type="text/javascript" src="{{ asset('sximo5/js/plugins/highcharts/highcharts.js') }}"></script>
<div class="page-header"><h2>  Sample Dashboard <small> Just change any content here with real data </small></h2></div>
<div class="p-5">
    <div class="row">
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div class=" info-box" >
                <div class="icon bg-orange">
                    <i class="fa fa-user"></i>
                </div>
                <div class="content">
                    <h4> 13.000 </h4>
                    Number of Registers users
                    <div class="info">
                        Tracked from Google Analytics
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div class=" info-box" >
                <div class="icon bg-cyan">
                    <i class="fa fa-chart-pie"></i>
                </div>
                <div class="content">
                    <h4> $ 565.000 </h4>
                    Currently sales of this month
                    <div class="info">
                        Tracked from Google Analytics
                    </div>
                </div>                 
            </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div class=" info-box" >
                <div class="icon bg-red">
                    <i class="fa fa-shopping-cart"></i>
                </div>
                <div class="content">
                    <h4> $ 565.000 </h4>
                    Currently sales of this month
                    <div class="info">
                        Tracked from Google Analytics
                    </div>
                </div>                 
            </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div class=" info-box" >
                <div class="icon bg-green">
                    <i class="fa fa-chart-bar"></i>
                </div>
                <div class="content">
                    <h4> $ 565.000 </h4>
                    Currently sales of this month
                    <div class="info">
                        Tracked from Google Analytics
                    </div>
                </div>                 
            </div>
        </div>    
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="mt-4" id="chartjs"></div>
        </div>
        <div class="col-md-6">
            <div class="mt-4" id="chartjs2"></div>
        </div>
    </div>
</div>
<script type="text/javascript">
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
</script>

<style type="text/css">
.info-box {


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
    padding: 10px ;
    border-top: solid 1px #ddd;
    margin-top: 10px;
    text-align: left;
    font-size: 11px;
    color: #999;
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
</style>       

@stop
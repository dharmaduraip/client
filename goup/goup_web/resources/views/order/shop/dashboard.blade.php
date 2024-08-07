@extends('order.shop.layout.base')
{{ App::setLocale(   isset($_COOKIE['shop_language']) ? $_COOKIE['shop_language'] : 'en'  ) }}
@section('title') Dashboard @stop

@section('content')

<div class="main-content-container container-fluid px-4">
    <!-- Page Header -->
    <div class="page-header row no-gutters py-4">
        <div class="col-12 col-sm-4 text-center text-sm-left mb-0">
        <span class="text-uppercase page-subtitle">{{ __('Dashboard') }}</span>
        <h3 class="page-title">{{ __('Dashboard Overview') }}</h3>
        </div>
    </div>
    <!-- End Page Header -->
    <!-- Small Stats Blocks -->

 
     <div class="row">
        <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="card dashboard_card">
                <div class="card-header card-header-warning card-header-icon">
                    <div class="card-icon">
                        <i class="material-icons">person</i>
                    </div>
                    <p class="card-category stats-small__label text-uppercase">{{ __('Orders Received') }}</p>
                    <h3 class="card-title recived_data"></h3>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="card dashboard_card">
                <div class="card-header card-header-success card-header-icon">
                    <div class="card-icon">
                        <i class="material-icons">person</i>
                    </div>
                    <p class="card-category stats-small__label text-uppercase"><b>{{ __('Orders Delivered') }}</b></p>
                    <h3 class="card-title delivered_data"></h3>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="card dashboard_card">
                <div class="card-header card-header-danger card-header-icon">
                    <div class="card-icon">
                        <i class="material-icons">person</i>
                    </div>
                    <p class="card-category stats-small__label text-uppercase">{{ __('Today Earnings') }}</p>
                    <h3 class="card-title  today_data"></h3>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="card dashboard_card">
                <div class="card-header card-header-info card-header-icon">
                    <div class="card-icon">
                        <i class="material-icons">person</i>
                    </div>
                    <p class="card-category stats-small__label text-uppercase">{{ __('Wallet Balance') }}</p>
                    <h3 class="card-title total_data"></h3>
                </div>
            </div>
        </div>
       
    </div>
    <!-- End Small Stats Blocks -->
    <div class="row">
        
          <!-- Order Stats -->
        <div class="col-lg-12 col-md-12 col-sm-12 mb-4">
            <div class="card card-small">
                <div class="card-header border-bottom">
                    <h6 class="m-0">{{ __('Products Sales') }}</h6>
                </div>
                <div class="card-body pt-0">
                    <canvas id="canvas2"></canvas>
                    
                </div>
            </div>
        </div>
        <!-- End Order Stats -->
        
         <!-- Over all Stats -->
        <!-- <div class="col-lg-4 col-md-4 col-sm-12 mb-4">
            <div class="card card-small h-100">
                <div class="card-header border-bottom">
                    <h6 class="m-0">Over all Summary</h6>
                </div>
                <div class="card-body d-flex py-0">
                   <canvas id="chart-area"></canvas>
                </div>
            </div>
        </div> -->
        <!-- End Over all Stats -->

        <!-- Default Light Table -->
        <div class="col-md-12">
        <div class="row">
            <div class="col">
                <div class="card card-small mb-4 p-3">
                    <div class="card-header border-bottom">
                    <h6 class="m-0">{{ __('Recent Orders') }}</h6>
                    </div>
                    <div class="card-body p-0 pb-3 text-left table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th scope="col" class="border-0">#</th>
                                <th scope="col" class="border-0">@lang('store.Order_ID') </th>
                                <th scope="col" class="border-0">@lang('store.Customer_Name')</th>
                                <th scope="col" class="border-0">@lang('store.Delivery_Person')</th>
                                <th scope="col" class="border-0">@lang('store.Status')</th>
                                <th scope="col" class="border-0">@lang('store.Amount')</th>
                                
                            </tr>
                        </thead>
                        <tbody class="recent_data">
                            
                            <tr>
                                <th scope="row">2</th>
                                <td>Edward Jett</td>                             
                                <td>Arturo Arturo</td>                             
                                <td>
                                    <span class="text-info">Arrived</span>
                                </td>
                                <td>$ 50.00</td>
                                 <td>
                                    <span>5 hours ago</span>
                                </td>
                            </tr>

                             <tr>
                                <th scope="row">3</th>
                                <td>Bivu</td>                             
                                <td>Arturo Arturo</td>                             
                                <td>
                                    <span class="text-success">Completed</span>
                                </td>
                                <td>$ 10.00</td>
                                 <td>
                                    <span>5 hours ago</span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    </div>
                </div>
            </div>
        </div>
        </div>
       
  
        <!-- End Top Referrals Component -->
    </div>
</div>
@stop

@section('scripts')
@parent
<script src="{{ asset('assets/plugins/data-tables/js/buttons.js')}}"></script>
<script src="{{ asset('assets/plugins/data-tables/js/jquery.dataTables.min.js')}}"></script>
<script src="{{ asset('assets/plugins/data-tables/js/dataTables.bootstrap.min.js')}}"></script>
<script src="{{ asset('assets/plugins/data-tables/js/dataTables.responsive.min.js')}}"></script>
<script src="{{ asset('assets/plugins/data-tables/js/dataTables.buttons.min.js')}}"></script>
<script src="{{ asset('assets/plugins/data-tables/js/jszip.min.js')}}"></script>
<script src="{{ asset('assets/plugins/data-tables/js/pdfmake.min.js')}}"></script>
<script src="{{ asset('assets/plugins/data-tables/js/vfs_fonts.js')}}"></script>
<script src="{{ asset('assets/plugins/data-tables/js/buttons.html5.min.js')}}"></script>
<script src="https://www.chartjs.org/dist/2.8.0/Chart.min.js"></script>
<script src="https://www.chartjs.org/samples/latest/utils.js"></script>
<script type="text/javascript">
var chartColors = {
            red: 'rgb(255, 99, 132)',
            orange: 'rgb(255, 159, 64)',
            yellow: 'rgb(255, 205, 86)',
            green: 'rgb(75, 192, 192)',
            blue: 'rgb(54, 162, 235)',
            purple: 'rgb(153, 102, 255)',
            grey: 'rgb(201, 203, 207)'
        };  
var GetStoreData = function () {
            $.ajax({
                url: getBaseUrl() + "/shop/total/storeorder",
                type:"GET",
                'beforeSend': function (request) {
                showLoader();
                },
                headers: {
                    Authorization: "Bearer " + getToken("shop")
                },
                success: function (data) {
                    var total_data=data.responseData;
                    $('.recived_data').text(total_data.received_data);
                    $('.delivered_data').text(total_data.delivered_data);
                    $('.today_data').text((total_data.today_earnings.total_amount) != null ? (total_data.currency+total_data.today_earnings.total_amount) : total_data.currency+0);
                    $('.total_data').text((total_data.total_earnings.total_amount) != null ? (total_data.currency+total_data.total_earnings.total_amount) : total_data.currency+0);
                    var cancel_data=data.responseData.cancelled_data;
                    var complete_data=data.responseData.completed_data;
                    var max=data.responseData.max;
                    var html=``;
                    if(total_data.recent_data.length > 0){
                    $(total_data.recent_data).each(function(index,val)
                    { 
                        if(val.status=='CANCELLED'){
                            var colour='text-danger';
                        }else if(val.status=='COMPLETED'){
                            var colour='text-success';
                        } else {
                            var colour='text-info';
                        }

                         html+=`<tr>
                                <th scope="row">`+parseInt(index+1)+`</th>
                                <th>`+val.store_order_invoice_id+`</th>
                                <td>`+(val.user ? val.user.first_name:'')+`</td>                             
                                <td>`+(val.provider ? val.provider.first_name:'')+`</td>                             
                                <td>
                                    <span class=`+colour+`>`+val.status+`</span>
                                </td>
                                <td>`+(val.order_invoice ?(total_data.currency+val.order_invoice.total_amount):total_data.currency+0.00)+`</td>
                                
                            </tr>`;
                    });
                     
                    } else {
                        html +=`<tr><td colspan='6'> No Recent Data</td></tr>`
                    } 
                    $('.recent_data').html(html);


                    config = {
                    type: 'line',
                    data: {
                        labels: [   'January',
                                    'February',
                                    'March',
                                    'April',
                                    'May',
                                    'June',
                                    'July',
                                    'August',
                                    'September',
                                    'October',
                                    'November',
                                    'December' 
                                ],
                        datasets: [ {
                            label: 'Completed Orders',
                            data:complete_data,
                            backgroundColor: window.chartColors.green,
                            borderColor: window.chartColors.green,
                            fill: false,
                            pointHoverRadius: 10,
                        }, {
                            label: 'Cancelled Orders',
                            data:cancel_data,
                            backgroundColor: window.chartColors.red,
                            borderColor: window.chartColors.red,
                            fill: false,
                            pointHitRadius: 20,
                        }]
                    },
                    options: {
                        responsive: true,
                        legend: {
                            position: 'bottom',
                        },
                        hover: {
                            mode: 'index'
                        },
                        scales: {
                            xAxes: [{
                                display: true,
                                scaleLabel: {
                                    display: true,
                                    labelString: 'Month'
                                }
                            }],
                            yAxes: [{
                                display: true,
                                scaleLabel: {
                                    display: true,
                                    labelString: 'Value'
                                },ticks: {
                                    min: 0,
                                    max: max,

                                    // forces step size to be 5 units
                                    stepSize: (Math.round(max / 100) * 100)/10
                                }
                            }]
                        },
                        title: {
                            display: true,
                            text: ''
                        }
                    }
                }
                var ctx = document.getElementById('canvas2').getContext('2d');
                window.myLine = new Chart(ctx, config); 
               hideLoader();   

               }

            })
      }; 


var config1 = {
    type: 'pie',
    data: {
        datasets: [{
            data:[10,38],
            backgroundColor: [
                window.chartColors.green,                
                window.chartColors.red
            ],
            label: 'Over all'
        }],
        labels: [
            'Completed',
            'Cancelled'            
        ]
    },
    options: {
        responsive: true
    }
};

window.onload = function() {
    GetStoreData();
}    

</script>
@stop
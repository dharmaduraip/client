@extends('common.admin.layout.base')
{{ App::setLocale(  isset($_COOKIE['admin_language']) ? $_COOKIE['admin_language'] : 'en'  ) }}

@section('title') {{ __('Overall Store Statements') }} @stop

@section('styles')
@parent
    <link rel="stylesheet" href="{{ asset('assets/plugins/data-tables/css/dataTables.bootstrap.min.css')}}"/>
    <link rel="stylesheet" href="{{ asset('assets/plugins/data-tables/css/responsive.bootstrap.min.css')}}">
@stop

@section('content')

<div class="main-content-container container-fluid px-4">
    <div class="page-header row no-gutters py-4">
        <div class="col-12 col-sm-4 text-center text-sm-left mb-0">
            <span class="text-uppercase page-subtitle">{{ __('Overall Store Statements') }}</span>
            <h3 class="page-title">{{ __('Overall Store Statements') }}</h3>
        </div>
    </div>
    <div class="row mb-4 mt-20">
        <div class="col-md-12">
            <div class="card card-small">
                <div class="card-header border-bottom">
                    <h6 class="m-0">{{ __('Overall Store Statements') }}</h6>
                </div>

                <div class="col-md-12">
                    <div class="note_txt">
                         @if(Helper::getDemomode() == 1)
                        <p>** Demo Mode : {{ __('admin.demomode') }}</p>
                        <span class="pull-left">(*personal information hidden in demo)</span>
                        @endif
                    </div>
                    <div class="datemenu">
                        <span>
                            <a style="cursor:pointer" id="tday" class="showdate">{{ __('Today') }}</a>
                            <a style="cursor:pointer" id="yday" class="showdate">{{ __('Yesterday') }}</a>
                            <a style="cursor:pointer" id="cweek" class="showdate">{{ __('Current Week') }}</a>
                            <a style="cursor:pointer" id="pweek" class="showdate">{{ __('Previous Week') }}</a>
                            <a style="cursor:pointer" id="cmonth" class="showdate">{{ __('Current Month') }}</a>
                            <a style="cursor:pointer" id="pmonth" class="showdate">{{ __('Previous Month') }}</a>
                            <a style="cursor:pointer" id="cyear" class="showdate">{{ __('Current Year') }}</a>
                            <a style="cursor:pointer" id="pyear" class="showdate">{{ __('Previous Year') }}</a>
                        </span>
                    </div>
                </div>   
                <div class="col-lg-12 col-md-12 col-12">         		
					<form class="form-horizontal" action="{{route('admin.store.statement.range')}}" method="GET" enctype="multipart/form-data" role="form">
                        <input type="hidden" name="type_val" id="type_val" value="range" />
                        <div class="row">
                            <div class="col-lg-3 col-md-12 col-sm-12 mb-4">
                                <label for="country" class="col-xs-4 col-form-label">{{ __('Country') }} <span class="red">*</span></label>
                                <div class="col-xs-8">
                                <select name="country_id" id="country_id" class="form-control" required>
                                    <option value="">Select</option>
                                    @foreach(Helper::getCountryList() as $key => $country)
                                        @if(isset($country_id) && $country_id == $key)
                                        <option value={{$key}} selected>{{$country}}</option>
                                        @else
                                        <option value={{$key}}>{{$country}}</option>
                                        @endif
                                    @endforeach
                                </select>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-12 col-sm-12 mb-4">
                                <label for="name" class="col-xs-4 col-form-label">{{ __('Date From') }} <span class="red">*</span></label>
                                <div class="col-xs-8">
                                @if(isset($statement_for) && $statement_for =="provider")
                                <input type="hidden" name="provider_id" id="provider_id" value="{{$id}}">
                                @elseif(isset($statement_for) && $statement_for =="user")
                                <input type="hidden" name="user_id" id="user_id" value="{{$id}}">
                                @elseif(isset($statement_for) && $statement_for =="fleet")
                                <input type="hidden" name="fleet_id" id="fleet_id" value="{{$id}}">
                                @endif
                                    <input class="form-control" type="date" value="{{$from_date}}" name="from_date" id="from_date" required placeholder="From Date">
                                </div>
                            </div>

                            <div class="col-lg-3 col-md-12 col-sm-12 mb-4">
                                <label for="email" class="col-xs-4 col-form-label">{{ __('Date To') }} <span class="red">*</span></label>
                                <div class="col-xs-8">
                                    <input class="form-control" type="date" value="{{$to_date}}" required name="to_date" id="to_date" placeholder="To Date">
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-12 col-sm-12 mt-10">
                                <label><small> &nbsp; </small></label>
                                <div class="col-xs-8">
                                    <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
                                </div>
                            </div>
                        </div>
                    </form>					
                </div>
                <div class="row col-lg-12 col-md-12 col-sm-12">
                    <div class="col-lg-4 col-md-4 col-sm-4">
                        <div class="card dashboard_card">
                            <div class="card-header card-header-warning card-header-icon">
                                <div class="card-icon">
                                    <i class="material-icons">local_taxi</i>
                                </div>
                                <p class="card-category stats-small__label text-uppercase">{{ __('Total No. of Stores') }}</p>
                                <h3 class="card-title"><span id="total_orders">0</span></h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-4">
                        <div class="card dashboard_card">
                            <div class="card-header card-header-warning card-header-icon">
                                <div class="card-icon">
                                    <i class="material-icons">attach_money</i>
                                </div>
                                <p class="card-category stats-small__label text-uppercase">{{ __('Revenue') }}</p>
                                <h3 class="card-title"><span id="revenue_value">0</span></h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-4">
                        <div class="card dashboard_card">
                            <div class="card-header card-header-warning card-header-icon">
                                <div class="card-icon">
                                    <i class="material-icons">cancel_presentation</i>
                                </div>
                                <p class="card-category stats-small__label text-uppercase">{{ __('Active Stores') }}</p>
                                <h3 class="card-title"><span id="cancelled_orders">0</span></h3>
                            </div>
                        </div>
                    </div>
                </div>
                <table id="data-table" class="table table-hover table_width display">
                    <thead>
                        <tr>
                            <th data-value="id">@lang('admin.id')</th>
                            <th>@lang('admin.request.order.storename')</th>
                            <th>@lang('admin.request.order.store_email')</th>
                            <th>@lang('admin.request.order.store_contact')</th>
                            <th>@lang('admin.request.order.store_location')</th>
                            <th>@lang('admin.request.order.earning')</th>
                            <th>@lang('admin.status')</th>
                            <th>@lang('admin.request.order.joined')</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
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
<script type="text/javascript">
	$(".showdate").on('click', function(){
        var ddattr=$(this).attr('id');
        $("#type_val").val(ddattr);
		//console.log(ddattr);
		if(ddattr=='tday'){
			$("#from_date").val('{{$dates["today"]}}');
			$("#to_date").val('{{$dates["today"]}}');
		}
		else if(ddattr=='yday'){
			$("#from_date").val('{{$dates["yesterday"]}}');
			$("#to_date").val('{{$dates["yesterday"]}}');
		}
		else if(ddattr=='cweek'){
			$("#from_date").val('{{$dates["cur_week_start"]}}');
			$("#to_date").val('{{$dates["cur_week_end"]}}');
		}
		else if(ddattr=='pweek'){
			$("#from_date").val('{{$dates["pre_week_start"]}}');
			$("#to_date").val('{{$dates["pre_week_end"]}}');
		}
		else if(ddattr=='cmonth'){
			$("#from_date").val('{{$dates["cur_month_start"]}}');
			$("#to_date").val('{{$dates["cur_month_end"]}}');
		}
		else if(ddattr=='pmonth'){
			$("#from_date").val('{{$dates["pre_month_start"]}}');
			$("#to_date").val('{{$dates["pre_month_end"]}}');
		}
		else if(ddattr=='pyear'){
			$("#from_date").val('{{$dates["pre_year_start"]}}');
			$("#to_date").val('{{$dates["pre_year_end"]}}');
		}
		else if(ddattr=='cyear'){
			$("#from_date").val('{{$dates["cur_year_start"]}}');
			$("#to_date").val('{{$dates["cur_year_end"]}}');
		}
		else{
			alert('invalid dates');
		}
	});
</script>
<script>
var table = $('#data-table');
$(document).ready(function() {
    $('body').on('click', '.view', function(e) {
        e.preventDefault();
        $.get("{{ url('admin/order-requestdetails/') }}/"+$(this).data('id')+"/view", function(data) {
            $('.crud-modal .modal-container').html("");
            $('.crud-modal .modal-container').html(data);
        });
        $('.crud-modal').modal('show');
    });
    var FromDate = $("#from_date").val();
    var ToDate = $("#to_date").val();
    var typeVal = $("#type_val").val();
    var countryVal = $("#country_id").val();
    table = table.DataTable( {
        "processing": true,
        "serverSide": true,
        "ordering": false,
        "ajax": {
            "url": getBaseUrl() + "/admin/store/storeStatementHistory?country_id="+countryVal+"&type="+typeVal+"&from="+FromDate+"&to="+ToDate,
            "type": "GET",
            'beforeSend': function (request) {
                showLoader();
            },
            "headers": {
                "Authorization": "Bearer " + getToken("admin")
            },
            dataFilter: function(data){

                var json = parseData( data );
                json.recordsTotal = json.responseData.stores.total;
                json.recordsFiltered = json.responseData.stores.total;
                json.data = json.responseData.stores.data;
                var totalOrders = json.responseData.total_orders;
                var revenueValue = json.responseData.revenue_value;
                var cancelledOrders = json.responseData.cancelled_orders;
                $("#total_orders").html(totalOrders);
                $("#revenue_value").html(revenueValue);
                $("#cancelled_orders").html(cancelledOrders);
                hideLoader();
                return JSON.stringify( json );
            }
        },
        "columns": [
            { "data": "id" ,render: function (data, type, row, meta) {
               return meta.row + meta.settings._iDisplayStart + 1;
             }
           },
            { "data": "store_name" },  
            { "data": function (data, type, dataToSet) {
                if({{Helper::getEncrypt()}} == 1){
                    return protect_email(data.email)
                }
                else{
                    return data.email
                }

            } },
            { "data": function (data, type, dataToSet) {                
                if({{Helper::getEncrypt()}} == 1){
                    return  protect_number(data.contact_number);
                }
                else{
                    return  data.contact_number;
                }    
            } },   
            { "data": "store_location" }, 
            { "data": "earnings" }, 
            { "data": "status" },       
            { "data": "joined" },
            

        ],
        responsive: true,
        paging:true,
            info:true,
            lengthChange:false,
            dom: 'Bfrtip',
            buttons: [{
               extend: "copy",
               exportOptions: {
                   columns: [":visible :not(:last-child)"]
               }
            }, {
               extend: "csv",
               exportOptions: {
                   columns: [":visible :not(:last-child)"]
               }
            }, {
               extend: "excel",
               exportOptions: {
                   columns: [":visible :not(:last-child)"]
               }
            }, {
               extend: "pdf",
               exportOptions: {
                   columns: [":visible :not(:last-child)"]
               }
            }],"drawCallback": function () {
    
                var info = $(this).DataTable().page.info();
                if (info.pages<=1) {
                   $('.dataTables_paginate').hide();
                   $('.dataTables_info').hide();
                }else{
                    $('.dataTables_paginate').show();
                    $('.dataTables_info').show();
                }
            }
    } );


} );
</script>

@stop

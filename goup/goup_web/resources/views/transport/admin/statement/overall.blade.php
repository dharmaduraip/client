@extends('common.admin.layout.base')
{{ App::setLocale(  isset($_COOKIE['admin_language']) ? $_COOKIE['admin_language'] : 'en'  ) }}

@section('title') {{ __('Overall Transport Statements') }} @stop

@section('styles')
@parent
    <link rel="stylesheet" href="{{ asset('assets/plugins/data-tables/css/dataTables.bootstrap.min.css')}}"/>
    <link rel="stylesheet" href="{{ asset('assets/plugins/data-tables/css/responsive.bootstrap.min.css')}}">
@stop

@section('content')

<div class="main-content-container container-fluid px-4">
    <div class="page-header row no-gutters py-4">
        <div class="col-12 col-sm-4 text-center text-sm-left mb-0">
            <span class="text-uppercase page-subtitle">{{ __('Overall Transport Statements') }}</span>
            <h3 class="page-title">{{ __('Overall Transport Statements') }}</h3>
        </div>
    </div>
    <div class="row mb-4 mt-20">
        <div class="col-md-12">
            <div class="card card-small">
                <div class="card-header border-bottom">
                    <h6 class="m-0">{{ __('Overall Transport Statements') }}</h6>
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
                            <a id="tday" class="showdate">{{ __('Today') }}</a>
                            <a id="yday" class="showdate ">{{ __('Yesterday') }}</a>
                            <a id="cweek" class="showdate ">{{ __('Current Week') }}</a>
                            <a id="pweek" class="showdate ">{{ __('Previous Week') }}</a>
                            <a id="cmonth" class="showdate ">{{ __('Current Month') }}</a>
                            <a id="pmonth" class="showdate ">{{ __('Previous Month') }}</a>
                            <a id="cyear" class="showdate ">{{ __('Current Year') }}</a>
                            <a id="pyear" class="showdate ">{{ __('Previous Year') }}</a>
                        </span>
                    </div>
                </div>   
                <div class="col-lg-12 col-md-12 col-12">         		
					<form class="form-horizontal" action="{{route('admin.ride.statement.range')}}" method="GET" enctype="multipart/form-data" role="form">
                        <input type="hidden" name="type_val" id="type_val" value="range" />
                        <div class="row">                            
                            
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
                                <label for="country" class="col-xs-4 col-form-label">{{ __('Fleet') }} </label>
                                <div class="col-xs-8">
                                <select name="fleet_id" id="fleet_id" class="form-control" >
                                    <option value="">Select</option>
                                </select>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-12 col-sm-12 mb-4">
                                <label for="country" class="col-xs-4 col-form-label"> {{ __('Status') }} </label>
                                <div class="col-xs-8">
                                <select name="status" id="status" class="form-control" >
                                    <option value="">Select</option>
                                    <option value="CANCELLED" @if(Request::get('status')=='CANCELLED')  selected @endif >CANCELLED</option>
                                    <option value="COMPLETED" @if(Request::get('status')=='COMPLETED')  selected @endif  >COMPLETED</option>
                                </select>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-12 col-sm-12 mb-4">
                                <label for="country" class="col-xs-4 col-form-label">{{ __('User') }} </label>
                                <div class="col-xs-8">
                                <select name="user_id" id="user_id" class="form-control" >
                                    <option value="">Select</option>
                                </select>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-12 col-sm-12 mb-4">
                                <label for="country" class="col-xs-4 col-form-label"> {{ __('Provider') }} </label>
                                <div class="col-xs-8">
                                <select name="provider_id" id="provider_id" class="form-control" >
                                    <option value="">Select</option>
                                </select>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-12 col-sm-12 mb-4">
                                <label for="country" class="col-xs-4 col-form-label">{{ __('Service Type') }} </label>
                                <div class="col-xs-8">
                                <select name="ride_type" id="ride_type" class="form-control" >
                                    <option value="">Select</option>
                                </select>
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12 mt-10">
                                <label><small> &nbsp; </small></label>
                                <div class="col-xs-8 text-center">
                                    <a href="{{route('admin.ride.statement.range')}}" class="btn btn-primary">{{ __('Reset') }}</a>
                                    <button type="submit" class="btn btn-primary">{{ __('Search') }}</button>
                                    <!-- <button type="submit" class="btn btn-primary">Search</button> -->
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
                                <p class="card-category stats-small__label text-uppercase">{{ __('Total No. of Rides') }}</p>
                                <h3 class="card-title"><span id="total_rides">0</span></h3>
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
                                <p class="card-category stats-small__label text-uppercase">{{ __('Cancelled Rides') }}</p>
                                <h3 class="card-title"><span id="cancelled_rides">0</span></h3>
                            </div>
                        </div>
                    </div>
                </div>
                <table id="data-table" class="table table-hover table_width display">
                    <thead>
                        <tr>
                            <th data-value="id">@lang('admin.id')</th>
                            <th>@lang('admin.request.Booking_ID')</th>
                            <th>@lang('admin.request.User_Name')</th>
                            <th>@lang('admin.request.Provider_Name')</th>
                            <th>@lang('admin.request.Date_Time')</th>
                            <th>@lang('admin.status')</th>
                            <th>@lang('admin.amount')</th>
                            <th>@lang('admin.request.Payment_Mode')</th>
                            <th>@lang('admin.request.Payment_Status')</th>
                            <th>@lang('admin.action')</th>
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

var tableName = '#data-table';
var table = $(tableName);

$(document).ready(function() {
                  
    var url = getBaseUrl() + "/admin/requestStatementhistory";
    var keys = {id: "S.No.", booking_id: "Booking ID", user_name: "User Name", provider_name: "Provider Name", created_time: "Date & Time", status: "Status", earnings: "Amount", payment_mode: "Payment Mode", paid: "Payment Status"};
    jQuery.fn.DataTable.Api.register( 'buttons.exportData()', function ( options ) {
        if ( this.context.length ) {

            var dataArray = new Array();
            var params = getTableData($(tableName).DataTable());
            params.country_id = getParameterByName('country_id');
            params.type = getParameterByName('type_val');
            params.from = getParameterByName('from_date');
            params.to = getParameterByName('to_date');
            params.fleet_id = getParameterByName('fleet_id');
            params.status = getParameterByName('status');
            params.provider_id = getParameterByName('provider_id');
            params.user_id = getParameterByName('user_id');
            params.ride_type = getParameterByName('ride_type');

            var jsonResult = $.ajax({
                url: url,
                beforeSend: function (request) {
                    showLoader();
                },
                headers: {
                    "Authorization": "Bearer " + getToken("admin")
                },
                async: false,
                data: params,
                success: function (result) {
                    $.each(result.responseData.rides, function (i, data)
                    {   

                        data.id = i+1;

                        if(data.user) {
                            data.user_name = data.user.first_name + " " +data.user.last_name;
                        }

                        if(data.provider) {
                            data.provider_name = data.provider.first_name + " " +data.provider.last_name;
                        }

                        if(data.email) {
                            if({{Helper::getEncrypt()}} == 1) data.email = protect_email(data.email);
                            else data.email = data.email;
                        }
                        
                        if(data.mobile) {
                            if({{Helper::getEncrypt()}} == 1) data.mobile = '+'+data.country_code + protect_number(data.mobile);
                            else data.mobile = '+'+data.country_code + data.mobile;
                        }

                        if(data.paid) {
                            if(data.paid == 1) data.paid = "PAID";
                            else data.paid = "NOT PAID";
                        } else data.paid = "NOT PAID";

                        if(data.earnings) {
                            data.earnings = data.currency + data.earnings;
                        }

                        if(data.admin) data.admin = data.admin.type;
                        else  data.admin = '';

                        var rowData = pick(data, Object.keys(keys));
                        var rows = {};
                        for(var i in Object.keys(keys)) {
                            rows[Object.keys(keys)[i]] = rowData[Object.keys(keys)[i]] != null ? rowData[Object.keys(keys)[i]] : '';
                        }
                        dataArray.push(Object.values(rows));
                    });
                    hideLoader();
                }
            });
          
            return {body: dataArray, header: Object.values(keys)};
        }
    });


    $('body').on('click', '.view', function(e) {
        e.preventDefault();
        $.get("{{ url('admin/riderequestdetails/') }}/"+$(this).data('id')+"/view", function(data) {
            $('.crud-modal .modal-container').html("");
            $('.crud-modal .modal-container').html(data);
        });
        $('.crud-modal').modal('show');
    });
    var FromDate = $("#from_date").val();
    var ToDate = $("#to_date").val();
    var typeVal = $("#type_val").val();
    var countryVal = $("#country_id").val();
    var provider_id = $("#provider_id").val();
    var user_id = $("#user_id").val();
    var fleet_id = $("#fleet_id").val();
    var ride_type = $("#ride_type").val();
    var status = $("#status").val();
    table = table.DataTable( {
        "processing": true,
        "serverSide": true,
        "ordering": false,
        "ajax": {
            "url": getBaseUrl() + "/admin/requestStatementhistory?country_id="+countryVal+"&type="+typeVal+"&from="+FromDate+"&to="+ToDate+'&fleet_id='+fleet_id+'&status='+status+'&provider_id='+provider_id+'&user_id='+user_id+'&ride_type='+ride_type,
            "type": "GET",
            'beforeSend': function (request) {
                showLoader();
            },
            "headers": {
                "Authorization": "Bearer " + getToken("admin")
            },
            dataFilter: function(data){

                var json = parseData( data );

                json.recordsTotal = json.responseData.rides.total;
                json.recordsFiltered = json.responseData.rides.total;
                json.data = json.responseData.rides.data;
                var totalRides = json.responseData.total_rides;
                var revenueValue = json.responseData.revenue_value;
                var cancelledRides = json.responseData.cancelled_rides;
                $("#total_rides").html(totalRides);
                $("#revenue_value").html(revenueValue);
                $("#cancelled_rides").html(cancelledRides);
                hideLoader();
                return JSON.stringify( json );
            }
        },
        "columns": [
            { "data": "id" ,render: function (data, type, row, meta) {
               return meta.row + meta.settings._iDisplayStart + 1;
             }
           },
            { "data": "booking_id" },

            { "data": "user_id", render: function (data, type, row) {
                    return row.user.first_name+" "+row.user.last_name;
               }
            },
            { "data": "provider_id", render: function (data, type, row) {
                    return row.provider!= null ? row.provider.first_name+" "+row.provider.last_name :'';
               }
            },
            { "data": "created_time" },
            { "data": "status" },
            { "data": "id", render: function (data, type, row) {
                if (typeof row.earnings !== 'undefined' ){
                    return row.currency+row.earnings;
                }
                return 'N/A';
                }
            },
            { "data": "payment_mode" },
            { "data": "paid", render: function (data, type, row) {
                if(data == 1){
                    return 'PAID';
                }
                return 'NOT PAID'
               }
            },
            { "data": "id", render: function (data, type, row) {
                return "<button data-id='"+data+"' class='btn btn-block btn-success view'>Details</button>";
            }}

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

$('#fleet_id').on('change',function(){

    var fleet_id = $(this).val();
    if(fleet_id){
        $.ajax({
            url: getBaseUrl() + "/admin/getfleetprovider?fleet_id="+fleet_id,
            type: "get",
            async: false,
            headers: {
                   Authorization: "Bearer " + getToken("admin")
            },
            success: (data, textStatus, jqXHR) => {
               $('select[name=provider_id]').html('');
                var providers = data.responseData;
                $('select[name=provider_id]').append(`<option value="">Select</option>`);
                for (var i in providers) {
                    if(provider_id == providers[i].id){
                        $('select[name=provider_id]').append(`<option  selected   value="` + providers[i].id + `">` + providers[i].first_name+' '+providers[i].last_name + `</option>`);
                    }else{
                        $('select[name=provider_id]').append(`<option     value="` + providers[i].id + `">` + providers[i].first_name+' '+providers[i].last_name + `</option>`);
                    }
                }
            },
            error: (jqXHR, textStatus, errorThrown) => {
                   alertMessage(textStatus, jqXHR.responseJSON.message, "danger");
            }
        });
    }else{
        $.ajax({
            url: getBaseUrl() + "/admin/getfleetprovider?fleet_id="+fleet_id,
            type: "get",
            async: false,
            headers: {
                   Authorization: "Bearer " + getToken("admin")
            },
            success: (data, textStatus, jqXHR) => {
               $('select[name=provider_id]').html('');
                var providers = data.responseData;
                $('select[name=provider_id]').append(`<option value="">Select</option>`);
                for (var i in providers) {
                    if(provider_id == providers[i].id){
                        $('select[name=provider_id]').append(`<option  selected   value="` + providers[i].id + `">` + providers[i].first_name+' '+providers[i].last_name + `</option>`);
                    }else{
                        $('select[name=provider_id]').append(`<option     value="` + providers[i].id + `">` + providers[i].first_name+' '+providers[i].last_name + `</option>`);
                    }
                }
            },
            error: (jqXHR, textStatus, errorThrown) => {
                   alertMessage(textStatus, jqXHR.responseJSON.message, "danger");
            }
        });
    }
});

$('#country_id').on('change',function(){

    var country_id = $(this).val();
    getdata(country_id);
    
});

@if(Request::get('country_id'))
    var country_id = {{Request::get('country_id')}};
    getdata({{Request::get('country_id')}});
@endif


function getdata(country_id){

    var provider_id = "{{Request::get('provider_id')}}";
    var user_id = "{{Request::get('user_id')}}";
    var fleet_id = "{{Request::get('fleet_id')}}";
    var ride_type = "{{Request::get('ride_type')}}";

    if(country_id){
        $.ajax({
            url: getBaseUrl() + "/admin/getdata?country_id="+country_id+'&service_type=TRANSPORT',
            type: "get",
            async: false,
            headers: {
                   Authorization: "Bearer " + getToken("admin")
            },
            success: (data, textStatus, jqXHR) => {
                $('select[name=fleet_id]').html('');
                var fleets = data.responseData.fleets;
                $('select[name=fleet_id]').append(`<option value="">Select</option>`);
               for (var i in fleets) {
                    if(fleet_id == fleets[i].id){
                        $('select[name=fleet_id]').append(`<option selected value="` + fleets[i].id + `">` + fleets[i].name + `</option>`);
                    }else{
                        $('select[name=fleet_id]').append(`<option value="` + fleets[i].id + `">` + fleets[i].name + `</option>`);
                    }
               }

               $('select[name=user_id]').html('');
                var users = data.responseData.users;
                $('select[name=user_id]').append(`<option value="">Select</option>`);
               for (var i in users) {
                    if(user_id == users[i].id){
                        $('select[name=user_id]').append(`<option selected value="` + users[i].id + `">` + users[i].first_name+' '+users[i].last_name + `</option>`);
                    }else{
                        $('select[name=user_id]').append(`<option value="` + users[i].id + `">` + users[i].first_name+' '+users[i].last_name + `</option>`);
                    }
               }

               $('select[name=provider_id]').html('');
                var providers = data.responseData.providers;
                $('select[name=provider_id]').append(`<option value="">Select</option>`);
               for (var i in providers) {
                if(provider_id == providers[i].id){
                    $('select[name=provider_id]').append(`<option  selected   value="` + providers[i].id + `">` + providers[i].first_name+' '+providers[i].last_name + `</option>`);
                }else{
                    $('select[name=provider_id]').append(`<option     value="` + providers[i].id + `">` + providers[i].first_name+' '+providers[i].last_name + `</option>`);
                }
               }

               $('select[name=ride_type]').html('');
                var ride_types = data.responseData.ride_type;
                $('select[name=ride_type]').append(`<option value="">Select</option>`);
               for (var i in ride_types) {
                    if(ride_type == ride_types[i].id){
                        $('select[name=ride_type]').append(`<option  selected value="` + ride_types[i].id + `">` + ride_types[i].ride_name + `</option>`);
                    }else{
                        $('select[name=ride_type]').append(`<option value="` + ride_types[i].id + `">` + ride_types[i].ride_name + `</option>`);
                    }
               }
            },
            error: (jqXHR, textStatus, errorThrown) => {
                   alertMessage(textStatus, jqXHR.responseJSON.message, "danger");
            }
        });
    }else{
        $('select[name=fleet_id]').html('');
        $('select[name=fleet_id]').append(`<option value="">Select</option>`);
        $('select[name=user_id]').html('');
        $('select[name=user_id]').append(`<option value="">Select</option>`);
        $('select[name=provider_id]').html('');
        $('select[name=provider_id]').append(`<option value="">Select</option>`);
        $('select[name=ride_type]').html('');
        $('select[name=ride_type]').append(`<option value="">Select</option>`);
    }
}
</script>

@stop

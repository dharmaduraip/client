@extends('common.admin.layout.base')
{{ App::setLocale(  isset($_COOKIE['admin_language']) ? $_COOKIE['admin_language'] : 'en'  ) }}

@section('title') {{ __('admin.fleet_transcation') }} @stop

@section('styles')
@parent
    <link rel="stylesheet" href="{{ asset('assets/plugins/data-tables/css/dataTables.bootstrap.min.css')}}"/>
    <link rel="stylesheet" href="{{ asset('assets/plugins/data-tables/css/responsive.bootstrap.min.css')}}">
@stop

@section('content')

<div class="main-content-container container-fluid px-4">
    <div class="page-header row no-gutters py-4">
        <div class="col-12 col-sm-4 text-center text-sm-left mb-0">
            <span class="text-uppercase page-subtitle">{{ __('admin.fleet_transcation') }}</span>
            <h3 class="page-title">{{ __('admin.fleet_transcation') }}</h3>
        </div>
    </div>
    <div class="row mb-4 mt-20">
        <div class="col-md-12">
            <div class="card card-small">
                <div class="card-header border-bottom">
                    <h6 class="m-0">{{ __('admin.fleet_transcation') }}</h6>
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
					<form class="form-horizontal" action="{{URL::to('admin/fleettransactions')}}" method="GET" enctype="multipart/form-data" role="form">
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
                <table id="data-table" class="table table-hover table_width display">
                    <thead>
                        <tr>
                            <th data-value="id">@lang('admin.id')</th>
                            <th>@lang('admin.transaction_ref')</th>
                            <th>@lang('admin.admin_service')</th>
                            <th>@lang('admin.datetime')</th>
                            <th>@lang('admin.transaction_desc')</th>
                            <th>@lang('admin.amount_type')</th>
                            <th>@lang('admin.amount')</th>
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
var table = $('#data-table');
$(document).ready(function() {

    var url = getBaseUrl() + "/admin/fleettransactions";
    var keys = {id: "S.No.", transaction_alias: "Transaction Id", admin_service: "Admin Service", dated: "Date & Time", transaction_desc: "Description", amount_type: "Status", amount: "Amount"};
    jQuery.fn.DataTable.Api.register( 'buttons.exportData()', function ( options ) {
        if ( this.context.length ) {

            var dataArray = new Array();
            var params = getTableData($(tableName).DataTable());
            params.country_id = getParameterByName('country_id');
            params.type = getParameterByName('type_val');
            params.from = getParameterByName('from_date');
            params.to = getParameterByName('to_date');

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
                    $.each(result.responseData, function (i, data)
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
    table = table.DataTable( {
        "processing": true,
        "serverSide": true,
        "ordering": true,
        "ajax": {
            "url": getBaseUrl() + "/admin/fleettransactions?country_id="+countryVal+"&type="+typeVal+"&from="+FromDate+"&to="+ToDate,
            "type": "GET",
            'beforeSend': function (request) {
                showLoader();
            },
            "headers": {
                "Authorization": "Bearer " + getToken("admin")
            },data: function(data){
                
                var info = $(tableName).DataTable().page.info();
                delete data.columns;

                data.page = info.page + 1;
                data.search_text = data.search['value'];
                data.order_by = $(tableName+' tr').eq(0).find('th').eq(data.order[0]['column']).data('value');
                data.order_direction = data.order[0]['dir'];
            },
            dataFilter: function(data){

                var json = parseData( data );

                json.recordsTotal = json.responseData.total;
                json.recordsFiltered = json.responseData.total;
                json.data = json.responseData.data;
                hideLoader();
                return JSON.stringify( json );
            }
        },
        "columns": [
            { "data": "id" ,render: function (data, type, row, meta) {
               return meta.row + meta.settings._iDisplayStart + 1;
             }
            },
            { "data": "transaction_alias" },
            { "data": "admin_service" },
            { "data": "dated" },
            { "data": "transaction_desc" },
            { "data": "amount_type" },           
            { "data": "amount" },  
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

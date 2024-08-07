@extends('common.admin.layout.base')
{{ App::setLocale(  isset($_COOKIE['admin_language']) ? $_COOKIE['admin_language'] : 'en'  ) }}

@section('title') {{ __('admin.include.user_overall_history') }} @stop

@section('styles')
@parent
    <link rel="stylesheet" href="{{ asset('assets/plugins/data-tables/css/dataTables.bootstrap.min.css')}}"/>
    <link rel="stylesheet" href="{{ asset('assets/plugins/data-tables/css/responsive.bootstrap.min.css')}}">
@stop

@section('content')

<div class="main-content-container container-fluid px-4">
    <div class="page-header row no-gutters py-4">
        <div class="col-12 col-sm-4 text-center text-sm-left mb-0">
            <span class="text-uppercase page-subtitle">{{ __('admin.include.user_overall_history') }}</span>
            <h3 class="page-title">{{ __('admin.include.user_overall_history') }} </h3>
        </div>
    </div>
    <div class="row mb-4 mt-20">
        <div class="col-md-12">
            <div class="card card-small">
                <div class="card-header border-bottom">
                    <h6 class="m-0">{{ __('admin.include.user_overall_history') }}</h6>
                </div>

                <div class="col-md-12">
                    <div class="note_txt">
                        @if(Helper::getDemomode() == 1)
                        <p>** Demo Mode : {{ __('admin.demomode') }}</p>
                        <span class="pull-left">(*personal information hidden in demo)</span>
                        @endif
                    </div>
                </div>

                <table id="data-table" class="table table-hover table_width display">
                <thead>
                    <tr>
                        <td data-value="first_name">@lang('admin.users.name')</td>
                        <td> @lang('admin.mobile')</td>
                        <td>@lang('admin.status')</td>
                        <td>@lang('admin.provides.Total_Rides')</td>
                        <td>@lang('admin.provides.Total_Services')</td>
                        <td>@lang('admin.provides.Total_Orders')</td>
                        <td>@lang('admin.provides.Total_delivery')</td>
                        <td>@lang('admin.provides.Total_Spending')</td>
                        <td>@lang('admin.provides.Joined_at')</td>
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
<script>
var tableName = '#data-table';
var table = $(tableName);
$(document).ready(function() {
               
    var url = getBaseUrl() + "/admin/statement/user";
    var keys = {full_name: "User Name", mobile: "Mobile", status: "Status", rides_count: "Total Rides", services_count: "Total Services", orders_count: "Total Orders", delivery_count: " Total Delivery", payment: "Total Spendings", created_at: "Joined at"};

    datatable_export(url, keys, {{Helper::getEncrypt()}});


    $('body').on('click', '.view', function(e) {
        e.preventDefault();
        alert("PROCESSING");
        // $.get("{{ url('admin/vehicletype/') }}/"+$(this).data('id')+"/view", function(data) {
        //     $('.crud-modal .modal-container').html("");
        //     $('.crud-modal .modal-container').html(data);
        // });
        // $('.crud-modal').modal('show');
    });


    table = table.DataTable( {
        "processing": true,
        "serverSide": true,
        "aoColumnDefs": [{ "bSortable": false, "aTargets": [1,2,3,4,5,6,7]}],
        
        "ajax": {
            "url": getBaseUrl() + "/admin/statement/user",
            "type": "GET",
            'beforeSend': function (request) {
                showLoader();
            },
            "headers": {
                "Authorization": "Bearer " + getToken("admin")
            },
            data: function(data){
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
                return JSON.stringify( json ); // return JSON string
            }
        },
        "columns": [
            { "data": "id", render: function (data, type, row) {
                    return row.first_name+" "+row.last_name;
                  }
            },
           
            { "data": function (data, type, dataToSet) {                
                if({{Helper::getEncrypt()}} == 1){
                    return  protect_number(data.mobile);
                }
                else{
                    return  data.mobile;
                }    
            } },   
            { "data": "status", render: function (data, type, row) {
                    
                     return row.status==1 ? "Approved":"Disable";

                 }
            },
            { "data": "rides_count" },
            { "data": "services_count" },
            { "data": "orders_count" },
            { "data": "delivery_count"},
            { "data": "payment"},
            { "data": "created_at" }
            
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

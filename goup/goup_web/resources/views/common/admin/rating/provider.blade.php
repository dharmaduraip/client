@extends('common.admin.layout.base')
{{ App::setLocale(  isset($_COOKIE['admin_language']) ? $_COOKIE['admin_language'] : 'en'  ) }}

@section('title') {{ __('Provider') }} {{ __('Reviews') }} @stop

@section('styles')
@parent
    <link rel="stylesheet" href="{{ asset('assets/plugins/data-tables/css/dataTables.bootstrap.min.css')}}"/>
    <link rel="stylesheet" href="{{ asset('assets/plugins/data-tables/css/responsive.bootstrap.min.css')}}">
@stop

@section('content')

<div class="main-content-container container-fluid px-4">
    <div class="page-header row no-gutters py-4">
        <div class="col-12 col-sm-4 text-center text-sm-left mb-0">
            <span class="text-uppercase page-subtitle">{{ __('Provider') }} {{ __('Reviews') }}</span>
            <h3 class="page-title">{{ __('Provider') }} {{ __('Reviews') }}</h3>
        </div>
    </div>
    <div class="row mb-4 mt-20">
        <div class="col-md-12">
            <div class="card card-small">
                <div class="card-header border-bottom">
                    <h6 class="m-0">{{ __('Provider') }} {{ __('Reviews') }}</h6>
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
                            <th data-value="id">@lang('admin.id')</th>
                            <th data-value="request_id">@lang('admin.review.transaction_id')</th>
                            <th data-value="admin_service">@lang('admin.review.admin_service')</th>
                            <th data-value="user_id">@lang('admin.request.User_Name')</th>
                            <th data-value="provider_id">@lang('admin.request.Provider_Name')</th>
                            <th data-value="provider_rating">@lang('admin.review.Rating')</th>
                            <th data-value="provider_comment">@lang('admin.review.provider_comments')</th>
                            
                            <th>@lang('admin.action')</th>
                    </tr>
                 </thead>


                </table>
            </div>
        </div>
    </div>
</div>
<style>
    .dataTables_wrapper.form-inline {
        display: block !important;
    }
</style>
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
    $('body').on('click', '.view', function(e) {
        e.preventDefault();
        $('.crud-modal .modal-container').html("Loading.................");
        if($(this).data('service')=="TRANSPORT"){
           
            $.get("{{ url('admin/riderequestdetails/') }}/"+$(this).data('id')+"/view", function(data) {
                $('.crud-modal .modal-container').html("");
                $('.crud-modal .modal-container').html(data);
            });
        }else if($(this).data('service')=="SERVICE"){
           
            $.get("{{ url('admin/service-requestdetails/') }}/"+$(this).data('id')+"/view", function(data) {
                $('.crud-modal .modal-container').html("");
                $('.crud-modal .modal-container').html(data);
            });
        }else if($(this).data('service')=="DELIVERY"){
           
           $.get("{{ url('admin/delivery-riderequestdetails/') }}/"+$(this).data('id')+"/view", function(data) {
               $('.crud-modal .modal-container').html("");
               $('.crud-modal .modal-container').html(data);
           });
       }else{
            $.get("{{ url('admin/order-requestdetails/') }}/"+$(this).data('id')+"/view", function(data) {
                $('.crud-modal .modal-container').html("");
                $('.crud-modal .modal-container').html(data);
            });
        }
        $('.crud-modal').modal('show');
    });
    table = table.DataTable( {
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": getBaseUrl() + "/admin/providerreview",
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
                return JSON.stringify( json );
            }
        },
        "columns": [
            { "data": "id" ,render: function (data, type, row, meta) {
               return meta.row + meta.settings._iDisplayStart + 1;
             }
           },
            { "data": "booking_id" },
            { "data": "admin_service" },

            { "data": "user_id", render: function (data, type, row) {
                return row.user?row.user.first_name+" "+row.user.last_name:"";
               }
            },
            { "data": "provider_id", render: function (data, type, row) {
                return row.provider?row.provider.first_name+" "+row.provider.last_name:"";
               }
            },
            { "data": "provider_rating" },
            { "data": "user_comment", render: function (data, type, row) {
                    return row.provider_comment ? row.provider_comment:" No Comments By Provider";
               }
            },
            
            { "data": "request_id", render: function (data, type, row) {
                return "<button data-id='"+data+"' data-service='"+row.admin_service+"' class='btn btn-block btn-success view'>view</button>";
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
</script>
@stop

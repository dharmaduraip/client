@extends('common.admin.layout.base')
{{ App::setLocale(  isset($_COOKIE['admin_language']) ? $_COOKIE['admin_language'] : 'en'  ) }}

@section('title') {{ __('Dispute') }} @stop

@section('styles')
@parent
    <link rel="stylesheet" href="{{ asset('assets/plugins/data-tables/css/dataTables.bootstrap.min.css')}}"/>
    <link rel="stylesheet" href="{{ asset('assets/plugins/data-tables/css/responsive.bootstrap.min.css')}}">
    
@stop

@section('content')

<div class="main-content-container container-fluid px-4">
    <div class="page-header row no-gutters py-4">
        <div class="col-12 col-sm-4 text-center text-sm-left mb-0">
            <span class="text-uppercase page-subtitle">{{ __('Dispute Reason') }}</span>
            <h3 class="page-title">{{ __('Dispute Reason List') }}</h3>
        </div>
    </div>
    <div class="row mb-4 mt-20 mt-30">
        <div class="col-md-12">
            <div class="card card-small">
                <div class="card-header border-bottom">
                    <h6 class="m-0 pull-left">{{ __('Dispute Reason') }}</h6>
                    @permission('dispute-create')
                        
                        <a href="javascript:;" class="btn btn-primary pull-right add"><i class="fa fa-plus"></i> <strong >{{ __('Add') }}  {{ __('Dispute Reason') }}</strong></a>
                        
                    @endpermission
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
                            <th data-value="dispute_name">@lang('admin.dispute.dispute_reason')</th>
                            <th data-value="dispute_type">@lang('admin.dispute.dispute_type')</th>
                            <th data-value="service">@lang('admin.dispute.dispute_services')</th>
                            <th data-value="status">@lang('admin.dispute.dispute_status')</th>
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
<script>
var tableName = '#data-table';
var table = $(tableName);
// showLoader();

$(document).ready(function() {

    var url = getBaseUrl() + "/admin/dispute_list";
    var keys = {id: "S.No.", dispute_name: "Dispute Reason", dispute_type: "Dispute Type", admin_services: "Services", status: "Status"};

    datatable_export(url, keys, {{Helper::getEncrypt()}});

    $('.add').on('click', function(e) {
        e.preventDefault();
        $.get("{{ url('admin/dispute/create') }}", function(data) {
            $('.crud-modal .modal-container').html("");
            $('.crud-modal .modal-container').html(data);
        });
        $('.crud-modal').modal('show');
    });

    $('body').on('click', '.edit', function(e) {
        e.preventDefault();
        $.get("{{ url('admin/dispute/') }}/"+$(this).data('id')+"/edit", function(data) {
            $('.crud-modal .modal-container').html("");
            $('.crud-modal .modal-container').html(data);
        });
        $('.crud-modal').modal('show');
    });


    table = table.DataTable( {
        "processing": true,
        "serverSide": true,
        "pageLength": 10,
        "aoColumnDefs": [{ "bSortable": false, "aTargets": [5]}],
        "ajax": {
            "url": url,
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
            { "data": "id" ,render: function (data, type, row, meta) {
               return meta.row + meta.settings._iDisplayStart + 1;
              }
            },
            { "data": "dispute_name", render: function (data, type, row) {
                if(data){
               return data.replace(/^(.)|\s(.)/g, function(dispute_name){ return dispute_name.toUpperCase( ); });
                }else{
                    return data;
                }
               }
            },
            { "data": "dispute_type", render: function (data, type, row) {
               return data.charAt(0).toUpperCase()+data.slice(1);
               }
            },
            { "data": "service", render: function (data, type, row) {
               return data.charAt(0).toUpperCase()+data.slice(1).toLowerCase();
               }
            },
            { "data": "status", render: function (data, type, row) {
               return data.charAt(0).toUpperCase()+data.slice(1);
               }
            },   
            { "data": "id", render: function (data, type, row) {
                if({{Helper::getDemomode()}} != 1){
                    var button='<div class="input-group-btn action_group"> <li class="action_icon"> <button type="button"class="btn btn-info btn-block "data-toggle="dropdown"><i class="fa fa-ellipsis-v" aria-hidden="true" title="View"></i></button>'+
                       '<ul class="dropdown-menu">';
                       button +='<li><a href="javascript:;" data-id="'+data+'" class="dropdown-item edit"><i class="fa fa-edit"></i> Edit</a> </li><li><a href="javascript:;" data-id="'+data+'" class="dropdown-item delete"><i class="fa fa-trash"></i>&nbsp;Delete</a> </li>';
                        button +='</ul> </li></div>';
                     return  button;  
                }

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

    $('body').on('click', '.delete', function() {
        var id = $(this).data('id');
        var url = getBaseUrl() + "/admin/dispute/"+id;
        deleteRow(id, url, table);
    });

} );
</script>
@stop

@extends('common.admin.layout.base')
{{ App::setLocale(  isset($_COOKIE['admin_language']) ? $_COOKIE['admin_language'] : 'en'  ) }}

@section('title') {{ __('admin.dispute.order_title') }}@stop

@section('styles')
@parent
    <link rel="stylesheet" href="{{ asset('assets/plugins/data-tables/css/dataTables.bootstrap.min.css')}}"/>
    <link rel="stylesheet" href="{{ asset('assets/plugins/data-tables/css/responsive.bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/jquery-ui/jquery-ui.css')}}">

@stop

@section('content')

<div class="main-content-container container-fluid px-4"> 
    <div class="page-header row no-gutters py-4">
        <div class="col-12 col-sm-4 text-center text-sm-left mb-0">
            <span class="text-uppercase page-subtitle">{{ __('admin.dispute.order.title') }}</span>
            <h3 class="page-title">{{ __('admin.dispute.order.title') }}</h3>
        </div>
    </div>
    <div class="row mb-4 mt-20">
        <div class="col-md-12">
            <div class="card card-small">
                <div class="card-header border-bottom">
                    <h6 class="m-0 pull-left">{{ __('admin.dispute.order.title') }}</h6>
                    
                    <a href="javascript:;" class="btn btn-success pull-right add"><i class="fa fa-plus"></i> {{ __('admin.dispute.add_order_dispute') }}</a>
                    
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
                            <th data-value="id">{{ __('admin.id') }}</th>                         
                            <th data-value="request_id">{{ __('admin.dispute.dispute_request_id') }}</th>
                            <th data-value="dispute_type">{{ __('admin.dispute.dispute_type') }}</th> 
                            <th data-value="dispute_name">{{ __('admin.dispute.dispute_name') }}</th>                           
                            <th data-value="comments">{{ __('admin.dispute.dispute_comments') }}</th>                           
                            <th data-value="refund_amount">{{ __('admin.dispute.dispute_refund') }}</th>                           
                            <th data-value="status">{{ __('admin.status')   }}</th>
                            <th>{{ __('admin.action')  }}</th>
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
<script src="{{ asset('assets/plugins/jquery-ui/jquery-ui.js')}}"></script>

<script>
var tableName = '#data-table';
var table = $(tableName);
$(document).ready(function() {

    var url = getBaseUrl() + "/admin/store/requestdispute";
    var keys = {id: "S.No.", booking_id: "Booking Id", dispute_type: "Dispute Type", dispute_name: "Reason", comments: "Comments", refund_amount: "Refund Amount", status: "Status"};

    jQuery.fn.DataTable.Api.register( 'buttons.exportData()', function ( options ) {
        if ( this.context.length ) {
            var dataArray = new Array();
            var params = getTableData($(tableName).DataTable());
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

                        if(data.email) {
                            if({{Helper::getEncrypt()}} == 1) data.email = protect_email(data.email);
                            else data.email = data.email;
                        }
                        
                        if(data.mobile) {
                            if({{Helper::getEncrypt()}} == 1) data.mobile = '+'+data.country_code + protect_number(data.mobile);
                            else data.mobile = '+'+data.country_code + data.mobile;
                        }

                        if(data.status) {
                            if(data.status == 1) data.status = "Closed";
                            else data.status = "Open";
                        }

                        if(data.dispute_type) {
                            data.dispute_type = (data.dispute_type).charAt(0).toUpperCase()+(data.dispute_type).slice(1);
                        }

                        if(data.request) {
                            data.booking_id = data.request.store_order_invoice_id;
                        }

                        if(data.wallet_balance) {
                            data.wallet_balance = data.currency_symbol + data.wallet_balance;
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

    $('.add').on('click', function(e) {
        e.preventDefault();
        $.get("{{ url('admin/order-dispute/create') }}", function(data) {
            $('.crud-modal .modal-container').html("");
            $('.crud-modal .modal-container').html(data);
        });
        $('.crud-modal').modal('show');
    });

    $('body').on('click', '.edit', function(e) {
        e.preventDefault();
        $.get("{{ url('admin/order-dispute/') }}/"+$(this).data('id')+"/edit", function(data) {
            $('.crud-modal .modal-container').html("");
            $('.crud-modal .modal-container').html(data);
        });
        $('.crud-modal').modal('show');
    });


    table = table.DataTable( {
        "processing": true,
        "serverSide": true,
        "aoColumnDefs": [{ "bSortable": false, "aTargets": [7]}],
        "ajax": {
            "url": getBaseUrl() +"/admin/store/requestdispute",
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
            { "data": "request_id",render: function (data, type, row) {
               return row.request.store_order_invoice_id;
              }
            },
            { "data": "dispute_type", render: function (data, type, row) {
               return data.charAt(0).toUpperCase()+data.slice(1);
               }
            },
            { "data": "dispute_name", render: function (data, type, row) {
                if(data){
                    disputecomments = row.dispute_type_comments != null ? row.dispute_type_comments:'';
                    if(disputecomments != ''){
                        return data.replace(/^(.)|\s(.)/g, function(dispute_name){ return dispute_name.toUpperCase( ); }) + " - " + disputecomments;
                    }else{
                        return data.replace(/^(.)|\s(.)/g, function(dispute_name){ return dispute_name.toUpperCase( ); });
                    }
                }else{
                    return data;
                }
               }
            },
            { "data": "comments", render: function (data, type, row) {
                if(data){
                  return data.replace(/^(.)|\s(.)/g, function(comments){ return comments.toUpperCase( ); });
                }else{
                  return data;
                }
               }
            },
            { "data": "dispute_type", render: function (data, type, row) {
                if(data =="user"){
                    return row.user?row.user.currency_symbol+row.refund_amount:'$0';
                }
                    return row.provider?row.provider.currency_symbol+row.refund_amount:'$0';
               }
            },
            { "data": "status", render: function (data, type, row) {
               return data.charAt(0).toUpperCase()+data.slice(1);
               }
            },
            { "data": "id", render: function (data, type, row) {
                if(row.status =="open" && "{{Helper::getDemomode()}}" != 1)
                return "<button data-id='"+data+"' class='btn btn-block btn-success edit'>Edit</button>";
               }
            }

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
        var url = getBaseUrl() +"/admin/service/requestdispute/"+id;
        deleteRow(id, url, table);
    });

} );
</script>
@stop

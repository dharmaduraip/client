@extends('common.admin.layout.base')
{{ App::setLocale(  isset($_COOKIE['admin_language']) ? $_COOKIE['admin_language'] : 'en'  ) }}

@section('title') {{ __('Payroll') }} @stop

@section('styles')
@parent
    <link rel="stylesheet" href="{{ asset('assets/plugins/data-tables/css/dataTables.bootstrap.min.css')}}"/>
    <link rel="stylesheet" href="{{ asset('assets/plugins/data-tables/css/responsive.bootstrap.min.css')}}">
    <link rel="stylesheet"  type='text/css' href="{{ asset('assets/plugins/cropper/css/cropper.css')}}" />
@stop

@section('content')
@include('common.admin.includes.image-modal')
<!-- Modal Starts -->

<div class="modal fade bs-modal-lg complete-modal" tabindex="-1" role="basic" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{ __('Confirm') }}</h4>
            </div>
            <div class="modal-body">
            {{ __('Are you sure want to complete?') }}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn default" data-dismiss="modal">{{ __('Close') }}</button>
                <button type="button" data-value="1" class="btn btn-danger complete-modal-btn">{{ __('Confirm') }}</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<!-- Modal Ends -->

<div class="main-content-container container-fluid px-4">
    <div class="page-header row no-gutters py-4">
        <div class="col-12 col-sm-4 text-center text-sm-left mb-0">
            <span class="text-uppercase page-subtitle">{{ __('Payroll') }}</span>
            <h3 class="page-title">{{ __('Payroll') }} {{ __('List') }}</h3>
        </div>
    </div>
    <div class="row mb-4 mt-20">
        <div class="col-md-12">
            <div class="card card-small">
                <div class="card-header border-bottom">
                    <h6 class="m-0 pull-left">{{ __('Payroll') }}</h6>
                    @if(Helper::getDemomode() != 1)
                    <a href="javascript:;" class="btn btn-success pull-right add new_user"><i class="fa fa-plus"></i> {{ __('Add New') }} {{ __('Payroll') }}</a>
                    @endif
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
                        <th data-value="transaction_id">{{ __('admin.transaction') }}</th>
                        <th data-value="template_id">{{ __('admin.payroll_type') }}</th>
                        <th data-value="status">{{ __('admin.status') }}</th>
                        <th>{{ __('admin.action') }}</th>
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
<script src = "{{ asset('assets/plugins/cropper/js/cropper.js')}}" > </script> 
<script src = "{{ asset('assets/layout/js/crop.js')}}" > </script>

<script>
var tableName = '#data-table';
var table = $(tableName);

showLoader();

$(document).ready(function() {

    var url = getBaseUrl() + "/admin/payroll";
    var keys = {id: "S.No.", transaction_id: "Transaction", payroll_type: "Payroll Type", status: "Status"};

    datatable_export(url, keys, {{Helper::getEncrypt()}});

    $('.add').on('click', function(e) {
        e.preventDefault();
             $.get("{{ url('admin/payroll/type') }}", function(data) {
                $('.crud-modal .modal-container').html("");
                $('.crud-modal .modal-container').html(data);
             });
        $('.crud-modal').modal('show');
    });

    $('body').on('click', '.addmanual', function(e) { 
        //$(".crud-modal").modal("hide");
        e.preventDefault();
         $.get("{{ url('admin/payroll/manualcreate') }}", function(data) {
            $('.crud-modal .modal-container').html("");
            $('.crud-modal .modal-container').html(data);
         });
         $('.crud-modal').modal('show');

    });
    $('body').on('click', '.addtemplate', function(e) { 
        e.preventDefault();
        //$(".crud-modal").modal("hide");
            $.get("{{ url('admin/payroll/create') }}", function(data) {
                $('.crud-modal .modal-container').html("");
                $('.crud-modal .modal-container').html(data);
             });
             $('.crud-modal').modal('show');
    });

       
       
   

    $('body').on('click', '.complete', function(e) { 
        e.preventDefault();
        $(".complete-modal").modal("show");
        var that = $(this);
        var id = $(this).data('id');

        $('body').off().on('click', '.complete-modal-btn', function(e) { 
            e.preventDefault();
            $.ajax({
                url: getBaseUrl() + "/admin/payroll/update-payroll",
                type: "post",
                headers: {
                    "Authorization": "Bearer " + getToken("admin")
                },
                data: {
                    id: id,
                    status: "COMPLETED"
                },
                beforeSend: function (request) {
                    showInlineLoader();
                },
                success: function(response, textStatus, jqXHR) {
                    that.closest('tr').find('td:nth(3)').text("COMPLETED");
                    that.parent().remove();
                    $(".complete-modal").modal("hide");
                    hideInlineLoader();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alertMessage(textStatus, jqXHR.statusText, "danger");
                    $(".complete-modal").modal("hide");
                    hideInlineLoader();
                }
            });
        });

    });

    $('#myModal').on('hidden.bs.modal', function () {
        $('.crud-modal .modal-container').html("");
    });

    table = table.DataTable( {
        "processing": true,
        "serverSide": true,
        "pageLength": 10,
        "ajax": {
            "url": getBaseUrl() + "/admin/payroll",
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
            dataFilter: function(response){        
                var json = parseData(response); 

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
            { "data": "transaction_id" },
            { "data": "payroll_type" },
            { "data": "status"},
            { "data": function (data, type, row) {

            var button=`<div class="input-group-btn action_group"> <li class="action_icon"> <button type="button"class="btn btn-info btn-block "data-toggle="dropdown"><i class="fa fa-ellipsis-v" aria-hidden="true" title="View"></i></button>`+
                   `<ul class="dropdown-menu">`;
                    if({{Helper::getDemomode()}} != 1){
                        if(data.status != "COMPLETED") {
                            button +=`<li><a href="javascript:;" data-id="`+data.id+`" class="dropdown-item complete"><i class="fa fa-edit"></i> Complete</a> </li>`; 
                        }
                        button +=`<li><a href="javascript:;" data-id="`+data.transaction_id+`" class="dropdown-item delete"><i class="fa fa-trash"></i> Delete</a> </li>
                        <li><a href="`+getBaseUrl() + `/admin/payrolls/download/`+data.transaction_id+`" data-id="`+data.transaction_id+`" class="dropdown-item "><i class="fa fa-database"></i> Download</a> </li>`;
                    }
                    button +=`</ul> </li></div>`;
                 return  button;  

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
    });
    

    $('body').on('click', '.delete', function() {
        var id = $(this).data('id');
        var url = getBaseUrl() + "/admin/payroll/"+id;
        deleteRow(id, url, table);
    });

    $('body').on('click', '.status', function() {
        var id = $(this).data('id');
        var value = $(this).data('value');

         $(".status-modal").modal("show");
            $(".status-modal-btn")
                .off()
                .on("click", function() {
                
                    
                    var url = getBaseUrl() + "/admin/payrolls/"+id+'/updateStatus?status='+value;

                    $.ajax({
                        type:"GET",
                        url: url,
                        headers: {
                            Authorization: "Bearer " + getToken("admin")
                        },
                        'beforeSend': function (request) {
                            showInlineLoader();
                        },
                        success:function(data){
                            $(".status-modal").modal("hide");
                            
                            var info = $('#data-table').DataTable().page.info();
                            table.order([[ info.page, 'asc' ]] ).draw( false );
                            alertMessage("Success", data.message, "success");
                            hideInlineLoader();
                        }
                    });
                });
        
    });

    $('body').on('click', '.downloads', function(e) {
        //e.preventDefault();
        var type = "User";
        var url = getBaseUrl() + "/admin/payrolls/download/"+$(this).data('id');
        $.ajax({
            type:"GET",
            url: url,
            responseType: 'blob',
            headers: {
                Authorization: "Bearer " + getToken("admin")
            },
            'beforeSend': function (request) {
                showInlineLoader();
            },
            success:function(data){
                const url = window.URL.createObjectURL(new Blob([data]));
                const link = document.createElement('a');
                link.setAttribute('download', 'invoices.xlsx');
                document.body.appendChild(link);
                link.click();
                hideInlineLoader();
            }
        });
        
    });

});
</script>
@stop

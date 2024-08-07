<?php 
header('Access-Control-Allow-Origin: *'); 
if(isset($_GET['location']) && !empty($_GET['location'])) {
    $location = explode('-',$_GET['location']);
}

?>
@extends('common.admin.layout.base')
{{ App::setLocale(  isset($_COOKIE['admin_language']) ? $_COOKIE['admin_language'] : 'en'  ) }}

@section('title') Users @stop

@section('styles')
@parent
    <link rel="stylesheet"  type='text/css' href="{{ asset('assets/plugins/cropper/css/cropper.css')}}" />
    <link rel="stylesheet" href="{{ asset('assets/plugins/data-tables/css/dataTables.bootstrap.min.css')}}"/>
    <link rel="stylesheet" href="{{ asset('assets/plugins/data-tables/css/responsive.bootstrap.min.css')}}">

@stop

@section('content')
@include('common.admin.includes.image-modal')
<div class="main-content-container container-fluid px-4">
    <div class="page-header row no-gutters py-4">
        <div class="col-12 col-sm-4 text-center text-sm-left mb-0">
            <span class="text-uppercase page-subtitle">{{ __('Users') }}</span>
            <h3 class="page-title">{{ __('Users') }} {{ __('List') }} </h3>
        </div>
    </div>
    <div class="row mb-4 mt-20">
        <div class="col-md-12">
            <div class="card card-small">
                <div class="card-header border-bottom">
                    <h6 class="m-0 pull-left">{{ __('Users') }}</h6>
                    @if(isset($location) && $location[1] > 0)
                        <a href="{{url('admin/user')}}" class="badge badge-info ml-4"><i class="fa fa-times"></i> {{$location[0]}}</a>
                    @endif
                    <a href="javascript:;" class="btn btn-success pull-right add new_user"><i class="fa fa-plus"></i> {{ __('Add New') }} {{ __('User') }}</a>

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
                        <th data-value="first_name">{{ __('admin.first_name') }}</th>
                        <th data-value="last_name">{{ __('admin.last_name') }}</th>
                        <th data-value="email">{{ __('admin.email') }}</th>
                        <th data-value="mobile">{{ __('admin.mobile') }}</th>
                        <th data-value="rating">{{ __('admin.users.Rating') }}</th>
                        <th data-value="wallet_balance">{{ __('admin.users.Wallet_Amount') }}</th>
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

    var url = getBaseUrl() + "/admin/users";
    var keys = {id: "S.No.", first_name: "First Name", last_name: "Last Name", email: "Email", mobile: "Mobile", rating: "Rating", wallet_balance: "Wallet Amount", status: "Status"};

    datatable_export(url, keys, {{Helper::getEncrypt()}});

    $('.add').on('click', function(e) {
        e.preventDefault();
        $.get("{{ url('admin/user/create') }}", function(data) {
            $('.crud-modal .modal-container').html("");
            $('.crud-modal .modal-container').html(data);
        });
        $('.crud-modal').modal('show');
    });

    $('body').on('click', '.edit', function(e) {

        e.preventDefault();
        $.get("{{ url('admin/user/') }}/"+$(this).data('id')+"/edit", function(data) {
            $('.crud-modal .modal-container').html("");
            $('.crud-modal .modal-container').html(data);
        });
        $('.crud-modal').modal('show');
    });

    $('#myModal').on('hidden.bs.modal', function () {
        $('.crud-modal .modal-container').html("");
    });



    table = table.DataTable( {
        "processing": true,
        "serverSide": true,
        "aoColumnDefs": [{ "bSortable": false, "aTargets": [8]}],
        "pageLength": 10,
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
                @if(isset($location) && $location[1] > 0)
                    data.location = {{$location[1]}};
                @endif



            },
            dataFilter: function(response){

                var data = parseData(response);
                var json = data;

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
            { "data": "first_name" },
            { "data": "last_name" },
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
                    return '+'+data.country_code + protect_number(data.mobile);
                }
                else{
                    return '+'+data.country_code + data.mobile;
                }
            } },
            { "data": "rating" },
            { "data": "wallet_balance" ,render: function (data, type, row) {
                return (row.currency_symbol != null ? row.currency_symbol : '') + ' ' +  row.wallet_balance;
            }},
            { "data": "status" ,render: function (data, type, row) {
                   if(data ==1){
                        return "<label class='switch'><input type='checkbox' class='status_enable switch-warning' checked data-id='"+row.id+"' data-value='"+row.status+"'> <span class='slider round'></span></label>"
                   }else{
                    return "<label class='switch'><input type='checkbox' class='status_enable'  data-id='"+row.id+"' data-value='"+row.status+"'> <span class='slider round'></span></label>"
                   }
                }
            },
            { "data": function (data, type, row) {

                if(data.status ==1){
                    var status ="Disable";
                }else{
                    var status="Enable";
                }


                    var button='<div class="input-group-btn action_group"> <li class="action_icon"> <button type="button"class="btn btn-info btn-block "data-toggle="dropdown"><i class="fa fa-ellipsis-v" aria-hidden="true" title="View"></i></button><ul class="dropdown-menu">';

                   button +='<li><a href="javascript:;" data-id="'+data.id+'" class="dropdown-item edit"><i class="fa fa-edit"></i> Edit</a> </li><li><a href="javascript:;" data-id="'+data.id+'" class="dropdown-item logs"><i class="fa fa-database"></i> Logs</a> </li><li><a href="javascript:;" data-id="'+data.id+'" class="dropdown-item wallet"><i class="fa fa-google-wallet"></i> Wallet Details</a> </li>';

                    button +='</ul> </li></div>';

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

                var info = $('#data-table').DataTable().page.info();

                if (info.pages<=1) {
                   $('#data-table .dataTables_paginate').hide();
                   $('#data-table .dataTables_info').hide();
                }else{
                   $('#data-table .dataTables_paginate').show();
                   $('#data-table .dataTables_info').show();
                }
            }
    });

    $('body').on('click', '.status_enable', function() {
        var id = $(this).data('id');
        var value = $(this).data('value');

         $(".status-modal").modal("show");
            $(".status-modal-btn")
                .off()
                .on("click", function() {


                    var url = getBaseUrl() + "/admin/users/"+id+'/updateStatus?status='+value;

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
                            alertMessage("Success", "Status Changed", "success");
                            hideInlineLoader();
                        },
                        error:function(jqXHR, textStatus, errorThrown){
                            $(".status-modal").modal("hide");

                            if (jqXHR.status == 401 && getToken(guard) != null) {
                                refreshToken(guard);
                            } else if (jqXHR.status == 401) {
                                window.location.replace("/admin/login");
                            }

                            if (jqXHR.responseJSON) {
                                alertMessage(textStatus, jqXHR.responseJSON.message, "danger");
                            }
                            hideInlineLoader();
                        }
                    });
                });

    });


    $('body').on('click', '.logs', function(e) {
        e.preventDefault();
        var type = "User";
        $.get("{{ url('admin/logs/') }}/"+$(this).data('id')+"/"+type, function(data) {
            $('.crud-modal .modal-container').html("");
            $('.crud-modal .modal-container').html(data);
        });
        $('.crud-modal').modal('show');
    });

    $('body').on('click', '.wallet', function(e) {
        e.preventDefault();
        var type = "User";
        $.get("{{ url('admin/wallet/') }}/"+$(this).data('id')+"/"+type, function(data) {
            $('.crud-modal .modal-container').html("");
            $('.crud-modal .modal-container').html(data);
        });
        $('.crud-modal').modal('show');
    });

});
</script>
<script>
  $(function() {
    $('#toggle-two').bootstrapToggle({
      on: 'Enabled',
      off: 'Disabled'
    });
  })
</script>
@stop

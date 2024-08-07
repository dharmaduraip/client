<?php 
if(isset($_GET['location']) && !empty($_GET['location'])) {
    $location = explode('-',$_GET['location']);
}

?>
@extends('common.admin.layout.base')
{{ App::setLocale(  isset($_COOKIE['admin_language']) ? $_COOKIE['admin_language'] : 'en'  ) }}

@section('title') {{ __('Provider') }} @stop

@section('styles')
@parent
    <link rel="stylesheet" href="{{ asset('assets/plugins/data-tables/css/dataTables.bootstrap.min.css')}}"/>
    <link rel="stylesheet" href="{{ asset('assets/plugins/data-tables/css/responsive.bootstrap.min.css')}}">
    <link rel="stylesheet"  type='text/css' href="{{ asset('assets/plugins/cropper/css/cropper.css')}}" />
    <link rel="stylesheet" href="{{ asset('assets/layout/css/service-master.css')}}">
@stop

@section('content')
@include('common.admin.includes.image-modal')
<div class="main-content-container container-fluid px-4">
    <div class="page-header row no-gutters py-4">
        <div class="col-12 col-sm-4 text-center text-sm-left mb-0">
            <span class="text-uppercase page-subtitle">{{ __('Providers') }}</span>
            <h3 class="page-title">{{ __('Providers') }} {{ __('List') }}</h3>
        </div>
    </div>
    <div class="row mb-4 mt-20">
        <div class="col-md-12">
            <div class="card card-small">
                <div class="card-header border-bottom">
                    <h6 class="m-0 pull-left">{{ __('Providers') }}</h6>
                    @if(isset($location) && $location[1] > 0)
                        <a href="{{url('admin/provider')}}" class="badge badge-info ml-4"><i class="fa fa-times"></i> {{$location[0]}}</a>
                    @endif

                     <a href="javascript:;" class="btn btn-success pull-right add"><i class="fa fa-plus"></i> {{ __('Add New') }} {{ __('Provider') }}</a>

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
                        <th data-value="admin_id">{{ __('admin.owner') }}</th>
                        <th data-value="payment_mode">{{ __('admin.request.wallet_balance') }}</th>
                        <th data-value="status">{{ __('admin.status') }}</th>
                        <th>{{ __('admin.action') }}</th>
                    </tr>
                 </thead>


                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade bs-modal-lg vechiledetails" tabindex="-1" role="basic" aria-hidden="true" data-backdrop="static" data-keyboard="false" >
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-container">
                <div class="row mb-4 mt-20">
                        <div class="col-md-12">
                                <div class="card-header border-bottom">
                                    <h6 class="m-0"style="margin:10!important;">{{ __('Vehicle Details') }}</h6>
                                </div>
                                <div class="form_pad">
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label><b style ="font-weight:bold">{{ __('Vehicle Name') }}:</b> <span class="m-0 vehicle_make"></label>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label><b style ="font-weight:bold">{{ __('Vehicle Number') }}:</b> <span class="m-0 vehicle_no"></label>
                                         </div>
                                    </div>

                                    <div class="form-row transport">
                                        <div class="form-group col-md-6">
                                            <label><b style ="font-weight:bold">{{ __('Vehicle Year') }}:</b> <span class="m-0 vehicle_year"></label>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label><b style ="font-weight:bold">{{ __('Vehicle Model') }}:</b> <span class="m-0 vehicle_model"></label>
                                        </div>
                                    </div>

                                    <div class="form-row transport">
                                        <div class="form-group col-md-6">
                                            <label><b style ="font-weight:bold">{{ __('Vehicle Color') }}:</b> <span class="m-0 vehicle_color"></label>
                                        </div>
                                        <div class="form-group col-md-6">
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <div class=" m-0 front_image1" style =margin-left:100px;>
                                             <p style ="font-weight:bold">{{ __('RC') }}</p>
                                            <img src = "" class ="img" height ="200px;" width ="200px;" />
                                           </div>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <div class=" m-0 backend_image" style =margin-left:100px;>
                                            <p style ="font-weight:bold">{{ __('Insurance') }}</p>
                                            <img src = "" class ="img1" height ="200px;" width ="200px;" />
                                            </div>
                                        </div>
                                    </div>
                                   <!--  <div id="approve_vechile"></div>
                                    <div id="delete_vechile"></div>  -->
                                    <button class="btn btn-danger btn-large vechileCancel pull-right documentcancel"  type="submit" style = "margin-right:20px;">{{ __('Cancel') }}</button>

                               </div>
                     </div>
                </div>
           </div>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>

<div class="modal fade bs-modal-lg documentdetails" tabindex="-1" role="basic" aria-hidden="true" data-backdrop="static" data-keyboard="false" >
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-container">

		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
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
var changed = false;
$(document).ready(function() {

    var url = getBaseUrl() + "/admin/provider";
    var keys = {id: "S.No.", first_name: "First Name", last_name: "Last Name", email: "Email", mobile: "Mobile", admin: "Owner", wallet_balance: "Wallet Amount", status: "Status"};

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
                            if(data.status == 1) data.status = "Enable";
                            else data.status = "Disable";
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
        $.get("{{ url('admin/provider/create') }}", function(data) {
            $('.crud-modal .modal-container').html("");
            $('.crud-modal .modal-container').html(data);
        });
        $('.crud-modal').modal('show');
    });

    $('body').on('click', '.add_amount', function(e) {
        e.preventDefault();
        $.get("{{ url('admin/provider/') }}/"+$(this).data('id')+"/addamount", function(data) {
            $('.crud-modal .modal-container').html("");
            $('.crud-modal .modal-container').html(data);
        });
        $('.crud-modal').modal('show');
    });

    $('body').on('click', '.edit', function(e) {
        e.preventDefault();
        $.get("{{ url('admin/provider/') }}/"+$(this).data('id')+"/edit", function(data) {
            $('.crud-modal .modal-container').html("");
            $('.crud-modal .modal-container').html(data);
        });
        $('.crud-modal').modal('show');
    });
    $('body').on('click', '.document', function(e) {
        e.preventDefault();
        $.get("{{ url('admin/provider/') }}/"+$(this).data('id')+"/"+$(this).data('cityid')+"/"+$(this).data('zoneid')+"/document", function(data) {
            $('.crud-modal .modal-container').html("");
            $('.crud-modal .modal-container').html(data);
        });
        $('.crud-modal').modal('show');
    });


    table = table.DataTable( {
        "processing": true,
        "serverSide": true,
        "pageLength": 10,
        "aoColumnDefs": [{ "bSortable": false, "aTargets": [7]}],
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
            dataFilter: function(data){

                var json = parseData( data );
                data.search_text = data.search['value'];
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
            { "data": function (data, type, row) {
                return data.admin != null ? data.admin.type : '';
            } },
            { "data": function (data, type, dataToSet) {

                    return data.currency_symbol + data.wallet_balance;
            } },
            { "data": "activation_status" ,render: function (data, type, row) {
                    if(data == "1" && row.status=="APPROVED"){
                        return "<label class='switch'><input type='checkbox' class='status_enable' checked  data-id='"+row.id+"' data-value='"+row.activation_status+"'> <span class='slider round'></span></label>"
                    }else{
                        return "<label class='switch'><input type='checkbox' class='status_enable'  data-id='"+row.id+"' data-value='"+row.activation_status+"'> <span class='slider round'></span></label>"

                    }
                }
            },
            { "data": function (data, type, row) {
               // console.log(data);
                if(data.activation_status == "1" && data.status=="APPROVED"){
                    var status ="Disable";
                }else{
                    var status="Enable";
                }

                var button='<div class="input-group-btn action_group"> <li class="action_icon"> <button type="button"class="btn btn-info btn-block "data-toggle="dropdown"><i class="fa fa-ellipsis-v" aria-hidden="true" title="View"></i></button>'+
                       '<ul class="dropdown-menu">';

                       if(data.status=="APPROVED"){
                            button +='<li > <a class="dropdown-item status" data-id="'+data.id+'" data-value="'+status+'"  href="javascript:;"><i class="fa fa-plus" aria-hidden="true" title="Status">&nbsp;'+status+'</i></a></li>';
                        }


                        if({{Helper::getDemomode()}} != 1){
                        button +='<li><a href="javascript:;"  data-id="'+data.id+'" class="dropdown-item edit"><i class="fa fa-edit"></i> Edit</a> </li><li><a href="javascript:;"  data-id="'+data.id+'" class="dropdown-item add_amount"><i class="fa fa-plus"></i>Add Amount</a> </li><li><a href="javascript:;" data-id="'+data.id+'" class="dropdown-item wallet"><i class="fa fa-google-wallet"></i> Wallet Details</a> </li><li><a href="javascript:;" data-cityid="'+data.city_id+'" data-zoneid="'+data.zone_id+'" data-id="'+data.id+'" class="dropdown-item document"><i class="fa fa-thumbs-up"></i>Approval</a> </li><li><a href="javascript:;" data-id="'+data.id+'" class="dropdown-item logs"><i class="fa fa-database"></i> Logs</a> </li>';
                        }
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
                   $('.dataTables_paginate').hide();
                   $('.dataTables_info').hide();
                }else{
                    $('.dataTables_paginate').show();
                    $('.dataTables_info').show();
                }
            }
    } );

    $('body').on('click', '.status_enable', function() {
        changed = false;
        var id = $(this).data('id');
        var value = $(this).data('value');

        if(value == 1){value = 'Disable'}
        else{value = 'Enable'}

         $(".status-modal").modal("show");
            $(".status-modal-btn")
                .off()
                .on("click", function() {

                    var url = getBaseUrl() + "/admin/provider/"+id+'/updateStatus?status='+value;

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
                            changed = true;
                            $(".status-modal").modal("hide");

                            var info = $('#data-table').DataTable().page.info();
                            table.order([[ info.page, 'asc' ]] ).draw( false );
                            alertMessage("Success", data.message, "success");
                            hideInlineLoader();
                        }
                    });
                });
        $(".status-modal").on('hidden.bs.modal', function () {
          if(!changed){
              $(".status_enable[data-id='"+id+"']").prop('checked',!($(".status_enable[data-id='"+id+"']").prop('checked')));
              changed = false;
          }
          $(this).off('hidden.bs.modal');
        })

    });

    $('body').on('click', '.logs', function(e) {
        e.preventDefault();
        var type = "Provider";
        $.get("{{ url('admin/logs/') }}/"+$(this).data('id')+"/"+type, function(data) {
            $('.crud-modal .modal-container').html("");
            $('.crud-modal .modal-container').html(data);
        });
        $('.crud-modal').modal('show');
    });



    $('body').on('click', '.wallet', function(e) {
        e.preventDefault();
        var type = "Provider";
        $.get("{{ url('admin/wallet/') }}/"+$(this).data('id')+"/"+type, function(data) {
            $('.crud-modal .modal-container').html("");
            $('.crud-modal .modal-container').html(data);
        });
        $('.crud-modal').modal('show');
    });

} );
</script>
@stop

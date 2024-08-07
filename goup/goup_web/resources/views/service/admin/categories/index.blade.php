@extends('common.admin.layout.base')
{{ App::setLocale(  isset($_COOKIE['admin_language']) ? $_COOKIE['admin_language'] : 'en'  ) }}

@section('title') {{ __('Service Main') }} {{ __('Categories') }}  @stop

@section('styles')
@parent
    <link rel="stylesheet"  type='text/css' href="{{ asset('assets/plugins/cropper/css/cropper.css')}}" />
    <link rel="stylesheet" href="{{ asset('assets/plugins/data-tables/css/dataTables.bootstrap.min.css')}}"/>
    <link rel="stylesheet" href="{{ asset('assets/plugins/data-tables/css/responsive.bootstrap.min.css')}}">
    <!-- <link rel="stylesheet" href="{{ asset('assets/layout/css/service-master.css')}}"> -->
@stop

@section('content')
@include('common.admin.includes.image-modal')
<div class="main-content-container container-fluid px-4">
    <div class="page-header row no-gutters py-4">
        <div class="col-12 col-sm-4 text-center text-sm-left mb-0">
            <span class="text-uppercase page-subtitle">{{ __('service.admin.categories.title') }}</span>
            <h3 class="page-title">{{ __('service.admin.categories.title') }}</h3>
        </div>
    </div>
    <div class="row mb-4 mt-20">
        <div class="col-md-12">
            <div class="card card-small">
                <div class="card-header border-bottom">
                    <h6 class="m-0 pull-left">{{ __('service.admin.categories.title') }}</h6>

                    <a href="javascript:;" class="btn btn-success pull-right add new_user"><i class="fa fa-plus"></i> {{ __('service.admin.categories.add') }}</a>

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
                        <th data-value="service_category_name">{{ __('service.admin.categories.name') }}</th>
                        <!--<th data-value="picture">{{ __('service.admin.categories.image') }}</th>
                        <th data-value="service_category_order">{{ __('service.admin.categories.order') }}</th>-->
                        <th data-value="service_category_status">{{ __('service.admin.categories.status') }}</th>
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
<?php $logo = 'data:image/jpeg;base64,'.base64_encode(file_get_contents(Helper::getSettings()->site->site_logo)); ?>

$(document).ready(function() {
    $('.add').on('click', function(e) {
        e.preventDefault();
        $.get("{{ url('admin/service-categories/create') }}", function(data) {
            $('.crud-modal .modal-container').html("");
            $('.crud-modal .modal-container').html(data);
        });
        $('.crud-modal').modal('show');
    });

    $('body').on('click', '.edit', function(e) {
        e.preventDefault();
        $.get("{{ url('admin/service-categories/') }}/"+$(this).data('id')+"/edit", function(data) {
            $('.crud-modal .modal-container').html("");
            $('.crud-modal .modal-container').html(data);
        });
        $('.crud-modal').modal('show');
    });

    table = table.DataTable( {
        "processing": true,
        "serverSide": true,
        "pageLength": 10,
        "ajax": {
            "url": getBaseUrl() + "/admin/service/categories",
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
            { "data": "service_category_name" },
            /*{ "data": "picture", render: function (data, type, row) {

                if(data){
                    return "<img src='"+data+"' class='input_img picture-src img-responsive imgsmall' title='' style='height: 50px;width:50px;'/>";
                }else{
                    return "NA";
                }


            }},
            { "data": "service_category_order" },*/
            { "data": "service_category_status" ,render: function (data, type, row) {
                if(data == 1){
                        return "<label class='switch'><input type='checkbox' class='status_enable switch-warning' checked data-id='"+row.id+"' data-value='"+row.service_category_status+"'> <span class='slider round'></span></label>"

                   }else{
                    return "<label class='switch'><input type='checkbox' class='status_enable'  data-id='"+row.id+"' data-value='"+row.service_category_status+"'> <span class='slider round'></span></label>"
                   }
            }
            },
            { "data": function (data, type, row) {

                if(data.service_category_status ==1){
                    var status ="Disable";
                }else{
                    var status="Enable";
                }

            var button='<div class="input-group-btn action_group"> <li class="action_icon"> <button type="button"class="btn btn-info btn-block "data-toggle="dropdown"><i class="fa fa-ellipsis-v" aria-hidden="true" title="View"></i></button>'+
                   '<ul class="dropdown-menu">';
                    if({{Helper::getDemomode()}} != 1){
                   button +='<li > <a class="dropdown-item status" data-id="'+data.id+'" data-value="'+data.service_category_status+'"  href="javascript:;"><i class="fa fa-plus" aria-hidden="true" title="Status">&nbsp;'+status+'</i></a></li><li><a href="javascript:;" data-id="'+data.id+'" class="dropdown-item edit"><i class="fa fa-edit"></i> Edit</a> </li>';
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
               },
               extend: 'pdfHtml5',
               customize: function (doc) {
                    //Remove the title created by datatTables
                    doc.content.splice(0,1);
                    //Create a date string that we use in the footer. Format is dd-mm-yyyy
                    var now = new Date();
                    var jsDate = now.getDate()+'-'+(now.getMonth()+1)+'-'+now.getFullYear();
                    // Logo converted to base64
                    // var logo = getBase64FromImageUrl('https://datatables.net/media/images/logo.png');

                    //doc.pageMargins = [100,60,100,30];
                    doc.content.margin = [ 100, 0, 100, 0 ] //left, top, right, bottom
                    // Set the font size fot the entire document
                    doc.defaultStyle.fontSize = 20;
                    // Set the fontsize for the table header
                    doc.styles.tableHeader.fontSize = 20;
                    doc.defaultStyle.alignment = 'center';
                    // Create a header object with 3 columns
                    // Left side: Logo
                    // Middle: brandname
                    // Right side: A document title
                    doc['header']=(function() {
                        return {
                            columns: [
                                /*{
                                    image: 'https://foodie.deliveryventure.com/assets/user/img/login.jpg',
                                    width: 24
                                },*/
                                {
                                    alignment: 'left',
                                    italics: true,
                                    text: '{{Helper::getSettings()->site->site_title}}',
                                    fontSize: 18,
                                    margin: [10,0]
                                },
                                {
                                    alignment: 'right',
                                    fontSize: 14,
                                    text: 'Service Main Categories'
                                }
                            ],
                            margin: 20
                        }
                    });

                    // Change dataTable layout (Table styling)
                    // To use predefined layouts uncomment the line below and comment the custom lines below
                    // doc.content[0].layout = 'lightHorizontalLines'; // noBorders , headerLineOnly
                    var objLayout = {};
                    objLayout['hLineWidth'] = function(i) { return .5; };
                    objLayout['vLineWidth'] = function(i) { return .5; };
                    objLayout['hLineColor'] = function(i) { return '#aaa'; };
                    objLayout['vLineColor'] = function(i) { return '#aaa'; };
                    objLayout['paddingLeft'] = function(i) { return 4; };
                    objLayout['paddingRight'] = function(i) { return 4; };
                    doc.content[0].layout = objLayout;
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

function getBase64Image(img) {
    var canvas = document.createElement("canvas");
    canvas.width = img.width;
    canvas.height = img.height;
    canvas.setAttribute('crossOrigin', 'anonymous');
    var ctx = canvas.getContext("2d");
    ctx.drawImage(img, 0, 0);
    var dataURL = canvas.toDataURL("image/png");
    return dataURL.replace(/^data:image\/(png|jpg);base64,/, "");
}

    $('body').on('click', '.status_enable', function() {
        var id = $(this).data('id');
        var value = $(this).data('value');


         $(".status-modal").modal("show");
            $(".status-modal-btn")
                .off()
                .on("click", function() {


                    var url = getBaseUrl() + "/admin/service/categories/"+id+'/updateStatus?status='+value;

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
                            console.log("pavan");
                             var info = $('#data-table').DataTable().page.info();
                             console.log(info.page);
                            table.order([[ info.page, 'asc' ]] ).draw( false );
                            alertMessage("Success", data.message, "success");
                            hideInlineLoader();
                        }
                    });
                });

    });

} );
</script>
@stop

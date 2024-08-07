@extends('common.admin.layout.base')
{{ App::setLocale(  isset($_COOKIE['admin_language']) ? $_COOKIE['admin_language'] : 'en'  ) }}

@section('title') {{ __('Menu') }} @stop

@section('styles')
@parent
    <link rel="stylesheet" href="{{ asset('assets/plugins/data-tables/css/dataTables.bootstrap.min.css')}}"/>
    <link rel="stylesheet" href="{{ asset('assets/plugins/data-tables/css/responsive.bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/data-tables/css/dataTables.checkboxes.css')}}">
    <link rel="stylesheet"  type='text/css' href="{{ asset('assets/plugins/cropper/css/cropper.css')}}" />
@stop

@section('content')
@include('common.admin.includes.image-modal')
<div class="main-content-container container-fluid px-4">
    <div class="page-header row no-gutters py-4">
        <div class="col-12 col-sm-4 text-center text-sm-left mb-0">
            <span class="text-uppercase page-subtitle">{{ __('Menu') }}</span>
            <h3 class="page-title">{{ __('Menu') }} {{ __('List') }}</h3>
        </div>
    </div>
    <div class="row mb-4 mt-20">
        <div class="col-md-12">
            <div class="card card-small">
                <div class="card-header border-bottom">
                    <h6 class="m-0 pull-left">{{ __('Menu') }}</h6>
                    
                    <a href="javascript:;" class="btn btn-success pull-right add"><i class="fa fa-plus"></i> {{ __('Add New') }} {{ __('Menu') }}</a>
                    
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
                        <th data-value="sort_order">@lang('admin.id')</th>
                        <th data-value="title">{{ __('admin.menu.menu_name') }}</th>
                       <!--  <th data-value="icon">{{ __('admin.menu.icon') }}</th>
                        <th data-value="featured_image">{{ __('admin.menu.featured_image') }}</th> -->
                        <th data-value="admin_service">{{ __('admin.menu.service') }}</th>
                        <!-- <th data-value="menu_type_id">{{ __('admin.menu.menu_type') }}</th> -->

                        <th data-value="menu_city">{{ __('admin.menu.menu_city') }}</th>
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
<script src="{{ asset('assets/plugins/data-tables/js/dataTables.checkboxes.min.js')}}"></script>
<script src="{{ asset('assets/plugins/data-tables/js/jszip.min.js')}}"></script>
<script src="{{ asset('assets/plugins/data-tables/js/pdfmake.min.js')}}"></script>
<script src="{{ asset('assets/plugins/data-tables/js/vfs_fonts.js')}}"></script>
<script src="{{ asset('assets/plugins/data-tables/js/buttons.html5.min.js')}}"></script>
<script src = "{{ asset('assets/plugins/cropper/js/cropper.js')}}" > </script> 
<script src = "{{ asset('assets/layout/js/crop.js')}}" > </script> 
<style>
.select_city .list-group{
    max-height: 350px;
    margin-bottom: 10px;
    overflow:scroll;
    -webkit-overflow-scrolling: touch;
}
</style>
<script>
var tableName = '#data-table';
var table = $(tableName);
$(document).ready(function() {

    $('.add').on('click', function(e) {
        e.preventDefault();
        $.get("{{ url('admin/menu/create') }}", function(data) {
            $('.crud-modal .modal-container').html("");
            $('.crud-modal .modal-container').html(data);
        });
        $('.crud-modal').modal('show');
        
    });

    $('body').on('click', '.edit', function(e) {
        e.preventDefault();
        $.get("{{ url('admin/menu/') }}/"+$(this).data('id')+"/edit", function(data) {
            $('.crud-modal .modal-container').html("");
            $('.crud-modal .modal-container').html(data);
        });
        $('.crud-modal').modal('show');
    });
    $('body').on('click', '.city', function(e) {
        e.preventDefault();
        $.get("{{ url('admin/menucity/') }}/"+$(this).data('id')+"/"+$(this).data('service'), function(data) {
            $('.crud-modal .modal-container').html("");
            $('.crud-modal .modal-container').html(data);
        });
        $('.crud-modal').modal('show');
    });

    table = table.DataTable( {
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": getBaseUrl() + "/admin/menu",
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
               /* data.order_by = $(tableName+' tr').eq(0).find('th').eq(data.order[0]['column']).data('value');
                data.order_direction = data.order[0]['dir'];*/
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
            { "data": "title" },
            
            // { "data": "icon", render: function (data, type, row) {
            //     return "<img src='"+data+"' style='height: 50px'>";
            //     }
            // },
            // { "data": "featured_image", render: function (data, type, row) {
            //     if(data){
            //         return "<img src='"+data+"' style='height: 50px'>";
            //     }else{
            //         return "<h6>NA</h6>"
            //     }
                
            //     }
            // },
            { "data": "admin_service" ,render: function (data, type, row) {
                return row.adminservice.display_name;
                }
            },
            // { "data": "menu_type_id" ,render: function (data, type, row) {
            //     return row.ridetype.ride_name;
            //     }
            // },

            { "data": "id" ,render: function (data, type, row) {
                return " <button data-id='"+data+"' data-service='"+row.adminservice.display_name+"' class='btn btn-block btn-outline-primary city'>Menu City</button>";
                }
            },
            { "data": "id", render: function (data, type, row) {

                
                    var button='<div class="input-group-btn action_group"> <li class="action_icon"> <button type="button"class="btn btn-info btn-block "data-toggle="dropdown"><i class="fa fa-ellipsis-v" aria-hidden="true" title="View"></i></button>'+
                       '<ul class="dropdown-menu">';
                       button +='<li><a href="javascript:;" data-id="'+data+'" class="dropdown-item edit"><i class="fa fa-edit"></i> Edit</a> </li><li><a href="javascript:;" data-id="'+data+'" class="dropdown-item delete"><i class="fa fa-trash"></i>&nbsp;Delete</a> </li>';
                        button +='</ul> </li></div>';
                     return  button;
                
              
            }}

        ],
        responsive: true,
        paging:true,
            info:true,
            lengthChange:false,
            ordering:false,
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
        var url = getBaseUrl() + "/admin/menu/"+id;
        deleteRow(id, url, table);
    });

} );
// $(document).ready(function(){
//     $('#checkAll').prop('checked', false);
//     var selected = new Array();
//     $('body').on('click', 'input[type=checkbox]', function() {
//         $("input[type=checkbox]:checked").each(function () {
//             if(this.value != 'on'){
//                 selected.push(this.value);
//             }
//         });

//         //Display the selected CheckBox values.
//         if (selected.length > 0) {
//             $("#cities").val(selected.join(","));
//         }
//     });
// });
function menuSelectCities(id) {
    var service = $("#service_id").val(id);
    var url = getBaseUrl() + "/admin/service/get-service-price/"+id;
    $.ajax({
        url: url,
        type: "GET",
        async : false,
        headers: {
            Authorization: "Bearer " + getToken("admin")
        },
        success: function(data) {
            var countryCityList ='';
            countryCityList +=  `<a class="list-group-item citylist" href="#" onclick="getData(`+id+`,'ALL','ALL')"><span>All Countries</span></a>`;
                $.each( data.responseData,function(key,value){
                if(key == 0){
                    var countryActiveClass ="active";
                    $('#data-tables').DataTable().search(value.country.country_name).draw(); 
                }else{
                    var countryActiveClass ='';
                }
                countryCityList +=  `<a class="list-group-item  `+ countryActiveClass +` citylist`+value.country.id+`" href="#" onclick="getData(`+id+`,`+value.country.id+`,'`+value.country.country_name+`')" id="`+value.country.id+`"><span>`+value.country.country_name+`</span></a>`;
                
                $.each( value.company_country_cities,function(key1,value1){
                    if(key == 0 && key1 ==0){
                        var cityActiveClass ="active";
                        $("#countryId").val(value.country.id);
                        $("#cityId").val(value1.city.id);
                        $("#serviceId").val(id);
                    }else{
                        var cityActiveClass ='';
                    }
                });
            });
            $('.myprice').empty().append(`<div class="form-group">
                    <div class="select_city nav-wrapper"><div class="list-group">
                        `+countryCityList+`
                    </div>
                    </div>
                </div>
            `);
        }
    });
}
// $("#checkAll").click(function(){
//     $('input:checkbox').not(this).prop('checked', this.checked);
// });
function getData(serviceId,countryId,countryName){
    if(countryName == 'ALL'){
        $("#country_id").val(countryId);
        $('.list-group-item').removeClass("active");
        $('.citylist').addClass("active"); 
        $('#data-tables').DataTable().search('').draw();    
    }else{
        $("#country_id").val(countryId);
        $('.list-group-item').removeClass("active");
        $('.citylist'+countryId).addClass("active");
        $('#data-tables').DataTable().search(countryName).draw();  
    }
}

</script>
@stop

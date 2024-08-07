@extends('common.admin.layout.base')
{{ App::setLocale(  isset($_COOKIE['admin_language']) ? $_COOKIE['admin_language'] : 'en'  ) }}

@section('title') {{ __('Dispatcher Panel') }} @stop

@section('styles')
@parent
    <link rel="stylesheet" href="{{ asset('assets/plugins/data-tables/css/dataTables.bootstrap.min.css')}}"/>
    <link rel="stylesheet" href="{{ asset('assets/plugins/data-tables/css/responsive.bootstrap.min.css')}}">
@stop

@section('content')
<div class="main-content-container container-fluid px-4">
    <div class="page-header row no-gutters py-4">
        <div class="col-12 col-sm-4 text-center text-sm-left mb-0">
            <span class="text-uppercase page-subtitle">{{ __('Dispatcher Panel') }}</span>
            <h3 class="page-title">{{ __('Dispatcher Panel') }}</h3>
        </div>
    </div>
    <div class="row mb-4 mt-20">
    <div class="col-md-12">
        <div class="card card-small">
            <div class="card-header border-bottom">
                <h6 class="m-0">{{ __('Dispatcher Panel') }}</h6>
                <div class="col-md-12">
            <div class="note_txt">
                @if(Helper::getDemomode() == 1)
                <p>** Demo Mode : {{ __('admin.demomode') }}</p>
                <span class="pull-left">(*personal information hidden in demo)</span>
                @endif

            </div>
        </div>
            </div>
            <div class="col-md-12">
                <div class="tabs">
                    <div class="tab-button-outer">
                        <ul id="tab-button">
                            <li class="is-active"><a><i class="fa fa-search"></i> {{ __('Searching') }}</a></li>
                            <li><a><i class="fa fa-user" aria-hidden="true"></i> {{ __('Assigned') }}</a></li>
                            <li><a><i class="fa fa-times" aria-hidden="true"></i> {{ __('Cancelled') }}</a></li>
                            <li><a><i class="fa fa-plus" aria-hidden="true"></i> {{ __('Add') }}</a></li>
                            <li><a><i class="fa fa-plus" aria-hidden="true"></i> {{ __('Add') }}</a></li>
                        </ul>
                    </div>
                    <div class="tab-select-outer">
                        <select id="tab-select">
                            <option value="#tab01"><i class="fa fa-times" aria-hidden="true"></i> {{ __('Searching') }}</option>
                            <option value="#tab02"><i class="fa fa-times" aria-hidden="true"></i> {{ __('Cancelled') }}</option>
                            <option value="#tab03"><i class="fa fa-plus" aria-hidden="true"></i> {{ __('Add') }}</option>
                        </select>
                    </div>
                    <div id="tab01" class="tab-contents row">
                        <div class="col-md-4">
                            <div class="tab_sub_title">
                                <h6 class="m-0">{{ __('Searching List') }}</h6>
                            </div>
                            <div class="tab_body fnt_weight_400">
                                <a href="#" class="btn btn-sm btn-danger">Cancel Ride</a>
                                <a href="#" class="btn btn-sm btn-info float-right">Searching</a>
                                <p class="font_16 txt_clr_2">Karthick M</p>
                                <p class="font_14">From: Simmakkal, Madurai Main, Madurai, Tamil Nadu, India</p>
                                <p class="font_14">To: Mathuthavani Praking Lot, Tiruchirappalli Bus Bay, Madurai, Tamil Nadu, India</p>
                                <p class="font_14">Payment: CASH</p>
                                <div class="progress md-progress">
                                    <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <p class="font_16">Manual Assignment : 2018-11-07 19:18:01</p>
                                <hr>
                                <a href="#" class="btn btn-sm btn-danger">Cancel Ride</a>
                                <a href="#" class="btn btn-sm btn-info float-right">Searching</a>
                                <p class="font_16 txt_clr_2">Karthick M</p>
                                <p class="font_14">From: Simmakkal, Madurai Main, Madurai, Tamil Nadu, India</p>
                                <p class="font_14">To: Mathuthavani Praking Lot, Tiruchirappalli Bus Bay, Madurai, Tamil Nadu, India</p>
                                <p class="font_14">Payment: CASH</p>
                                <div class="progress md-progress">
                                    <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <p class="font_16">Manual Assignment : 2018-11-07 19:18:01</p>
                                <hr>
                                <a href="#" class="btn btn-sm btn-danger">Cancel Ride</a>
                                <a href="#" class="btn btn-sm btn-info float-right">Searching</a>
                                <p class="font_16 txt_clr_2">Karthick M</p>
                                <p class="font_14">From: Simmakkal, Madurai Main, Madurai, Tamil Nadu, India</p>
                                <p class="font_14">To: Mathuthavani Praking Lot, Tiruchirappalli Bus Bay, Madurai, Tamil Nadu, India</p>
                                <p class="font_14">Payment: CASH</p>
                                <div class="progress md-progress">
                                    <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <p class="font_16">Manual Assignment : 2018-11-07 19:18:01</p>
                                <hr>
                                <a href="#" class="btn btn-sm btn-danger">Cancel Ride</a>
                                <a href="#" class="btn btn-sm btn-info float-right">Searching</a>
                                <p class="font_16 txt_clr_2">Karthick M</p>
                                <p class="font_14">From: Simmakkal, Madurai Main, Madurai, Tamil Nadu, India</p>
                                <p class="font_14">To: Mathuthavani Praking Lot, Tiruchirappalli Bus Bay, Madurai, Tamil Nadu, India</p>
                                <p class="font_14">Payment: CASH</p>
                                <div class="progress md-progress">
                                    <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <p class="font_16">Manual Assignment : 2018-11-07 19:18:01</p>
                                <hr>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="tab_sub_title">
                                <h6 class="m-0">{{ __('Map') }}</h6>
                            </div>
                            <div id="world1" class="hght_500"></div>
                        </div>
                    </div>
                    <div id="tab02" class="tab-contents row d-none">
                        <div class="col-md-4">
                            <div class="tab_sub_title">
                                <h6 class="m-0">{{ __('Cancelled List') }}</h6>
                            </div>
                            <div class="tab_body fnt_weight_400">
                                <a href="#" class="btn btn-sm btn-danger float-right">Cancelled</a>
                                <p class="font_16 txt_clr_2">Tess Demo</p>
                                <p class="font_14">From: 10201 Mountair Ave, Tujunga, CA 91042, USA</p>
                                <p class="font_14">To: 11347 Vanowen St, North Hollywood, CA 91605, USA</p>
                                <p class="font_14">Payment: CASH</p>
                                <div class="progress md-progress">
                                    <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <p class="font_16">Cancelled at : 2018-11-08 13:48:04</p>
                                <hr>
                                <a href="#" class="btn btn-sm btn-danger float-right">Cancelled</a>
                                <p class="font_16 txt_clr_2">Tess Demo</p>
                                <p class="font_14">From: 10201 Mountair Ave, Tujunga, CA 91042, USA</p>
                                <p class="font_14">To: 11347 Vanowen St, North Hollywood, CA 91605, USA</p>
                                <p class="font_14">Payment: CASH</p>
                                <div class="progress md-progress">
                                    <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <p class="font_16">Cancelled at : 2018-11-08 13:48:04</p>
                                <hr>
                                <a href="#" class="btn btn-sm btn-danger float-right">Cancelled</a>
                                <p class="font_16 txt_clr_2">Tess Demo</p>
                                <p class="font_14">From: 10201 Mountair Ave, Tujunga, CA 91042, USA</p>
                                <p class="font_14">To: 11347 Vanowen St, North Hollywood, CA 91605, USA</p>
                                <p class="font_14">Payment: CASH</p>
                                <div class="progress md-progress">
                                    <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <p class="font_16">Cancelled at : 2018-11-08 13:48:04</p>
                                <hr>
                                <a href="#" class="btn btn-sm btn-danger float-right">Cancelled</a>
                                <p class="font_16 txt_clr_2">Tess Demo</p>
                                <p class="font_14">From: 10201 Mountair Ave, Tujunga, CA 91042, USA</p>
                                <p class="font_14">To: 11347 Vanowen St, North Hollywood, CA 91605, USA</p>
                                <p class="font_14">Payment: CASH</p>
                                <div class="progress md-progress">
                                    <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <p class="font_16">Cancelled at : 2018-11-08 13:48:04</p>
                                <hr>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="tab_sub_title">
                                <h6 class="m-0">{{ __('Map') }}</h6>
                            </div>
                            <div id="world2" class="hght_500"></div>
                        </div>
                    </div>
                    <div id="tab03" class="tab-contents row d-none">
                        <div class="col-md-4">
                            <div class="tab_sub_title">
                                <h6 class="m-0">{{ __('Ride Details') }}</h6>
                            </div>
                            <form>
                                <div class="form-row mb-3">
                                    <div class="form-group col-md-6">
                                        <label for="feFirstName">First Name</label>
                                        <input type="text" class="form-control" id="feFirstName" placeholder="First Name" value=""> </div>
                                        <div class="form-group col-md-6">
                                            <label for="feLastName">Last Name</label>
                                            <input type="text" class="form-control" id="feLastName" placeholder="Last Name" value=""> </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label for="feEmailAddress">Email</label>
                                                <input type="email" class="form-control" id="feEmailAddress" placeholder="Email" value=""> </div>
                                                <div class="form-group col-md-6">
                                                    <label for="Phone">Phone</label>
                                                    <input type="text" class="form-control" id="fePassword" placeholder="Phone"> </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="feInputAddress">Pickup Address</label>
                                                    <input type="text" class="form-control" id="feInputAddress" placeholder="Pickup Address">
                                                </div>
                                                <div class="form-group">
                                                    <label for="feInputAddress">Dropoff Address</label>
                                                    <input type="text" class="form-control" id="feInputAddress" placeholder="Dropoff Address">
                                                </div>
                                                <div class="form-group">
                                                    <label for="feInputAddress">Schedule Time</label>
                                                    <input type='text' class="form-control" id="datetimepicker1" placeholder="Schedule Time" />
                                                </div>
                                                <div class="form-group">
                                                    <label for="feInputAddress">Service Type</label>
                                                    <select class="form-control">
                                                        <option selected="">Sedan</option>
                                                        <option>Hatchback</option>
                                                        <option>SUV</option>
                                                    </select>
                                                </div>

                                                <div class="form-row">
                                                    <div class="custom-control custom-toggle custom-toggle-sm mb-1">
                                                        <input type="checkbox" id="customToggle2" name="customToggle2" class="custom-control-input" checked="checked">
                                                        <label class="custom-control-label" for="customToggle2">Auto Assign Provider</label>
                                                    </div>
                                                </div>
                                                <br>
                                                <button type="submit" class="btn btn-danger">{{ __('Cancel') }}</button>
                                                <button type="submit" class="btn btn-accent float-right">{{ __('Submit') }}</button>
                                            </form>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="tab_sub_title">
                                                <h6 class="m-0">{{ __('Map') }}</h6>
                                            </div>
                                            <div id="world3" class="hght_500"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
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
<script type="text/javascript" src="{{ asset('asset/js/dispatcher-map-admin.js') }}"></script>
<script src="https://maps.googleapis.com/maps/api/js?key={{Helper::getSettings()->site->browser_key}}&libraries=places&callback=initMap" async defer></script>
<script>
var tableName = '#data-table';
var table = $(tableName);

//showLoader();

$(document).ready(function() {
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

    table = table.DataTable( {
        "processing": true,
        "serverSide": true,
        "pageLength": 10,
        "ajax": {
            "url": getBaseUrl() + "/admin/users",
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
                    return '+'+(data.country_code  ?  data.country_code:'91')+ protect_number(data.mobile);
                }
                else{
                    return '+'+data.country_code?data.country_code:'91'+ data.mobile;
                }
            } },
            { "data": "rating" },
            { "data": "wallet_balance" },
            { "data": "id", render: function (data, type, row) {
                if({{Helper::getDemomode()}} != 1){
                    return "<button data-id='"+data+"' class='btn btn-block btn-success edit'>Edit</button> <button data-id='"+data+"' class='btn btn-block btn-danger delete'>Delete</button>";
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
        var url = getBaseUrl() + "/admin/users/"+id;
        deleteRow(id, url, table);
    });

} );
</script>
@stop

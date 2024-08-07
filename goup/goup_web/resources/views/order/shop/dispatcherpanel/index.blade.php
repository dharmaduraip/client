@extends('order.shop.layout.base')
{{ App::setLocale(   isset($_COOKIE['shop_language']) ? $_COOKIE['shop_language'] : 'en'  ) }}
@section('title') {{ __('Dispatcher Panel') }} @stop

@section('styles')
@parent
    <link rel="stylesheet" href="{{ asset('assets/plugins/data-tables/css/dataTables.bootstrap.min.css')}}"/>
    <link rel="stylesheet" href="{{ asset('assets/plugins/data-tables/css/responsive.bootstrap.min.css')}}">
@stop

@section('content')
<div class="main-content-container container-fluid px-4">
   <!-- Page Header -->
   <div class="page-header row no-gutters py-4">
	  <div class="col-12 col-sm-4 text-center text-sm-left mb-0">
		 <span class="text-uppercase page-subtitle">{{ __('Dashboard') }}</span>
		 <h3 class="page-title">{{ __('Dispatcher') }}</h3>
	  </div>
   </div>
   <!-- TabMenu Start -->
   <div class="row mb-4 mt-20 mt-4">
	  <div class="col-md-12">
		 <div class="card card-small">
			<div class="card-header border-bottom">
			   <h6 class="m-0">{{ __('Request List') }}</h6>
			</div>
			<div class="col-md-12">
				<div id="root"></div>
			</div>
		 </div>
	  </div>
   </div>
  
   <!-- TabMenu End -->
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


<script crossorigin src="https://unpkg.com/babel-standalone@6.26.0/babel.min.js"></script>
<!-- <script crossorigin src="https://unpkg.com/react@16.8.0/umd/react.production.min.js"></script>
<script crossorigin src="https://unpkg.com/react-dom@16.8.0/umd/react-dom.production.min.js"></script> -->

<script crossorigin src="https://unpkg.com/react@16.8.0/umd/react.development.js"></script>
<script crossorigin src="https://unpkg.com/react-dom@16.8.0/umd/react-dom.development.js"></script>



<script  type="text/babel" src="{{ asset('assets/layout/js/shopdispatcher.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/layout/js/dispatcher-map.js') }}"></script>
<script src="https://maps.googleapis.com/maps/api/js?key={{Helper::getSettings()->site->browser_key}}&libraries=places" async defer></script>



<script> 
	var tableName = '#data-table';
	var table = $(tableName);
	window.salt_key = '{{Helper::getSaltKey()}}';
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
				{ "data": "email" },
				{ "data": "mobile" },
				{ "data": "rating" },
				{ "data": "wallet_balance" },
				{ "data": "id", render: function (data, type, row) {
					return "<button data-id='"+data+"' class='btn btn-block btn-success edit'>Edit</button> <button data-id='"+data+"' class='btn btn-block btn-danger delete'>Delete</button>";
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

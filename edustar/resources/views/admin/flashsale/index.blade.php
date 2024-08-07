@extends('admin.layouts.master')
@section('title','All Flash deals')
@section('maincontent')
@component('components.breadcumb',['secondaryactive' => 'active'])
@slot('heading')
   {{ __('All Flash deals') }}
@endslot

@slot('menu1')
   {{ __('Flash deals') }}
@endslot
@slot('button')

<div class="col-md-4 col-lg-4">
    <div class="widgetbar">
        @can('flash-deals.create')
        <a  href=" {{ route('flash-sales.create') }} " class="btn btn-primary-rgba mr-2">
            <i class="feather icon-plus mr-2"></i> {{__("Add new flash deal")}}
        </a>
        @endcan
    </div>                        
</div>
@endslot
@endcomponent

<div class="contentbar">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        {{__("All Flash deals")}}
                    </h3>
                </div>

                <div class="card-body">
                    <table id="flashdeals" class="table table-striped">
                        <thead>
                            <th>
                                #
                            </th>
                            <th>
                                {{__("Deal title")}}
                            </th>
                            <th>
                                {{__("Start date")}}
                            </th>
                            <th>
                                {{__("End date")}}
                            </th>
                            <th>
                                {{__("Banner")}}
                            </th>
                            <th>
                                {{__("Action")}}
                            </th>
                        </thead>

                        <tbody id="sortable">

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@section('script')
<script type="text/javascript">
    $( function() {
      $( "#sortable" ).sortable();
      $( "#sortable" ).disableSelection();
    } );
  
     $("#sortable").sortable({
     update: function (e, u) {
      var data = $(this).sortable('serialize');
    //   $(".sortable").attr("id", )
     console.log("ID is ", data);
      $.ajax({
          url: "{{ route('flash_reposition') }}",
          type: 'get',
          data: data,
          dataType: 'json',
          success: function (result) {
            console.log(data);
          }
      });
  
    }
  
  });
</script>
    <script>
            $(function () {
                "use strict";
                var table = $('#flashdeals').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: @json(route("flash-sales.index")),
                    language: {
                        searchPlaceholder: "Search deals..."
                    },
                        //$(nRow).attr('id', aData[0]);
                    // $(".sortable").attr("id", 'flashsales.id');

                    columns: [
                        {data: 'DT_RowIndex', name: 'flashsales.position', searchable : false},
                        {data : 'title', name : 'flashsales.title'},
                        {data : 'start_date', name : 'flashsales.start_date'},
                        {data : 'end_date', name : 'flashsales.end_date'},
                        {data : 'background_image', name : 'background_image',searchable : false, orderable : false},
                        {data : 'action', name : 'action',searchable : false, orderable : false},
                    ],
                    dom : 'lBfrtip',
                    buttons : [
                        'csv','excel','pdf','print','colvis'
                    ],
                    order : [[0,'DESC']]
                });

                var myInterval = setInterval(getSortableRow, 1000);

                function getSortableRow(){
                    var allTableData = $("#sortable tr");
                    if(allTableData.length > 0){
                        clearInterval(myInterval);
                        allTableData.each(function(){
                            var ID = $(this).children(".sorting_1").html();
                            $(this).attr("id", "id-"+ID);
                            $(this).addClass("sortable");
                        });
                    }
                    
                }

                // var allTableData = $("#sortable tr td");
                // console.log("lll Td are ", allTableData);
                
            });
    </script>
@endsection
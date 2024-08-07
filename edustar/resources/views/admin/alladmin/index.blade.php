@extends('admin.layouts.master')
@section('title','All Admins')
@section('maincontent')
@component('components.breadcumb',['secondaryactive' => 'active'])
@slot('heading')
{{ __('Admins') }}
@endslot

@slot('menu1')
{{ __('Admins') }}
@endslot

@slot('button')

<div class="col-md-4 col-lg-4">
    <div class="widgetbar">
            <a href="{{route('alladmin.add')}}" class="float-right btn btn-primary-rgba mr-2"><i
                class="feather icon-plus mr-2"></i>{{ __('Add Admin') }}</a>    
            </div>
</div>

@endslot
@endcomponent

<div class="contentbar">
    <div class="row">
         <div class="col-lg-12">
            <div class="card m-b-30">
                <div class="card-header">
                    <h5 class="box-title">{{ __('All Admins') }}</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="alladmin" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{{ __('Image') }}</th>
                                    <th>{{ __('Users') }}</th>
                                    <th>{{ __('Login As User') }}</th>
                                    <th>{{ __('Status') }}</th>
                                    <th>{{ __('Action') }}</th>
                                </tr>
                            </thead>
                       <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- End col -->
    </div>
    <!-- End row -->
</div>

@endsection
@section('script')
<!-- script for datatable start -->
<script type="text/javascript">
    $(function () {
      
      var table = $('#alladmin').DataTable({
          processing: true,
          serverSide: true,
          responsive:true,
          searchDelay : 1000,
          stateSave : true,
          ajax: '{{ route('alladmin.index') }}',
          columns: [
              {data: 'DT_RowIndex', name: 'users.id'},
              {data: 'image', name: 'image', orderable: false ,searchable: false},
              {data: 'name' ,name: 'users.fname'},
              {data: 'loginasuser', name: 'loginasuser' , orderable: false, searchable: false},
              {data: 'status', name: 'status', orderable: false ,searchable: false},
              {data: 'action', name: 'action', orderable: false, searchable: false},
          ]
      });
      
    });
</script>
<script>
    $(document).on("change", ".user", function () {
        var checkbox = $(this);
        $.ajax({
            type: "GET",
            dataType: "json",
            url: 'user/status',
            data: {
                'status': $(this).is(':checked') ? 1 : 0,
                'id': $(this).data('id')
            },
            success: function(data)
            {
                if(data.msg == undefined)
                {
                    var warning = new PNotify( {
                        title: 'success', text:'Status Update Successfully', type: 'success', desktop: {
                        desktop: true, icon: 'feather icon-thumbs-down'
                        }
                    });
                    warning.get().click(function() {
                        warning.remove();
                    });
                }
                else
                {
                    alert("You can't change this user status. because, This admin already used in some course.");
                    checkbox.trigger("click");
                }
          }
        });
    })
</script>
<script>
    $("#checkboxAll").on('click', function () {
        $('input.check').not(this).prop('checked', this.checked);
    });
</script>
<!-- script for datatable end -->

@endsection
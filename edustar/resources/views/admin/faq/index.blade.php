@extends('admin.layouts.master')
@section('title', 'All FAQ - Admin')
@section('maincontent')
@component('components.breadcumb',['fourthactive' => 'active'])
@slot('heading')
   {{ __('FAQ Student') }}
@endslot
@slot('menu1')
{{ __('FAQ Student') }}
@endslot
@slot('button')
<div class="col-md-4 col-lg-4">
  <div class="widgetbar">
      @can('faq.faq-student.delete')
  <button type="button" class="float-right btn btn-danger-rgba mr-2 multipledel" data-toggle="modal" data-target="#bulk_delete"><i
            class="feather icon-trash mr-2"></i>{{ __('Delete Selected') }} </button>
            @endcan
            @can('faq.faq-student.create')
    <a href="{{url('faq/create')}}" class="float-right btn btn-primary-rgba mr-2"><i class="feather icon-plus mr-2"></i>{{ __('Add FAQ') }}</a>
  @endcan
  </div>
</div>
@endslot
@endcomponent
<div class="contentbar">
    <div class="row">
@if ($errors->any())  
  <div class="alert alert-danger" role="alert">
  @foreach($errors->all() as $error)     
  <p>{{ $error}}<button type="button" class="close" data-dismiss="alert" aria-label="Close">
  <span aria-hidden="true" style="color:red;">&times;</span></button></p>
      @endforeach  
  </div>
  @endif
  
    <!-- row started -->
    <div class="col-lg-12">
    
        <div class="card m-b-30">
                <!-- Card header will display you the heading -->
                <div class="card-header">
                    <h5 class="card-box">{{ __('FAQ Student') }}</h5>
                </div> 
               
                <!-- card body started -->
                <div class="card-body">
                <div class="table-responsive">
                        <!-- table to display faq start -->
                        <table id="datatable-buttons" class="table table-striped table-bordered">
                        <thead>
                            <th>
                                <input id="checkboxAll" type="checkbox" class="filled-in" name="checked[]"
                                value="all" />
                                <label for="checkboxAll" class="material-checkbox"></label>   # 
                            </th>
                            <th>{{ __('Title') }}</th>
                            <th>{{ __('Detail') }}</th>
                            <th>{{ __('Status') }}</th>
                            <th>{{ __('Action') }}</th>
                        </thead>

                        <tbody id="sortable">
                            @foreach($faq as $key=>$p)
                            <tr class="sortable" id="id-{{ $p->id }}">
                                <td>              
                                    <input type='checkbox' form='bulk_delete_form' class='check filled-in material-checkbox-input'
                                        name='checked[]' value="{{ $p->id }}" id='checkbox{{ $p->id }}'>
                                    <label for='checkbox{{ $p->id }}' class='material-checkbox'></label>
                                    <?php echo $key+1; ?>
                                <div id="bulk_delete" class="delete-modal modal fade" role="dialog">
                                    <div class="modal-dialog modal-sm">
                                        <!-- Modal content-->
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                <div class="delete-icon"></div>
                                            </div>
                                            <div class="modal-body text-center">
                                                <h4 class="modal-heading">{{ __('Are You Sure') }} ?</h4>
                                                <p>{{ __('Do you really want to delete selected item ? This process
                                                    cannot be undone') }}.</p>
                                            </div>
                                            <div class="modal-footer">
                                                <form id="bulk_delete_form" method="post"
                                                    action="{{ route('faq.bulk.delete') }}">
                                                    @csrf
                                                    @method('POST')
                                                    <button type="reset" class="btn btn-gray translate-y-3"
                                                        data-dismiss="modal">{{ __('No') }}</button>
                                                    <button type="submit" class="btn btn-danger">{{ __('Yes') }}</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                </td>
                                <td>{{$p->title}}</td>      
                                <td>{{ str_limit(strip_tags($p->details), $limit = 50, $end = '...')}}</td>
                                <td>
                                    <label class="switch">
                                        <input class="faq" type="checkbox"  data-id="{{$p->id}}" name="status" {{ $p->status == '1' ? 'checked' : '' }}>
                                        <span class="knob"></span>
                                      </label>
                                </td>

                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-round btn-outline-primary" type="button" id="CustomdropdownMenuButton1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="feather icon-more-vertical-"></i></button>
                                        <div class="dropdown-menu" aria-labelledby="CustomdropdownMenuButton1">
                                            @can('faq.faq-student.edit')
                                            <a class="dropdown-item" href="{{url('faq/'.$p->id.'/edit')}}"><i class="feather icon-edit mr-2"></i>{{ __('Edit') }}</a>
                                            @endcan
                                            @can('faq.faq-student.delete')
                                            <a class="dropdown-item btn btn-link" data-toggle="modal" data-target="#delete{{ $p->id }}" >
                                                <i class="feather icon-delete mr-2"></i>{{ __("Delete") }}</a>
                                            </a>
                                            @endcan
                                        </div>
                                    </div>

                                    <!-- delete Modal start -->
                                    <div class="modal fade bd-example-modal-sm" id="delete{{ $p->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                                        <div class="modal-dialog modal-sm">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleSmallModalLabel">{{ __('Delete') }}</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                        <h4>{{ __('Are You Sure ?')}}</h4>
                                                        <p>{{ __('Do you really want to delete')}} <b>{{$p->title}}</b> ? {{ __('This process cannot be undone.')}}</p>
                                                </div>
                                                <div class="modal-footer">
                                                    <form method="post" action="{{url('faq/'.$p->id)}}" class="pull-right">
                                                        {{csrf_field()}}
                                                        {{method_field("DELETE")}}
                                                        <button type="reset" class="btn btn-secondary" data-dismiss="modal">{{ __('No') }}</button>
                                                        <button type="submit" class="btn btn-primary">{{ __('Yes') }}</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- delete Model ended -->

                                </td>
                                
                            </tr> 
                            @endforeach 
                        </tbody>
                        </table>                  
                        <!-- table to display faq data end -->                
                    </div><!-- table-responsive div end -->
                </div><!-- card body end -->
            
        </div><!-- col end -->
    </div>
</div>
</div><!-- row end -->
    <br><br>
@endsection
<!-- main content section ended -->
<!-- This section will contain javacsript start -->
@section('script')
<script type="text/javascript">
    $( function() {
      $( "#sortable" ).sortable();
      $( "#sortable" ).disableSelection();
    } );
  
     $("#sortable").sortable({
     update: function (e, u) {
      var data = $(this).sortable('serialize');
     
      $.ajax({
          url: "{{ route('faq_reposition') }}",
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
<!-- script to change status start -->
<script>

        $(document).on("change",".faq",function() { 
            $.ajax({
            type: "GET",
            dataType: "json",
            url: 'faq-status',
            data: {'status': $(this).is(':checked') ? 1 : 0, 'id': $(this).data('id')},
            success: function(data){
            var warning = new PNotify( {
                title: 'success', text:'Status Update Successfully', type: 'success', desktop: {
                desktop: true, icon: 'feather icon-thumbs-down'
                }
              });
              warning.get().click(function() {
                warning.remove();
              });
          }
        });
    
  });
</script>
<!-- script to change status end -->
<script>
$("#checkboxAll").on('click', function () {
    $('input.check').not(this).prop('checked', this.checked);
});
$(".multipledel").click(function(){
     
     var count = $('[name="checked[]"]:checked').length;
     if(count == "0")
     {
         alert("Atleast One Faq Student is required to be selected");
         return false;
     }
     
 });
</script>
@endsection
<!-- This section will contain javacsript end -->
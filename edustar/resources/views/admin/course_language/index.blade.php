@extends('admin.layouts.master')
@section('title','All Course Language')
@section('maincontent')
@component('components.breadcumb',['secondaryactive' => 'active'])
@slot('heading')
   {{ __('Course Languages') }}
@endslot

@slot('menu1')
   {{ __('Course Languages') }}
@endslot

@slot('button')

<div class="col-md-4 col-lg-4">
    <div class="widgetbar">
      @can('course-languages.delete')
      <a href="page-product-detail.html" class="btn btn-danger-rgba multipledel"  data-toggle="modal" data-target=".bd-example-modal-sm1"><i class="feather icon-trash mr-2"></i>{{__('Delete Selected')}}</a>
@endcan
        <div class="modal fade bd-example-modal-sm1" tabindex="-1" role="dialog" aria-hidden="true">
          <div class="modal-dialog modal-sm">
              <div class="modal-content">
                  <div class="modal-header">
                      <h5  class="modal-title">{{__('Delete')}}</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                      </button>
                  </div>
                  <div class="modal-body text-center">
                      <p class="text-muted">{{ __("Do you really want to delete these records? This process cannot be undone.")}}</p>
                  </div>
                  <div class="modal-footer">
                    
                    
                      <form method="post" action="{{ action('CourseLanguageController@bulk_delete') }}
                      " id="bulk_delete_form" data-parsley-validate class="form-horizontal form-label-left">
                      {{ csrf_field() }}
                    
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __("No")}}</button>
                      <button type="submit" class="btn btn-danger">{{ __("Yes")}}</button>
                   </form>
                  </div>
              </div>
          </div>
      </div>
@can('course-languages.create')
        <a data-toggle="modal" data-target="#myModaljjh" href="#" class="btn btn-primary-rgba mr-2" ><i class="feather icon-plus mr-2"></i>{{ __('Add Language') }}</a>
     @endcan
        
    </div>                        
</div>

@endslot
@endcomponent
<div class="contentbar"> 
  <div class="row">
      
      <div class="col-lg-12">
          <div class="card m-b-30">
              <div class="card-header">
                  <h5 class="card-box">{{__('All Course languages')}}</h5>
              </div>
              <div class="card-body">
              
                  <div class="table-responsive">
                      <table id="datatable" class="table table-striped table-bordered">
                          <thead>
                          <tr>
                            <th><input id="checkboxAll" type="checkbox" class="filled-in" name="checked[]" value="all" />
                          <label for="checkboxAll" class="material-checkbox"></label> #</th>
                            <th>{{ __('Language') }}</th>
                            <th>{{ __('Status') }}</th>
                            @if(Auth::user()->role == "admin")
                            <th>{{ __('Action') }}</th>
                            @endif
                           
                          </tr>
                          </thead>
          
                          <tbody>
                            <?php $i=0;?>
                            @foreach($language as $cat)
                              <?php $i++;?>
                              <tr>
                                <td>  <input type='checkbox' form='bulk_delete_form' class='check filled-in material-checkbox-input'
                                  name='checked[]' value='{{ $cat->id }}' id='checkbox{{ $cat->id }}'>
                              <label for='checkbox{{ $cat->id }}' class='material-checkbox'></label>
                              <?php echo $i; ?>
                              </td>
                                <td>{{$cat->name}}</td>
                                <td>
                                  <label class="switch">
                                    <input class="courselanguage" type="checkbox"  data-id="{{$cat->id}}" name="status"     {{ $cat->status ==1 ? 'checked' : ''}}>
                                    <span class="knob"></span>
                                  </label>
                                  </td>

                                  
                                <td>
                                  @if(Auth::user()->role == "admin")
                                  <div class="dropdown">
                                    <button class="btn btn-round btn-outline-primary" type="button" id="CustomdropdownMenuButton1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="feather icon-more-vertical-"></i></button>
                                    <div class="dropdown-menu" aria-labelledby="CustomdropdownMenuButton1">
                                      @can('courses-language.edit')
                                     
                                        <a class="dropdown-item"data-toggle="modal" data-target="#edit{{ $cat->id}}"><i class="feather icon-edit mr-2"></i>Edit</a>
                                        @endcan
                                        @can('courses-language.delete')
                                        <a class="dropdown-item btn btn-link" data-toggle="modal" data-target="#delete{{ $cat->id}}" >
                                            <i class="feather icon-delete mr-2"></i>{{ __("Delete") }}</a>
                                        </a>
                                        @endcan
                                       
                                    </div>
                                </div>
                                <div class="modal fade bd-example-modal-sm" id="edit{{$cat->id}}" tabindex="-1" role="dialog" aria-hidden="true">
                                  <div class="modal-dialog">
                                      <div class="modal-content">
                                          <div class="modal-header">
                                              <h5 class="modal-title" id="exampleSmallModalLabel">Edit CourseLanguage</h5>
                                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                              <span aria-hidden="true">&times;</span>
                                              </button>
                                          </div>
                                          <div class="modal-body">
                                            <form id="demo-form" method="post" action="{{url('courselang/'.$cat->id)}}
                                              "data-parsley-validate class="form-horizontal form-label-left">
                                          {{ csrf_field() }}
                                          {{ method_field('PUT') }}
                                          
                                            <div class="col-md-12">
                                              <div class="form-group">
                                                <label for="exampleInputSlug">{{ __('Name') }}: <sup class="redstar">*</sup></label>
                                                <input type="text" class="form-control" name="name" value="{{ $cat->name }}" id="exampleInputPassword1" placeholder="{{ __('Please') }}  {{ __('Enter') }} {{ __('Language') }}">
                                              </div>
                                             
                                            </div>
                                            {{-- <div class="col-md-6">
                                              <div class="form-group">
                                                <label for="exampleInputTit1e">{{ __('Status') }}:</label>
                                                <input type="checkbox" class="custom_toggle" name="status"
                                                {{ $cat->status==1 ? 'checked' : '' }}/>
                                  
                                              </div>
                                            </div> --}}
                                  
                                          <div class="col-md-6">
                                            <div class="form-group">
                                              {{-- <button type="reset" class="btn btn-danger"><i class="fa fa-ban"></i>
                                                {{__('Reset')}}</button> --}}
                                              <button type="submit" class="btn btn-primary"><i class="fa fa-check-circle"></i>
                                                {{__('Update')}}</button>
                                            </div>
                                  
                                            <div class="clear-both"></div>
                                          </div>
                                            </form>
                                          </div>
                                          
                                      </div>
                                  </div>
                              </div> 
                                <!-- delete Modal start -->
                                <div class="modal fade bd-example-modal-sm" id="delete{{$cat->id}}" tabindex="-1" role="dialog" aria-hidden="true">
                                    <div class="modal-dialog modal-sm">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleSmallModalLabel">{{__('Delete')}}</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                    <h4>{{ __('Are You Sure ?')}}</h4>
                                                    <p>{{ __('Do you really want to delete')}} ? {{ __('This process cannot be undone.')}}</p>
                                            </div>
                                            <div class="modal-footer">
                                                <form method="post" action="{{url('courselang/'.$cat->id)}}" class="pull-right">
                                                    {{csrf_field()}}
                                                    {{method_field("DELETE")}}
                                                    <button type="reset" class="btn btn-secondary" data-dismiss="modal">{{__('No')}}</button>
                                                    <button type="submit" class="btn btn-danger">{{__('Yes')}}</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div> 
                                @endif
                                </td>       
                              
          
                               
                              </tr>
                            @endforeach
                          </tbody>
                        </table>
                      </div>
                  </div>
              </div>
          </div>
          <!-- End col -->
      </div>
  <!-- End row -->
  </div>



  <!--Model for add city -->
<div class="modal fade" id="myModaljjh"  tabindex="-1" role="dialog" aria-labelledby="exampleStandardModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleStandardModalLabel">{{__('Add Language')}}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="demo-form2" method="post" action="{{ route('courselang.store') }}" data-parsley-validate class="form-horizontal form-label-left">
          {{ csrf_field() }}
                  
  
          <div class="row">
            <div class="col-md-12">
              <label for="exampleInputSlug">{{ __('Name') }}:<sup class="redstar">*</sup></label>
              <input type="text" class="form-control" name="name" id="exampleInputPassword1" placeholder="{{ __('Please') }} {{ __('Enter') }} {{ __('Language') }}" value="">
            </div>
            <br>
            <div class="col-md-12 mt-3">
              <label for="exampleInputDetails">{{ __('Status') }}:</label>
              <input  class="custom_toggle" id="welmail" type="checkbox" name="status"  checked />

                
              
            </div>
          
          <br>
          <div class="form-group col-md-12 mt-3">
            {{-- <button type="reset" class="btn btn-danger-rgba"><i class="fa fa-ban"></i> {{__('Reset')}}</button> --}}
            <button type="submit" class="btn btn-primary-rgba"><i class="fa fa-check-circle"></i>
                {{__('Create')}}</button>
        </div>
              </div>
            </form>
          </div>
           
        </div>
      </div>
    </div>
@endsection
@section('script')
<script>

      $(document).on("change",".courselanguage",function() { 
        var checkbox = $(this);
        $.ajax({
            type: "GET",
            dataType: "json",
            url: 'courselanguage/status',
            data:   {'status': $(this).is(':checked') ? 1 : 0, 'id': $(this).data('id')},
            success: function(data){
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
                  alert("You can't change this status. because, This language is already used in some course.");
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
$(".multipledel").click(function(){
     
     var count = $('[name="checked[]"]:checked').length;
     if(count == "0")
     {
         alert("Atleast One Course Language is required to be selected");
         return false;
     }
     
 });
</script>
@endsection

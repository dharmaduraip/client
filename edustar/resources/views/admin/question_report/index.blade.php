@extends('admin.layouts.master')
@section('title', 'Reported Question - Admin')
@section('maincontent')
 

@component('components.breadcumb',['thirdactive' => 'active'])
@slot('heading')
   {{ __('Reported Questions') }}
@endslot
@slot('menu1')
   {{ __('Report') }}
@endslot
@slot('menu2')
   {{ __('Reported Questions') }}
@endslot
@slot('button')
<div class="col-md-4 col-lg-4">
  <div class="widgetbar">
    @can('reported-question.delete')
      <a href="page-product-detail.html" class="btn btn-danger-rgba multipledel"  data-toggle="modal" data-target=".bd-example-modal-sm1"><i class="feather icon-trash mr-2"></i>{{ __('Delete Selected') }}</a>
      @endcan                          
      <div class="modal fade bd-example-modal-sm1" tabindex="-1" role="dialog" aria-hidden="true">
          <div class="modal-dialog modal-sm">
              <div class="modal-content">
                  <div class="modal-header">
                      <h5 class="modal-title" id="exampleSmallModalLabel">{{ __('Delete') }}</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                      </button>
                  </div>
                  <div class="modal-body text-center">
                      <p class="text-muted">{{ __("Do you really want to delete these records? This process cannot be undone.")}}</p>
                  </div>
                  <div class="modal-footer">
                    <form method="post" action="{{ action('BulkdeleteController@reportedquestiondeleteAll') }}
                    " id="bulk_delete_form" data-parsley-validate class="form-horizontal form-label-left">
                    {{ csrf_field() }}

                    
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __("Close")}}</button>
                      <button type="submit" class="btn btn-primary">{{ __("Delete")}}</button>
                  </form>
                  </div>
              </div>
          </div>
      </div>
  </div>                        
</div>
@endslot


@endcomponent

  <div class="contentbar">                
    <!-- Start row -->
    <div class="row">
    
        <div class="col-lg-12">
            <div class="card m-b-30">
                <div class="card-header">
                    <h5 class="box-title">{{ __('Reported Questions') }} </h5>
                </div>
                <div class="card-body">
                 
                    <div class="table-responsive">
                        <table id="datatable-buttons" class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th> <input id="checkboxAll" type="checkbox" class="filled-in" name="checked[]" value="all" id="checkboxAll">
                                    <label for="checkboxAll" class="material-checkbox"></label>
                                    #</th>
                                <th>{{ __('User') }}</th>
                              
                                <th>{{ __('Question') }}</th>
                                <th>{{ __('Title') }}</th>
                                <th>{{ __('Email') }}</th>
                                <th>{{ __('Detail') }}</th>
                                <th>{{ __('Course') }}</th>
                                <th>{{ __('Action') }}</th>

                               
                            </tr>
                            </thead>
                            <tbody>
                                <?php $i=0;?>
                                @foreach($items as $item)
                                  <?php $i++;?>
                                  <tr>
                                  
                                  
                                    <td> <input type="checkbox" form="bulk_delete_form" class="filled-in material-checkbox-input" name="checked[]" value="{{$item->id}}" id="checkbox{{$item->id}}">
                                        <label for="checkbox{{$item->id}}" class="material-checkbox"></label> 
                                        <?php echo $i;?></td>
                                    <td>{{$item->user['fname']}}</td>
                                    
                                    <td>{{$item->question['question']}}</td>
                                    <td>{{$item->title}}</td>
                                    <td>{{$item->email}}</td>

                                    <td>{{  strip_tags(str_limit($item->detail, $limit=50, $end="..."))}}</td>
                                    <td>{{$item->courses['title']}}</td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-round btn-primary-rgba" type="button" id="CustomdropdownMenuButton3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="feather icon-more-vertical-"></i></button>
                                            <div class="dropdown-menu" aria-labelledby="CustomdropdownMenuButton3">
                                                <a class="dropdown-item"   href="{{url('user/question/report/'.$item->id)}}"><i class="feather icon-edit mr-2"></i>{{ __("Edit")}}</a>
                                                <a class="dropdown-item" data-toggle="modal" data-target=".bd-example-modal-sm"><i class="feather icon-delete mr-2"></i>{{ __("Delete")}}</a>
                                              
                                            </div>
                                        </div>
                                      </td>
                                   
                                   
                                       
                                        <div class="modal fade bd-example-modal-sm" tabindex="-1" role="dialog" aria-hidden="true">
                                            <div class="modal-dialog modal-sm">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleSmallModalLabel">{{ __('Delete') }}</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p class="text-muted">{{ __("Do you really want to delete these records? This process cannot be undone.")}}</p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <form  method="post" action="{{url('user/question/report',$item->id)}}"
                                                           >
                                                            {{ csrf_field() }}
                                                            {{ method_field('DELETE') }}
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __("Close")}}</button>
                                                        <button type="submit" class="btn btn-primary">{{ __("Delete")}}</button>
                                                    </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                   
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

@endsection


@section('scripts')
<script>
$(".multipledel").click(function(){
     
     var count = $('[name="checked[]"]:checked').length;
     if(count == "0")
     {
         alert("Atleast One Reported Question is required to be selected");
         return false;
     }
     
 });
</script>
@endsection



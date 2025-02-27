@extends('admin.layouts.master')
@section('title', 'All Meetings - Admin')
@section('maincontent')
 

@component('components.breadcumb',['fourthactive' => 'active'])
@slot('heading')
   {{ __('All Meetings') }}
@endslot
@slot('menu1')
   {{ __('Meetings') }}
@endslot
@slot('menu2')
   {{ __('Zoom Live Meetings') }}
@endslot

@slot('menu3')
   {{ __('All Meetings') }}
@endslot
@slot('button')
<div class="col-md-4 col-lg-4">
  <div class="widgetbar">
<a href="page-product-detail.html" class="btn btn-danger-rgba"  data-toggle="modal" data-target=".bd-example-modal-sm1"><i class="feather icon-trash mr-2"></i>Delete Selected</a>
                                
<div class="modal fade bd-example-modal-sm1" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleSmallModalLabel">Delete</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
                <p class="text-muted">{{ __("Do you really want to delete these records? This process cannot be undone.")}}</p>
            </div>
            <div class="modal-footer">
              <form method="post" action="{{ action('BulkdeleteController@ZoommeetingdeleteAll') }}
                      " id="bulk_delete_form" data-parsley-validate class="form-horizontal form-label-left">
                      {{ csrf_field() }}

              
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __("No")}}</button>
                <button type="submit" class="btn btn-primary">{{ __("Yes")}}</button>
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
                    <h5 class="box-title">{{ __('All Meetings')}}</h5>
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
                              <th>{{ __('Meeting') }}</th>
                              <th>{{ __('Url') }}</th>
                              <th>{{ __('Delete') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                              <?php $i=0;?>
              @foreach($meetings as $meeting)
              <?php $i++;?>
              <tr>
                <td> <input type="checkbox" form="bulk_delete_form" class="filled-in material-checkbox-input" name="checked[]" value="{{$meeting->id}}" id="checkbox{{$meeting->id}}">
                  <label for="checkbox{{$meeting->id}}" class="material-checkbox"></label>
                  <?php echo $i;?>
                  
                  </td>
              
                <td>{{$meeting->user['fname']}}</td>

                <td>
                  <p><b>{{ __('adminstaticword.MeetingID') }}:</b> {{ $meeting['meeting_id'] }}</p>
                  <p><b>{{ __('adminstaticword.OwnerID') }}:</b> {{ $meeting['owner_id'] }}</p>
                  <p><b>{{ __('adminstaticword.MeetingTopic') }}:</b> {{ $meeting['meeting_title'] }}</p>
                  <p><b>{{ __('adminstaticword.StartTime') }}:</b> {{ date('d-m-Y | h:i:s A',strtotime($meeting['start_time'])) }}</p>

                  @if(isset($meeting->course_id))

                  <p><b>{{ __('adminstaticword.Meetingoncourse') }}:</b> {{ $meeting->courses['title'] }}</p>

                  @endif

                </td>
                
                <td>
                  <a href="{{ $meeting->zoom_url }}" target="_blank" class="btn btn-primary-rgba">{{ __('adminstaticword.JoinMeeting') }}</a>
                </td>
                    <td>
                      <a href="page-product-detail.html" class="btn btn-danger-rgba"  data-toggle="modal" data-target=".bd-example-modal-sm"><i class="feather icon-trash"></i></a>
                      
                      <div class="modal fade bd-example-modal-sm" tabindex="-1" role="dialog" aria-hidden="true">
                          <div class="modal-dialog modal-sm">
                              <div class="modal-content">
                                  <div class="modal-header">
                                      <h5 class="modal-title" id="exampleSmallModalLabel">Delete</h5>
                                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                      <span aria-hidden="true">&times;</span>
                                      </button>
                                  </div>
                                  <div class="modal-body">
                                      <p class="text-muted">{{ __("Do you really want to delete these records? This process cannot be undone.")}}</p>
                                  </div>
                                  <div class="modal-footer">
                                    <form  method="post" action="{{ route('zoom.destroy',$meeting->id) }}
                                      "data-parsley-validate class="form-horizontal form-label-left">
                                      {{ csrf_field() }}
                                      {{ method_field('DELETE') }}
                                      <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __("Close")}}</button>
                                      <button type="submit" class="btn btn-primary">{{ __("Delete")}}</button>
                                  </form>
                                  </div>
                              </div>
                          </div>
                      </div>
                  </td>
    
                               
                              
                
                               
                              
                                @endforeach
                              </tr>
                              
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

@extends('admin.layouts.master')
@section('title', 'Involve Request - Instructor')
@section('maincontent')
 

@component('components.breadcumb',['thirdactive' => 'active'])
@slot('heading')
   {{ __('Involve Request ') }}
@endslot
@slot('menu1')
   {{ __('Instructor') }}
@endslot
@slot('menu2')
   {{ __('Multiple Instructor') }}
@endslot
@slot('menu2')
   {{ __('Involve Request ') }}
@endslot


@endcomponent


  <div class="contentbar">                
    <!-- Start row -->
    <div class="row">
    
        <div class="col-lg-12">
            <div class="card m-b-30">
                <div class="card-header">
                    <h5 class="box-title">{{ __('Involvement Courses')}}</h5>
                </div>
                <div class="card-body">
                 
                    <div class="table-responsive">
                        <table id="datatable-buttons" class="table table-striped table-bordered">
                            <thead>
                            <tr>
                              <th>#</th>
                              <th>{{ __('Image') }}</th>
                              <th>{{ __('User Name') }}</th>
                              <th>{{ __('Email') }}</th>
                              <th>{{ __('Title') }}</th>
                              <th>{{ __('Reason') }}</th>
                              <th>{{ __('Status') }}</th>
                              <th>{{ __('Accept') }}</th>
                              <th>{{ __('Reject') }}</th>
                           
                            </tr>
                            </thead>
                            <tbody>
                              <?php $i=0;?>
                              @foreach($involve_requests as $item)
                              @if(isset($item->course->user))
                              @if(Auth::user()->id == $item->course->user->id)     
                              <?php $i++;?>
                              <tr>
                                  <td>@php echo $i; @endphp</td>
                                  <td>
                                    @if($item->user->user_img != null || $item->user->user_img !='')
                                      <img src="{{ asset('images/user_img/'.$item->user->user_img)}}" class="img-circle">
                                    @else
                                      <img src="{{ asset('images/default/user.jpg')}}" class="img-responsive img-circle" alt="User Image">
                                    @endif
                                  </td> 
                                  <td>{{$item->user->fname}}</td>
                                  <td>{{$item->user->email}}</td>
                                  <td>{{ $item->course->title}}</td>
                                  <td>{{ $item->reason }}</td>
                                  <td>
                                    <label class="switch">
                                      <input class="involverequest" type="checkbox"  data-id="{{$item->id}}" name="status" {{ $item->status == '1' ? 'checked' : '' }}>
                                      <span class="knob"></span>
                                    </label>
                                  </td>
                                  
                                  <td>
                                    @if($item->status == 0)
                                      <form  method="post" action="{{route('involve.request.edit',$item->id)}}
                                          "data-parsley-validate class="form-horizontal form-label-left">
                                          {{ csrf_field() }}
                                        
                                           <button type="submit" class="btn btn-info">{{ __('Accept') }}</i></button>
                                      </form>
                                    @else
                                       <b class="text-green">{{__('Accepted By Instructor')}} {{$item->course->user->fname}}</b>
                                    @endif
                                  </td>
                                 
                                  <td><form  method="post" action="{{route('involve.request.destroy',$item->id)}}
                                        "data-parsley-validate class="form-horizontal form-label-left">
                                        {{ csrf_field() }}
                                        {{ method_field('DELETE') }}
                                         <button type="submit" class="btn btn-danger">{{ __('Reject') }}</i></button>
                                      </form>
                                  </td>
              
                                
                              </tr>
                              @endif
                              @endif
                              @endforeach
              
                             
                             
                            </tfoot>
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
    "use Strict";

$.ajaxSetup({
  headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  }
});

  $(function() {
    $('.involverequest').change(function() {
        var status = $(this).prop('checked') == true ? 1 : 0; 
        
        var id = $(this).data('id'); 
        
        
        $.ajax({
            type: "POST",
            dataType: "json",
            url: "{{url('quickupdate/involvementrequest')}}",
            data: {'status': status, 'id': id},
            success: function(data){
              console.log(data)
            }
        });
    })
  })
</script>


@endsection
              
                       
                                    
 
@extends('admin.layouts.master')
@section('title', 'All Courses - Admin')
@section('maincontent')
@component('components.breadcumb',['fourthactive' => 'active'])
@slot('heading')
   {{ __('Users Enrolled') }}
@endslot
@slot('menu1')
{{ __('Users Enrolled') }}
@endslot
@slot('button')

<div class="col-md-4 col-lg-4">
    <div class="widgetbar">
        <a href=" {{ route('attandance.index') }} " class="btn btn-primary-rgba mr-2">
            <i class="feather icon-arrow-left mr-2"></i> {{__("Back")}}
        </a>
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
                    <h5 class="card-box">{{ __('Users Enrolled') }}</h5>
                </div> 
               
                <!-- card body started -->
                <div class="card-body">
                <div class="table-responsive">
                        <!-- table to display faq start -->
                        <table id="datatable-buttons" class="table table-striped table-bordered">
                        <thead>
                        <th>#</th>
                        <th>{{ __('Users') }}</th>
                        <th>{{ __('Attendance') }}</th>
                        </thead>
​
                        <tbody>
                            <?php $i=0;?>
                            @foreach($enrolled as $enroll)
                            <?php $i++;?>
                              <tr>
                                <td><?php echo $i;?></td>
                                <td>
                                  <p><b>{{ __('User') }}:</b> {{ $enroll->user->fname }} {{ $enroll->user->lname }}</p>
                                  <p><b>{{ __('Email') }}:</b> {{ $enroll->user->email }} </p>
                                </td>
                                <td>
                                  <a href="{{ route('user.attandance', ['id' => $enroll->user_id, 'course' => $enroll->course_id]) }}" class="btn btn-primary">{{ __('Attendance') }}</a>
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

@endsection
<!-- This section will contain javacsript end -->
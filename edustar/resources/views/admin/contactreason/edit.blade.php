@extends('admin.layouts.master')
@section('title', 'Edit Contact-reason - Admin')
@section('maincontent')
@component('components.breadcumb',['fourthactive' => 'active'])
@slot('heading')
   {{ __('Edit Contact-reason') }}
@endslot
@slot('menu1')
{{ __('Edit Contact-reason') }}
@endslot
@slot('button')
<div class="col-md-4 col-lg-4">
  <div class="widgetbar">
  <a href="{{url('contactreason')}}" class="btn btn-primary-rgba"><i class="feather icon-arrow-left mr-2"></i>{{ __("Back")}}</a>
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
                    <h5 class="card-box">{{ __('Edit Contact-reason') }}</h5>
                </div> 
               
                <!-- card body started -->
                <div class="card-body">

                <!-- form start -->
                <form action="{{url('contactreason/'.$find->id)}}" class="form" method="POST" novalidate enctype="multipart/form-data">
                  {{ csrf_field() }}
                  {{method_field('PATCH')}}
                        <!-- row start -->
                        <div class="row">
                            <div class="col-md-12">
                                <!-- card start -->
                                <div class="card">
                                    <!-- card body start -->
                                    <div class="card-body">
                                        <!-- row start -->
                                          <div class="row">
                                              
                                              <div class="col-md-12">
                                                  <!-- row start -->
                                                  <div class="row">
                                                    
                                                    <!-- Title -->
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="text-dark">{{ __('Reason') }} <span class="text-danger">*</span></label>
                                                            <input type="text" value="{{$find->reason}}" autofocus="" class="form-control @error('reason') is-invalid @enderror" placeholder="{{ __('Please Enter the reason to contact us') }}" name="reason" required="">
                                                            @error('reason')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                    </div>


                                                    <!-- Status -->
                                                    <div class="form-group col-md-2">
                                                        <label for="exampleInputDetails">{{ __('Status') }} :</label><br>
                                                        <input type="checkbox" class="custom_toggle" name="status" {{ $find->status == '1' ? 'checked' : '' }} />
                                                        <input type="hidden"  name="free" value="0" for="status" id="status">
                                                    </div>
                                                                  
                                                    <!-- create and close button -->
                                                    <div class="col-md-12">
                                                        <button type="reset" class="btn btn-danger-rgba mr-1"><i class="fa fa-ban"></i> {{ __("Reset")}}</button>
                                                        <button type="submit" class="btn btn-primary-rgba"><i class="fa fa-check-circle"></i>
                                                            {{ __("Update")}}</button>
                                                    </div>

                                                  </div><!-- row end -->
                                              </div><!-- col end -->
                                          </div><!-- row end -->

                                    </div><!-- card body end -->
                                </div><!-- card end -->
                            </div><!-- col end -->
                        </div><!-- row end -->
                  </form>
                  <!-- form end -->
                  
                
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
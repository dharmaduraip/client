@extends('admin.layouts.master')
@section('title', 'Terms & Condition - Admin')
@section('maincontent')
@component('components.breadcumb',['fourthactive' => 'active'])
@slot('heading')
   {{ __('Terms & Condition') }}
@endslot
@slot('menu1')
{{ __('Terms & Condition') }}
@endslot
@endcomponent
<div class="contentbar">
    <div class="row">

  
    <!-- row started -->
    <div class="col-lg-12">
        @if ($errors->any())  
        <div class="alert alert-danger" role="alert">
        @foreach($errors->all() as $error)     
        <p>{{ $error}}<button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true" style="color:red;">&times;</span></button></p>
            @endforeach  
        </div>
        @endif
        <div class="card m-b-30">
                <!-- Card header will display you the heading -->
                <div class="card-header">
                    <h5 class="card-box">{{ __('Terms & Condition') }}</h5>
                </div> 
               
                <!-- card body started -->
                <div class="card-body">
                <!-- form start -->
                <form action="{{ action('TermsController@update') }}" class="form" method="POST" novalidate enctype="multipart/form-data">
                      {{ csrf_field() }}
                      {{ method_field('PUT') }}
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
                                                   
                                                    <!-- Terms&Condition -->
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label class="text-dark">{{ __('Terms&Condition') }} : <span class="text-danger">*</span></label>
                                                            <textarea id="detail" name="terms" required="">{{ optional($items)->terms }}</textarea>
                                                        </div>
                                                    </div>
                                                                  
                                                    <!-- create and close button -->
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <button type="reset" class="btn btn-danger-rgba mr-1"><i class="fa fa-ban"></i> {{ __("Reset")}}</button>
                                                            <button type="submit" class="btn btn-primary-rgba"><i class="fa fa-check-circle"></i>
                                                            {{ __("Update")}}</button>
                                                        </div>
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
                </div>
                <!-- card body end -->
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
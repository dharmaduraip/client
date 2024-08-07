@extends('admin.layouts.master')
@section("title", "Africa's Talking Settings - Admin")
@section('maincontent')
@component('components.breadcumb',['fourthactive' => 'active'])
@slot('heading')
   {{ __("Africa's Talking SMS Channel Settings") }}
@endslot
@slot('menu1')
{{ __("Africa's Talking Settings") }}
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
                    <h5 class="card-box">{{ __("Africa's Talking SMS Channel Settings") }}</h5>
                </div> 
               
                <!-- card body started -->
                <div class="card-body">
               <!-- form start -->
               <form action="{{ route('africas.talking.update') }}" class="form" method="POST" novalidate enctype="multipart/form-data">
                        @csrf
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
                                                    
                                                    <!-- AFRICAS TALKING USERNAME -->
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="text-dark">{{ __('Username :') }}<span class="text-danger">*</span></label>
                                                            <input name="africas_talking_username" type="text" value="{{ env('AFRICAS_TALKING_USERNAME') }}" class="form-control">
                                                            @error('africas_talking_username')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                    </div>

                                                     <!-- AFRICAS TALKING APIKEY -->
                                                     <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="text-dark">{{ __('API Key :') }}<span class="text-danger">*</span></label>
                                                            <input name="africas_talking_apikey" type="text" value="{{ env('AFRICAS_TALKING_APIKEY') }}" class="form-control">
                                                            @error('africas_talking_apikey')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                    </div>

                                                    
                                                   <!-- Status -->
                                                   <div class="form-group col-md-6">
                                                        <label class="text-dark" for="exampleInputDetails">{{ __("Africa's Talking Enable") }} :</label><br>
                                                        <input type="checkbox" class="custom_toggle" name="africas_talking_enable" {{ $settings->africas_talking_enable == '1' ? 'checked' : '' }} />
                                                    </div>
              
                                                    <!-- create and close button -->
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <button type="submit" class="btn btn-primary-rgba"><i class="fa fa-check-circle"></i>
                                                            {{ __("Save")}}</button>
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

@section('script')
<!-- script to change status start -->
<script>
  $(function() {
    $('.custom_toggle').change(function() {
        var status = $(this).prop('checked') == true ? 1 : 0;  
        $.ajax({
            type: "GET",
            url: "{{ url('africas_talking/status') }}",
            data: {'status': status},
            success: function(data){
              console.log(id)
            }
        });
    });
  });
</script>
<!-- script to change status end -->
@endsection
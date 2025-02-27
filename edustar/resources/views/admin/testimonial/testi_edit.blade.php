@extends('admin/layouts.master')
@section('title', 'Edit Testimonial - Admin')
@section('maincontent')


@component('components.breadcumb',['fourthactive' => 'active'])
@slot('heading')
{{ __('Edit Testimonial') }}
@endslot
@slot('menu1')
{{ __('Front Settings') }}
@endslot
@slot('menu2')
{{ __('Testimonial') }}
@endslot
@slot('menu3')
{{ __('Edit Testimonial') }}
@endslot

@slot('button')
<div class="col-md-4 col-lg-4">
  <div class="widgetbar">
      <a href="{{ url('testimonial')}}" class="btn btn-primary-rgba"><i class="feather icon-arrow-left mr-2"></i>{{ __("Back")}}</a>
      
  </div>                        
</div>
@endslot

@endcomponent


<div class="contentbar">
  @if ($errors->any())  
  <div class="alert alert-danger" role="alert">
  @foreach($errors->all() as $error)     
  <p>{{ $error}}<button type="button" class="close" data-dismiss="alert" aria-label="Close">
  <span aria-hidden="true" style="color:red;">&times;</span></button></p>
  @endforeach  
  </div>
  @endif
         
  <div class="row">
    <div class="col-lg-12">
      <div class="card m-b-30">
        <div class="card-header">
          <h5 class="card-title">{{ __("Edit Testimonial")}}</h5>
        </div>
        <div class="card-body">

          <form id="demo-form2" method="post" action="{{url('testimonial/'.$test->id)}}" data-parsley-validate class="form-horizontal form-label-left"  enctype="multipart/form-data">
            {{ csrf_field() }}
            {{method_field('PATCH')}}

            <div class="row">
              <div class="form-group col-md-6">
                <label for="exampleInputName">{{ __('Name') }}:<sup class="text-danger">*</sup></label>
                  <input type="text" class="form-control" name="client_name" id="exampleInputTitle"value="{{$test->client_name}}">
              </div>
              <div class="form-group col-md-6">
                <label for="exampleInputTit1e">{{ __('Designation') }}:<sup class="text-danger">*</sup></label>
                    <input type="text" class="form-control" value="{{ $test->designation }}" name="designation" id="exampleInputTitle" placeholder="{{ __('Enter') }} {{ __('Designation') }}" value="">
              </div>

              <div class="form-group col-md-12">
                <label for="exampleInputDetails">{{ __('Detail') }}:<sup class="text-danger">*</sup></label>
                <textarea name="details" row="3" class="form-control">{{$test->details}}</textarea>
              </div>
              <div class="form-group col-md-6">
                <label for="exampleInputSlug">{{ __('Image') }}:<sup class="text-danger">*</sup></label><br>
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text" id="inputGroupFileAddon01">{{ __('Upload') }}</span>
                  </div>
                  <div class="custom-file">
                    <input type="file"  name="image" class="custom-file-input" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01" accept="image/png, image/jpeg, image/gif, image/jpg, image/svg">
                    <label class="custom-file-label" for="inputGroupFile01">{{ __('Choose file') }}</label>
                  </div>
                </div>
                
                
                <img src="{{ url('/images/testimonial/'.$test->image) }}" class="img-responsive image_size"  />
              </div>
             
              <div class="col-md-6">
                <div class="form-group{{ $errors->has('rating') ? ' has-error' : '' }}">
                  <label for="exampleInputName">{{'Rating' }}</label>
                    <div class="col-md-12">
                        <div class="rating">
                            <label>
                                <input type="radio" name="rating" value="1"
                                    {{$test->rating == 1 ? 'checked' : ''}} />
                                <span class="icon"><i class="fa fa-star" style='color:orange'
                                        aria-hidden="true"></i></span>
                            </label>
                            <label>
                                <input type="radio" name="rating" value="2"
                                    {{$test->rating == 2 ? 'checked' : ''}} />
                                <span class="icon"><i class="fa fa-star" style='color:orange'
                                        aria-hidden="true"></i></span>
                                <span class="icon"><i class="fa fa-star" style='color:orange'
                                        aria-hidden="true"></i></span>
                            </label>
                            <label>
                                <input type="radio" name="rating" value="3"
                                    {{$test->rating == 3? 'checked' : ''}} />
                                <span class="icon"><i class="fa fa-star" style='color:orange'
                                        aria-hidden="true"></i></span>
                                <span class="icon"><i class="fa fa-star" style='color:orange'
                                        aria-hidden="true"></i></span>
                                <span class="icon"><i class="fa fa-star" style='color:orange'
                                        aria-hidden="true"></i></span>
                            </label>
                            <label>
                                <input type="radio" name="rating" value="4"
                                    {{$test->rating == 4 ? 'checked' : ''}} />
                                <span class="icon"><i class="fa fa-star" style='color:orange'
                                        aria-hidden="true"></i></span>
                                <span class="icon"><i class="fa fa-star" style='color:orange'
                                        aria-hidden="true"></i></span>
                                <span class="icon"><i class="fa fa-star" style='color:orange'
                                        aria-hidden="true"></i></span>
                                <span class="icon"><i class="fa fa-star" style='color:orange'
                                        aria-hidden="true"></i></span>
                            </label>
                            <label>
                                <input type="radio" name="rating" value="5"
                                    {{$test->rating == 5 ? 'checked' : ''}} />
                                <span class="icon"><i class="fa fa-star" style='color:orange'
                                        aria-hidden="true"></i></span>
                                <span class="icon"><i class="fa fa-star" style='color:orange'
                                        aria-hidden="true"></i></span>
                                <span class="icon"><i class="fa fa-star" style='color:orange'
                                        aria-hidden="true"></i></span>
                                <span class="icon"><i class="fa fa-star" style='color:orange'
                                        aria-hidden="true"></i></span>
                                <span class="icon"><i class="fa fa-star" style='color:orange'
                                        aria-hidden="true"></i></span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group col-md-12">
              <label for="exampleInputDetails" class="mr-3">{{ __('Status') }}:</label><br>
              <input id="status_toggle" type="checkbox" class="custom_toggle" name="status" {{ $test->status == '1' ? 'checked' : '' }} />
              <input type="hidden"  name="free" value="0" for="status" id="status">
            </div>
            </div>
     
         
          <div class="form-group">
            <button type="reset" class="btn btn-danger-rgba mr-1"><i class="fa fa-ban"></i> {{ __("Reset")}}</button>
            <button type="submit" class="btn btn-primary-rgba"><i class="fa fa-check-circle"></i>
            {{ __("Update")}}</button>
          </div>

          </form>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection

@section('scripts')

<script>
(function($) {
  "use strict";
  tinymce.init({selector:'textarea'});
})(jQuery);
</script>

@endsection
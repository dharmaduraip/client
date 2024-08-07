@extends('admin.layouts.master')
@section('title','Edit Private Course')
@section('maincontent')

@component('components.breadcumb',['secondaryactive' => 'active'])

@slot('heading')
{{ __('Private Course') }}
@endslot

@slot('menu1')
{{ __('Edit Private Course') }}
@endslot

@slot('button')
<div class="col-md-4 col-lg-4">
  <a href="{{ url('private-course') }}" class="float-right btn btn-primary-rgba mr-2"><i
      class="feather icon-arrow-left mr-2"></i>{{ __('Back') }}</a>
</div>
@endslot

@endcomponent
<div class="contentbar">
  <div class="row">
    <div class="col-lg-12">
      <div class="card m-b-30">
        <div class="card-header">
          <h5 class="card-box">{{ __('Edit') }} {{ __('Private Course') }}</h5>
        </div>
        <div class="card-body ml-2">
          <form action="{{url('private-course/'.$private->id)}}" method="post" enctype="multipart/form-data">
            {{ csrf_field() }} 
            {{ method_field('PUT') }}
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label>{{ __('Select') }} {{ __('Course') }}: <span class="text-danger">*</span></label>
                  <select class="form-control js-example-basic-single" name="course_id"  size="5" row="5" placeholder="{{ __('Select') }} {{ __('Course') }}">


                    @foreach ($courses as $cat)
                    @if($cat->status == 1)
                    <option value="{{ $cat->id }}" {{$cat->id == $private['course_id'] ? 'selected' : ""}}>{{ $cat->title }}
                    </option>
                    @endif

                  @endforeach

                  </select>
                </div>
                

                <div class="form-group">
                  <label>{{ __('Hide from ') }} {{ __('Users') }}: <span class="text-danger">*</span></label>
                  <select class="form-control js-example-basic-single" name="user_id[]" multiple="multiple" size="5" row="5" placeholder="{{ __('Select') }} {{ __('Users') }}">


                    @foreach ($users as $user)
                      @if($user->status == 1)
                      <option value="{{ $user->id }}" {{in_array($user->id, $private['user_id'] ?: []) ? "selected": ""}}>{{ $user->fname }}
                    </option>
                      @endif

                    @endforeach

                  </select>
                </div>
                
              

              <div class="row">
                
          
                <div class="col-md-3">
                  @if(Auth::User()->role == "admin")
                  <label for="exampleInputTit1e">{{ __('Status') }}:</label><br>
                  <input type="checkbox" class="custom_toggle" name="status" {{ $private->status == '1' ? 'checked' : '' }} />
                
                  @endif
                </div>
              </div>
              <br>
              <div class="form-group">
                <a href="javascript:window.location.reload(true)" class="btn btn-danger-rgba"><i class="fa fa-ban"></i>
                  {{ __('Reset') }}</a>
                <button type="submit" class="btn btn-primary-rgba"><i class="fa fa-check-circle"></i>
                  {{ __('Update') }}</button>
              </div>
              <div class="clear-both"></div>

              </div>
            </div>
          </div>
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


  $(function() {
    $('.js-example-basic-single').select2();
  });

  
})(jQuery);
</script>
  
@endsection


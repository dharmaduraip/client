@extends('admin.layouts.master')
@section('title','Edit Previouspaper')
@section('maincontent')

@component('components.breadcumb',['thirdactive' => 'active'])

@slot('heading')
{{ __('Home') }}
@endslot

@slot('menu1')
{{ __('Admin') }}
@endslot

@slot('menu2')
{{ __(' Edit Previous Paper') }}
@endslot

@slot('button')
<div class="col-md-4 col-lg-4">
<a href="{{ url('course/create/'. $paper->courses->id) }}" class="float-right btn btn-primary-rgba"><i class="feather icon-arrow-left mr-2"></i>{{ __('Back') }}</a>
</div>
@endslot
@endcomponent
@if ($errors->any())
<div class="alert alert-danger">
  <ul>
    @foreach ($errors->all() as $error)
    <li>{{ $error }}</li>
    @endforeach
  </ul>
</div>
@endif
<div class="contentbar">
  <div class="row">
    <div class="col-lg-12">
      <div class="card m-b-30">
        <div class="card-header">
          <h5 class="card-box">{{ __('Edit') }} {{ __('Previous Paper') }}</h5>
        </div>
        <div class="card-body ml-2">
          <form id="demo-form" method="post" action="{{url('previous-paper/'.$paper->id)}}"data-parsley-validate class="form-horizontal form-label-left" enctype="multipart/form-data">
            {{ csrf_field() }}
            {{ method_field('PUT') }}

          
            <input type="hidden" name="course_id" value="{{ $paper->course_id }}"  />


            <div class="row">
              <div class="col-md-12">
                <label for="exampleInputTit1e">{{ __('Title') }} : <span class="redstar">*</span></label>
                <input type="" class="form-control" name="title" id="exampleInputTitle" value="{{$paper->title}}">
                <br>
              </div>

              <div class="col-md-12">
                <label for="exampleInputTit1e">{{ __('Detail') }} : <span class="redstar">*</span></label>
                <textarea name="detail" rows="3" class="form-control" >{{ $paper->detail }}</textarea>
                <br>
              </div>

              <div class="col-md-12">
                  <label for="exampleInputDetails">{{ __('Paper Upload') }} :</label> - <small>{{__('eg: zip or pdf files')}}</small>
                  <!--  -->
                  <div class="input-group mb-3">
										<div class="input-group-prepend">
											<span class="input-group-text" id="inputGroupFileAddon01">{{ __('Upload') }}</span>
										</div>
										<div class="custom-file">
											<input type="file" class="custom-file-input" id="inputGroupFile01" name="file" value="{{ $paper->file }}" aria-describedby="inputGroupFileAddon01">
											<label class="custom-file-label" for="inputGroupFile01">{{ __('Choose file') }}</label>
										</div>
										</div>
                  <!--  -->
                
              </div>
            </div>
            <br>
            @if(file_exists(public_path().'/files/papers/'.$paper->file) && $paper->file != NULL)
            <div class="row">
              <div class="col-md-12 mb-3">
                {{ __('Clik here & Download File') }} : <a href="{{ url('/files/papers/'.$paper->file) }}" download><b>{{ $paper->file }}<b></a>  
              </div>
            </div>
            @endif
            <div class="row">
              <div class="col-md-12">
                <label for="exampleInputTit1e">{{ __('Status') }} :</label><br>
                    <label class="switch">
                      <input class="slider" type="checkbox" name="status" {{ $paper->status == '1' ? 'checked' : '' }} />
                      <span class="knob"></span>
                    </label>
              </div>
            </div>
            <br>
            <div class="form-group">
              <button type="reset" class="btn btn-danger-rgba"><i class="fa fa-ban"></i>
                {{ __('Reset') }}</button>
              <button type="submit" class="btn btn-primary-rgba"><i class="fa fa-check-circle"></i>
                {{ __('Update') }}</button>
            </div>
            <div class="clear-both"></div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>


@endsection
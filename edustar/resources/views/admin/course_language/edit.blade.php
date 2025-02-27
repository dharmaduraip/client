@extends('admin.layouts.master')
@section('title','Edit CourseLanguage')
@section('maincontent')

@component('components.breadcumb',['thirdactive' => 'active'])

@slot('heading')
{{ __('Home') }}
@endslot

@slot('menu1')
{{ __('Admin') }}
@endslot

@slot('menu2')
{{ __(' Edit CourseLanguage') }}
@endslot

@slot('button')
<div class="col-md-4 col-lg-4">
  <a href="{{ url('courselang') }}" class="float-right btn btn-primary mr-2"><i
      class="feather icon-arrow-left mr-2"></i>{{ __('Back') }}</a>
</div>
@endslot

@endcomponent
<div class="contentbar">
  <div class="row">
    <div class="col-lg-12">
      <div class="card m-b-30">
        <div class="card-header">
          <h5 class="card-box">{{ __('Edit') }} {{ __('Language') }}</h5>
        </div>
        <div class="card-body ml-2">
          <form id="demo-form" method="post" action="{{url('courselang/'.$language->id)}}
            "data-parsley-validate class="form-horizontal form-label-left">
        {{ csrf_field() }}
        {{ method_field('PUT') }}
        
          <div class="col-md-12">
            <div class="form-group">
              <label for="exampleInputSlug">{{ __('Name') }}: <sup class="redstar">*</sup></label>
              <input type="text" class="form-control" name="name" value="{{ $language->name }}" id="exampleInputPassword1" placeholder="{{ __('Enter') }} {{ __('Language') }}">
            </div>
           
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="exampleInputTit1e">{{ __('Status') }}:</label>
              <input type="checkbox" class="custom_toggle" name="status"
              {{ $language->status==1 ? 'checked' : '' }}/>

            </div>
          </div>

        <div class="col-md-6">
          <div class="form-group">
            <button type="reset" class="btn btn-danger"><i class="fa fa-ban"></i>
              {{ __('Reset') }}</button>
            <button type="submit" class="btn btn-primary"><i class="fa fa-check-circle"></i>
              {{ __('Update') }}</button>
          </div>

          <div class="clear-both"></div>
        </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection


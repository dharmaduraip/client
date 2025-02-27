@extends('admin.layouts.master')
@section('title','Edit Quiz-topic')
@section('maincontent')
@component('components.breadcumb',['thirdactive' => 'active'])
@slot('heading')
{{ __('Home') }}
@endslot
@slot('menu1')
{{ __('Admin') }}
@endslot
@slot('menu2')
{{ __(' Edit Quiz Topic') }}
@endslot
@slot('button')
<div class="col-md-4 col-lg-4">
<a href="{{ url('course/create/'. $topic->courses->id) }}" class="float-right btn btn-primary-rgba"><i class="feather icon-arrow-left mr-2"></i>{{ __('Back') }}</a>
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
          <h5 class="card-title">{{ __('Edit') }} {{ __('Quiz Topic') }}</h5>
        </div>
        <div class="card-body ml-2">
          <form id="demo-form2" method="POST" action="{{route('quiztopic.update', $topic->id)}}" data-parsley-validate class="form-horizontal form-label-left">
            {{ csrf_field() }}
            {{ method_field('PUT') }}
           
           

            <div class="row">
              <div class="col-md-12">
                <label for="exampleInputTit1e">{{ __('Quiz') }}:<span class="redstar">*</span> </label>
                <input type="text" placeholder="Enter Quiz Topic" class="form-control " name="title" id="exampleInputTitle" value="{{ $topic->title }}">
              </div>
            </div>
            <br>

            <div class="row">
              <div class="col-md-12">
                <label for="exampleInputDetails">{{ __('Quiz Description') }}:<sup class="redstar">*</sup></label>
                <textarea name="description" rows="3" class="form-control" placeholder="Enter Description">{{ $topic->description }}</textarea>
              </div>
            </div>
            <br>

            <div class="row">
              <div class="col-md-12">
                <label for="exampleInputTit1e">{{ __('Per Question Marks') }}:<span class="redstar">*</span> </label>
                <input type="number" placeholder="Enter Per Question Mark" class="form-control " name="per_q_mark" id="exampleInputTitle" value="{{ $topic->per_q_mark }}">
              </div>
            </div>
            <br>


            <div class="row">
              <div class="col-md-12">
                <label for="exampleInputTit1e">{{ __('Quiz Timer') }}:<span class="redstar">*</span> </label>
                <input type="text" placeholder="Enter Quiz Time" class="form-control" name="timer" id="exampleInputTitle" value="{{ $topic->timer }}">
              </div>
            </div>
            <br>

            <div class="row">
              <div class="col-md-12">
                <label for="exampleInputTit1e">{{ __('Days') }}:</label>
                <small class="text-info">({{ __('Days after quiz will start when user enroll in course') }})</small>
                <input type="text" placeholder="Enter Due Days" class="form-control" name="due_days" id="exampleInputTitle" value="{{ $topic->due_days }}">
              </div>
            </div>
            <br>

            <div class="row">
              <div class="col-md-4">
                  <label for="exampleInputTit1e">{{ __('Status') }} :</label><br>
                    <label class="switch">
                    <input class="slider" type="checkbox" name="status" {{ $topic->status == '1' ? 'checked' : '' }} />
                    <span class="knob"></span>
                  </label>
              </div>

              <div class="col-md-4">
                <label for="exampleInputTit1e">{{ __('Quiz Reattempt') }} :</label><br>
                  <label class="switch">
                    <input class="slider" type="checkbox" name="quiz_again" {{ $topic->quiz_again == '1' ? 'checked' : '' }} />
                    <span class="knob"></span>
                  </label>
              </div>

              <div class="col-md-4">
                <label for="exampleInputTit1e">{{ __('Quiz Type') }} : <small class="text-info">{{__('if enable then its create Subjective type (or) if disable then its create Objective type quiz.') }}</small></label><br>
                  <label class="switch">
                    <input class="slider" type="checkbox" name="type" {{ $topic->type == '1' ? 'checked' : '' }} />
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


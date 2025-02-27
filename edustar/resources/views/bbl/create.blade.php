@extends('admin.layouts.master')
@section('title', 'Create a new meeting - Admin')
@section('maincontent')


@component('components.breadcumb',['fourthactive' => 'active'])
@slot('heading')
{{ __('List all meetings') }}
@endslot
@slot('menu1')
{{ __('Mettings') }}
@endslot
@slot('menu2')
{{ __('Big Blue Mettings') }}
@endslot
@slot('menu3')
{{ __(' List all meetings') }}
@endslot
@slot('button')
<div class="col-md-4 col-lg-4">
  <div class="widgetbar">
    <a href="{{url("bigblue/meetings")}}" class="btn btn-primary-rgba"><i class="feather icon-arrow-left mr-2"></i>{{ __("Back")}}</a>

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
          <h5 class="card-title">{{ __('Create a new meeting') }}</h5>
        </div>
        <div class="card-body">

          <form action="{{ route('bbl.store') }}" method="POST" autocomplete="off">
            @csrf

           <div class="row">
              <div class="form-group col-md-12">
                <label for="exampleInputDetails">{{ __('Link By Course') }}:</label>
                    {{-- <input id="TextPosition" class="custom_toggle" type="checkbox" name="link_by" /> --}}

                    <input type="checkbox" id="myCheck" name="link_by" class="custom_toggle" onclick="myFunction()"  >
                    {{-- <input type="hidden" name="free" value="0" for="opp" id="link_by"> --}}

              </div>


              <div class="form-group col-md-12">
               <div  id="update-password" style="display: none"> 
                <label>{{ __('Courses') }}:<span class="redstar">*</span></label>
                <select name="course_id" id="course_id" class="select2-single form-control">
                  <option value="" selected disabled>{{ __('Please Select an Option') }}</option>
                  @php
                    $course = App\Course::where('status', '1')->where('user_id', Auth::user()->id)->get();
                  @endphp
                  @foreach($course as $cor)
                    <option value="{{$cor->id}}">{{$cor->title}}</option>
                  @endforeach
                </select>
              </div>
              </div>

              <div class="form-group col-md-6">
                <label  for="exampleInputDetails">{{ __('Presenter Name') }}: <sup class="redstar">*</sup></label>
                <input value="{{ old('presen_name') }}" type="text" name="presen_name" class="form-control" required="" placeholder="enter presenter name">
              </div>

              <div class="form-group col-md-6">
                <label>{{ __('MeetingID') }}: <sup class="redstar">*</sup></label>
                <input value="{{ old('meetingid') }}" type="text" name="meetingid" class="form-control" required="" placeholder="enter meeting id">
               
              </div>
              <div class="form-group col-md-6">
                <label> {{ __('Meeting') }} {{ __('Name') }}: <sup class="redstar">*</sup></label>
                <input value="{{ old('meetingname') }}" type="text" name="meetingname" class="form-control" required="" placeholder="enter meeting name">
              </div>

              <div class="form-group col-md-6">
                <label>{{ __('Meeting') }} {{ __('Duration') }}: <sup class="redstar">*</sup>   <small class="text-muted">It will be count in minutes</small> </label>
                <input value="{{ old('duration') }}" type="text" name="duration" class="form-control" required="" placeholder="enter meeting duration eg. 40">
                
              </div>


              <div class="form-group col-md-12">
                <label>
                  {{ __('Start Time') }}:<sup class="redstar">*</sup>
                </label>

                <div class="input-group" id='datetimepicker1'>
                  <input type="text"  name="start_time"   id="time-format" class="form-control" placeholder="dd/mm/yyyy - hh:ii aa" aria-describedby="basic-addon5" required/>
                  <div class="input-group-append">
                      <span class="input-group-text" id="basic-addon5"><i class="feather icon-calendar"></i></span>
                  </div>
                </div>
              </div>


              <div class="form-group col-md-6">
                <label> {{ __('Moderator Password') }}:</label>
                <div class="input-group mb-3">
                  
                  <input id="password-field"  type="password"  name="modpw" class="form-control" placeholder="enter moderator password">
                  <div class="input-group-prepend text-center">
                  <span toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password"></span></i></span>
                  </div>
                </div>
               
              </div>


              <div class="form-group col-md-6">
                <label>{{ __('Attandee Password') }}:<span class="redstar">*</span> <small class="text-muted text-info"><br>
                  (<b>Tip !</b> Share your attendee password to students using social handling networks.)</small></label>
                
                <input required id="attendeepw" value="" type="password" name="attendeepw" class="form-control" placeholder="enter attandee password">
                
                 <small class="text-muted text-info">{{__('Should be diffrent from')}} <b>{{__('Moderator')}}</b> {{__('password')}}</small>

              </div>

              <div class="form-group col-md-6">
                <label>{{__('Set Welcome Message:')}}</label>
                <input value="{{ old('welcomemsg') }}" type="text" class="form-control" name="welcomemsg" placeholder="enter welcome message">

              </div>
              <div class="form-group col-md-6">
                <label>{{__('Set Max Participants:')}}</label>
              <input value="{{ old('setMaxParticipants') }}" type="number" min="-1" class="form-control" name="setMaxParticipants" placeholder="enter maximum participant no., leave blank if want unlimited participant"/>

              </div>
              <div class="form-group col-md-6">
                <label>{{__('Set Mute on Start:')}}</label>
                <input class="custom_toggle" type="checkbox" name="setMuteOnStart" />

              </div>
              <div class="form-group col-md-6" style="display: none">
                <label>{{__('Allow Record:')}}</label>
                <input  class="custom_toggle" type="checkbox" name="allow_record" />

              </div>
            </div>
            <a href="javascript:window.location.reload(true)" class="btn btn-danger-rgba"><i class="fa fa-ban"></i> {{__('Reset')}}</a>
            <button type="submit" class="btn btn-primary-rgba"><i class="fa fa-check-circle"></i>
              {{__('Create')}}</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>



@endsection
@section('script')

<script>
  (function($) {
    "use strict";
    $(function(){
        $('#myCheck').change(function(){
          if($('#myCheck').is(':checked')){
            $('#update-password').show('fast');
          }else{
            $('#update-password').hide('fast');
          }
        });
        
    });
  })(jQuery);
  </script>
@endsection
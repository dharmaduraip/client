@extends('admin.layouts.master')
@section('title','Create a new course')
@section('stylesheet')
  <style>
  .loader-div {
    position: fixed;
    height: 100%;
    width: 100%;
    top: 0px;
    left: 0;
    bottom: 0;
    right: 0px;
    background: #00000066;
    z-index: 99999;
  }
  .loader {
    display: flex;
    flex-direction: column;
    align-items: center;
  }
  .loader-circle {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    background-color: white;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    display: flex;
    justify-content: center;
    align-items: center;
    animation: pulse 1.5s ease-in-out infinite;
  }
  .loader-circle:before {
    content: "";
    display: block;
    width: 50px;
    height: 50px;
    border-radius: 50%;
    border: 5px solid #000000;
    border-color: #000000 transparent #000000 transparent;
    animation: loader 1.2s linear infinite;
  }
  .loader-text {
    color: #000000;
    font-size: 15px;
    font-weight: bold;
    margin-top: 16px;
    background: white;
    padding: 3px 14px;
    font-family: "Mukta Vaani", sans-serif;
    border-radius: 10px;
  }
  @keyframes loader {
    0% {
      transform: rotate(0deg);
    }
    100% {
      transform: rotate(360deg);
    }
  }
  @keyframes pulse {
    0% {
      transform: scale(0.8);
      opacity: 0.5;
    }
    50% {
      transform: scale(1);
      opacity: 1;
    }
    100% {
      transform: scale(0.8);
      opacity: 0.5;
    }
  }
</style>
@endsection
@section('breadcum')
@component('components.breadcumb',['secondaryactive' => 'active'])
@slot('heading')
{{ __('Course') }}
@endslot

@slot('menu1')
{{ __('Course') }}
@endslot

@slot('button')

<div class="col-md-4 col-lg-4">
  <div class="widgetbar">
    <a href="{{route('course.index')}}" class="float-right btn btn-primary-rgba mr-2"><i class="feather icon-arrow-left mr-2"></i>{{ __('Back') }}</a>
  </div>
</div>

@endslot
@endcomponent

<div class="contentbar">
  @if ($errors->any())
  <div class="alert alert-danger">
    <ul>
      @foreach ($errors->all() as $error)
      <li>{{ $error }}</li>
      @endforeach
    </ul>
  </div>
  @endif
  <div class="row">
    <!-- loader div -->
    <div class="loader-div d-none">
      <div class="d-flex justify-content-center align-items-center h-100 w-100">
        <div class="loader">
          <div class="loader-circle"></div>
          <span class="loader-text">uploading...</span>
        </div>
      </div>
    </div>
    <!-- loader div -->
    <div class="col-lg-12">
      <div class="card m-b-30">
        <div class="card-header">
          <h5 class="box-tittle">{{ __('Add') }} {{ __('Course') }}</h5>
        </div>
        <div class="card-body">
          <form action="{{url('course/')}}" method="post" enctype="multipart/form-data">
            {{ csrf_field() }}

            <div class="row">
              <div class="col-md-3">
                <label>{{ __('Category') }}:<span class="redstar">*</span></label>
                <select name="category_id" id="category_id" class="form-control select2">
                  <option value="" selected hidden disabled>{{ __('Select an Option') }}</option>
                  @foreach($category as $cate)
                  <option value="{{$cate->id}}" {{ old('category_id') == $cate->id ? 'selected' : '' }}>{{$cate->title}}</option>
                  @endforeach
                </select>
                <div class="redstar category_id"></div>
              </div>
              <div class="col-md-3">
                <label>{{ __('SubCategory') }}:<span class="redstar">*</span></label>
                <select name="subcategory_id" id="upload_id" class="form-control select2">
                  <option value="" selected hidden disabled>{{ __('First Select Category') }}</option>
                </select>
                <div class="redstar upload_id"></div>
              </div>
              <div class="col-md-3">
                <label>{{ __('Child Category') }}:</label>
                <select name="childcategory_id" id="grand" class="form-control select2">
                  <option value="" selected hidden disabled>{{ __('First Select Subcategory') }}</option>
                </select>
              </div>
              <div class="col-md-3">
                <label for="exampleInputTit1e">{{ __('Instructor') }}<span class="redstar">*</span></label>
                <select name="user_id" class="form-control select2 col-md-7 col-xs-12" id="user_id">
                  <option value="" selected hidden disabled>{{ __('Select an Option') }}</option>
                  @if(Auth::user()->role == 'admin')
                    <option value="{{Auth::user()->id}}">{{Auth::user()->fname}} {{Auth::user()->lname}}</option>
                    @foreach($users as $user)
                      <option value="{{$user->id}}">{{$user->fname}} {{$user->lname}}</option>
                    @endforeach
                  @else
                    <option value="{{Auth::user()->id}}" selected>{{Auth::user()->fname}}</option>
                  @endif
                </select>
                <div class="redstar user_id"></div>
              </div>
              <br>
              <div class="col-md-12">
                <div class="form-group">
                  <label>{{ __("Also in :") }} </label>
                  <select multiple="multiple" name="other_cats[]" id="other_cats" class="form-control select2">
                    @foreach($category as $category)
                    <option {{ old('other_cats') != '' && in_array($category->id,old('other_cats')) ? "selected" : "" }} value="{{ $category->id }}">{{ $category->title }}</option>
                    @endforeach
                  </select>

                  <small class="text-primary">
                    <i class="feather icon-help-circle"></i> {{ __("If in list primary category is also present then it will auto remove from this after create product.") }}
                  </small>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-4">
                <label>{{ __('Language') }}: <span class="redstar">*</span></label>
                <select name="language_id" class="form-control select2" id="language_id">
                  <option value="" selected hidden disabled>{{ __('Select an Option') }}</option>
                  @php
                  $languages = App\CourseLanguage::where('status','1')->get();
                  @endphp
                  @foreach($languages as $caat)
                  <option {{ old('language_id') == $caat->id ? 'selected' : "" }} value="{{ $caat->id }}">{{ $caat->name }}</option>
                  @endforeach
                </select>
                <div class="redstar language_id"></div>
              </div>

              <div class="col-md-4">
                @php
                $ref_policy = App\RefundPolicy::where('status','1')->get();
                @endphp
                <label for="exampleInputSlug">{{ __('Select Refund Policy') }}</label>
                <select name="refund_policy_id" class="form-control select2">
                  <option value="none" selected disabled hidden>
                    {{ __('Select an Option') }}
                  </option>
                  @foreach($ref_policy as $ref)
                  <option value="{{ $ref->id }}" {{ old('refund_policy_id') == $ref->id ? 'selected' : '' }}>{{ $ref->name }}</option>
                  @endforeach
                </select>

              </div>

              @if(Auth::User()->role == "admin")
              <div class="col-md-4">
                <label>{{ __('Institute') }}: <span class="redstar">*</span></label>
                <select name="institude_id" class="form-control select2" id="institude_id">
                  @php
                  $institute = App\Institute::where('status' ,'1')->get();
                  @endphp
                  <option value="none" selected disabled hidden>
                    {{ __('Select an Option') }}
                  </option>
                  @foreach($institute as $inst)
                  <option value="{{ $inst->id }}" {{ old('institude_id') == $inst->id ? 'selected' : '' }}>{{ $inst->title }}</option>
                  @endforeach
                </select>
                <div class="redstar institude_id"></div>
              </div>
              @endif

              @if(Auth::User()->role == "instructor")
              <div class="col-md-4">
                <label>{{ __('Institute') }}: <span class="redstar">*</span></label>
                <select name="institude_id" class="form-control select2" id="institude_id">
                  @php
                  $institute = App\Institute::where('user_id',Auth::user()->id)->where('status' ,'1')->get();
                  @endphp
                  <option value="none" selected disabled hidden>
                    {{ __('Select an Option') }}
                  </option>
                  @foreach($institute as $inst)
                  <option value="{{ $inst->id }}" {{ old('institude_id') == $inst->id ? 'selected' : '' }}>{{ $inst->title }}</option>
                  @endforeach
                </select>
                <div class="redstar institude_id"></div>
              </div>
              @endif


            </div>
            <br>



            <div class="row">
              <div class="col-md-6">
                <label for="exampleInputTit1e">{{ __('Title') }}: <sup class="redstar">*</sup></label>
                <input type="title" class="form-control" name="title" id="exampleInputTitle" placeholder="{{ __('Enter') }} {{ __('Title') }}" value="{{ (old('title')) }}">
                <div class="redstar exampleInputTitle"></div>
              </div>
              <div class="col-md-6">
                <label for="exampleInputSlug">{{ __('Slug') }}: <sup class="redstar">*</sup></label>
                <input  type="text" class="form-control slugval" name="slug" id="exampleInputPassword1 " placeholder="{{ __('Enter') }} {{ __('Slug') }}" value="{{ (old('slug')) }}" >
                <div class="redstar slug"></div>
              </div>
            </div>
            <br>

            <div class="row">
              <div class="col-md-6">
                <label for="exampleInputTit1e">{{ __('Short Detail') }}: <sup class="redstar">*</sup></label>
                <textarea name="short_detail" rows="3" class="form-control" placeholder="{{ __('Enter') }} {{ __('ShortDetail') }}" id="short_detail">{{ (old('short_detail')) }}</textarea>
                <div class="redstar short_detail"></div>
              </div>
              <div class="col-md-6">
                <label for="exampleInputTit1e">{{ __('Requirements') }}: <sup class="redstar">*</sup></label>
                <textarea name="requirement" rows="3" class="form-control" placeholder="{{ __('Enter') }} {{ __('Requirements') }}" id="requirement" >{{ (old('requirement')) }}</textarea>
                <div class="redstar requirement"></div>
              </div>
            </div>
            <br>



            <div class="row">
              <div class="col-md-12">
                <label for="exampleInputTit1e">{{ __('Detail') }}: <sup class="redstar">*</sup></label>
                <textarea id="detail" name="detail" rows="3" class="form-control">{{ (old('detail')) }}</textarea>
                <div class="redstar detail"></div>
              </div>
            </div>
            <br>

            <!-- country start -->
            <div class="row">
              <div class="col-md-12">

                <label>{{ __('Country') }}: </label>
                <select class="select2-multi-select-tf form-control" name="countries[]" multiple="multiple">
                  @foreach($countries as $country)
                  <option {{ in_array($country->name, old('countries', [])) ? 'selected' : '' }}>{{ $country->name }}</option>
                  @endforeach
                </select>

                <small class="text-info"><i class="fa fa-question-circle"></i> ({{ __('Select those countries where you want to block courses')}} )</small>

              </div>
            </div>
            <br>
            <!-- country end -->


            @if(Auth::User()->role == "admin")
            <div class="row">
              <div class="col-md-12">

                <label for="exampleInputSlug">{{ __('Select Tags') }}:</label>
                <select class="form-control js-example-basic-single" name="level_tags">
                  <option value="none" selected disabled hidden>
                    {{ __('Select an Option') }}
                  </option>

                  <option value="trending" {{ old('level_tags') == 'trending' ? 'selected' : '' }}>{{ __('Trending') }}</option>

                  <option value="onsale" {{ old('level_tags') == 'onsale' ? 'selected' : '' }}>{{ __('On-sale') }}</option>

                  <option value="bestseller" {{ old('level_tags') == 'bestseller' ? 'selected' : '' }}>{{ __('Bestseller') }}</option>

                  <option value="beginner" {{ old('level_tags') == 'beginner' ? 'selected' : '' }}>{{ __('Beginner') }}</option>

                  <option value="intermediate" {{ old('level_tags') == 'intermediate' ? 'selected' : '' }}>{{ __('Intermediate') }}</option>

                  <option value="expert" {{ old('level_tags') == 'expert' ? 'selected' : '' }}>{{ __('Expert') }}</option>

                </select>

              </div>

            </div>

            @endif
            <br>

            <div class="row">
              <div class="col-md-12">

                <label>{{ __('Course Tags') }}: <span class="redstar">*</span></label>
                <select class="select2-multi-select form-control" name="course_tags[]" multiple="multiple" size="5" row="5" placeholder="" id="course_tags">

                  <option></option>

                </select>
                <div class="redstar course_tags"></div>
              </div>
            </div>
            <br>



            <div class="row">
              <div class="col-md-12 d-none">


                <label for="exampleInputSlug">{{ __('ReturnAvailable') }}</label>
                <select name="refund_enable" class="form-control js-example-basic-single col-md-7 col-xs-12">
                  <option value="none" selected disabled hidden>
                    {{ __('Select an Option') }}
                  </option>

                  <option value="1">{{ __('Return Available') }}</option>
                  <option value="0">{{ __('Return Not Available') }}</option>

                </select>

              </div>
            </div>
            <br>
            <div class="row">
              <div class="col-md-3">
                <label for="exampleInputDetails">{{ __('Paid') }}:</label>
                <input type="checkbox" class="custom_toggle" id="cb111" name="type" id="customSwitch2"/>

                <label class="tgl-btn" data-tg-off="{{ __('Free') }}" data-tg-on="{{ __('Paid') }}" for="cb111"></label>

                <br>
                <div style="display: none;" id="pricebox">
                  <label for="exampleInputSlug">{{ __('Price') }}: <sup class="redstar">*</sup></label>
                  <input type="number" step="0.01" class="form-control" name="price" id="priceMain" placeholder="{{ __('Enter') }} {{ __('Price') }}" value="{{ (old('price')) }}">
                  <div class="redstar priceMain"></div>
                  <label for="exampleInputSlug">{{ __('Discount Price') }}: </label>
                  <input type="number" step="0.01" class="form-control" name="discount_price" id="offerPrice" placeholder="{{ __('Enter') }} {{ __('Discount Price') }}" value="{{ (old('discount_price')) }}">
                </div>
              </div>
              <div class="col-md-3 d-none">
                {{-- <label for="exampleInputDetails">{{ __('MoneyBack') }}:</label>
                <input type="checkbox" class="custom_toggle" id="cb01" name="type" checked />
                <label class="tgl-btn" data-tg-off="{{ __('No') }}" data-tg-on="{{ __('Yes') }}" for="cb01"></label> --}}
                {{-- <input type="hidden" name="free" value="0" id="cb10"> --}}
                <br>
                {{-- <div class="display-none" id="dooa">
        
                  <label for="exampleInputSlug">{{ __('Days') }}: <sup class="redstar">*</sup></label>
                <input type="number" min="1" class="form-control" name="day" id="exampleInputPassword1" placeholder="{{ __('Enter') }} {{ __('Days') }}" value="">

              </div> --}}
            </div>

            <div class="col-md-3">
              @if(Auth::User()->role == "admin")
              <label for="exampleInputDetails">{{ __('Featured') }}:</label>
              <input type="checkbox" class="custom_toggle" id="cb1" name="featured" checked />
              <label class="tgl-btn" data-tg-off="{{ __('OFF') }}" data-tg-on="{{ __('ON') }}" for="cb1"></label>
              {{-- <input type="hidden" name="featured" value="0" id="j"> --}}
              @endif
            </div>
            <div class="col-md-3">
              @if(Auth::User()->role == "admin")
              <label for="exampleInputDetails">{{ __('Status') }}:</label>
              <input type="checkbox" class="custom_toggle" name="status" id="cb3" checked />
              <label class="tgl-btn" data-tg-off="{{ __('Deactive') }}" data-tg-on="{{ __('Active') }}" for="cb3"></label>
              {{-- <input type="hidden" name="status" id="test"> --}}
              @endif
            </div>

            <div class="col-md-3">
              <label for="exampleInputDetails">{{ __('Instructor Involvement Request') }}:</label>
              <input name="involvement_request" type="checkbox" class="custom_toggle" id="involve" checked />
              <label class="tgl-btn" data-tg-off="{{ __('OFF') }}" data-tg-on="{{ __('ON') }}" for="involve"></label>

            </div>
        </div>
        <br>

        <div class="row">
          <div class="col-md-6">
            <label for="exampleInputDetails">{{ __('Preview Video') }}:</label>
            <input id="preview" type="checkbox" class="custom_toggle" name="preview_type" />
            <label class="tgl-btn" data-tg-off="{{ __('URL') }}" data-tg-on="{{ __('Upload') }}" for="preview"></label>

            <div style="display: none;" id="document1">
              <label for="exampleInputSlug">{{ __('Upload Video') }}:</label>
              <input type="file" name="video" id="video" value="" class="form-control" accept=".mp4,.avi,.wmv">
            </div>
            <div id="document2">
              <label for="">{{ __('URL') }}: </label>
              <input type="url" name="url" id="url" placeholder="{{ __('Enter') }} {{ __('URL') }}" class="form-control" value="{{ (old('url')) }}">
            </div>
          </div>



          <div class="col-md-6">
            <label for="">{{ __('Duration') }}: </label>
            <input id="duration_type" type="checkbox" class="custom_toggle" name="duration_type" checked />
            <label class="tgl-btn" data-tg-off="{{ __('Days') }}" data-tg-on="{{ __('Month') }}" for="duration_type"></label>
            <small class="text-info"><i class="fa fa-question-circle"></i> {{ __('If enabled duration can be in months') }},</small>
            <small class="text-info"> {{ __('when Disabled duration can be in days') }}.</small>
            <br>
            <label for="exampleInputSlug">{{ __('Course Expire Duration') }}<span class="redstar">*</span></label>
            <input min="1" class="form-control" name="duration" type="number" id="duration" placeholder="{{ __('Enter') }} {{ __('Course Expire Duration') }}" value="{{ (old('duration')) }}" >
            <div class="redstar duration"></div>
          </div>
        </div>

        <br>

        <div class="row">
          @if(Auth::user()->role == 'instructor')
          <div class="col-md-6">
            <label class="text-dark" for="exampleInputSlug">{{ __('PreviewImage') }}<sup class="redstar">*</sup> </label>
            <div class="input-group mb-3">
              <div class="input-group-prepend">
                <span class="input-group-text" id="file">{{ __('Upload') }}</span>
              </div>
              <div class="custom-file">
                <input type="file" name="preview_image" class="custom-file-input" id="file" aria-describedby="inputGroupFileAddon01">
                <label class="custom-file-label" for="inputGroupFile01">{{ __('Choose file') }}</label>
              </div>
            </div>
          </div>
          @endif

          @if(Auth::user()->role == 'admin')
          <div class="col-md-6">
            <label class="text-dark">{{ __('PreviewImage') }}<sup class="redstar">*</sup> <span class="text-danger"></span></label><br>
            <div class="input-group mb-3">
              <input type="text" class="form-control" readonly id="image" name="preview_image">
              <div class="input-group-append">
                <span data-input="image" class="midia-toggle btn-primary  input-group-text" id="basic-addon2">{{ __('Browse') }}</span>
              </div>
            </div>
          </div>
          @endif


          <div class="col-md-6">
            @if(Auth::User()->role == "admin")
            <label for="Revenue">{{ __('Instructor Revenue') }}:</label>
            <div class="input-group">
              <input min="1" max="100" class="form-control" name="instructor_revenue" type="number" id="revenue" placeholder="{{ __('Enter') }} revenue percentage" class="{{ $errors->has('instructor_revenue') ? ' is-invalid' : '' }} form-control" value="{{ (old('instructor_revenue')) }}">
              <span class="input-group-addon"><i class="fa fa-percent"></i></span>
            </div>
            @endif
          </div>
        </div>
        </br>
        <br>


        <div class="row">
          <div class="col-sm-3">

            <label for="exampleInputDetails">{{ __('Assignment') }}:</label>
            <input {{ old('assignment_enable') == "0" ? '' : "checked" }} id="frees" type="checkbox" class="custom_toggle" name="assignment_enable" checked />
            <label class="tgl-btn" data-tg-off="{{ __('No') }}" data-tg-on="{{ __('Yes') }}" for="frees">
              <small class="text-info"><i class="fa fa-question-circle"></i> {{ __('To enable assignment on portal') }}
          </small>
            </label>

          </div>

          <div class="col-sm-3">

            <label for="exampleInputDetails">{{ __('Appointment') }}:</label>
            <input {{ old('appointment_enable') == "0" ? '' : "checked" }} id="frees1" type="checkbox" class="custom_toggle" name="appointment_enable" checked />
            <label class="tgl-btn" data-tg-off="{{ __('No') }}" data-tg-on="{{ __('Yes') }}" for="frees1"></label>

          </div>

          <div class="col-sm-3">
            <label for="exampleInputDetails">{{ __('Certificate Enable') }}:</label>
            <input {{ old('certificate_enable') == "0" ? '' : "checked" }} id="frees2" type="checkbox" class="custom_toggle" name="certificate_enable" checked />
            <label class="tgl-btn" data-tg-off="{{ __('No') }}" data-tg-on="{{ __('Yes') }}" for="frees2"></label>
          </div>

          <div class="col-sm-3">
            <label for="">{{ __('Drip Content') }}: </label>
            <input id="drip_enable" type="checkbox" class="custom_toggle" name="drip_enable" checked />
            <label class="tgl-btn" data-tg-off="Disable" data-tg-on="Enable" for="drip_enable"></label>
            <small class="text-info"><i class="fa fa-question-circle"></i> {{ __('To release content on chapter & classes by a specific date or amount of days after enrollment') }}.
          </small>
          </div>
        </div>
        <br>
        <br>
        <div class="form-group">
          <a href="javascript:window.location.reload(true)" class="btn btn-danger-rgba"><i class="fa fa-ban"></i> {{ __('Reset') }}</a>
          <button type="submit" class="btn btn-primary-rgba loaderenable"><i class="fa fa-check-circle"></i>
            {{ __('Create') }}</button>
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
@section('scripts')

<script>
  $(document).ready(function(){
    $(".loaderenable").click(function(){
      var category_id = $("#category_id").val();
      var subcategory_id = $("#upload_id").val();
      var user_id = $("#user_id").val();
      var language_id = $("#language_id").val();
      var institude_id = $("#institude_id").val();
      var title = $("#exampleInputTitle").val();
      var slug = $(".slugval").val();
      var short_detail = $("#short_detail").val();
      var requirement = $("#requirement").val();
      var course_tags = $("#course_tags").val();
      var duration = $("#duration").val();

      $(".redstar.category_id").html("");
      $(".redstar.priceMain").html("");
      $(".redstar.upload_id").html("");
      $(".redstar.user_id").html("");
      $(".redstar.language_id").html("");
      $(".redstar.institude_id").html("");
      $(".redstar.exampleInputTitle").html("");
      $(".redstar.slug").html("");
      $(".redstar.short_detail").html("");
      $(".redstar.requirement").html("");
      $(".redstar.course_tags").html("");
      $(".redstar.duration").html("");

      if(category_id == "" || category_id == undefined)
      {
          $(".redstar.category_id").html("please choose category");
          var divLoc = $('.redstar.category_id').offset();
          myscrollfunc(divLoc);
          return false;
      }
      if(subcategory_id == "" || subcategory_id == undefined)
      {
          $(".redstar.upload_id").html("please choose subcategory");
          var divLoc = $('.redstar.upload_id').offset();
          myscrollfunc(divLoc);
          return false;
      }
      if(user_id == "" || user_id == undefined)
      {
          $(".redstar.user_id").html("please choose instructor");
          var divLoc = $('.redstar.user_id').offset();
          myscrollfunc(divLoc);
          return false;
      }
      if(language_id == "" || language_id == undefined)
      {
          $(".redstar.language_id").html("please choose language");
          var divLoc = $('.redstar.language_id').offset();
          myscrollfunc(divLoc);
          return false;
      }
      if(institude_id == "" || institude_id == undefined)
      {
          $(".redstar.institude_id").html("please choose institude");
          var divLoc = $('.redstar.institude_id').offset();
          myscrollfunc(divLoc);
          return false;
      }
      if(title == "" || title == undefined)
      {
          $(".redstar.exampleInputTitle").html("title field is required");
          var divLoc = $('.redstar.exampleInputTitle').offset();
          myscrollfunc(divLoc);
          return false;
      }
      if(slug == "" || slug == undefined)
      {
          $(".redstar.slug").html("slug field is required");
          var divLoc = $('.redstar.slug').offset();
          myscrollfunc(divLoc);
          return false;
      }
      if(short_detail == "" || short_detail == undefined)
      {
          $(".redstar.short_detail").html("short_detail field is required");
          var divLoc = $('.redstar.short_detail').offset();
          myscrollfunc(divLoc);
          return false;
      }
      if(requirement == "" || requirement == undefined)
      {
          $(".redstar.requirement").html("requirement field is required");
          var divLoc = $('.redstar.requirement').offset();
          myscrollfunc(divLoc);
          return false;
      }
      if(course_tags == "" || course_tags == undefined)
      {
          $(".redstar.course_tags").html("course tags field is required");
          var divLoc = $('.redstar.course_tags').offset();
          myscrollfunc(divLoc);
          return false;
      }
      if(duration == "" || duration == undefined)
      {
          $(".redstar.duration").html("duration field is required");
          var divLoc = $('.redstar.duration').offset();
          myscrollfunc(divLoc);
          return false;
      }
      
      $(".loader-div").removeClass('d-none');
      $("body").addClass('overflow-hidden');

    });
  });

  function myscrollfunc(divLoc)
  {
      var loc = divLoc.top-300;
      $('html, body').animate({scrollTop: loc}, "slow");
  }

  (function($) {
    "use strict";

    $(function() {
      $('.js-example-basic-single').select2({
        tags: true,
        tokenSeparators: [',', ' ']
      });
      $(".select2-multi-select-tf").select2({
         tags:false,
      });
    });

    $(function() {
      $('#cb1').change(function() {
        $('#j').val(+$(this).prop('checked'))
      })
    })

    $(function() {
      $('#cb3').change(function() {
        $('#test').val(+$(this).prop('checked'))
      })
    })

    $('#cb111').on('change', function() {

      if ($('#cb111').is(':checked')) {
        $('#pricebox').show('fast');

        $(".redstar.priceMain").html("Price field is required");
        var divLoc = $('.redstar.priceMain').offset();
        myscrollfunc(divLoc);
        return false;

      } else {
        $('#pricebox').hide('fast');

        $('#priceMain').removeAttr('required');
      }

    });

    $('#preview').on('change', function() {

      if ($('#preview').is(':checked')) {
        $('#document1').show('fast');
        $('#document2').hide('fast');
      } else {
        $('#document2').show('fast');
        $('#document1').hide('fast');
      }

    });

    $("#cb3").on('change', function() {
      if ($(this).is(':checked')) {
        $(this).attr('value', '1');
      } else {
        $(this).attr('value', '0');
      }
    });

    $(function() {

      $('#ms').change(function() {
        if ($('#ms').val() == 'yes') {
          $('#doabox').show();
        } else {
          $('#doabox').hide();
        }
      });

    });

    $(function() {

      $('#ms').change(function() {
        if ($('#ms').val() == 'yes') {
          $('#doaboxx').show();
        } else {
          $('#doaboxx').hide();
        }
      });

    });

    $(function() {

      $('#msd').change(function() {
        if ($('#msd').val() == 'yes') {
          $('#doa').show();
        } else {
          $('#doa').hide();
        }
      });

    });

    $(function() {
      var urlLike = '{{ url('admin/dropdown') }}';
      $('#category_id').change(function() {
        var up = $('#upload_id').empty();
        var cat_id = $(this).val();
        if (cat_id) {
          $.ajax({
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "GET",
            url: urlLike,
            data: {
              catId: cat_id
            },
            success: function(data) {
              console.log(data);
              up.append('<option value="" selected disabled>Please Choose</option>');
              $.each(data, function(id, title) {
                up.append($('<option>', {
                  value: id,
                  text: title
                }));
              });
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
              console.log(XMLHttpRequest);
            }
          });
        }
      });
    });

    $(function() {
      var urlLike = '{{ url('admin/gcat') }}';
      $('#upload_id').change(function() {
        var up = $('#grand').empty();
        var cat_id = $(this).val();
        if (cat_id) {
          $.ajax({
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "GET",
            url: urlLike,
            data: {
              catId: cat_id
            },
            success: function(data) {
              console.log(data);
              up.append('<option value="" selected disabled>Please Choose</option>');
              $.each(data, function(id, title) {
                up.append($('<option>', {
                  value: id,
                  text: title
                }));
              });
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
              console.log(XMLHttpRequest);
            }
          });
        }
      });
    });
  })(jQuery);
</script>


<script>
  $(".midia-toggle").midia({
    base_url: '{{ url('') }}',
    title: 'Choose Course Image',
    dropzone: {
      acceptedFiles: '.jpg,.png,.jpeg,.webp,.bmp,.gif'
    },
    directory_name: 'course'
  });
</script>


@endsection
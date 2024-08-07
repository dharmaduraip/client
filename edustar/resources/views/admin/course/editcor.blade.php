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
    @if ($errors->any())
    <div class="alert alert-danger">
      <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
    @endif
    <div class="card m-b-30">
      <div class="card-header">
        <h5 class="card-box">{{ __('Edit') }} {{ __('Course') }}</h5>
      </div>
      <div class="card-body ml-2">
        <form action="{{route('course.update',$cor->id)}}" method="post" enctype="multipart/form-data">
          {{ csrf_field() }}
          {{ method_field('PUT') }}

          <div class="row">
            <div class="col-md-3">
              <label>{{ __('Category') }}<span class="redstar">*</span></label>
              <select name="category_id" id="category_id" class="form-control select2" >
                <option value="" disabled selected>{{ __('SelectanOption') }}</option>
                @php
                $category = App\Categories::where('status','1')->get();
                @endphp
                
                @foreach($category as $caat)
                <option {{ $cor->category_id == $caat->id ? 'selected' : "" }} value="{{ $caat->id }}">{{ $caat->title }}</option>
                @endforeach
              </select>
              <div class="redstar category_id"></div>
            </div>
            <div class="col-md-3">
              <label>{{ __('SubCategory') }}:<span class="redstar">*</span></label>
              <select name="subcategory_id" id="upload_id" class="form-control select2">
                @php
                $subcategory =App\SubCategory::where('category_id', $cor->category_id)->where('status','1')->get();
                @endphp
                <option value="" selected disabled hidden>
                  {{ __('SelectanOption') }}
                </option>
                @if(!empty($subcategory))
                @foreach($subcategory as $caat)
                <option {{ $cor->subcategory_id == $caat->id ? 'selected' : "" }} value="{{ $caat->id }}">{{ $caat->title }}</option>
                @endforeach
                @endif
              </select>
              <div class="redstar upload_id"></div>
            </div>
            <div class="col-md-3">
              <label>{{ __('Child Category') }}:</label>
              <select name="childcategory_id" id="grand" class="form-control select2">
                @php
                $childcategory = App\ChildCategory::where('subcategory_id', $cor->subcategory_id)->where('status','1')->get();
                @endphp
                <option value="none" selected disabled hidden>
                  {{ __('SelectanOption') }}
                </option>
                @if(!empty($childcategory))
                @foreach($childcategory as $caat)
                <option {{ $cor->childcategory_id == $caat->id ? 'selected' : "" }} value="{{ $caat->id }}">{{ $caat->title }}</option>
                @endforeach
                @endif
              </select>
            </div>
            <div class="col-md-3">
              <label for="exampleInputSlug">{{ __('Instructor') }}<span class="redstar">*</span></label>
              <select name="user_id" class="form-control select2 col-md-7 col-xs-12" id="user_id">
                <option value="" selected hidden disabled>{{ __('SelectanOption') }}</option>
                @if(Auth::user()->role == 'admin')
                @foreach($users as $user)
                <option {{ $cor->user_id == $user->id ? 'selected' : "" }} value="{{ $user->id }}">{{ $user->fname }} {{$user->lname}}</option>
                @endforeach
                @else
                <option {{ $cor->user_id == Auth::user()->id ? 'selected' : "" }} value="{{ Auth::user()->id }}">{{ Auth::user()->fname }}</option>
                @endif
              </select>
              <div class="redstar user_id"></div>
            </div>
          </div>
          <br>

          @php
          $category = App\Categories::all();
          @endphp


          <div class="col-md-12">
            <div class="form-group">
              <label>{{ __("Also in :") }}</label>
              <select multiple="multiple" name="other_cats[]" id="other_cats" class="form-control select2">
                @php
                $category = App\Categories::all();
                @endphp

                @foreach($category as $caat)
                <option {{in_array($caat->id, $cor->other_cats ?: []) ? "selected": ""}} value="{{ $caat->id }}">{{ $caat->title }}</option>
                <!-- <option {{ $cor->category_id == $caat->id ? 'selected' : "" }} value="{{ $caat->id }}">{{ $caat->title }}</option> -->
                @endforeach
              </select>

              <small class="text-primary">
                <i class="feather icon-help-circle"></i> {{ __("If in list primary category is also present then it will auto remove from this after create product.") }}
              </small>
            </div>
          </div>

          <div class="row">
            <div class="col-md-4">
              @php
              $languages = App\CourseLanguage::where('status','1')->get();
              @endphp
              <label for="exampleInputSlug">{{ __('Language') }}: <span class="redstar">*</span></label>
              <select name="language_id" class="form-control select2 col-md-7 col-xs-12" id="language_id">
                <option value="" selected disabled hidden>
                  {{ __('SelectanOption') }}
                </option>
                @foreach($languages as $cat)
                <option {{ $cor->language_id == $cat->id ? 'selected' : "" }} value="{{ $cat->id }}">{{ $cat->name }}</option>
                @endforeach
              </select>
              <div class="redstar language_id"></div>
            </div>


            <div class="col-md-4">

              @php
              $ref_policy = App\RefundPolicy::where('status','1')->get();
              @endphp
              <label for="exampleInputSlug">{{ __('Select Refund Policy') }}</label>
              <select name="refund_policy_id" class="form-control select2 col-md-7 col-xs-12">
                <option value="none" selected disabled hidden>
                  {{ __('SelectanOption') }}
                </option>
                @foreach($ref_policy as $ref)
                <option {{ $cor->refund_policy_id == $ref->id ? 'selected' : "" }} value="{{ $ref->id }}">{{ $ref->name }}</option>
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
                <option value="" selected disabled hidden>
                  {{ __('SelectanOption') }}
                </option>
                @foreach($institute as $inst)
                <option value="{{ $inst->id }}" {{$inst->id  == $cor->institude_id ? 'selected' : ''}}>{{ $inst->title }}</option>
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
                $institute = App\Institute::where('status' ,'1')->where('user_id',Auth::user()->id)->get();
                @endphp
                <option value="" selected disabled hidden>
                  {{ __('SelectanOption') }}
                </option>
                @foreach($institute as $inst)
                <option value="{{ $inst->id }}" {{$inst->id  == $cor->institude_id ? 'selected' : ''}}>{{ $inst->title }}</option>
                @endforeach
              </select>
              <div class="redstar institude_id"></div>
            </div>
            @endif
          </div>


          <div class="row">

            <div class="col-md-6">
              <label for="exampleInputTit1e">{{ __('Title') }}:<sup class="redstar">*</sup></label>
              <input type="text" class="form-control" name="title" id="exampleInputTitle" value="{{ $cor->title }}">
              <div class="redstar exampleInputTitle"></div>
            </div>
            

            <div class="col-md-6">
              <label for="exampleInputSlug">{{ __('Slug') }}: <sup class="redstar">*</sup></label>
              <input  type="text" class="form-control" name="slug" value="{{ $cor->slug}}" id="slug" >
              <div class="redstar slug"></div>
            </div>
            
          </div>
          <br>

          <div class="row">
            <div class="col-md-6">
              <label for="exampleInputDetails">{{ __('Short Detail') }}:<sup class="redstar">*</sup></label>
              <textarea name="short_detail" id="short_detail" rows="3" class="form-control">{!! $cor->short_detail !!}</textarea>
              <div class="redstar short_detail"></div>
            </div>
            <div class="col-md-6">
              <label for="exampleInputDetails">{{ __('Requirements') }}:<sup class="redstar">*</sup></label>
              <textarea name="requirement" rows="3" class="form-control" id="requirement" >{!! $cor->requirement !!}</textarea>
              <div class="redstar requirement"></div>
            </div>
            
          </div>
          <br>


          <br>
          

          <div class="row">
            @if(Auth::User()->role == "admin")
            <div class="col-md-6">
              <label for="exampleInputSlug">{{ __('Level/Type Tags') }}</label>
              <select class="form-control js-example-basic-single" name="level_tags">
                <option value="0" disabled hidden>
                  {{ __('SelectanOption') }}
                </option>

                <option {{ $cor->level_tags == 'trending' ? 'selected' : ''}} value="trending">{{ __('Trending') }}</option>

                <option {{ $cor->level_tags == 'onsale' ? 'selected' : ''}} value="onsale">{{ __('Onsale') }}</option>

                <option {{ $cor->level_tags == 'bestseller' ? 'selected' : ''}} value="bestseller">{{ __('Bestseller') }}</option>

                <option {{ $cor->level_tags == 'beginner' ? 'selected' : ''}} value="beginner">{{ __('Beginner') }}</option>

                <option {{ $cor->level_tags == 'intermediate' ? 'selected' : ''}} value="intermediate">{{ __('Intermediate') }}</option>

                <option {{ $cor->level_tags == 'expert' ? 'selected' : ''}} value="expert">{{ __('Expert') }}</option>

              </select>

            </div>
             @endif
            <div class="col-md-6">
              <label for="exampleInputSlug">{{ __('Course Tags') }}<sup class="redstar">*</sup></label>
              <select class="select2-multi-select form-control" name="course_tags[]" multiple="multiple" size="5" id="course_tags">


                @if(is_array($cor['course_tags']) || is_object($cor['course_tags']))

                @foreach($cor['course_tags'] as $cat)

                <option value="{{ $cat }}" {{in_array($cat, $cor['course_tags'] ?: []) ? "selected": ""}}>{{ $cat }}
                </option>


                @endforeach
               

              </select>
              <div class="redstar course_tags"></div>
            </div>
          </div>
          <br>
          <br>

          @endif



          <div class="row">
            <div class="col-md-12">
              <label for="exampleInputDetails">{{ __('Detail') }}:<sup class="redstar">*</sup></label>
              <textarea id="detail" name="detail" rows="3" class="form-control">{!! $cor->detail !!}</textarea>
              <div class="redstar detail"></div>
            </div>
          </div>
          <br>


          <!-- country start -->
          <div class="row">
            <div class="col-md-12">

              <label>{{ __('Country') }}: <span></span></label>
              <select class="select2-multi-select-tf form-control" name="country[]" multiple="multiple">
                @foreach($countries as $country)
                <option {{in_array($country->name, $cor->country ?: []) ? "selected": ""}} value="{{ $country->name }}">{{ $country->name }}</option>
                @endforeach
              </select>

              <small class="text-info"><i class="fa fa-question-circle"></i> ({{ __('Select those countries where you want to block courses')}} )</small>

            </div>
          </div>
          <br>
          <!-- country end -->

          <div class="row">
            {{-- <div class="col-md-3 display-none">
                  <label for="exampleInputDetails">{{ __('MoneyBack') }}:</label><br>
            <label class="switch">
              <input class="slider" type="checkbox" id="customSwitch1" name="money" {{ $cor->day != '' ? 'checked' : '' }} />
              <span class="knob"></span>
            </label>

            <br>

            <div style="{{ $cor->day == 1 ? '' : 'display:none' }}" id="jeet">
              <label for="exampleInputSlug">{{ __('Days') }}:<sup class="redstar">*</sup></label>
              <input type="number" min="1" class="form-control" name="day" id="exampleInputPassword1" placeholder="{{ __('Enter') }} day" value="{{ $cor->day }}">
            </div>
          </div> --}}
          <div class="col-md-3">
            <label for="exampleInputDetails">{{ __('Paid') }}:</label><br>
            <label class="switch">
              <input class="slider" type="checkbox" id="customSwitch2" name="type" {{ $cor->type == '1' ? 'checked' : '' }} />
              <span class="knob"></span>
            </label>

            <br>

            <div style="{{ $cor->type == 1 ? '' : 'display:none' }}" id="doabox">
              <label for="exampleInputSlug">{{ __('Price') }}: <sup class="redstar">*</sup></label>
              <input step="0.01" type="text" inputmode="numeric" pattern="[-+]?[0-9]*[.,]?[0-9]+" class="form-control" name="price" id="priceMain" placeholder="{{ __('Enter') }} {{ __('Price') }}" value="{{ $cor->price }}" >
              <div class="redstar priceMain"></div>
              <br>
              <label for="exampleInputSlug">{{ __('Discount Price') }}: </label>
              <input step="0.01" type="text" inputmode="numeric" pattern="[-+]?[0-9]*[.,]?[0-9]+" class="form-control" name="discount_price" id="exampleInputPassword1" placeholder="{{ __('Enter') }} {{ __('DiscountPrice') }}" value="{{ $cor->discount_price }}">
            </div>
          </div>

          <div class="col-md-3">
            @if(Auth::User()->role == "admin")
            <label for="exampleInputTit1e">{{ __('Featured') }}:</label><br>
            <label class="switch">
              <input class="slider" type="checkbox" id="customSwitch6" name="featured" {{ $cor->featured==1 ? 'checked' : '' }} />
              <span class="knob"></span>
            </label>

            @endif
          </div>
          <div class="col-md-3">
            @if(Auth::User()->role == "admin")
            <label for="exampleInputTit1e">{{ __('Status') }}:</label><br>
            <label class="switch">
              <input class="slider" type="checkbox" id="customSwitch6" name="status" {{ $cor->status==1 ? 'checked' : '' }} />
              <span class="knob"></span>
            </label>


            @endif
          </div>
          <div class="row">
            <div class="col-md-4">
              <label for="exampleInputDetails">{{ __('Instructor Involvement Request') }}:</label><br>
              <label class="switch">
                <input class="slider" type="checkbox" id="customSwitch6" name="involvement_request" {{ $cor->involvement_request==1 ? 'checked' : '' }} />
                <span class="knob"></span>
              </label>


            </div>
          </div>
          <br>


          <div class="col-md-4">
            <label for="exampleInputDetails">{{ __('Preview Video') }}:</label><br>
            <label class="switch">
              <input class="slider previdtype" type="checkbox" id="customSwitch61" name="preview_type" {{ $cor->preview_type=="video" ? 'checked' : '' }} />


              <span class="knob"></span>
            </label>




            <div style="{{ $cor->preview_type == 'url' ? 'display:none' : '' }}" id="document1">
              <br>
              <label for="exampleInputSlug">{{ __('Upload Video') }}: <sup class="redstar">*</sup></label>
              <!-- -------------- -->
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text" id="inputGroupFileAddon01">{{ __('Upload') }}</span>
                </div>
                <div class="custom-file">
                  <input type="file" class="custom-file-input" id="inputGroupFile01" name="video" value="{{ $cor->video }}" aria-describedby="inputGroupFileAddon01" accept=".mp4,.avi,.wmv">
                  <label class="custom-file-label" for="inputGroupFile01">{{ __('Choose file') }}</label>
                  <div class="redstar inputGroupFile01"></div>
                </div>
              </div>
              @if($cor->video !="")
              <video src="{{ asset('video/preview/'.$cor->video) }}" width="200" height="150" controls>
              </video>
              @endif
              <!-- -------------- -->
            </div>

            <div @if($cor->preview_type =="video") class="display-none" @endif id="document2">
              <br>
              <label for="exampleInputSlug">{{ __('URL') }}: <sup class="redstar">*</sup></label>
              <input type="url" class="form-control" placeholder="{{ __('Enter') }} URL" name="url" id="url" value="{{ $cor->url }}">
            </div>
          </div>

          <div class="col-md-4">
            <label for="">{{ __('Duration') }}: </label><br>
            <label class="switch">
              <input class="slider" type="checkbox" name="duration_type" {{ $cor->duration_type == "m" ? 'checked' : '' }} />
              <span class="knob"></span>
            </label>
            <br>
            <small class="text-info"><i class="fa fa-question-circle"></i> {{ __('If enabled duration can be in months') }}.</small><br>
            <small class="text-info"> {{ __('when Disabled duration can be in days') }}.</small>

            <br>
            <label for="exampleInputSlug">{{ __('Course Expire Duration') }}<sup class="redstar">*</sup></label>
            <input min="1" class="form-control" name="duration" type="number" id="duration" value="{{ $cor->duration }}" placeholder="{{ __('Enter') }} {{ __('Duration') }}" >
            <div class="redstar duration"></div>
          </div>
          
      </div>
      <br>

      <div class="row">

        @if(Auth::user()->role == 'instructor')
        <div class="col-md-6">
          <label>{{ __('PreviewImage') }}:size: 270x200</label>
          <br>
          <!-- ====================== -->
          <div class="input-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text" id="inputGroupFileAddon01">{{ __('Upload') }}</span>
            </div>
            <div class="custom-file">
              <input type="file" class="custom-file-input" id="inputGroupFile01" name="preview_image" value="{{ $cor->preview_image }}">
              <label class="custom-file-label" for="inputGroupFile01">{{ __('Choose file') }}</label>
              <div class="redstar inputGroupFile01"></div>
            </div>
          </div>
          @if($cor['preview_image'] !== NULL && $cor['preview_image'] !== '')
          <img src="{{ url('/images/course/'.$cor->preview_image) }}" height="70px;" width="70px;" />
          @else
          <img src="{{ Avatar::create($cor->title)->toBase64() }}" alt="course" class="img-fluid">
          @endif
          <!-- ====================== -->
          <br>
        </div>

        @endif

        @if(Auth::user()->role == 'admin')

        <div class="col-md-6">
          <div class="form-group">
            <label class="control-label" for="first-name">{{ __('Image') }} <span class="redstar">*</span> </label>

            <div class="input-group">

              <input readonly id="image" name="preview_image" type="text" class="form-control" value="{{$cor['preview_image'] != NULL ? $cor['preview_image'] : '' }}">
              <div class="input-group-append">
                <span data-input="image" class="bg-primary text-light midia-toggle input-group-text">{{ __('Browse') }}</span>
              </div>
            </div>

            <small class="text-info"> <i class="text-dark feather icon-help-circle"></i>({{ __('Choose Image for 
                          post') }})</small>
            <br>

            @if($cor['preview_image'] !== NULL && $cor['preview_image'] !== '')
            <img src="{{ url('/images/course/'.$cor->preview_image) }}" height="70px;" width="70px;" />
            @else
            <img src="{{ Avatar::create($cor->title)->toBase64() }}" alt="course" class="img-fluid">
            @endif
          </div>
        </div>

        @endif




        <div class="col-md-6">
          @if(Auth::User()->role == "admin")
          <label for="Revenue">{{ __('Instructor Revenue') }}:</label>

          <div class="input-group">

            <input min="1" max="100" class="form-control" name="instructor_revenue" type="number" value="{{ $cor['instructor_revenue'] }}" id="revenue" placeholder="Enter revenue percentage" class="{{ $errors->has('instructor_revenue') ? ' is-invalid' : '' }} form-control">
            <span class="input-group-addon"><i class="fa fa-percent"></i></span>
          </div>
          @endif
        </div>
      </div>
      <br>

      <div class="row">
        <div class="col-sm-3">

          <label for="exampleInputDetails">{{ __('Assignment') }}:</label><br>
          <label class="switch">
            <input class="slider" type="checkbox" name="assignment_enable" {{ $cor['assignment_enable']=="1" ? 'checked' : '' }} />
            <span class="knob"></span>
          </label>
          <br>
          <small class="text-info"><i class="fa fa-question-circle"></i> {{ __('To enable assignment on portal') }}
          </small>

        </div>

        <div class="col-sm-3">

          <label for="exampleInputDetails">{{ __('Appointment') }}:</label><br>
          <label class="switch">
            <input class="slider" type="checkbox" name="appointment_enable" {{ $cor['appointment_enable']=="1" ? 'checked' : '' }} />
            <span class="knob"></span>
          </label>

        </div>

        <div class="col-sm-3">

          <label for="exampleInputDetails">{{ __('Certificate Enable') }}:</label><br>
          <!--  -->
          <label class="switch">
            <input class="slider" type="checkbox" name="certificate_enable" id="customSwitch10" {{ $cor['certificate_enable'] == "1" ? 'checked' : '' }} />
            <span class="knob"></span>
          </label>

        </div>

        <div class="col-sm-3">

          <label for="">{{ __('Drip Content') }}: </label><br>
          <label class="switch">
            <input class="slider" type="checkbox" name="drip_enable" {{ $cor['drip_enable'] == 1 ? 'checked' : '' }} />
            <span class="knob"></span>
          </label>
          <br>
          <small class="text-info"><i class="fa fa-question-circle"></i> {{ __('To release content on chapter & classes by a specific date or amount of days after enrollment') }}.
          </small>
        </div>
      </div>
      <br>
      <br>
      <br>

      <div class="box-footer">
        <button type="submit" class="btn btn-lg col-md-3 btn-primary-rgba loaderenable">{{ __('Save') }}</button>
      </div>

      </form>
    </div>
  </div>
</div>
</div>
<!-- edit media Modal start -->

<!-- edit media Model ended -->
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
      var slug = $("#slug").val();
      var short_detail = $("#short_detail").val();
      var requirement = $("#requirement").val();
      var preview_image = $("#inputGroupFile01").val();
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
      if ($("#customSwitch2").prop('checked')==true){ 
        var priceMain = $("#priceMain").val();
        if(priceMain == "" || priceMain == undefined)
        {
          $(".redstar.priceMain").html("Price field is required");
          var divLoc = $('.redstar.priceMain').offset();
          myscrollfunc(divLoc);
          return false;
        }
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
        $('#f').val(+$(this).prop('checked'))
      })
    })

    $(function() {
      $('#cb3').change(function() {
        $('#test').val(+$(this).prop('checked'))
      })
    })

    $(function() {

      $('#murl').change(function() {
        if ($('#murl').val() == 'yes') {
          $('#doab').show();
        } else {
          $('#doab').hide();
        }
      });

    });

    $(function() {

      $('#murll').change(function() {
        if ($('#murll').val() == 'yes') {
          $('#doabb').show();
        } else {
          $('#doab').hide();
        }
      });

    });

    $('#customSwitch2').change(function() {
      if ($('#customSwitch2').is(':checked')) {
        $('#doabox').show('fast');

        $('#priceMain').prop('required', 'required');

      } else {
        $('#doabox').hide('fast');

        $('#priceMain').removeAttr('required');
      }

    });

    $('#customSwitch61').on('change', function() {

      if ($('#customSwitch61').is(':checked')) {
        $('#document1').show('fast');
        $('#document2').hide('fast');

      } else {
        $('#document2').show('fast');
        $('#document1').hide('fast');
      }

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
              up.append('<option value="0">Please Choose</option>');
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
              up.append('<option value="0">Please Choose</option>');
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
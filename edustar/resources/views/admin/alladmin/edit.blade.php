@extends('admin.layouts.master')
@section('title','Edit Admin')
@section('stylesheet')
  <style type="text/css">
      .toggle-password{
            position: absolute;
            top: 65px;
            right: 15px; 
        }
      .toggle-password1{
          position: absolute;
          top: 65px;
          right: 15px; 
      }
      #phone_code .select2.select2-container.select2-container--default{
            width: 120px!important;
        }
  </style>
@endsection

@section('maincontent')

@component('components.breadcumb',['thirdactive' => 'active'])

@slot('heading')
{{ __('Home') }}
@endslot

@slot('menu1')
{{ __('Admin') }}
@endslot

@slot('menu2')
{{ __(' Edit Admin') }}
@endslot

@slot('button')
<div class="col-md-4 col-lg-4">
  <a href="{{ route('alladmin.index') }}" class="float-right btn btn-primary-rgba mr-2"><i
      class="feather icon-arrow-left mr-2"></i>{{ __('Back') }}</a>
</div>
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
    <div class="col-lg-12">
      <div class="card m-b-30">
        <div class="card-header">
          <h5 class="box-title">{{ __('Edit') }} {{ __('Admin') }}</h5>
        </div>
        <div class="card-body ml-2">
          <form action="{{ route('alladmin.update',$user->id) }}" method="POST" enctype="multipart/form-data">
            {{ csrf_field() }}
            {{ method_field('PUT') }}
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="fname">
                    {{ __('First Name') }}:
                    <sup class="text-danger">*</sup>
                  </label>
                  <input value="{{ $user->fname }}" autofocus required name="fname" type="text" class="form-control"
                    placeholder="{{ __('Please') }} {{ __('Enter') }} {{ __('First Name') }}" />
                </div>
               

                <div class="form-group">
                  <label for="mobile"> {{ __('Mobile') }}:</label>
                  <div class="d-flex " id="phone_code">
                      <select name="phone_code" class="phone_code select2" required>
                          @foreach ($countries as $country)
                              <option value="+{{$country->phonecode}}" {{$user->phone_code == $country->phonecode ? 'selected':''}}>+{{ $country->phonecode }}</option>
                          @endforeach
                      </select>
                      <input value="{{ $user->mobile }}" type="text" name="mobile"
                        placeholder="{{ __('Enter') }} {{ __('Mobile') }}"
                        class="form-control">
                  </div>
                </div>
                
                <div class="form-group">
                  <label for="address">{{ __('Address') }}: </label>
                  <textarea name="address" class="form-control" rows="1"
                    placeholder="{{ __('Enter') }} {{ __('address') }}" value="">{{ $user->address }}</textarea>
                </div>
                 <div class="form-group">
                  <label for="city_id">{{ __('State') }}:</label>
                  <select id="upload_id" class="form-control select2" name="state_id">
                    <option value="none" selected disabled hidden>
                      {{ __('Select an Option') }}
                    </option>
                    @foreach ($states as $s)
                    <option value="{{ $s->id}}" {{ $user->state_id==$s->id ? 'selected' : '' }}>
                      {{ $s->name}}
                    </option>
                    @endforeach

                  </select>
                </div>
                <div class="form-group">
                  <label for="pin_code">{{ __('Pincode') }}:</label>
                  <input value="{{ $user->pin_code }}"
                    placeholder="{{ __('Enter') }} {{ __('Pincode') }}" type="text"
                    name="pin_code" class="form-control">
                </div>
                <div class="form-group">
                  <label for="role">{{ __('Select Role') }}:</label>
                  @if(Auth::User()->role=="admin")
                  <select class="form-control select2" name="role">
                    <option {{ $user->role == 'admin' ? 'selected' : ''}} value="admin">{{ __('Admin') }}
                    </option>
                  </select>
                   
                  @endif
                 
                </div>
               
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="lname">
                    {{ __('Last Name') }}:
                    <sup class="text-danger">*</sup>
                  </label>
                  <input value="{{ $user->lname }}" required name="lname" type="text" class="form-control"
                    placeholder="{{ __('Enter') }} {{ __('Last Name') }}" />
                </div>
            
                <div class="form-group">
                  <label for="mobile">{{ __('Email') }}:<sup class="text-danger">*</sup> </label>
                  <input value="{{ $user->email }}" required type="email" name="email"
                    placeholder="{{ __('Enter') }} {{ __('Email') }}"
                    class="form-control">
                </div>
                <div class="form-group">
                  <label for="city_id">{{ __('Country') }}:</label>
                  <select id="country_id" class="form-control select2" name="country_id">
                    <option value="none" selected disabled hidden>
                      {{ __('Select an Option') }}
                    </option>

                    @foreach ($countries as $coun)
                    <option value="{{ $coun->id }}"
                      {{ $user->country_id == $coun->id ? 'selected' : ''}}>
                      {{ $coun->nicename }}
                    </option>
                    @endforeach
                  </select>
                </div>
               
                <div class="form-group">
                  <label for="city_id">{{ __('City') }}:</label>
                  <select id="grand" class="form-control select2" name="city_id">
                    <option value="none" selected disabled hidden>
                      {{ __('Select an Option') }}
                    </option>
                    @foreach ($cities as $c)
                    <option value="{{ $c->id }}" {{ $user->city_id == $c->id ? 'selected' : ''}}>{{ $c->name }}
                    </option>
                    @endforeach
                  </select>
                </div>
               
                

               
                <div class="form-group">
                  <label>{{ __('Image') }}:<sup class="redstar">*</sup></label>
                  <small class="text-muted"><i class="fa fa-question-circle"></i>
                    {{ __('Recommended-size') }} (410 x 410px)</small>
                  <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text" id="inputGroupFileAddon01">{{ __('Upload') }}</span>
                    </div>
                    <div class="custom-file">
                      <input type="file" class="custom-file-input" id="inputGroupFile01" name="user_img"
                        aria-describedby="inputGroupFileAddon01" accept=".jpg,.jpeg,.png,.bmp,.tiff">
                      <label class="custom-file-label" for="inputGroupFile01">{{ __('Choose file') }}</label>
                    </div>
                  </div>
                  @if($user->user_img != null || $user->user_img !='')
                  <div class="edit-user-img">
                    <img src="{{ url('/images/user_img/'.$user->user_img) }}"  alt="User Image" class="img-responsive image_size">
                  </div>
                  @else
                  <div class="edit-user-img">
                    <img src="{{ asset('images/default/user.jpg')}}"  alt="User Image" class="img-responsive img-circle">
                  </div>
                  @endif
                </div>
                

              </div>
               <div class="form-group">
                  <label for="detail">{{ __('Detail') }}:<sup class="text-danger">*</sup></label>
                  <textarea id="detail" name="detail" class="form-control" rows="5"
                    placeholder="{{ __('Enter') }} {{ __('Detail') }}"
                    value="">{{ $user->detail }}</textarea>
                </div>
            </div>

            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                    <label for="fb_url">
                      {{ __('Facebook Url') }}:
                    </label>
                    <input autofocus name="fb_url" value="{{ $user->fb_url }}" type="text" class="form-control"
                      placeholder="Facebook.com/" />
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="youtube_url">
                      {{ __('Youtube Url') }}:
                    </label>
                    <input autofocus name="youtube_url" value="{{ $user->youtube_url }}" type="text" class="form-control"
                      placeholder="youtube.com/" />

                  </div>
                </div>
                <div class="col-md-6">

                   <div class="form-group">
                    <label for="twitter_url">
                      {{ __('Twitter Url') }}:
                    </label>
                    <input autofocus name="twitter_url" value="{{ $user->twitter_url }}" type="text" class="form-control"
                      placeholder="Twitter.com/" />
                  </div>
                </div>
                <div class="col-md-6">

                  <div class="form-group">
                    <label for="linkedin_url">
                      {{ __('Linkedin Url') }}:
                    </label>
                    <input autofocus name="linkedin_url" value="{{ $user->linkedin_url }}" type="text"
                      class="form-control" placeholder="Linkedin.com/" />
                  </div>
              </div>
              
              <div class="col-md-4">
                  <div class="form-group">
                    <label for="exampleInputDetails">{{ __('Verified') }}:<sup class="redstar text-danger">*</sup></label><br>
                    <input id="verified" type="checkbox" class="custom_toggle" name="verified" {{  $user->email_verified_at != NULL ? 'checked' : '' }} />
                   

                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="exampleInputTit1e">{{ __('Status') }}:<sup
                        class="text-danger">*</sup></label><br>
                    <input type="checkbox" class="custom_toggle stch{{ $user->id }}" name="status" onchange="checkstatus({{ $user->id }})"
                      {{ $user->status == '1' ? 'checked' : '' }} />

                  </div>
              </div>
              <div class="col-md-4">
                                
                <div class="form-group">
                  

                  <div class="row">
                    <div class="col-md-12">
                      <div class="update-password">
                        <label for="box1"> {{ __('Update Password') }}:</label>
                        <br>
                        <input type="checkbox" id="myCheck" name="update_pass" class="custom_toggle" onclick="myFunction()">
                      </div>
                    </div>
                  </div>


                  <div style="display: none" id="update-password">
                  <div class="form-group position-relative">
                    <label>{{ __('Password') }}</label>
                    <input type="password" name="password" class="form-control" id="password"
                      placeholder="{{ __('Enter') }} {{ __('Password') }}">
                    <span toggle="#password-field" class="fa fa-fw fa-eye field_icon toggle-password"></span>
                  </div>
               
              
                <div class="form-group position-relative" >
                  <label>{{ __('Confirm Password') }}</label>
                  <input type="password" name="confirmpassword" class="form-control" id="password1"
                    placeholder="{{ __('Confirm Password') }}">
                  <span toggle="#password-field" class="fa fa-fw fa-eye field_icon toggle-password1"></span>
                </div>

              </div>
               
              </div>
               
              </div>
            </div>

           
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
@endsection
@section('scripts')
<script>
  function checkstatus(id)
  {
    if($(".stch"+id).prop("checked") != true)
    {
      $.ajax({
          type: "GET",
          dataType: "json",
          url: "{{ route('user.status') }}",
          data: {
              'status': 0,
              'id': id
          },
          success: function(data)
          { 
              if(data.msg == undefined)
              {
                  var warning = new PNotify( {
                      title: 'success', text:'Status Update Successfully', type: 'success', desktop: {
                      desktop: true, icon: 'feather icon-thumbs-down'
                      }
                  });
                  warning.get().click(function() {
                      warning.remove();
                  });
              }
              else
              {
                  alert("You can't change this user status. because, This user already used in some course.");
                  $(".stch"+id).trigger("click");
              }
          }
      });
    }
  }
  (function ($) {
    "use strict";

    $(function () {
      $("#dob,#doa").datepicker({
        changeYear: true,
        yearRange: "-100:+0",
        dateFormat: 'yy/mm/dd',
      });
    });


    $('#married_status').change(function () {

      if ($(this).val() == 'Married') {
        $('#doaboxxx').show();
      } else {
        $('#doaboxxx').hide();
      }
    });

    $(function () {
      var urlLike = '{{ url('country/dropdown') }}';
      $('#country_id').change(function () {
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
            success: function (data) {
              console.log(data);
              up.append('<option value="0">Please Choose</option>');
              $.each(data, function (id, title) {
                up.append($('<option>', {
                  value: id,
                  text: title
                }));
              });
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
              console.log(XMLHttpRequest);
            }
          });
        }
      });
    });

    $(function () {
      var urlLike = '{{ url('country/gcity') }}';
      $('#upload_id').change(function () {
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
            success: function (data) {
              console.log(data);
              up.append('<option value="0">Please Choose</option>');
              $.each(data, function (id, title) {
                up.append($('<option>', {
                  value: id,
                  text: title
                }));
              });
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
              console.log(XMLHttpRequest);
            }
          });
        }
      });
    });

  })(jQuery);
</script>


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
<script type="text/javascript">
    $(document).on('click', '.toggle-password', function() {
        var input = $("#password");
        input.attr('type') === 'password' ? input.attr('type','text') : input.attr('type','password');
        $(".toggle-password").Class("fa-eye fa-eye-slash");
    });
    $(document).on('click', '.toggle-password1', function() {
        var input = $("#password1");
        input.attr('type') === 'password' ? input.attr('type','text') : input.attr('type','password');
        $(".toggle-password1").toggleClass("fa-eye fa-eye-slash");
    });
</script>
@endsection
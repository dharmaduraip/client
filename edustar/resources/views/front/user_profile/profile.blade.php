@extends('theme.master')
@section('title', 'Profile & Setting')
@section('custom-head')
    <style type="text/css">
        .toggle-password{
            position: absolute;
            top: 38px;
            right: 30px; 
        }
        .toggle-password1{
            position: absolute;
            top: 38px;
            right: 30px; 
        }
        #phone_code .select2-container--default .select2-selection--single .select2-selection__arrow b{
        	margin-top: -14px;
        }
        #phone_code .select2.select2-container.select2-container--default{
        	width: 100px!important;
        }
        #phone_code .select2-container--default .select2-selection--single{
            height: calc(1.6em + 0.7rem + 1px) !important;
        }
        #phone_code .select2-selection__rendered{
        	margin-top: -4px;
        }
    </style>
@endsection
@section('content')
@include('admin.message')
<!-- about-home start -->
@php
$gets = App\Breadcum::first();
@endphp
@if(isset($gets))
<section id="business-home" class="business-home-main-block">
    <div class="business-img">
        @if($gets['img'] !== NULL && $gets['img'] !== '')
        <img src="{{ url('/images/breadcum/'.$gets->img) }}" class="img-fluid" alt="" />
        @else
        <img src="{{ Avatar::create($gets->text)->toBase64() }}" alt="{{ __('course')}}" class="img-fluid">
        @endif
    </div>
    <div class="overlay-bg"></div>
    <div class="container-xl">
        <div class="business-dtl">
            <div class="row">
                <div class="col-lg-6">
                    <div class="bredcrumb-dtl">
                        <h1 class="wishlist-home-heading">{{ __('User Profile') }}</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endif
<!-- profile update start -->
<section id="profile-item" class="profile-item-block">
    <div class="container-xl">
    	<form action="{{ route('user.profile',$orders->id) }}" method="POST" enctype="multipart/form-data">
        	{{ csrf_field() }}
            {{ method_field('PUT') }}

	        <div class="row">
	            <div class="col-xl-3 col-lg-4 col-md-4">
	                <div class="dashboard-author-block text-center">
	                    <div class="author-image">
						    <div class="avatar-upload">
						        <div class="avatar-edit">
						            <input type='file' id="imageUpload" name="user_img" accept=".png, .jpg, .jpeg" />
						            <label for="imageUpload"><i class="fa fa-pencil"></i></label>
						        </div>
						        <div class="avatar-preview">
						        	@if(Auth::User()->user_img != null || Auth::User()->user_img !='')
							            <img class="avatar-preview-img" id="imagePreview" src="{{ url('/images/user_img/'.Auth::User()->user_img) }}">
							           
							        @else
							        	<img class="avatar-preview-img" id="imagePreview" src="{{ asset('images/default/user.jpg')}}">
							           
							        @endif
						        </div>
						    </div>
	                    </div>
	                    <div class="author-name">{{ Auth::User()->fname }}&nbsp;{{ Auth::User()->lname }}</div>
	                </div>
	                <div class="dashboard-items">
	                    <ul>
	                        <li>
								<i class="fa fa-bookmark"></i>
								<a href="{{ route('mycourse.show') }}" title="{{ __('My Courses')}}">{{ __('My Courses') }}</a>
							</li>
	                        <li>
								<i class="fa fa-heart"></i>
								<a href="{{ route('wishlist.show') }}" title="{{ __('My wishlist')}}">{{ __('My Wishlist') }}</a>
							</li>
	                        <li>
								<i class="fa fa-history"></i>
								<a href="{{ route('purchase.show') }}" title="{{ __('Purchase History')}}">{{ __('Purchase History') }}</a>
							</li>
	                        <li>
								<i class="fa fa-user"></i>
								<a href="{{route('profile.show',Auth::User()->id)}}" title="{{ __('User Profile')}}">{{ __('User Profile') }}</a>
							</li>
	                        @if(Auth::User()->role == "user")
	                        <li>
								<i class="fa fa-user-circle-o" aria-hidden="true"></i>
								<a href="#" data-toggle="modal" data-target="#myModalinstructor" title="{{ __('Become An Instructor') }}">{{ __('Become An Instructor') }}</a>
							</li>
	                        @endif
	                        <li>
								<i class="fa fa-bank"></i>
								<a href="{{ url('bankdetail') }}" title="{{ __('My Bank Details') }}">{{ __('My Bank Details') }}</a>
							</li>

	                        <li>
								<i class="fa fa-check"></i>
								<a href="{{ route('2fa.show') }}" title="{{ __('2 Factor Auth') }}">{{ __('2 Factor Auth') }}</a>
							</li>
							<li>
								<i class="fa fa-check"></i>
								<a href="{{ route('verifaction') }}" title="{{ __('Verification') }}">{{ __('Verification') }}</a>
							</li>
	                    </ul>
	                </div>
	            </div>
	            <div class="col-xl-9 col-lg-8 col-md-8">

	                <div class="profile-info-block">
	                    <div class="profile-heading">{{ __('Personal Info') }}</div>
	                    <div class="row">
	                        <div class="col-lg-6">
	                            <div class="form-group">
	                                <label for="name">{{ __('First Name') }}<sup class="text-danger">*</sup></label>
	                                <input type="text" id="name" name="fname" class="form-control" placeholder="{{ __('Enter First Name') }}" value="{{ $orders->fname }}" required>
	                            </div>
	                            <div class="form-group">
	                                <label for="email">{{ __('Email') }}<sup class="text-danger">*</sup></label>
	                                <input type="email" id="email" name="email" class="form-control" placeholder="info@example.com" required value="{{ $orders->email }}" >
	                            </div>
	                           
	                        </div>
	                        <div class="col-lg-6">
	                            <div class="form-group">
	                                <label for="Username">{{ __('Last Name') }}<sup class="text-danger">*</sup></label>
	                                <input type="text" id="lname" name="lname" class="form-control" placeholder="{{ __('Enter Last Name') }}" value="{{ $orders->lname }}" required>
	                            </div>
	                            <div class="form-group">
	                                <label for="mobile">{{ __('Mobile') }}<sup class="text-danger">*</sup></label>
	                                <div class="d-flex" id="phone_code">
		                                <select name="phone_code"  class="phone_code select2" required>
	                                        @foreach ($countries as $country)
	                                            <option value="+{{$country->phonecode}}" {{$orders->phone_code == $country->phonecode ? 'selected':''}}>+{{ $country->phonecode }}</option>
	                                        @endforeach
	                                    </select>
		                                <input type="text" name="mobile" id="mobile" value="{{ $orders->mobile }}" class="form-control" placeholder="{{ __('Enter Mobile No') }}">
	                                </div>
	                            </div>
	                           
	                            
	                        </div>
	                    </div>

	                    <div class="form-group">
	                        <label for="bio">{{ __('address') }}</label>
	                        <textarea id="address" name="address" class="form-control" placeholder="{{ __('Enter your Address') }}" value="">{{ $orders->address }}</textarea>
	                    </div>
	                    <br>

	                    <div class="row">
	                        <div class="col-lg-4">
	                        	<div class="form-group">
	                                <label for="city_id">{{ __('Country') }}:</label>
					                <select id="country_id" class="form-control js-example-basic-single" name="country_id">
					                  	<option value="none" selected disabled hidden> 
					                      {{ __('Select an Option') }}
					                    </option>
					                  
					                  @foreach ($countries as $coun)
					                    <option value="{{ $coun->id }}" {{ $orders->country_id == $coun->id ? 'selected' : ''}}>{{ $coun->nicename }}
					                    </option>
					                  @endforeach
					                </select>
	                            </div>
	                        </div>
	                        <div class="col-lg-4">
	                        	<div class="form-group">
	                        		<label for="city_id">{{ __('State') }}:</label>
					                <select id="upload_id" class="form-control js-example-basic-single" name="state_id">
					                  <option value="none" selected disabled hidden> 
					                    {{ __('Select an Option') }}
					                  </option>
					                  @foreach ($states as $s)
					                    <option value="{{ $s->id}}" {{ $orders->state_id==$s->id ? 'selected' : '' }}>{{ $s->name}}</option>
					                  @endforeach 

					                </select>
	                        	</div>
	                        </div>
	                        <div class="col-lg-4">
	                        	<div class="form-group">
	                        		<label for="city_id">{{ __('City') }}:</label>
					                <select id="grand" class="form-control js-example-basic-single" name="city_id">
					                  <option value="none" selected disabled hidden> 
					                    {{ __('SelectanOption') }}
					                  </option>
					                   @foreach ($cities as $c)
					                    <option value="{{ $c->id }}" {{ $orders->city_id ==$c->id ? 'selected' : ''}}>{{ $c->name }}
					                    </option>
					                  @endforeach 
					                </select>
	                        	</div>
	                        </div>
	                    </div>
	                    <div class="form-group">
	                        <label for="bio">{{ __('Author Bio') }}</label>
	                        <textarea id="detail" name="detail" class="form-control" placeholder="{{ __('Enter your details') }}" value="">{{ $orders->detail }}</textarea>
	                    </div>
	                    <br>

	                    <div class="row">
		                    <div class="col-lg-12">
		                      <div class="update-password">
		                        <label for="box1">{{ __('Update Password') }}:</label>
		                        <input type="checkbox" name="update_pass" id="myCheck" onclick="myFunction()">
		                      </div>
		                    </div>
		                </div>
		                <div class="password display-none" id="update-password">
			                <div class="row">
				                <div class="col-lg-6">
					                <div class="form-group position-relative">
						                <label for="confirmpassword">{{ __('Password') }}:</label>
										  <input name="password" class="form-control" id="password" type="password" placeholder="{{ __('Enter Password') }}" onkeyup='check();' />
										  <span toggle="#password-field" class="fa fa-fw fa-eye field_icon toggle-password"></span>
										</label>
									</div>
								</div>
								<div class="col-lg-6">
									<div class="form-group position-relative">
										<label>{{ __('Confirm Password') }}:</label>
										  <input type="password" name="confirm_password" id="confirm_password" class="form-control" placeholder="{{ __('Confirm Password') }}" onkeyup='check();' /> 
										  <span id='message'></span>
										  <span toggle="#password-field" class="fa fa-fw fa-eye field_icon toggle-password1"></span>
										</label>
									</div>
								</div>
							</div>
		            	</div>
		                <br>
	                </div>
	                <div class="social-profile-block">
	                    <div class="social-profile-heading">{{ __('Social Profile') }}</div>
	                    <div class="row">
	                        <div class="col-lg-6">
	                            <div class="social-block">
	                                <div class="form-group">
	                                    <label for="facebook">{{ __('Facebook Url') }}</label><br>
	                                    <div class="row">
	                                        <div class="col-lg-2 col-2">
	                                            <div class="profile-update-icon">
	                                                <div class="product-update-social-icons"><a href="{{ $orders->fb_url }}" target="_blank" title="facebook"><i class="fa fa-facebook facebook"></i></a>
	                                                </div>
	                                            </div>
	                                        </div>
	                                        <div class="col-lg-10 col-10">
	                                            <input type="text" name="fb_url" value="{{ $orders->fb_url }}" id="facebook" class="form-control" placeholder="{{ __('Facebook.com')}}" />
	                                        </div>
	                                    </div>    
	                                </div>
	                            </div>
	                            <div class="social-block">
	                                <div class="form-group">
	                                    <label for="behance2">{{ __('Youtube Url') }}</label><br>
	                                    <div class="row">
	                                        <div class="col-lg-2 col-2">
	                                            <div class="profile-update-icon">
	                                                <div class="product-update-social-icons">
														<a href="{{ $orders->youtube_url }}" target="_blank" title="googleplus"><i class="fa fa-youtube youtube"></i></a>
	                                                </div>
	                                            </div>
	                                        </div>
	                                        <div class="col-lg-10 col-10">
	                                            <input type="text" name="youtube_url" value="{{ $orders->youtube_url }}" id="behance2" class="form-control" placeholder="{{ __('youtube.com')}}" />
	                                        </div>
	                                    </div>    
	                                </div>
	                            </div>
	                        </div>
	                        <div class="col-lg-6">
	                            <div class="social-block">
	                                <div class="form-group">
	                                    <label for="twitter">{{ __('Twitter Url') }}</label><br>
	                                    <div class="row">
	                                        <div class="col-lg-2 col-2">
	                                            <div class="profile-update-icon">
	                                                <div class="product-update-social-icons"><a href="{{ $orders->twitter_url }}" target="_blank" title="twitter"><i class="fa fa-twitter twitter"></i></a>
	                                                </div>
	                                            </div>
	                                        </div>
	                                        <div class="col-lg-10 col-10">
	                                            <input type="text" name="twitter_url" value="{{ $orders->twitter_url }}" id="twitter" class="form-control" placeholder="{{ __('Twitter.com')}}" />
	                                        </div>
	                                    </div>    
	                                </div>
	                            </div>
	                            <div class="social-block">
	                                <div class="form-group">
	                                    <label for="dribbble2">{{ __('Linked In Url') }}</label><br>
	                                    <div class="row">
	                                        <div class="col-lg-2 col-2">
	                                            <div class="profile-update-icon">
	                                                <div class="product-update-social-icons"><a href="{{ $orders->linkedin_url }}" target="_blank" title="linkedin"><i class="fa fa-linkedin-in linkedin"></i></a>
	                                                </div>
	                                            </div>
	                                        </div>
	                                        <div class="col-lg-10 col-10">
	                                            <input type="text" name="linkedin_url" value="{{ $orders->linkedin_url }}" id="dribbble2" class="form-control" placeholder="Linkedin.com/">
	                                        </div>
	                                    </div>    
	                                </div>
	                            </div>
	                        </div>
	                    </div>
	                </div>

	                <div class="upload-items text-right">
	                    <button type="submit" class="btn btn-primary" title="upload items">{{ __('Update Profile') }}</button>
	                </div>
	                
	            </div>
	        </div>

        </form>
    </div>
</section>
<!-- profile update end -->
@endsection

@section('custom-script')

<script>
$('.select2').select2();
(function($) {
  "use strict";
  $(function() {
    var urlLike = '{{ url('country/dropdown') }}';
    $('#country_id').change(function() {
      var up = $('#upload_id').empty();
      var cat_id = $(this).val();    
      if(cat_id){
        $.ajax({
          headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          type:"GET",
          url: urlLike,
          data: {catId: cat_id},
          success:function(data){   
            console.log(data);
            up.append('<option value="0">Please Choose</option>');
            $.each(data, function(id, title) {
              up.append($('<option>', {value:id, text:title}));
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
(function($) {
  "use strict";
  $(function() {
    var urlLike = '{{ url('country/gcity') }}';
    $('#upload_id').change(function() {
      var up = $('#grand').empty();
      var cat_id = $(this).val();    
      if(cat_id){
        $.ajax({
          headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          type:"GET",
          url: urlLike,
          data: {catId: cat_id},
          success:function(data){   
            console.log(data);
            up.append('<option value="0">Please Choose</option>');
            $.each(data, function(id, title) {
              up.append($('<option>', {value:id, text:title}));
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
(function($) {
  "use strict";
	function readURL(input) {
	if (input.files && input.files[0]) {
	    var reader = new FileReader();
	    reader.onload = function(e) {
	    	$('#imagePreview').attr('src','');
	        $('#imagePreview').css('background-image', 'url('+e.target.result +')');
	        $('#imagePreview').hide();
	        $('#imagePreview').fadeIn(650);
	    }
	    reader.readAsDataURL(input.files[0]);
		}
	}
	$("#imageUpload").change(function() {
	    readURL(this);
	});
})(jQuery);
</script>

<script>
  function myFunction() {
    var checkBox = document.getElementById("myCheck");
    var text = document.getElementById("update-password");
    if (checkBox.checked == true){
      text.style.display = "block";
    } else {
       text.style.display = "none";
    }
  }
</script>

<script>
(function($) {
  "use strict";
	$('#password, #confirm_password').on('keyup', function () {
	  if ($('#password').val() == $('#confirm_password').val()) {
	    $('#message').html('Password Match').css('color', 'green');
	  } else 
	    $('#message').html('Password Do Not Match').css('color', 'red');
	});
})(jQuery);

</script>

<script>
(function($) {
  "use strict";
	tinymce.init({selector:'textarea#detail'});
})(jQuery);
</script>
<script type="text/javascript">
    $(document).on('click', '.toggle-password', function() {
        var input = $("#password");
        input.attr('type') === 'password' ? input.attr('type','text') : input.attr('type','password');
        $(".toggle-password").toggleClass("fa-eye fa-eye-slash");
    });
    $(document).on('click', '.toggle-password1', function() {
        var input = $("#confirm_password");
        input.attr('type') === 'password' ? input.attr('type','text') : input.attr('type','password');
        $(".toggle-password1").toggleClass("fa-eye fa-eye-slash");
    });
</script>

@endsection
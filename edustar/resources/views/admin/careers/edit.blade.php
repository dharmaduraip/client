@extends('admin.layouts.master')
@section('title', 'Career - Admin')
@section('stylesheet')
	<style>	
		.dblock{
			display: block;
		}
	</style>
@endsection
@section('maincontent')
@component('components.breadcumb',['fourthactive' => 'active'])
@slot('heading')
{{ __('Career - Admin') }}
@endslot
@slot('menu1')
{{ __('Career - Admin') }}
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

		<!-- row started -->
		<div class="col-lg-12">

			<div class="card m-b-30">

				<!-- Card header will display you the heading -->
				<div class="card-header">
					<h5 class="card-box">{{ __('Career') }}</h5>
				</div>

				<!-- card body started -->
				<div class="card-body">
					<!-- form for comming soon start -->
					<form action="{{ action('CareersController@update') }}" method="POST" enctype="multipart/form-data">
						{{ csrf_field() }}
						{{ method_field('PUT') }}

						<!-- section 1 start -->
						<div class="row">
							<div class="col-md-12">
								<label class="text-dark dblock" for="one_enable">{{ __('Section One') }}</label>
								<input type="checkbox" class="custom_toggle" id="customSwitch1" name="one_enable" {{ $careers['one_enable']==1 ? 'checked' : '' }} />
								<input type="hidden" name="free" value="0" for="status" id="customSwitch1">
								<div class="row mt-3" style="{{ $careers['one_enable']==1 ? '' : 'display:none' }}" id="section_one">
									<div class="col-md-6">
										<label class="text-dark" for="one_heading">{{ __('Section One Heading :') }} <span class="text-danger">*</span></label>
										<input value="{{ $careers['one_heading'] }}" name="one_heading" type="text" class="form-control" placeholder="Enter Heading" required />
									</div>

									<div class="col-md-6">
										<label class="text-dark" for="one_text">{{ __('Section One Text :') }} <span class="text-danger">*</span></label>
										<textarea name="one_text" rows="1" class="form-control" placeholder="Enter Text" required >{{ $careers['one_text'] }}</textarea>
										<br>
									</div>

									<div class="col-md-6">
										<label class="text-dark" for="one_btntxt">{{ __('Section One button Text :') }} <span class="text-danger">*</span></label>
										<input value="{{ $careers['one_btntxt'] }}" name="one_btntxt" type="text" class="form-control" placeholder="Enter Button Text" required />
									</div>

									<div class="col-md-6">
										<label class="text-dark" for="one_btntxt">{{ __('Section One button Link :') }} <span class="text-danger">*</span></label>
										<input value="{{ $careers['three_btntxt'] }}" name="three_btntxt" type="text" class="form-control" placeholder="Enter Button Link" required />
									</div>

									<div class="col-md-6">

										<label class="text-dark dblock">{{ __('Section One Image :') }}<span class="text-danger">*</span></label>
										<div class="input-group mb-3">
											<div class="input-group-prepend">
												<span class="input-group-text" id="inputGroupFileAddon01">{{ __('Upload') }}</span>
											</div>
											<div class="custom-file">
												<input type="file" class="custom-file-input" id="inputGroupFile01" name="one_video" aria-describedby="inputGroupFileAddon01" accept=".png,.jpg,.jpeg" @if(!file_exists(public_path().'/images/careers/'.$careers['one_video']) || $careers['one_video'] == NULL)  required  @endif>
												<label class="custom-file-label" for="inputGroupFile01">{{ __('Choose file') }}</label>
											</div>
										</div>
										@if(file_exists(public_path().'/images/careers/'.$careers['one_video']) && $careers['one_video'] != NULL)
										<img src="{{ url('/images/careers/'.$careers['one_video']) }}" class="image_size" />
										@endif
									</div>
								</div>
							</div>
						</div>
						<!-- section 1 end -->

						<!-- section 2 start -->
						<div class="row mt-3">
							<div class="col-md-12">
								<label class="text-dark dblock" name="two_enable" for="two_enable">{{ __('Section Two') }} <small class="text-info"><i class="fa fa-question-circle"></i> {{ __('if enable section two, it will show the testimonial content.') }} </small></label>
								<input type="checkbox" class="custom_toggle" id="customSwitch2" name="two_enable" {{ $careers['two_enable']==1 ? 'checked' : '' }} />
								<input type="hidden" name="free" value="0" for="customSwitch2" id="customSwitch2">

								{{-- <div class="row mt-3" style="{{ $careers['two_enable']==1 ? '' : 'display:none' }}" id="section_two">

									<div class="col-md-6">

										<label class="text-dark">{{ __('Section Two Background Image :') }}<span class="text-danger">*</span></label><br>
										<div class="input-group mb-3">
											<div class="input-group-prepend">
												<span class="input-group-text" id="inputGroupFileAddon01">{{ __('Upload') }}</span>
											</div>
											<div class="custom-file">
												<input type="file" class="custom-file-input" id="inputGroupFile01" name="two_bg_image" aria-describedby="inputGroupFileAddon01">
												<label class="custom-file-label" for="inputGroupFile01">{{ __('Choose file') }}</label>
											</div>
										</div>
										@if($image = @file_get_contents('../public/images/careers/'.$careers['two_bg_image']))
										<img src="{{ url('/images/careers/'.$careers['two_bg_image']) }}" class="image_size" />
										@endif

									</div>

									<div class="col-md-6">

										<label class="text-dark">{{ __('Section Two Image :') }}<span class="text-danger">*</span></label><br>
										<div class="input-group mb-3">
											<div class="input-group-prepend">
												<span class="input-group-text" id="inputGroupFileAddon01">{{ __('Upload') }}</span>
											</div>
											<div class="custom-file">
												<input type="file" class="custom-file-input" id="inputGroupFile01" name="two_video" aria-describedby="inputGroupFileAddon01">
												<label class="custom-file-label" for="inputGroupFile01">{{ __('Choose file') }}</label>
											</div>
										</div>
										@if($image = @file_get_contents('../public/images/careers/'.$careers['two_video']))
										<img src="{{ url('/images/careers/'.$careers['two_video']) }}" class="image_size" />
										@endif
										<br>
										<br>
									</div>

									<div class="col-md-6">
										<label class="text-dark" for="two_heading">{{ __('Section Two Heading :') }}<span class="text-danger">*</span></label>
										<input value="{{ $careers['two_heading'] }}" name="two_heading" type="text" class="form-control" placeholder="Enter Heading" />
									</div>


								</div> --}}
							</div>
						</div>
						<!-- section 2 end -->

						<!-- section 3 start -->
						<div class="row mt-3">
							<div class="col-md-12">
								<label class="text-dark dblock" for="three_enable">{{ __('Section Three') }}</label>
								<input type="checkbox" class="custom_toggle" id="customSwitch3" name="three_enable" {{ $careers['three_enable']==1 ? 'checked' : '' }} />
								<input type="hidden" name="free" value="0" for="customSwitch3" id="customSwitch3">

								<div class="row mt-3" style="{{ $careers['three_enable']==1 ? '' : 'display:none' }}" id="section_three">

									<div class="col-md-6">

										<label class="text-dark">{{ __('Section Three Background Image :') }}<span class="text-danger">*</span></label><br>
										<div class="input-group mb-3">
											<div class="input-group-prepend">
												<span class="input-group-text" id="inputGroupFileAddon01">{{ __('Upload') }}</span>
											</div>
											<div class="custom-file">
												<input type="file" class="custom-file-input" id="inputGroupFile01" name="three_bg_image" aria-describedby="inputGroupFileAddon01" @if(!file_exists(public_path().'/images/careers/'.$careers['three_bg_image']) || $careers['three_bg_image'] == NULL)  required  @endif accept=".jpg,.jpeg,.png" >
												<label class="custom-file-label" for="inputGroupFile01">{{ __('Choose file') }}</label>
											</div>
										</div>
										@if(file_exists(public_path().'/images/careers/'.$careers['three_bg_image']) && $careers['three_bg_image'] != NULL)
										<img src="{{ url('/images/careers/'.$careers['three_bg_image']) }}" class="image_size" />
										@endif

									</div>

									<div class="col-md-6">

										<label class="text-dark">{{ __('Section Three Image :') }}<span class="text-danger">*</span></label><br>
										<div class="input-group mb-3">
											<div class="input-group-prepend">
												<span class="input-group-text" id="inputGroupFileAddon01">{{ __('Upload') }}</span>
											</div>
											<div class="custom-file">
												<input type="file" class="custom-file-input" id="inputGroupFile01" name="three_video" aria-describedby="inputGroupFileAddon01" @if(!file_exists(public_path().'/images/careers/'.$careers['three_video']) || $careers['three_video'] == NULL ) required  @endif accept=".jpg,.jpeg,.png">
												<label class="custom-file-label" for="inputGroupFile01">{{ __('Choose file') }}</label>
											</div>
										</div>
										@if(file_exists(public_path().'/images/careers/'.$careers['three_video']) && $careers['three_video'] != NULL )
										<img src="{{ url('/images/careers/'.$careers['three_video']) }}" class="image_size" />
										@endif
										<br>
										<br>
									</div>

									<div class="col-md-6">
										<label class="text-dark" for="three_heading">{{ __('Section Three Heading :') }}<span class="text-danger">*</span></label>
										<input value="{{ $careers['three_heading'] }}" name="three_heading" type="text" class="form-control" placeholder="Enter Heading" required />
									</div>


								</div>
							</div>
						</div>
						<!-- section 3 end -->
						<!-- section 4 start -->
						<div class="row mt-3">
							<div class="col-md-12">
								<label class="text-dark dblock" for="four_enable">{{ __('Section Four') }} <small class="text-info"><i class="fa fa-question-circle"></i> {{ __('gallery section') }} </small></label>
								<input type="checkbox" class="custom_toggle" id="customSwitch4" name="four_enable" {{ $careers['four_enable']==1 ? 'checked' : '' }} />
								<input type="hidden" name="free" value="0" for="customSwitch4" id="customSwitch4">

								<div class="row mt-3" style="{{ $careers['four_enable']==1 ? '' : 'display:none' }}" id="section_four">

									<div class="col-md-4">
										<label class="text-dark">{{ __('Section Four Image One :') }}<span class="text-danger">*</span></label><br>
										<div class="input-group mb-3">
											<div class="input-group-prepend">
												<span class="input-group-text" id="inputGroupFileAddon01">{{ __('Upload') }}</span>
											</div>
											<div class="custom-file">
												<input type="file" class="custom-file-input" id="inputGroupFile01" name="four_img_one" aria-describedby="inputGroupFileAddon01" accept=".jpg,.jpeg,.png" @if(!file_exists(public_path().'/images/careers/'.$careers['four_img_one']) || $careers['four_img_one'] == NULL  ) required  @endif>
												<label class="custom-file-label" for="inputGroupFile01">{{ __('Choose file') }}</label>
											</div>
										</div>
										@if(file_exists(public_path().'/images/careers/'.$careers['four_img_one']) && $careers['four_img_one'] != NULL)
										<img src="{{ url('/images/careers/'.$careers['four_img_one']) }}" class="image_size" />
										@endif
									</div>

									<div class="col-md-4">

										<label class="text-dark">{{ __('Section Four Image Two :') }}<span class="text-danger">*</span></label><br>
										<div class="input-group mb-3">
											<div class="input-group-prepend">
												<span class="input-group-text" id="inputGroupFileAddon01">{{ __('Upload') }}</span>
											</div>
											<div class="custom-file">
												<input type="file" class="custom-file-input" id="inputGroupFile01" name="four_img_two" aria-describedby="inputGroupFileAddon01" accept=".jpg,.jpeg,.png" @if(!file_exists(public_path().'/images/careers/'.$careers['four_img_two']) || $careers['four_img_two'] == NULL ) required  @endif>
												<label class="custom-file-label" for="inputGroupFile01">{{ __('Choose file') }}</label>
											</div>
										</div>
										@if(file_exists(public_path().'/images/careers/'.$careers['four_img_two']) && $careers['four_img_two'] != NULL)
										<img src="{{ url('/images/careers/'.$careers['four_img_two']) }}" class="image_size" />
										@endif

									</div>

									<div class="col-md-4">

										<label class="text-dark">{{ __('Section Four Image Three :') }}<span class="text-danger">*</span></label><br>
										<div class="input-group mb-3">
											<div class="input-group-prepend">
												<span class="input-group-text" id="inputGroupFileAddon01">{{ __('Upload') }}</span>
											</div>
											<div class="custom-file">
												<input type="file" class="custom-file-input" id="inputGroupFile01" name="four_img_three" aria-describedby="inputGroupFileAddon01" accept=".jpg,.jpeg,.png" @if(!file_exists(public_path().'/images/careers/'.$careers['four_img_three']) || $careers['four_img_three'] == NULL ) required  @endif >
												<label class="custom-file-label" for="inputGroupFile01">{{ __('Choose file') }}</label>
											</div>
										</div>
										@if(file_exists(public_path().'/images/careers/'.$careers['four_img_three']) && $careers['four_img_three'] != NULL)
										<img src="{{ url('/images/careers/'.$careers['four_img_three']) }}" class="image_size" />
										@endif

										<br>
										<br>
									</div>

									<div class="col-md-4">

										<label class="text-dark">{{ __('Section Four Image Four :') }}<span class="text-danger">*</span></label><br>
										<div class="input-group mb-3">
											<div class="input-group-prepend">
												<span class="input-group-text" id="inputGroupFileAddon01">{{ __('Upload') }}</span>
											</div>
											<div class="custom-file">
												<input type="file" class="custom-file-input" id="inputGroupFile01" name="four_img_four" aria-describedby="inputGroupFileAddon01" accept=".jpg,.jpeg,.png" @if(!file_exists(public_path().'/images/careers/'.$careers['four_img_four']) || $careers['four_img_four'] == NULL ) required  @endif>
												<label class="custom-file-label" for="inputGroupFile01">{{ __('Choose file') }}</label>
											</div>
										</div>
										@if(file_exists(public_path().'/images/careers/'.$careers['four_img_four']) && $careers['four_img_four'] != NULL)
										<img src="{{ url('/images/careers/'.$careers['four_img_four']) }}" class="image_size" />
										@endif

									</div>

									<div class="col-md-4">
										<label class="text-dark">{{ __('Section Four Image Five :') }}<span class="text-danger">*</span></label><br>
										<div class="input-group mb-3">
											<div class="input-group-prepend">
												<span class="input-group-text" id="inputGroupFileAddon01">{{ __('Upload') }}</span>
											</div>
											<div class="custom-file">
												<input type="file" class="custom-file-input" id="inputGroupFile01" name="four_img_five" aria-describedby="inputGroupFileAddon01" accept=".jpg,.jpeg,.png" @if(!file_exists(public_path().'/images/careers/'.$careers['four_img_five'])|| $careers['four_img_five'] == NULL ) required  @endif>
												<label class="custom-file-label" for="inputGroupFile01">{{ __('Choose file') }}</label>
											</div>
										</div>
										@if(file_exists(public_path().'/images/careers/'.$careers['four_img_five']) && $careers['four_img_five'] != NULL)
										<img src="{{ url('/images/careers/'.$careers['four_img_five']) }}" class="image_size" />
										@endif
									</div>

									<div class="col-md-4">

										<label class="text-dark">{{ __('Section Four Image Six :') }}<span class="text-danger">*</span></label><br>
										<div class="input-group mb-3">
											<div class="input-group-prepend">
												<span class="input-group-text" id="inputGroupFileAddon01">{{ __('Upload') }}</span>
											</div>
											<div class="custom-file">
												<input type="file" class="custom-file-input" id="inputGroupFile01" name="four_img_six" aria-describedby="inputGroupFileAddon01" accept=".jpg,.jpeg,.png" @if(!file_exists(public_path().'/images/careers/'.$careers['four_img_six']) || $careers['four_img_six'] == NULL ) required  @endif>
												<label class="custom-file-label" for="inputGroupFile01">{{ __('Choose file') }}</label>
											</div>
										</div>
										@if(file_exists(public_path().'/images/careers/'.$careers['four_img_six']) && $careers['four_img_six'] != NULL)
										<img src="{{ url('/images/careers/'.$careers['four_img_six']) }}" class="image_size" />
										@endif
										<br>
										<br>
									</div>

									<div class="col-md-4">

										<label class="text-dark">{{ __('Section Four Image Seven :') }}<span class="text-danger">*</span></label><br>
										<div class="input-group mb-3">
											<div class="input-group-prepend">
												<span class="input-group-text" id="inputGroupFileAddon01">{{ __('Upload') }}</span>
											</div>
											<div class="custom-file">
												<input type="file" class="custom-file-input" id="inputGroupFile01" name="four_img_seven" aria-describedby="inputGroupFileAddon01" accept=".jpg,.jpeg,.png" @if(!file_exists(public_path().'/images/careers/'.$careers['four_img_seven']) || $careers['four_img_seven'] == NULL ) required  @endif>
												<label class="custom-file-label" for="inputGroupFile01">{{ __('Choose file') }}</label>
											</div>
										</div>
										@if(file_exists(public_path().'/images/careers/'.$careers['four_img_seven']) && $careers['four_img_seven'] != NULL)
										<img src="{{ url('/images/careers/'.$careers['four_img_seven']) }}" class="image_size" />
										@endif
									</div>

									<div class="col-md-4">

										<label class="text-dark">{{ __('Section Four Image Eight :') }}<span class="text-danger">*</span></label><br>
										<div class="input-group mb-3">
											<div class="input-group-prepend">
												<span class="input-group-text" id="inputGroupFileAddon01">{{ __('Upload') }}</span>
											</div>
											<div class="custom-file">
												<input type="file" class="custom-file-input" id="inputGroupFile01" name="four_img_eight" aria-describedby="inputGroupFileAddon01" accept=".jpg,.jpeg,.png" @if(!file_exists(public_path().'/images/careers/'.$careers['four_img_eight']) || $careers['four_img_eight'] == NULL ) required  @endif>
												<label class="custom-file-label" for="inputGroupFile01">{{ __('Choose file') }}</label>
											</div>
										</div>
										@if(file_exists(public_path().'/images/careers/'.$careers['four_img_eight']) && $careers['four_img_eight'] != NULL)
										<img src="{{ url('/images/careers/'.$careers['four_img_eight']) }}" class="image_size" />
										@endif
									</div>

									<div class="col-md-4">
										<label class="text-dark">{{ __('Section Four Image Nine :') }}<span class="text-danger">*</span></label><br>
										<div class="input-group mb-3">
											<div class="input-group-prepend">
												<span class="input-group-text" id="inputGroupFileAddon01">{{ __('Upload') }}</span>
											</div>
											<div class="custom-file">
												<input type="file" class="custom-file-input" id="inputGroupFile01" name="four_img_nine" aria-describedby="inputGroupFileAddon01" accept=".jpg,.jpeg,.png" @if(!file_exists(public_path().'/images/careers/'.$careers['four_img_nine']) || $careers['four_img_nine'] == NULL ) required  @endif>
												<label class="custom-file-label" for="inputGroupFile01">{{ __('Choose file') }}</label>
											</div>
										</div>
										@if(file_exists(public_path().'/images/careers/'.$careers['four_img_nine']) && $careers['four_img_nine'] != NULL)
										<img src="{{ url('/images/careers/'.$careers['four_img_nine']) }}" class="image_size" />
										@endif
									</div>
									<div class="col-md-4 mt-3">
										<label class="text-dark">{{ __('Section Four Image Ten :') }}<span class="text-danger">*</span></label><br>
										<div class="input-group mb-3">
											<div class="input-group-prepend">
												<span class="input-group-text" id="inputGroupFileAddon01">{{ __('Upload') }}</span>
											</div>
											<div class="custom-file">
												<input type="file" class="custom-file-input" id="inputGroupFile01" name="four_img_ten" aria-describedby="inputGroupFileAddon01" accept=".jpg,.jpeg,.png" @if(!file_exists(public_path().'/images/careers/'.$careers['four_img_ten']) || $careers['four_img_ten'] == NULL ) required  @endif>
												<label class="custom-file-label" for="inputGroupFile01">{{ __('Choose file') }}</label>
											</div>
										</div>
										@if(file_exists(public_path().'/images/careers/'.$careers['four_img_ten']) && $careers['four_img_ten'] != NULL)
										<img src="{{ url('/images/careers/'.$careers['four_img_ten']) }}" class="image_size" />
										@endif
									</div>
								</div>
							</div>
						</div>
						<!-- section 4 end -->
						<!-- section 5 start -->
						<div class="row mt-3">
							<div class="col-md-12">
								<label class="text-dark dblock" for="four_enable">{{ __('Section Five') }}</label>
								<input type="checkbox" class="custom_toggle" id="customSwitch5" name="five_enable" {{ $careers['five_enable']==1 ? 'checked' : '' }} />
								<input type="hidden" name="free" value="0" for="customSwitch5" id="customSwitch5">

								<div class="row mt-3" style="{{ $careers['five_enable']==1 ? '' : 'display:none' }}" id="section_five">
									<div class="col-md-6">
										<label class="text-dark" for="five_heading">{{ __('Section Five Heading : ') }}<span class="text-danger">*</span></label>
										<input value="{{ $careers['five_heading'] }}" name="five_heading" type="text" class="form-control" placeholder="Enter Heading" required/>
									</div>

									<div class="col-md-6">
										<label class="text-dark" for="five_text">{{ __('Section Five Text :') }} <span class="text-danger">*</span></label>
										<input value="{{ $careers['five_text'] }}" name="five_text" type="text" class="form-control" placeholder="Enter Text" required/>
									</div>

									<div class="col-md-4 display-none">
										<label class="text-dark" for="five_icon">{{ __('Section Five Icon :') }}<span class="text-danger">*</span></label>
										<input value="{{ $careers['five_icon'] }}" name="five_icon" type="text" class="form-control" placeholder="Enter Icon" />
										<br>
									</div>

									<div class="col-md-6">
										<label class="text-dark" for="five_textone">{{ __('Section Five Topic One :') }}<span class="text-danger">*</span></label>
										<input value="{{ $careers['five_textone'] }}" name="five_textone" type="text" class="form-control" placeholder="Enter Topic" required/>
										<br>

										<label class="text-dark" for="five_texttwo">{{ __('Section Five Topic Two : ') }}</label>
										<input value="{{ $careers['five_texttwo'] }}" name="five_texttwo" type="text" class="form-control" placeholder="Enter Topic" />
										<br>

										<label class="text-dark" for="five_textthree">{{ __('Section Five Topic Three :') }}</label>
										<input value="{{ $careers['five_textthree'] }}" name="five_textthree" type="text" class="form-control" placeholder="Enter Topic" />
										<br>

										<label class="text-dark" for="five_textfour">{{ __('Section Five Topic Four :') }}</label>
										<input value="{{ $careers['five_textfour'] }}" name="five_textfour" type="text" class="form-control" placeholder="Enter Topic" />
										<br>

										<label class="text-dark" for="five_textfive">{{ __('Section Five Topic Five :') }}</label>
										<input value="{{ $careers['five_textfive'] }}" name="five_textfive" type="text" class="form-control" placeholder="Enter Topic" />
										<br>

										<label class="text-dark" for="five_textsix">{{ __('Section Five Topic Six :') }}</label>
										<input value="{{ $careers['five_textsix'] }}" name="five_textsix" type="text" class="form-control" placeholder="Enter Topic" />
										<br>

										<label class="text-dark" for="five_textseven">{{ __('Section Five Topic Seven :') }}</label>
										<input value="{{ $careers['five_textseven'] }}" name="five_textseven" type="text" class="form-control" placeholder="Enter Topic" />
										<br>

										<label class="text-dark" for="five_texteight">{{ __('Section Five Topic Eight :') }}</label>
										<input value="{{ $careers['five_texteight'] }}" name="five_texteight" type="text" class="form-control" placeholder="Enter Topic" />
										<br>

										<label class="text-dark" for="five_textnine">{{ __('Section Five Topic Nine :') }}</label>
										<input value="{{ $careers['five_textnine'] }}" name="five_textnine" type="text" class="form-control" placeholder="Enter Topic" />
										<br>

										<label class="text-dark" for="five_textten">{{ __('Section Five Topic Ten :') }}</label>
										<input value="{{ $careers['five_textten'] }}" name="five_textten" type="text" class="form-control" placeholder="Enter Topic" />
										<br>
									</div>

									<div class="col-md-6">
										<label class="text-dark" for="five_dtlone">{{ __('Section Five Detail One :') }}<span class="text-danger">*</span></label>
										<textarea name="five_dtlone" rows="1" class="form-control" placeholder="Enter Deatil" required>{{ $careers['five_dtlone'] }}</textarea>
										<br>

										<label class="text-dark" for="five_dtltwo">{{ __('Section Five Detail two :') }}</label>
										<textarea name="five_dtltwo" rows="1" class="form-control" placeholder="Enter Deatil">{{ $careers['five_dtltwo'] }}</textarea>
										<br>


										<label class="text-dark" for="five_dtlthree">{{ __('Section Five Detail three :') }}</label>
										<textarea name="five_dtlthree" rows="1" class="form-control" placeholder="Enter Deatil">{{ $careers['five_dtlthree'] }}</textarea>
										<br>

										<label class="text-dark" for="five_dtlfour">{{ __('Section Five Detail four :') }} </label>
										<textarea name="five_dtlfour" rows="1" class="form-control" placeholder="Enter Deatil">{{ $careers['five_dtlfour'] }}</textarea>
										<br>

										<label class="text-dark" for="five_dtlfive">{{ __('Section Five Detail five :') }} </label>
										<textarea name="five_dtlfive" rows="1" class="form-control" placeholder="Enter Deatil">{{ $careers['five_dtlfive'] }}</textarea>
										<br>

										<label class="text-dark" for="five_dtlsix">{{ __('Section Five Detail six :') }}</label>
										<textarea name="five_dtlsix" rows="1" class="form-control" placeholder="Enter Deatil">{{ $careers['five_dtlsix'] }}</textarea>
										<br>

										<label class="text-dark" for="five_dtlseven">{{ __('Section Five Detail seven :') }}</label>
										<textarea name="five_dtlseven" rows="1" class="form-control" placeholder="Enter Deatil">{{ $careers['five_dtlseven'] }}</textarea>
										<br>

										<label class="text-dark" for="five_dtleight">{{ __('Section Five Detail eight :') }}</label>
										<textarea name="five_dtleight" rows="1" class="form-control" placeholder="Enter Deatil">{{ $careers['five_dtleight'] }}</textarea>
										<br>

										<label class="text-dark" for="five_dtlnine">{{ __('Section Five Detail nine :') }}</label>
										<textarea name="five_dtlnine" rows="1" class="form-control" placeholder="Enter Deatil">{{ $careers['five_dtlnine'] }}</textarea>
										<br>

										<label class="text-dark" for="five_dtlten">{{ __('Section Five Detail ten :') }} </label>
										<textarea name="five_dtlten" rows="1" class="form-control" placeholder="Enter Deatil">{{ $careers['five_dtlten'] }}</textarea>
										<br>
									</div>
								</div>
							</div>
						</div>
						<!-- section 5 end -->

						<!-- section 6 start -->
						<div class="row mt-3">
							<div class="col-md-12">
								<label class="text-dark dblock" for="four_enable">{{ __('Section Six') }}</label>
								<input type="checkbox" class="custom_toggle" id="customSwitch6" name="six_enable" {{ $careers['six_enable']==1 ? 'checked' : '' }} />
								<input type="hidden" name="free" value="0" for="customSwitch6" id="customSwitch6">

								<div class="row mt-3" style="{{ $careers['six_enable']==1 ? '' : 'display:none' }}" id="section_six">
									<div class="col-md-6">
										<label class="text-dark" for="six_heading">{{ __('Section Six Heading : ') }}<span class="text-danger">*</span></label>
										<input value="{{ $careers['six_heading'] }}" name="six_heading" type="text" class="form-control" placeholder="Enter Heading" required />
									</div>

									<div class="col-md-6">
										<label class="text-dark" for="six_text">{{ __('Section Six Text :') }}<span class="text-danger">*</span></label>
										<textarea name="six_text" rows="3" class="form-control" placeholder="Enter Text" required>{{ $careers['six_text'] }}</textarea>
										<br>
									</div>

									<div class="col-md-6">
										<label class="text-dark" for="six_topic_one">{{ __('Section Six Topic One :') }}<span class="text-danger">*</span></label>
										<input value="{{ $careers['six_topic_one'] }}" name="six_topic_one" type="text" class="form-control" placeholder="Enter Title" required />
									</div>

									<div class="col-md-6">
										<label class="text-dark" for="six_topic_two">{{ __('Section Six Topic Two :') }}</label>
										<input value="{{ $careers['six_topic_two'] }}" name="six_topic_two" type="text" class="form-control" placeholder="Enter Title" />
										<br>
									</div>

									<div class="col-md-6">
										<label class="text-dark" for="six_topic_three">{{ __('Section Six Topic Three :') }}</label>
										<input value="{{ $careers['six_topic_three'] }}" name="six_topic_three" type="text" class="form-control" placeholder="Enter Title" />
									</div>

									<div class="col-md-6">
										<label class="text-dark" for="six_topic_four">{{ __('Section Six Topic Four :') }}</label>
										<input value="{{ $careers['six_topic_four'] }}" name="six_topic_four" type="text" class="form-control" placeholder="Enter Title" />
										<br>
									</div>

									<div class="col-md-6">
										<label class="text-dark" for="six_topic_five">{{ __('Section Six Topic Five :') }}</label>
										<input value="{{ $careers['six_topic_five'] }}" name="six_topic_five" type="text" class="form-control" placeholder="Enter Title" />
									</div>

									<div class="col-md-6">
										<label class="text-dark" for="six_topic_six">{{ __('Section Six Topic Six :') }}</label>
										<input value="{{ $careers['six_topic_six'] }}" name="six_topic_six" type="text" class="form-control" placeholder="Enter Title" />
										<br>
									</div>
								</div>
							</div>
						</div>
						<!-- section 6 end -->

						<div class="form-group">
							<a href="javascript:window.location.reload(true)" class="btn btn-danger-rgba mr-1"><i class="fa fa-ban"></i> {{ __("Reset")}}</a>
							<button type="submit" class="btn btn-primary-rgba"><i class="fa fa-check-circle"></i>
								{{ __("Update")}}</button>
						</div>

					</form>
					<!-- form for comming soon end -->
				</div>
				<!-- card body end -->

			</div><!-- col end -->
		</div>
	</div>
</div><!-- row end -->
<br><br>
@endsection
<!-- main content section ended -->
<!-- This section will contain javacsript start -->
@section('script')
<script>
	(function($) {
		"use strict";

		$(document).ready(function() {

			$('#customSwitch1').change(function() {
				if ($('#customSwitch1').is(':checked')) {
					$('#section_one').show('fast');
				} else {
					$('#section_one').hide('fast');
				}

			});

			$('#customSwitch2').change(function() {
				if ($('#customSwitch2').is(':checked')) {
					$('#section_two').show('fast');
				} else {
					$('#section_two').hide('fast');
				}

			});

			$('#customSwitch3').change(function() {
				if ($('#customSwitch3').is(':checked')) {
					$('#section_three').show('fast');
				} else {
					$('#section_three').hide('fast');
				}

			});

			$('#customSwitch4').change(function() {
				if ($('#customSwitch4').is(':checked')) {
					$('#section_four').show('fast');
				} else {
					$('#section_four').hide('fast');
				}

			});

			$('#customSwitch5').change(function() {
				if ($('#customSwitch5').is(':checked')) {
					$('#section_five').show('fast');
				} else {
					$('#section_five').hide('fast');
				}

			});

			$('#customSwitch6').change(function() {
				if ($('#customSwitch6').is(':checked')) {
					$('#section_six').show('fast');
				} else {
					$('#section_six').hide('fast');
				}

			});
		});
	})(jQuery);
</script>
<style>
	.image_size {
		height: 80px;
		width: 200px;
	}
</style>
@endsection
<!-- This section will contain javacsript end -->
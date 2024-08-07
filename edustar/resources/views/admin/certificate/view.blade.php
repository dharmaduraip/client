@extends('admin.layouts.master')
@section('title', 'Certificate Verification - Admin')
@section('maincontent')


@component('components.breadcumb',['thirdactive' => 'active'])
@slot('heading')
{{ __('Certificate Verification') }}
@endslot
@slot('menu1')
{{ __('Certificate Verification') }}
@endslot

@endcomponent
<div class="contentbar">
	<div class="row">
		<div class="col-lg-12">
			@if (session()->has('fail'))
			<div class="alert alert-danger" role="alert">
				<p>{{ session()->get('fail') }}<button type="button" class="close" data-dismiss="alert"
						aria-label="Close">
						<span aria-hidden="true">&times;</span></button></p>
			</div>
			@endif
			<div class="card m-b-30">
				<div class="card-header">
					<h5 class="card-title">{{ __('Certificate Verification') }}</h5>
				</div>
				<div class="card-body">
					<form action="{{ action('CertificateController@verification') }}" method="GET"
						enctype="multipart/form-data">

						<div class="row">
							<div class="form-group col-md-12">
								<label>{{ __('Enter Certificate Serial Number') }}:<span
										class="redstar">*</span></label>
								<div class="row">
									<div class="col-lg-6">
										<input type="text" class="form-control" id="skillifyTheme" name="title" value="{{ $posts }}" required>
									</div>
								</div>
								<div class="col-lg-12 mt-4">
									<a href="{{ route('certificate.index') }}" class="btn btn-danger-rgba mr-1"><i class="fa fa-ban"></i>
										{{ __("Reset")}}</a>
									<button type="submit" class="btn btn-primary-rgba">
										<i class="fa fa-check-circle"></i>
										{{ __("Verify")}}
									</button>
								</div>
							</div>
						</div>
					</form>
				</div>





				@if (isset($posts))

				{{-- <a href="{{ url('certificate'.'/'.$posts) }}" target="blank">
					<h4> {{$posts}} </h4>
				</a> --}}

				<div class="button-list">
					<a href="{{ url('certificate'.'/'.$posts) }}" target="blank"
						class="btn btn-success-rgba btn-lg btn-block">{{ __('View Certificate') }}</a>
				</div>

				@endif

			</div>
		</div>
	</div>
</div>
@endsection


@section('script')

<script>
	$(document).ready(function () {

		$(".reset-btn").click(function () {
			var uri = window.location.toString();

			if (uri.indexOf("?") > 0) {

				var clean_uri = uri.substring(0, uri.indexOf("?"));

				window.history.replaceState({}, document.title, clean_uri);

			}

			 location.reload();
		});
	});
</script>
<!-- script to change status end -->
@endsection
@extends('common.admin.layout.base')
{{ App::setLocale(  isset($_COOKIE['admin_language']) ? $_COOKIE['admin_language'] : 'en'  ) }}

@section('title') @lang('admin.account.change_password') @stop

@section('styles')
@parent
<link rel="stylesheet" href="{{ asset('assets/plugins/data-tables/css/dataTables.bootstrap.min.css')}}" />
<link rel="stylesheet" href="{{ asset('assets/plugins/data-tables/css/responsive.bootstrap.min.css')}}">
@stop

@section('content')

<div class="main-content-container container-fluid px-4">
	<div class="page-header row no-gutters py-4">
		<div class="col-12 col-sm-4 text-center text-sm-left mb-0">
			<span class="text-uppercase page-subtitle">@lang('admin.account.change_password')</span>
			<h3 class="page-title">@lang('admin.account.change_password')</h3>
		</div>
	</div>
	<div class="row mb-4 mt-20">
		<div class="col-md-12">
			<div class="card card-small">
				<div class="card-header border-bottom">
					<h6 class="m-0">@lang('admin.account.change_password')</h6>
				</div>
				<div class="col-md-12">
					<form class="validateForm">
						@csrf()
						@if(!empty($id))
						<input type="hidden" name="_method" value="PATCH">
						<input type="hidden" name="id" value="{{$id}}">
						@endif
						<div class="form-row">
							<div class="form-group col-md-12">
								<label for="name">@lang('admin.account.old_password')</label>
								<input class="form-control" type="password" name="old_password" id="old_password" placeholder="Old Password">
							</div>
						</div>
						<div class="form-row">
							<div class="form-group col-md-12">
								<label for="email">@lang('admin.account.password')</label>
								<input class="form-control" type="password" name="password" id="password" placeholder="New Password">
							</div>
						</div>
						<div class="form-row">
							<div class="form-group col-md-12">
								<label for="email">@lang('admin.account.password')</label>
								<input class="form-control" type="password" name="password_confirmation" id="password_confirmation" placeholder="Re-type New Password">
							</div>
						</div>
						@if(Helper::getDemomode() != 1)
						<button type="submit" class="btn btn-accent float-right">@lang('admin.account.change_password')</button>
						@endif
						<br><br><br>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
@stop
@section('scripts')
@parent
<script>
	$(document).ready(function() {
		basicFunctions();

		var id = "";

		//List the profile details
		$.ajax({
			type: "GET",
			url: getBaseUrl() + "/admin/password",
			headers: {
				Authorization: "Bearer " + getToken("admin")
			},
			success: function(data) {
				var result = data.responseData;
				$('#old_password').val(result.old_password);
				$('#password').val(result.password);
				$('#password_confirmation').val(result.password_confirmation);
			}
		});

		$('.validateForm').validate({
			errorElement: 'span', //default input error message container
			errorClass: 'help-block', // default input error message class
			focusInvalid: false, // do not focus the last invalid input
			rules: {
				old_password: {
					required: true
				},
				password: {
					required: true
				},
			},
			messages: {
				old_password: {
					required: "Old Password is required."
				},
				password: {
					required: "Password is required."
				},
			},
			highlight: function(element) {
				$(element).closest('.form-group').addClass('has-error');
			},
			success: function(label) {
				label.closest('.form-group').removeClass('has-error');
				label.remove();
			},
			submitHandler: function(form) {

				var formGroup = $(".validateForm").serialize().split("&");
				var data = new FormData();
				for (var i in formGroup) {
					var params = formGroup[i].split("=");
					data.append(params[0], decodeURIComponent(params[1]));
				}
				var url = getBaseUrl() + "/admin/password";
				var data = saveRow(url, null, data, "admin", '/admin/dashboard');



			}
		});


		$('.cancel').on('click', function() {
			$(".crud-modal").modal("hide");
		});

	});
</script>

@stop
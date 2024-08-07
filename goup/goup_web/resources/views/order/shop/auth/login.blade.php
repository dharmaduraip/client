@extends('order.shop.layout.auth')
{{ App::setLocale(   isset($_COOKIE['shop_language']) ? $_COOKIE['shop_language'] : 'en'  ) }}
@section('content')
@include('common.alert')
<section class="login">
	<div class="container">
		<div class="row">
			<div class="col-md-12 col-lg-12">
				<div class="basic_form login_form">
				<!-- <h1 id = "login_status">Login</h1> -->
				<h1 id ="login_status">Shop Login</h1>
				<div class="form_cnt"> 
                    <div class="form_bdy admin active_form">
						<form role="form" class="validateForm">
							<input type =hidden name='role'  value="">
							<input type="hidden" name="salt_key" value="{{Helper::getSaltKey()}}">
							<div class="form-group">
								<label class="control-label">Email <span>*</span></label>
								<div class="basic_tpy_sec"><input  maxlength="100" type="text" required="required" id="email" name="email" class="form-control" placeholder="Email" /></div>
							</div>

							<div class="form-group">
								<label class="control-label">Password <span>*</span></label>
								<div class="basic_tpy_sec"><input maxlength="100" type="password" required="required" id="password" name="password" class="form-control" placeholder="Password"></div>
							</div>

							<div class="login_btn">
								<button class="btn btn-primary  btn-lg  login_btn" type="submit" >Sign in</button>
							</div>
                        	
						</form>

					</div>
					<br>
					<span>Forgot your Password?<strong><a href="{{url('/shop/forgotPassword')}}" class="signup-link">Reset Here</a></strong></span>
				</div>
				
			</div>

		</div>
		</div>
	</div>
</section>
@stop

@section('scripts')
@parent

<script>
$('.form_type li').click(function()
{
	$(this).siblings().removeClass('active');
	$(this).addClass('active');
	$('.form_cnt .form_bdy').siblings().removeClass('active_form');
	var x=$(this).data('target');
	$('.'+x).addClass('active_form');
});
$("input[name=role]").val('Admin');
var default_name = '  Login';
$('.user-type').on('click',function(){
	var name = $(this).text();
	$("#login_status").empty().append(name + ' Login');
	$("input[name=role]").val(name);
});


$(document).ready(function() {

	var base_url_data = JSON.parse(decodeHTMLEntities('{{$base}}'));

	for(var i in Object.keys(base_url_data)) {
		var key = String(Object.keys(base_url_data)[i]);
		var value = String(Object.values(base_url_data)[i]);
		localStorage.setItem(key, value);
	}

	setBaseUrl('{{$base_url}}');

	var formGroup = $(".validateForm").serialize().split("&");

	var data = new FormData();

		for(var i in formGroup) {
			var params = formGroup[i].split("=");
			data.append( params[0], decodeURIComponent(params[1]) );

		}

		// data.append( 'salt_key', '{{Helper::getSaltKey()}}');
		// console.log(data); 

		$('.validateForm').validate({
		errorElement: 'span', //default input error message container
		errorClass: 'help-block', // default input error message class
		focusInvalid: false, // do not focus the last invalid input
		rules: {
            email: { required: true, email: true },
            password: { required: true },
		},

		messages: {
			email: { required: "Email is required." },
            password: { required: "Password is required." },
		},

		highlight: function(element)
		{
			$(element).closest('.form-group').addClass('has-error');
		},

		success: function(label) {
			label.closest('.form-group').removeClass('has-error');
			label.remove();
		},

		submitHandler: function(form) {

            var formGroup = $(".validateForm").serialize().split("&");

            var data = new FormData();

            for(var i in formGroup) {
                var params = formGroup[i].split("=");
                data.append( params[0], decodeURIComponent(params[1]) );
            }

            $.ajax({
				url: getBaseUrl() + "/shop/login",
				type: "post",
				data: data,
				processData: false,
				contentType: false,
				success: function(response, textStatus, jqXHR) {
					setToken("shop", response.responseData.access_token);
					setShopDetails(response.responseData.user);
					document.cookie="shop_language="+response.responseData.user.language+"; path=/";
					window.location.replace("{{ url('/shop/dashboard') }}/"+response.responseData.user.id);
				},
				error: function(jqXHR, textStatus, errorThrown) {
					alertMessage(textStatus, jqXHR.responseJSON.message, "danger"); 
				}
			});
		}
    });

});
</script>
@stop
